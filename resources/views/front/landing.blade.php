@extends('layouts.landing')
@section('title', 'SALZA - Marketplace Sepatu UMKM')

@section('content')

{{-- HERO --}}
<section id="beranda" class="relative min-h-screen flex items-center pt-20 hero-glow overflow-hidden">
    <div class="absolute top-32 right-10 w-80 h-80 bg-brand-500/8 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-20 left-10 w-60 h-60 bg-blue-500/6 rounded-full blur-[80px]"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-sf-600/10 rounded-full" style="animation:spin-slow 60s linear infinite"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-sf-600/5 rounded-full" style="animation:spin-slow 90s linear infinite reverse"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500/10 border border-brand-500/20 rounded-full mb-8">
                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-brand-400"></span></span>
                    <span class="text-brand-400 text-xs font-bold tracking-widest uppercase">Marketplace UMKM Sepatu</span>
                </div>
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-[1.05] tracking-tight mb-7">Langkahmu,<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 via-brand-400 to-emerald-300">Ceritamu.</span></h1>
                <p class="text-lg text-slate-400 leading-relaxed mb-10 max-w-lg">Temukan koleksi sepatu terbaik dari pengrajin lokal Indonesia. Kualitas premium, harga bersahabat, pengiriman seluruh nusantara.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#produk" class="inline-flex items-center gap-2.5 px-8 py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 transition-all duration-300 hover:-translate-y-0.5">Jelajahi Produk <i class="fa-solid fa-arrow-right text-sm"></i></a>
                    <a href="#cara-pesan" class="inline-flex items-center gap-2.5 px-8 py-4 border border-sf-600/50 hover:border-sf-500 text-slate-300 hover:text-white font-medium rounded-2xl transition-all hover:-translate-y-0.5"><i class="fa-solid fa-circle-play text-brand-400"></i> Cara Pesan</a>
                </div>
                <div class="flex gap-10 mt-12 pt-8 border-t border-sf-600/20">
                    <div><p class="text-3xl font-black text-white">500+</p><p class="text-sm text-slate-500 mt-1">Produk Sepatu</p></div>
                    <div><p class="text-3xl font-black text-white">50+</p><p class="text-sm text-slate-500 mt-1">UMKM Mitra</p></div>
                    <div><p class="text-3xl font-black text-white">10K+</p><p class="text-sm text-slate-500 mt-1">Pelanggan Puas</p></div>
                </div>
            </div>
            <div class="relative fade-up hidden lg:block">
                <div class="relative z-10 float-anim">
                    <img src="{{ asset('images/default-product.png') }}" alt="Sepatu Premium" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl shadow-black/40">
                </div>
                <div class="absolute top-8 -left-4 glass-card rounded-2xl p-4 shadow-xl z-20" style="animation:float 3s ease-in-out infinite">
                    <div class="flex items-center gap-3"><div class="w-11 h-11 bg-brand-500/20 rounded-xl flex items-center justify-center"><i class="fa-solid fa-truck-fast text-brand-400"></i></div><div><p class="text-sm font-bold text-white">Gratis Ongkir</p><p class="text-xs text-slate-500">Min. belanja 200rb</p></div></div>
                </div>
                <div class="absolute bottom-16 -right-4 glass-card rounded-2xl p-4 shadow-xl z-20" style="animation:float 4s ease-in-out infinite 1s">
                    <div class="flex items-center gap-3"><div class="w-11 h-11 bg-amber-500/20 rounded-xl flex items-center justify-center"><i class="fa-solid fa-shield-halved text-amber-400"></i></div><div><p class="text-sm font-bold text-white">Garansi Original</p><p class="text-xs text-slate-500">100% produk lokal</p></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI --}}
<section class="py-12 border-t border-sf-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2" id="category-filter">
            <button onclick="setCategory('semua')" data-cat="semua" class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-brand-500 text-white shadow-lg shadow-brand-500/20">
                Semua
            </button>
            
            @foreach($kategori as $index => $kat)
            <button onclick="setCategory('{{ $kat->slug }}')" data-cat="{{ $kat->slug }}" 
                class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-sf-700/50 text-slate-400 border border-sf-600/25 hover:border-brand-500/40 hover:text-white">
                {{ $kat->name }}
            </button>
            @endforeach
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setCategory('semua');
            });
        </script>
    </div>
</section>

