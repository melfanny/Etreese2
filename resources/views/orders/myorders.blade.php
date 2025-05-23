@extends('layouts.app_order_users')
@section('content')
    <div class="container">
        <h2>Pesanan Saya</h2>
        @forelse($orders as $order)
            <div class="card mb-3" style="@if($order->status == 'waiting_payment') border:2px solid orange; @endif">
                <div class="card-body">
                    <b>Produk:</b> {{ $order->product->name }}<br>
                    <b>Total:</b> Rp{{ number_format($order->total, 0, ',', '.') }}<br>
                    <b>Status:</b>
                    @if($order->status == 'waiting_payment')
                        <span class="badge bg-warning">Belum Dibayar</span>
                        <form action="{{ route('order.payment', $order) }}" method="GET" style="display:inline;">
                            <button class="btn btn-primary btn-sm">Bayar Sekarang</button>
                        </form>
                    @elseif($order->status == 'paid')
                        <span class="badge bg-info">Sudah Dibayar</span>
                    @elseif($order->status == 'processed')
                        <span class="badge bg-primary">Diproses</span>
                    @elseif($order->status == 'shipped')
                        <span class="badge bg-success">Dikirim</span>
                        <form action="{{ route('order.complete', $order) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-success btn-sm">Pesanan Diterima</button>
                        </form>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-secondary">Selesai</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-warning">Belum ada pesanan.</div>
        @endforelse
    </div>
@endsection