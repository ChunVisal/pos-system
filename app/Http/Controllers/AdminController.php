<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $start = $request->start_date ?? now()->subDays(14)->format('Y-m-d');
        $end = $request->end_date ?? now()->format('Y-m-d');

        return view('admin.dashboard', [
            'start' => $start,
            'end' => $end,
            'summaryCards' => DashboardController::getSummaryCards(),
            'topProducts' => DashboardController::getTopProducts(),
            'topCategories' => DashboardController::getTopCategories(),
            'topCashiers' => DashboardController::getTopCashiers(),
            'salesChart' => DashboardController::getSalesChart($start, $end),
            'paymentBreakdown' => DashboardController::getPaymentBreakdown(),
        ]);
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

    public function customers()
    {
        return view('admin.customers');
    }

    public function activitylog()
    {
        return view('admin.activitylog');
    }
}
