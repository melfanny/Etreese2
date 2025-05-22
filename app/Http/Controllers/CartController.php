<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();

    if ($cart) {
        $cart->increment('quantity');
    } else {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => 1,
        ]);
    }

    return redirect()->route('cart.index')->with('success', 'Product added to cart.');
}

public function index()
{
    $carts = Cart::with('product')->where('user_id', Auth::id())->get();
    return view('cart', compact('carts'));
}

public function removeFromCart($id)
{
    $cart = Cart::findOrFail($id);
    $cart->delete();
    return back()->with('success', 'Item removed.');
}

public function removeSelected(Request $request)
{
    $cartIds = $request->input('cart_ids', []);

    if (count($cartIds)) {
        Cart::where('user_id', Auth::id())->whereIn('id', $cartIds)->delete();
        return back()->with('success', 'Item terpilih berhasil dihapus.');
    }

    return back()->with('error', 'Tidak ada item yang dipilih.');
}

public function decrement($id)
{
    $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->first();

    if ($cart) {
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete(); // Hapus jika jumlah sudah 1
        }
    }

    return back();
}


public function increment($id)
{
    $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->first();

    if ($cart) {
        $cart->increment('quantity');
    }

    return back();
}

}
