<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'name',
                'code',
                'barcode',
            ], 'like', '%'.$request->search.'%');
        })->with('category')->get();

        $categories = Categories::all();

        return view('admin.products', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'selling_price' => $request->selling_price,
                'stock_quantity' => $request->stock_quantity ?? $product->stock_quantity,
                'status' => $request->status ?? $product->status,
                'cost_price' => $request->cost_price ?? $product->cost_price,
                'brand' => $request->brand ?? $product->brand,
                'image' => $request->image ?? $product->image,
                'low_stock_threshold' => $request->low_stock_threshold ?? $product->low_stock_threshold,
                // code and barcode intentionally omitted — never change them on update
            ]);

            return response()->json($product->fresh());

        } catch (\Exception $e) {
            \Log::error('Update error: '.$e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function byCategory(Request $request)
    {
        $category = Categories::where('code', $request->category_code)->first();

        if (! $category) {
            return response()->json(['category_id' => null, 'products' => []]);
        }

        $products = Product::where('category_id', $category->id)
            ->select('id', 'name', 'code', 'barcode', 'selling_price')
            ->get();

        return response()->json([
            'category_id' => $category->id,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Store payload:', $request->all());

            // Auto-generate unique code
            $prefix = 'PROD-'.strtoupper(substr($request->name, 0, 3));
            do {
                $code = $prefix.'-'.rand(1000, 9999);
            } while (Product::where('code', $code)->exists());

            // Auto-generate unique barcode
            do {
                $barcode = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
            } while (Product::where('barcode', $barcode)->exists());

            $product = Product::create([
                'code' => $code,
                'name' => $request->name,
                'category_id' => $request->category_id,
                'barcode' => $barcode,
                'selling_price' => $request->selling_price,
                'stock_quantity' => $request->stock_quantity ?? 0,
                'status' => $request->status ?? 'active',
                'cost_price' => $request->cost_price ?? 0,
                'brand' => $request->brand ?? null,
                'image' => $request->image ?? null,
                'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            ]);

            return response()->json($product);

        } catch (\Exception $e) {
            \Log::error('Store error: '.$e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
