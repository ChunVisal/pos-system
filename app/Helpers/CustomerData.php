<?php

namespace App\Helpers;

class CustomerData
{
    public static function getSummary()
    {
        return [
            [
                'title' => 'Total Customers',
                'value' => '1,284',
                'icon' => 'fa-solid fa-users',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => 'up',
                'percentage' => '12.5%',
                'period' => 'vs last month',
            ],
            [
                'title' => 'New Customers',
                'value' => '86',
                'icon' => 'fa-solid fa-user-plus',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => '8.2%',
                'period' => 'this month',
            ],
            [
                'title' => 'VIP Members',
                'value' => '342',
                'icon' => 'fa-solid fa-crown',
                'iconBg' => '#F59E0B',
                'iconColor' => '#F59E0B',
                'trend' => 'up',
                'percentage' => '5.7%',
                'period' => 'vs last month',
            ],
            [
                'title' => 'Avg Order Value',
                'value' => '$156.80',
                'icon' => 'fa-solid fa-chart-line',
                'iconBg' => '#8B5CF6',
                'iconColor' => '#8B5CF6',
                'trend' => 'up',
                'percentage' => '3.1%',
                'period' => 'vs last month',
            ],
        ];
    }

    public static function getSegments()
    {
        return [
            ['label' => 'All Customers', 'count' => 1284, 'active' => true],
            ['label' => 'VIP', 'count' => 342, 'active' => false],
            ['label' => 'Regular', 'count' => 624, 'active' => false],
            ['label' => 'New', 'count' => 218, 'active' => false],
            ['label' => 'Inactive', 'count' => 100, 'active' => false],
        ];
    }

    public static function getCustomers()
    {
        return [
            [
                'id' => 1,
                'name' => 'Sokha Chan',
                'email' => 'sokha@example.com',
                'phone' => '+855 12 345 678',
                'address' => '123 Street, Phnom Penh',
                'segment' => 'vip',
                'orders' => 47,
                'total_spent' => 12580.00,
                'last_order' => '2024-06-20',
                'loyalty_points' => 1250,
                'recent_orders' => [
                    ['id' => '001', 'date' => 'Jun 20, 2024', 'amount' => 156.50, 'status' => 'Completed'],
                    ['id' => '002', 'date' => 'Jun 15, 2024', 'amount' => 89.00, 'status' => 'Completed'],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Dara Kim',
                'email' => 'dara@example.com',
                'phone' => '+855 98 765 432',
                'address' => '456 Avenue, Siem Reap',
                'segment' => 'regular',
                'orders' => 23,
                'total_spent' => 4560.00,
                'last_order' => '2024-06-18',
                'loyalty_points' => 340,
            ],
            [
                'id' => 3,
                'name' => 'Maly Touch',
                'email' => 'maly@example.com',
                'phone' => '+855 77 123 456',
                'address' => '789 Boulevard, Battambang',
                'segment' => 'new',
                'orders' => 4,
                'total_spent' => 380.00,
                'last_order' => '2024-06-16',
                'loyalty_points' => 80,
            ],
        ];
    }
}