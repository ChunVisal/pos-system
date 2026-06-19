<?php

namespace App\Helpers;

class DashboardData
{
    public static function getCards()
    {
        return [
            [
                'title' => 'Total Revenue',
                'value' => '$32,000',
                'icon' => 'fa-solid fa-dollar-sign',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => '12.5%',
                'period' => 'from last week',
            ],
            [
                'title' => 'Sales Today',
                'value' => '45',
                'icon' => 'fa-solid fa-cart-shopping',
                'iconBg' => '#8B5CF6',
                'iconColor' => '#8B5CF6',
                'trend' => 'up',
                'percentage' => '8.2%',
                'period' => 'vs yesterday',
            ],
            [
                'title' => 'Products',
                'value' => '25',
                'icon' => 'fa-solid fa-cube',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => 'down',
                'percentage' => '2.3%',
                'period' => 'vs last month',
            ],
            [
                'title' => 'Low Stock',
                'value' => '3',
                'icon' => 'fa-solid fa-triangle-exclamation',
                'iconBg' => '#F59E0B',
                'iconColor' => '#D97706',
                'trend' => 'up',
                'percentage' => '5.0%',
                'period' => 'vs last week',
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