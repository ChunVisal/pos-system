<?php

namespace App\Http\Controllers;

use App\Models\CashierStock;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('code', 'like', '%'.$search.'%')
                        ->orWhere('barcode', 'like', '%'.$search.'%')
                        ->orWhereHas('category', function ($cat) use ($search) {
                            $cat->where('name', 'like', '%'.$search.'%');
                        });
                });
            })
            ->with('category')
            ->get();

        $categories = Categories::all();
        $cashiers = User::where('role', 'cashier')->get();
        $cashierStocks = CashierStock::with('cashier')->get();

        if ($request->ajax === '1') {
            return response()->json([
                'table' => view('admin.partials.products.table-rows', compact('products'))->render(),
                'grid' => view('admin.partials.products.grid-rows', compact('products'))->render(),
            ]);
        }

        return view('admin.products', compact('products', 'categories', 'cashiers', 'cashierStocks'));
    }

    public function stockDrop(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cashier_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock']);
        }

        CashierStock::create([
            'product_id' => $request->product_id,
            'cashier_id' => $request->cashier_id,
            'allocated_quantity' => $request->quantity,
            'allocated_by' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Stock transferred']);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $imageUrl = $product->image; // keep existing by default
            if ($request->hasFile('image_file')) {
                $imageUrl = $this->uploadToCloudinary($request->file('image_file')); // ← use private method
            } elseif ($request->image_url) {
                $imageUrl = $request->image_url;
            }

            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'selling_price' => $request->selling_price,
                'stock_quantity' => $request->stock_quantity ?? $product->stock_quantity,
                'status' => $request->status ?? $product->status,
                'cost_price' => $request->cost_price ?? $product->cost_price,
                'brand' => $request->brand ?? $product->brand,
                'image' => $imageUrl,
                'low_stock_threshold' => $request->low_stock_threshold ?? $product->low_stock_threshold,
                // code and barcode intentionally omitted — never change them on update
            ]);

            return response()->json($product->fresh());

        } catch (\Exception $e) {
            \Log::error('Update error: '.$e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function uploadToCloudinary($file): string
    {
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');
        $timestamp = time();
        $signature = sha1("folder=pos/products&timestamp={$timestamp}{$apiSecret}");

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => false,   // ← bypass SSL for Laragon
            CURLOPT_SSL_VERIFYHOST => false,   // ← bypass SSL for Laragon
            CURLOPT_POSTFIELDS => [
                'file' => new \CURLFile($file->getRealPath(), $file->getMimeType(), $file->getClientOriginalName()),
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
                'folder' => 'pos/products',
            ],
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("Cloudinary upload failed: {$error}");
        }

        $data = json_decode($response, true);

        if (! isset($data['secure_url'])) {
            throw new \Exception('Cloudinary error: '.($data['error']['message'] ?? 'Unknown error'));
        }

        return $data['secure_url'];
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete(); // hard delete, no soft delete

        return response()->json(['message' => 'Deleted']);
    }

    public function bulkDestroy(Request $request)
    {
        Product::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function byCategory(Request $request)
    {
        $category = Categories::select('id', 'code', 'name')->where('code', $request->category_code)->first();

        if (! $category) {
            return response()->json(['category_id' => null, 'products' => []]);
        }

        // Get names from catalog — NEVER deleted, always there!
        $catalogProducts = ProductCatalog::where('category_code', $request->category_code)->get();

        // Get DB products for price/code/stock info
        $dbProducts = Product::where('category_id', $category->id)
            ->select('id', 'name', 'code', 'barcode', 'selling_price')
            ->get()->keyBy('name');

        $products = $catalogProducts->map(function ($item) use ($dbProducts) {
            $db = $dbProducts->get($item->name);

            return [
                'id' => $db?->id ?? null,
                'name' => $item->name,
                'code' => $db?->code ?? '',
                'barcode' => $db?->barcode ?? '',
                'selling_price' => $db?->selling_price ?? $item->default_price,
            ];
        })->values();

        return response()->json([
            'category_id' => $category->id,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $cacheKey = 'store_product_'.md5($request->name.$request->category_id.$request->ip());

        if (\Cache::has($cacheKey)) {
            return response()->json(\Cache::get($cacheKey));
        }

        try {
            $prefix = 'PROD-'.strtoupper(substr($request->name, 0, 3));
            do {
                $code = $prefix.'-'.rand(1000, 9999);
            } while (Product::where('code', $code)->exists());

            do {
                $barcode = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
            } while (Product::where('barcode', $barcode)->exists());

            $imageUrl = null;
            if ($request->hasFile('image_file')) {
                $imageUrl = $this->uploadToCloudinary($request->file('image_file'));
            } elseif ($request->image_url) {
                $imageUrl = $request->image_url;
            }

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
                'image' => $imageUrl,
                'low_stock_threshold' => $request->low_stock_threshold ?? 5,
            ]);

            \Cache::put($cacheKey, $product, 5);

            return response()->json($product);

        } catch (\Exception $e) {
            \Log::error('Store error: '.$e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
