<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\Size;
use App\Models\Stock;

class OrderController extends Controller
{
    // Checkout: buat order baru
    public function checkout(Request $request)
    {

        if (empty($request->cart_ids)) {
            return back()->with('error', 'Pilih setidaknya satu produk untuk checkout.');
        }

        $cartIds = $request->cart_ids;

        if (empty($cartIds) || !is_array($cartIds)) {
            return back()->with('error', 'Pilih setidaknya satu produk untuk checkout.');
        }
        $carts = \App\Models\Cart::whereIn('id', $cartIds)->with('product', 'size', 'color')->get();

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
            'product_id' => $carts->first()->product_id, // keep first product_id for compatibility
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

        return redirect()->route('order.payment', $order);
    }

    // Halaman pembayaran
    public function payment(Order $order)
    {
        if ($order->user_id != Auth::id())
            abort(403);

        // Pass only the order to the view
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
    public function myOrders(Request $request)
    {
        $status = $request->get('status', 'waiting_payment'); // default = waiting_payment

        $validStatuses = ['waiting_payment', 'paid', 'processed', 'shipped', 'completed'];

        // Validasi agar hanya status yang valid diproses
        if (!in_array($status, $validStatuses)) {
            abort(404); // atau bisa redirect ke default
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
        if ($order->user_id != Auth::id())
            abort(403);
        if ($order->status !== 'shipped')
            abort(403);

        // Start transaction to ensure data consistency
        DB::beginTransaction();
        try {
            // Update order status
            $order->update(['status' => 'completed']);

            // Reduce stock for each item in the order
            foreach ($order->checkout_data as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Find the color and size IDs
                $color = Color::where('product_id', $product->id)
                    ->where('name', $item['color'])
                    ->first();
                $size = Size::where('product_id', $product->id)
                    ->where('name', $item['size'])
                    ->first();

                if ($color && $size) {
                    // Find and update the stock
                    $stock = Stock::where('product_id', $product->id)
                        ->where('color_id', $color->id)
                        ->where('size_id', $size->id)
                        ->first();

                    if ($stock) {
                        // Ensure we don't go below 0
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
