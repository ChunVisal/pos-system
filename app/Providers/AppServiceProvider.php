<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
        public function boot()
    {
        Blade::component('skeleton.product-skeleton', \App\View\Components\Skeleton\ProductSkeleton::class);
        Blade::component('skeleton.inventory-skeleton', \App\View\Components\Skeleton\InventorySkeleton::class);
        Blade::component('skeleton.users-skeleton', \App\View\Components\Skeleton\UsersSkeleton::class);
        Blade::component('skeleton.customers-skeleton', \App\View\Components\Skeleton\CustomersSkeleton::class);
        Blade::component('skeleton.reports-skeleton', \App\View\Components\Skeleton\ReportsSkeleton::class);
        Blade::component('skeleton.activity-skeleton', \App\View\Components\Skeleton\ActivitySkeleton::class);
        Blade::component('skeleton.settings-skeleton', \App\View\Components\Skeleton\SettingsSkeleton::class);
    }
}
