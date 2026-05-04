<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder untuk Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@salza.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Seeder untuk Pelanggan
        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@salza.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'pelanggan',
            'phone' => '089876543210',
        ]);
    }
}
