<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
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

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/by-category', [ProductController::class, 'byCategory'])
        ->name('admin.products.byCategory');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-delete');

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
