@extends('layouts.app_admin')

@section('content')
    <style>
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

        .overview-search {
            flex: 1 1 300px;
            max-width: 350px;
        }

        .overview-search input {
            width: 100%;
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #d1bfa3;
            font-size: 1rem;
            background: #fff;
        }

        .overview-search button:hover svg circle,
        .overview-search button:hover svg path {
            stroke: #b36b2c;
        }

        .overview-stats {
            display: flex;
            gap: 18px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(136, 79, 34, 0.08);
            padding: 18px 28px;
            min-width: 180px;
            text-align: center;
            flex: 1 1 180px;
        }

        .stat-label {
            font-size: 1rem;
            color: #884F22;
            margin-bottom: 6px;
        }

        .stat-label.active {
            font-weight: bold;
            color: #b36b2c;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #65141d;
        }

        .order-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 22px;
        }

        .order-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(136, 79, 34, 0.08);
            padding: 22px 18px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            position: relative;
            transition: box-shadow 0.15s;
        }

        .order-card:hover {
            box-shadow: 0 4px 18px rgba(136, 79, 34, 0.16);
        }

        .product-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #eee;
            background: #f3e5d7;
        }

        .order-info {
            flex: 1;
        }

        .order-info h2 {
            font-size: 1.1rem;
            color: #884F22;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .order-info p {
            font-size: 0.97rem;
            color: #333;
            margin-bottom: 3px;
        }

        .order-status {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 8px;
            font-size: 0.93rem;
            font-weight: 600;
            margin-top: 8px;
        }

        .status-processed {
            background: #b6e6c3;
            color: #1b7f3a;
        }

        .status-shipped {
            background: #b3d8f7;
            color: #1a5e8a;
        }

        .status-completed {
            background: #e2e2e2;
            color: #555;
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

    <div class="order-overview-container">
        <div class="overview-header">
            <div class="overview-title">Order Overview</div>
            <div class="overview-search">
                <form method="GET" action="{{ route('admin.orders') }}"
                    style="display: flex; align-items: center; gap: 6px;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari order, customer, atau ID...">
                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke="#884F22" stroke-width="2" />
                            <path d="M20 20L16.65 16.65" stroke="#884F22" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="overview-stats">
            <div class="stat-card">
                <a href="{{ route('admin.orders', ['status' => null]) }}"
                    class="stat-label {{ request('status') === null ? 'active' : '' }}"
                    style="cursor:pointer; text-decoration:underline; color:inherit;">
                    Total Orders
                </a>
                <div class="stat-value">{{ $totalOrders }}</div>
            </div>
            <div class="stat-card">
                <a href="{{ route('admin.orders', ['status' => 'waiting_payment']) }}"
                    class="stat-label {{ request('status') === 'waiting_payment' ? 'active' : '' }}"
                    style="cursor:pointer; text-decoration:underline; color:inherit;">
                    Waiting Payment
                </a>
                <div class="stat-value">{{ $waitingPayment }}</div>
            </div>

            <div class="stat-card">
                <a href="{{ route('admin.orders', ['status' => 'processed']) }}"
                    class="stat-label {{ request('status') === 'processed' ? 'active' : '' }}"
                    style="cursor:pointer; text-decoration:underline; color:inherit;">
                    Processed
                </a>
                <div class="stat-value">{{ $processed }}</div>
            </div>
            <div class="stat-card">
                <a href="{{ route('admin.orders', ['status' => 'shipped']) }}"
                    class="stat-label {{ request('status') === 'shipped' ? 'active' : '' }}"
                    style="cursor:pointer; text-decoration:underline; color:inherit;">
                    Shipped
                </a>
                <div class="stat-value">{{ $shipped }}</div>
            </div>
            <div class="stat-card">
                <a href="{{ route('admin.orders', ['status' => 'completed']) }}"
                    class="stat-label {{ request('status') === 'completed' ? 'active' : '' }}"
                    style="cursor:pointer; text-decoration:underline; color:inherit;">
                    Completed
                </a>
                <div class="stat-value">{{ $completed }}</div>
            </div>
        </div>
        <div class="order-list">
            @forelse($orders as $order)
                <div class="order-card">
                    <img src="{{ $order->product && $order->product->image ? asset('storage/' . $order->product->image) : asset('images/sample-product.jpg') }}"
                        alt="Product" class="product-thumb">
                    <div class="order-info">
                        <h2>Order #{{ $order->id }}</h2>
                        <p><b>Customer:</b> {{ $order->user->name ?? '-' }}</p>
                        <p><b>Date:</b> {{ $order->created_at->format('Y-m-d') }}</p>
                        <p><b>Total:</b> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        <span class="order-status status-{{ $order->status }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                        <div style="margin-top:10px;">
                            @if($order->status == 'paid')
                                <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-warning btn-sm">Processed (Packing)</button>
                                </form>
                            @elseif($order->status == 'processed')
                                <form action="{{ route('admin.orders.ship', $order) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-primary btn-sm">Shipping</button>
                                </form>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-success">Menunggu User Complete</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align:center; color:#884F22; font-size:1.1rem;">
                    Belum ada order.
                </div>
            @endforelse
        </div>
    </div>
    @include('layouts.footer')
@endsection