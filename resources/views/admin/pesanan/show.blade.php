@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-white">Detail Pesanan</h1>
            <p class="text-xs text-slate-500 mt-1">Invoice: {{ $pesanan->invoice }}</p>
        </div>
        <a href="{{ URL::previous() }}" class="text-sm text-indigo-400 hover:text-indigo-300 flex items-center gap-1">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Info Pengiriman -->
        <div class="lg:col-span-1 bg-[#121220] rounded-lg p-5 border border-outline-variant/10">
            <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-400 text-lg">local_shipping</span>
                Info Pengiriman
            </h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-slate-500 text-xs">Nama Penerima</p>
                    <p class="text-slate-200 font-medium">{{ $pesanan->shipping_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 text-xs">No. Telepon</p>
                    <p class="text-slate-200 font-medium">{{ $pesanan->shipping_phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 text-xs">Alamat</p>
                    <p class="text-slate-200 font-medium">{{ $pesanan->shipping_address ?? '-' }}</p>
                </div>
                @if($pesanan->tracking_number)
                <div>
                    <p class="text-slate-500 text-xs">No. Resi</p>
                    <p class="text-cyan-400 font-medium">{{ $pesanan->tracking_number }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="lg:col-span-2 bg-[#121220] rounded-lg p-5 border border-outline-variant/10">
            <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-400 text-lg">receipt_long</span>
                Ringkasan Pesanan
            </h3>
            
            <div class="mb-4 p-3 rounded-lg bg-slate-900/50 flex justify-between items-center">
                <span class="text-slate-400 text-sm">Status Saat Ini</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                    @if($pesanan->status == 'masuk') bg-blue-500/15 text-blue-400 
                    @elseif($pesanan->status == 'dikonfirmasi') bg-purple-500/15 text-purple-400 
                    @elseif($pesanan->status == 'dikemas') bg-yellow-500/15 text-yellow-400 
                    @elseif($pesanan->status == 'dikirim') bg-cyan-500/15 text-cyan-400 
                    @elseif($pesanan->status == 'diperjalanan') bg-orange-500/15 text-orange-400 
                    @elseif($pesanan->status == 'selesai') bg-emerald-500/15 text-emerald-400 
                    @elseif($pesanan->status == 'dibatalkan') bg-red-500/15 text-red-400 
                    @endif">
                    {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                </span>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Metode Pembayaran</span>
                    <span class="text-slate-200">{{ strtoupper($pesanan->payment_method ?? '-') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Tanggal Pesan</span>
                    <span class="text-slate-200">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <div class="border-t border-outline-variant/20 pt-4 flex justify-between items-center">
                <span class="text-white font-semibold">Total Pembayaran</span>
                <span class="text-2xl font-bold text-emerald-400">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- TOMBOL PROSES PESANAN -->
    <div class="mt-6 bg-[#121220] rounded-lg p-5 border border-outline-variant/10">
        <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-400 text-lg">play_circle</span>
            Proses Pesanan
        </h3>
        <div class="flex flex-wrap gap-3">
            @if($pesanan->status == 'masuk')
                <form action="{{ route('pesanan.aksi.konfirmasi', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">check_circle</span> Konfirmasi
                    </button>
                </form>
                <form action="{{ route('pesanan.aksi.dibatalkan', $pesanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-red-600/20 hover:bg-red-600/40 text-red-400 text-sm font-semibold rounded-lg transition flex items-center gap-2 border border-red-500/20">
                        <span class="material-symbols-outlined text-base">cancel</span> Batalkan
                    </button>
                </form>
            @endif

            @if($pesanan->status == 'dikonfirmasi')
                <form action="{{ route('pesanan.aksi.dikemas', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-yellow-600 hover:bg-yellow-500 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">inventory_2</span> Tandai Dikemas
                    </button>
                </form>
            @endif

            @if($pesanan->status == 'dikemas')
                <form action="{{ route('pesanan.aksi.dikirim', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">local_shipping</span> Tandai Dikirim
                    </button>
                </form>
            @endif

            @if($pesanan->status == 'dikirim')
                {{-- CATATAN: route di web.php Anda tertulis 'pesanan.aksi.dikirim' untuk diperjalanan --}}
                <form action="{{ route('pesanan.aksi.dikirim', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">local_taxi</span> Dalam Perjalanan
                    </button>
                </form>
            @endif

            @if($pesanan->status == 'diperjalanan')
                <form action="{{ route('pesanan.aksi.selesai', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">verified</span> Tandai Selesai
                    </button>
                </form>
            @endif

            @if(in_array($pesanan->status, ['selesai', 'dibatalkan']))
                <div class="text-slate-500 text-sm italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">block</span> 
                    Pesanan sudah {{ $pesanan->status }} dan tidak bisa diubah lagi.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection