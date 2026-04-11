<?php

namespace App\Providers;


use App\Models\Vendor;
use App\Observers\VendorObserver;
use App\Repositories\DataInterface\VendorRepositoryInterface;
use App\Repositories\VendorRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            VendorRepositoryInterface::class,
            VendorRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Vendor::observe(VendorObserver::class);
    }
}
