@extends('layouts.app')
@section('title','SALZA - Toko Sepatu Online Terpercaya')
@section('content')

<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-content">
    <span class="hero-tag">Koleksi Terbaru 2024</span>
    <h1>Adidas<br/><span>Nyaman &amp; Stylish</span></h1>
    <p>Sepatu Adidas yang nyaman dipakai untuk menemani aktivitas anda sehari-hari.</p>
    <a href="{{ route('shop') }}" class="btn-primary"><i class="fa fa-shopping-bag"></i> Belanja Sekarang</a>
  </div>
</section>

<section class="features">
  <div class="container">
    <div class="features-grid">
      <div class="feature-item"><div class="feature-icon"><i class="fa fa-shipping-fast"></i></div><div><h4>Pengiriman Cepat</h4><p>Kurir pengiriman yang handal</p></div></div>
      <div class="feature-item"><div class="feature-icon"><i class="fa fa-shield-alt"></i></div><div><h4>Kualitas Terjamin</h4><p>3 Bulan garansi produk</p></div></div>
      <div class="feature-item"><div class="feature-icon"><i class="fa fa-credit-card"></i></div><div><h4>Pembayaran Mudah</h4><p>Bisa Cash On Delivery</p></div></div>
      <div class="feature-item"><div class="feature-icon"><i class="fa fa-headset"></i></div><div><h4>Admin Bersahabat</h4><p>Admin yang ramah dan edukatif</p></div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header"><div class="sub-title">Pilihan Terbaik</div><h2>PRODUK KAMI</h2></div>
    <div class="tabs">
      <button class="tab-btn active" onclick="filterTab(this,'all')">Semua</button>
      @foreach($categories as $cat)
      <button class="tab-btn" onclick="filterTab(this,'{{ \Illuminate\Support\Str::slug($cat->name) }}')">{{ $cat->name }}</button>
      @endforeach
    </div>
    <div class="product-grid" id="productGrid">
      @foreach($featuredProducts as $p)
      <div class="product-card" data-cat="{{ \Illuminate\Support\Str::slug($p->category->name??'lainnya') }}">
        <div class="product-img-wrap">
          <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" loading="lazy"/>
          @if($p->discount_percent>0)<span class="badge badge-sale">{{ $p->discount_percent }}%</span>
          @elseif($p->is_new)<span class="badge badge-new">BARU</span>@endif
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
    <div class="text-center" style="margin-top:30px">
      <a href="{{ route('shop') }}" class="btn-outline">Lihat Semua Produk <i class="fa fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<div class="container">
  <div class="banner-double">
    <a href="{{ route('shop',['category'=>'wanita']) }}" class="banner-item">
      <img src="https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=600&q=80" alt="Wanita"/>
      <div class="banner-label">Koleksi Wanita</div>
    </a>
    <a href="{{ route('shop',['category'=>'pria']) }}" class="banner-item">
      <img src="https://images.unsplash.com/photo-1579338559194-a162d19bf842?w=600&q=80" alt="Pria"/>
      <div class="banner-label">Koleksi Pria</div>
    </a>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="side-grid">
      <div class="side-section">
        <h3 class="side-title">PRODUK TERBARU</h3>
        @foreach($newProducts as $p)
        <div class="mini-product">
          <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}"/>
          <div class="mini-product-info">
            <h4><a href="{{ route('product.show',[$p->id,$p->slug]) }}">{{ $p->name }}</a></h4>
            <div class="price-row"><span class="price">{{ $p->price_formatted }}</span>@if($p->old_price)<span class="price-old">{{ $p->old_price_formatted }}</span>@endif</div>
            <button class="btn-cart sm" onclick="addToCart({{ $p->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
          </div>
        </div>
        @endforeach
      </div>
      <div class="side-section">
        <h3 class="side-title">BEST SELLER</h3>
        @foreach($bestSellers as $p)
        <div class="mini-product">
          <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}"/>
          <div class="mini-product-info">
            <h4><a href="{{ route('product.show',[$p->id,$p->slug]) }}">{{ $p->name }}</a></h4>
            <div class="price-row"><span class="price">{{ $p->price_formatted }}</span>@if($p->old_price)<span class="price-old">{{ $p->old_price_formatted }}</span>@endif</div>
            <button class="btn-cart sm" onclick="addToCart({{ $p->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<div class="container">
  <div class="sale-banner">
    <div class="sale-inner">
      <h2>BIG <span>SALE</span> 🔥</h2>
      <p>Dapatkan diskon hingga 30% untuk produk pilihan kami!</p>
      <a href="{{ route('shop') }}" class="btn-primary" style="margin-top:14px">Belanja Sekarang</a>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="section-header"><div class="sub-title">Baru Tiba</div><h2>KOLEKSI TERBARU</h2></div>
    <div class="product-grid">
      @foreach($newCollection as $p)
      <div class="product-card">
        <div class="product-img-wrap">
          <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" loading="lazy"/>
          <span class="badge badge-new">BARU</span>
          <div class="product-actions">
            <button class="action-btn" onclick="toggleWishlist({{ $p->id }},this)"><i class="fa fa-heart"></i></button>
            <a href="{{ route('product.show',[$p->id,$p->slug]) }}" class="action-btn"><i class="fa fa-eye"></i></a>
          </div>
        </div>
        <div class="product-info">
          <div class="product-brand">{{ $p->brand->name??'' }}</div>
          <h3><a href="{{ route('product.show',[$p->id,$p->slug]) }}">{{ $p->name }}</a></h3>
          <div class="price-row"><span class="price">{{ $p->price_formatted }}</span></div>
          <button class="btn-cart" onclick="addToCart({{ $p->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-header"><div class="sub-title">Hemat Lebih</div><h2>PRODUK PROMO</h2></div>
    <div class="product-grid">
      @foreach($promoProducts as $p)
      <div class="product-card">
        <div class="product-img-wrap">
          <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" loading="lazy"/>
          <span class="badge badge-sale">{{ $p->discount_percent }}%</span>
          <div class="product-actions">
            <button class="action-btn" onclick="toggleWishlist({{ $p->id }},this)"><i class="fa fa-heart"></i></button>
            <a href="{{ route('product.show',[$p->id,$p->slug]) }}" class="action-btn"><i class="fa fa-eye"></i></a>
          </div>
        </div>
        <div class="product-info">
          <div class="product-brand">{{ $p->brand->name??'' }}</div>
          <h3><a href="{{ route('product.show',[$p->id,$p->slug]) }}">{{ $p->name }}</a></h3>
          <div class="price-row"><span class="price">{{ $p->price_formatted }}</span><span class="price-old">{{ $p->old_price_formatted }}</span></div>
          <button class="btn-cart" onclick="addToCart({{ $p->id }})"><i class="fa fa-cart-plus"></i> Keranjang</button>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="brands-section">
  <div class="container">
    <div class="section-header"><div class="sub-title">Partner Kami</div><h2>BRAND KAMI</h2></div>
    <div class="brands-grid">
      @foreach($brands as $b)
      <a href="{{ route('shop',['brand'=>$b->slug]) }}" class="brand-item">
        @if($b->image)<img src="{{ asset('storage/'.$b->image) }}" alt="{{ $b->name }}"/>@else<span>{{ $b->name }}</span>@endif
      </a>
      @endforeach
    </div>
  </div>
</section>

@endsection
@push('scripts')
<script>
function filterTab(btn,cat) {
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#productGrid .product-card').forEach(c=>{
    c.style.display=(cat==='all'||c.dataset.cat===cat)?'':'none';
  });
}
</script>
@endpush
