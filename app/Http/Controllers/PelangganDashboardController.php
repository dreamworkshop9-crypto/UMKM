<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function cekRole()
    {
        if (auth()->user()->role !== 'pelanggan') {
            abort(403, 'Akses ditolak. Hanya untuk pelanggan.');
        }
    }

    public function index()
    {
        $this->cekRole();
        return view('pelanggan.dashboard');
    }

    public function pesananSaya()
    {
        $this->cekRole();
        return view('pages.placeholder', ['title' => 'Pesanan Saya']);
    }

    public function ulasanSaya()
    {
        $this->cekRole();
        return view('pages.placeholder', ['title' => 'Ulasan Saya']);
    }

    public function profil()
    {
        $this->cekRole();
        return view('pages.placeholder', ['title' => 'Profil']);
    }

    public function alamat()
    {
        $this->cekRole();
        return view('pages.placeholder', ['title' => 'Alamat']);
    }
}