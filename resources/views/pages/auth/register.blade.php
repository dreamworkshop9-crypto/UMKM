@extends('layouts.app')
@section('title','Daftar - SALZA')
@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-logo">SAL<span>ZA</span></div>
    <h2>Buat Akun Baru</h2>
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <form action="{{ route('register.post') }}" method="POST">
      @csrf
      <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Nama Anda"/></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="email@contoh.com"/></div>
      <div class="form-group"><label>No. Telepon</label><input type="text" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"/></div>
      <div class="form-group"><label>Password</label><input type="password" name="password" class="form-input" required placeholder="Minimal 8 karakter"/></div>
      <div class="form-group"><label>Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-input" required placeholder="Ulangi password"/></div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:16px">
        <i class="fa fa-user-plus"></i> Daftar
      </button>
    </form>
    <p class="auth-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
  </div>
</div>
@endsection
