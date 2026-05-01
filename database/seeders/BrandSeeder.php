<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Adidas', 'Fila', 'Puma', 'Champion', 'Vans',
            'Nike', 'Converse', 'New Balance', 'Reebok', 'Under Armour',
        ];

        foreach ($brands as $name) {
            Brand::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'image' => null, // Nanti bisa diisi lewat form
            ]);
        }
    }
}