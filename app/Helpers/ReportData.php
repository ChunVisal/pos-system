<?php

namespace App\Helpers;

class ReportData
{
    public static function getSummary()
    {
        return [
            'total_revenue' => 32450.00,
            'total_transactions' => 318,
            'avg_sale' => 102.04,
            'items_sold' => 612,
            'revenue_trend' => 'up',
            'revenue_change' => '12.5%',
            'transactions_trend' => 'up',
            'transactions_change' => '8.2%',
            'avg_trend' => 'down',
            'avg_change' => '1.8%',
            'items_trend' => 'up',
            'items_change' => '5.4%',
        ];
    }

    public static function getRevenueTrend()
    {
        return [
            'labels'  => ['Nov 19', 'Nov 20', 'Nov 21', 'Nov 22', 'Nov 23', 'Nov 24', 'Nov 25'],
            'revenue' => [3800, 2950, 4200, 5100, 4600, 6300, 5500],
        ];
    }

    public static function getDailySales()
    {
        return [
            ['date' => '2024-11-25', 'transactions' => 52, 'revenue' => 5500.00, 'avg_sale' => 105.77, 'items_sold' => 98],
            ['date' => '2024-11-24', 'transactions' => 61, 'revenue' => 6300.00, 'avg_sale' => 103.28, 'items_sold' => 115],
            ['date' => '2024-11-23', 'transactions' => 44, 'revenue' => 4600.00, 'avg_sale' => 104.55, 'items_sold' => 87],
            ['date' => '2024-11-22', 'transactions' => 49, 'revenue' => 5100.00, 'avg_sale' => 104.08, 'items_sold' => 92],
            ['date' => '2024-11-21', 'transactions' => 40, 'revenue' => 4200.00, 'avg_sale' => 105.00, 'items_sold' => 78],
            ['date' => '2024-11-20', 'transactions' => 29, 'revenue' => 2950.00, 'avg_sale' => 101.72, 'items_sold' => 56],
            ['date' => '2024-11-19', 'transactions' => 36, 'revenue' => 3800.00, 'avg_sale' => 105.56, 'items_sold' => 70],
        ];
    }

    public static function getTopItems()
    {
        return [
            ['rank' => 1, 'name' => 'NVIDIA RTX 4090', 'category' => 'Graphics Cards', 'qty_sold' => 28, 'revenue' => 44772.00, 'percent' => 100],
            ['rank' => 2, 'name' => 'Intel Core i9-14900K', 'category' => 'Processors', 'qty_sold' => 22, 'revenue' => 13178.00, 'percent' => 78],
            ['rank' => 3, 'name' => 'Samsung 990 Pro 1TB NVMe', 'category' => 'Storage', 'qty_sold' => 35, 'revenue' => 4515.00, 'percent' => 65],
            ['rank' => 4, 'name' => 'Corsair Vengeance 32GB DDR5', 'category' => 'RAM / Memory', 'qty_sold' => 31, 'revenue' => 4619.00, 'percent' => 60],
            ['rank' => 5, 'name' => 'LG UltraGear 27" 240Hz', 'category' => 'Monitors', 'qty_sold' => 14, 'revenue' => 5586.00, 'percent' => 45],
        ];
    }

    public static function getSalesBySalesperson()
    {
        return [
            [
                'name' => 'Sreyleak Kim',
                'transactions' => 89,
                'revenue' => 9120.00,
                'top_item' => 'NVIDIA RTX 4090',
                'percent' => 100,
            ],
            [
                'name' => 'Vibol Heng',
                'transactions' => 76,
                'revenue' => 7840.00,
                'top_item' => 'Intel Core i9-14900K',
                'percent' => 86,
            ],
            [
                'name' => 'Ratanak Vong',
                'transactions' => 68,
                'revenue' => 6450.00,
                'top_item' => 'Samsung 990 Pro 1TB NVMe',
                'percent' => 71,
            ],
            [
                'name' => 'Sopheak Ly',
                'transactions' => 54,
                'revenue' => 5230.00,
                'top_item' => 'Corsair Vengeance 32GB DDR5',
                'percent' => 57,
            ],
            [
                'name' => 'Bopha Meas',
                'transactions' => 31,
                'revenue' => 3810.00,
                'top_item' => 'LG UltraGear 27" 240Hz',
                'percent' => 42,
            ],
        ];
    }

    public static function getPaymentBreakdown()
    {
        return [
            [
                'method' => 'Cash',
                'transactions' => 102,
                'amount' => 17850.00,
                'percent' => 55,
                'color' => '#0F6E8C',
            ],
            [
                'method' => 'KHQR',
                'transactions' => 67,
                'amount' => 9735.00,
                'percent' => 30,
                'color' => '#10B981',
            ],
            [
                'method' => 'Credit Card',
                'transactions' => 32,
                'amount' => 4865.00,
                'percent' => 15,
                'color' => '#8B5CF6',
            ],
        ];
    }

    public static function getInventorySummary()
    {
        $items = InventoryData::getStockItems();

        return [
            'total_stock_value' => collect($items)->sum(fn ($i) => $i['price'] * $i['stock']),
            'low_stock' => collect($items)->filter(fn ($i) => $i['stock'] > 0 && $i['stock'] < $i['reorder_level'])->count(),
            'out_of_stock' => collect($items)->filter(fn ($i) => $i['stock'] <= 0)->count(),
            'total_units' => collect($items)->sum('stock'),
        ];
    }

    public static function getStockByCategory()
    {
        $items = collect(InventoryData::getStockItems());

        return $items->groupBy('category_name')->map(function ($group, $name) {
            return [
                'category' => $name,
                'products' => $group->count(),
                'total_stock' => $group->sum('stock'),
                'stock_value' => $group->sum(fn ($i) => $i['price'] * $i['stock']),
            ];
        })->sortByDesc('stock_value')->values()->all();
    }
}