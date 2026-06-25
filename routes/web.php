<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root route - check if logged in first
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/cashier/pos');
    }

    return redirect('/login');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('admin.inventory');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/customer', [AdminController::class, 'customer'])->name('admin.customer');
    Route::get('/activitylog', [AdminController::class, 'activitylog'])->name('admin.activitylog');
});

// Cashier Routes
Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/cashier/pos', [CashierController::class, 'pos'])->name('cashier.pos');
});

// Auth routes (already there)
require __DIR__.'/auth.php';
