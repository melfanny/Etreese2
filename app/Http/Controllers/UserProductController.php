<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserProductController extends Controller
{
     public function index()
    {
        $products = Product::select(['id', 'name', 'image', 'price'])->get();
        return view('products', compact('products'));
    }
}
