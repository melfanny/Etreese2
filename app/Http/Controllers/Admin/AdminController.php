<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman utama admin
    public function index()
    {
        return view('admin.home_admin');
    }

    // Halaman Orders
    public function orders()
    {
        return view('admin.orders');
    }

    // Halaman Products
    public function products_admin()
    {
        return view('admin.products_admin');
    }

    // Halaman Sales
    public function sales()
    {
        return view('admin.sales');
    }

    // Halaman Stock
    public function stock()
    {
        return view('admin.stock');
    }

    // Halaman Profile admin
    public function profile()
    {
        return view('admin.profile');
    }
}
