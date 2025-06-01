<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Home;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Fungsi untuk mengecek apakah user admin
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admins';
    }

    public function index()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        $home = Home::first();

        return view('admin.home_admin', compact('home'));
    }

    public function orders()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return view('admin.orders');
    }

    public function products_admin()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return view('admin.products.products_admin');
    }

    public function sales(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        $period = $request->get('period', 'week'); // Default to week if not specified
        
        // Get all completed orders for the period
        $orders = Order::where('status', 'completed')
            ->when($period === 'week', function ($q) {
                return $q->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            })
            ->when($period === 'month', function ($q) {
                return $q->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
            })
            ->when($period === 'year', function ($q) {
                return $q->whereBetween('created_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ]);
            })
            ->get();

        // Get all products
        $products = Product::with(['colors', 'sizes'])->get();
        $detailedSales = [];

        foreach ($products as $product) {
            // Get all items for this product from all orders
            $productItems = $orders->flatMap(function($order) use ($product) {
                return collect($order->checkout_data)
                    ->filter(function($item) use ($product) {
                        return $item['product_id'] == $product->id;
                    });
            });

            if ($productItems->isNotEmpty()) {
                // Calculate total sales and income for this product
                $totalSold = $productItems->sum('quantity');
                $totalIncome = $productItems->sum(function($item) {
                    return $item['price'] * $item['quantity'];
                });

                // Get variant sales details
                $variantSales = $productItems
                    ->groupBy(function($item) {
                        return ($item['color'] ?? 'Unknown') . '|' . ($item['size'] ?? 'Unknown');
                    })
                    ->map(function($items) {
                        return [
                            'color' => $items->first()['color'] ?? 'Unknown',
                            'size' => $items->first()['size'] ?? 'Unknown',
                            'quantity' => $items->sum('quantity')
                        ];
                    })
                    ->sortBy(['color', 'size'])
                    ->values();

                // Calculate period sales
                $weekSold = $orders->filter(function($order) {
                    return $order->created_at->between(
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    );
                })->flatMap(function($order) use ($product) {
                    return collect($order->checkout_data)
                        ->filter(function($item) use ($product) {
                            return $item['product_id'] == $product->id;
                        });
                })->sum('quantity');

                $monthSold = $orders->filter(function($order) {
                    return $order->created_at->between(
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    );
                })->flatMap(function($order) use ($product) {
                    return collect($order->checkout_data)
                        ->filter(function($item) use ($product) {
                            return $item['product_id'] == $product->id;
                        });
                })->sum('quantity');

                $yearSold = $orders->filter(function($order) {
                    return $order->created_at->between(
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear()
                    );
                })->flatMap(function($order) use ($product) {
                    return collect($order->checkout_data)
                        ->filter(function($item) use ($product) {
                            return $item['product_id'] == $product->id;
                        });
                })->sum('quantity');

                $variantDetails = [];
                $currentColor = null;
                foreach ($variantSales as $variant) {
                    if ($currentColor !== $variant['color']) {
                        if ($currentColor !== null) {
                            $variantDetails[] = '';
                        }
                        $currentColor = $variant['color'];
                        $variantDetails[] = "<b>{$variant['color']}:</b>";
                    }
                    $variantDetails[] = "&nbsp;&nbsp;&nbsp;&nbsp;{$variant['size']}: {$variant['quantity']} pcs";
                }

                $detailedSales[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'week_sold' => $weekSold,
                    'month_sold' => $monthSold,
                    'year_sold' => $yearSold,
                    'total_income' => $totalIncome,
                    'total_sales' => $totalSold,
                    'variant_details' => $variantDetails
                ];
            }
        }

        return view('admin.sales', [
            'salesData' => $detailedSales,
            'currentPeriod' => $period
        ]);
    }

    public function stock()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return view('admin.stock');
    }

    public function profile()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return view('admin.profile');
    }
    public function home_admin()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return view('admin.home');
    }
}
