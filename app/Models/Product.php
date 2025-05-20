<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'deskripsi', 'image', 'price'];

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
}
