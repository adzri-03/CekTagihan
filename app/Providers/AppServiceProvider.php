<?php

namespace App\Providers;

use App\Models\PembacaanMeter;
use Illuminate\Support\ServiceProvider;
use App\Observers\PembacaanMeterObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\Barryvdh\DomPDF\ServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PembacaanMeter::observe(PembacaanMeterObserver::class);
    }
}
