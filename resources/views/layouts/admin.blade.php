<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>@yield('title', 'Salza Admin') - Admin</title>
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
@yield('additional-css')
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

<!-- Dashboard -->
<a class="flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-active-gradient text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.dashboard') }}">
<span class="material-symbols-outlined text-[20px]">dashboard</span>
<span class="text-[13px] {{ request()->routeIs('admin.dashboard') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
</a>

<!-- Data Master -->
<div class="px-4 py-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Data Master</div>
<a class="flex items-center justify-between {{ request()->routeIs('admin.brands.index') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.brands.index') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">list</span><span class="text-[13px] font-medium">Merek</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.kategori') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.kategori') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">category</span><span class="text-[13px] font-medium">Kategori</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.produk') || request()->routeIs('admin.produk.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.produk') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span class="text-[13px] font-medium">Produk</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.slider') || request()->routeIs('admin.slider.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.slider') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">view_carousel</span><span class="text-[13px] font-medium">Slider</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.kupon') || request()->routeIs('admin.kupon.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.kupon') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">confirmation_number</span><span class="text-[13px] font-medium">Kupon</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>

<!-- Kelola Pesanan -->
<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Kelola Pesanan</div>

{{-- Pesanan Parent (POLOS, klik toggle) --}}
<div onclick="togglePesanan()" class="flex items-center justify-between {{ request()->routeIs('admin.pesanan.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all cursor-pointer select-none">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-[20px]">list_alt</span>
<span class="text-[13px] font-medium">Pesanan</span>
</div>
<span id="pesanan-arrow" class="material-symbols-outlined text-[16px] transition-transform duration-200 {{ request()->routeIs('admin.pesanan.*') ? '' : '' }}" style="{{ request()->routeIs('admin.pesanan.*') ? 'transform:rotate(180deg)' : '' }}">expand_more</span>
</div>

{{-- Sub-menu Pesanan --}}
<div id="pesanan-submenu" class="pl-6 space-y-1 mt-1 mb-1 {{ request()->routeIs('admin.pesanan.*') ? '' : 'hidden' }}">
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

<a class="flex items-center justify-between {{ request()->routeIs('admin.pembatalan') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.pembatalan') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">cancel</span><span class="text-[13px] font-medium">Pembatalan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.pengembalian') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.pengembalian') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">assignment_return</span><span class="text-[13px] font-medium">Pengembalian</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.ulasan') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.ulasan') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">reviews</span><span class="text-[13px] font-medium">Ulasan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.stok') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.stok') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory</span><span class="text-[13px] font-medium">Stok Produk</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>

<!-- Pengaturan -->
<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Pengaturan</div>
<a class="flex items-center justify-between {{ request()->routeIs('admin.users') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.users') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">group</span><span class="text-[13px] font-medium">Data User</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.admins') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.admins') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">admin_panel_settings</span><span class="text-[13px] font-medium">Data Admin</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.laporan') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.laporan') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">bar_chart</span><span class="text-[13px] font-medium">Laporan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
</nav>
<div class="p-4 border-t border-outline-variant/20 flex items-center justify-around text-slate-500">
<span class="material-symbols-outlined cursor-pointer hover:text-white text-[18px]">settings</span>
<span class="material-symbols-outlined cursor-pointer hover:text-white text-[18px]">mail</span>
<span class="material-symbols-outlined cursor-pointer hover:text-white text-[18px]">lock</span>
</div>
</aside>

<!-- Main Content -->
<main class="pl-[260px] min-h-screen flex flex-col">
<!-- Header -->
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

<!-- Content Area -->
<div class="flex-1 p-8 overflow-y-auto custom-scrollbar">

{{-- Flash Message --}}
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

@yield('content')

</div>

<!-- Footer -->
<footer class="px-8 py-6 flex justify-between items-center text-[11px] text-slate-500">
<div>&copy; {{ date('Y') }} <span class="text-indigo-400">Salza E-commerce</span>. All Rights Reserved.</div>
<div>Versi / <span class="text-white">1.1</span></div>
</footer>
</main>

<script>
const flash=document.getElementById('flash-msg');
if(flash){setTimeout(()=>{flash.style.transition='opacity .4s,transform .4s';flash.style.opacity='0';flash.style.transform='translateY(-10px)';setTimeout(()=>flash.remove(),400)},4000)}
function togglePesanan(){const s=document.getElementById('pesanan-submenu'),a=document.getElementById('pesanan-arrow'),h=s.classList.contains('hidden');if(h){s.classList.remove('hidden');a.style.transform='rotate(180deg)'}else{s.classList.add('hidden');a.style.transform='rotate(0deg)'}}
@yield('additional-js')
</script>
</body>
</html>