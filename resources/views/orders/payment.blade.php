@extends('layouts.app_order_users')
@section('content')
    <div class="container">
        <h2>Pembayaran Order #{{ $order->id }}</h2>
        <p>Produk: <b>{{ $order->product->name }}</b></p>
        <p>Total: <b>Rp{{ number_format($order->total, 0, ',', '.') }}</b></p>
        <p>Shipping Method: <b>{{ $order->shipping_method ?? 'N/A' }}</b></p>
        <p>Payment Method: <b>{{ $order->payment_method ?? 'N/A' }}</b></p>
        <form action="{{ route('order.pay', $order) }}" method="POST">
            @csrf
            <button class="btn btn-success">Bayar Sekarang (Simulasi)</button>
        </form>
    </div>
@endsection