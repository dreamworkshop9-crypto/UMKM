@extends('layouts.app')
@section('title', $product->name . ' - SALZA')
@section('content')
<div class="container" style="padding:30px 20px 60px">
  <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a> &rsaquo; <a href="{{ route('shop') }}">Belanja</a> &rsaquo; <span>{{ $product->name }}</span></div>
  <div class="product-detail-layout">
    <div class="product-gallery">
      <div class="main-img"><img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"/></div>
      @if($product->images->count())
      <div class="thumb-list">
        @foreach($product->images as $image)
        <img class="thumb" src="{{ asset('storage/'.$image->image) }}" alt="{{ $product->name }}" loading="lazy"/>
        @endforeach
      </div>
      @endif
    </div>
    <div class="product-detail-info">
      <div class="product-brand-tag">{{ $product->brand->name ?? 'Brand' }}</div>
      <h1>{{ $product->name }}</h1>
      <div class="price-row large">
        <span class="price">{{ $product->price_formatted }}</span>
        @if($product->old_price)<span class="price-old">{{ $product->old_price_formatted }}</span>@endif
      </div>
      @if($product->discount_percent > 0)<span class="discount-badge">Diskon {{ $product->discount_percent }}%</span>@endif
      <p class="product-meta">{{ \Illuminate\Support\Str::limit($product->description, 220) }}</p>
      <div class="detail-actions">
        <button class="btn-primary" onclick="addToCart({{ $product->id }})"><i class="fa fa-cart-plus"></i> Tambah ke Keranjang</button>
        <button class="btn-wishlist" onclick="toggleWishlist({{ $product->id }}, this)"><i class="fa fa-heart"></i></button>
      </div>
      <div class="product-meta">SKU: {{ $product->sku ?? '-' }} | Stok: {{ $product->stock }} | Berat: {{ $product->weight ?? '-' }} gr</div>
    </div>
  </div>
  <div class="product-description">
    <h3>Deskripsi Produk</h3>
    <div class="description-content">{!! nl2br(e($product->description)) !!}</div>
  </div>
  @if($related->count())
  <section class="section related-products">
    <div class="section-header"><div class="sub-title">Rekomendasi</div><h2>Produk Terkait</h2></div>
    <div class="product-grid">
      @foreach($related as $item)
      <div class="product-card">
        <div class="product-img-wrap"><img src="{{ $item->thumbnail_url }}" alt="{{ $item->name }}"/></div>
        <div class="product-info">
          <h3><a href="{{ route('product.show',[$item->id,$item->slug]) }}">{{ $item->name }}</a></h3>
          <div class="price-row"><span class="price">{{ $item->price_formatted }}</span>@if($item->old_price)<span class="price-old">{{ $item->old_price_formatted }}</span>@endif</div>
          <button class="btn-cart" onclick="addToCart({{ $item->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  @endif
</div>
@endsection
