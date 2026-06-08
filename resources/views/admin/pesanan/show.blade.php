<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Salza Admin - Detail Pesanan</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config={darkMode:"class",theme:{extend:{colors:{background:"#121220","surface-container":"#1c1c2d",primary:"#6366f1",secondary:"#a855f7","outline-variant":"#2e2e48","on-surface":"#94a3b8",error:"#ef4444"},borderRadius:{DEFAULT:"0.25rem",lg:"0.5rem",xl:"0.75rem",full:"9999px"},spacing:{gutter:"20px",xl:"32px",sm:"8px",md:"16px",lg:"24px",unit:"4px",xs:"4px",sidebar_width:"260px"},fontFamily:{"body-md":["Inter"],"display-lg":["Inter"],"body-sm":["Inter"],"title-sm":["Inter"],"headline-md":["Inter"],"label-caps":["Inter"]}}}}
</script>
<style>
body{background-color:#121220;color:#e3e0f5}
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24}
.custom-scrollbar::-webkit-scrollbar{width:4px}
.custom-scrollbar::-webkit-scrollbar-track{background:#1C1C2D}
.custom-scrollbar::-webkit-scrollbar-thumb{background:#2D2D3F;border-radius:10px}
.bg-active-gradient{background:linear-gradient(90deg,#3b82f6 0%,#8b5cf6 100%)}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body class="font-body-md text-body-md overflow-hidden bg-background">

<!-- Sidebar -->
<aside class="w-[260px] h-screen fixed left-0 top-0 bg-[#1c1c2d] flex flex-col z-[60] border-r border-outline-variant/20">
<div class="p-6">
<h1 class="text-2xl font-black tracking-tighter text-white">SALZA</h1>
<p class="text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500 mt-1">Admin Management</p>
</div>
<nav class="flex-1 px-4 overflow-y-auto custom-scrollbar space-y-1">
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.dashboard') }}">
<span class="material-symbols-outlined text-[20px]">dashboard</span><span class="text-[13px] font-medium">Dashboard</span>
</a>
<div class="px-4 py-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Data Master</div>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.brands.index') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">list</span><span class="text-[13px] font-medium">Merek</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.kategori') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">category</span><span class="text-[13px] font-medium">Kategori</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.produk') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span class="text-[13px] font-medium">Produk</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.slider') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">view_carousel</span><span class="text-[13px] font-medium">Slider</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.kupon') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">confirmation_number</span><span class="text-[13px] font-medium">Kupon</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>

<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Kelola Pesanan</div>

<!-- Pesanan POLOS -->
<div onclick="togglePesanan()" class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all cursor-pointer select-none">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-[20px]">list_alt</span>
<span class="text-[13px] font-medium">Pesanan</span>
</div>
<span id="pesanan-arrow" class="material-symbols-outlined text-[16px] transition-transform duration-200" style="transform:rotate(180deg)">expand_more</span>
</div>

<!-- Sub-menu TERBUKA -->
<div id="pesanan-submenu" class="pl-6 space-y-1 mt-1 mb-1">
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.masuk') }}"><span class="material-symbols-outlined text-[14px] text-indigo-400/50">more_horiz</span><span>Pesanan Masuk</span></a>
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikonfirmasi') }}"><span class="material-symbols-outlined text-[14px] text-indigo-400/50">more_horiz</span><span>Pesanan Di Konfirmasi</span></a>
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikemas') }}"><span class="material-symbols-outlined text-[14px] text-indigo-400/50">more_horiz</span><span>Pesanan Di Kemas</span></a>
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikirim') }}"><span class="material-symbols-outlined text-[14px] text-indigo-400/50">more_horiz</span><span>Pesanan Dikirim</span></a>
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.diperjalanan') }}"><span class="material-symbols-outlined text-[14px] text-indigo-400/50">more_horiz</span><span>Pesanan Dalam Perjalanan</span></a>
<a class="flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.selesai') }}"><span class="material-symbols-outlined text-[14px] text-indigo-400/50">more_horiz</span><span>Pesanan Selesai</span></a>
</div>

<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.pembatalan') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">cancel</span><span class="text-[13px] font-medium">Pembatalan</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.pengembalian') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">assignment_return</span><span class="text-[13px] font-medium">Pengembalian</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.ulasan') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">reviews</span><span class="text-[13px] font-medium">Ulasan</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.stok') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory</span><span class="text-[13px] font-medium">Stok Produk</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>

<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Pengaturan</div>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.users') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">group</span><span class="text-[13px] font-medium">Data User</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.admins') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">admin_panel_settings</span><span class="text-[13px] font-medium">Data Admin</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.laporan') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">bar_chart</span><span class="text-[13px] font-medium">Laporan</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
</nav>
<div class="p-4 border-t border-outline-variant/20 flex items-center justify-around text-slate-500">
<span class="material-symbols-outlined cursor-pointer hover:text-white text-[18px]">settings</span>
<span class="material-symbols-outlined cursor-pointer hover:text-white text-[18px]">mail</span>
<span class="material-symbols-outlined cursor-pointer hover:text-white text-[18px]">lock</span>
</div>
</aside>

