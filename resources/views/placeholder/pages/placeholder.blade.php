@extends('layouts.app')

@section('title', $title ?? 'Halaman')

@section('content')
<div class="p-8">
    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 p-16 text-center">
        <div class="w-16 h-16 rounded-2xl bg-slate-700/50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-white mb-1">{{ $title }}</h3>
        <p class="text-sm text-slate-400">Halaman ini masih dalam pengembangan.</p>
    </div>
</div>
@endsection