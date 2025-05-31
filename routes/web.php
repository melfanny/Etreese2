<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;


Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

use App\Models\Home;

use App\Models\Product;

Route::get('/', function () {
    $home = Home::first();
    $products = Product::select(['id', 'name', 'image', 'price'])->get();
    return view('home', compact('home', 'products'));
})->name('home');


Route::get('/Products', [UserProductController::class, 'index'])->name('products'); //menampilkan katalog produk pelanggan


// Route::get('/Cart', function () {
//     return view('cart');
// })->name('cart');


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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('message', [App\Http\Controllers\MessageController::class, 'index'])->name('admin.message');
});
#Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.products_admin'); // menampilkan semua produk
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create'); // form tambah produk
    Route::post('products/create', [ProductController::class, 'store'])->name('products.store'); // simpan produk baru
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // form edit produk
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');//update produk
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // hapus produk
    Route::get('stock', [App\Http\Controllers\Admin\StockController::class, 'index'])->name('stock');
    Route::put('stock-limit/{productId}/{colorId}/{sizeId}', [App\Http\Controllers\Admin\StockController::class, 'updateStockLimit'])->name('update.stock.limit');

    Route::get('message', [App\Http\Controllers\MessageController::class, 'index'])->name('admin.messages');
});

Route::get('/products/{id}', [UserProductController::class, 'show'])->name('product.productdetails'); // menampilkan produk detal
Route::get('/products', [UserProductController::class, 'index'])->name('products.index'); // menampilkan produk berdasarkan index ketika melakukan search

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // menampilkan isi page cart
    Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add'); // tambah produk ke cart
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // hapus semua produk dari cart
    Route::delete('/cart/remove-selected', [CartController::class, 'removeSelected'])->name('cart.removeSelected'); // menghapus produk tertentu dari cart
    Route::get('/cart/decrement/{id}', [CartController::class, 'decrement'])->name('cart.decrement'); //menambah kuantitas produk
    Route::get('/cart/increment/{id}', [CartController::class, 'increment'])->name('cart.increment'); // mengurangi kuantitas produk 
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index'); // akses notifikasi 
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// User order routes
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/payment/{order}', [OrderController::class, 'payment'])->name('order.payment');
    Route::post('/payment/{order}/pay', [OrderController::class, 'pay'])->name('order.pay');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('order.myorders');
    Route::post('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');
});

// Admin order routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::post('orders/{order}/confirm', [AdminOrderController::class, 'confirmPayment'])->name('admin.orders.confirm');
    Route::post('orders/{order}/ship', [AdminOrderController::class, 'ship'])->name('admin.orders.ship');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/home', [HomeController::class, 'edit'])->name('home.edit');
    Route::post('/admin/home/update', action: [HomeController::class, 'update'])->name('home.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index'); // akses notifikasi 
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

Route::middleware(['auth'])->group(function () {
    Route::get('addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout'); // display checkout page
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout'); // handle checkout submission
});

require __DIR__ . '/auth.php';
