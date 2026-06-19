<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('kategoris.id', 'kategoris.name', DB::raw('COUNT(produks.id) as produk_count'))
                        ->leftJoin('produks', 'kategoris.id', '=', 'produks.kategori_id') 
                        ->groupBy('kategoris.id', 'kategoris.name')
                        ->orderBy('kategoris.name')
                        ->get();

        $produk = Product::with(['category', 'brand'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(12)
                        ->get();

        return view('front.landing', [
            'kategori'    => $kategori,
            'produk'      => $produk,
            'provinsi'    => $this->provinsiList(),
            'kurir'       => ['jne' => 'JNE', 'jnt' => 'J&T', 'sicepat' => 'SiCepat'],
            'ongkirRates' => $this->ongkirRates(),
        ]);
    }

    public function produkDetail($id)
    {
        $produk = Product::with(['category', 'brand', 'images'])->findOrFail($id);

        $mainImage = null;
        if ($produk->thumbnail) {
            $mainImage = str_starts_with($produk->thumbnail, 'http')
                ? $produk->thumbnail
                : asset('storage/' . $produk->thumbnail);
        }

        $allImages = [];
        if ($produk->images && $produk->images->count()) {
            foreach ($produk->images as $img) {
                $path = $img->image ?? $img->file ?? '';
                if ($path) {
                    $allImages[] = [
                        'id'  => $img->id,
                        'url' => str_starts_with($path, 'http') ? $path : asset('storage/' . $path),
                    ];
                }
            }
        }
        if (!$mainImage && count($allImages)) {
            $mainImage = $allImages[0]['url'];
        }

        // FIX: Mengambil gambar dari kolom 'image' secara manual
        if (!$mainImage && $produk->image) {
            $mainImage = str_starts_with($produk->image, 'http')
                ? $produk->image
                : asset('storage/' . $produk->image);
        }

        return response()->json([
            'data' => [
                'id'          => $produk->id,
                'name'        => $produk->name,
                'slug'        => $produk->slug,
                'description' => $produk->description,
                'price'       => $produk->price,
                'old_price'   => $produk->old_price,
                'stock'       => $produk->stock,
                'sizes'       => [],
                'colors'      => [],
                'rating'      => 0,
                'terjual'     => 0,
                'is_active'   => $produk->is_active,
                'category'    => $produk->category,
                'brand'       => $produk->brand,
                'images'      => count($allImages) ? $allImages : [['id' => $produk->id, 'url' => $mainImage]],
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