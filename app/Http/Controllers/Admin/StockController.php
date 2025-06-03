<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                    
                    // Only add alert if stock limit is greater than 0 and current stock is less than or equal to limit
                    if ($stockLimit > 0 && $currentStock <= $stockLimit) {
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
            
            // Get the product with its colors and sizes
            $product = Product::with(['colors', 'sizes'])->findOrFail($productId);
            
            // Get the first available color or use null if no colors exist
            $defaultColorId = $product->colors->first()?->id;
            
            if (!$defaultColorId) {
                return redirect()->back()->with('error', 'Produk harus memiliki minimal satu warna!');
            }
            
            foreach ($stockLimits as $sizeId => $limit) {
                // Skip if sizeId is not numeric
                if (!is_numeric($sizeId)) continue;
                
                // Find or create stock record for this size and color
                $stock = Stock::firstOrNew([
                    'product_id' => $productId,
                    'size_id' => $sizeId,
                    'color_id' => $defaultColorId
                ]);
                
                // Set quantity to 0 if it's a new record
                if (!$stock->exists) {
                    $stock->quantity = 0;
                }
                
                $stock->stock_limit = $limit;
                $stock->save();
            }
            
            return redirect()->back()->with('success', 'Stock limit berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating stock limits', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui stock limit: ' . $e->getMessage());
        }
    }
} 