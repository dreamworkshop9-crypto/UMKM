<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Salza Admin - {{ $pageTitle ?? 'Pesanan Masuk' }}</title>
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
<span class="material-symbols-outlined text-[20px]">dashboard</span>
<span class="text-[13px] font-medium">Dashboard</span>
</a>
<div class="px-4 py-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Data Master</div>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.brands.index') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">list</span><span class="text-[13px] font-medium">Merek</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.kategori') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">category</span><span class="text-[13px] font-medium">Kategori</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.produk') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span class="text-[13px] font-medium">Produk</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.slider') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">view_carousel</span><span class="text-[13px] font-medium">Slider</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.kupon') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">confirmation_number</span><span class="text-[13px] font-medium">Kupon</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>

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
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.masuk') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.masuk') }}">
<span class="material-symbols-outlined text-[14px]">{{ request()->routeIs('admin.pesanan.masuk') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Masuk</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.dikonfirmasi') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikonfirmasi') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.dikonfirmasi') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.dikonfirmasi') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Di Konfirmasi</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.dikemas') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikemas') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.dikemas') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.dikemas') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Di Kemas</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.dikirim') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikirim') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.dikirim') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.dikirim') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Dikirim</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.diperjalanan') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.diperjalanan') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.diperjalanan') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.diperjalanan') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Dalam Perjalanan</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.selesai') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.selesai') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.selesai') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.selesai') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Selesai</span>
</a>
</div>

<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.pembatalan') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">cancel</span><span class="text-[13px] font-medium">Pembatalan</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.pengembalian') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">assignment_return</span><span class="text-[13px] font-medium">Pengembalian</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.ulasan') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">reviews</span><span class="text-[13px] font-medium">Ulasan</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.stok') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory</span><span class="text-[13px] font-medium">Stok Produk</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>

<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Pengaturan</div>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.users') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">group</span><span class="text-[13px] font-medium">Data User</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.admins') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">admin_panel_settings</span><span class="text-[13px] font-medium">Data Admin</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
<a class="flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.laporan') }}"><div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">bar_chart</span><span class="text-[13px] font-medium">Laporan</span></div><span class="material-symbols-outlined text-[16px]">chevron_right</span></a>
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
@if(session('error'))
<div id="flash-msg" class="max-w-[1200px] mx-auto mb-4 px-5 py-3 rounded-xl bg-red-600/20 border border-red-500/30 text-red-400 text-[13px] font-medium flex items-center gap-2">
<span class="material-symbols-outlined text-[18px]">error</span>{{ session('error') }}
</div>
@endif

<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
<div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
<h2 class="text-[16px] font-semibold text-white">{{ $pageTitle ?? 'Pesanan Masuk' }}</h2>
<span class="bg-indigo-600 text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[24px] h-[24px] flex items-center justify-center">{{ $pesanan->total() }}</span>
</div>

<div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-3">
<div class="flex items-center gap-2 text-slate-400 text-[13px]">
<span>Show</span>
<select id="perPage" class="bg-[#121220] border border-outline-variant/30 rounded-md px-3 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none text-[13px]">
<option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
<option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
<option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
</select>
<span>entries</span>
</div>
<div class="flex items-center gap-3">
<span class="text-slate-400 text-[13px]">Search:</span>
<input id="searchInput" class="bg-[#121220] border border-outline-variant/30 rounded-md px-4 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none w-[200px] text-[13px] placeholder-slate-600" type="text" placeholder="Cari kode / nama..." value="{{ request('search') }}"/>
</div>
</div>

