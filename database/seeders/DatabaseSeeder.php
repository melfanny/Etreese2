<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User biasa
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'users',
                'password' => Hash::make('user123'),
            ]);
        }

        // Admin
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admins',
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
