<?php

namespace App\Helpers;

class CashierData
{
    public static function getCategories()
    {
        return [
            ['code' => 'ALL', 'name' => 'All Items', 'icon' => 'fa-solid fa-border-all', 'color' => '#0F6E8C'],
            ['code' => 'GPU', 'name' => 'Graphics Cards', 'icon' => 'fa-solid fa-microchip', 'color' => '#8B5CF6'],
            ['code' => 'CPU', 'name' => 'Processors', 'icon' => 'fa-solid fa-server', 'color' => '#0F6E8C'],
            ['code' => 'RAM', 'name' => 'Memory', 'icon' => 'fa-solid fa-memory', 'color' => '#10B981'],
            ['code' => 'STO', 'name' => 'Storage', 'icon' => 'fa-solid fa-hard-drive', 'color' => '#F59E0B'],
            ['code' => 'MBD', 'name' => 'Motherboards', 'icon' => 'fa-solid fa-computer', 'color' => '#EF4444'],
            ['code' => 'PSU', 'name' => 'Power Supply', 'icon' => 'fa-solid fa-plug', 'color' => '#6366F1'],
            ['code' => 'COL', 'name' => 'Cooling', 'icon' => 'fa-solid fa-wind', 'color' => '#14B8A6'],
            ['code' => 'PER', 'name' => 'Peripherals', 'icon' => 'fa-solid fa-keyboard', 'color' => '#EC4899'],
        ];
    }

    public static function getProducts()
    {
        return [
            ['code' => 'PRD-0001', 'name' => 'NVIDIA RTX 4090', 'category_code' => 'GPU', 'category_name' => 'Graphics Cards', 'price' => 1599.00, 'stock' => 12, 'barcode' => '8901234560011'],
            ['code' => 'PRD-0002', 'name' => 'NVIDIA RTX 4070 Ti', 'category_code' => 'GPU', 'category_name' => 'Graphics Cards', 'price' => 899.00, 'stock' => 8, 'barcode' => '8901234560028'],
            ['code' => 'PRD-0003', 'name' => 'Intel Core i9-14900K', 'category_code' => 'CPU', 'category_name' => 'Processors', 'price' => 599.00, 'stock' => 15, 'barcode' => '8901234560035'],
            ['code' => 'PRD-0004', 'name' => 'AMD Ryzen 9 7950X', 'category_code' => 'CPU', 'category_name' => 'Processors', 'price' => 549.00, 'stock' => 9, 'barcode' => '8901234560042'],
            ['code' => 'PRD-0005', 'name' => 'Corsair 32GB DDR5', 'category_code' => 'RAM', 'category_name' => 'Memory', 'price' => 149.00, 'stock' => 20, 'barcode' => '8901234560059'],
            ['code' => 'PRD-0006', 'name' => 'Kingston 16GB DDR4', 'category_code' => 'RAM', 'category_name' => 'Memory', 'price' => 65.00, 'stock' => 6, 'barcode' => '8901234560066'],
            ['code' => 'PRD-0007', 'name' => 'Samsung 990 Pro 1TB', 'category_code' => 'STO', 'category_name' => 'Storage', 'price' => 129.00, 'stock' => 18, 'barcode' => '8901234560073'],
            ['code' => 'PRD-0008', 'name' => 'Seagate Barracuda 2TB', 'category_code' => 'STO', 'category_name' => 'Storage', 'price' => 59.00, 'stock' => 0, 'barcode' => '8901234560080'],
            ['code' => 'PRD-0009', 'name' => 'ASUS ROG Strix Z790-E', 'category_code' => 'MBD', 'category_name' => 'Motherboards', 'price' => 489.00, 'stock' => 5, 'barcode' => '8901234560097'],
            ['code' => 'PRD-0010', 'name' => 'MSI MAG B650 Tomahawk', 'category_code' => 'MBD', 'category_name' => 'Motherboards', 'price' => 219.00, 'stock' => 11, 'barcode' => '8901234560103'],
            ['code' => 'PRD-0011', 'name' => 'Corsair RM850x 850W', 'category_code' => 'PSU', 'category_name' => 'Power Supply', 'price' => 139.00, 'stock' => 14, 'barcode' => '8901234560110'],
            ['code' => 'PRD-0012', 'name' => 'Noctua NH-D15 Cooler', 'category_code' => 'COL', 'category_name' => 'Cooling', 'price' => 99.00, 'stock' => 4, 'barcode' => '8901234560134'],
            ['code' => 'PRD-0013', 'name' => 'Logitech G Pro X KB', 'category_code' => 'PER', 'category_name' => 'Peripherals', 'price' => 149.00, 'stock' => 25, 'barcode' => '8901234560158'],
            ['code' => 'PRD-0014', 'name' => 'LG UltraGear 27" 240Hz', 'category_code' => 'PER', 'category_name' => 'Peripherals', 'price' => 399.00, 'stock' => 10, 'barcode' => '8901234560141'],
            ['code' => 'PRD-0015', 'name' => 'AMD Ryzen 5 7600X', 'category_code' => 'CPU', 'category_name' => 'Processors', 'price' => 249.00, 'stock' => 7, 'barcode' => '8901234560165'],
        ];
    }
}
