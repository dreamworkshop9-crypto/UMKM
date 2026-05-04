<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PelangganDashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\PesananController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'register']);

// Public Storefront Routes
Route::get('/shop', [App\Http\Controllers\ProductController::class, 'index'])->name('shop');
Route::get('/product/{id}/{slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('/home', function() { return redirect('/shop'); })->name('home');

Route::middleware('auth')->group(function() {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    Route::post('/order/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/order/{invoice}', [App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
});
Route::post('/order/track', [App\Http\Controllers\OrderController::class, 'track'])->name('order.track');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::redirect('/pesanan', '/admin/pesanan/masuk');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan/masuk', [PesananController::class, 'masuk'])->name('pesanan.masuk');
    Route::get('/pesanan/konfirmasi/{id}', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    Route::get('/pesanan/dalam-perjalanan/{id}', [PesananController::class, 'dalam_perjalanan'])->name('pesanan.dalam_perjalanan');
    Route::get('/pesanan/dikemas/{id}', [PesananController::class, 'dikemas'])->name('pesanan.dikemas');
    Route::get('/pesanan/dikirim/{id}', [PesananController::class, 'dikirim'])->name('pesanan.dikirim');
    Route::get('/pesanan/selesai/{id}', [PesananController::class, 'selesai'])->name('pesanan.selesai');
    Route::get('/pesanan/dibatalkan/{id}', [PesananController::class, 'dibatalkan'])->name('pesanan.dibatalkan');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::prefix('api/brands')->name('brands.')->group(function () {
        Route::get('/',          [BrandController::class, 'list'])   ->name('list');
        Route::post('/',         [BrandController::class, 'store'])  ->name('store');
        Route::get('{brand}',    [BrandController::class, 'show'])   ->name('show');
        Route::put('{brand}',    [BrandController::class, 'update']) ->name('update');
        Route::delete('{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::prefix('api/kategori')->name('kategori.')->group(function () {
        Route::get('/',              [KategoriController::class, 'list'])   ->name('list');
        Route::post('/',             [KategoriController::class, 'store'])  ->name('store');
        Route::get('{kategori}',     [KategoriController::class, 'show'])   ->name('show');
        Route::put('{kategori}',     [KategoriController::class, 'update']) ->name('update');
        Route::delete('{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
    Route::prefix('api/produk')->name('produk.')->group(function () {
        Route::get('/',           [ProdukController::class, 'list'])   ->name('list');
        Route::get('/options',    [ProdukController::class, 'options']) ->name('options');
        Route::post('/',          [ProdukController::class, 'store'])  ->name('store');
        Route::get('{produk}',    [ProdukController::class, 'show'])   ->name('show');
        Route::put('{produk}',    [ProdukController::class, 'update']) ->name('update');
        Route::delete('{produk}', [ProdukController::class, 'destroy'])->name('destroy');
    });

    Route::get('/slider', [SliderController::class, 'index'])->name('slider');
    Route::prefix('api/slider')->name('slider.')->group(function () {
        Route::get('/',          [SliderController::class, 'list'])   ->name('list');
        Route::post('/',         [SliderController::class, 'store'])  ->name('store');
        Route::get('{slider}',    [SliderController::class, 'show'])   ->name('show');
        Route::put('{slider}',    [SliderController::class, 'update']) ->name('update');
        Route::delete('{slider}', [SliderController::class, 'destroy'])->name('destroy');
    });

    Route::get('/kupon', [KuponController::class, 'index'])->name('kupon');
    Route::prefix('api/kupon')->name('kupon.')->group(function () {
        Route::get('/',          [KuponController::class, 'list'])   ->name('list');
        Route::post('/',         [KuponController::class, 'store'])  ->name('store');
        Route::get('{kupon}',     [KuponController::class, 'show'])   ->name('show');
        Route::put('{kupon}',     [KuponController::class, 'update']) ->name('update');
        Route::delete('{kupon}', [KuponController::class, 'destroy'])->name('destroy');
    });

    Route::view('/wilayah', 'pages.placeholder', ['title' => 'Data Wilayah'])->name('wilayah');
    Route::view('/pembatalan', 'pages.placeholder', ['title' => 'Pembatalan'])->name('pembatalan');
    Route::view('/pengembalian', 'pages.placeholder', ['title' => 'Pengembalian'])->name('pengembalian');
    Route::view('/ulasan', 'pages.placeholder', ['title' => 'Ulasan'])->name('ulasan');
    Route::view('/stok', 'pages.placeholder', ['title' => 'Stok Produk'])->name('stok');
    Route::view('/users', 'pages.placeholder', ['title' => 'Data User'])->name('users');
    Route::view('/admins', 'pages.placeholder', ['title' => 'Data Admin'])->name('admins');
    Route::view('/laporan', 'pages.placeholder', ['title' => 'Laporan'])->name('laporan');
});

Route::middleware('auth')->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan', [PelangganDashboardController::class, 'pesananSaya'])->name('pesanan');
    Route::get('/ulasan', [PelangganDashboardController::class, 'ulasanSaya'])->name('ulasan');
    Route::get('/profil', [PelangganDashboardController::class, 'profil'])->name('profil');
    Route::get('/alamat', [PelangganDashboardController::class, 'alamat'])->name('alamat');
});

Route::post('/api/simulasi-pesanan', function () {
    $produks = \App\Models\Produk::inRandomOrder()->take(rand(1,3))->get();
    $items = [];
    $total = 0;
    foreach ($produks as $p) {
        $qty = rand(1, 2);
        $items[] = [
            'name'  => $p->nama ?? $p->name ?? 'Produk',
            'price' => $p->harga ?? $p->price ?? 100000,
            'qty'   => $qty,
            'image' => $p->gambar ?? $p->image ?? null,
        ];
        $total += ($p->harga ?? $p->price ?? 100000) * $qty;
    }
    $names = ['Andi Wijaya','Maya Sari','Doni Prasetyo','Lina Kusuma','Hendra Saputra','Rina Wati','Joko Susilo'];
    $code = 'ORD-' . str_pad(\App\Models\Pesanan::count() + 1, 5, '0', STR_PAD_LEFT);
    $pesanan = \App\Models\Pesanan::create([
        'code'           => $code,
        'customer_name'  => $names[array_rand($names)],
        'customer_phone' => '08' . rand(1000000000, 9999999999),
        'items'          => $items,
        'total_price'    => $total,
        'status'         => 'masuk',
        'notes'          => null,
    ]);
    return response()->json([
        'message' => 'Pesanan baru masuk!',
        'code'    => $pesanan->code,
        'total'   => $pesanan->formatted_price,
        'items'   => $pesanan->item_count,
    ]);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
