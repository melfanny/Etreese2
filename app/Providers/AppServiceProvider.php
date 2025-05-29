<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;

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
    public function boot(): void
    {
        // ketika ada badge orderan yang masuk (sudah dibayar) maka akan tetap tampil ketika pengguna tidak sedang di page order
        View::composer('layouts.admin.navigation_admin', function ($view) {
        $newPaidOrdersCount = Order::where('status', 'paid')->count();
        $view->with('newPaidOrdersCount', $newPaidOrdersCount);
    });
    }
}
