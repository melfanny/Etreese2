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
     public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::select(['id', 'name', 'image', 'price']); // menampilkan nama, gambar, dan harga produk di katalog produk

        //  ini untuk melakukan pencarian pada search box supaya tidak case sensitive
        if ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"]);
        }

        $products = $query->get();
        // melakukan pencarian secara langsung di page product
        return view('products', compact('products', 'search'));
    }

    // menampilkan produk katalog yg di upload admin di page product pelanggan 
    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('product-details', compact('product')); // jika produk ditemukan, maka tampilkan
}
}

