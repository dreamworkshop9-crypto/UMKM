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

    @if($orders->isNotEmpty())
        <div class="space-y-4">
            @foreach($orders as $order)
                <article class="rounded-2xl border border-slate-700/40 bg-slate-800/40 p-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-400">{{ $order->invoice }}</p>
                            <h3 class="text-lg font-semibold text-white mt-1">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</h3>
                            <p class="text-sm text-slate-400">Total: Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-300 text-xs font-semibold uppercase tracking-wide">{{ str_replace('_', ' ', $order->status) }}</span>
                            <a href="{{ route('order.show', $order->invoice) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium">Detail</a>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($order->items->take(3) as $item)
                            <span class="px-3 py-1 rounded-full bg-slate-700/70 text-slate-200 text-xs">{{ $item->product->name ?? $item->produk->name ?? 'Produk' }} × {{ $item->quantity }}</span>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16">
            <i class="fa fa-shopping-cart text-5xl text-slate-600 mb-4"></i>
            <h3 class="text-lg font-medium text-slate-300">Belum Ada Pesanan</h3>
            <p class="text-slate-500 text-sm mt-1 text-center max-w-sm">Anda belum melakukan pesanan apapun. Ayo mulai belanja dan temukan sepatu impian Anda.</p>
            <a href="{{ route('shop') }}" class="mt-6 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
