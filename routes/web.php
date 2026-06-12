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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\KeranjangController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\PaymentController;
// → DITAMBAHKAN: Biar tidak tulis panjang2 di bawah
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\Admin\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'register']);

// Public Storefront Routes
Route::get('/shop', [FrontController::class, 'index'])->name('shop');
Route::get('/product/{id}/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/home', function() { return redirect('/shop'); })->name('home');

Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/order/{invoice}', [OrderController::class, 'show'])->name('order.show');
});
Route::post('/order/track', [OrderController::class, 'track'])->name('order.track');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::redirect('/pesanan', '/admin/pesanan/masuk');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // PESANAN — Halaman List (GET)
    Route::get('/pesanan/masuk',           [PesananController::class, 'masuk'])           ->name('pesanan.masuk');
    Route::get('/pesanan/dikonfirmasi',    [PesananController::class, 'dikonfirmasi'])    ->name('pesanan.dikonfirmasi');
    Route::get('/pesanan/dikemas',         [PesananController::class, 'dikemas'])         ->name('pesanan.dikemas');
    Route::get('/pesanan/dikirim',         [PesananController::class, 'dikirim'])         ->name('pesanan.dikirim');
    Route::get('/pesanan/diperjalanan',    [PesananController::class, 'diperjalanan'])    ->name('pesanan.diperjalanan');
    Route::get('/pesanan/selesai',         [PesananController::class, 'selesai'])         ->name('pesanan.selesai');
    Route::get('/pesanan/dibatalkan',      [PesananController::class, 'dibatalkan'])      ->name('pesanan.dibatalkan');

    // PESANAN — Detail (GET)
    Route::get('/pesanan/{id}',            [PesananController::class, 'show'])            ->name('pesanan.show');

    // PESANAN — Aksi Ubah Status (POST)
    Route::post('/pesanan/{id}/konfirmasi',     [PesananController::class, 'aksiKonfirmasi'])     ->name('pesanan.aksi.konfirmasi');
    Route::post('/pesanan/{id}/dikemas',        [PesananController::class, 'aksiDikemas'])        ->name('pesanan.aksi.dikemas');
    Route::post('/pesanan/{id}/dikirim',        [PesananController::class, 'aksiDikirim'])        ->name('pesanan.aksi.dikirim');
    Route::post('/pesanan/{id}/diperjalanan',   [PesananController::class, 'aksiDiperjalanan'])   ->name('pesanan.aksi.diperjalanan');
    Route::post('/pesanan/{id}/selesai',        [PesananController::class, 'aksiSelesai'])        ->name('pesanan.aksi.selesai');
    Route::post('/pesanan/{id}/dibatalkan',     [PesananController::class, 'aksiDibatalkan'])     ->name('pesanan.aksi.dibatalkan');

    // BRAND
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::prefix('api/brands')->name('brands.')->group(function () {
        Route::get('/',          [BrandController::class, 'list'])   ->name('list');
        Route::post('/',         [BrandController::class, 'store'])  ->name('store');
        Route::get('{brand}',    [BrandController::class, 'show'])   ->name('show');
        Route::put('{brand}',    [BrandController::class, 'update']) ->name('update');
        Route::delete('{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });

    // KATEGORI
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::prefix('api/kategori')->name('kategori.')->group(function () {
        Route::get('/',              [KategoriController::class, 'list'])   ->name('list');
        Route::post('/',             [KategoriController::class, 'store'])  ->name('store');
        Route::get('{kategori}',     [KategoriController::class, 'show'])   ->name('show');
        Route::put('{kategori}',     [KategoriController::class, 'update']) ->name('update');
        Route::delete('{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    // PRODUK
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
    Route::get('/produk/detail/{id}', [ProdukController::class, 'detailView'])->name('product.detail');
    Route::prefix('api/produk')->name('produk.')->group(function () {
        Route::get('/',           [ProdukController::class, 'list'])   ->name('list');
        Route::get('/options',    [ProdukController::class, 'options']) ->name('options');
        Route::post('/',          [ProdukController::class, 'store'])  ->name('store');
        Route::get('{produk}',    [ProdukController::class, 'show'])   ->name('show');
        Route::put('{produk}',    [ProdukController::class, 'update']) ->name('update');
        Route::delete('{produk}', [ProdukController::class, 'destroy'])->name('destroy');
    });

    // SLIDER
    Route::get('/slider', [SliderController::class, 'index'])->name('slider');
    Route::prefix('api/slider')->name('slider.')->group(function () {
        Route::get('/',          [SliderController::class, 'list'])   ->name('list');
        Route::post('/',         [SliderController::class, 'store'])  ->name('store');
        Route::get('{slider}',   [SliderController::class, 'show'])   ->name('show');
        Route::put('{slider}',   [SliderController::class, 'update']) ->name('update');
        Route::delete('{slider}', [SliderController::class, 'destroy'])->name('destroy');
    });

    // KUPON
    Route::get('/kupon', [KuponController::class, 'index'])->name('kupon');
    Route::prefix('api/kupon')->name('kupon.')->group(function () {
        Route::get('/',          [KuponController::class, 'list'])   ->name('list');
        Route::post('/',         [KuponController::class, 'store'])  ->name('store');
        Route::get('{kupon}',    [KuponController::class, 'show'])   ->name('show');
        Route::put('{kupon}',    [KuponController::class, 'update']) ->name('update');
        Route::delete('{kupon}', [KuponController::class, 'destroy'])->name('destroy');
    });

    // DATA USER
    Route::get('/users',               [UserController::class, 'index'])   ->name('users');
    Route::get('/api/users/{user}',    [UserController::class, 'show'])    ->name('users.show');
    Route::put('/api/users/{user}',    [UserController::class, 'update'])  ->name('users.update');
    Route::delete('/api/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // PLACEHOLDER PAGES
    Route::view('/wilayah',      'pages.placeholder', ['title' => 'Data Wilayah'])  ->name('wilayah');
    Route::get('/pembatalan',    [PesananController::class, 'dibatalkan'])->name('pembatalan');
    Route::get('/pengembalian', [PesananController::class, 'pengembalian'])->name('pengembalian');
    Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan');
    Route::post('/api/ulasan/{id}/status', [UlasanController::class, 'updateStatus'])->name('ulasan.update-status');
    Route::delete('/api/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    Route::get('/stok', [ProdukController::class, 'stok'])->name('stok');
    Route::view('/admins',       'pages.placeholder', ['title' => 'Data Admin'])    ->name('admins');
    Route::get('/laporan',           [LaporanController::class, 'index'])->name('laporan');
    Route::get('/api/laporan/chart', [LaporanController::class, 'chart'])->name('laporan.chart');
});

Route::middleware('auth')->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan', [PelangganDashboardController::class, 'pesananSaya'])->name('pesanan');
    Route::get('/ulasan', [PelangganDashboardController::class, 'ulasanSaya'])->name('ulasan');
    Route::get('/profil', [PelangganDashboardController::class, 'profil'])->name('profil');
    Route::get('/alamat', [PelangganDashboardController::class, 'alamat'])->name('alamat');
});

// SIMULASI PESANAN
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

// SALZA LANDING PAGE + API KERANJANG + CHECKOUT
Route::get('/landing', [FrontController::class, 'index'])->name('front.home');

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'updateQty'])->name('keranjang.update');
    Route::get('/produk-detail/{id}', [FrontController::class, 'produkDetail'])->name('produk.detail');
    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->middleware('auth')
        ->name('checkout');
});

// MIDTRANS PAYMENT GATEWAY
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');
Route::get('/payment/success',  [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/finish',   [PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/unfinish', [PaymentController::class, 'unfinish'])->name('payment.unfinish');
Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout.legacy');

Route::get('/pesanan/sukses', function () {
    return response('OK', 200);
})->name('pesanan.sukses');

Route::get('/payment/error',    [PaymentController::class, 'error'])->name('payment.error');