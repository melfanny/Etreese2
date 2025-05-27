<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'deskripsi', 'image', 'price', 'stock_limit'];

    protected $attributes = [
        'stock_limit' => 10 // Default stock limit
    ];

    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function isLowStock($colorId, $sizeId)
    {
        $stock = $this->stocks()
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();
            
        return $stock ? $stock->quantity <= $this->stock_limit : true;
    }
}
