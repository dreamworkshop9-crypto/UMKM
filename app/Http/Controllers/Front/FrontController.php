<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('produk')->orderBy('name')->get();
        
        // HAPUS 'images' dari sini, karena gambar ada di kolom langsung
        $produk   = Produk::with(['kategori', 'brand'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(12)
                        ->get();

        return view('front.landing', [
            'kategori'    => $kategori,
            'produk'      => $produk,
            'provinsi'    => $this->provinsiList(),
            'kurir'       => ['jne' => 'JNE', 'jnt' => 'J&T', 'sicepat' => 'SiCepat'],
            'metodeBayar' => ['transfer' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'cod' => 'COD', 'qris' => 'QRIS'],
            'ongkirRates' => $this->ongkirRates(),
        ]);
    }

    public function produkDetail($id)
    {
        // HAPUS 'images' dan 'variants' dari sini
        $produk = Produk::with(['kategori', 'brand'])->findOrFail($id);

        // Format response agar frontend tidak error (mengikuti struktur array images)
        return response()->json([
            'data' => [
                'id'          => $produk->id,
                'name'        => $produk->name,
                'slug'        => $produk->slug,
                'description' => $produk->description,
                'price'       => $produk->price,
                'old_price'   => $produk->old_price,
                'stock'       => $produk->stock,
                'sizes'       => $produk->sizes,
                'colors'      => $produk->colors,
                'is_active'   => $produk->is_active,
                'kategori'    => $produk->kategori,
                'brand'       => $produk->brand,
                
                // Dipaksa format array agar sesuai ekspektasi frontend Anda
                'images'      => [
                    [
                        'id'   => $produk->id,
                        'url'  => $produk->image_url, // Memakai accessor yang baru dibuat di Model
                    ]
                ],
            ]
        ]);
    }

    private function provinsiList(): array
    {
        return [
            'jawa-barat'   => 'Jawa Barat',
            'jawa-tengah'  => 'Jawa Tengah',
            'jawa-timur'   => 'Jawa Timur',
            'dki-jakarta'  => 'DKI Jakarta',
            'banten'       => 'Banten',
            'sumatera'     => 'Sumatera',
            'kalimantan'   => 'Kalimantan',
            'sulawesi'     => 'Sulawesi',
            'bali-ntt-ntb' => 'Bali / NTT / NTB',
            'papua-maluku' => 'Papua / Maluku',
        ];
    }

    private function ongkirRates(): array
    {
        return [
            'jawa-barat'   => ['jne' => 15000, 'jnt' => 12000, 'sicepat' => 10000],
            'jawa-tengah'  => ['jne' => 18000, 'jnt' => 15000, 'sicepat' => 13000],
            'jawa-timur'   => ['jne' => 20000, 'jnt' => 17000, 'sicepat' => 14000],
            'dki-jakarta'  => ['jne' => 10000, 'jnt' => 8000,  'sicepat' => 7000],
            'banten'       => ['jne' => 12000, 'jnt' => 10000, 'sicepat' => 9000],
            'sumatera'     => ['jne' => 30000, 'jnt' => 25000, 'sicepat' => 22000],
            'kalimantan'   => ['jne' => 40000, 'jnt' => 35000, 'sicepat' => 30000],
            'sulawesi'     => ['jne' => 45000, 'jnt' => 38000, 'sicepat' => 35000],
            'bali-ntt-ntb' => ['jne' => 35000, 'jnt' => 30000, 'sicepat' => 25000],
            'papua-maluku' => ['jne' => 60000, 'jnt' => 55000, 'sicepat' => 50000],
        ];
    }
}