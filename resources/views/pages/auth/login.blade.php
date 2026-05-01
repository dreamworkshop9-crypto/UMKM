@extends('layouts.app')
@section('title','Masuk - SALZA')
@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-logo">SAL<span>ZA</span></div>
    <h2>Masuk ke Akun</h2>
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <form action="{{ route('login.post') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="email@contoh.com"/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-input" required placeholder="Password Anda"/>
      </div>
      <div class="form-check">
        <input type="checkbox" name="remember" id="remember"/>
        <label for="remember">Ingat saya</label>
      </div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:16px">
        <i class="fa fa-sign-in-alt"></i> Masuk
      </button>
    </form>
    <p class="auth-link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
  </div>
</div>
@endsection
