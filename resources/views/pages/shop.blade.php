@extends('layouts.app')
@section('title','Belanja - SALZA')
@section('content')
<div class="container" style="padding:30px 20px 60px">
  <div class="shop-layout">
    <aside class="shop-sidebar">
      <div class="sidebar-box">
        <h4>Kategori</h4>
        <ul class="sidebar-list">
          <li><a href="{{ route('shop') }}" class="{{ !request('category')?'active':'' }}">Semua</a></li>
          @foreach($categories as $cat)
          <li>
            <a href="{{ route('shop',['category'=>$cat->slug]) }}" class="{{ request('category')===$cat->slug?'active':'' }}">{{ $cat->name }}</a>
            @if($cat->children->count())
            <ul class="sidebar-sub">
              @foreach($cat->children as $sub)
              <li><a href="{{ route('shop',['category'=>$sub->slug]) }}">{{ $sub->name }}</a></li>
              @endforeach
            </ul>
            @endif
          </li>
          @endforeach
        </ul>
      </div>
      <div class="sidebar-box">
        <h4>Brand</h4>
        <ul class="sidebar-list">
          @foreach($brands as $b)
          <li><a href="{{ route('shop',['brand'=>$b->slug]) }}" class="{{ request('brand')===$b->slug?'active':'' }}">{{ $b->name }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="sidebar-box">
        <h4>Filter Harga</h4>
        <form action="{{ route('shop') }}" method="GET">
          <div class="price-range">
            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="form-input sm"/>
            <span>–</span>
            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="form-input sm"/>
          </div>
          <button type="submit" class="btn-primary sm" style="margin-top:10px;width:100%">Filter</button>
        </form>
      </div>
    </aside>
    <div class="shop-main">
      <div class="shop-header">
        <div>Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari {{ $products->total() }} produk</div>
        <form action="{{ route('shop') }}" method="GET">
          <input type="hidden" name="q" value="{{ request('q') }}"/>
          <input type="hidden" name="category" value="{{ request('category') }}"/>
          <input type="hidden" name="brand" value="{{ request('brand') }}"/>
          <select name="sort" onchange="this.form.submit()" class="form-select">
            <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>Terbaru</option>
            <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Harga Terendah</option>
            <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Harga Tertinggi</option>
          </select>
        </form>
      </div>
      @if($products->count())
      <div class="product-grid">
        @foreach($products as $p)
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" loading="lazy"/>
            @if($p->discount_percent>0)<span class="badge badge-sale">{{ $p->discount_percent }}%</span>@elseif($p->is_new)<span class="badge badge-new">BARU</span>@endif
            <div class="product-actions">
              <button class="action-btn" onclick="toggleWishlist({{ $p->id }},this)"><i class="fa fa-heart"></i></button>
              <a href="{{ route('product.show',[$p->id,$p->slug]) }}" class="action-btn"><i class="fa fa-eye"></i></a>
            </div>
          </div>
          <div class="product-info">
            <div class="product-brand">{{ $p->brand->name??'' }}</div>
            <h3><a href="{{ route('product.show',[$p->id,$p->slug]) }}">{{ $p->name }}</a></h3>
            <div class="price-row">
              <span class="price">{{ $p->price_formatted }}</span>
              @if($p->old_price)<span class="price-old">{{ $p->old_price_formatted }}</span>@endif
            </div>
            <button class="btn-cart" onclick="addToCart({{ $p->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
          </div>
        </div>
        @endforeach
      </div>
      <div class="pagination-wrap">{{ $products->links() }}</div>
      @else
      <div class="empty-state"><i class="fa fa-search fa-3x"></i><p>Produk tidak ditemukan.</p><a href="{{ route('shop') }}" class="btn-primary">Lihat Semua</a></div>
      @endif
    </div>
  </div>
</div>
@endsection
