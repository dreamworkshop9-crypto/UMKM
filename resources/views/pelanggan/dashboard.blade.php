@extends('layouts.pelanggan')

@section('title', 'Dashboard Pelanggan - SALZA')

@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
    <p class="text-slate-400">Pantau aktivitas belanja dan pesanan Anda di sini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Card 1 --}}
    <div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-white">{{ $totalPesanan ?? 0 }}</h3>
            </div>
            <div class="bg-emerald-500/10 p-3 rounded-lg">
                <i class="fa fa-shopping-bag text-emerald-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('pelanggan.pesanan') }}" class="text-xs text-emerald-400 hover:text-emerald-300 font-medium">Lihat Semua Pesanan &rarr;</a>
        </div>
    </div>

    {{-- Card 2 --}}
    <div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pesanan Aktif</p>
                <h3 class="text-2xl font-bold text-white">{{ $pesananAktif ?? 0 }}</h3>
            </div>
            <div class="bg-blue-500/10 p-3 rounded-lg">
                <i class="fa fa-truck text-blue-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs text-slate-500">Menunggu dikirim atau dalam perjalanan</span>
        </div>
    </div>

    {{-- Card 3 --}}
    <div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Menunggu Ulasan</p>
                <h3 class="text-2xl font-bold text-white">0</h3>
            </div>
            <div class="bg-amber-500/10 p-3 rounded-lg">
                <i class="fa fa-star text-amber-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('pelanggan.ulasan') }}" class="text-xs text-amber-400 hover:text-amber-300 font-medium">Berikan ulasan Anda &rarr;</a>
        </div>
    </div>
</div>

<div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
    <div class="p-6 border-b border-slate-700/50 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-white">Pesanan Terkini</h2>
        <a href="{{ route('pelanggan.pesanan') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Total Belanja</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-700/10">
                        <td class="px-6 py-4 text-slate-300">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-slate-200 font-medium">{{ $order->invoice }}</td>
                        <td class="px-6 py-4 text-slate-200">Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4"><span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-300 text-xs font-semibold uppercase tracking-wide">{{ str_replace('_', ' ', $order->status) }}</span></td>
                        <td class="px-6 py-4"><a href="{{ route('order.show', $order->invoice) }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium">Lihat Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-16 text-center text-slate-500" colspan="5">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa fa-box-open text-4xl text-slate-600 mb-3"></i>
                                <p>Belum ada transaksi pesanan.</p>
                                <a href="{{ route('shop') }}" class="mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-sm transition-colors">Mulai Belanja</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
