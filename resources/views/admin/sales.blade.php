@extends('layouts.app_admin')

@section('content')
    <style>
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
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 28px;
        }

        .product-card {
            background: linear-gradient(120deg, #fff7f0 60%, #f3e5d7 100%);
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(136, 79, 34, 0.10), 0 1.5px 4px #e5c7b0;
            overflow: hidden;
            text-align: left;
            transition: box-shadow 0.18s, transform 0.18s;
            border: 1.5px solid #e5c7b0;
            padding: 32px 28px 26px 28px;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: 0 8px 28px rgba(136, 79, 34, 0.18), 0 2px 8px #e5c7b0;
            transform: translateY(-4px) scale(1.02);
            border-color: #b36b2c;
        }

        .img-wrapper {
            width: 100%;
            aspect-ratio: 1/1;
            background: #f3e5d7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0 0 12px 12px;
        }

        .product-card h3 {
            font-size: 1.18rem;
            color: #884F22;
            margin: 18px 0 6px 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .product-card .period-stats {
            display: flex;
            gap: 12px;
            margin-bottom: 8px;
        }

        .period-box {
            background: #fff;
            border-radius: 7px;
            padding: 7px 13px;
            font-size: 0.97rem;
            color: #b36b2c;
            font-weight: 600;
            border: 1px solid #e5c7b0;
            box-shadow: 0 1px 4px #f3e5d7;
        }

        .product-card .price {
            color: #b36b2c;
            font-size: 1.08rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .product-card .qty {
            color: #1b7f3a;
            font-size: 1.01rem;
            font-weight: 500;
            margin-bottom: 0;
        }

        .product-details {
            margin-top: 10px;
            background: #fff7f0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.98rem;
        }

        .product-details ul {
            margin: 0;
            padding-left: 18px;
        }

        .product-details li {
            margin-bottom: 3px;
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

        @media (max-width: 700px) {
            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .dashboard-header h2 {
                font-size: 1.3rem;
            }
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Sales Dashboard</h2>
            <div class="filter-group">
                <button class="filter-btn active">Week</button>
                <button class="filter-btn">Month</button>
                <button class="filter-btn">Year</button>
            </div>
        </div>
        <div class="product-grid">
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80"
                        alt="Product A">
                </div>
                <h3>Product A</h3>
                <div class="period-stats">
                    <div class="period-box">
                        <span class="stat-label">Week:</span>
                        <span class="stat-value">12 sold</span>
                    </div>
                    <div class="period-box">
                        <span class="stat-label">Month:</span>
                        <span class="stat-value">44 sold</span>
                    </div>
                    <div class="period-box">
                        <span class="stat-label">Year:</span>
                        <span class="stat-value">210 sold</span>
                    </div>
                </div>
                <div class="price">Income: Rp1.440.000</div>
                <div class="qty">Total Sales: 44</div>
                <div class="product-details">
                    <b>Details:</b>
                    <ul>
                        <li>Red Variant: 20 pcs</li>
                        <li>Blue Variant: 14 pcs</li>
                        <li>Green Variant: 10 pcs</li>
                    </ul>
                </div>
            </div>
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80"
                        alt="Product B">
                </div>
                <h3>Product B</h3>
                <div class="period-stats">
                    <div class="period-box">
                        <span class="stat-label">Week:</span>
                        <span class="stat-value">7 sold</span>
                    </div>
                    <div class="period-box">
                        <span class="stat-label">Month:</span>
                        <span class="stat-value">21 sold</span>
                    </div>
                    <div class="period-box">
                        <span class="stat-label">Year:</span>
                        <span class="stat-value">110 sold</span>
                    </div>
                </div>
                <div class="price">Income: Rp623.000</div>
                <div class="qty">Total Sales: 21</div>
                <div class="product-details">
                    <b>Details:</b>
                    <ul>
                        <li>Small: 8 pcs</li>
                        <li>Medium: 7 pcs</li>
                        <li>Large: 6 pcs</li>
                    </ul>
                </div>
            </div>
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80"
                        alt="Product C">
                </div>
                <h3>Product C</h3>
                <div class="period-stats">
                    <div class="period-box">
                        <span class="stat-label">Week:</span>
                        <span class="stat-value">2 sold</span>
                    </div>
                    <div class="period-box">
                        <span class="stat-label">Month:</span>
                        <span class="stat-value">12 sold</span>
                    </div>
                    <div class="period-box">
                        <span class="stat-label">Year:</span>
                        <span class="stat-value">50 sold</span>
                    </div>
                </div>
                <div class="price">Income: Rp180.000</div>
                <div class="qty">Total Sales: 12</div>
                <div class="product-details">
                    <b>Details:</b>
                    <ul>
                        <li>Black: 5 pcs</li>
                        <li>White: 7 pcs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection