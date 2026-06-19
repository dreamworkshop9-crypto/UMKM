@extends('layouts.app')
@section('title','Keranjang - SALZA')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400">
            <i class="fa-solid fa-shopping-cart text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Keranjang Belanja</h2>
    </div>

    @if($cartItems->count())
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Cart Items -->
        <div class="flex-1 space-y-4">
            @foreach($cartItems as $item)
            <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-xl p-3 sm:p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4 relative group transition-all hover:border-slate-700" id="ci-{{ $item->id }}">
                
                <!-- Product Image -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg bg-slate-800/50 p-2 flex-shrink-0 border border-slate-700/50 flex items-center justify-center overflow-hidden">
                    <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500"/>
                </div>

                <!-- Product Info -->
                <div class="flex-1 flex flex-col justify-center w-full">
                    <h4 class="text-base font-bold text-white mb-1.5 leading-tight pr-8 truncate">
                        <a href="{{ route('product.show', [$item->product->id, $item->product->slug]) }}" class="hover:text-emerald-400 transition-colors">{{ $item->product->name }}</a>
                    </h4>
                    
                    <div class="flex flex-wrap gap-2 mb-2">
                        @if($item->size)
                        <div class="px-2 py-0.5 rounded-md bg-slate-800 border border-slate-700 text-[10px] font-semibold text-slate-300">
                            <span class="text-slate-500">Ukuran:</span> {{ $item->size }}
                        </div>
                        @endif
                        @if($item->color)
                        <div class="px-2 py-0.5 rounded-md bg-slate-800 border border-slate-700 text-[10px] font-semibold text-slate-300 flex items-center gap-1">
                            <span class="text-slate-500">Warna:</span> 
                            <span class="w-2 h-2 rounded-full border border-slate-600 inline-block" style="background-color: {{ strtolower($item->color) }}"></span>
                            {{ $item->color }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="text-emerald-400 font-bold text-sm">{{ $item->product->price_formatted }}</div>
                </div>

                <!-- Quantity & Subtotal -->
                <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-3 sm:gap-4 mt-3 sm:mt-0">
                    <div class="text-right hidden sm:block">
                        <div class="text-[9px] text-slate-500 uppercase tracking-widest font-bold mb-0.5">Subtotal</div>
                        <div class="text-base font-bold text-white">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="flex items-center bg-slate-950 border border-slate-800 rounded-lg p-1 h-9">
                        <button class="w-7 h-7 rounded text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition-colors" onclick="updateCart({{ $item->id }}, {{ $item->quantity - 1 }})">
                            <i class="fa-solid fa-minus text-[10px]"></i>
                        </button>
                        <span class="w-8 text-center text-xs font-bold text-white">{{ $item->quantity }}</span>
                        <button class="w-7 h-7 rounded text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition-colors" onclick="updateCart({{ $item->id }}, {{ $item->quantity + 1 }})">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Remove Button -->
                <button class="absolute top-3 right-3 w-7 h-7 rounded-md bg-rose-500/10 text-rose-500 flex items-center justify-center border border-rose-500/20 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-all hover:bg-rose-500 hover:text-white" onclick="removeCart({{ $item->id }})" title="Hapus Produk">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
                
                <!-- Mobile Subtotal -->
                <div class="text-right sm:hidden ml-auto">
                    <div class="text-sm font-bold text-white">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Checkout Summary -->
        <div class="w-full md:w-80 flex-shrink-0">
            <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-xl p-5 sticky top-24">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-purple-400 text-sm"></i> Ringkasan Pesanan
                </h3>
                
                <div class="space-y-3 mb-5 text-xs">
                    <div class="flex justify-between items-center text-slate-300">
                        <span>Subtotal Produk</span>
                        <span class="font-bold text-white">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-300">
                        <span>Ongkos Kirim</span>
                        <span class="text-[10px] px-2 py-0.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded font-semibold">Dihitung otomatis</span>
                    </div>
                </div>
                
                <div class="pt-3 border-t border-slate-800 mb-6">
                    <div class="flex justify-between items-end">
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total</span>
                        <span class="text-2xl font-bold text-emerald-400 leading-none">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <h3 class="text-sm font-bold text-white mb-3">Informasi Pengiriman</h3>
                <form action="{{ route('order.checkout') }}" method="POST" class="space-y-3">
                    @csrf
                    
                    <div class="space-y-2">
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-3 top-3 text-slate-500 text-xs"></i>
                            <input type="text" name="name" class="w-full bg-slate-950 border border-slate-800 rounded-lg py-2.5 pl-9 pr-3 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-slate-600" value="{{ Auth::user()->name }}" placeholder="Nama Lengkap" required/>
                        </div>
                        
                        <div class="relative">
                            <i class="fa-solid fa-phone absolute left-3 top-3 text-slate-500 text-xs"></i>
                            <input type="text" name="phone" class="w-full bg-slate-950 border border-slate-800 rounded-lg py-2.5 pl-9 pr-3 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-slate-600" value="{{ Auth::user()->phone ?? '' }}" placeholder="Nomor WhatsApp" required/>
                        </div>
                        
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-3 top-3 text-slate-500 text-xs"></i>
                            <textarea name="address" class="w-full bg-slate-950 border border-slate-800 rounded-lg py-2.5 pl-9 pr-3 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-slate-600 min-h-[80px] resize-y" placeholder="Alamat Lengkap" required></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2">
                            <div class="relative">
                                <i class="fa-solid fa-city absolute left-3 top-3 text-slate-500 text-xs"></i>
                                <input type="text" name="city" class="w-full bg-slate-950 border border-slate-800 rounded-lg py-2.5 pl-9 pr-3 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-slate-600" placeholder="Kota/Kab" required/>
                            </div>
                            <div class="relative">
                                <i class="fa-solid fa-map-pin absolute left-3 top-3 text-slate-500 text-xs"></i>
                                <input type="text" name="postal_code" class="w-full bg-slate-950 border border-slate-800 rounded-lg py-2.5 pl-9 pr-3 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-slate-600" placeholder="Kode Pos" required/>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3">
                        <label class="block text-[11px] font-semibold text-slate-400 mb-2 uppercase tracking-wider">Pilih Pembayaran</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="cod" class="peer sr-only" checked>
                                <div class="p-2 border border-slate-700 bg-slate-800 rounded-lg text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-400 transition-all">
                                    <i class="fa-solid fa-hand-holding-dollar block text-sm mb-1"></i>
                                    <span class="text-[10px] font-bold">COD (Bayar di Tempat)</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer" class="peer sr-only">
                                <div class="p-2 border border-slate-700 bg-slate-800 rounded-lg text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-400 transition-all">
                                    <i class="fa-solid fa-building-columns block text-sm mb-1"></i>
                                    <span class="text-[10px] font-bold">Transfer Bank</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 mt-4 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 group">
                        Buat Pesanan <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else
    
    <!-- Empty State -->
    <div class="max-w-xl mx-auto mt-8">
        <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-2xl p-10 text-center">
            <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-700">
                <i class="fa-solid fa-cart-arrow-down text-3xl text-slate-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Keranjang Belanja Kosong</h3>
            <p class="text-sm text-slate-400 mb-8 max-w-sm mx-auto">Anda belum menambahkan produk apapun. Yuk temukan sepatu impianmu sekarang!</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-500 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-purple-500/25">
                <i class="fa-solid fa-store"></i> Mulai Belanja
            </a>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
async function updateCart(id, qty) {
    if (qty < 1) { removeCart(id); return; }
    
    const itemEl = document.getElementById('ci-'+id);
    if(itemEl) itemEl.style.opacity = '0.5';

    try {
        const r = await fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify({ cart_id: id, quantity: qty })
        });
        const data = await r.json();
        
        if (data.success) {
            location.reload();
        } else {
            showToast('Gagal memperbarui kuantitas', 'error');
            if(itemEl) itemEl.style.opacity = '1';
        }
    } catch (e) {
        showToast('Terjadi kesalahan jaringan', 'error');
        if(itemEl) itemEl.style.opacity = '1';
    }
}

async function removeCart(id) {
    if (!confirm('Hapus produk ini dari keranjang?')) return;
    
    const itemEl = document.getElementById('ci-'+id);
    if(itemEl) itemEl.style.opacity = '0.5';

    try {
        const r = await fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify({ cart_id: id })
        });
        const data = await r.json();
        
        if (data.success) {
            location.reload();
        } else {
            showToast('Gagal menghapus produk', 'error');
            if(itemEl) itemEl.style.opacity = '1';
        }
    } catch (e) {
        showToast('Terjadi kesalahan jaringan', 'error');
        if(itemEl) itemEl.style.opacity = '1';
    }
}
</script>
@endpush
@endsection
