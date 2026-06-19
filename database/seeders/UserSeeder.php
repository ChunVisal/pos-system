<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
            'name' => 'Admin',
            'email' => 'admin@blue.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

         // Cashier
        User::create([
            'name' => 'Cashier',
            'email' => 'cashier@blue.com',
            'password' => Hash::make('cashier123'),
            'role' => 'cashier',
        ]);
    }
}
