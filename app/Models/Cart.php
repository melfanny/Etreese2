<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'color_id', 'size_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // relasi tabel color dan size
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
