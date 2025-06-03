<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    // Checkout: buat order baru
    public function checkout(Request $request)
    {
        if (empty($request->cart_ids) || !is_array($request->cart_ids)) {
            return back()->with('error', 'Pilih setidaknya satu produk untuk checkout.');
        }

        $cartIds = $request->cart_ids;

        $carts = \App\Models\Cart::whereIn('id', $cartIds)
            ->with('product', 'size', 'color')
            ->get();

        // Validasi stok untuk setiap item di cart
        foreach ($carts as $cart) {
            $stock = \App\Models\Stock::where('product_id', $cart->product_id)
                ->where('color_id', $cart->color_id)
                ->where('size_id', $cart->size_id)
                ->first();

            if (!$stock || $stock->quantity < $cart->quantity) {
                $productName = $cart->product->name;
                $colorName = $cart->color->name ?? 'N/A';
                $sizeName = $cart->size->name ?? 'N/A';
                $availableStock = $stock ? $stock->quantity : 0;
                
                return back()->with('error', "Stok tidak mencukupi untuk produk: {$productName} ({$colorName} - {$sizeName}). Stok tersedia: {$availableStock}");
            }
        }

        // Hitung total harga seluruh produk di keranjang
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        // Prepare checkout data array for all products
        $checkoutData = [];
        foreach ($carts as $cart) {
            $checkoutData[] = [
                'product_id' => $cart->product_id,
                'product_name' => $cart->product->name,
                'image' => $cart->product->image,
                'price' => $cart->product->price,
                'quantity' => $cart->quantity,
                'size' => $cart->size->name ?? null,
                'color' => $cart->color->name ?? null,
            ];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $carts->first()->product_id,
            'total' => $totalPrice,
            'status' => 'waiting_payment',
            'shipping_method' => $request->shipping_method ?? null,
            'payment_method' => $request->payment_method ?? null,
            'address_id' => $request->address_id ?? null,
            'checkout_data' => $checkoutData,
        ]);

        if (!$order) {
            return back()->with('error', 'Failed to create order. Please try again.');
        }

        \App\Models\Cart::whereIn('id', $cartIds)->delete();

        return redirect()->route('order.payment', ['order' => $order->id]);
    }

    // Halaman pembayaran
    public function payment(Order $order)
    {
        if ($order->user_id != Auth::id())
            abort(403);

        // Set Midtrans config
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat Snap Token jika belum ada
        if (!$order->snap_token) {
            $params = [
                'transaction_details' => [
                    'order_id' => 'ETREESE-' . $order->id . '-' . time(),
                    'gross_amount' => $order->total,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];
            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
        }

        return view('orders.payment', compact('order'));
    }

    // API untuk ambil snap_token (opsional)
    public function getSnapToken(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        return response()->json([
            'snap_token' => $order->snap_token
        ]);
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
    public function myOrders(Request $request)
    {
        $status = $request->get('status', 'waiting_payment');
        $validStatuses = ['waiting_payment', 'paid', 'processed', 'shipped', 'completed'];

        if (!in_array($status, $validStatuses)) {
            abort(404);
        }

        $orders = Order::with('product')
            ->where('user_id', Auth::id())
            ->where('status', $status)
            ->latest()
            ->get();

        return view('orders.myorders', compact('orders', 'status'));
    }

    // User klik pesanan diterima
    public function complete(Order $order)
    {
        if ($order->user_id != Auth::id() || $order->status !== 'shipped')
            abort(403);

        DB::beginTransaction();
        try {
            $order->update(['status' => 'completed']);

            foreach ($order->checkout_data as $item) {
                $product = Product::findOrFail($item['product_id']);

                $color = Color::where('product_id', $product->id)
                    ->where('name', $item['color'])
                    ->first();

                $size = Size::where('product_id', $product->id)
                    ->where('name', $item['size'])
                    ->first();

                if ($color && $size) {
                    $stock = Stock::where('product_id', $product->id)
                        ->where('color_id', $color->id)
                        ->where('size_id', $size->id)
                        ->first();

                    if ($stock) {
                        $newQuantity = max(0, $stock->quantity - $item['quantity']);
                        $stock->update(['quantity' => $newQuantity]);
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Pesanan selesai!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyelesaikan pesanan: ' . $e->getMessage());
        }
    }
}
