<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.products_admin', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.products_admin')->with('success', 'Produk berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric|min:0',
            'colors' => 'required|array',
            'colors.*' => 'required|string',
            'sizes' => 'required|array',
            'sizes.*' => 'required|string',
            'stocks' => 'required|array',
            'stocks.*' => 'array',
            'stocks.*.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            // Jika ada gambar baru, hapus gambar lama dan simpan gambar baru
            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $request->file('image')->store('products', 'public');
            }

            // Update data produk
            $product->name = $request->name;
            $product->deskripsi = $request->deskripsi;
            $product->price = $request->price;
            $product->save();

            // Hapus warna, ukuran, dan stok lama dulu (kalau kamu ingin update total)
            Color::where('product_id', $product->id)->delete();
            Size::where('product_id', $product->id)->delete();
            Stock::where('product_id', $product->id)->delete();

            // Simpan warna baru
            $colors = [];
            foreach ($request->colors as $colorName) {
                $color = Color::create([
                    'product_id' => $product->id,
                    'name' => $colorName,
                ]);
                $colors[$colorName] = $color->id;
            }

            // Simpan ukuran baru
            $sizes = [];
            foreach ($request->sizes as $sizeName) {
                $size = Size::create([
                    'product_id' => $product->id,
                    'name' => $sizeName,
                ]);
                $sizes[$sizeName] = $size->id;
            }

            // Simpan stok baru
            foreach ($request->stocks as $colorName => $sizesArray) {
                foreach ($sizesArray as $sizeName => $quantity) {
                    if (isset($colors[$colorName]) && isset($sizes[$sizeName])) {
                        Stock::create([
                            'product_id' => $product->id,
                            'color_id' => $colors[$colorName],
                            'size_id' => $sizes[$sizeName],
                            'quantity' => $quantity,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.products_admin')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }



    public function create()
    {
        return view('admin.products.add_new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric|min:0',
            'colors' => 'required|array',      // <=== ini
            'colors.*' => 'required|string',   // <=== dan ini
            'sizes' => 'required|array',
            'sizes.*' => 'required|string',
            'stocks' => 'required|array',
            'stocks.*' => 'array',
            'stocks.*.*' => 'required|integer|min:0',
        ]);


        DB::beginTransaction();

        try {
            // Upload gambar jika ada
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            // Buat produk
            $product = Product::create([
                'name' => $request->name,
                'deskripsi' => $request->deskripsi,
                'image' => $imagePath,
                'price' => $request->price,
            ]);

            // Simpan warna
            $colors = [];
            foreach ($request->colors as $colorName) {
                $color = Color::create([
                    'product_id' => $product->id,
                    'name' => $colorName,
                ]);
                $colors[$colorName] = $color->id; // simpan id untuk mapping stok nanti
            }

            // Simpan ukuran
            $sizes = [];
            foreach ($request->sizes as $sizeName) {
                $size = Size::create([
                    'product_id' => $product->id,
                    'name' => $sizeName,
                ]);
                $sizes[$sizeName] = $size->id; // simpan id untuk mapping stok nanti
            }

            /*
            Format $request->stocks harus berupa array multi dimensi seperti ini:

            [
              'Merah' => [
                  'S' => 10,
                  'M' => 5
              ],
              'Biru' => [
                  'S' => 7,
                  'L' => 3
              ]
            ]
            */

            // Simpan stok berdasarkan warna & ukuran
            foreach ($request->stocks as $colorName => $sizesArray) {
                foreach ($sizesArray as $sizeName => $quantity) {
                    if (isset($colors[$colorName]) && isset($sizes[$sizeName])) {
                        Stock::create([
                            'product_id' => $product->id,
                            'color_id' => $colors[$colorName],
                            'size_id' => $sizes[$sizeName],
                            'quantity' => $quantity,
                        ]);
                    }
                }
            }

            DB::commit();

            // Untuk create
            return redirect()->route('admin.products.products_admin')->with('success', 'Produk berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Produk gagal dibuat! ' . $e->getMessage());
        }
    }
}
