<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganDashboardController extends Controller
{


    private function cekRole()
    {
        $role = Auth::user()->role ?? null;

        if (! in_array($role, ['pelanggan', 'pembeli'], true)) {
            abort(403, 'Akses ditolak. Hanya untuk pelanggan.');
        }
    }

    public function index()
    {
        $this->cekRole();

        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        $totalPesanan = Order::where('user_id', Auth::id())->count();
        $pesananAktif = Order::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu_pembayaran', 'menunggu_konfirmasi', 'dikemas', 'dikirim'])
            ->count();

        return view('pelanggan.dashboard', compact('orders', 'totalPesanan', 'pesananAktif'));
    }

    public function pesananSaya()
    {
        $this->cekRole();

        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('pelanggan.pesanan', compact('orders'));
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