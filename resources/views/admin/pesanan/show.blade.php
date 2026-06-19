@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('additional-css')
<style>
.card-detail {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    overflow: hidden;
}
.card-detail-header {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(46, 46, 72, 0.3);
    background: rgba(46, 46, 72, 0.1);
}
.card-detail-body {
    padding: 24px;
}
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 10px 0;
    font-size: 13px;
    border-bottom: 1px solid rgba(46, 46, 72, 0.15);
}
.info-row:last-child { border-bottom: none; }
.info-label { color: #64748b; min-width: 100px; }
.info-value { color: #e2e8f0; font-weight: 500; text-align: right; max-width: 200px; }
.product-row {
    display: grid;
    grid-template-columns: 60px 1fr 120px 80px 130px;
    align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid rgba(46, 46, 72, 0.15);
    font-size: 13px;
}
.product-row:last-child { border-bottom: none; }
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 0.5rem;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Header & Status -->
    <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Detail Pesanan</h1>
            <p class="text-sm text-slate-400 mt-1">{{ $pesanan->invoice }} &bull; {{ $pesanan->created_at->format('d M Y, H:i') }}</p>
        </div>
        <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase 
            @if($pesanan->status == 'menunggu') bg-blue-500/15 text-blue-400 border border-blue-500/20 
            @elseif($pesanan->status == 'dikonfirmasi') bg-amber-500/15 text-amber-400 border border-amber-500/20 
            @elseif($pesanan->status == 'dikemas') bg-purple-500/15 text-purple-400 border border-purple-500/20 
            @elseif($pesanan->status == 'dikirim') bg-cyan-500/15 text-cyan-400 border border-cyan-500/20 
            @elseif($pesanan->status == 'diperjalanan') bg-orange-500/15 text-orange-400 border border-orange-500/20 
            @elseif($pesanan->status == 'selesai') bg-emerald-500/15 text-emerald-400 border border-emerald-500/20 
            @elseif($pesanan->status == 'dibatalkan') bg-red-500/15 text-red-400 border border-red-500/20 
            @endif">
            {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
        </span>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">check_circle</span> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">error</span> {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Daftar Produk (Kiri) -->
        <div class="lg:col-span-2 card-detail">
            <div class="card-detail-header">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-400 text-lg">shopping_bag</span>
                    Daftar Produk
                </h3>
            </div>
            <div class="card-detail-body">
                @if($pesanan->items->count() > 0)
                    <div class="hidden md:grid product-row text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2" style="border-bottom: 1px solid rgba(46, 46, 72, 0.4); padding-bottom: 12px;">
                        <div>Gambar</div>
                        <div>Produk</div>
                        <div class="text-right">Harga</div>
                        <div class="text-right">Qty</div>
                        <div class="text-right">Subtotal</div>
                    </div>
                    @foreach($pesanan->items as $index => $item)
                    <div class="product-row">
                        <!-- GAMBAR PRODUK -->
                        <div class="w-12 h-12 rounded-lg bg-[#121220] border border-outline-variant/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img src="{{ $item->product->image_url ?? asset('images/default-product.png') }}" alt="{{ $item->product->name ?? 'Produk' }}" class="w-full h-full object-cover"/>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">{{ $item->product->name ?? 'Produk Dihapus' }}</p>
                            <p class="text-xs text-slate-500 mt-1">
                                @if($item->size) Size: {{ $item->size }}@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('additional-css')
<style>
.card-detail {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    overflow: hidden;
}
.card-detail-header {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(46, 46, 72, 0.3);
    background: rgba(46, 46, 72, 0.1);
}
.card-detail-body {
    padding: 24px;
}
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 10px 0;
    font-size: 13px;
    border-bottom: 1px solid rgba(46, 46, 72, 0.15);
}
.info-row:last-child { border-bottom: none; }
.info-label { color: #64748b; min-width: 100px; }
.info-value { color: #e2e8f0; font-weight: 500; text-align: right; max-width: 200px; }
.product-row {
    display: grid;
    grid-template-columns: 40px 1fr 120px 80px 130px;
    align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid rgba(46, 46, 72, 0.15);
    font-size: 13px;
}
.product-row:last-child { border-bottom: none; }
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 0.5rem;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Header & Status -->
    <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Detail Pesanan</h1>
            <p class="text-sm text-slate-400 mt-1">{{ $pesanan->invoice }} &bull; {{ $pesanan->created_at->format('d M Y, H:i') }}</p>
        </div>
        <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase 
            @if($pesanan->status == 'menunggu') bg-blue-500/15 text-blue-400 border border-blue-500/20 
            @elseif($pesanan->status == 'dikonfirmasi') bg-amber-500/15 text-amber-400 border border-amber-500/20 
            @elseif($pesanan->status == 'dikemas') bg-purple-500/15 text-purple-400 border border-purple-500/20 
            @elseif($pesanan->status == 'dikirim') bg-cyan-500/15 text-cyan-400 border border-cyan-500/20 
            @elseif($pesanan->status == 'diperjalanan') bg-orange-500/15 text-orange-400 border border-orange-500/20 
            @elseif($pesanan->status == 'selesai') bg-emerald-500/15 text-emerald-400 border border-emerald-500/20 
            @elseif($pesanan->status == 'dibatalkan') bg-red-500/15 text-red-400 border border-red-500/20 
            @endif">
            {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
        </span>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">check_circle</span> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">error</span> {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Daftar Produk (Kiri) -->
        <div class="lg:col-span-2 card-detail">
            <div class="card-detail-header">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-400 text-lg">shopping_bag</span>
                    Daftar Produk
                </h3>
            </div>
            <div class="card-detail-body">
                @if($pesanan->items->count() > 0)
                    <div class="hidden md:grid product-row text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2" style="border-bottom: 1px solid rgba(46, 46, 72, 0.4); padding-bottom: 12px;">
                        <div>#</div>
                        <div>Produk</div>
                        <div class="text-right">Harga</div>
                        <div class="text-right">Qty</div>
                        <div class="text-right">Subtotal</div>
                    </div>
                    @foreach($pesanan->items as $index => $item)
                    <div class="product-row">
                        <div class="text-slate-500 text-sm">{{ $index + 1 }}</div>
                        <div>
                            <p class="text-white font-medium">{{ $item->product->name ?? 'Produk Dihapus' }}</p>
                            <p class="text-xs text-slate-500 mt-1">
                                @if($item->size) Size: {{ $item->size }} @endif
                                @if($item->color && $item->color !== '-') Color: {{ $item->color }} @endif
                            </p>
                        </div>
                        <div class="text-right text-slate-300">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        <div class="text-right text-slate-300">{{ $item->quantity }}</div>
                        <div class="text-right text-emerald-400 font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                @else
                    <p class="text-slate-500 text-sm text-center py-8">Tidak ada item produk.</p>
                @endif
            </div>
        </div>

        <!-- Info Pengiriman & Pembayaran (Kanan) -->
        <div class="space-y-6">
            <div class="card-detail">
                <div class="card-detail-header">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-cyan-400 text-lg">local_shipping</span>
                        Info Pengiriman
                    </h3>
                </div>
                <div class="card-detail-body space-y-0">
                    <div class="info-row">
                        <span class="info-label">Penerima</span>
                        <span class="info-value">{{ $pesanan->shipping_name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Telepon</span>
                        <span class="info-value">{{ $pesanan->shipping_phone ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-value">{{ $pesanan->shipping_address ?? '-' }}</span>
                    </div>
                    @if($pesanan->tracking_number)
                    <div class="info-row">
                        <span class="info-label">No. Resi</span>
                        <span class="info-value text-cyan-400">{{ $pesanan->tracking_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-detail">
                <div class="card-detail-header">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-lg">payments</span>
                        Pembayaran
                    </h3>
                </div>
                <div class="card-detail-body space-y-0">
                    <div class="info-row">
                        <span class="info-label">Metode</span>
                        <span class="info-value uppercase">{{ $pesanan->payment_method ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full 
                            @if(($pesanan->payment_status ?? 'pending') == 'paid') bg-emerald-500/15 text-emerald-400 
                            @else bg-yellow-500/15 text-yellow-400 @endif">
                            {{ ucfirst($pesanan->payment_status ?? 'Pending') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Grand Total -->
            <div class="bg-[#121220] border border-indigo-500/20 rounded-xl p-5">
                <p class="text-sm text-slate-400 mb-1">Total Pembayaran</p>
                <p class="text-3xl font-bold text-emerald-400">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi Proses Pesanan -->
    <div class="card-detail">
        <div class="card-detail-header">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-400 text-lg">play_circle</span>
                Proses Pesanan
            </h3>
        </div>
        <div class="card-detail-body">
            <div class="flex flex-wrap gap-3">
                <a href="{{ URL::previous() }}" class="btn-action bg-slate-500/10 text-slate-400 hover:bg-slate-500/20 border border-slate-500/20">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                </a>

                @if($pesanan->status == 'menunggu')
                    <form action="{{ route('admin.pesanan.aksi.konfirmasi', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-blue-600 hover:bg-blue-500 text-white"><span class="material-symbols-outlined text-base">check_circle</span> Konfirmasi</button>
                    </form>
                    <form action="{{ route('admin.pesanan.aksi.dibatalkan', $pesanan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="btn-action bg-red-600/10 hover:bg-red-600/20 text-red-400 border border-red-500/20"><span class="material-symbols-outlined text-base">cancel</span> Batalkan</button>
                    </form>
                @endif

                @if($pesanan->status == 'dikonfirmasi')
                    <form action="{{ route('admin.pesanan.aksi.dikemas', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-purple-600 hover:bg-purple-500 text-white"><span class="material-symbols-outlined text-base">inventory_2</span> Tandai Dikemas</button>
                    </form>
                @endif

                @if($pesanan->status == 'dikemas')
                    <form action="{{ route('admin.pesanan.aksi.dikirim', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-cyan-600 hover:bg-cyan-500 text-white"><span class="material-symbols-outlined text-base">local_shipping</span> Tandai Dikirim</button>
                    </form>
                @endif

                @if($pesanan->status == 'dikirim')
                    <form action="{{ route('admin.pesanan.aksi.dikirim', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-orange-600 hover:bg-orange-500 text-white"><span class="material-symbols-outlined text-base">local_taxi</span> Dalam Perjalanan</button>
                    </form>
                @endif

                @if($pesanan->status == 'diperjalanan')
                    <form action="{{ route('admin.pesanan.aksi.selesai', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-emerald-600 hover:bg-emerald-500 text-white"><span class="material-symbols-outlined text-base">verified</span> Tandai Selesai</button>
                    </form>
                @endif

                @if(in_array($pesanan->status, ['selesai', 'dibatalkan']))
                    <div class="text-slate-500 text-sm italic flex items-center gap-2 py-2">
                        <span class="material-symbols-outlined text-base">block</span> Pesanan sudah {{ $pesanan->status }} dan tidak bisa diubah lagi.
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection @endif
                                @if($item->color && $item->color !== '-') Color: {{ $item->color }} @endif
                            </p>
                        </div>
                        <div class="text-right text-slate-300 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        <div class="text-right text-slate-300 text-sm">{{ $item->quantity }}</div>
                        <div class="text-right text-emerald-400 font-semibold text-sm">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                @else
                    <p class="text-slate-500 text-sm text-center py-8">Tidak ada item produk.</p>
                @endif
            </div>
        </div>

        <!-- Info Pengiriman & Pembayaran (Kanan) -->
        <div class="space-y-6">
            <div class="card-detail">
                <div class="card-detail-header">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-cyan-400 text-lg">local_shipping</span>
                        Info Pengiriman
                    </h3>
                </div>
                <div class="card-detail-body space-y-0">
                    <div class="info-row">
                        <span class="info-label">Penerima</span>
                        <span class="info-value">{{ $pesanan->shipping_name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Telepon</span>
                        <span class="info-value">{{ $pesanan->shipping_phone ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-value">{{ $pesanan->shipping_address ?? '-' }}</span>
                    </div>
                    @if($pesanan->tracking_number)
                    <div class="info-row">
                        <span class="info-label">No. Resi</span>
                        <span class="info-value text-cyan-400">{{ $pesanan->tracking_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-detail">
                <div class="card-detail-header">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-lg">payments</span>
                        Pembayaran
                    </h3>
                </div>
                <div class="card-detail-body space-y-0">
                    <div class="info-row">
                        <span class="info-label">Metode</span>
                        <span class="info-value uppercase">{{ $pesanan->payment_method ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full 
                            @if(($pesanan->payment_status ?? 'pending') == 'paid') bg-emerald-500/15 text-emerald-400 
                            @else bg-yellow-500/15 text-yellow-400 @endif">
                            {{ ucfirst($pesanan->payment_status ?? 'Pending') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Grand Total -->
            <div class="bg-[#121220] border border-indigo-500/20 rounded-xl p-5">
                <p class="text-sm text-slate-400 mb-1">Total Pembayaran</p>
                <p class="text-3xl font-bold text-emerald-400">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi Proses Pesanan -->
    <div class="card-detail">
        <div class="card-detail-header">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-400 text-lg">play_circle</span>
                Proses Pesanan
            </h3>
        </div>
        <div class="card-detail-body">
            <div class="flex flex-wrap gap-3">
                <a href="{{ URL::previous() }}" class="btn-action bg-slate-500/10 text-slate-400 hover:bg-slate-500/20 border border-slate-500/20">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                </a>

                @if($pesanan->status == 'menunggu')
                    <form action="{{ route('admin.pesanan.aksi.konfirmasi', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-blue-600 hover:bg-blue-500 text-white"><span class="material-symbols-outlined text-base">check_circle</span> Konfirmasi</button>
                    </form>
                    <form action="{{ route('admin.pesanan.aksi.dibatalkan', $pesanan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="btn-action bg-red-600/10 hover:bg-red-600/20 text-red-400 border border-red-500/20"><span class="material-symbols-outlined text-base">cancel</span> Batalkan</button>
                    </form>
                @endif

                @if($pesanan->status == 'dikonfirmasi')
                    <form action="{{ route('admin.pesanan.aksi.dikemas', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-purple-600 hover:bg-purple-500 text-white"><span class="material-symbols-outlined text-base">inventory_2</span> Tandai Dikemas</button>
                    </form>
                @endif

                @if($pesanan->status == 'dikemas')
                    <form action="{{ route('admin.pesanan.aksi.dikirim', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-cyan-600 hover:bg-cyan-500 text-white"><span class="material-symbols-outlined text-base">local_shipping</span> Tandai Dikirim</button>
                    </form>
                @endif

                @if($pesanan->status == 'dikirim')
                    <form action="{{ route('admin.pesanan.aksi.dikirim', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-orange-600 hover:bg-orange-500 text-white"><span class="material-symbols-outlined text-base">local_taxi</span> Dalam Perjalanan</button>
                    </form>
                @endif

                @if($pesanan->status == 'diperjalanan')
                    <form action="{{ route('admin.pesanan.aksi.selesai', $pesanan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action bg-emerald-600 hover:bg-emerald-500 text-white"><span class="material-symbols-outlined text-base">verified</span> Tandai Selesai</button>
                    </form>
                @endif

                @if(in_array($pesanan->status, ['selesai', 'dibatalkan']))
                    <div class="text-slate-500 text-sm italic flex items-center gap-2 py-2">
                        <span class="material-symbols-outlined text-base">block</span> Pesanan sudah {{ $pesanan->status }} dan tidak bisa diubah lagi.
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection