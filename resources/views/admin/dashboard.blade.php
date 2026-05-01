@extends('layouts.admin')

@section('title', 'Dashboard Admin - SALZA')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30 h-40">
        <div class="flex justify-between items-start h-full">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Penjualan Bulan Ini</p>
                <h3 class="text-2xl font-bold text-white">Rp0</h3>
            </div>
            <div class="bg-amber-500/10 p-3 rounded-lg">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30 h-40">
        <div class="flex justify-between items-start h-full">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Penjualan Tahun Ini</p>
                <h3 class="text-2xl font-bold text-white">Rp120.000</h3>
            </div>
            <div class="bg-purple-500/10 p-3 rounded-lg">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30 h-40">
        <div class="flex justify-between items-start h-full">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pesanan Ditunda</p>
                <h3 class="text-2xl font-bold text-white">0</h3>
            </div>
            <div class="bg-rose-500/10 p-3 rounded-lg">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.279a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.209.388l-2.235 2.235a13.177 13.177 0 01-5.474-5.474l2.235-2.235a1 1 0 00.388-1.209L9.107 4.316a1 1 0 00-.948-.684H5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
    <div class="p-6 border-b border-slate-700/50">
        <h2 class="text-lg font-semibold text-white">Semua Pesanan Baru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Total Bayar</th>
                    <th class="px-6 py-4">Metode Pembayaran</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <tr>
                    <td class="px-6 py-20 text-center text-slate-500 italic" colspan="6">Belum ada pesanan baru hari ini.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
