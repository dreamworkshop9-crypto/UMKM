@extends('layouts.auth')

@section('title', 'Login - SALZA')

@section('content')
<div class="bg-slate-800/60 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-8">
    <!-- Logo -->
    <div class="flex items-center justify-center space-x-2 mb-8">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-2xl">S</span>
        </div>
        <span class="text-2xl font-bold text-white tracking-wider">SALZA</span>
    </div>

    <h2 class="text-xl font-bold text-white text-center mb-1">Masuk ke Akun</h2>
    <p class="text-sm text-slate-400 text-center mb-8">Silakan masukkan email dan password</p>

    @if(session('error'))
    <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg text-sm text-red-400 text-center">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white text-sm placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-colors" placeholder="nama@email.com">
            @error('email')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Password</label>
            <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white text-sm placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-colors" placeholder="Masukkan password">
            @error('password')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 transition-all duration-200">
            Masuk
        </button>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        Belum punya akun?
        <a href="{{ route('daftar') }}" class="text-purple-400 hover:text-purple-300 font-semibold transition-colors">Daftar sekarang</a>
    </p>
</div>
@endsection
