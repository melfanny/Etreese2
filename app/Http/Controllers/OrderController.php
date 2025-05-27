<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Checkout: buat order baru
    public function checkout(Request $request)
    {

        if (empty($request->cart_ids)) {
            return back()->with('error', 'Pilih setidaknya satu produk untuk checkout.');
        }

        $cartIds = $request->cart_ids;
        if (!is_array($cartIds)) {
            $cartIds = explode(',', $cartIds);
        }

        if (empty($cartIds) || $cartIds[0] === '') {
            return back()->with('error', 'Pilih setidaknya satu produk untuk checkout.');
        }

        $carts = \App\Models\Cart::whereIn('id', $cartIds)->with('product')->get();

        // Contoh: hanya satu produk, jika multi-produk silakan buat order_items
        $cart = $carts->first();
        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $cart->product_id,
            'total' => $cart->product->price * $cart->quantity,
            'status' => 'waiting_payment',
            'shipping_method' => $request->shipping_method[$cart->id] ?? null,
            'payment_method' => $request->payment_method[$cart->id] ?? null,
        ]);
        \App\Models\Cart::whereIn('id', $cartIds)->delete();

        return redirect()->route('order.payment', $order);
    }

    // Halaman pembayaran
    public function payment(Order $order)
    {
        if ($order->user_id != Auth::id())
            abort(403);
        return view('orders.payment', compact('order'));
    }

    // Simulasi bayar
    public function pay(Order $order)
    {
        if ($order->user_id != Auth::id())
            abort(403);
        $order->update(['status' => 'paid']);
        return redirect()->route('order.myorders')->with('success', 'Pembayaran berhasil!');
    }

    // Lihat pesanan user
    public function myOrders()
    {
        $orders = Order::with('product')->where('user_id', Auth::id())->latest()->get();
        return view('orders.myorders', compact('orders'));
    }

    // User klik pesanan diterima
    public function complete(Order $order)
    {
        if ($order->user_id != Auth::id())
            abort(403);
        if ($order->status !== 'shipped')
            abort(403);
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Pesanan selesai!');
    }

}
