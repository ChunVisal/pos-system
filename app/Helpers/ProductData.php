<?php

namespace App\Helpers;

class ProductData
{
    public static function getCategories()
    {
        return [
            ['code' => 'GPU', 'name' => 'Graphics Cards', 'status' => 'active'],
            ['code' => 'CPU', 'name' => 'Processors', 'status' => 'active'],
            ['code' => 'RAM', 'name' => 'RAM / Memory', 'status' => 'active'],
            ['code' => 'STO', 'name' => 'Storage', 'status' => 'active'],
            ['code' => 'MBD', 'name' => 'Motherboards', 'status' => 'active'],
            ['code' => 'PSU', 'name' => 'Power Supplies', 'status' => 'active'],
            ['code' => 'CSE', 'name' => 'Cases', 'status' => 'active'],
            ['code' => 'COL', 'name' => 'Cooling', 'status' => 'active'],
            ['code' => 'MON', 'name' => 'Monitors', 'status' => 'active'],
            ['code' => 'PER', 'name' => 'Peripherals', 'status' => 'active'],
        ];
    }

    public static function getProducts()
    {
        return [
            [
                'code' => 'PRD-0001',
                'name' => 'NVIDIA RTX 4090',
                'category_code' => 'GPU',
                'category_name' => 'Graphics Cards',
                'price' => 1599.00,
                'stock' => 12,
                'barcode' => '8901234560011',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 1599.00],
                ],
            ],
            [
                'code' => 'PRD-0002',
                'name' => 'NVIDIA RTX 4070 Ti',
                'category_code' => 'GPU',
                'category_name' => 'Graphics Cards',
                'price' => 899.00,
                'stock' => 8,
                'barcode' => '8901234560028',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 899.00],
                ],
            ],
            [
                'code' => 'PRD-0003',
                'name' => 'Intel Core i9-14900K',
                'category_code' => 'CPU',
                'category_name' => 'Processors',
                'price' => 599.00,
                'stock' => 15,
                'barcode' => '8901234560035',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 599.00],
                ],
            ],
            [
                'code' => 'PRD-0004',
                'name' => 'AMD Ryzen 9 7950X',
                'category_code' => 'CPU',
                'category_name' => 'Processors',
                'price' => 549.00,
                'stock' => 9,
                'barcode' => '8901234560042',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 549.00],
                ],
            ],
            [
                'code' => 'PRD-0005',
                'name' => 'Corsair Vengeance 32GB DDR5',
                'category_code' => 'RAM',
                'category_name' => 'RAM / Memory',
                'price' => 149.00,
                'stock' => 20,
                'barcode' => '8901234560059',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 149.00],
                    ['description' => 'Box of 5', 'quantity_per_unit' => 5, 'price' => 720.00],
                ],
            ],
            [
                'code' => 'PRD-0006',
                'name' => 'Kingston Fury 16GB DDR4',
                'category_code' => 'RAM',
                'category_name' => 'RAM / Memory',
                'price' => 65.00,
                'stock' => 6,
                'barcode' => '8901234560066',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 65.00],
                ],
            ],
            [
                'code' => 'PRD-0007',
                'name' => 'Samsung 990 Pro 1TB NVMe',
                'category_code' => 'STO',
                'category_name' => 'Storage',
                'price' => 129.00,
                'stock' => 18,
                'barcode' => '8901234560073',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 129.00],
                ],
            ],
            [
                'code' => 'PRD-0008',
                'name' => 'Seagate Barracuda 2TB HDD',
                'category_code' => 'STO',
                'category_name' => 'Storage',
                'price' => 59.00,
                'stock' => 0,
                'barcode' => '8901234560080',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 59.00],
                ],
            ],
            [
                'code' => 'PRD-0009',
                'name' => 'ASUS ROG Strix Z790-E',
                'category_code' => 'MBD',
                'category_name' => 'Motherboards',
                'price' => 489.00,
                'stock' => 5,
                'barcode' => '8901234560097',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 489.00],
                ],
            ],
            [
                'code' => 'PRD-0010',
                'name' => 'MSI MAG B650 Tomahawk',
                'category_code' => 'MBD',
                'category_name' => 'Motherboards',
                'price' => 219.00,
                'stock' => 11,
                'barcode' => '8901234560103',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 219.00],
                ],
            ],
            [
                'code' => 'PRD-0011',
                'name' => 'Corsair RM850x 850W PSU',
                'category_code' => 'PSU',
                'category_name' => 'Power Supplies',
                'price' => 139.00,
                'stock' => 14,
                'barcode' => '8901234560110',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 139.00],
                ],
            ],
            [
                'code' => 'PRD-0012',
                'name' => 'NZXT H7 Flow Mid Tower',
                'category_code' => 'CSE',
                'category_name' => 'Cases',
                'price' => 109.00,
                'stock' => 7,
                'barcode' => '8901234560127',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 109.00],
                ],
            ],
            [
                'code' => 'PRD-0013',
                'name' => 'Noctua NH-D15 Air Cooler',
                'category_code' => 'COL',
                'category_name' => 'Cooling',
                'price' => 99.00,
                'stock' => 4,
                'barcode' => '8901234560134',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 99.00],
                ],
            ],
            [
                'code' => 'PRD-0014',
                'name' => 'LG UltraGear 27" 240Hz',
                'category_code' => 'MON',
                'category_name' => 'Monitors',
                'price' => 399.00,
                'stock' => 10,
                'barcode' => '8901234560141',
                'status' => 'active',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 399.00],
                ],
            ],
            [
                'code' => 'PRD-0015',
                'name' => 'Logitech G Pro X Keyboard',
                'category_code' => 'PER',
                'category_name' => 'Peripherals',
                'price' => 149.00,
                'stock' => 25,
                'barcode' => '8901234560158',
                'status' => 'inactive',
                'uoms' => [
                    ['description' => 'Piece', 'quantity_per_unit' => 1, 'price' => 149.00],
                    ['description' => 'Box of 10', 'quantity_per_unit' => 10, 'price' => 1400.00],
                ],
            ],
        ];
    }
}