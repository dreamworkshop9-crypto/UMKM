<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>@yield('title','SALZA - Toko Sepatu Online')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
@stack('styles')
</head>
<body>
<div class="topbar">
  <div class="topbar-inner">
    <span><i class="fa fa-map-marker-alt"></i> SALZA, Jl. Babakan Tiga No. 82 Ciwidey</span>
    <div class="top-links">
      @auth
        <a href="{{ route('wishlist.index') }}"><i class="fa fa-heart"></i> Wishlist</a>
        <a href="{{ route('order.index') }}"><i class="fa fa-box"></i> Pesanan</a>
        <a href="#" onclick="openTrack()"><i class="fa fa-truck"></i> Lacak</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">@csrf
          <button type="submit" class="btn-link"><i class="fa fa-sign-out-alt"></i> Keluar ({{ Auth::user()->name }})</button>
        </form>
      @else
        <a href="#" onclick="openTrack()"><i class="fa fa-truck"></i> Lacak Pesanan</a>
        <a href="{{ route('login') }}"><i class="fa fa-user"></i> Masuk</a>
        <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Daftar</a>
      @endauth
    </div>
  </div>
</div>
 
<header>
  <div class="header-inner">
    <a href="{{ route('home') }}" class="logo">SAL<span>ZA</span></a>
    <div class="search-wrap">
      <form action="{{ route('shop') }}" method="GET">
        <input type="text" name="q" placeholder="Cari sepatu impianmu..." value="{{ request('q') }}"/>
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <div class="header-actions">
      <a href="{{ route('wishlist.index') }}" class="icon-btn" title="Wishlist"><i class="fa fa-heart"></i></a>
      <a href="{{ route('cart.index') }}" class="cart-btn">
        <i class="fa fa-shopping-cart"></i> Keranjang
        <span class="cart-badge" id="cartCount">@auth{{ \App\Models\Cart::where('user_id',Auth::id())->sum('quantity') }}@else0@endauth</span>
      </a>
    </div>
  </div>
</header>
 
<nav>
  <ul class="nav-menu">
    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home')?'active':'' }}">Beranda</a></li>
    @foreach($categories??[] as $cat)
    <li class="has-dropdown">
      <a href="{{ route('shop',['category'=>$cat->slug]) }}">{{ $cat->name }} <i class="fa fa-chevron-down"></i></a>
      @if($cat->children->count())
      <ul class="dropdown">
        @foreach($cat->children as $sub)
        <li>
          <span class="dropdown-title">{{ $sub->name }}</span>
          @foreach($sub->children as $ss)
          <a href="{{ route('product.subsubcategory',[$ss->id,$ss->slug]) }}">{{ $ss->name }}</a>
          @endforeach
        </li>
        @endforeach
      </ul>
      @endif
    </li>
    @endforeach
    <li><a href="{{ route('shop') }}">Belanja</a></li>
    <li><a href="{{ route('shop',['sort'=>'price_asc']) }}" style="color:#d4a843">Promo</a></li>
  </ul>
</nav>
 
@if(session('success'))<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}<button onclick="this.parentElement.remove()" class="alert-close">&times;</button></div>@endif
@if(session('error'))<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}<button onclick="this.parentElement.remove()" class="alert-close">&times;</button></div>@endif
 
<main>@yield('content')</main>
 
<footer>
  <div class="footer-inner">
    <div class="footer-col footer-about">
      <div class="footer-logo">SAL<span>ZA</span></div>
      <p>SALZA adalah perusahaan jual beli sepatu secara online dengan kualitas terjamin dan harga terjangkau.</p>
      <div class="socials">
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Link</h4>
      <ul>
        <li><a href="#">Tentang Kami</a></li>
        <li><a href="{{ route('shop') }}">Semua Produk</a></li>
        <li><a href="#">Kontak Kami</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Layanan</h4>
      <ul>
        @auth<li><a href="{{ route('order.index') }}">Pesanan Saya</a></li>@else<li><a href="{{ route('login') }}">Akun Saya</a></li>@endauth
        <li><a href="#" onclick="openTrack()">Lacak Pesanan</a></li>
        <li><a href="#">FAQ</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Hubungi Kami</h4>
      <ul class="footer-contact">
        <li><i class="fa fa-map-marker-alt"></i> Jl. Babakan Tiga No. 82 Ciwidey</li>
        <li><i class="fa fa-phone"></i> +6281563977109</li>
        <li><i class="fa fa-envelope"></i> esalza@gmail.com</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">&copy; {{ date('Y') }} Salza. All Rights Reserved</div>
</footer>
 
<div class="modal-overlay" id="trackOverlay" onclick="if(event.target===this)closeTrack()">
  <div class="modal">
    <button class="modal-close" onclick="closeTrack()">&times;</button>
    <h3>Lacak Pesanan</h3>
    <p class="modal-sub">Masukkan nomor invoice Anda</p>
    <input type="text" id="invoiceInput" placeholder="Contoh: INV-ABCD1234XY" class="form-input" style="margin-bottom:12px"/>
    <button class="btn-primary" style="width:100%;justify-content:center" onclick="trackOrder()">
      <i class="fa fa-search"></i> Cari Pesanan
    </button>
    <div id="trackResult" style="display:none;margin-top:16px"></div>
  </div>
</div>
 
<div class="toast" id="toast"></div>
 
<script>
window.csrfToken = '{{ csrf_token() }}';
function openTrack()  { document.getElementById('trackOverlay').classList.add('open'); }
function closeTrack() { document.getElementById('trackOverlay').classList.remove('open'); document.getElementById('trackResult').style.display='none'; }
async function trackOrder() {
  const inv = document.getElementById('invoiceInput').value.trim();
  if (!inv) { showToast('Masukkan nomor invoice!','warning'); return; }
  const res  = await fetch('{{ route("order.track") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':window.csrfToken},body:JSON.stringify({invoice:inv})});
  const data = await res.json();
  const el = document.getElementById('trackResult');
  el.style.display='block';
  el.innerHTML = data.found
    ? `<div class="track-info"><div><b>Invoice:</b> ${data.invoice}</div><div><b>Status:</b> ${data.status}</div><div><b>Tanggal:</b> ${data.date}</div><div><b>Total:</b> ${data.total}</div></div>`
    : `<p style="color:red"><i class="fa fa-times-circle"></i> ${data.message}</p>`;
}
function showToast(msg,type='success') {
  const t=document.getElementById('toast');
  t.textContent=msg; t.className='toast toast-'+type+' show';
  setTimeout(()=>t.classList.remove('show'),3200);
}
async function addToCart(productId,size='',color='',qty=1) {
  @auth
  const res  = await fetch('{{ route("cart.add") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':window.csrfToken},body:JSON.stringify({product_id:productId,quantity:qty,size,color})});
  const data = await res.json();
  if (data.success) { document.getElementById('cartCount').textContent=data.count; showToast(data.message); }
  @else
  window.location.href='{{ route("login") }}';
  @endauth
}
async function toggleWishlist(productId,btn) {
  @auth
  const res  = await fetch('{{ route("wishlist.toggle") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':window.csrfToken},body:JSON.stringify({product_id:productId})});
  const data = await res.json();
  showToast(data.message); btn.classList.toggle('wishlist-active');
  @else
  window.location.href='{{ route("login") }}';
  @endauth
}
setTimeout(()=>document.querySelectorAll('.alert').forEach(a=>a.remove()),4000);
</script>
@stack('scripts')
</body>
</html>
