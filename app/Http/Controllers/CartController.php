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
        // Validasi input size_id yang harus diisi oleh pelanggan
        $request->validate([
            'size_id' => 'required|exists:sizes,id',
        ]);

        $sizeId = $request->size_id;

        // Cari produk beserta warna (colors)
        $product = Product::with('colors')->findOrFail($id);

        // Ambil color_id dari database
        $colorId = $product->colors->first()?->id ?? null;

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->where('size_id', $sizeId)
            ->where('color_id', $colorId)->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'color_id' => $colorId,
                'size_id' => $sizeId,
                'quantity' => 1,
            ]);
        }
        // setelah validasi sesuai maka produk berhasil ditambahkan ke cart dan di direct ke page cart
        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    // menampilkan informasi produk di cart 
    public function index()
    {
        $carts = Cart::with('product', 'color', 'size')->where('user_id', Auth::id())->get();
        return view('cart', compact('carts'));
    }

    // menghapus semua produk 
    public function removeFromCart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return back()->with('success', 'Item removed.');
    }

    // menghapus produk tertentu yang di checklist di cart. Jika tidak ada yg di checklist maka akan menampilkan pesan error
    public function removeSelected(Request $request)
    {
        $cartIds = $request->input('cart_ids', []);

        if (count($cartIds)) {
            Cart::where('user_id', Auth::id())->whereIn('id', $cartIds)->delete();
            return back()->with('success', 'Item terpilih berhasil dihapus.');
        }

        return back()->with('error', 'Tidak ada item yang dipilih.');
    }

    // mengurangi kuantitas produk di database ketika tombol - ditekan
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

    // menambahkan kuantitas produk di database ketika tombol + ditekan
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

    public function checkout()
    {
        $carts = Cart::with('product', 'color', 'size')->where('user_id', Auth::id())->get();
        return view('checkout', compact('carts'));
    }
}