{{-- PRODUK --}}
<section id="produk" class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Koleksi Terbaru</span>
            <h2 class="text-3xl md:text-5xl font-black text-white mt-4 mb-5">Produk Pilihan UMKM</h2>
            <p class="text-slate-400 max-w-xl mx-auto text-lg">Sepatu berkualitas tinggi dari pengrajin lokal terbaik Indonesia.</p>
        </div>
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($produk as $index => $p)
            @php
                $pKatSlug = $p->category->slug ?? '';
                $pBrand   = $p->brand->name ?? 'UMKM Lokal';
                $pGambar  = $p->thumbnail_url;
                $pStok    = $p->stock ?? 0;
            @endphp
            <div class="product-card bg-sf-700/40 rounded-2xl border border-sf-600/15 overflow-hidden card-lift img-zoom group fade-up {{ $index < 4 ? 'vis' : '' }}" data-name="{{ strtolower($p->name) }}" data-kategori="{{ $pKatSlug }}" data-umkm="{{ strtolower($pBrand) }}" style="{{ $index >= 4 ? 'transition-delay:'.$index*0.08.'s' : '' }}">
                <div class="relative overflow-hidden cursor-pointer" onclick="openProductModal({{ $p->id }})">
                    <img src="{{ $pGambar }}" alt="{{ $p->name }}" class="w-full h-56 object-cover" loading="lazy" onerror="this.src='{{ asset('images/default-product.png') }}'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-400"></div>
                    @if($pStok <= 5)<span class="absolute top-3 left-3 px-2.5 py-1 bg-rose-500/90 backdrop-blur-sm text-white text-[10px] font-bold rounded-lg uppercase tracking-wide">Stok Terbatas</span>@endif
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-sf-900/80 backdrop-blur-sm text-slate-300 text-[10px] font-medium rounded-lg">{{ $p->category->name ?? '' }}</span>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0 transition-all duration-400">
                        <button onclick="event.stopPropagation();openProductModal({{ $p->id }})" class="w-full py-2.5 bg-white/90 backdrop-blur-sm text-sf-900 text-xs font-bold rounded-xl hover:bg-white transition-colors">Lihat Detail</button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-[11px] text-slate-500 font-medium mb-1">{{ $pBrand }}</p>
                    <h3 class="text-sm font-bold text-white mb-2.5 line-clamp-2 cursor-pointer hover:text-brand-400 transition-colors leading-snug" onclick="openProductModal({{ $p->id }})">{{ $p->name }}</h3>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-0.5">@for($i=0;$i<5;$i++)<i class="fa-solid fa-star text-[9px] {{ $i < floor($p->rating ?? 0) ? 'text-amber-400' : 'text-sf-600' }}"></i>@endfor<span class="text-xs text-slate-400 ml-1">{{ number_format($p->rating ?? 0, 1) }}</span></div>
                        <span class="text-sf-600">·</span>
                        <span class="text-xs text-slate-500">Terjual {{ $p->terjual ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-base font-black text-brand-400">{{ 'Rp ' . number_format($p->price) }}</p>
                        <button onclick="event.stopPropagation();quickAdd({{ $p->id }})" class="w-10 h-10 bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95"><i class="fa-solid fa-plus text-sm"></i></button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div id="empty-state" class="hidden text-center py-24">
            <div class="w-24 h-24 mx-auto bg-sf-700/30 rounded-3xl flex items-center justify-center mb-6"><i class="fa-solid fa-box-open text-4xl text-slate-600"></i></div>
            <p class="text-slate-400 text-xl font-semibold">Produk tidak ditemukan</p>
            <p class="text-slate-600 mt-2">Coba ubah filter atau kata kunci pencarian.</p>
            <button onclick="setCategory('semua');document.getElementById('search-input').value='';filterProducts();" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-brand-500/10 text-brand-400 hover:bg-brand-500/20 rounded-xl text-sm font-semibold transition-all"><i class="fa-solid fa-rotate-left text-xs"></i> Reset Filter</button>
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section id="tentang" class="py-16 lg:py-24 border-t border-sf-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative fade-up">
                <div class="absolute -inset-4 bg-gradient-to-br from-brand-500/10 to-blue-500/5 rounded-3xl blur-2xl"></div>
                <img src="{{ asset('images/default-product.png') }}" alt="Workshop" class="relative w-full rounded-2xl shadow-2xl shadow-black/30">
                <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl p-6 shadow-xl shadow-brand-500/20"><p class="text-4xl font-black text-white">5+</p><p class="text-sm text-brand-200 font-medium">Tahun Melayani</p></div>
            </div>
            <div class="fade-up">
                <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-6">Mengangkat Sepatu Lokal ke Panggung Nasional</h2>
                <p class="text-slate-400 leading-relaxed mb-8 text-lg">SALZA hadir sebagai jembatan antara pengrajin sepatu UMKM dan pecinta sepatu tanah air.</p>
                <div class="grid grid-cols-2 gap-5">
                    <div class="glass-card rounded-xl p-4 hover:border-brand-500/30 transition-all"><div class="w-10 h-10 bg-brand-500/15 rounded-lg flex items-center justify-center mb-3"><i class="fa-solid fa-hand-holding-heart text-brand-400 text-sm"></i></div><p class="text-sm font-bold text-white">100% Lokal</p><p class="text-xs text-slate-500 mt-1">Produksi dalam negeri</p></div>
                    <div class="glass-card rounded-xl p-4 hover:border-blue-500/30 transition-all"><div class="w-10 h-10 bg-blue-500/15 rounded-lg flex items-center justify-center mb-3"><i class="fa-solid fa-medal text-blue-400 text-sm"></i></div><p class="text-sm font-bold text-white">Quality Control</p><p class="text-xs text-slate-500 mt-1">Standar mutu ketat</p></div>
                    <div class="glass-card rounded-xl p-4 hover:border-amber-500/30 transition-all"><div class="w-10 h-10 bg-amber-500/15 rounded-lg flex items-center justify-center mb-3"><i class="fa-solid fa-tags text-amber-400 text-sm"></i></div><p class="text-sm font-bold text-white">Harga Adil</p><p class="text-xs text-slate-500 mt-1">Langsung dari produsen</p></div>
                    <div class="glass-card rounded-xl p-4 hover:border-rose-500/30 transition-all"><div class="w-10 h-10 bg-rose-500/15 rounded-lg flex items-center justify-center mb-3"><i class="fa-solid fa-headset text-rose-400 text-sm"></i></div><p class="text-sm font-bold text-white">Support 24/7</p><p class="text-xs text-slate-500 mt-1">Selalu siap membantu</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARA PEMESANAN --}}
