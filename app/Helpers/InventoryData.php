<?php

namespace App\Helpers;

class InventoryData
{
    public static function getStockItems()
    {
        $products = ProductData::getProducts();

        $reorderLevels = [
            'PRD-0001' => 10, 'PRD-0002' => 10, 'PRD-0003' => 10, 'PRD-0004' => 10,
            'PRD-0005' => 15, 'PRD-0006' => 15, 'PRD-0007' => 10, 'PRD-0008' => 10,
            'PRD-0009' => 8,  'PRD-0010' => 8,  'PRD-0011' => 10, 'PRD-0012' => 8,
            'PRD-0013' => 8,  'PRD-0014' => 8,  'PRD-0015' => 15,
        ];

        $lastUpdated = [
            'PRD-0001' => '2024-11-22', 'PRD-0002' => '2024-11-21', 'PRD-0003' => '2024-11-24',
            'PRD-0004' => '2024-11-20', 'PRD-0005' => '2024-11-23', 'PRD-0006' => '2024-11-19',
            'PRD-0007' => '2024-11-24', 'PRD-0008' => '2024-11-18', 'PRD-0009' => '2024-11-22',
            'PRD-0010' => '2024-11-23', 'PRD-0011' => '2024-11-21', 'PRD-0012' => '2024-11-20',
            'PRD-0013' => '2024-11-17', 'PRD-0014' => '2024-11-23', 'PRD-0015' => '2024-11-25',
        ];

        return array_map(function ($product) use ($reorderLevels, $lastUpdated) {
            $product['reorder_level'] = $reorderLevels[$product['code']] ?? 10;
            $product['last_updated'] = $lastUpdated[$product['code']] ?? '2024-11-20';
            return $product;
        }, $products);
    }

    public static function getSummaryCards()
    {
        $summary = self::getSummary();

        return [
            [
                'title' => 'Total Products',
                'value' => $summary['total_products'],
                'icon' => 'fa-solid fa-cube',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => 'up',
                'percentage' => '4.0%',
                'period' => ' last month',
            ],
            [
                'title' => 'Low Stock',
                'value' => $summary['low_stock'],
                'icon' => 'fa-solid fa-triangle-exclamation',
                'iconBg' => '#F59E0B',
                'iconColor' => '#D97706',
                'trend' => 'up',
                'percentage' => '5.0%',
                'period' => ' last week',
            ],
            [
                'title' => 'Out of Stock',
                'value' => $summary['out_of_stock'],
                'icon' => 'fa-solid fa-circle-xmark',
                'iconBg' => '#EF4444',
                'iconColor' => '#EF4444',
                'trend' => 'down',
                'percentage' => '1.0%',
                'period' => ' last week',
            ],
            [
                'title' => 'Stock Value',
                'value' => '$' . number_format($summary['total_value']),
                'icon' => 'fa-solid fa-sack-dollar',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => '7.5%',
                'period' => ' last month',
            ],
        ];
    }

    public static function getSummary()
    {
        $items = self::getStockItems();

        $totalProducts = count($items);
        $lowStock = collect($items)->filter(fn ($i) => $i['stock'] > 0 && $i['stock'] < $i['reorder_level'])->count();
        $outOfStock = collect($items)->filter(fn ($i) => $i['stock'] <= 0)->count();
        $totalValue = collect($items)->sum(fn ($i) => $i['price'] * $i['stock']);

        return [
            'total_products' => $totalProducts,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock,
            'total_value' => $totalValue,
        ];
    }

    public static function getMovementTrend()
    {
        return [
            'labels'    => ['Nov 19', 'Nov 20', 'Nov 21', 'Nov 22', 'Nov 23', 'Nov 24', 'Nov 25'],
            'stock_in'  => [8, 0, 5, 12, 10, 15, 6],
            'stock_out' => [4, 7, 3, 9, 6, 11, 5],
        ];
    }

    public static function getMovements()
    {
        return [
            [
                'id' => 1,
                'product_name' => 'NVIDIA RTX 4090',
                'product_code' => 'PRD-0001',
                'type' => 'in',
                'quantity' => 5,
                'reason' => 'Restock',
                'user' => 'Admin',
                'date' => '2024-11-24 10:32',
            ],
            [
                'id' => 2,
                'product_name' => 'Samsung 990 Pro 1TB NVMe',
                'product_code' => 'PRD-0007',
                'type' => 'out',
                'quantity' => 2,
                'reason' => 'Sale',
                'user' => 'Cashier 1',
                'date' => '2024-11-24 09:15',
            ],
            [
                'id' => 3,
                'product_name' => 'Seagate Barracuda 2TB HDD',
                'product_code' => 'PRD-0008',
                'type' => 'out',
                'quantity' => 3,
                'reason' => 'Sale',
                'user' => 'Cashier 2',
                'date' => '2024-11-23 16:48',
            ],
            [
                'id' => 4,
                'product_name' => 'Noctua NH-D15 Air Cooler',
                'product_code' => 'PRD-0013',
                'type' => 'in',
                'quantity' => 10,
                'reason' => 'Restock',
                'user' => 'Admin',
                'date' => '2024-11-23 11:02',
            ],
            [
                'id' => 5,
                'product_name' => 'ASUS ROG Strix Z790-E',
                'product_code' => 'PRD-0009',
                'type' => 'out',
                'quantity' => 1,
                'reason' => 'Damaged',
                'user' => 'Admin',
                'date' => '2024-11-22 14:20',
            ],
            [
                'id' => 6,
                'product_name' => 'Kingston Fury 16GB DDR4',
                'product_code' => 'PRD-0006',
                'type' => 'out',
                'quantity' => 4,
                'reason' => 'Sale',
                'user' => 'Cashier 1',
                'date' => '2024-11-22 13:05',
            ],
        ];
    }
}