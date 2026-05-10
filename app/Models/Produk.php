<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'brand_id', 
        'kategori_id', 
        'subcategory_id', 
        'subsubcategory_id', 
        'price', 
        'thumbnail', 
        'sku', 
        'weight', 
        'old_price', 
        'stock', 
        'sizes', 
        'colors', 
        'image', 
        'is_active', 
        'is_new', 
        'is_best_seller'
    ];

    // Cast array otomatis untuk sizes & colors
    protected $casts = [
        'sizes'  => 'array',
        'colors' => 'array',
    ];

    // === RELASI ===
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // === ACCESSOR GAMBAR (Otomatis bikin URL) ===
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        // Ganti dengan path gambar default jika gambar kosong
        return asset('images/default-product.png'); 
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::url($this->thumbnail);
        }
        return $this->image_url; // Fallback ke gambar utama jika thumbnail kosong
    }
}