<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function cekRole()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }
    }

    public function index()
    {
        $this->cekRole();
        return view('admin.dashboard');
    }

    public function pesanan()
    {
        $this->cekRole();
        return view('pages.placeholder', ['title' => 'Pesanan']);
    }
}