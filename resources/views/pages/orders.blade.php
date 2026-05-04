@extends('layouts.app')
@section('title','Pesanan Saya - SALZA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400">
            <i class="fa-solid fa-box-open text-xl"></i>
        </div>
        <div>
            <h2 class="text-3xl font-bold text-white tracking-tight">Riwayat Pesanan</h2>
            <p class="text-sm text-slate-400 mt-1">Pantau status pesanan sepatu Anda di sini.</p>
        </div>
    </div>

    @if($orders->count())
    <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950 border-b border-slate-800">
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Invoice / Tanggal</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Produk</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pembayaran</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($orders as $o)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center text-slate-500 flex-shrink-0">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <div>
                                    <span class="block font-bold text-white mb-0.5">{{ $o->invoice }}</span>
                                    <span class="text-xs text-slate-500">{{ $o->created_at->format('d M Y - H:i') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-[-10px]">
                                @foreach($o->items->take(3) as $item)
                                    <div class="w-10 h-10 rounded-full bg-white border-2 border-slate-900 overflow-hidden shadow-sm relative z-[{{ 3 - $loop->index }}]" title="{{ $item->product->name }}">
                                        <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                                @if($o->items->count() > 3)
                                    <div class="w-10 h-10 rounded-full bg-slate-800 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold text-white relative z-0">
                                        +{{ $o->items->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-xs text-slate-400 mt-2">{{ $o->items->count() }} Item | {{ strtoupper($o->payment_method) }}</div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="font-bold text-emerald-400 block">{{ $o->total_formatted }}</span>
                        </td>
                        <td class="py-5 px-6">
                            @if($o->status == 'pending')
                                <span class="px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[11px] font-bold uppercase tracking-widest"><i class="fa-solid fa-clock mr-1"></i> Menunggu</span>
                            @elseif($o->status == 'processing')
                                <span class="px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[11px] font-bold uppercase tracking-widest"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Diproses</span>
                            @elseif($o->status == 'shipped')
                                <span class="px-3 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[11px] font-bold uppercase tracking-widest"><i class="fa-solid fa-truck-fast mr-1"></i> Dikirim</span>
                            @elseif($o->status == 'completed')
                                <span class="px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-bold uppercase tracking-widest"><i class="fa-solid fa-check-double mr-1"></i> Selesai</span>
                            @elseif($o->status == 'cancelled')
                                <span class="px-3 py-1.5 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 text-[11px] font-bold uppercase tracking-widest"><i class="fa-solid fa-xmark mr-1"></i> Dibatalkan</span>
                            @else
                                <span class="px-3 py-1.5 rounded-full bg-slate-500/10 border border-slate-500/20 text-slate-400 text-[11px] font-bold uppercase tracking-widest">{{ $o->status_label }}</span>
                            @endif
                        </td>
                        <td class="py-5 px-6 text-right">
                            <a href="{{ route('order.show', $o->invoice) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-purple-600 text-white text-xs font-bold rounded-lg border border-slate-700 hover:border-purple-500 transition-all">
                                <i class="fa-solid fa-arrow-right"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="p-6 border-t border-slate-800">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
    @else
    
    <!-- Empty State -->
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-3xl p-16 text-center">
            <div class="w-32 h-32 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-8 border border-slate-700">
                <i class="fa-solid fa-box-open text-5xl text-slate-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">Belum Ada Pesanan</h3>
            <p class="text-slate-400 mb-10 max-w-sm mx-auto">Riwayat belanja Anda masih kosong. Temukan sepatu favorit Anda dan mulai koleksi gaya terbaru!</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-purple-500/25">
                <i class="fa-solid fa-store"></i> Mulai Belanja
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
