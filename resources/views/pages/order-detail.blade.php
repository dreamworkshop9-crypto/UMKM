@extends('layouts.app')
@section('title','Detail Pesanan - SALZA')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Header Area -->
    <div class="mb-8">
        <a href="{{ route('order.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-purple-400 transition-colors mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pesanan Saya
        </a>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 border border-slate-700">
                    <i class="fa-solid fa-file-invoice text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Detail Pesanan</h2>
                    <p class="text-sm text-slate-400">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-1">
                <span class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Invoice</span>
                <span class="text-lg font-bold text-white bg-slate-900 px-4 py-1.5 rounded-lg border border-slate-700">{{ $order->invoice }}</span>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
        
        <!-- Status Bar -->
        <div class="p-6 sm:px-10 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-950/50">
            <div>
                <span class="text-sm text-slate-400 block mb-1">Status Pesanan:</span>
                @if($order->status == 'menunggu')
                    <span class="px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-clock"></i> Menunggu Konfirmasi</span>
                @elseif($order->status == 'dikonfirmasi')
                    <span class="px-4 py-2 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-spinner fa-spin"></i> Dikonfirmasi</span>
                @elseif($order->status == 'dikemas')
                    <span class="px-4 py-2 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-box"></i> Sedang Dikemas</span>
                @elseif($order->status == 'dikirim')
                    <span class="px-4 py-2 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-truck"></i> Sedang Dikirim</span>
                @elseif($order->status == 'diperjalanan')
                    <span class="px-4 py-2 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-truck-fast"></i> Dalam Perjalanan</span>
                @elseif($order->status == 'selesai')
                    <span class="px-4 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-check-double"></i> Pesanan Selesai</span>
                @elseif($order->status == 'dibatalkan')
                    <span class="px-4 py-2 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-bold uppercase tracking-widest inline-flex items-center gap-2"><i class="fa-solid fa-xmark"></i> Pesanan Dibatalkan</span>
                @else
                    <span class="px-4 py-2 rounded-xl bg-slate-500/10 border border-slate-500/20 text-slate-400 text-xs font-bold uppercase tracking-widest">{{ ucfirst($order->status) }}</span>
                @endif
            </div>
            <button onclick="window.print()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition-colors border border-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Invoice
            </button>
        </div>

        <!-- Product List -->
        <div class="p-6 sm:p-10 border-b border-slate-800">
            <h3 class="text-base font-bold text-white mb-6 flex items-center gap-2"><i class="fa-solid fa-box-open text-purple-400"></i> Daftar Produk</h3>
            
            <div class="space-y-6">
                @foreach($order->items as $item)
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
            <!-- Product Image -->
        <div class="w-20 h-20 rounded-xl bg-slate-800/50 p-2 flex-shrink-0 border border-slate-700/50 flex items-center justify-center overflow-hidden">
    <img src="{{ $item->product->image_url ?? asset('images/default-product.png') }}" alt="{{ $item->product->name ?? 'Produk' }}" class="max-w-full max-h-full object-contain"/>
</div>
                    
                    <!-- Product Info -->
                    <div class="flex-1">
                        <h4 class="text-base font-bold text-white leading-tight mb-1">{{ $item->product->name ?? 'Produk Tidak Tersedia' }}</h4>
                        <div class="flex flex-wrap gap-2 mb-2">
                            @if($item->size)
                                <span class="text-xs text-slate-400 bg-slate-800 px-2 py-0.5 rounded border border-slate-700">Ukuran: {{ $item->size }}</span>
                            @endif
                            @if($item->color && $item->color !== '-')
                                <span class="text-xs text-slate-400 bg-slate-800 px-2 py-0.5 rounded border border-slate-700">Warna: {{ $item->color }}</span>
                            @endif
                        </div>
                        <div class="text-sm font-semibold text-emerald-400">{{ $item->quantity }} × Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                    
                    <!-- FIX SUBTOTAL Rp 0 -->
                    <div class="text-right w-full sm:w-auto mt-2 sm:mt-0 pt-3 sm:pt-0 border-t border-slate-800 sm:border-0">
                        <div class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-1 hidden sm:block">Subtotal</div>
                        <div class="text-lg font-bold text-white">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Info Grid -->
        <div class="p-6 sm:p-10 grid grid-cols-1 md:grid-cols-2 gap-10 bg-slate-900/30">
            
            <!-- Shipping Info -->
            <div>
                <h3 class="text-base font-bold text-white mb-5 flex items-center gap-2"><i class="fa-solid fa-truck text-emerald-400"></i> Informasi Pengiriman</h3>
                <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5 space-y-4">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-user text-slate-500 mt-1"></i>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $order->shipping_name ?? '-' }}</div>
                            <div class="text-sm text-slate-400">{{ $order->shipping_phone ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-slate-500 mt-1"></i>
                        <div>
                            <div class="text-sm text-slate-300 leading-relaxed">{{ $order->shipping_address ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div>   
                <h3 class="text-base font-bold text-white mb-5 flex items-center gap-2"><i class="fa-solid fa-wallet text-amber-400"></i> Informasi Pembayaran</h3>
                <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-800">
                        <span class="text-sm text-slate-400">Metode Pembayaran</span>
                        <span class="text-sm font-bold text-white bg-slate-800 px-3 py-1 rounded-lg border border-slate-700">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-slate-400">Subtotal Produk</span>
                        <span class="text-sm font-medium text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-slate-400">Ongkos Kirim</span>
                        <span class="text-sm font-medium text-emerald-400">Gratis</span>
                    </div>
                    <div class="flex justify-between items-end pt-4 border-t border-slate-800">
                        <span class="text-sm font-bold uppercase tracking-wider text-slate-400">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-emerald-400">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection