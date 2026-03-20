<?php

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/user/{id}', function ($id) {
    return "User ID : " . $id;
});

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return "Halaman Admin Dashboard";
    });

    Route::get('/users', function () {
        return "Halaman Admin Users";
    });

});

Route::get('/listbarang/{id}/{nama}', function ($id, $nama) {
    return view('list_barang', [
        'id' => $id,
        'nama' => $nama
    ]);
});

use Illuminate\Support\Facades\Route;

Route::get('/listbarang/{id}/{nama}', function ($id, $nama) {
    return view('list_barang', [
        'id' => $id,
        'nama' => $nama
    ]);

Route::get('/listbarang/{id}/{nama}', [ListBarangController::class, 'show']);
});