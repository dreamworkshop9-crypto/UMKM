<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALZA - Marketplace Sepatu UMKM</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans:['Inter','sans-serif'], display:['Playfair Display','serif'] },
                    colors: {
                        brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' }
                    }
                }
            }
        }
    </script>
    <style>
        .bg-dashboard-card{background:#1e293b}
        .glass-nav{background:rgba(15,23,42,.85);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px)}
        .hero-glow{background:radial-gradient(ellipse at 70% 50%,rgba(16,185,129,.15) 0%,transparent 60%)}
        .card-hover{transition:all .4s cubic-bezier(.4,0,.2,1)}
        .card-hover:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,.3),0 0 0 1px rgba(16,185,129,.2)}
        .img-zoom img{transition:transform .6s cubic-bezier(.4,0,.2,1)}
        .img-zoom:hover img{transform:scale(1.08)}
        .fade-up{opacity:0;transform:translateY(30px);transition:all .7s cubic-bezier(.4,0,.2,1)}
        .fade-up.visible{opacity:1;transform:translateY(0)}
        .toast-enter{animation:toastIn .4s ease-out forwards}
        .toast-exit{animation:toastOut .3s ease-in forwards}
        @keyframes toastIn{from{opacity:0;transform:translateX(100px)}to{opacity:1;transform:translateX(0)}}
        @keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100px)}}
        @keyframes float{0%,100%{transform:translateY(0) rotate(-5deg)}50%{transform:translateY(-20px) rotate(-5deg)}}
        .float-anim{animation:float 6s ease-in-out infinite}
        @keyframes pulse-ring{0%{transform:scale(1);opacity:.5}100%{transform:scale(1.5);opacity:0}}
        .pulse-ring::before{content:'';position:absolute;inset:-4px;border-radius:50%;border:2px solid #10b981;animation:pulse-ring 2s ease-out infinite}
        .scrollbar-hide::-webkit-scrollbar{display:none}
        .scrollbar-hide{-ms-overflow-style:none;scrollbar-width:none}
        input:focus,select:focus,textarea:focus{outline:none}
        .line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .auth-tab{position:relative}
        .auth-tab.active{color:#34d399}
        .auth-tab.active::after{content:'';position:absolute;bottom:-1px;left:0;right:0;height:2px;background:#10b981;border-radius:2px}
    </style>
</head>
<body class="font-sans text-white antialiased" style="background:#0f172a">

    
    <?php if(session('success')): ?>
    <div id="flash-msg" class="fixed top-24 right-4 z-[80] flex items-center gap-3 px-5 py-4 bg-slate-800 border border-brand-500/30 rounded-xl shadow-2xl max-w-sm toast-enter">
        <i class="fa-solid fa-circle-check text-brand-400 text-lg flex-shrink-0"></i>
        <p class="text-sm text-slate-200"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    
    <nav id="navbar" class="glass-nav fixed top-0 left-0 right-0 z-50 border-b border-slate-700/30 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="<?php echo e(route('front.home')); ?>" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-400 to-brand-600 rounded-lg flex items-center justify-center"><i class="fa-solid fa-shoe-prints text-white text-sm"></i></div>
                    <span class="text-xl font-bold tracking-tight">SALZA</span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#beranda" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Beranda</a>
                    <a href="#produk" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Produk</a>
                    <a href="#tentang" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Tentang</a>
                    <a href="#cara-pesan" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Cara Pesan</a>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button onclick="openCart()" class="relative w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span id="cart-badge" class="hidden absolute -top-1 -right-1 w-5 h-5 bg-brand-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">0</span>
                    </button>
                    <?php if(auth()->guard()->guest()): ?>
                    <button onclick="openAuthModal('login')" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk
                    </button>
                    <?php endif; ?>
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('pelanggan.pesanan')); ?>" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fa-solid fa-box text-xs"></i> Pesanan
                    </a>
                    <div class="hidden sm:block relative" id="dd-wrap">
                        <button onclick="document.getElementById('dd-menu').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-700/50 transition-all">
                            <div class="w-8 h-8 bg-brand-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-user text-brand-400 text-xs"></i></div>
                            <span class="text-sm text-slate-300 max-w-[100px] truncate"><?php echo e(auth()->user()->name); ?></span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-500"></i>
                        </button>
                        <div id="dd-menu" class="hidden absolute right-0 top-full mt-2 w-56 bg-slate-800 border border-slate-700/30 rounded-xl shadow-2xl overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-slate-700/30">
                                <p class="text-sm font-semibold text-white"><?php echo e(auth()->user()->name); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e(auth()->user()->email); ?></p>
                            </div>
                            <div class="py-1">
                                <a href="<?php echo e(route('pelanggan.dashboard')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50"><i class="fa-solid fa-gauge w-4 text-center text-slate-500"></i>Dashboard</a>
                                <a href="<?php echo e(route('pelanggan.pesanan')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50"><i class="fa-solid fa-box w-4 text-center text-slate-500"></i>Pesanan Saya</a>
                            </div>
                            <div class="border-t border-slate-700/30 py-1">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-rose-400 hover:bg-rose-500/10"><i class="fa-solid fa-right-from-bracket w-4 text-center"></i>Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all"><i id="mob-icon" class="fa-solid fa-bars"></i></button>
                </div>
            </div>
        </div>
        <div id="search-bar" class="hidden border-t border-slate-700/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input id="search-input" type="text" placeholder="Cari sepatu..." class="w-full pl-11 pr-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all" oninput="filterProducts()">
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-700/30">
            <div class="px-4 py-4 space-y-1">
                <a href="#beranda" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Beranda</a>
                <a href="#produk" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Produk</a>
                <a href="#tentang" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Tentang</a>
                <a href="#cara-pesan" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Cara Pesan</a>
                <?php if(auth()->guard()->guest()): ?>
                <button onclick="openAuthModal('login');toggleMobileMenu();" class="block w-full text-left px-4 py-3 text-sm font-medium text-brand-400 hover:bg-brand-500/10 rounded-lg"><i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk / Daftar</button>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('pelanggan.pesanan')); ?>" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700/50 rounded-lg"><i class="fa-solid fa-box mr-2"></i>Pesanan Saya</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm font-medium text-rose-400 hover:bg-rose-500/10 rounded-lg"><i class="fa-solid fa-right-from-bracket mr-2"></i>Keluar</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <section id="beranda" class="relative min-h-screen flex items-center pt-20 hero-glow overflow-hidden">
        <div class="absolute top-32 right-10 w-72 h-72 bg-brand-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-56 h-56 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="fade-up">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500/10 border border-brand-500/20 rounded-full mb-6">
                        <span class="w-2 h-2 bg-brand-400 rounded-full animate-pulse"></span>
                        <span class="text-brand-400 text-xs font-semibold tracking-wide uppercase">Marketplace UMKM Sepatu</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.1] tracking-tight mb-6">Langkahmu,<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 via-brand-400 to-brand-500">Ceritamu.</span></h1>
                    <p class="text-lg text-slate-400 leading-relaxed mb-8 max-w-lg">Temukan koleksi sepatu terbaik dari pengrajin lokal Indonesia. Kualitas premium, harga bersahabat.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#produk" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/25 transition-all duration-300">Jelajahi Produk <i class="fa-solid fa-arrow-right text-sm"></i></a>
                        <a href="#cara-pesan" class="inline-flex items-center gap-2 px-8 py-4 border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-medium rounded-xl transition-all"><i class="fa-solid fa-circle-play text-brand-400"></i> Cara Pesan</a>
                    </div>
                    <div class="flex gap-8 mt-10 pt-8 border-t border-slate-700/30">
                        <div><p class="text-2xl font-bold text-white">500+</p><p class="text-sm text-slate-500">Produk Sepatu</p></div>
                        <div><p class="text-2xl font-bold text-white">50+</p><p class="text-sm text-slate-500">UMKM Mitra</p></div>
                        <div><p class="text-2xl font-bold text-white">10K+</p><p class="text-sm text-slate-500">Pelanggan Puas</p></div>
                    </div>
                </div>
                <div class="relative fade-up hidden lg:block">
                    <div class="relative z-10 float-anim">
                        <img src="https://picsum.photos/seed/salza-hero-shoe/600/500.jpg" alt="Sepatu Premium" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl shadow-black/30">
                    </div>
                    <div class="absolute top-8 -left-4 bg-dashboard-card border border-slate-700/30 rounded-2xl p-4 shadow-xl z-20 animate-bounce" style="animation-duration:3s">
                        <div class="flex items-center gap-3"><div class="w-10 h-10 bg-brand-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-truck-fast text-brand-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Gratis Ongkir</p><p class="text-xs text-slate-500">Min. belanja 200rb</p></div></div>
                    </div>
                    <div class="absolute bottom-16 -right-4 bg-dashboard-card border border-slate-700/30 rounded-2xl p-4 shadow-xl z-20 animate-bounce" style="animation-duration:4s;animation-delay:1s">
                        <div class="flex items-center gap-3"><div class="w-10 h-10 bg-amber-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-shield-halved text-amber-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Garansi Original</p><p class="text-xs text-slate-500">100% produk lokal</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-16 border-t border-slate-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2" id="category-filter">
                <button onclick="setCategory('semua')" data-cat="semua" class="cat-btn active-cat flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-brand-500 text-white">Semua</button>
                <?php $__currentLoopData = $kategori ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button onclick="setCategory('<?php echo e($kat->slug); ?>')" data-cat="<?php echo e($kat->slug); ?>" class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-slate-800 text-slate-400 border border-slate-700/30 hover:border-brand-500/50 hover:text-white">
                    <i class="fa-solid fa-tag mr-2 text-xs"></i><?php echo e($kat->name); ?>

                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="produk" class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-brand-400 text-xs font-bold tracking-[0.2em] uppercase">Koleksi Terbaru</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 mb-4">Produk Pilihan UMKM</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Sepatu berkualitas dari pengrajin lokal Indonesia.</p>
            </div>
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php $__currentLoopData = $produk ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $pNama = $p->name;
                    $pHarga = $p->price;
                    // PERBAIKAN 1: Gunakan accessor image_url yang sudah dibuat di Model
                    $pGambar = $p->image_url; 
                    $pSlug = $p->kategori->slug ?? '';
                    $pBrand = $p->brand->name ?? 'UMKM Lokal';
                    $pStok = $p->stock;
                    $pKatName = $p->kategori->name ?? '';
                ?>
                <div class="product-card bg-dashboard-card rounded-2xl border border-slate-700/30 overflow-hidden card-hover img-zoom group fade-up visible" data-name="<?php echo e($pNama); ?>" data-kategori="<?php echo e($pSlug); ?>" data-umkm="<?php echo e($pBrand); ?>">
                    <div class="relative overflow-hidden cursor-pointer" onclick="openProductModal('<?php echo e($p->id); ?>')">
                        <img src="<?php echo e($pGambar); ?>" alt="<?php echo e($pNama); ?>" class="w-full h-56 object-cover" onerror="this.src='https://picsum.photos/seed/shoe-<?php echo e($p->id); ?>/400/400.jpg'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <?php if($pStok <= 5): ?><span class="absolute top-3 left-3 px-2.5 py-1 bg-rose-500/90 text-white text-[10px] font-bold rounded-lg uppercase tracking-wide">Stok Terbatas</span><?php endif; ?>
                        <span class="absolute top-3 right-3 px-2.5 py-1 bg-slate-900/80 text-slate-300 text-[10px] font-medium rounded-lg"><?php echo e($pKatName); ?></span>
                        <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <button onclick="event.stopPropagation();openProductModal('<?php echo e($p->id); ?>')" class="w-full py-2 bg-white/90 backdrop-blur-sm text-slate-900 text-xs font-semibold rounded-lg hover:bg-white transition-colors">Lihat Detail</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-[11px] text-slate-500 font-medium mb-1"><?php echo e($pBrand); ?></p>
                        <h3 class="text-sm font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-brand-400 transition-colors" onclick="openProductModal('<?php echo e($p->id); ?>')"><?php echo e($pNama); ?></h3>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex items-center gap-0.5"><i class="fa-solid fa-star text-amber-400 text-[10px]"></i><span class="text-xs text-slate-400"><?php echo e(number_format($p->rating ?? 0, 1)); ?></span></div>
                            <span class="text-slate-700">·</span>
                            <span class="text-xs text-slate-500">Terjual <?php echo e($p->terjual ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-base font-bold text-brand-400"><?php echo e('Rp ' . number_format($pHarga)); ?></p>
                            <button onclick="event.stopPropagation();quickAddToCart('<?php echo e($p->id); ?>')" class="w-9 h-9 bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200"><i class="fa-solid fa-plus text-sm"></i></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div id="empty-state" class="hidden text-center py-20">
                <i class="fa-solid fa-box-open text-5xl text-slate-700 mb-4"></i>
                <p class="text-slate-500 text-lg">Produk tidak ditemukan.</p>
                <button onclick="setCategory('semua');document.getElementById('search-input').value='';filterProducts();" class="mt-4 text-brand-400 hover:text-brand-300 text-sm font-medium">Reset Filter</button>
            </div>
        </div>
    </section>

    
    <section id="tentang" class="py-16 lg:py-24 border-t border-slate-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative fade-up">
                    <img src="https://picsum.photos/seed/salza-workshop/600/500.jpg" alt="Workshop" class="w-full rounded-2xl shadow-xl">
                    <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl p-6 shadow-xl"><p class="text-3xl font-bold text-white">5+</p><p class="text-sm text-brand-100">Tahun Melayani</p></div>
                </div>
                <div class="fade-up">
                    <span class="text-brand-400 text-xs font-bold tracking-[0.2em] uppercase">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 mb-6">Mengangkat Sepatu Lokal ke Panggung Nasional</h2>
                    <p class="text-slate-400 leading-relaxed mb-6">SALZA hadir sebagai jembatan antara pengrajin sepatu UMKM dan pecinta sepatu tanah air.</p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-brand-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-hand-holding-heart text-brand-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">100% Lokal</p><p class="text-xs text-slate-500 mt-1">Produksi dalam negeri</p></div></div>
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-medal text-blue-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Quality Control</p><p class="text-xs text-slate-500 mt-1">Standar mutu ketat</p></div></div>
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-amber-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-tags text-amber-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Harga Adil</p><p class="text-xs text-slate-500 mt-1">Langsung dari produsen</p></div></div>
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-rose-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-headset text-rose-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Support 24/7</p><p class="text-xs text-slate-500 mt-1">Selalu siap membantu</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="cara-pesan" class="py-16 lg:py-24 border-t border-slate-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-brand-400 text-xs font-bold tracking-[0.2em] uppercase">Mudah & Cepat</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 mb-4">Cara Pemesanan</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="relative text-center fade-up group">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-brand-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-magnifying-glass text-white text-xl"></i></div>
                    <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-slate-700/50"></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-brand-400 text-xs font-bold rounded-full leading-7 mb-3">1</span>
                    <h3 class="text-base font-semibold text-white mb-2">Pilih Produk</h3>
                    <p class="text-sm text-slate-500">Jelajahi dan pilih sepatu favoritmu.</p>
                </div>
                <div class="relative text-center fade-up group" style="transition-delay:.1s">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-bag-shopping text-white text-xl"></i></div>
                    <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-slate-700/50"></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-blue-400 text-xs font-bold rounded-full leading-7 mb-3">2</span>
                    <h3 class="text-base font-semibold text-white mb-2">Masukkan Keranjang</h3>
                    <p class="text-sm text-slate-500">Tambahkan dan pilih ukuran.</p>
                </div>
                <div class="relative text-center fade-up group" style="transition-delay:.2s">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-amber-500 to-amber-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-user-plus text-white text-xl"></i></div>
                    <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-slate-700/50"></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-amber-400 text-xs font-bold rounded-full leading-7 mb-3">3</span>
                    <h3 class="text-base font-semibold text-white mb-2">Login / Daftar</h3>
                    <p class="text-sm text-slate-500">Daftar atau masuk untuk checkout.</p>
                </div>
                <div class="text-center fade-up group" style="transition-delay:.3s">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-rose-500 to-rose-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-box-open text-white text-xl"></i></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-rose-400 text-xs font-bold rounded-full leading-7 mb-3">4</span>
                    <h3 class="text-base font-semibold text-white mb-2">Bayar & Terima</h3>
                    <p class="text-sm text-slate-500">Isi alamat, bayar, terima pesanan.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-16 lg:py-24 border-t border-slate-700/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-brand-600 to-brand-800 rounded-3xl p-10 md:p-16 text-center overflow-hidden fade-up">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Tampil Beda?</h2>
                    <p class="text-brand-100 max-w-xl mx-auto mb-8">Bergabunglah dengan ribuan pelanggan yang sudah mempercayakan kebutuhan sepatu mereka melalui SALZA.</p>
                    <a href="#produk" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition-colors shadow-xl">Belanja Sekarang <i class="fa-solid fa-arrow-right text-sm"></i></a>
                </div>
            </div>
        </div>
    </section>

    
    <footer class="border-t border-slate-700/20 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4"><div class="w-9 h-9 bg-gradient-to-br from-brand-400 to-brand-600 rounded-lg flex items-center justify-center"><i class="fa-solid fa-shoe-prints text-white text-sm"></i></div><span class="text-xl font-bold tracking-tight">SALZA</span></div>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">Marketplace sepatu UMKM terpercaya.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-brand-500/20 rounded-lg flex items-center justify-center text-slate-500 hover:text-brand-400 transition-all"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-brand-500/20 rounded-lg flex items-center justify-center text-slate-500 hover:text-brand-400 transition-all"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-brand-500/20 rounded-lg flex items-center justify-center text-slate-500 hover:text-brand-400 transition-all"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                    </div>
                </div>
                <div><h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigasi</h4><ul class="space-y-3"><li><a href="#beranda" class="text-sm text-slate-500 hover:text-brand-400">Beranda</a></li><li><a href="#produk" class="text-sm text-slate-500 hover:text-brand-400">Produk</a></li><li><a href="#tentang" class="text-sm text-slate-500 hover:text-brand-400">Tentang</a></li></ul></div>
                <div><h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kategori</h4><ul class="space-y-3"><?php $__currentLoopData = $kategori ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a href="#" onclick="setCategory('<?php echo e($kat->slug); ?>');document.getElementById('produk').scrollIntoView({behavior:'smooth'});return false;" class="text-sm text-slate-500 hover:text-brand-400"><?php echo e($kat->name); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
                <div><h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kontak</h4><ul class="space-y-3"><li class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-slate-600 mt-0.5 text-sm"></i><span class="text-sm text-slate-500">Jl. Pengrajin No. 45, Bandung</span></li><li class="flex items-center gap-3"><i class="fa-solid fa-phone text-slate-600 text-sm"></i><span class="text-sm text-slate-500">+62 812-3456-7890</span></li><li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-slate-600 text-sm"></i><span class="text-sm text-slate-500">hello@salza.id</span></li></ul></div>
            </div>
            <div class="border-t border-slate-700/30 pt-8 text-center"><p class="text-xs text-slate-600">&copy; <?php echo e(date('Y')); ?> SALZA. All rights reserved.</p></div>
        </div>
    </footer>

    
    <div id="cart-overlay" class="fixed inset-0 bg-black/60 z-50 hidden opacity-0 transition-opacity duration-300" onclick="closeCart()"></div>
    <div id="cart-sidebar" class="fixed top-0 right-0 bottom-0 w-full max-w-md bg-slate-900 border-l border-slate-700/30 z-50 transform translate-x-full transition-transform duration-300 flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-slate-700/30">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2"><i class="fa-solid fa-bag-shopping text-brand-400"></i> Keranjang</h3>
            <button onclick="closeCart()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        <div id="cart-items" class="flex-1 overflow-y-auto p-6 space-y-4">
            <div id="cart-empty" class="flex flex-col items-center justify-center h-full text-center"><i class="fa-solid fa-bag-shopping text-5xl text-slate-700 mb-4"></i><p class="text-slate-500">Keranjang masih kosong</p></div>
        </div>
        <div id="cart-footer" class="hidden border-t border-slate-700/30 p-6 space-y-3">
            <div class="bg-brand-500/10 border border-brand-500/20 rounded-xl p-3 flex items-center gap-3"><i class="fa-solid fa-circle-info text-brand-400"></i><p class="text-xs text-brand-300">Login/daftar dulu untuk checkout</p></div>
            <div class="flex justify-between text-sm"><span class="text-slate-400">Subtotal</span><span id="cart-subtotal" class="text-white font-semibold">Rp 0</span></div>
            <button onclick="handleCheckoutClick()" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all"><i class="fa-solid fa-lock mr-2 text-xs"></i>Checkout</button>
        </div>
    </div>

    
    <div id="auth-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4" onclick="closeAuthModal()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex border-b border-slate-700/30">
                <button onclick="switchAuthTab('login')" id="tab-login" class="auth-tab active flex-1 py-4 text-sm font-semibold text-center transition-colors">Masuk</button>
                <button onclick="switchAuthTab('register')" id="tab-register" class="auth-tab flex-1 py-4 text-sm font-semibold text-center text-slate-500 transition-colors">Daftar</button>
            </div>
            <div id="form-login" class="p-6">
                <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="intended" value="<?php echo e(url()->current()); ?>">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                        <input type="email" name="email" required placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                        <input type="password" name="password" required placeholder="Masukkan password" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <?php if(session('error')): ?>
                    <div class="text-xs text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg px-3 py-2"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all">Masuk</button>
                    <p class="text-center text-sm text-slate-500">Belum punya akun? <button type="button" onclick="switchAuthTab('register')" class="text-brand-400 hover:text-brand-300 font-medium">Daftar</button></p>
                </form>
            </div>
            <div id="form-register" class="p-6 hidden">
                <form method="POST" action="<?php echo e(route('daftar')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-rose-400">*</span></label>
                        <input type="text" name="name" required placeholder="Nama lengkap" value="<?php echo e(old('name')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">No. WhatsApp <span class="text-rose-400">*</span></label>
                        <input type="tel" name="whatsapp" required placeholder="081234567890" value="<?php echo e(old('whatsapp')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email <span class="text-rose-400">*</span></label>
                        <input type="email" name="email" required placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password <span class="text-rose-400">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" minlength="8" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password <span class="text-rose-400">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <?php if(session('error')): ?>
                    <div class="text-xs text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg px-3 py-2"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all">Daftar Akun</button>
                    <p class="text-center text-sm text-slate-500">Sudah punya akun? <button type="button" onclick="switchAuthTab('login')" class="text-brand-400 hover:text-brand-300 font-medium">Masuk</button></p>
                </form>
            </div>
        </div>
    </div>

    
    <div id="checkout-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4" onclick="closeCheckout()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between p-6 border-b border-slate-700/30 sticky top-0 bg-slate-900 z-10 rounded-t-2xl">
                <h3 class="text-lg font-semibold text-white">Checkout</h3>
                <button onclick="closeCheckout()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="checkout-form" onsubmit="submitOrder(event)" class="p-6 space-y-5">
                <?php echo csrf_field(); ?>
                <?php if(auth()->guard()->check()): ?>
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/20">
                    <h4 class="text-sm font-semibold text-white flex items-center gap-2 mb-3"><i class="fa-solid fa-user text-brand-400 text-xs"></i> Data Pembeli</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-slate-500 text-xs">Nama</p><p class="text-white font-medium"><?php echo e(auth()->user()->name); ?></p></div>
                        <div><p class="text-slate-500 text-xs">WhatsApp</p><p class="text-white font-medium"><?php echo e(auth()->user()->whatsapp ?? auth()->user()->phone ?? '-'); ?></p></div>
                        <div class="col-span-2"><p class="text-slate-500 text-xs">Email</p><p class="text-white font-medium"><?php echo e(auth()->user()->email); ?></p></div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/20">
                    <h4 class="text-sm font-semibold text-white mb-3">Ringkasan Pesanan</h4>
                    <div id="checkout-summary" class="space-y-2 text-sm"></div>
                    <div class="border-t border-slate-700/30 mt-3 pt-3 flex justify-between"><span class="text-white font-semibold">Subtotal</span><span id="checkout-subtotal" class="text-brand-400 font-bold"></span></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Alamat Lengkap <span class="text-rose-400">*</span></label>
                    <textarea name="alamat" required rows="3" placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan, Kota, Kode Pos" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Provinsi <span class="text-rose-400">*</span></label>
                        <select name="provinsi" id="provinsi-select" required onchange="updateShipping()" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                            <option value="">Pilih Provinsi</option>
                            <?php $__currentLoopData = $provinsi ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>"><?php echo e($v); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Kurir <span class="text-rose-400">*</span></label>
                        <select name="kurir" id="kurir-select" required onchange="updateShipping()" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                            <option value="">Pilih Kurir</option>
                            <?php $__currentLoopData = $kurir ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>"><?php echo e($v); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/20">
                    <div class="flex justify-between text-sm mb-2"><span class="text-slate-400">Ongkos Kirim</span><span id="checkout-shipping" class="text-white font-medium">Pilih lokasi & kurir</span></div>
                    <div class="flex justify-between"><span class="text-white font-semibold">Total Bayar</span><span id="checkout-grand-total" class="text-brand-400 font-bold text-lg">-</span></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Metode Pembayaran <span class="text-rose-400">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <?php $__currentLoopData = $metodeBayar ?? ['transfer'=>'Transfer Bank','ewallet'=>'E-Wallet','cod'=>'COD','qris'=>'QRIS']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center gap-3 px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl cursor-pointer hover:border-brand-500/50 transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-500/5">
                            <input type="radio" name="pembayaran" value="<?php echo e($val); ?>" required class="accent-brand-500">
                            <span class="text-sm text-slate-300"><?php echo e($label); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Catatan (opsional)</label>
                    <textarea name="catatan" rows="2" placeholder="Catatan tambahan..." class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all resize-none"></textarea>
                </div>
                <button type="submit" id="submit-order-btn" class="w-full py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-500/25 transition-all text-base"><i class="fa-solid fa-paper-plane mr-2"></i>Buat Pesanan</button>
            </form>
        </div>
    </div>

    
    <div id="product-modal" class="fixed inset-0 bg-black/70 z-[55] hidden flex items-center justify-center p-4" onclick="closeProductModal()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div id="product-modal-content"><div class="flex items-center justify-center h-64"><i class="fa-solid fa-spinner fa-spin text-brand-400 text-2xl"></i></div></div>
        </div>
    </div>

    
    <div id="success-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-sm text-center p-10">
            <div class="w-20 h-20 mx-auto bg-brand-500/20 rounded-full flex items-center justify-center mb-6 relative pulse-ring"><i class="fa-solid fa-check text-brand-400 text-3xl"></i></div>
            <h3 class="text-xl font-bold text-white mb-2">Pesanan Berhasil!</h3>
            <p class="text-sm text-slate-400 mb-2">Detail pesanan dikirim ke WhatsApp Anda.</p>
            <p class="text-sm text-slate-400 mb-6">Kode: <span id="invoice-number" class="text-brand-400 font-semibold">-</span></p>
            <a href="<?php echo e(route('pelanggan.pesanan')); ?>" class="block w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl transition-all mb-3">Lihat Pesanan Saya</a>
            <button onclick="closeSuccessModal()" class="w-full py-3 border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-medium rounded-xl transition-all">Tutup</button>
        </div>
    </div>

    
    <div id="toast-container" class="fixed top-24 right-4 z-[70] space-y-3"></div>

    
    <script>
    const APP = {
        csrfToken: '<?php echo e(csrf_token()); ?>',
        isLoggedIn: <?php echo e(auth()->check() ? 'true' : 'false'); ?>,
        routes: {
            keranjangIndex: '<?php echo e(route("api.keranjang")); ?>',
            keranjangTambah: '<?php echo e(route("api.keranjang.tambah")); ?>',
            keranjangHapus: '<?php echo e(route("api.keranjang.hapus", "ID")); ?>',
            keranjangUpdate: '<?php echo e(route("api.keranjang.update", "ID")); ?>',
            produkDetail: '<?php echo e(route("api.produk.detail", "ID")); ?>',
            checkout: '<?php echo e(route("api.checkout")); ?>',
        }
    };

    let cart = [], currentCategory = 'semua', shippingCost = 0;
    const shippingRates = <?php echo json_encode($ongkirRates ?? [], 15, 512) ?>;

    async function api(url, method = 'GET', data = null) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const opts = { method, headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' } };
        if (method !== 'GET') { opts.headers['Content-Type'] = 'application/json'; opts.headers['X-CSRF-TOKEN'] = token; opts.body = JSON.stringify(data); }
        const res = await fetch(url, opts);
        const json = await res.json();
        if (!res.ok) throw { message: json.message || 'Terjadi kesalahan', errors: json.errors };
        return json;
    }

    function openAuthModal(tab) { switchAuthTab(tab); document.getElementById('auth-modal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeAuthModal() { document.getElementById('auth-modal').classList.add('hidden'); document.body.style.overflow = ''; }
    function switchAuthTab(tab) {
        document.getElementById('form-login').classList.toggle('hidden', tab !== 'login');
        document.getElementById('form-register').classList.toggle('hidden', tab !== 'register');
        document.getElementById('tab-login').classList.toggle('active', tab === 'login');
        document.getElementById('tab-register').classList.toggle('active', tab === 'register');
        document.getElementById('tab-login').classList.toggle('text-slate-500', tab !== 'login');
        document.getElementById('tab-register').classList.toggle('text-slate-500', tab !== 'register');
    }

    async function loadCart() { try { const r = await api(APP.routes.keranjangIndex); cart = r.data || []; updateCartUI(); } catch { cart = []; updateCartUI(); } }
    async function quickAddToCart(id, ukuran = null) { try { const r = await api(APP.routes.keranjangTambah, 'POST', { produk_id: id, ukuran, qty: 1 }); cart = r.data || []; updateCartUI(); showToast(r.message || 'Ditambahkan', 'success'); } catch (e) { showToast(e.message || 'Gagal', 'error'); } }
    async function removeFromCart(id) { try { const r = await api(APP.routes.keranjangHapus.replace('ID', id), 'DELETE'); cart = r.data || []; updateCartUI(); } catch (e) { showToast(e.message, 'error'); } }
    async function updateQty(id, d) { const item = cart.find(i => i.id == id); if (!item) return; if (item.qty + d <= 0) { removeFromCart(id); return; } try { const r = await api(APP.routes.keranjangUpdate.replace('ID', id), 'PUT', { qty: item.qty + d }); cart = r.data || []; updateCartUI(); } catch (e) { showToast(e.message, 'error'); } }

    function getSub() { return cart.reduce((s, i) => s + i.harga * i.qty, 0); }
    function formatRp(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

    function updateCartUI() {
        const badge = document.getElementById('cart-badge'), footer = document.getElementById('cart-footer'), total = cart.reduce((s, i) => s + i.qty, 0);
        if (total > 0) { badge.classList.remove('hidden'); badge.classList.add('flex'); badge.textContent = total; footer.classList.remove('hidden'); } else { badge.classList.add('hidden'); badge.classList.remove('flex'); footer.classList.add('hidden'); }
        document.getElementById('cart-subtotal').textContent = formatRp(getSub());
        const empty = `<div id="cart-empty" class="${cart.length > 0 ? 'hidden' : ''} flex flex-col items-center justify-center h-full text-center"><i class="fa-solid fa-bag-shopping text-5xl text-slate-700 mb-4"></i><p class="text-slate-500">Keranjang masih kosong</p></div>`;
        const items = cart.map(i => `<div class="flex gap-4 bg-slate-800/50 rounded-xl p-3 border border-slate-700/20"><img src="${i.foto || 'https://picsum.photos/seed/shoe-'+i.produk_id+'/120/120.jpg'}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0"><div class="flex-1 min-w-0"><div class="flex justify-between items-start"><div><h4 class="text-sm font-semibold text-white truncate">${i.nama}</h4><p class="text-xs text-slate-500">Size: ${i.ukuran ?? '-'}</p></div><button onclick="removeFromCart('${i.id}')" class="text-slate-600 hover:text-rose-400 ml-2"><i class="fa-solid fa-trash-can text-xs"></i></button></div><p class="text-sm font-bold text-brand-400 mt-1">${formatRp(i.harga * i.qty)}</p><div class="flex items-center gap-2 mt-2"><button onclick="updateQty('${i.id}',-1)" class="w-7 h-7 bg-slate-700 hover:bg-slate-600 rounded-md flex items-center justify-center text-slate-400 hover:text-white text-xs"><i class="fa-solid fa-minus"></i></button><span class="text-sm font-medium text-white w-6 text-center">${i.qty}</span><button onclick="updateQty('${i.id}',1)" class="w-7 h-7 bg-slate-700 hover:bg-slate-600 rounded-md flex items-center justify-center text-slate-400 hover:text-white text-xs"><i class="fa-solid fa-plus"></i></button></div></div></div>`).join('');
        document.getElementById('cart-items').innerHTML = empty + items;
    }

    function openCart() { document.getElementById('cart-overlay').classList.remove('hidden'); setTimeout(() => { document.getElementById('cart-overlay').classList.remove('opacity-0'); document.getElementById('cart-sidebar').classList.remove('translate-x-full'); }, 10); document.body.style.overflow = 'hidden'; }
    function closeCart() { document.getElementById('cart-overlay').classList.add('opacity-0'); document.getElementById('cart-sidebar').classList.add('translate-x-full'); setTimeout(() => document.getElementById('cart-overlay').classList.add('hidden'), 300); document.body.style.overflow = ''; }

    function handleCheckoutClick() { if (!cart.length) return; if (!APP.isLoggedIn) { closeCart(); setTimeout(() => openAuthModal('login'), 350); return; } openCheckout(); }

    async function openProductModal(id) {
        const modal = document.getElementById('product-modal'), content = document.getElementById('product-modal-content');
        modal.classList.remove('hidden'); document.body.style.overflow = 'hidden';
        content.innerHTML = '<div class="flex items-center justify-center h-64"><i class="fa-solid fa-spinner fa-spin text-brand-400 text-2xl"></i></div>';
        try {
            const r = await api(APP.routes.produkDetail.replace('ID', id)), p = r.data;
            
            // PERBAIKAN 2: Sesuaikan dengan format JSON 'images' yang baru dari Controller
            const fotoUrl = (p.images && p.images.length > 0) ? p.images[0].url : `https://picsum.photos/seed/shoe-${p.id}/800/500.jpg`;
            
            content.innerHTML = `<div class="relative"><img src="${fotoUrl}" class="w-full h-64 sm:h-80 object-cover rounded-t-2xl"><button onclick="closeProductModal()" class="absolute top-4 right-4 w-10 h-10 bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white"><i class="fa-solid fa-xmark"></i></button><span class="absolute top-4 left-4 px-3 py-1.5 ${(p.stok??p.stock??0)<=5?'bg-rose-500':'bg-brand-500'} text-white text-xs font-bold rounded-lg">Stok: ${p.stok??p.stock??0}</span></div><div class="p-6 sm:p-8"><p class="text-xs text-brand-400 font-semibold uppercase tracking-wider mb-2">${p.brand?.nama ?? p.brand?.name ?? 'UMKM'}</p><h2 class="text-2xl font-bold text-white mb-3">${p.nama ?? p.name}</h2><div class="flex items-center gap-4 mb-4"><div class="flex items-center gap-1">${Array(5).fill(0).map((_,i)=>'<i class="fa-solid fa-star text-xs '+(i<Math.floor(p.rating||0)?'text-amber-400':'text-slate-700')+'"></i>').join('')}<span class="text-sm text-slate-400 ml-1">${Number(p.rating||0).toFixed(1)}</span></div><span class="text-slate-700">|</span><span class="text-sm text-slate-500">Terjual ${p.terjual??0}</span></div><p class="text-2xl font-bold text-brand-400 mb-4">${formatRp(p.harga ?? p.price ?? 0)}</p><p class="text-sm text-slate-400 leading-relaxed mb-6">${p.deskripsi ?? p.description ?? ''}</p><div class="mb-6"><p class="text-sm font-medium text-white mb-3">Pilih Ukuran:</p><div class="flex flex-wrap gap-2" id="size-opt">${(p.ukuran??p.sizes??[]).map((s,i)=>'<button type="button" onclick="pickSize(this,\''+s+'\')" class="sz px-4 py-2.5 border '+(i===0?'border-brand-500 bg-brand-500/10 text-brand-400':'border-slate-600 text-slate-400 hover:border-brand-500/50 hover:text-white')+' rounded-lg text-sm font-medium transition-all">'+s+'</button>').join('')}</div><input type="hidden" id="sel-size" value="${(p.ukuran??p.sizes??[])[0]??''}"></div><button onclick="addToCartModal('${p.id}')" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all flex items-center justify-center gap-2"><i class="fa-solid fa-bag-shopping text-sm"></i> Tambah ke Keranjang</button></div>`;
        } catch (e) { content.innerHTML = `<div class="p-10 text-center"><i class="fa-solid fa-circle-exclamation text-rose-400 text-3xl mb-4"></i><p class="text-slate-400">${e.message||'Gagal memuat'}</p><button onclick="closeProductModal()" class="mt-4 text-brand-400 text-sm font-medium">Tutup</button></div>`; }
    }
    function closeProductModal() { document.getElementById('product-modal').classList.add('hidden'); document.body.style.overflow = ''; }
    function pickSize(btn, s) { document.getElementById('sel-size').value = s; document.querySelectorAll('#size-opt .sz').forEach(b => { b.className = 'sz px-4 py-2.5 border border-slate-600 text-slate-400 hover:border-brand-500/50 hover:text-white rounded-lg text-sm font-medium transition-all'; }); btn.className = 'sz px-4 py-2.5 border border-brand-500 bg-brand-500/10 text-brand-400 rounded-lg text-sm font-medium transition-all'; }
    function addToCartModal(id) { quickAddToCart(id, document.getElementById('sel-size').value); closeProductModal(); }

    function openCheckout() { if (!cart.length) return; closeCart(); setTimeout(() => { document.getElementById('checkout-modal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; renderCheckoutSummary(); updateShipping(); }, 350); }
    function closeCheckout() { document.getElementById('checkout-modal').classList.add('hidden'); document.body.style.overflow = ''; }
    function renderCheckoutSummary() {
        document.getElementById('checkout-summary').innerHTML = cart.map(i => `<div class="flex justify-between"><span class="text-slate-400 truncate mr-4">${i.nama} <span class="text-slate-600">(x${i.qty}, size ${i.ukuran ?? '-'})</span></span><span class="text-white font-medium flex-shrink-0">${formatRp(i.harga * i.qty)}</span></div>`).join('');
        document.getElementById('checkout-subtotal').textContent = formatRp(getSub());
    }
    function updateShipping() {
        const p = document.getElementById('provinsi-select').value, k = document.getElementById('kurir-select').value;
        shippingCost = (p && k && shippingRates[p]?.[k]) ? shippingRates[p][k] : 0;
        const s = document.getElementById('checkout-shipping'), g = document.getElementById('checkout-grand-total');
        if (shippingCost > 0) { s.textContent = formatRp(shippingCost); g.textContent = formatRp(getSub() + shippingCost); } else { s.textContent = 'Pilih lokasi & kurir'; g.textContent = '-'; }
    }

    async function submitOrder(e) {
        e.preventDefault();
        const fd = new FormData(e.target), data = Object.fromEntries(fd.entries());
        if (!data.alamat || data.alamat.length < 10) { showToast('Alamat minimal 10 karakter', 'error'); return; }
        if (!data.provinsi || !data.kurir || !data.pembayaran) { showToast('Lengkapi semua field', 'error'); return; }
        if (shippingCost === 0) { showToast('Pilih provinsi dan kurir', 'error'); return; }
        const btn = document.getElementById('submit-order-btn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Memproses...';
        try {
            data.ongkir = shippingCost; data.total = getSub() + shippingCost;
            const r = await api(APP.routes.checkout, 'POST', data);
            cart = []; shippingCost = 0; updateCartUI(); closeCheckout(); e.target.reset();
            document.getElementById('invoice-number').textContent = r.data?.code ?? '-';
            document.getElementById('success-modal').classList.remove('hidden');
        } catch (e) { showToast(e.errors ? Object.values(e.errors)[0][0] : (e.message || 'Gagal'), 'error'); }
        finally { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane mr-2"></i>Buat Pesanan'; }
    }
    function closeSuccessModal() { document.getElementById('success-modal').classList.add('hidden'); document.body.style.overflow = ''; }

    function setCategory(cat) { currentCategory = cat; document.querySelectorAll('.cat-btn').forEach(b => { b.className = b.dataset.cat === cat ? 'cat-btn active-cat flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-brand-500 text-white' : 'cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-slate-800 text-slate-400 border border-slate-700/30 hover:border-brand-500/50 hover:text-white'; }); filterProducts(); }
    function filterProducts() { const q = (document.getElementById('search-input')?.value || '').toLowerCase(); let n = 0; document.querySelectorAll('.product-card').forEach(c => { const ok = (currentCategory === 'semua' || c.dataset.kategori === currentCategory) && (!q || c.dataset.name.includes(q) || c.dataset.kategori.includes(q) || c.dataset.umkm.includes(q)); c.style.display = ok ? '' : 'none'; if (ok) n++; }); document.getElementById('empty-state').classList.toggle('hidden', n > 0); }

    function toggleSearch() { const b = document.getElementById('search-bar'); b.classList.toggle('hidden'); if (!b.classList.contains('hidden')) document.getElementById('search-input').focus(); }
    function toggleMobileMenu() { const m = document.getElementById('mobile-menu'); m.classList.toggle('hidden'); document.getElementById('mob-icon').className = m.classList.contains('hidden') ? 'fa-solid fa-bars' : 'fa-solid fa-xmark'; }
    function showToast(msg, type = 'success') { const c = document.getElementById('toast-container'), t = document.createElement('div'); t.className = `toast-enter flex items-center gap-3 px-5 py-4 bg-slate-800 border ${type==='success'?'border-brand-500/30':'border-rose-500/30'} rounded-xl shadow-2xl max-w-sm`; t.innerHTML = `<i class="fa-solid ${type==='success'?'fa-circle-check text-brand-400':'fa-circle-exclamation text-rose-400'} text-lg flex-shrink-0"></i><p class="text-sm text-slate-200">${msg}</p>`; c.appendChild(t); setTimeout(() => { t.classList.remove('toast-enter'); t.classList.add('toast-exit'); setTimeout(() => t.remove(), 300); }, 3000); }

    const obs = new IntersectionObserver(e => e.forEach(x => { if (x.isIntersecting) x.target.classList.add('visible'); }), { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
    window.addEventListener('scroll', () => { const n = document.getElementById('navbar'); n.classList.toggle('shadow-xl', scrollY > 100); n.classList.toggle('shadow-black/20', scrollY > 100); });
    document.querySelectorAll('[id="flash-msg"]').forEach(el => setTimeout(() => { el.classList.add('toast-exit'); setTimeout(() => el.remove(), 300); }, 5000));
    document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>
</html> ,tambahkan fitur transaksi payment gateaway,tambah kerajang <?php /**PATH C:\laragon\www\UMKM-main\resources\views/layouts/landing.blade.php ENDPATH**/ ?>