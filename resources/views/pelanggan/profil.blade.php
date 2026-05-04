@extends('layouts.pelanggan')
@section('title', 'Profil Saya - SALZA')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-3xl">
    <div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
        <div class="p-6 border-b border-slate-700/50">
            <h2 class="text-xl font-bold text-white">Informasi Akun</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola data pribadi Anda untuk mempermudah proses belanja.</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div class="flex items-center space-x-6 mb-6">
                    <div class="w-20 h-20 rounded-full bg-slate-700 flex items-center justify-center overflow-hidden border-2 border-slate-600">
                        <i class="fa fa-user text-3xl text-slate-400"></i>
                    </div>
                    <div>
                        <button type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-sm border border-slate-600 transition-colors">Ubah Foto</button>
                        <p class="text-xs text-slate-500 mt-2">Maks. 2MB (JPG, PNG)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->name }}" class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full bg-slate-800/50 border border-slate-700 text-slate-400 rounded-lg px-4 py-2.5 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">No. Telepon</label>
                        <input type="text" value="{{ auth()->user()->phone ?? '' }}" placeholder="Contoh: 081234567890" class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-lg shadow-lg shadow-emerald-500/20 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
