<?php

namespace Database\Seeders;

use App\Helpers\ProductData;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $allProducts = ProductData::getAllProducts();

        foreach ($allProducts as $item) {
            $category = Categories::where('code', $item['category_code'])->first();
            if (! $category) {
                continue;
            }

            // Skip if already exists by name + category
            if (Product::where('name', $item['name'])->where('category_id', $category->id)->exists()) {
                continue;
            }

            $prefix = 'PROD-'.strtoupper(substr($item['name'], 0, 3));
            do {
                $code = $prefix.'-'.rand(1000, 9999);
            } while (Product::where('code', $code)->exists());

            do {
                $barcode = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
            } while (Product::where('barcode', $barcode)->exists());

            Product::create([
                'code' => $code,
                'name' => $item['name'],
                'category_id' => $category->id,
                'barcode' => $barcode,
                'selling_price' => $item['price'],
                'cost_price' => round($item['price'] * 0.7, 2),
                'stock_quantity' => 0,
                'low_stock_threshold' => 5,
                'status' => 'active',
                'brand' => null,
                'image' => null,
            ]);
        }
    }
}
