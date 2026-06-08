@extends('layouts.admin')

@section('title', ($title ?? 'Halaman') . ' - SALZA')
@section('page-title', $title ?? 'Halaman')

@section('content')
<div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 p-16 text-center">
    <div class="w-16 h-16 rounded-2xl bg-slate-700/50 flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-hammer text-2xl text-slate-500"></i>
    </div>
    <h3 class="text-lg font-bold text-white mb-1">{{ $title }}</h3>
    <p class="text-sm text-slate-400">Halaman ini masih dalam pengembangan.</p>
</div>
@endsection
