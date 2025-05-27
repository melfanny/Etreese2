<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        // Load products with their relations and ensure they exist
        $products = Product::with([
            'colors' => function($query) {
                $query->whereNotNull('id');
            },
            'sizes' => function($query) {
                $query->whereNotNull('id');
            },
            'stocks' => function($query) {
                $query->whereNotNull('id');
            }
        ])->get();
        
        // Collect stock limit alerts
        $stockLimitAlerts = collect();
        foreach ($products as $product) {
            // Skip if product has no colors or sizes
            if (!$product->colors || !$product->sizes) {
                continue;
            }

            foreach ($product->colors as $color) {
                // Skip if color is null
                if (!$color) {
                    continue;
                }

                foreach ($product->sizes as $size) {
                    // Skip if size is null
                    if (!$size) {
                        continue;
                    }

                    $stock = $product->stocks()
                        ->where('color_id', $color->id)
                        ->where('size_id', $size->id)
                        ->first();
                    
                    $currentStock = $stock ? $stock->quantity : 0;
                    $stockLimit = $stock ? $stock->stock_limit : ($product->stock_limit ?? 0);
                    
                    if ($currentStock <= $stockLimit) {
                        $stockLimitAlerts->push((object)[
                            'product_name' => $product->name,
                            'color_name' => $color->name,
                            'size_name' => $size->name,
                            'stock' => $currentStock,
                            'stock_limit' => $stockLimit
                        ]);
                    }
                }
            }
        }

        return view('admin.stock', compact('products', 'stockLimitAlerts'));
    }

    public function updateStockLimit(Request $request, $productId)
    {
        try {
            $stockLimits = $request->input('stock_limit', []);
            if (!is_array($stockLimits)) {
                // Fallback: single value (old form)
                $stockLimits = [$request->input('variant_key', '0-0') => $request->input('stock_limit')];
            }
            foreach ($stockLimits as $variantKey => $limit) {
                [$colorId, $sizeId] = explode('-', $variantKey);
                $stock = \App\Models\Stock::where('product_id', $productId)
                    ->where('color_id', $colorId)
                    ->where('size_id', $sizeId)
                    ->first();
                if ($stock) {
                    $stock->stock_limit = $limit;
                    $stock->save();
                } else {
                    \App\Models\Stock::create([
                        'product_id' => $productId,
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'quantity' => 0,
                        'stock_limit' => $limit
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Stock limit berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating stock limits', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui stock limit: ' . $e->getMessage());
        }
    }
} 