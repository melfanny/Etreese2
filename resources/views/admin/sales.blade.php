@extends('layouts.app_admin')

@section('content')
    <style>
        .sales-container {
            background-color: #EBC4AE;
        }

        .dashboard-container {
            padding: 32px 32px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            padding: 30px 28px 26px 28px;
        }

        .dashboard-header h2 {
            font-size: 2.1rem;
            font-weight: bold;
            color: #884F22;
            letter-spacing: 1px;
        }

        .filter-group {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 7px 18px;
            border-radius: 8px;
            border: 1.5px solid #d1bfa3;
            background: #fff7f0;
            color: #884F22;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.18s, color 0.18s, border 0.18s;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: #ffe3c2;
            color: #b36b2c;
            border-color: #b36b2c;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            width: 100%;
        }

        .product-card {
            background: linear-gradient(120deg, #fff7f0 60%, #f3e5d7 100%);
            border-radius: 16px;
            box-shadow: 0 3px 12px rgba(136, 79, 34, 0.08), 0 1px 3px #e5c7b0;
            overflow: hidden;
            text-align: left;
            transition: box-shadow 0.18s, transform 0.18s;
            border: 1px solid #e5c7b0;
            padding: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 0;
            max-width: 100%;
            align-items: center;
        }

        .product-card:hover {
            box-shadow: 0 6px 20px rgba(136, 79, 34, 0.12), 0 2px 6px #e5c7b0;
            transform: translateY(-2px) scale(1.01);
        }

        .img-wrapper {
            width: 100%;
            max-width: 160px;
            aspect-ratio: 1/1;
            background: #f3e5d7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            padding: 8px;
        }

        .product-card h3 {
            font-size: 1.1rem;
            color: #884F22;
            margin: 12px 0 4px 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .product-card .period-stats {
            display: flex;
            gap: 8px;
            margin-bottom: 6px;
        }

        .period-box {
            background: #fff;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.9rem;
            color: #b36b2c;
            font-weight: 600;
            border: 1px solid #e5c7b0;
            box-shadow: 0 1px 4px #f3e5d7;
        }

        .product-card .price {
            color: #b36b2c;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .product-card .qty {
            color: #1b7f3a;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0;
        }

        .product-details {
            margin-top: 8px;
            background: #fff7f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        .product-details ul {
            margin: 0;
            padding-left: 16px;
        }

        .product-details li {
            margin-bottom: 2px;
        }

        .stat-label {
            color: #884F22;
            font-weight: 600;
            margin-right: 4px;
        }

        .stat-value {
            color: #b36b2c;
            font-weight: bold;
        }

        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .img-wrapper {
                max-width: 100%;
            }
        }
    </style>
    <div class="sales-container">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h2>Rekap Penjualan</h2>
            </div>
            <div class="product-grid">
                @foreach($salesData as $product)
                    <div class="product-card">
                        <div class="img-wrapper">
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}">
                        </div>
                        <h3>{{ $product['name'] }}</h3>
                        <div class="period-box" style="margin-bottom:8px;">
                            <span class="stat-label">Total Pembelian:</span>
                            <span class="stat-value">{{ $product['total_sales'] }} produk</span>
                        </div>
                        <div class="price">Pemasukan: Rp{{ number_format($product['total_income'], 0, ',', '.') }}</div>
                        <div class="product-details">
                            <b>Detail:</b>
                            <ul style="list-style: none; padding-left: 0; margin-top: 8px;">
                                @foreach($product['variant_details'] as $variant)
                                    @if($variant === '')
                                        <li style="margin: 4px 0;"></li>
                                    @elseif(strpos($variant, '<b>') === 0)
                                        <li style="margin: 8px 0 4px 0; color: #884F22;">{!! $variant !!}</li>
                                    @else
                                        <li style="margin: 2px 0; color: #b36b2c;">{!! $variant !!}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection