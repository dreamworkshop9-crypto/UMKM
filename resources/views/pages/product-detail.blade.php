    @extends('layouts.app')
@section('title', $product->name . ' - SALZA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- === DEBUG SEMENTARA === -->
<div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-xs font-mono text-white space-y-1">
    <p><strong>Raw Image DB:</strong> {{ $product->image ?? 'NULL' }}</p>
    <p><strong>Hasil Thumbnail URL:</strong> {{ $product->thumbnail_url }}</p>
    <p><strong>Jumlah Gallery:</strong> {{ $product->images->count() }}</p>
    @if($product->images->count() > 0)
        <p><strong>Gallery Pertama:</strong> {{ $product->images->first()->image }}</p>
    @endif
</div>
<!-- === AKHIR DEBUG === -->
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-400 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center hover:text-white transition-colors"><i class="fa-solid fa-home mr-2 text-xs"></i> Beranda</a>
            </li>
            <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i> <a href="{{ route('shop') }}" class="hover:text-white transition-colors">Belanja</a></div></li>
            @if($product->category)
            <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i> <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-white transition-colors">{{ $product->category->name }}</a></div></li>
            @endif
            <li aria-current="page"><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-2 text-slate-600"></i> <span class="text-white">{{ $product->name }}</span></div></li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-12 mb-16">
        <!-- Product Images Gallery -->
        <div class="w-full lg:w-1/2 flex flex-col gap-4">
            <div class="w-full aspect-square bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-3xl p-8 flex items-center justify-center relative overflow-hidden group">
                <!-- Badges -->
                <div class="absolute top-6 left-6 z-10 flex flex-col gap-2">
                    @if($product->discount_percent > 0)
                        <span class="bg-rose-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg shadow-rose-500/30">-{{ $product->discount_percent }}%</span>
                    @endif
                    @if($product->is_new)
                        <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg shadow-emerald-500/30">BARU</span>
                    @endif
                </div>

                <img id="mainImage" src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain drop-shadow-2xl transition-transform duration-500 group-hover:scale-110">
            </div>

            <!-- Thumbnails -->
            @if($product->images && $product->images->count() > 0)
            <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                <button onclick="changeMainImage('{{ $product->thumbnail_url }}')" class="aspect-square bg-slate-900 border-2 border-purple-500 rounded-xl p-2 flex items-center justify-center overflow-hidden thumb-btn transition-all">
                    <img src="{{ $product->thumbnail_url }}" alt="Thumbnail Utama" class="max-w-full max-h-full object-contain">
                </button>
                @foreach($product->images as $img)
                <button onclick="changeMainImage('{{ asset('storage/'.$img->image) }}', this)" class="aspect-square bg-slate-900 border-2 border-transparent hover:border-slate-600 rounded-xl p-2 flex items-center justify-center overflow-hidden thumb-btn transition-all">
                    <img src="{{ asset('storage/'.$img->image) }}" alt="Thumbnail Tambahan" class="max-w-full max-h-full object-contain">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="w-full lg:w-1/2 flex flex-col">
            <div class="mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3 tracking-tight">{{ $product->name }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-sm mb-4">
                    <span class="px-3 py-1 bg-slate-800 text-purple-400 font-bold tracking-widest uppercase rounded-lg border border-slate-700">{{ $product->brand->name ?? 'Lainnya' }}</span>
                    <span class="text-slate-400 flex items-center gap-2"><i class="fa-solid fa-box text-slate-500"></i> Stok: <strong class="{{ $product->stock > 0 ? 'text-emerald-400' : 'text-rose-400' }}">{{ $product->stock > 0 ? $product->stock : 'Habis' }}</strong></span>
                    @if($product->sku) <span class="text-slate-400">SKU: <strong>{{ $product->sku }}</strong></span> @endif
                </div>
            </div>

            <div class="mb-8 p-6 bg-slate-900/50 rounded-2xl border border-slate-800">
                <div class="flex items-end gap-4">
                    <span class="text-4xl font-bold text-emerald-400">{{ $product->price_formatted }}</span>
                    @if($product->old_price)
                        <span class="text-lg text-slate-500 line-through mb-1">{{ $product->old_price_formatted }}</span>
                    @endif
                </div>
            </div>

            <p class="text-slate-400 leading-relaxed mb-8">{{ \Illuminate\Support\Str::limit($product->description, 180) }}</p>

            <form id="addToCartForm" class="space-y-6 mb-8">
                <!-- Size Selector -->
                @if($product->sizes && count($product->sizes) > 0)
                <div>
                    <div class="flex justify-between mb-3">
                        <h3 class="text-sm font-semibold text-white">Pilih Ukuran</h3>
                        <button type="button" class="text-xs text-purple-400 hover:text-purple-300 underline">Panduan Ukuran</button>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->sizes as $idx => $size)
                        <label class="cursor-pointer relative">
                            <input type="radio" name="size" value="{{ $size }}" class="peer sr-only" {{ $idx===0 ? 'checked' : '' }}>
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl border border-slate-700 bg-slate-800 text-slate-300 font-semibold peer-checked:bg-purple-600 peer-checked:border-purple-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-purple-500/25 hover:border-slate-500 transition-all">
                                {{ $size }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Color Selector -->
                @if($product->colors && count($product->colors) > 0)
                <div>
                    <h3 class="text-sm font-semibold text-white mb-3">Pilih Warna: <span id="colorNameDisplay" class="font-normal text-slate-400">{{ $product->colors[0] }}</span></h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->colors as $idx => $color)
                        @php
                            $hex = '#1e293b'; // Default fallback
                            $c = strtolower($color);
                            if(str_contains($c,'hitam')||str_contains($c,'black')) $hex = '#1a1a1a';
                            elseif(str_contains($c,'putih')||str_contains($c,'white')) $hex = '#f5f5f5';
                            elseif(str_contains($c,'merah')||str_contains($c,'red')) $hex = '#dc2626';
                            elseif(str_contains($c,'biru')||str_contains($c,'blue')) $hex = '#2563eb';
                            elseif(str_contains($c,'hijau')||str_contains($c,'green')) $hex = '#16a34a';
                            elseif(str_contains($c,'abu')||str_contains($c,'grey')) $hex = '#6b7280';
                            elseif(str_contains($c,'coklat')||str_contains($c,'brown')) $hex = '#78350f';
                            elseif(str_contains($c,'krem')||str_contains($c,'cream')) $hex = '#d4c5a9';
                        @endphp
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="color" value="{{ $color }}" class="peer sr-only" {{ $idx===0 ? 'checked' : '' }} onchange="document.getElementById('colorNameDisplay').textContent = this.value">
                            <div class="w-10 h-10 rounded-full border-2 border-slate-700 bg-slate-800 peer-checked:border-white peer-checked:scale-110 shadow-sm transition-all flex items-center justify-center" style="background-color: {{ $hex }}">
                                <i class="fa-solid fa-check text-[10px] text-white/90 opacity-0 peer-checked:opacity-100 drop-shadow-md"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center gap-4 pt-4 border-t border-slate-800">
                    <!-- Quantity -->
                    <div class="flex items-center bg-slate-900 border border-slate-700 rounded-xl p-1 h-14">
                        <button type="button" onclick="changeQty(-1)" class="w-10 h-full rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition-colors"><i class="fa-solid fa-minus text-xs"></i></button>
                        <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 h-full text-center bg-transparent text-white font-bold outline-none appearance-none" readonly>
                        <button type="button" onclick="changeQty(1)" class="w-10 h-full rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition-colors"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>
                    
                    <button type="button" onclick="submitAddToCart({{ $product->id }})" class="flex-1 h-14 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 group disabled:opacity-50 disabled:cursor-not-allowed" {{ $product->stock < 1 ? 'disabled' : '' }}>
                        <i class="fa-solid fa-cart-plus group-hover:-translate-y-0.5 transition-transform"></i> 
                        {{ $product->stock > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                    </button>
                    
                    <button type="button" onclick="toggleWishlist({{ $product->id }}, this)" class="w-14 h-14 rounded-xl bg-slate-800 hover:bg-rose-500 text-slate-300 hover:text-white flex items-center justify-center border border-slate-700 transition-all shadow-lg group">
                        <i class="fa-solid fa-heart text-xl group-hover:scale-110 transition-transform"></i>
                    </button>
                </div>
            </form>
            
            <!-- Features -->
            <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-slate-400 mt-auto">
                <div class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl border border-slate-800/50">
                    <i class="fa-solid fa-shield-halved text-purple-400 text-lg"></i> 100% Produk Original
                </div>
                <div class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl border border-slate-800/50">
                    <i class="fa-solid fa-rotate-left text-emerald-400 text-lg"></i> Garansi Retur 7 Hari
                </div>
                <div class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl border border-slate-800/50">
                    <i class="fa-solid fa-truck-fast text-blue-400 text-lg"></i> Pengiriman Instan
                </div>
                <div class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl border border-slate-800/50">
                    <i class="fa-solid fa-headset text-amber-400 text-lg"></i> CS Fast Response
                </div>
            </div>
        </div>
    </div>

    <!-- Description Details -->
    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-8 lg:p-12 mb-16">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-info text-purple-400"></i> Detail Spesifikasi
        </h3>
        <div class="prose prose-invert prose-slate max-w-none text-slate-300 prose-p:leading-relaxed prose-a:text-purple-400">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count())
    <div>
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-purple-400 font-bold tracking-widest uppercase text-xs">Pilihan Lainnya</span>
                <h2 class="text-3xl font-bold text-white mt-1">Produk Terkait</h2>
            </div>
            <a href="{{ route('shop', ['category' => $product->category->slug ?? '']) }}" class="text-sm font-semibold text-emerald-400 hover:text-emerald-300 hidden sm:block">Lihat Semua &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $p)
            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl border border-slate-700/50 overflow-hidden group flex flex-col h-full relative transition-all hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10 hover:border-purple-500/50">
                <!-- Badges -->
                <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                    @if($p->discount_percent > 0)
                        <span class="bg-rose-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg shadow-rose-500/30">-{{ $p->discount_percent }}%</span>
                    @endif
                </div>

                <!-- Image -->
                <div class="relative h-56 w-full bg-slate-800/30 p-6 flex items-center justify-center overflow-hidden">
                    <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" class="max-w-full max-h-full object-contain drop-shadow-2xl group-hover:scale-110 transition-transform duration-500">
                    
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3">
                        <button onclick="toggleWishlist({{ $p->id }}, this)" class="w-12 h-12 rounded-full bg-slate-800 text-slate-300 hover:bg-rose-500 hover:text-white flex items-center justify-center shadow-lg transition-colors border border-slate-700">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                        <a href="{{ route('product.show', [$p->id, $p->slug]) }}" class="w-12 h-12 rounded-full bg-slate-800 text-slate-300 hover:bg-purple-500 hover:text-white flex items-center justify-center shadow-lg transition-colors border border-slate-700">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-5 flex-1 flex flex-col">
                    <div class="text-[11px] font-semibold text-purple-400 uppercase tracking-widest mb-1">{{ $p->brand->name ?? 'Lainnya' }}</div>
                    <h3 class="text-lg font-bold text-white mb-2 leading-tight">
                        <a href="{{ route('product.show', [$p->id, $p->slug]) }}" class="hover:text-purple-400 transition-colors">{{ $p->name }}</a>
                    </h3>
                    
                    <div class="mt-auto pt-4 flex flex-col gap-4">
                        <div>
                            @if($p->old_price)
                                <div class="text-xs text-slate-500 line-through mb-0.5">{{ $p->old_price_formatted }}</div>
                            @endif
                            <div class="text-xl font-bold text-emerald-400">{{ $p->price_formatted }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Change main image
    function changeMainImage(src, btn = null) {
        document.getElementById('mainImage').src = src;
        if(btn) {
            document.querySelectorAll('.thumb-btn').forEach(b => {
                b.classList.remove('border-purple-500');
                b.classList.add('border-transparent');
            });
            btn.classList.remove('border-transparent');
            btn.classList.add('border-purple-500');
        }
    }

    // Quantity selector
    function changeQty(delta) {
        const inp = document.getElementById('qtyInput');
        const max = parseInt(inp.max);
        let val = parseInt(inp.value) + delta;
        if(val < 1) val = 1;
        if(val > max) { val = max; showToast('Maksimal stok tercapai!', 'error'); }
        inp.value = val;
    }

    // Advanced Add to Cart with Variants
    async function submitAddToCart(productId) {
        @auth
        const btn = event.currentTarget;
        const ogText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menambahkan...';

        const sizeInput = document.querySelector('input[name="size"]:checked');
        const colorInput = document.querySelector('input[name="color"]:checked');
        const qty = parseInt(document.getElementById('qtyInput').value);

        const size = sizeInput ? sizeInput.value : null;
        const color = colorInput ? colorInput.value : null;

        try {
            const res = await fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken 
                },
                body: JSON.stringify({ product_id: productId, quantity: qty, size: size, color: color })
            });
            const data = await res.json();
            
            if (data.success) {
                document.getElementById('cartCount').textContent = data.count;
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang', 'error');
            }
        } catch (error) {
            showToast('Terjadi kesalahan jaringan', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = ogText;
        }
        @else
        window.location.href = '{{ route("login") }}';
        @endauth
    }
</script>
@endpush
@endsection
