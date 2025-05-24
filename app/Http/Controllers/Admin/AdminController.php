<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Home;

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

    public function sales()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return view('admin.sales');
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
