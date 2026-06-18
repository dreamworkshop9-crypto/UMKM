@extends('layouts.app')

@section('title', 'SALZA - Marketplace Sepatu UMKM')

@push('styles')
<style>
    @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
    .marquee-track{animation:marquee 30s linear infinite}
    .marquee-track:hover{animation-play-state:paused}
    .faq-answer{max-height:0;overflow:hidden;transition:max-height .4s cubic-bezier(.23,1,.32,1),padding .3s}
    .faq-answer.open{max-height:300px}
    .faq-icon{transition:transform .3s}
    .faq-item.active .faq-icon{transform:rotate(45deg)}
    .testimonial-slide{transition:all .5s cubic-bezier(.23,1,.32,1)}
    .skeleton{background:linear-gradient(90deg,#1e293b 25%,#334155 50%,#1e293b 75%);background-size:200% 100%;animation:shimmer 1.5s infinite}
    @keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
    .stat-num{font-variant-numeric:tabular-nums}
</style>
@endpush

@section('content')

<!-- ══════════════════════════════════════════════════════════════
     HERO
     ══════════════════════════════════════════════════════════════ -->
<section id="beranda" class="relative min-h-screen flex items-center pt-20 hero-glow overflow-hidden">
    <div class="absolute top-32 right-10 w-80 h-80 bg-brand-500/8 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-20 left-10 w-60 h-60 bg-blue-500/6 rounded-full blur-[80px]"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-surface-600/10 rounded-full" style="animation:spin-slow 60s linear infinite"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-surface-600/5 rounded-full" style="animation:spin-slow 90s linear infinite reverse"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500/10 border border-brand-500/20 rounded-full mb-8">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-400"></span>
                    </span>
                    <span class="text-brand-400 text-xs font-bold tracking-widest uppercase">Marketplace UMKM Sepatu #1</span>
                </div>
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-[1.05] tracking-tight mb-7">
                    Langkahmu,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 via-brand-400 to-emerald-300">Ceritamu.</span>
                </h1>
                <p class="text-lg text-slate-400 leading-relaxed mb-10 max-w-lg">Temukan koleksi sepatu terbaik dari pengrajin lokal Indonesia. Kualitas premium, harga bersahabat, pengiriman seluruh nusantara.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#produk" class="inline-flex items-center gap-2.5 px-8 py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 transition-all duration-300 hover:-translate-y-0.5">
                        Jelajahi Produk <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#cara-pesan" class="inline-flex items-center gap-2.5 px-8 py-4 border border-surface-600/50 hover:border-surface-500 text-slate-300 hover:text-white font-medium rounded-2xl transition-all hover:-translate-y-0.5">
                        <i class="fa-solid fa-circle-play text-brand-400"></i> Cara Pesan
                    </a>
                </div>

                <div class="flex gap-10 mt-12 pt-8 border-t border-surface-600/20">
                    <div>
                        <p class="text-3xl font-black text-white stat-num" data-target="500" data-suffix="+">0</p>
                        <p class="text-sm text-slate-500 mt-1">Produk Sepatu</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white stat-num" data-target="50" data-suffix="+">0</p>
                        <p class="text-sm text-slate-500 mt-1">UMKM Mitra</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white stat-num" data-target="10" data-suffix="K+">0</p>
                        <p class="text-sm text-slate-500 mt-1">Pelanggan Puas</p>
                    </div>
                </div>
            </div>

            <div class="relative fade-up hidden lg:block">
                <div class="relative z-10 float-anim">
                    <img src="https://picsum.photos/seed/salza-hero-v4/600/500.jpg" alt="Sepatu Premium" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl shadow-black/40">
                </div>
                <div class="absolute top-8 -left-4 glass-card rounded-2xl p-4 shadow-xl z-20" style="animation:float 3s ease-in-out infinite">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-brand-500/20 rounded-xl flex items-center justify-center"><i class="fa-solid fa-truck-fast text-brand-400"></i></div>
                        <div><p class="text-sm font-bold text-white">Gratis Ongkir</p><p class="text-xs text-slate-500">Min. belanja 200rb</p></div>
                    </div>
                </div>
                <div class="absolute bottom-16 -right-4 glass-card rounded-2xl p-4 shadow-xl z-20" style="animation:float 4s ease-in-out infinite 1s">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-amber-500/20 rounded-xl flex items-center justify-center"><i class="fa-solid fa-shield-halved text-amber-400"></i></div>
                        <div><p class="text-sm font-bold text-white">Garansi Original</p><p class="text-xs text-slate-500">100% produk lokal</p></div>
                    </div>
                </div>
                <div class="absolute top-1/2 -left-10 glass-card rounded-xl px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/avatar-1/32/32.jpg" class="w-7 h-7 rounded-full border-2 border-surface-800">
                            <img src="https://picsum.photos/seed/avatar-2/32/32.jpg" class="w-7 h-7 rounded-full border-2 border-surface-800">
                            <img src="https://picsum.photos/seed/avatar-3/32/32.jpg" class="w-7 h-7 rounded-full border-2 border-surface-800">
                        </div>
                        <div><p class="text-xs font-bold text-white">4.9/5</p><p class="text-[10px] text-slate-500">10K+ review</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     MARQUEE BRAND MITRA
     ══════════════════════════════════════════════════════════════ -->
<section class="py-10 border-t border-surface-600/15 overflow-hidden">
    <p class="text-center text-xs font-bold text-slate-600 uppercase tracking-[0.3em] mb-6">Dipercaya oleh UMKM sepatu terbaik</p>
    <div class="relative">
        <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-surface-900 to-transparent z-10"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-surface-900 to-transparent z-10"></div>
        <div class="flex marquee-track" style="width:max-content">
            @php($brands = ['FootCraft Studio','Batak Leather','Santai Shoes','Island Footwear','Gentleman Craft','Urban Step','Nusantara Sole','Java Bootery'])
            @for($i = 0; $i < 2; $i++)
            @foreach($brands as $b)
            <div class="flex items-center gap-2.5 mx-8 px-5 py-3 bg-surface-700/20 border border-surface-600/10 rounded-xl flex-shrink-0">
                <div class="w-8 h-8 bg-surface-600/20 rounded-lg flex items-center justify-center"><i class="fa-solid fa-shoe-prints text-slate-500 text-xs"></i></div>
                <span class="text-sm font-semibold text-slate-500 whitespace-nowrap">{{ $b }}</span>
            </div>
            @endforeach
            @endfor
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     KENAPA PILIH SALZA
     ══════════════════════════════════════════════════════════════ -->
<section class="py-16 lg:py-24 border-t border-surface-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Keunggulan Kami</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-4">Kenapa Pilih SALZA?</h2>
            <p class="text-slate-400 max-w-lg mx-auto">Bukan sekadar marketplace — kami partner pertumbuhan UMKM sepatu Indonesia.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php($features = [
                ['fa-magnifying-glass-chart','Terverifikasi','Setiap produk melewati quality control ketat sebelum ditampilkan','from-brand-500 to-brand-700','shadow-brand-500/20'],
                ['fa-hand-holding-dollar','Harga Langsung Produsen','Tanpa perantara, harga yang kamu bayar langsung ke pengrajin','from-emerald-500 to-emerald-700','shadow-emerald-500/20'],
                ['fa-rotate-left','Garansi 7 Hari','Tidak puas? Kembalikan dalam 7 hari tanpa ribet','from-blue-500 to-blue-700','shadow-blue-500/20'],
                ['fa-truck-fast','Pengiriman Cepat','Didukung JNE, J&T, SiCepat, dan AnterAja ke seluruh Indonesia','from-amber-500 to-amber-700','shadow-amber-500/20'],
                ['fa-credit-card','Pembayaran Aman','Terintegrasi Midtrans: QRIS, VA, E-Wallet, COD','from-violet-500 to-violet-700','shadow-violet-500/20'],
                ['fa-headset','Support 24/7','Tim kami selalu siap membantu via WhatsApp setiap hari','from-rose-500 to-rose-700','shadow-rose-500/20'],
            ])
            @foreach($features as $i => $f)
            <div class="fade-up group" style="transition-delay:{{$i*0.08}}s">
                <div class="glass-card rounded-2xl p-6 h-full hover:border-brand-500/20 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br {{ $f[3] }} rounded-2xl flex items-center justify-center mb-5 shadow-xl {{ $f[4] }} group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid {{ $f[0] }} text-white text-lg"></i>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">{{ $f[1] }}</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ $f[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     KATEGORI + PRODUK
     ══════════════════════════════════════════════════════════════ -->
<section id="produk" class="py-16 lg:py-24 border-t border-surface-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Koleksi Terbaru</span>
            <h2 class="text-3xl md:text-5xl font-black text-white mt-4 mb-5">Produk Pilihan UMKM</h2>
            <p class="text-slate-400 max-w-xl mx-auto text-lg">Sepatu berkualitas tinggi dari pengrajin lokal terbaik Indonesia.</p>
        </div>

        <!-- Kategori Filter -->
        <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-4 mb-8" id="category-filter">
            <button onclick="setCategory('semua')" data-cat="semua" class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 bg-brand-500 text-white shadow-lg shadow-brand-500/20">Semua</button>
            @foreach($kategori as $kat)
            <button onclick="setCategory('{{ $kat->slug }}')" data-cat="{{ $kat->slug }}" class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-surface-700/50 text-slate-400 border border-surface-600/25 hover:border-brand-500/40 hover:text-white">
                {{ $kat->name }}
            </button>
            @endforeach
        </div>

        <!-- Product Grid -->
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-4 gap-6">
            @foreach($produk as $index => $p)
            @php
                $pKatSlug = $p->kategori->slug ?? '';
                $pBrand   = $p->brand->name ?? 'UMKM Lokal';
                 $pGambar = !empty($p->image) ? \Storage::url($p->image) : 'https://picsum.photos/seed/shoe-' . $p->id . '/400/400.jpg';
            @endphp
            <div class="product-card bg-surface-700/40 rounded-2xl border border-surface-600/15 overflow-hidden card-lift img-zoom group fade-up {{ $index < 4 ? 'vis' : '' }}" data-name="{{ strtolower($p->name) }}" data-kategori="{{ $pKatSlug }}" data-umkm="{{ strtolower($pBrand) }}" style="{{ $index >= 4 ? 'transition-delay:'.$index*0.06.'s' : '' }}">
                <div class="relative overflow-hidden cursor-pointer" onclick="openProductModal({{ $p->id }})">
                    <img src="{{ $pGambar }}" alt="{{ $p->name }}" class="w-full h-56 object-cover" loading="lazy" onerror="this.src='https://picsum.photos/seed/shoe-{{ $p->id }}/400/400.jpg'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-400"></div>
                    @if($p->stock <= 5)
                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-rose-500/90 backdrop-blur-sm text-white text-[10px] font-bold rounded-lg uppercase tracking-wide">Stok Terbatas</span>
                    @endif
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-surface-900/80 backdrop-blur-sm text-slate-300 text-[10px] font-medium rounded-lg">{{ $p->kategori->name ?? '' }}</span>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0 transition-all duration-400">
                        <button onclick="event.stopPropagation();openProductModal({{ $p->id }})" class="w-full py-2.5 bg-white/90 backdrop-blur-sm text-surface-900 text-xs font-bold rounded-xl hover:bg-white transition-colors">Lihat Detail</button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-[11px] text-slate-500 font-medium mb-1">{{ $pBrand }}</p>
                    <h3 class="text-sm font-bold text-white mb-2.5 line-clamp-2 cursor-pointer hover:text-brand-400 transition-colors leading-snug" onclick="openProductModal({{ $p->id }})">{{ $p->name }}</h3>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-0.5">
                            @for($i = 0; $i < 5; $i++)
                            <i class="fa-solid fa-star text-[9px] {{ $i < floor($p->rating ?? 0) ? 'text-amber-400' : 'text-surface-600' }}"></i>
                            @endfor
                            <span class="text-xs text-slate-400 ml-1">{{ number_format($p->rating ?? 0, 1) }}</span>
                        </div>
                        <span class="text-surface-600">·</span>
                        <span class="text-xs text-slate-500">Terjual {{ $p->terjual ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-base font-black text-brand-400">{{ 'Rp ' . number_format($p->price) }}</p>
                        <button onclick="event.stopPropagation();quickAdd({{ $p->id }})" class="w-10 h-10 bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="hidden text-center py-24">
            <div class="w-24 h-24 mx-auto bg-surface-700/30 rounded-3xl flex items-center justify-center mb-6"><i class="fa-solid fa-box-open text-4xl text-slate-600"></i></div>
            <p class="text-slate-400 text-xl font-semibold">Produk tidak ditemukan</p>
            <p class="text-slate-600 mt-2">Coba ubah filter atau kata kunci pencarian.</p>
            <button onclick="setCategory('semua');document.getElementById('search-input').value='';filterProducts();" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-brand-500/10 text-brand-400 hover:bg-brand-500/20 rounded-xl text-sm font-semibold transition-all">
                <i class="fa-solid fa-rotate-left text-xs"></i> Reset Filter
            </button>
        </div>

        <!-- Lihat Semua -->
        <div class="text-center mt-12 fade-up">
            <p class="text-sm text-slate-500 mb-4">Menampilkan {{ count($produk) }} dari 500+ produk</p>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     TESTIMONIAL
     ══════════════════════════════════════════════════════════════ -->
<section class="py-16 lg:py-24 border-t border-surface-600/15 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-brand-500/5 rounded-full blur-[120px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-14 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Testimoni</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-4">Apa Kata Mereka?</h2>
            <p class="text-slate-400 max-w-lg mx-auto">Ribuan pelanggan sudah merasakan kualitas sepatu UMKM melalui SALZA.</p>
        </div>

        <div class="relative">
            <div id="testimonial-container" class="overflow-hidden">
                <div id="testimonial-track" class="flex transition-transform duration-500" style="transform:translateX(0)">
                    @php($testimonials = [
                        ['Rizki Pratama','Jakarta','Sneakers yang saya beli kualitasnya setara brand luar, tapi harganya jauh lebih masuk akal. Packingnya juga rapi banget.','5','https://picsum.photos/seed/testi-1/80/80.jpg'],
                        ['Sari Dewi','Bandung','Awalnya ragu beli sepatu online, tapi ternyata sesuai ekspektasi. Ukuran pas, bahannya nyaman. Pasti repeat order!','5','https://picsum.photos/seed/testi-2/80/80.jpg'],
                        ['Ahmad Fauzi','Surabaya','Boot kulit dari Batak Leather ini juara. Sudah 3 bulan dipakai harian dan masih awet. Recommended banget!','5','https://picsum.photos/seed/testi-3/80/80.jpg'],
                        ['Dinda Ayu','Yogyakarta','Prosesnya cepat, dari pesan sampai diterima cuma 2 hari. Sepatunya juga cantik banget, banyak yang tanya kemana beli.','4','https://picsum.photos/seed/testi-4/80/80.jpg'],
                        ['Budi Santoso','Semarang','SALZA benar-benar membantu UMKM lokal. Saya sebagai pengrajin juga ikut terbantu produknya terjual lebih luas.','5','https://picsum.photos/seed/testi-5/80/80.jpg'],
                        ['Maya Putri','Bali','Loafers-nya super nyaman buat jalan-jalan di Bali. Desainnya minimalis dan elegan. Love it!','5','https://picsum.photos/seed/testi-6/80/80.jpg'],
                    ])
                    @foreach($testimonials as $t)
                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                        <div class="glass-card rounded-2xl p-6 h-full flex flex-col">
                            <div class="flex items-center gap-0.5 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star text-xs {{ $i < intval($t[3]) ? 'text-amber-400' : 'text-surface-600' }}"></i>
                                @endfor
                            </div>
                            <p class="text-sm text-slate-300 leading-relaxed flex-1 mb-5">"{{ $t[2] }}"</p>
                            <div class="flex items-center gap-3 pt-4 border-t border-surface-600/15">
                                <img src="{{ $t[4] }}" class="w-10 h-10 rounded-full object-cover border-2 border-surface-600/30">
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $t[0] }}</p>
                                    <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot mr-1"></i>{{ $t[1] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Nav -->
            <div class="flex items-center justify-center gap-4 mt-8">
                <button onclick="slideTestimonial(-1)" class="w-11 h-11 bg-surface-700/50 hover:bg-surface-700 border border-surface-600/20 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition-all"><i class="fa-solid fa-chevron-left text-sm"></i></button>
                <div id="testimonial-dots" class="flex gap-2"></div>
                <button onclick="slideTestimonial(1)" class="w-11 h-11 bg-surface-700/50 hover:bg-surface-700 border border-surface-600/20 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition-all"><i class="fa-solid fa-chevron-right text-sm"></i></button>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     TENTANG
     ══════════════════════════════════════════════════════════════ -->
<section id="tentang" class="py-16 lg:py-24 border-t border-surface-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative fade-up">
                <div class="absolute -inset-4 bg-gradient-to-br from-brand-500/10 to-blue-500/5 rounded-3xl blur-2xl"></div>
                <img src="https://picsum.photos/seed/salza-workshop-v4/600/500.jpg" alt="Workshop" class="relative w-full rounded-2xl shadow-2xl shadow-black/30">
                <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl p-6 shadow-xl shadow-brand-500/20">
                    <p class="text-4xl font-black text-white">5+</p>
                    <p class="text-sm text-brand-200 font-medium">Tahun Melayani</p>
                </div>
                <div class="absolute -top-4 -left-4 glass-card rounded-xl px-4 py-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-award text-amber-400"></i>
                        <span class="text-xs font-bold text-white">Top UMKM Platform 2024</span>
                    </div>
                </div>
            </div>
            <div class="fade-up">
                <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-6">Mengangkat Sepatu Lokal ke Panggung Nasional</h2>
                <p class="text-slate-400 leading-relaxed mb-4 text-lg">SALZA hadir sebagai jembatan antara pengrajin sepatu UMKM dan pecinta sepatu tanah air. Kami percaya bahwa sepatu buatan Indonesia bisa bersaing dengan brand internasional.</p>
                <p class="text-slate-400 leading-relaxed mb-8">Setiap produk yang masuk ke platform kami melewati proses kurasi ketat untuk memastikan kualitas yang konsisten.</p>
                <div class="grid grid-cols-2 gap-4">
                    @php($abouts = [
                        ['fa-hand-holding-heart','100% Lokal','Produksi dalam negeri','bg-brand-500/15','text-brand-400'],
                        ['fa-medal','Quality Control','Standar mutu ketat','bg-blue-500/15','text-blue-400'],
                        ['fa-tags','Harga Adil','Langsung dari produsen','bg-amber-500/15','text-amber-400'],
                        ['fa-headset','Support 24/7','Selalu siap membantu','bg-rose-500/15','text-rose-400'],
                    ])
                    @foreach($abouts as $a)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 {{ $a[3] }} rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid {{ $a[0] }} {{ $a[4] }} text-sm"></i></div>
                        <div><p class="text-sm font-bold text-white">{{ $a[1] }}</p><p class="text-xs text-slate-500 mt-0.5">{{ $a[2] }}</p></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     CARA PEMESANAN
     ══════════════════════════════════════════════════════════════ -->
<section id="cara-pesan" class="py-16 lg:py-24 border-t border-surface-600/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">Mudah & Cepat</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-4">Cara Pemesanan</h2>
            <p class="text-slate-400 max-w-lg mx-auto">4 langkah mudah untuk mendapatkan sepatu impianmu.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php($steps = [
                ['Pilih Produk','Jelajahi katalog dan pilih sepatu favoritmu. Gunakan filter untuk memudahkan pencarian.','fa-magnifying-glass','from-brand-500 to-brand-700','shadow-brand-500/20','1','text-brand-400'],
                ['Masukkan Keranjang','Pilih ukuran yang sesuai dan tambahkan ke keranjang belanja.','fa-bag-shopping','from-blue-500 to-blue-700','shadow-blue-500/20','2','text-blue-400'],
                ['Bayar Aman','Pilih metode pembayaran: QRIS, Virtual Account, E-Wallet, atau COD.','fa-credit-card','from-amber-500 to-amber-700','shadow-amber-500/20','3','text-amber-400'],
                ['Terima Pesanan','Pantau status pesanan dan terima sepatu di depan pintu rumahmu.','fa-box-open','from-rose-500 to-rose-700','shadow-rose-500/20','4','text-rose-400'],
            ])
            @foreach($steps as $i => $s)
            <div class="relative text-center fade-up group" style="transition-delay:{{$i*0.1}}s">
                <div class="w-[72px] h-[72px] mx-auto bg-gradient-to-br {{ $s[3] }} rounded-2xl flex items-center justify-center mb-6 shadow-xl {{ $s[4] }} group-hover:scale-110 group-hover:shadow-2xl transition-all duration-300">
                    <i class="fa-solid {{ $s[2] }} text-white text-xl"></i>
                </div>
                <div class="hidden lg:block absolute top-9 left-[60%] w-[80%] border-t-2 border-dashed border-surface-600/30"></div>
                <span class="inline-flex items-center justify-center w-8 h-8 bg-surface-700 {{ $s[6] }} text-xs font-black rounded-full mb-3">{{ $s[5] }}</span>
                <h3 class="text-base font-bold text-white mb-2">{{ $s[0] }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     FAQ
     ══════════════════════════════════════════════════════════════ -->
<section class="py-16 lg:py-24 border-t border-surface-600/15">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <span class="text-brand-400 text-xs font-bold tracking-[0.25em] uppercase">FAQ</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-4 mb-4">Pertanyaan Umum</h2>
        </div>
        <div class="space-y-3 fade-up">
            @php($faqs = [
                ['Apakah sepatu yang dijual original?','Ya, 100% produk di SALZA adalah produk asli buatan pengrajin lokal Indonesia. Setiap produk melewati proses verifikasi sebelum ditampilkan di platform.'],
                ['Bagaimana jika ukuran tidak cocok?','Kami menyediakan garansi 7 hari. Jika ukuran tidak sesuai, kamu bisa menukar dengan ukuran lain atau mengembalikan barang dengan syarat belum dipakai dan tag masih menempel.'],
                ['Metode pembayaran apa saja yang tersedia?','Kami menerima QRIS (semua aplikasi pembayaran), Virtual Account (BCA, BNI, Mandiri, BRI), E-Wallet (GoPay, OVO, DANA, ShopeePay), dan COD (Bayar di Tempat).'],
                ['Berapa lama pengiriman?','Pengiriman tergantung lokasi. Untuk Pulau Jawa biasanya 1-3 hari kerja. Luar Jawa 3-7 hari kerja. Kami bekerja sama dengan JNE, J&T, SiCepat, dan AnterAja.'],
                ['Apakah bisa request ukuran khusus?','Beberapa mitra UMKM kami menerima custom order. Kamu bisa langsung menghubungi pengrajin melalui fitur chat di halaman produk atau hubungi CS kami.'],
                ['Bagaimana cara cek status pesanan?','Setelah checkout, kamu akan mendapat kode pesanan. Login ke akun SALZA, buka menu "Pesanan Saya" untuk melacak status secara real-time.'],
            ])
            @foreach($faqs as $i => $faq)
            <div class="faq-item glass-card rounded-xl overflow-hidden" onclick="toggleFaq(this)">
                <button class="w-full flex items-center justify-between p-5 text-left">
                    <span class="text-sm font-bold text-white pr-4">{{ $faq[0] }}</span>
                    <span class="faq-icon w-8 h-8 bg-surface-600/30 rounded-lg flex items-center justify-center text-slate-400 flex-shrink-0"><i class="fa-solid fa-plus text-xs"></i></span>
                </button>
                <div class="faq-answer px-5">
                    <p class="text-sm text-slate-400 leading-relaxed pb-5">{{ $faq[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════════
     CTA
     ══════════════════════════════════════════════════════════════ -->
<section class="py-16 lg:py-24 border-t border-surface-600/15">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-br from-brand-600 via-brand-700 to-emerald-800 rounded-3xl p-10 md:p-16 text-center overflow-hidden fade-up">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-white/5 rounded-full"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-5">Siap Tampil Beda?</h2>
                <p class="text-brand-100/80 max-w-xl mx-auto mb-10 text-lg">Bergabunglah dengan ribuan pelanggan yang sudah mempercayakan kebutuhan sepatu mereka melalui SALZA.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#produk" class="inline-flex items-center justify-center gap-2.5 px-10 py-4 bg-white text-brand-700 font-bold rounded-2xl hover:bg-brand-50 transition-all shadow-2xl shadow-black/20 hover:-translate-y-0.5 text-lg">
                        Belanja Sekarang <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20SALZA%2C%20saya%20ingin%20bertanya" target="_blank" class="inline-flex items-center justify-center gap-2.5 px-10 py-4 border-2 border-white/30 hover:border-white/60 text-white font-bold rounded-2xl transition-all hover:-translate-y-0.5 text-lg">
                        <i class="fa-brands fa-whatsapp text-xl"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Animated Counter ─────────────────────────────────────────────
function animateCounters() {
    document.querySelectorAll('.stat-num').forEach(el => {
        const target = parseInt(el.dataset.target);
        const suffix = el.dataset.suffix || '';
        const duration = 2000;
        const start = performance.now();

        function tick(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(target * eased) + suffix;
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    });
}

// Trigger counter saat hero terlihat
const heroObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            animateCounters();
            heroObs.unobserve(e.target);
        }
    });
}, { threshold: 0.3 });
const heroSection = document.getElementById('beranda');
if (heroSection) heroObs.observe(heroSection);


// ── Testimonial Carousel ─────────────────────────────────────────
let testiIndex = 0;
let testiPerView = 3;

function updateTestiPerView() {
    const w = window.innerWidth;
    if (w < 768) testiPerView = 1;
    else if (w < 1024) testiPerView = 2;
    else testiPerView = 3;
}

function getTotalTestiSlides() {
    const total = document.querySelectorAll('#testimonial-track > div').length;
    return Math.max(1, total - testiPerView + 1);
}

function slideTestimonial(dir) {
    updateTestiPerView();
    const max = getTotalTestiSlides();
    testiIndex = Math.max(0, Math.min(testiIndex + dir, max - 1));
    const track = document.getElementById('testimonial-track');
    const pct = (100 / document.querySelectorAll('#testimonial-track > div').length) * testiPerView;
    track.style.transform = `translateX(-${testiIndex * (100 / testiPerView)}%)`;
    updateTestiDots();
}

function goTestiSlide(i) {
    testiIndex = i;
    const track = document.getElementById('testimonial-track');
    track.style.transform = `translateX(-${testiIndex * (100 / testiPerView)}%)`;
    updateTestiDots();
}

function updateTestiDots() {
    const total = getTotalTestiSlides();
    const dots = document.getElementById('testimonial-dots');
    dots.innerHTML = '';
    for (let i = 0; i < total; i++) {
        const dot = document.createElement('button');
        dot.className = `w-2.5 h-2.5 rounded-full transition-all duration-300 ${i === testiIndex ? 'bg-brand-400 w-8' : 'bg-surface-600 hover:bg-surface-500'`;
        dot.onclick = () => goTestiSlide(i);
        dots.appendChild(dot);
    }
}

// Init
updateTestiPerView();
updateTestiDots();
window.addEventListener('resize', () => { updateTestiPerView(); updateTestiDots(); slideTestimonial(0); });


// ── FAQ Accordion ────────────────────────────────────────────────
function toggleFaq(item) {
    const answer = item.querySelector('.faq-answer');
    const isOpen = item.classList.contains('active');

    // Tutup semua
    document.querySelectorAll('.faq-item').forEach(faq => {
        faq.classList.remove('active');
        faq.querySelector('.faq-answer').classList.remove('open');
    });

    // Buka yang diklik (jika sebelumnya tertutup)
    if (!isOpen) {
        item.classList.add('active');
        answer.classList.add('open');
    }
}
</script>
@endpush