<section id="cara-pesan" class="py-16 lg:py-24 border-t border-sf-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Mudah & Cepat</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-4">Cara Pemesanan</h2>
            <p class="text-slate-400 max-w-lg mx-auto">4 langkah mudah untuk mendapatkan sepatu impianmu.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php($steps=[['Pilih Produk','Jelajahi dan pilih sepatu favoritmu.','fa-magnifying-glass','from-brand-500 to-brand-700','text-brand-400','1'],['Masukkan Keranjang','Pilih ukuran dan jumlah.','fa-bag-shopping','from-blue-500 to-blue-700','text-blue-400','2'],['Bayar Aman','Pilih metode pembayaran.','fa-credit-card','from-amber-500 to-amber-700','text-amber-400','3'],['Terima Pesanan','Sepatu diantar ke rumahmu.','fa-box-open','from-rose-500 to-rose-700','text-rose-400','4']])
            @foreach($steps as $i => $s)
            <div class="relative text-center fade-up group" style="transition-delay:{{$i*0.1}}s">
                <div class="w-[72px] h-[72px] mx-auto bg-gradient-to-br {{ $s[3] }} rounded-2xl flex items-center justify-center mb-6 shadow-xl group-hover:scale-110 transition-all duration-300"><i class="fa-solid {{ $s[2] }} text-white text-xl"></i></div>
                <div class="hidden lg:block absolute top-9 left-[60%] w-[80%] border-t-2 border-dashed border-sf-600/30"></div>
                <span class="inline-flex items-center justify-center w-8 h-8 bg-sf-700 {{ $s[4] }} text-xs font-black rounded-full mb-3">{{ $s[5] }}</span>
                <h3 class="text-base font-bold text-white mb-2">{{ $s[0] }}</h3>
                <p class="text-sm text-slate-500">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 lg:py-24 border-t border-sf-600/15">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-br from-brand-600 via-brand-700 to-emerald-800 rounded-3xl p-10 md:p-16 text-center overflow-hidden fade-up">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-5">Siap Tampil Beda?</h2>
                <p class="text-brand-100/80 max-w-xl mx-auto mb-10 text-lg">Bergabunglah dengan ribuan pelanggan yang sudah mempercayakan kebutuhan sepatu mereka melalui SALZA.</p>
                <a href="#produk" class="inline-flex items-center gap-2.5 px-10 py-4 bg-white text-brand-700 font-bold rounded-2xl hover:bg-brand-50 transition-all shadow-2xl shadow-black/20 hover:-translate-y-0.5 text-lg">Belanja Sekarang <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

@endsection