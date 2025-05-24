@extends('layouts.app_admin')

@section('content')
    <style>
        .order-container {
            background-color: #EBC4AE;
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
            border: 1px solid #d1bfa3;
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
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 22px;
            margin-top: 18px;
        }

        .order-card {
            background: linear-gradient(120deg, #fff7f0 60%, #f3e5d7 100%);
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(136, 79, 34, 0.10), 0 1.5px 4px #e5c7b0;
            padding: 26px 22px 20px 22px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            position: relative;
            transition: box-shadow 0.18s, transform 0.18s;
            border: 1.5px solid #e5c7b0;
        }

        .order-card:hover {
            box-shadow: 0 8px 28px rgba(136, 79, 34, 0.18), 0 2px 8px #e5c7b0;
            transform: translateY(-4px) scale(1.02);
            border-color: #b36b2c;
        }

        .product-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
            border: 2px solid #e5c7b0;
            background: #f3e5d7;
            box-shadow: 0 2px 8px #f3e5d7;
        }

        .order-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .order-info h2 {
            font-size: 1.15rem;
            color: #884F22;
            margin-bottom: 8px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .order-info p {
            font-size: 1rem;
            color: #6d4c2c;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .order-status {
            display: inline-block;
            padding: 5px 16px;
            border-radius: 10px;
            font-size: 0.98rem;
            font-weight: 600;
            margin-top: 10px;
            background: #f3e5d7;
            color: #884F22;
            letter-spacing: 0.5px;
            box-shadow: 0 1px 4px #e5c7b0;
        }

        .status-waiting_payment {
            background: #ffe3c2;
            color: #b36b2c;
        }

        .status-paid {
            background: #fff0c2;
            color: #b36b2c;
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

        .order-actions {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .order-actions .btn {
            border-radius: 7px;
            font-size: 0.97rem;
            font-weight: 600;
            padding: 6px 16px;
            border: none;
            transition: background 0.15s, color 0.15s;
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
    <div class="order-container">
        <div class="order-overview-container">
            <div class="overview-header">
                <div class="overview-title">Order Overview</div>
                <div class="overview-search">
                    <form method="GET" action="{{ route('admin.orders') }}">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari order, customer, atau ID...">
                        <button type="submit" class="search-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" stroke="#884F22" stroke-width="2" />
                                <path d="M20 20L16.65 16.65" stroke="#884F22" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="overview-stats">
                <a href="{{ route('admin.orders', ['status' => null]) }}"
                    class="stat-card {{ request('status') === null ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === null ? 'active' : '' }}">
                        Total Orders
                    </span>
                    <span class="stat-value">{{ $totalOrders }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'waiting_payment']) }}"
                    class="stat-card {{ request('status') === 'waiting_payment' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'waiting_payment' ? 'active' : '' }}">
                        Waiting Payment
                    </span>
                    <span class="stat-value">{{ $waitingPayment }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'paid']) }}"
                    class="stat-card {{ request('status') === 'paid' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'paid' ? 'active' : '' }}">
                        Confirmation
                    </span>
                    <span class="stat-value">{{ $paid }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'processed']) }}"
                    class="stat-card {{ request('status') === 'processed' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'processed' ? 'active' : '' }}">
                        Processed
                    </span>
                    <span class="stat-value">{{ $processed }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'shipped']) }}"
                    class="stat-card {{ request('status') === 'shipped' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'shipped' ? 'active' : '' }}">
                        Shipped
                    </span>
                    <span class="stat-value">{{ $shipped }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'completed']) }}"
                    class="stat-card {{ request('status') === 'completed' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'completed' ? 'active' : '' }}">
                        Completed
                    </span>
                    <span class="stat-value">{{ $completed }}</span>
                </a>
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
                            <div class="order-actions">
                                @if($order->status == 'paid')
                                    <form action="{{ route('admin.orders.confirm', $order) }}" method="POST"
                                        style="display:inline;">
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
    </div>
    @include('layouts.footer')
@endsection