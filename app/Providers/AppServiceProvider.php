<?php

namespace App\Providers;

use App\View\Components\Skeleton\ActivitySkeleton;
use App\View\Components\Skeleton\CustomersSkeleton;
use App\View\Components\Skeleton\InventorySkeleton;
use App\View\Components\Skeleton\ProductSkeleton;
use App\View\Components\Skeleton\ReportsSkeleton;
use App\View\Components\Skeleton\SettingsSkeleton;
use App\View\Components\Skeleton\UsersSkeleton;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        if (app()->environment('local')) {
            // Disable SSL verification for local dev
            $this->app->bind('cloudinary', function () {
                putenv('CURL_CA_BUNDLE=');
            });
        }
        Blade::component('skeleton.product-skeleton', ProductSkeleton::class);
        Blade::component('skeleton.inventory-skeleton', InventorySkeleton::class);
        Blade::component('skeleton.users-skeleton', UsersSkeleton::class);
        Blade::component('skeleton.customers-skeleton', CustomersSkeleton::class);
        Blade::component('skeleton.reports-skeleton', ReportsSkeleton::class);
        Blade::component('skeleton.activity-skeleton', ActivitySkeleton::class);
        Blade::component('skeleton.settings-skeleton', SettingsSkeleton::class);
    }
}
