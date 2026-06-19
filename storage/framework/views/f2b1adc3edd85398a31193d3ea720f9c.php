<aside class="w-64 bg-dashboard-card flex-shrink-0 flex flex-col border-r border-slate-700/50 fixed h-full z-30">
    <!-- Logo -->
    <div class="p-6 flex items-center space-x-2">
        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-xl">S</span>
        </div>
        <div>
            <span class="text-lg font-bold text-white tracking-wider">SALZA</span>
            <p class="text-[9px] text-emerald-400 font-semibold uppercase tracking-widest">Akun Saya</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-2 text-sm">
        <!-- Dashboard -->
        <div class="mb-6">
            <a class="flex items-center px-4 py-3 rounded-lg transition-all <?php if(Route::currentRouteName() === 'pelanggan.dashboard'): ?> text-white shadow-lg shadow-emerald-500/20 bg-slate-700/50 <?php else: ?> text-slate-400 hover:bg-slate-700/50 hover:text-white <?php endif; ?>" href="<?php echo e(route('pelanggan.dashboard')); ?>">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Dashboard
            </a>
        </div>

        <!-- Pesanan -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Pesanan</p>
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors <?php if(Route::currentRouteName() === 'pelanggan.pesanan'): ?> bg-slate-700/50 text-white <?php else: ?> text-slate-400 hover:bg-slate-700/50 hover:text-white <?php endif; ?>" href="<?php echo e(route('pelanggan.pesanan')); ?>">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Pesanan Saya
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors <?php if(Route::currentRouteName() === 'pelanggan.ulasan'): ?> bg-slate-700/50 text-white <?php else: ?> text-slate-400 hover:bg-slate-700/50 hover:text-white <?php endif; ?>" href="<?php echo e(route('pelanggan.ulasan')); ?>">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Ulasan Saya
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Pengaturan -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Pengaturan</p>
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors <?php if(Route::currentRouteName() === 'pelanggan.profil'): ?> bg-slate-700/50 text-white <?php else: ?> text-slate-400 hover:bg-slate-700/50 hover:text-white <?php endif; ?>" href="<?php echo e(route('pelanggan.profil')); ?>">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Profil
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors <?php if(Route::currentRouteName() === 'pelanggan.alamat'): ?> bg-slate-700/50 text-white <?php else: ?> text-slate-400 hover:bg-slate-700/50 hover:text-white <?php endif; ?>" href="<?php echo e(route('pelanggan.alamat')); ?>">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Alamat
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
<?php /**PATH C:\laragon\www\UMKM-main\resources\views/components/pelanggan-sidebar.blade.php ENDPATH**/ ?>