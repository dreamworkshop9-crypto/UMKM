@extends('layouts.app')
@section('title','Detail Pesanan - SALZA')
@section('content')
<div class="container" style="padding:30px 20px 60px;max-width:860px">
  <a href="{{ route('order.index') }}" class="back-link"><i class="fa fa-arrow-left"></i> Kembali</a>
  <h2 class="page-title">Detail Pesanan</h2>
  <div class="order-detail-card">
    <div class="order-header">
      <div>
        <div class="order-invoice">{{ $order->invoice }}</div>
        <div class="order-date">{{ $order->created_at->format('d F Y, H:i') }}</div>
      </div>
      <span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span>
    </div>
    <div class="order-items-list">
      @foreach($order->items as $item)
      <div class="order-item-row">
        <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}"/>
        <div class="order-item-info">
          <h4>{{ $item->product->name }}</h4>
          @if($item->size)<span class="item-meta">Ukuran: {{ $item->size }}</span>@endif
          <div>{{ $item->quantity }} × Rp{{ number_format($item->price,0,',','.') }}</div>
        </div>
        <div class="order-item-sub">Rp{{ number_format($item->subtotal,0,',','.') }}</div>
      </div>
      @endforeach
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin:20px 0">
      <div class="order-address">
        <h4>Alamat Pengiriman</h4>
        <p><strong>{{ $order->name }}</strong> | {{ $order->phone }}</p>
        <p>{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</p>
      </div>
      <div>
        <h4>Pembayaran</h4>
        <p>{{ strtoupper($order->payment_method) }}</p>
      </div>
    </div>
    <div class="order-total-row"><span>Total Pesanan</span><strong>{{ $order->total_formatted }}</strong></div>
  </div>
</div>
@endsection