<!-- Main Content -->
<main class="pl-[260px] min-h-screen flex flex-col">
<header class="h-[70px] flex justify-between items-center px-8">
<div class="flex items-center gap-6">
<span class="material-symbols-outlined text-slate-400 cursor-pointer">menu</span>
<span class="material-symbols-outlined text-slate-400 cursor-pointer">fullscreen</span>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-3 group cursor-pointer">
<img alt="Profile" class="w-8 h-8 rounded-full border border-indigo-500/30 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=6366f1&color=fff"/>
</div>
<form method="POST" action="{{ route('logout') }}">
@csrf
<a class="flex items-center gap-2 text-slate-400 hover:text-white transition-colors group cursor-pointer" onclick="this.closest('form').submit()">
<span class="material-symbols-outlined text-[20px] group-hover:translate-x-0.5 transition-transform">logout</span>
<span class="text-[13px] font-medium">Keluar</span>
</a>
</form>
</div>
</header>

<div class="flex-1 p-8 overflow-y-auto custom-scrollbar">

@if(session('success'))
<div id="flash-msg" class="max-w-[1200px] mx-auto mb-4 px-5 py-3 rounded-xl bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 text-[13px] font-medium flex items-center gap-2">
<span class="material-symbols-outlined text-[18px]">check_circle</span>{{ session('success') }}
</div>
@endif

