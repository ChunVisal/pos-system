<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Chun Visal',
            'email' => 'admin@blue.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Cashier
        User::create([
            'name' => '@Cashier',
            'email' => 'cashier@blue.com',
            'password' => Hash::make('cashier123'),
            'role' => 'cashier',
            'status' => 'active',
        ]);
    }
}
