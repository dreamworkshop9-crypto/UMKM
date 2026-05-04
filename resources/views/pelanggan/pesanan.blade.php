@extends('layouts.pelanggan')
@section('title', 'Pesanan Saya - SALZA')
@section('page-title', 'Pesanan Saya')

@section('content')
<div class="bg-dashboard-card rounded-xl border border-slate-700/30 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white">Daftar Pesanan</h2>
        <div class="flex gap-2">
            <select class="bg-slate-800 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block p-2">
                <option>Semua Status</option>
                <option>Menunggu Pembayaran</option>
                <option>Diproses</option>
                <option>Dikirim</option>
                <option>Selesai</option>
            </select>
        </div>
    </div>

    <div class="flex flex-col items-center justify-center py-16">
        <i class="fa fa-shopping-cart text-5xl text-slate-600 mb-4"></i>
        <h3 class="text-lg font-medium text-slate-300">Belum Ada Pesanan</h3>
        <p class="text-slate-500 text-sm mt-1 text-center max-w-sm">Anda belum melakukan pesanan apapun. Ayo mulai belanja dan temukan sepatu impian Anda.</p>
        <a href="{{ route('shop') }}" class="mt-6 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">Mulai Belanja</a>
    </div>
</div>
@endsection
