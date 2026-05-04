@extends('layouts.app')
@section('title','Wishlist Saya - SALZA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-rose-500/10 flex items-center justify-center text-rose-500">
                <i class="fa-solid fa-heart text-xl"></i>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-white tracking-tight">Wishlist Saya</h2>
                <p class="text-sm text-slate-400 mt-1">Koleksi sepatu impian yang Anda simpan.</p>
            </div>
        </div>
        <div class="hidden sm:block">
            <span class="px-4 py-2 bg-slate-900 border border-slate-700 text-slate-300 rounded-full text-sm font-semibold">{{ $wishlists->count() }} Produk Tersimpan</span>
        </div>
    </div>

    @if($wishlists->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($wishlists as $w)
        <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl border border-slate-700/50 overflow-hidden group flex flex-col h-full relative transition-all hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10 hover:border-purple-500/50">
            
            <!-- Badges -->
            <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                @if($w->product->discount_percent > 0)
                    <span class="bg-rose-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg shadow-rose-500/30">-{{ $w->product->discount_percent }}%</span>
                @endif
                @if($w->product->is_new)
                    <span class="bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg shadow-emerald-500/30">BARU</span>
                @endif
            </div>

            <!-- Remove Button -->
            <button onclick="toggleWishlist({{ $w->product->id }}, this)" class="absolute top-4 right-4 w-9 h-9 z-10 rounded-full bg-rose-500 text-white flex items-center justify-center shadow-lg transition-colors border border-rose-600 hover:bg-slate-800 hover:text-slate-400 hover:border-slate-700" title="Hapus dari Wishlist">
                <i class="fa-solid fa-heart"></i>
            </button>

            <!-- Image -->
            <div class="relative h-56 w-full bg-slate-800/30 p-6 flex items-center justify-center overflow-hidden">
                <img src="{{ $w->product->thumbnail_url }}" alt="{{ $w->product->name }}" class="max-w-full max-h-full object-contain drop-shadow-2xl group-hover:scale-110 transition-transform duration-500">
                
                <!-- Quick View Action -->
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 flex items-center justify-center">
                    <a href="{{ route('product.show', [$w->product->id, $w->product->slug]) }}" class="w-12 h-12 rounded-full bg-slate-800 text-slate-300 hover:bg-purple-500 hover:text-white flex items-center justify-center shadow-lg transition-colors border border-slate-700">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </div>
            </div>

            <!-- Info -->
            <div class="p-5 flex-1 flex flex-col">
                <div class="text-[11px] font-semibold text-purple-400 uppercase tracking-widest mb-1">{{ $w->product->brand->name ?? 'Lainnya' }}</div>
                <h3 class="text-lg font-bold text-white mb-2 leading-tight">
                    <a href="{{ route('product.show', [$w->product->id, $w->product->slug]) }}" class="hover:text-purple-400 transition-colors">{{ $w->product->name }}</a>
                </h3>
                
                <div class="mt-auto pt-4 flex flex-col gap-4">
                    <div>
                        @if($w->product->old_price)
                            <div class="text-xs text-slate-500 line-through mb-0.5">{{ $w->product->old_price_formatted }}</div>
                        @endif
                        <div class="text-xl font-bold text-emerald-400">{{ $w->product->price_formatted }}</div>
                    </div>
                    
                    <button onclick="addToCart({{ $w->product->id }})" class="w-full py-2.5 rounded-xl bg-slate-800 hover:bg-emerald-500 text-white font-semibold text-sm flex items-center justify-center gap-2 border border-slate-700 hover:border-emerald-500 transition-all shadow-lg hover:shadow-emerald-500/25 group/btn">
                        <i class="fa-solid fa-cart-plus group-hover/btn:-translate-y-0.5 transition-transform"></i> Pindahkan ke Keranjang
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    
    <!-- Empty State -->
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-3xl p-16 text-center">
            <div class="w-32 h-32 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-8 border border-slate-700">
                <i class="fa-solid fa-heart-crack text-5xl text-slate-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">Wishlist Anda Kosong</h3>
            <p class="text-slate-400 mb-10 max-w-sm mx-auto">Anda belum menyimpan produk apapun ke dalam Wishlist. Yuk temukan sepatu impianmu dan simpan untuk dibeli nanti!</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-purple-500/25">
                <i class="fa-solid fa-store"></i> Mulai Jelajah
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
