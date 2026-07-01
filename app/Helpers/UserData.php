<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;

class UserData
{
    public static function getSummaryCards()
    {

        return [
            [
                'title' => 'Total Users',
                'value' => User::count(),
                'icon' => 'fa-solid fa-users',
                'iconBg' => '#0F6E8C',
                'iconColor' => '#0F6E8C',
                'trend' => 'up',
                'percentage' => '2.0%',
                'period' => 'last month',
            ],
            [
                'title' => 'Admins',
                'value' => User::where('role', 'admin')->count(),
                'icon' => 'fa-solid fa-user-shield',
                'iconBg' => '#8B5CF6',
                'iconColor' => '#8B5CF6',
                'trend' => 'up',
                'percentage' => '0.0%',
                'period' => 'no change',
            ],
            [
                'title' => 'Cashiers',
                'value' => User::where('role', 'cashier')->count(),
                'icon' => 'fa-solid fa-cash-register',
                'iconBg' => '#10B981',
                'iconColor' => '#10B981',
                'trend' => 'up',
                'percentage' => '3.5%',
                'period' => 'last month',
            ],
            [
                'title' => 'Active Today',
                'value' => User::where('status', 'active')->count(),
                'icon' => 'fa-solid fa-circle-check',
                'iconBg' => '#F59E0B',
                'iconColor' => '#D97706',
                'trend' => 'down',
                'percentage' => '1.2%',
                'period' => 'yesterday',
            ],
        ];
    }

    public static function getUsers()
    {
        return User::orderByRaw("FIELD(role, 'admin', 'cashier')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                $user->last_login = $user->last_login ? Carbon::parse($user->last_login) : null;

                return $user;
            });
    }
}
