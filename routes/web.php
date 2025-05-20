<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Home', function () {
    return view('home');
})->name('home');


Route::get('/Products', [UserProductController::class, 'index'])->name('products');


Route::get('/Cart', function () {
    return view('cart');
})->name('cart');

Route::get('/AboutUs', function () {
    return view('aboutus');
})->name('aboutus');



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');
Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->middleware(['auth', 'verified'])->name('user.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes admin
//Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
Route::prefix('admin')->group(function () {
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('home', [AdminController::class, 'index'])->name('admin.home');
    Route::get('orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('sales', [AdminController::class, 'sales'])->name('admin.sales');
    Route::get('stock', [AdminController::class, 'stock'])->name('admin.stock');
    Route::get('products', [AdminController::class, 'products_admin'])->name('admin.products.products_admin');
    Route::get('add_new', [ProductController::class, 'create'])->name('admin.products.create');
});
#Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.products_admin'); // menampilkan semua produk
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create'); // form tambah produk
    Route::post('products/create', [ProductController::class, 'store'])->name('products.store'); // simpan produk baru
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // form edit produk
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // hapus produk
});

Route::get('/products/{id}', [UserProductController::class, 'show'])->name('product.productdetails');


require __DIR__ . '/auth.php';
