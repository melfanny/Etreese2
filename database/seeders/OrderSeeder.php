<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Ambil user yang sudah ada
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $user = User::factory()->create();
        }

        // Buat product jika belum ada
        $product = Product::first() ?? Product::factory()->create();

        // Buat order
        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'total' => 150000,
            'status' => 'confirmation',
        ]);
    }
}
