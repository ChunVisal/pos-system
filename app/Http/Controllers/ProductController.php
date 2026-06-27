<?php

namespace App\Http\Controllers;

use App\Helpers\ProductData;
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
        Product::where('id', $id)->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function byCategory(Request $request)
    {
        $category = Categories::where('code', $request->category_code)->first();

        if (! $category) {
            return response()->json(['category_id' => null, 'products' => []]);
        }

        $helperProducts = ProductData::getProductsByCategory($request->category_code);
        $dbProducts = Product::where('category_id', $category->id)
            ->select('id', 'name', 'code', 'barcode', 'selling_price')
            ->get()->keyBy('name');

        $products = collect($helperProducts)->map(function ($item) use ($dbProducts) {
            $db = $dbProducts->get($item['name']);

            return [
                'id' => $db?->id ?? null,
                'name' => $item['name'],
                'code' => $db?->code ?? '',
                'barcode' => $db?->barcode ?? '',
                'selling_price' => $db?->selling_price ?? $item['price'],
            ];
        })->values();

        return response()->json([
            'category_id' => $category->id,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        // Prevent duplicate submissions within 5 seconds
        $cacheKey = 'store_product_'.md5($request->name.$request->category_id.$request->ip());

        if (\Cache::has($cacheKey)) {
            \Log::info('=== DUPLICATE BLOCKED ===', ['name' => $request->name]);

            return response()->json(\Cache::get($cacheKey));
        }

        try {
            \Log::info('=== STORE CALLED ===', [
                'time' => now()->format('H:i:s.u'),
                'name' => $request->name,
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip(),
            ]);

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

            // Cache the result for 5 seconds to block duplicates
            \Cache::put($cacheKey, $product, 5);

            return response()->json($product);

        } catch (\Exception $e) {
            \Log::error('Store error: '.$e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
