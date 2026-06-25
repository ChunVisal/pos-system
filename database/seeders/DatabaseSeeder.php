<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with clean production data.
     */
    public function run(): void
    {
        // ==========================================
        // 1. CREATE CATEGORIES
        // ==========================================
        $electronics = Categories::create([
            'code' => 'CAT-ELEC',
            'name' => 'Electronics',
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQokKjD_cG-ps1uggc2geP3ZBIHMwuwqHfI8c0jW2dyQ&s=10',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        $accessories = Categories::create([
            'code' => 'CAT-ACC',
            'name' => 'Accessories',
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQokKjD_cG-ps1uggc2geP3ZBIHMwuwqHfI8c0jW2dyQ&s=10',
            'status' => 'active',
            'sort_order' => 2,
        ]);

        $appliances = Categories::create([
            'code' => 'CAT-APP',
            'name' => 'Appliances',
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQokKjD_cG-ps1uggc2geP3ZBIHMwuwqHfI8c0jW2dyQ&s=10',
            'status' => 'active',
            'sort_order' => 3,
        ]);

        // ==========================================
        // 2. CREATE PRODUCTS (Matching exactly 3 items)
        // ==========================================

        // Item 1: MacBook Air (In Stock)
        Product::create([
            'code' => 'PROD-M1-MAC',
            'name' => 'Apple MacBook Air M1 (8GB/256GB SSD)',
            'image' => 'https://emarque.co/cdn/shop/articles/415274348_762964179210278_5193433904941910425_n.jpg?v=1713869061&width=1100',
            'category_id' => $electronics->id,
            'barcode' => '194252057912',
            'cost_price' => 750.00,
            'selling_price' => 999.00,
            'stock_quantity' => 25,
            'low_stock_threshold' => 5,
            'status' => 'active',
        ]);

        // Item 2: Logitech Mouse (Low Stock)
        Product::create([
            'code' => 'PROD-MX-MOU',
            'name' => 'Logitech MX Master 3S Wireless Mouse',
            'image' => 'https://emarque.co/cdn/shop/articles/415274348_762964179210278_5193433904941910425_n.jpg?v=1713869061&width=1100',
            'category_id' => $accessories->id,
            'barcode' => '097855174950',
            'cost_price' => 60.00,
            'selling_price' => 99.00,
            'stock_quantity' => 3,
            'low_stock_threshold' => 8,
            'status' => 'active',
        ]);

        // Item 3: Sony Headphones (Out of Stock)
        Product::create([
            'code' => 'PROD-WH-1000',
            'name' => 'Sony WH-1000XM4 Wireless Headphones',
            'image' => 'https://emarque.co/cdn/shop/articles/415274348_762964179210278_5193433904941910425_n.jpg?v=1713869061&width=1100',
            'category_id' => $accessories->id,
            'barcode' => '027242919434',
            'cost_price' => 180.00,
            'selling_price' => 249.99,
            'stock_quantity' => 0,
            'low_stock_threshold' => 5,
            'status' => 'active',
        ]);
    }
}
