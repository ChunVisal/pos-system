<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class DashboardData
{
    public static function getSummaryCards()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todaySales = Order::whereDate('created_at', $today)->sum('total');
        $yesterdaySales = Order::whereDate('created_at', $yesterday)->sum('total');
        $todayOrders = Order::whereDate('created_at', $today)->count();

        // Percentage change from yesterday
        $salesChange = $yesterdaySales > 0
            ? round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 1)
            : 0;

        $totalRevenue = Order::sum('total');
        $totalProducts = Product::count();
        $lowStock = Product::whereColumn('stock_quantity', '<', 'low_stock_threshold')
            ->where('stock_quantity', '>', 0)->count();
        $outOfStock = Product::where('stock_quantity', '<=', 0)->count();

        return [
            [
                'title' => 'Total Revenue',
                'value' => '$'.number_format($totalRevenue, 2),
                'icon' => 'fa-solid fa-dollar-sign',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => 'All time',
                'period' => 'Lifetime earnings',
            ],
            [
                'title' => 'Sales Today',
                'value' => '$'.number_format($todaySales, 2),
                'icon' => 'fa-solid fa-cart-shopping',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => $salesChange >= 0 ? 'up' : 'down',
                'percentage' => abs($salesChange).'%',
                'period' => 'vs yesterday',
            ],
            [
                'title' => 'Total Products',
                'value' => $totalProducts,
                'icon' => 'fa-solid fa-cube',
                'iconBg' => '#8B5CF6',
                'iconColor' => '#8B5CF6',
                'trend' => 'up',
                'percentage' => $lowStock.' low',
                'period' => $outOfStock.' out of stock',
            ],
            [
                'title' => 'Low Stock Alert',
                'value' => $lowStock + $outOfStock,
                'icon' => 'fa-solid fa-triangle-exclamation',
                'iconBg' => '#EF4444',
                'iconColor' => '#EF4444',
                'trend' => 'down',
                'percentage' => $outOfStock.' items',
                'period' => 'Need restock',
            ],
        ];
    }
    // app/Helpers/DashboardData.php

    public static function getTopProducts()
    {
        return [
            [
                'name' => 'NVIDIA RTX 4090',
                'image' => 'https://via.placeholder.com/40',
                'price' => 1599.00,
                'sold' => 12,
                'revenue' => 19188,
                'percent' => 100,
                'rank' => 1,
            ],
            [
                'name' => 'Intel Core i9-14900K',
                'image' => 'https://via.placeholder.com/40',
                'price' => 1599.00,
                'sold' => 15,
                'revenue' => 8985,
                'percent' => 75,
                'rank' => 2,
            ],
            [
                'name' => 'Corsair 32GB RAM',
                'image' => 'https://via.placeholder.com/40',
                'price' => 1599.00,
                'sold' => 20,
                'revenue' => 2980,
                'percent' => 50,
                'rank' => 3,
            ],
            [
                'name' => 'Samsung 990 Pro 1TB',
                'image' => 'https://via.placeholder.com/40',
                'price' => 1599.00,
                'sold' => 18,
                'revenue' => 2682,
                'percent' => 40,
                'rank' => 4,
            ],
        ];
    }

    public static function getTopCategories()
    {
        return [
            [
                'name' => 'Graphics Cards',
                'icon' => 'fa-microchip',
                'products' => 45,
                'revenue' => 28450,
                'percent' => 100,
                'rank' => 1,
            ],
            [
                'name' => 'Processors',
                'icon' => 'fa-cpu',
                'products' => 32,
                'revenue' => 15200,
                'percent' => 75,
                'rank' => 2,
            ],
            [
                'name' => 'RAM / Memory',
                'icon' => 'fa-memory',
                'products' => 28,
                'revenue' => 8900,
                'percent' => 50,
                'rank' => 3,
            ],
            [
                'name' => 'Storage',
                'icon' => 'fa-hard-drive',
                'products' => 20,
                'revenue' => 5600,
                'percent' => 40,
                'rank' => 4,
            ],
        ];
    }
}
