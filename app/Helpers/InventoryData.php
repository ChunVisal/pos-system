<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\StockMovement;

class InventoryData
{
    public static function getStockItems()
    {
        // Replace ProductData::getProducts() with direct Product model query to avoid undefined method
        $products = Product::query()
            ->get()
            ->map(function ($p) {
                return [
                    'code' => $p->code ?? $p->product_code ?? null,
                    'stock' => $p->stock_quantity ?? $p->stock ?? 0,
                    'price' => $p->selling_price ?? $p->price ?? $p->cost_price ?? 0,
                    // preserve other attributes if present
                    'name' => $p->name ?? null,
                ];
            })
            ->toArray();

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
        return [
            [
                'title' => 'Total Products',
                'value' => Product::query()->count('id'),
                'icon' => 'fa-solid fa-cube',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => 'up',
                'percentage' => '4.0%',
                'period' => 'Today',
            ],
            [
                'title' => 'Low Stock',
                'value' => Product::whereColumn('stock_quantity', '<', 'low_stock_threshold', 'and')
                    ->where('stock_quantity', '>', 0, 'and')
                    ->count(),
                'icon' => 'fa-solid fa-triangle-exclamation',
                'iconBg' => '#F59E0B',
                'iconColor' => '#D97706',
                'trend' => 'up',
                'percentage' => '5.0%',
                'period' => 'Today',
            ],
            [
                'title' => 'Out of Stock',
                'value' => Product::where('stock_quantity', '=', 0, 'and')->count(),
                'icon' => 'fa-solid fa-circle-xmark',
                'iconBg' => '#EF4444',
                'iconColor' => '#EF4444',
                'trend' => 'down',
                'percentage' => '1.0%',
                'period' => 'Today',
            ],
            [
                'title' => 'Stock Value',
                'value' => Product::selectRaw('SUM(stock_quantity * selling_price) as total', [])->value('total') ?? 0,
                'icon' => 'fa-solid fa-sack-dollar',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => '7.5%',
                'period' => 'Today',
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

    private function getMovementTrend()
    {
        $movements = StockMovement::orderBy('created_at', 'asc')->get();

        if ($movements->isEmpty()) {
            return [
                'labels' => [],
                'stock_in' => [],
                'stock_out' => [],
            ];
        }

        $grouped = $movements->groupBy(function ($item) {
            return $item->created_at->format('d M');
        });

        $labels = [];
        $stockIn = [];
        $stockOut = [];

        foreach ($grouped as $time => $items) {
            $labels[] = $time;
            $stockIn[] = $items->where('type', 'in')->sum('quantity');
            $stockOut[] = $items->where('type', 'out')->sum('quantity');
        }

        return [
            'labels' => $labels,
            'stock_in' => $stockIn,
            'stock_out' => $stockOut,
        ];
    }

    // public static function getMovements()
    // {
    //     return [
    //         [
    //             'id' => 1,
    //             'product_name' => 'NVIDIA RTX 4090',
    //             'product_code' => 'PRD-0001',
    //             'type' => 'in',
    //             'quantity' => 5,
    //             'reason' => 'Restock',
    //             'user' => 'Admin',
    //             'date' => '2024-11-24 10:32',
    //         ],
    //         [
    //             'id' => 2,
    //             'product_name' => 'Samsung 990 Pro 1TB NVMe',
    //             'product_code' => 'PRD-0007',
    //             'type' => 'out',
    //             'quantity' => 2,
    //             'reason' => 'Sale',
    //             'user' => 'Cashier 1',
    //             'date' => '2024-11-24 09:15',
    //         ],
    //         [
    //             'id' => 3,
    //             'product_name' => 'Seagate Barracuda 2TB HDD',
    //             'product_code' => 'PRD-0008',
    //             'type' => 'out',
    //             'quantity' => 3,
    //             'reason' => 'Sale',
    //             'user' => 'Cashier 2',
    //             'date' => '2024-11-23 16:48',
    //         ],
    //         [
    //             'id' => 4,
    //             'product_name' => 'Noctua NH-D15 Air Cooler',
    //             'product_code' => 'PRD-0013',
    //             'type' => 'in',
    //             'quantity' => 10,
    //             'reason' => 'Restock',
    //             'user' => 'Admin',
    //             'date' => '2024-11-23 11:02',
    //         ],
    //         [
    //             'id' => 5,
    //             'product_name' => 'ASUS ROG Strix Z790-E',
    //             'product_code' => 'PRD-0009',
    //             'type' => 'out',
    //             'quantity' => 1,
    //             'reason' => 'Damaged',
    //             'user' => 'Admin',
    //             'date' => '2024-11-22 14:20',
    //         ],
    //         [
    //             'id' => 6,
    //             'product_name' => 'Kingston Fury 16GB DDR4',
    //             'product_code' => 'PRD-0006',
    //             'type' => 'out',
    //             'quantity' => 4,
    //             'reason' => 'Sale',
    //             'user' => 'Cashier 1',
    //             'date' => '2024-11-22 13:05',
    //         ],
    //     ];
    // }
}
