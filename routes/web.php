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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin']);
Route::get('/daftar', [AuthController::class, 'daftar'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'prosesDaftar']);

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
    Route::get('/pesanan', [PelangganDashboardController::class, 'pesananSaya'])->name('pelanggan.pesanan');
    Route::get('/ulasan', [PelangganDashboardController::class, 'ulasanSaya'])->name('pelanggan.ulasan');
    Route::get('/profil', [PelangganDashboardController::class, 'profil'])->name('pelanggan.profil');
    Route::get('/alamat', [PelangganDashboardController::class, 'alamat'])->name('pelanggan.alamat');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