<a href="{{ URL::previous() }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-[13px] transition-colors mb-6">
<span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 space-y-6">
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
<div>
<h2 class="text-[20px] font-semibold text-white">Detail Pesanan</h2>
<p class="text-[13px] text-slate-500 mt-1 font-mono">{{ $pesanan->code }}</p>
</div>
@php
 $bc=['masuk'=>'bg-blue-500/15 text-blue-400 border-blue-500/20','dikonfirmasi'=>'bg-amber-500/15 text-amber-400 border-amber-500/20','dikemas'=>'bg-purple-500/15 text-purple-400 border-purple-500/20','dikirim'=>'bg-cyan-500/15 text-cyan-400 border-cyan-500/20','diperjalanan'=>'bg-orange-500/15 text-orange-400 border-orange-500/20','selesai'=>'bg-emerald-500/15 text-emerald-400 border-emerald-500/20','dibatalkan'=>'bg-red-500/15 text-red-400 border-red-500/20'];
 $bl=['masuk'=>'Masuk','dikonfirmasi'=>'Dikonfirmasi','dikemas'=>'Dikemas','dikirim'=>'Dikirim','diperjalanan'=>'Dalam Perjalanan','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
@endphp
<span class="text-[12px] font-bold px-3 py-1.5 rounded-full border self-start {{ $bc[$pesanan->status] ?? '' }}">{{ $bl[$pesanan->status] ?? strtoupper($pesanan->status) }}</span>
</div>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
<div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10"><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Tanggal</div><div class="text-[14px] text-white font-medium">{{ $pesanan->created_at->format('d M Y') }}</div><div class="text-[12px] text-slate-500">{{ $pesanan->created_at->format('H:i') }} WIB</div></div>
<div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10"><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">ID</div><div class="text-[14px] text-white font-medium font-mono">#{{ $pesanan->id }}</div></div>
<div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10"><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Jumlah Item</div><div class="text-[14px] text-white font-medium">{{ is_array($pesanan->items) ? count($pesanan->items) : 0 }} produk</div></div>
<div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10"><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Total</div><div class="text-[14px] text-indigo-400 font-bold">Rp {{ number_format($pesanan->total_price, 0, ',', '.') }}</div></div>
</div>
</div>
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
<h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[18px] text-indigo-400">shopping_bag</span> Item Pesanan</h3>
@php $items = is_array($pesanan->items) ? $pesanan->items : json_decode($pesanan->items, true) ?? []; @endphp
@if(count($items) > 0)
<div class="border border-outline-variant/30 rounded-lg overflow-hidden">
<table class="w-full text-left">
<thead><tr class="bg-[#24243a] border-b border-outline-variant/30">
<th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Produk</th>
<th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase text-center">Qty</th>
<th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase text-right">Harga</th>
<th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase text-right">Subtotal</th>
</tr></thead>
<tbody>
@foreach($items as $i)
<tr class="border-b border-outline-variant/10 last:border-b-0">
<td class="px-4 py-3"><div class="flex items-center gap-3">
@if(isset($i['image']) && $i['image'])<img src="{{ $i['image'] }}" class="w-10 h-10 rounded-lg object-cover border border-outline-variant/20" alt=""/>
@else<div class="w-10 h-10 rounded-lg bg-[#121220] border border-outline-variant/20 flex items-center justify-center"><span class="material-symbols-outlined text-[16px] text-slate-600">image</span></div>@endif
<span class="text-[13px] text-slate-200">{{ $i['name'] ?? '-' }}</span></div></td>
<td class="px-4 py-3 text-[13px] text-slate-300 text-center">{{ $i['qty'] ?? 1 }}</td>
<td class="px-4 py-3 text-[13px] text-slate-400 text-right">Rp {{ number_format($i['price'] ?? 0, 0, ',', '.') }}</td>
<td class="px-4 py-3 text-[13px] text-white font-medium text-right">Rp {{ number_format(($i['price'] ?? 0) * ($i['qty'] ?? 1), 0, ',', '.') }}</td>
</tr>
@endforeach
</tbody>
<tfoot><tr class="bg-[#121220]"><td colspan="3" class="px-4 py-3 text-[13px] font-bold text-white text-right">Total</td><td class="px-4 py-3 text-[14px] font-bold text-indigo-400 text-right">Rp {{ number_format($pesanan->total_price, 0, ',', '.') }}</td></tr></tfoot>
</table>
</div>
@else
<div class="text-center py-10 text-slate-500 text-[13px]"><span class="material-symbols-outlined text-[36px] text-slate-600/50 block mb-2">remove_shopping_cart</span>Tidak ada item</div>
@endif
</div>
</div>

<div class="space-y-6">
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
<h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[18px] text-indigo-400">person</span> Info Pelanggan</h3>
<div class="space-y-4">
<div><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Nama</div><div class="text-[14px] text-slate-200">{{ $pesanan->customer_name ?? '-' }}</div></div>
<div><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Telepon</div><div class="text-[14px] text-slate-200">{{ $pesanan->customer_phone ?? '-' }}</div></div>
@if($pesanan->notes)<div><div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Catatan</div><div class="text-[13px] text-slate-400 bg-[#121220] rounded-lg p-3 border border-outline-variant/10">{{ $pesanan->notes }}</div></div>@endif
</div>
</div>

<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
<h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[18px] text-indigo-400">timeline</span> Riwayat Status</h3>
@php
 $steps=[['key'=>'masuk','label'=>'Pesanan Masuk','icon'=>'inbox'],['key'=>'dikonfirmasi','label'=>'Dikonfirmasi','icon'=>'check_circle'],['key'=>'dikemas','label'=>'Dikemas','icon'=>'inventory_2'],['key'=>'dikirim','label'=>'Dikirim','icon'=>'local_shipping'],['key'=>'diperjalanan','label'=>'Dalam Perjalanan','icon'=>'directions_bike'],['key'=>'selesai','label'=>'Selesai','icon'=>'verified']];
 $statusOrder=array_column($steps,'key');$currentIdx=array_search($pesanan->status,$statusOrder);$isCancelled=$pesanan->status==='dibatalkan';
@endphp
<div class="space-y-0">
@foreach($steps as $i => $step)
@php $isDone=!$isCancelled&&$i<=$currentIdx; $isActive=!$isCancelled&&$i===$currentIdx; $isFuture=!$isCancelled&&$i>$currentIdx; @endphp
<div class="flex gap-3">
<div class="flex flex-col items-center">
<div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $isDone?'bg-emerald-500/20 text-emerald-400':'bg-[#121220] text-slate-600 border border-outline-variant/20' }} {{ $isActive?'ring-2 ring-emerald-500/40':'' }}">
<span class="material-symbols-outlined text-[16px]">{{ $isDone?'check':$step['icon'] }}</span>
</div>
@unless($loop->last)<div class="w-0.5 h-8 flex-1 {{ $isDone?'bg-emerald-500/30':'bg-outline-variant/20' }}"></div>@endunless
</div>
<div class="pb-6">
<div class="text-[13px] {{ $isActive?'text-white font-semibold':($isDone?'text-slate-300':'text-slate-600') }}">{{ $step['label'] }}</div>
@if($isActive)<div class="text-[11px] text-slate-500 mt-0.5">Status saat ini</div>@endif
</div>
</div>
@endforeach
@if($isCancelled)
<div class="flex gap-3">
<div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500/20 text-red-400 ring-2 ring-red-500/40"><span class="material-symbols-outlined text-[16px]">cancel</span></div>
<div><div class="text-[13px] text-red-400 font-semibold">Dibatalkan</div><div class="text-[11px] text-slate-500 mt-0.5">Pesanan ini dibatalkan</div></div>
</div>
@endif
</div>
</div>