<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-[#24243a]">
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode Pesanan</th>
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Bayar</th>
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
<th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
</tr>
</thead>
<tbody>
@if($pesanan->count() > 0)
@foreach($pesanan as $index => $item)
<tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
<td class="px-6 py-4 text-[13px] text-slate-400">{{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $index + 1 }}</td>
<td class="px-6 py-4 text-[13px] text-slate-300 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}<span class="block text-[11px] text-slate-500">{{ $item->created_at->format('H:i') }}</span></td>
<td class="px-6 py-4 text-[13px] text-indigo-400 font-mono font-medium">{{ $item->code }}</td>
<td class="px-6 py-4"><div class="text-[13px] text-slate-200">{{ $item->customer_name }}</div><div class="text-[11px] text-slate-500">{{ $item->customer_phone }}</div></td>
<td class="px-6 py-4 text-[13px] text-white font-semibold whitespace-nowrap">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
<td class="px-6 py-4">
@php
 $bc=['masuk'=>'bg-blue-500/15 text-blue-400 border-blue-500/20','dikonfirmasi'=>'bg-amber-500/15 text-amber-400 border-amber-500/20','dikemas'=>'bg-purple-500/15 text-purple-400 border-purple-500/20','dikirim'=>'bg-cyan-500/15 text-cyan-400 border-cyan-500/20','diperjalanan'=>'bg-orange-500/15 text-orange-400 border-orange-500/20','selesai'=>'bg-emerald-500/15 text-emerald-400 border-emerald-500/20','dibatalkan'=>'bg-red-500/15 text-red-400 border-red-500/20'];
 $bl=['masuk'=>'Masuk','dikonfirmasi'=>'Dikonfirmasi','dikemas'=>'Dikemas','dikirim'=>'Dikirim','diperjalanan'=>'Dalam Perjalanan','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
@endphp
<span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $bc[$item->status] ?? 'bg-slate-500/15 text-slate-400' }}">{{ $bl[$item->status] ?? strtoupper($item->status) }}</span>
</td>
<td class="px-6 py-4">
<div class="flex items-center gap-1.5">
<a href="{{ route('admin.pesanan.show', $item->id) }}" class="p-1.5 rounded-lg bg-slate-500/10 text-slate-400 hover:text-white hover:bg-slate-500/20 transition-all" title="Detail"><span class="material-symbols-outlined text-[16px]">visibility</span></a>
@if($statusKey === 'masuk')
<form method="POST" action="{{ route('admin.pesanan.aksi.konfirmasi', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Konfirmasi {{ $item->code }}?')" class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:text-white hover:bg-emerald-500/20 transition-all" title="Konfirmasi"><span class="material-symbols-outlined text-[16px]">check_circle</span></button></form>
<form method="POST" action="{{ route('admin.pesanan.aksi.dibatalkan', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Batalkan {{ $item->code }}?')" class="p-1.5 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Batalkan"><span class="material-symbols-outlined text-[16px]">cancel</span></button></form>
@endif
@if($statusKey === 'dikonfirmasi')
<form method="POST" action="{{ route('admin.pesanan.aksi.dikemas', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Kemas {{ $item->code }}?')" class="p-1.5 rounded-lg bg-purple-500/10 text-purple-400 hover:text-white hover:bg-purple-500/20 transition-all" title="Kemas"><span class="material-symbols-outlined text-[16px]">inventory_2</span></button></form>
@endif
@if($statusKey === 'dikemas')
<form method="POST" action="{{ route('admin.pesanan.aksi.dikirim', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Kirim {{ $item->code }}?')" class="p-1.5 rounded-lg bg-cyan-500/10 text-cyan-400 hover:text-white hover:bg-cyan-500/20 transition-all" title="Kirim"><span class="material-symbols-outlined text-[16px]">local_shipping</span></button></form>
@endif
@if($statusKey === 'dikirim')
<form method="POST" action="{{ route('admin.pesanan.aksi.diperjalanan', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Dalam perjalanan {{ $item->code }}?')" class="p-1.5 rounded-lg bg-orange-500/10 text-orange-400 hover:text-white hover:bg-orange-500/20 transition-all" title="Dalam Perjalanan"><span class="material-symbols-outlined text-[16px]">directions_bike</span></button></form>
@endif
@if($statusKey === 'diperjalanan')
<form method="POST" action="{{ route('admin.pesanan.aksi.selesai', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Selesai {{ $item->code }}?')" class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:text-white hover:bg-emerald-500/20 transition-all" title="Selesai"><span class="material-symbols-outlined text-[16px]">verified</span></button></form>
@endif
</div>
</td>
</tr>
@endforeach
@else
<tr>
<td class="px-6 py-10 text-center text-slate-500 text-[13px]" colspan="7">
<div class="flex flex-col items-center gap-2 py-8">
<span class="material-symbols-outlined text-[48px] opacity-10">inbox</span>
<span>Tidak ada data pesanan</span>
</div>
</td>
</tr>
@endif
</tbody>
</table>
</div>

<div class="px-6 py-4 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
<p class="text-[13px] text-slate-500">Showing {{ $pesanan->firstItem() ?? 0 }} to {{ $pesanan->lastItem() ?? 0 }} of {{ $pesanan->total() }} entries</p>
<div class="flex">
<a href="{{ $pesanan->appends(request()->query())->previousPageUrl() ?? '#' }}" class="px-4 py-2 border border-outline-variant/30 bg-[#212135] text-slate-400 rounded-l-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $pesanan->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">Previous</a>
<a href="{{ $pesanan->appends(request()->query())->nextPageUrl() ?? '#' }}" class="px-4 py-2 border border-l-0 border-outline-variant/30 bg-[#212135] text-slate-400 rounded-r-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $pesanan->hasMorePages() ? '' : 'opacity-40 pointer-events-none' }}">Next</a>
</div>
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
let st;document.getElementById('searchInput').addEventListener('input',function(e){clearTimeout(st);st=setTimeout(()=>{const p=new URLSearchParams(location.search);e.target.value?p.set('search',e.target.value):p.delete('search');p.delete('page');location.href=location.pathname+'?'+p.toString()},500)});
document.getElementById('perPage').addEventListener('change',function(e){const p=new URLSearchParams(location.search);p.set('per_page',e.target.value);p.delete('page');location.href=location.pathname+'?'+p.toString()});
function togglePesanan(){const s=document.getElementById('pesanan-submenu'),a=document.getElementById('pesanan-arrow'),h=s.classList.contains('hidden');if(h){s.classList.remove('hidden');a.style.transform='rotate(180deg)'}else{s.classList.add('hidden');a.style.transform='rotate(0deg)'}}
</script>
</body>
</html>