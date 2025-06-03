<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;

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
        // Share new paid orders count with admin navigation
        View::composer('layouts.admin.navigation_admin', function ($view) {
            $newPaidOrdersCount = Order::where('status', 'paid')->count();
            
            // Count low stock items
            $lowStockCount = 0;
            $products = Product::with(['colors', 'sizes', 'stocks'])->get();
            
            foreach ($products as $product) {
                $productColors = $product->colors->isNotEmpty() ? $product->colors : collect([null]);
                $productSizes = $product->sizes->isNotEmpty() ? $product->sizes : collect([null]);
                
                foreach($productColors as $color) {
                    foreach($productSizes as $size) {
                        $stock = $product->stocks()
                            ->when($color, fn($q) => $q->where('color_id', $color->id))
                            ->when($size, fn($q) => $q->where('size_id', $size->id))
                            ->first();
                        
                        $currentStock = $stock ? $stock->quantity : 0;
                        $stockLimit = $stock ? $stock->stock_limit : ($product->stock_limit ?? 0);
                        
                        // Only count if stock is less than or equal to limit AND limit is greater than 0
                        if($stockLimit > 0 && $currentStock <= $stockLimit) {
                            $lowStockCount++;
                        }
                    }
                }
            }
            
            $view->with([
                'newPaidOrdersCount' => $newPaidOrdersCount,
                'lowStockCount' => $lowStockCount
            ]);
        });
    }
}
