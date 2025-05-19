<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User biasa
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'users',
            'password' => Hash::make('user123'),
        ]);

        // Admin
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admins',
            'password' => Hash::make('admin123'),
        ]);
    }
}
