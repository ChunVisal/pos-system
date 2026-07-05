<?php

namespace App\Helpers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerData
{
    public static function getSummary()
    {
        $userId = Auth::id();

        $baseQuery = Customer::whereHas('orders', function ($q) use ($userId) {
            $q->where('cashier_id', $userId);
        });

        return [
            [
                'title' => 'Total Customers',
                'value' => (clone $baseQuery)->count(),
                'icon' => 'fa-solid fa-users',
                'iconBg' => 'bg-[#0F6E8C]/10',
                'iconColor' => 'text-[#0F6E8C]',
                'trend' => '+12%',
                'trendColor' => 'text-green-500',
                'subtitle' => 'Your customers',
            ],
            [
                'title' => 'VIP Members',
                'value' => (clone $baseQuery)->where('segment', 'vip')->count(),
                'icon' => 'fa-solid fa-crown',
                'iconBg' => 'bg-yellow-500/10',
                'iconColor' => 'text-yellow-600',
                'trend' => '+5%',
                'trendColor' => 'text-green-500',
                'subtitle' => 'Spent over $5,000',
            ],
            [
                'title' => 'Regular',
                'value' => (clone $baseQuery)->where('segment', 'regular')->count(),
                'icon' => 'fa-solid fa-repeat',
                'iconBg' => 'bg-blue-500/10',
                'iconColor' => 'text-blue-600',
                'trend' => '+8%',
                'trendColor' => 'text-green-500',
                'subtitle' => '3+ orders',
            ],
            [
                'title' => 'New Customers',
                'value' => (clone $baseQuery)->where('segment', 'new')->count(),
                'icon' => 'fa-solid fa-walking',
                'iconBg' => 'bg-green-500/10',
                'iconColor' => 'text-green-600',
                'trend' => '+15%',
                'trendColor' => 'text-green-500',
                'subtitle' => '1-2 orders',
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
                ],
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
