@extends('layouts.app')
@section('title','Pesanan Saya - SALZA')
@section('content')
<div class="container" style="padding:30px 20px 60px">
  <h2 class="page-title">Pesanan Saya</h2>
  @if($orders->count())
  <div class="orders-table-wrap">
    <table class="orders-table">
      <thead><tr><th>Invoice</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($orders as $o)
        <tr>
          <td><strong>{{ $o->invoice }}</strong></td>
          <td>{{ $o->created_at->format('d M Y') }}</td>
          <td>{{ $o->total_formatted }}</td>
          <td>{{ strtoupper($o->payment_method) }}</td>
          <td><span class="status-badge status-{{ $o->status }}">{{ $o->status_label }}</span></td>
          <td><a href="{{ route('order.show',$o->invoice) }}" class="btn-sm"><i class="fa fa-eye"></i> Detail</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination-wrap">{{ $orders->links() }}</div>
  </div>
  @else
  <div class="empty-state"><i class="fa fa-box fa-4x"></i><h3>Belum Ada Pesanan</h3><p>Ayo belanja sepatu impianmu!</p><a href="{{ route('shop') }}" class="btn-primary">Mulai Belanja</a></div>
  @endif
</div>
@endsection
