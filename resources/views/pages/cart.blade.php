@extends('layouts.app')
@section('title','Keranjang - SALZA')
@section('content')
<div class="container" style="padding:30px 20px 60px">
  <h2 class="page-title">Keranjang Belanja</h2>
  @if($cartItems->count())
  <div class="cart-layout">
    <div class="cart-items">
      @foreach($cartItems as $item)
      <div class="cart-item" id="ci-{{ $item->id }}">
        <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}"/>
        <div class="cart-item-info">
          <h4>{{ $item->product->name }}</h4>
          @if($item->size)<div class="item-meta">Ukuran: {{ $item->size }}</div>@endif
          @if($item->color)<div class="item-meta">Warna: {{ $item->color }}</div>@endif
          <div class="price">{{ $item->product->price_formatted }}</div>
        </div>
        <div class="cart-item-qty">
          <button class="qty-btn" onclick="updateCart({{ $item->id }},{{ $item->quantity-1 }})">−</button>
          <span>{{ $item->quantity }}</span>
          <button class="qty-btn" onclick="updateCart({{ $item->id }},{{ $item->quantity+1 }})">+</button>
        </div>
        <div class="cart-item-sub">Rp{{ number_format($item->product->price*$item->quantity,0,',','.') }}</div>
        <button class="remove-btn" onclick="removeCart({{ $item->id }})"><i class="fa fa-trash"></i></button>
      </div>
      @endforeach
    </div>
    <div class="cart-summary">
      <h3>Ringkasan Pesanan</h3>
      <div class="summary-row"><span>Subtotal</span><span>Rp{{ number_format($subtotal,0,',','.') }}</span></div>
      <div class="summary-row"><span>Ongkos Kirim</span><span>Dihitung saat checkout</span></div>
      <hr/>
      <div class="summary-row total"><span>Total</span><span>Rp{{ number_format($subtotal,0,',','.') }}</span></div>
      <h3 style="margin-top:24px">Data Pengiriman</h3>
      <form action="{{ route('order.checkout') }}" method="POST">
        @csrf
        <div class="form-group"><label>Nama Penerima</label><input type="text" name="name" class="form-input" value="{{ Auth::user()->name }}" required/></div>
        <div class="form-group"><label>No. Telepon</label><input type="text" name="phone" class="form-input" value="{{ Auth::user()->phone??'' }}" required/></div>
        <div class="form-group"><label>Alamat Lengkap</label><textarea name="address" class="form-input" rows="3" required></textarea></div>
        <div class="form-group"><label>Kota</label><input type="text" name="city" class="form-input" required/></div>
        <div class="form-group"><label>Kode Pos</label><input type="text" name="postal_code" class="form-input" required/></div>
        <div class="form-group">
          <label>Metode Pembayaran</label>
          <select name="payment_method" class="form-select">
            <option value="cod">Cash On Delivery (COD)</option>
            <option value="transfer">Transfer Bank</option>
          </select>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center"><i class="fa fa-check"></i> Buat Pesanan</button>
      </form>
    </div>
  </div>
  @else
  <div class="empty-state"><i class="fa fa-shopping-cart fa-4x"></i><h3>Keranjang Masih Kosong</h3><p>Yuk mulai belanja sepatu favoritmu!</p><a href="{{ route('shop') }}" class="btn-primary">Mulai Belanja</a></div>
  @endif
</div>
@push('scripts')
<script>
async function updateCart(id,qty) {
  if(qty<1){removeCart(id);return;}
  const r=await fetch('{{ route("cart.update") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':window.csrfToken},body:JSON.stringify({cart_id:id,quantity:qty})});
  if((await r.json()).success) location.reload();
}
async function removeCart(id) {
  const r=await fetch('{{ route("cart.remove") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':window.csrfToken},body:JSON.stringify({cart_id:id})});
  if((await r.json()).success){document.getElementById('ci-'+id).remove();showToast('Produk dihapus.');}
}
</script>
@endpush
@endsection