@if(!$isCancelled && $pesanan->status !== 'selesai')
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
<h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[18px] text-indigo-400">bolt</span> Aksi</h3>
<div class="space-y-2">
@if($pesanan->status === 'masuk')
<form method="POST" action="{{ route('admin.pesanan.aksi.konfirmasi', $pesanan->id) }}">@csrf<button type="submit" onclick="return confirm('Konfirmasi pesanan ini?')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-[13px] font-semibold transition-colors"><span class="material-symbols-outlined text-[18px]">check_circle</span> Konfirmasi Pesanan</button></form>
<form method="POST" action="{{ route('admin.pesanan.aksi.dibatalkan', $pesanan->id) }}">@csrf<button type="submit" onclick="return confirm('Yakin batalkan pesanan ini?')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-600/10 border border-red-500/20 hover:bg-red-600/20 text-red-400 text-[13px] font-semibold transition-colors"><span class="material-symbols-outlined text-[18px]">cancel</span> Batalkan Pesanan</button></form>
@endif
@if($pesanan->status === 'dikonfirmasi')
<form method="POST" action="{{ route('admin.pesanan.aksi.dikemas', $pesanan->id) }}">@csrf<button type="submit" onclick="return confirm('Tandai sebagai dikemas?')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-[13px] font-semibold transition-colors"><span class="material-symbols-outlined text-[18px]">inventory_2</span> Tandai Dikemas</button></form>
@endif
@if($pesanan->status === 'dikemas')
<form method="POST" action="{{ route('admin.pesanan.aksi.dikirim', $pesanan->id) }}">@csrf<button type="submit" onclick="return confirm('Tandai sebagai dikirim?')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white text-[13px] font-semibold transition-colors"><span class="material-symbols-outlined text-[18px]">local_shipping</span> Tandai Dikirim</button></form>
@endif
@if($pesanan->status === 'dikirim')
<form method="POST" action="{{ route('admin.pesanan.aksi.diperjalanan', $pesanan->id) }}">@csrf<button type="submit" onclick="return confirm('Tandai dalam perjalanan?')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-orange-600 hover:bg-orange-500 text-white text-[13px] font-semibold transition-colors"><span class="material-symbols-outlined text-[18px]">directions_bike</span> Dalam Perjalanan</button></form>
@endif
@if($pesanan->status === 'diperjalanan')
<form method="POST" action="{{ route('admin.pesanan.aksi.selesai', $pesanan->id) }}">@csrf<button type="submit" onclick="return confirm('Tandai pesanan selesai?')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-[13px] font-semibold transition-colors"><span class="material-symbols-outlined text-[18px]">verified</span> Tandai Selesai</button></form>
@endif
</div>
</div>
@endif

</div>
</div>

</div>

<footer class="px-8 py-6 flex justify-between items-center text-[11px] text-slate-500">
<div>&copy; {{ date('Y') }} <span class="text-indigo-400">Salza E-commerce</span>. All Rights Reserved.</div>
<div>Versi / <span class="text-white">1.1</span></div>
</footer>
</main>

<script>
const flash=document.getElementById('flash-msg');
if(flash){setTimeout(()=>{flash.style.transition='opacity .4s,transform .4s';flash.style.opacity='0';flash.style.transform='translateY(-10px)';setTimeout(()=>flash.remove(),400)},4000)}
function togglePesanan(){const s=document.getElementById('pesanan-submenu'),a=document.getElementById('pesanan-arrow'),h=s.classList.contains('hidden');if(h){s.classList.remove('hidden');a.style.transform='rotate(180deg)'}else{s.classList.add('hidden');a.style.transform='rotate(0deg)'}}
</script>
</body>
</html>