<?php

namespace App\Providers;

use App\Models\PembacaanMeter;
use Illuminate\Support\ServiceProvider;
use App\Observers\PembacaanMeterObserver;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PembacaanMeter::observe(PembacaanMeterObserver::class);
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin' ? Response::allow() : Response::deny('Hanya admin yg bisa mengakses halaman ini');
        });
    }
}
