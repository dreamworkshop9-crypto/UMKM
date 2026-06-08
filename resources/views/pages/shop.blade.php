@extends('layouts.app')
@section('title','Belanja Produk - SALZA')

@push('styles')
<style>
/* Reset base background specifically for the shop page if needed, but Tailwind is available */
body { background-color: #0f172a; color: #f8fafc; }
.shop-hero {
    background: radial-gradient(circle at top right, rgba(139, 92, 246, 0.15), transparent 40%),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.1), transparent 40%);
}
.glass-panel {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.05);
}
.product-card-modern {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.product-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
    border-color: rgba(139, 92, 246, 0.4);
}
.product-card-modern:hover .card-actions {
    opacity: 1;
    transform: translateY(0);
}
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="shop-hero border-b border-slate-800/50 pb-8 pt-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">Koleksi <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-emerald-400">Sepatu Premium</span></h1>
                <p class="text-slate-400 max-w-xl text-lg">Temukan gaya terbaikmu dengan koleksi sepatu eksklusif dari berbagai merek ternama yang kami hadirkan khusus untuk Anda.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-500 uppercase tracking-widest font-semibold mb-1">Total Koleksi</p>
                <p class="text-3xl font-bold text-white">{{ $products->total() }} <span class="text-lg text-slate-400 font-normal">Produk</span></p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row gap-10">
        
        <!-- Sidebar Filter -->
        <aside class="w-full lg:w-72 flex-shrink-0">
            <div class="sticky top-24 space-y-8">
                
                <!-- Kategori Filter -->
                <div class="glass-panel rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center"><i class="fa-solid fa-layer-group text-purple-400 mr-2"></i> Kategori</h3>
                    <ul class="space-y-2 custom-scrollbar max-h-64 overflow-y-auto pr-2">
                        <li>
                            <a href="{{ route('shop') }}" class="flex items-center justify-between py-2 px-3 rounded-lg transition-colors {{ !request('category') ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                                <span>Semua Kategori</span>
                                @if(!request('category')) <i class="fa-solid fa-check text-xs"></i> @endif
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('shop',['category'=>$cat->slug]) }}" class="flex items-center justify-between py-2 px-3 rounded-lg transition-colors {{ request('category')===$cat->slug ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                                <span>{{ $cat->name }}</span>
                                @if(request('category')===$cat->slug) <i class="fa-solid fa-check text-xs"></i> @endif
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Brand Filter -->
                <div class="glass-panel rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center"><i class="fa-solid fa-tag text-emerald-400 mr-2"></i> Merek</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($brands as $b)
                        <a href="{{ route('shop',['brand'=>$b->slug]) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all border {{ request('brand')===$b->slug ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/40 shadow-lg shadow-emerald-500/10' : 'bg-slate-800 text-slate-400 border-slate-700 hover:border-slate-500 hover:text-white' }}">
                            {{ $b->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Price Filter -->
                <div class="glass-panel rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center"><i class="fa-solid fa-coins text-amber-400 mr-2"></i> Rentang Harga</h3>
                    <form action="{{ route('shop') }}" method="GET" class="space-y-4">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('brand')) <input type="hidden" name="brand" value="{{ request('brand') }}"> @endif
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                        
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs">Rp</span>
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg py-2.5 pl-8 pr-3 text-sm text-white focus:border-purple-500 outline-none">
                            </div>
                            <span class="text-slate-500">-</span>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs">Rp</span>
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg py-2.5 pl-8 pr-3 text-sm text-white focus:border-purple-500 outline-none">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-lg border border-slate-700 hover:border-slate-500 transition-colors">Terapkan Filter</button>
                    </form>
                </div>
                
            </div>
        </aside>

        <!-- Product Grid Area -->
        <div class="flex-1">
            <!-- Toolbar -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8 glass-panel rounded-2xl p-4">
                <p class="text-sm text-slate-400">
                    Menampilkan <span class="text-white font-semibold">{{ $products->firstItem() ?? 0 }}</span> - <span class="text-white font-semibold">{{ $products->lastItem() ?? 0 }}</span> dari total <span class="text-white font-semibold">{{ $products->total() }}</span> produk
                </p>
                <form action="{{ route('shop') }}" method="GET" class="flex items-center gap-3">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('brand')) <input type="hidden" name="brand" value="{{ request('brand') }}"> @endif
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                    @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                    
                    <label class="text-sm text-slate-400 whitespace-nowrap">Urutkan:</label>
                    <div class="relative">
                        <select name="sort" onchange="this.form.submit()" class="appearance-none bg-slate-900 border border-slate-700 rounded-lg py-2 pl-4 pr-10 text-sm text-white focus:border-purple-500 outline-none cursor-pointer">
                            <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Harga Tertinggi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-500 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <!-- Products -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $p)
                    <div class="product-card-modern glass-panel rounded-2xl border border-slate-700/50 overflow-hidden group flex flex-col h-full relative">
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                            @if($p->discount_percent > 0)
                                <span class="bg-rose-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg shadow-rose-500/30">-{{ $p->discount_percent }}%</span>
                            @endif
                            @if($p->is_new)
                                <span class="bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg shadow-emerald-500/30">BARU</span>
                            @endif
                        </div>

                        <!-- Image -->
                        <div class="relative h-64 w-full bg-slate-900/50 p-6 flex items-center justify-center overflow-hidden">
                            <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" class="max-w-full max-h-full object-contain drop-shadow-2xl group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Hover Actions -->
                            <div class="card-actions absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] opacity-0 translate-y-4 transition-all duration-300 flex items-center justify-center gap-3">
                                <button onclick="toggleWishlist({{ $p->id }}, this)" class="w-12 h-12 rounded-full bg-slate-800 text-slate-300 hover:bg-rose-500 hover:text-white flex items-center justify-center shadow-lg transition-colors border border-slate-700">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                                <a href="{{ route('product.show',[$p->id,$p->slug]) }}" class="w-12 h-12 rounded-full bg-slate-800 text-slate-300 hover:bg-purple-500 hover:text-white flex items-center justify-center shadow-lg transition-colors border border-slate-700">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="text-[11px] font-semibold text-purple-400 uppercase tracking-widest mb-1">{{ $p->brand->name ?? 'Lainnya' }}</div>
                            <h3 class="text-lg font-bold text-white mb-2 leading-tight">
                                <a href="{{ route('product.show',[$p->id,$p->slug]) }}" class="hover:text-purple-400 transition-colors">{{ $p->name }}</a>
                            </h3>
                            
                            <div class="mt-auto pt-4 flex items-end justify-between">
                                <div>
                                    @if($p->old_price)
                                        <div class="text-xs text-slate-500 line-through mb-0.5">{{ $p->old_price_formatted }}</div>
                                    @endif
                                    <div class="text-xl font-bold text-emerald-400">{{ $p->price_formatted }}</div>
                                </div>
                                <button onclick="addToCart({{ $p->id }})" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-emerald-500 text-slate-300 hover:text-white flex items-center justify-center border border-slate-700 transition-all shadow-lg hover:shadow-emerald-500/25" title="Tambah ke Keranjang">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="glass-panel rounded-2xl border border-slate-700/50 p-12 text-center">
                    <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-box-open text-4xl text-slate-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-slate-400 mb-8 max-w-md mx-auto">Maaf, kami tidak dapat menemukan produk yang sesuai dengan filter pencarian Anda. Silakan coba filter yang lain.</p>
                    <a href="{{ route('shop') }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-500 text-white font-semibold rounded-xl transition-all shadow-lg shadow-purple-500/25 inline-flex items-center gap-2">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
