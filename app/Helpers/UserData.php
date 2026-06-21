<?php

namespace App\Helpers;

class UserData
{
    public static function getUsers()
    {
        return [
            [
                'id' => 1,
                'name' => 'Sokha Chan',
                'email' => 'sokha.chan@bluetech.com',
                'role' => 'admin',
                'status' => 'active',
                'last_login' => '2024-11-25 09:12',
                'created_at' => '2024-01-15',
            ],
            [
                'id' => 2,
                'name' => 'Dara Pich',
                'email' => 'dara.pich@bluetech.com',
                'role' => 'admin',
                'status' => 'active',
                'last_login' => '2024-11-24 17:40',
                'created_at' => '2024-02-02',
            ],
            [
                'id' => 3,
                'name' => 'Sreyleak Kim',
                'email' => 'sreyleak.kim@bluetech.com',
                'role' => 'cashier',
                'status' => 'active',
                'last_login' => '2024-11-25 08:50',
                'created_at' => '2024-03-10',
            ],
            [
                'id' => 4,
                'name' => 'Vibol Heng',
                'email' => 'vibol.heng@bluetech.com',
                'role' => 'cashier',
                'status' => 'active',
                'last_login' => '2024-11-25 10:05',
                'created_at' => '2024-03-18',
            ],
            [
                'id' => 5,
                'name' => 'Channary Sok',
                'email' => 'channary.sok@bluetech.com',
                'role' => 'cashier',
                'status' => 'inactive',
                'last_login' => '2024-10-30 14:22',
                'created_at' => '2024-04-05',
            ],
            [
                'id' => 6,
                'name' => 'Ratanak Vong',
                'email' => 'ratanak.vong@bluetech.com',
                'role' => 'cashier',
                'status' => 'active',
                'last_login' => '2024-11-24 19:15',
                'created_at' => '2024-05-22',
            ],
            [
                'id' => 7,
                'name' => 'Sopheak Ly',
                'email' => 'sopheak.ly@bluetech.com',
                'role' => 'cashier',
                'status' => 'active',
                'last_login' => '2024-11-23 11:30',
                'created_at' => '2024-06-11',
            ],
            [
                'id' => 8,
                'name' => 'Bopha Meas',
                'email' => 'bopha.meas@bluetech.com',
                'role' => 'cashier',
                'status' => 'inactive',
                'last_login' => '2024-09-12 08:00',
                'created_at' => '2024-07-02',
            ],
        ];
    }

    public static function getSummary()
    {
        $users = self::getUsers();

        return [
            'total' => count($users),
            'admins' => collect($users)->where('role', 'admin')->count(),
            'cashiers' => collect($users)->where('role', 'cashier')->count(),
            'active' => collect($users)->where('status', 'active')->count(),
        ];
    }

    public static function getSummaryCards()
    {
        $summary = self::getSummary();

        return [
            [
                'title' => 'Total Users',
                'value' => $summary['total'],
                'icon' => 'fa-solid fa-users',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => 'up',
                'percentage' => '2.0%',
                'period' => 'vs last month',
            ],
            [
                'title' => 'Admins',
                'value' => $summary['admins'],
                'icon' => 'fa-solid fa-user-shield',
                'iconBg' => '#8B5CF6',
                'iconColor' => '#8B5CF6',
                'trend' => 'up',
                'percentage' => '0.0%',
                'period' => 'no change',
            ],
            [
                'title' => 'Cashiers',
                'value' => $summary['cashiers'],
                'icon' => 'fa-solid fa-cash-register',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => '3.5%',
                'period' => 'vs last month',
            ],
            [
                'title' => 'Active Today',
                'value' => $summary['active'],
                'icon' => 'fa-solid fa-circle-check',
                'iconBg' => '#F59E0B',
                'iconColor' => '#D97706',
                'trend' => 'down',
                'percentage' => '1.2%',
                'period' => 'vs yesterday',
            ],
        ];
    }
}