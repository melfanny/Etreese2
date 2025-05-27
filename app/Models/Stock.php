<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['product_id', 'color_id', 'size_id', 'quantity', 'stock_limit'];

    protected $attributes = [
        'stock_limit' => null // Will use product's default limit if null
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function getEffectiveStockLimit()
    {
        return $this->stock_limit ?? $this->product->stock_limit;
    }
}
