<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function inventory()
    {
        // Fetch raw collections directly from your database tables
        $categories = Categories::all();
        $products = Product::with('category')->get();

        // Send them cleanly to your UI file
        return view('admin.inventory', compact('categories', 'products'));
    }

    public function users()
    {
        return view('admin.users');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function customer()
    {
        return view('admin.customer');
    }

    public function activitylog()
    {
        return view('admin.activitylog');
    }
}
