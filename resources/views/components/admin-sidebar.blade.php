<aside class="w-64 bg-dashboard-card flex-shrink-0 flex flex-col border-r border-slate-700/50 fixed h-full z-30">
    <div class="p-6 flex items-center space-x-2">
        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-xl">S</span>
        </div>
        <div>
            <span class="text-lg font-bold text-white tracking-wider">SALZA</span>
            <p class="text-[9px] text-purple-400 font-semibold uppercase tracking-widest">Admin Panel</p>
        </div>
    </div>
    <nav class="flex-1 overflow-y-auto px-4 py-2 text-sm">
        <!-- Dashboard -->
        <div class="mb-6">
            <a class="flex items-center px-4 py-3 rounded-lg transition-all @if(Route::currentRouteName() === 'admin.dashboard') text-white shadow-lg shadow-purple-500/20 bg-slate-700/50 @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.dashboard') }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Dashboard
            </a>
        </div>

        <!-- Data Master -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Data Master</p>
            <ul class="space-y-1">
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'admin.brands.index') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.brands.index') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Merek</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'admin.kategori') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.kategori') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Kategori</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                <li>
                    <div class="flex items-center justify-between px-4 py-2 rounded-lg text-slate-400 cursor-default">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m8-4v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </span>
                        Produk
                    </div>
                    <ul class="ml-7 mt-1 space-y-1 border-l border-slate-700/50 pl-4">
                        <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.produk') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.produk') }}"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.produk') bg-purple-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Data Produk</a></li>
                        <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.produk.create') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.produk.create') }}"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.produk.create') bg-purple-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Tambah Produk</a></li>
                    </ul>
                </li>
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'admin.slider') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.slider') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Slider</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'admin.kupon') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.kupon') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Kupon</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors text-slate-400 hover:bg-slate-700/50 hover:text-white" href="{{ route('admin.wilayah') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Data Wilayah</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
            </ul>
        </div>

        <!-- Kelola Pesanan — expanded sub-menu -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Kelola Pesanan</p>
            <ul class="space-y-1">
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors text-slate-400 hover:bg-slate-700/50 hover:text-white" href="#">
                    <span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0H4m0 14h16M5 9h10l-2-2m0 0l2 2m0 0h-4m-4-4h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Pesanan Masuk</span>
                </a></li>
                <ul class="ml-7 mt-1 space-y-1 border-l border-slate-700/50 pl-4">
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.pesanan') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admin.pesanan.masuk') }}"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.pesanan') bg-emerald-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Pesanan Masuk</a></li>
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.pesanan.konfirmasi') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="#"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.pesanan.konfirmasi') bg-blue-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Konfirmasi</a></li>
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.pesanan.dalam_perjalanan') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="#"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.pesanan.dalam_perjalanan') bg-amber-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Dalam Perjalanan</a></li>
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.pesanan.dikemas') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="#"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.pesanan.dikemas') bg-purple-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Dikemas</a></li>
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.pesanan.dikirim') bg-slate-700/50 text-white font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="#"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.pesanan.dikirim') bg-cyan-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Dikirim</a></li>
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] @if(Route::currentRouteName() === 'admin.pesanan.selesai') bg-slate-600/50 text-slate-300 font-medium @else text-slate-500 hover:bg-slate-700/50 hover:text-white @endif" href="#"><span class="w-1.5 h-1.5 rounded-full @if(Route::currentRouteName() === 'admin.pesanan.selesai') bg-slate-400 @else bg-slate-600 @endif mr-2.5 flex-shrink-0"></span>Selesai</a></li>
                    <li><a class="flex items-center px-3 py-1.5 rounded-lg transition-colors text-[13px] text-slate-500 hover:bg-slate-700/50 hover:text-white" href="#"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Dibatalkan</span><svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                </ul>
            </div>

        <!-- Pengaturan -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Pengaturan</p>
            <ul class="space-y-1">
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors text-slate-400 hover:bg-slate-700/50 hover:text-white" href="{{ route('admin.users') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Data User</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors text-slate-400 hover:bg-slate-700/50 hover:text-white" href="{{ route('admin.admins') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>Data Admin</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
                <li><a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors text-slate-400 hover:bg-slate-700/50 hover:text-white" href="{{ route('admin.laporan') }}"><span class="flex items-center"><svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-linecap="round" stroke-width="2"></path></svg>Laporan</span><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></li>
            </ul>
        </div>
    </nav>
</aside>
