<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganDashboardController extends Controller
{


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
        return view('pelanggan.pesanan');
    }

    public function ulasanSaya()
    {
        $this->cekRole();
        return view('pelanggan.ulasan');
    }

    public function profil()
    {
        $this->cekRole();
        return view('pelanggan.profil');
    }

    public function alamat()
    {
        $this->cekRole();
        return view('pelanggan.alamat');
    }
}