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
            background-color: #0d6efd;
            color: white;
        }

        .status-shipped {
            background-color: #20c997;
            color: white;
        }

        .status-completed {
            background-color: #6c757d;
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
    <div class="order-container">
        <div class="order-overview-container">
            <div class="overview-header">
                <div class="overview-title">Pesanan Masuk</div>
                <div class="overview-search">
                    <form method="GET" action="{{ route('admin.orders') }}">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari disini...">
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
                        Total Pesanan
                    </span>
                    <span class="stat-value">{{ $totalOrders }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'waiting_payment']) }}"
                    class="stat-card {{ request('status') === 'waiting_payment' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'waiting_payment' ? 'active' : '' }}">
                        Menunggu Pembayaran
                    </span>
                    <span class="stat-value">{{ $waitingPayment }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'paid']) }}"
                    class="stat-card {{ request('status') === 'paid' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'paid' ? 'active' : '' }}">
                        Konfirmasi
                    </span>
                    <span class="stat-value">{{ $paid }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'processed']) }}"
                    class="stat-card {{ request('status') === 'processed' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'processed' ? 'active' : '' }}">
                        Diproses
                    </span>
                    <span class="stat-value">{{ $processed }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'shipped']) }}"
                    class="stat-card {{ request('status') === 'shipped' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'shipped' ? 'active' : '' }}">
                        Dikirim
                    </span>
                    <span class="stat-value">{{ $shipped }}</span>
                </a>
                <a href="{{ route('admin.orders', ['status' => 'completed']) }}"
                    class="stat-card {{ request('status') === 'completed' ? 'active' : '' }}">
                    <span class="stat-label {{ request('status') === 'completed' ? 'active' : '' }}">
                        Selesai
                    </span>
                    <span class="stat-value">{{ $completed }}</span>
                </a>
            </div>
            <div class="order-list">
                @forelse($orders as $order)
                        <div class="order-card">
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
                                <h2>Pesanan #{{ $order->id }}</h2>
                                <p><b>Pelanggan:</b> {{ $order->user->name ?? '-' }}</p>
                                <p><b>Tanggal:</b> {{ $order->created_at->format('Y-m-d') }}</p>
                                <p><b>Total:</b> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                <div style="margin: 8px 0 12px 0;">
                                    <b>Status:</b>
                                    <span class="order-status status-{{ $order->status }}">
                                        {{ $order->status === 'waiting_payment' ? 'Menunggu Pembayaran' :
                    ($order->status === 'paid' ? 'Dibayar' :
                        ($order->status === 'processed' ? 'Diproses' :
                            ($order->status === 'shipped' ? 'Dikirim' :
                                ($order->status === 'completed' ? 'Selesai' : ucfirst(str_replace('_', ' ', $order->status)))
                            ))) }}
                                    </span>
                                </div>
                                <div style="margin-top:12px;">
                                    <b>Detail Produk:</b>
                                    @if(isset($order->checkout_data) && count($order->checkout_data) > 0)
                                        <ul style="margin: 8px 0 0 0; padding-left: 18px;">
                                            @foreach($order->checkout_data as $item)
                                                <li>
                                                    {{ $item['product_name'] }}
                                                    @if(!empty($item['color'])) - <span style="color:#b36b2c;">Warna:
                                                    {{ $item['color'] }}</span>@endif
                                                    @if(!empty($item['size'])) - <span style="color:#b36b2c;">Ukuran:
                                                    {{ $item['size'] }}</span>@endif
                                                    - <span style="color:#884F22;">Jumlah: {{ $item['quantity'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <ul style="margin: 8px 0 0 0; padding-left: 18px;">
                                            <li>
                                                {{ $order->product->name ?? '-' }}
                                                @if(!empty($order->color)) - <span style="color:#b36b2c;">Warna:
                                                {{ $order->color }}</span>@endif
                                                @if(!empty($order->size)) - <span style="color:#b36b2c;">Ukuran:
                                                {{ $order->size }}</span>@endif
                                                - <span style="color:#884F22;">Kuantitas: {{ $order->quantity ?? 1 }}</span>
                                            </li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="order-actions">
                                    @if($order->status == 'paid')
                                        <form action="{{ route('admin.orders.confirm', $order) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn btn-warning btn-sm">Proses (Dikemas)</button>
                                        </form>
                                    @elseif($order->status == 'processed')
                                        <form action="{{ route('admin.orders.ship', $order) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-primary btn-sm">Kirim</button>
                                        </form>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-success">Menunggu Konfirmasi Selesai</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-secondary">Pesanan Selesai</span>
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