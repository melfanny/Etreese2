@extends('layouts.app_order_users')
<style>
    .order-container {
        background-color: #d2997a;
    }

    .order-overview-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 16px 24px 16px;
    }

    .overview-header {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .overview-title {
        font-size: 2.2rem;
        font-weight: bold;
        color: #884F22;
    }

    .overview-search form {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .overview-search input {
        width: 100%;
        padding: 10px 16px;
        border-right: none;
        border-radius: 8px 0 0 8px;
        font-size: 1rem;
        background: #fff;
        outline: none;
        height: 42px;
    }

    .search-btn {
        background: #fff;
        border: 1px solid #d1bfa3;
        border-left: none;
        border-radius: 0 8px 8px 0;
        padding: 0 16px;
        display: flex;
        align-items: center;
        transition: border-color 0.2s, box-shadow 0.2s;
        cursor: pointer;
        height: 42px;
    }

    .search-btn:hover,
    .search-btn:focus {
        border-color: #b36b2c;
        box-shadow: 0 0 0 2px #f3e5d7;
        background: #f9f6f2;
    }

    .overview-stats {
        display: flex;
        gap: 22px;
        margin-bottom: 32px;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .stat-card {
        background: linear-gradient(135deg, #fff7f0 60%, #f3e5d7 100%);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(136, 79, 34, 0.10), 0 1.5px 4px #e5c7b0;
        padding: 22px 32px 18px 32px;
        min-width: 180px;
        text-align: center;
        flex: 1 1 180px;
        transition: transform 0.18s, box-shadow 0.18s, background 0.18s;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .stat-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 28px rgba(136, 79, 34, 0.18), 0 2px 8px #e5c7b0;
        background: linear-gradient(135deg, #f3e5d7 60%, #fff7f0 100%);
        color: #884F22;
    }

    .stat-card.active {
        background: linear-gradient(135deg, #ffe3c2 60%, #e9c7a0 100%);
        color: #884F22;
    }

    .stat-label,
    .stat-value {
        font-size: 1.08rem;
        color: #884F22;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: block;
        transition: color 0.18s;
    }

    .stat-label {
        margin-bottom: 8px;
    }

    .stat-value {
        margin-bottom: 0;
        margin-top: 0;
    }

    .stat-card.active .stat-label,
    .stat-card.active .stat-value {
        color: #b36b2c !important;
        text-shadow: 0 2px 8px #fff7f0;
    }

    @media (max-width: 900px) {
        .overview-stats {
            gap: 12px;
        }

        .stat-card {
            padding: 18px 12px;
            min-width: 140px;
        }

        .stat-value {
            font-size: 1.3rem;
        }
    }

    .order-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 20px;
        max-width: 900px;
        margin: 0 auto;
    }

    .order-card {
        display: flex;
        background-color: #FFFBEF;
        padding: 20px;
        border-radius: 10px;
        align-items: flex-start;
        gap: 20px;
        width: 100%;
        box-sizing: border-box;
    }


    .product-thumb {
        width: 150px;
        height: auto;
        border-radius: 10px;
        background-color: white;
        padding: 10px;
    }

    .product-thumb.scrollable {
        overflow-y: auto;
        max-height: 300px;
    }

    .order-info {
        flex: 1;
        font-family: 'Poppins', sans-serif;
    }

    .order-info h2 {
        margin-top: 0;
    }

    .order-info p {
        font-size: 1rem;
        color: #6d4c2c;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .order-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 10px;
    }

    .status-waiting_payment {
        background: #ffe3c2;
        color: #b36b2c;
    }

    .status-paid {
        background-color: #ffc107;
        color: #000;
    }

    .status-processed {
        background-color: rgb(88, 155, 255);
        color: white;
    }

    .status-shipped {
        background-color: rgb(85, 199, 165);
        color: white;
    }

    .status-completed {
        background-color: rgb(192, 154, 92);
        color: white;
    }

    .order-actions {
        margin-top: 15px;
    }

    .order-actions .btn {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .order-actions .btn-warning {
        background: #ffe3c2;
        color: #b36b2c;
        border: 1px solid #b36b2c;
    }

    .order-actions .btn-warning:hover {
        background: #b36b2c;
        color: #fff;
    }

    .order-actions .btn-primary {
        background: #b3d8f7;
        color: #1a5e8a;
        border: 1px solid #1a5e8a;
    }

    .order-actions .btn-primary:hover {
        background: #1a5e8a;
        color: #fff;
    }

    .order-actions .badge {
        font-size: 0.97rem;
        padding: 6px 14px;
        border-radius: 7px;
        background: #e2e2e2;
        color: #555;
        font-weight: 600;
    }

    @media (max-width: 700px) {
        .overview-header {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
        }

        .overview-title {
            font-size: 1.5rem;
        }

        .overview-stats {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

@section('content')
    <div class="order-container">
        <div class="order-overview-container">
            <h2 class="overview-title">Pesanan Saya</h2>
            <div class="overview-stats">
                <a href="{{ route('order.myorders', ['status' => 'waiting_payment']) }}"
                    class="stat-card {{ $status === 'waiting_payment' ? 'active' : '' }}">
                    <span class="stat-label">Waiting Payment</span>
                </a>
                <a href="{{ route('order.myorders', ['status' => 'paid']) }}"
                    class="stat-card {{ $status === 'paid' ? 'active' : '' }}">
                    <span class="stat-label">Paid</span>
                </a>
                <a href="{{ route('order.myorders', ['status' => 'processed']) }}"
                    class="stat-card {{ $status === 'processed' ? 'active' : '' }}">
                    <span class="stat-label">Processed</span>
                </a>
                <a href="{{ route('order.myorders', ['status' => 'shipped']) }}"
                    class="stat-card {{ $status === 'shipped' ? 'active' : '' }}">
                    <span class="stat-label">Shipped</span>
                </a>
                <a href="{{ route('order.myorders', ['status' => 'completed']) }}"
                    class="stat-card {{ $status === 'completed' ? 'active' : '' }}">
                    <span class="stat-label">Completed</span>
                </a>
            </div>

            <div class="order-list">
                @forelse($orders as $order)
                    <div class="order-card {{ $order->status == 'waiting_payment' ? 'highlight-border' : '' }}">
                        @if(isset($order->checkout_data) && count($order->checkout_data) > 0)
                            <div class="product-thumb scrollable">
                                @foreach($order->checkout_data as $item)
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['product_name'] }}"
                                        class="product-thumb" style="margin-bottom: 10px;">
                                @endforeach
                            </div>
                        @else
                            <img src="{{ $order->product && $order->product->image ? asset('storage/' . $order->product->image) : asset('images/sample-product.jpg') }}"
                                class="product-thumb">
                        @endif

                        <div class="order-info">
                            @if(isset($order->checkout_data) && count($order->checkout_data) > 0)
                                <h2>Products:</h2>
                                <ul>
                                    @foreach($order->checkout_data as $item)
                                        <li>{{ $item['product_name'] }} - Qty: {{ $item['quantity'] }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <h2>{{ $order->product->name }}</h2>
                            @endif
                            <p><strong>Total:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong>
                                @if($order->status == 'waiting_payment')
                                    <span class="order-status status-waiting_payment">Belum Dibayar</span>
                                @elseif($order->status == 'paid')
                                    <span class="order-status status-processed">Sudah dibayar</span>
                                @elseif($order->status == 'processed')
                                    <span class="order-status status-processed">Diproses</span>
                                @elseif($order->status == 'shipped')
                                    <span class="order-status status-shipped">Dikirim</span>
                                @elseif($order->status == 'completed')
                                    <span class="order-status status-completed">Selesai</span>
                                @endif
                            </p>

                            <div class="order-actions">
                                @if($order->status == 'waiting_payment')
                                    <form action="{{ route('order.payment', $order) }}" method="GET" style="display:inline;">
                                        <button class="btn btn-warning">Bayar Sekarang</button>
                                    </form>
                                @elseif($order->status == 'shipped')
                                    <form action="{{ route('order.complete', $order) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-primary">Pesanan Diterima</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">Belum ada pesanan.</div>
                @endforelse
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection