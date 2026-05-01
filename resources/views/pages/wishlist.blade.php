@extends('layouts.app')
@section('title','Wishlist - SALZA')
@section('content')
<div class="container" style="padding:30px 20px 60px">
  <h2 class="page-title">Wishlist Saya</h2>
  @if($wishlists->count())
  <div class="product-grid">
    @foreach($wishlists as $w)
    <div class="product-card">
      <div class="product-img-wrap">
        <img src="{{ $w->product->thumbnail_url }}" alt="{{ $w->product->name }}" loading="lazy"/>
        <div class="product-actions">
          <button class="action-btn wishlist-active" onclick="toggleWishlist({{ $w->product->id }},this)"><i class="fa fa-heart"></i></button>
          <a href="{{ route('product.show',[$w->product->id,$w->product->slug]) }}" class="action-btn"><i class="fa fa-eye"></i></a>
        </div>
      </div>
      <div class="product-info">
        <h3><a href="{{ route('product.show',[$w->product->id,$w->product->slug]) }}">{{ $w->product->name }}</a></h3>
        <div class="price-row">
          <span class="price">{{ $w->product->price_formatted }}</span>
          @if($w->product->old_price)<span class="price-old">{{ $w->product->old_price_formatted }}</span>@endif
        </div>
        <button class="btn-cart" onclick="addToCart({{ $w->product->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
      </div>
    </div>
    @endforeach
  </div>
  @else
  <div class="empty-state"><i class="fa fa-heart fa-4x"></i><h3>Wishlist Masih Kosong</h3><p>Tambahkan produk favoritmu!</p><a href="{{ route('shop') }}" class="btn-primary">Jelajahi Produk</a></div>
  @endif
</div>
@endsection
