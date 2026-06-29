<?php

namespace Database\Seeders;

use App\Helpers\ProductData;
use App\Models\ProductCatalog;
use Illuminate\Database\Seeder;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        ProductCatalog::truncate();

        foreach (ProductData::getAllProducts() as $item) {
            ProductCatalog::create([
                'name' => $item['name'],
                'default_price' => $item['price'],
                'category_code' => $item['category_code'],
            ]);
        }
    }
}
