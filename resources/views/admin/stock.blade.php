@extends('layouts.app_admin')
@section('content')
    <style>
        .dashboard-container {
            padding: 50px 10%;
            font-family: 'Cormorant Garamond', serif;
            background-color: #e5c7b0;
        }

        .dashboard-header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #884F22;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            width: 100%;
            justify-items: stretch;
        }

        .product-card {
            width: 100%;
            max-width: 100%;
            background: linear-gradient(120deg, #fff7f0 60%, #f3e5d7 100%);
            border-radius: 14px;
            overflow: hidden;
            text-align: left;
            box-shadow: 0 2px 8px #e5c7b0;
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            border: 1.5px solid #e5c7b0;
            padding-bottom: 18px;
        }

        @media (max-width: 900px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }

        .img-wrapper {
            width: 100%;
            background: #f3e5d7;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px 14px 0 0;
            overflow: hidden;
            height: 220px;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f3e5d7;
        }

        .product-name {
            color: #884F22;
            padding: 16px 18px 6px 18px;
            font-weight: bold;
            font-size: 1.15rem;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .variant-section {
            padding: 0 18px 0 18px;
            margin-bottom: 10px;
        }

        .variant-title {
            font-size: 1rem;
            font-weight: 600;
            color: #b36b2c;
            margin: 14px 0 6px 0;
            letter-spacing: 0.5px;
        }

        .variant-info-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 8px;
        }

        .variant-info-item {
            background: #fff7f0;
            color: #884F22;
            border-radius: 6px;
            padding: 4px 12px;
            font-size: 0.98rem;
            box-shadow: 0 1px 4px #f3e5d7;
        }

        .stock-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px #f3e5d7;
            padding: 12px 16px;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .stock-info {
            color: #1b7f3a;
            font-weight: 600;
            margin-right: 8px;
        }

        .limit-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .limit-btn {
            background: #fff7f0;
            border: 1.5px solid #e0c3a0;
            color: #b36b2c;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.15s, border 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            user-select: none;
        }

        .limit-btn:hover {
            background: #ffe3c2;
            border-color: #b36b2c;
        }

        .limit-input {
            width: 48px;
            text-align: center;
            border: 1.5px solid #e0c3a0;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #884F22;
            background: #fff;
            padding: 2px 4px;
            margin: 0 2px;
            transition: border 0.18s;
            appearance: textfield;
        }

        .limit-input::-webkit-inner-spin-button,
        .limit-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .reset-btn {
            background: #fff7f0;
            border: 1.5px solid #e0c3a0;
            color: #b36b2c;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.5rem 1.1rem;
            margin-left: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.15s, border 0.15s, color 0.15s;
        }

        .reset-btn:hover {
            background: #ffe3c2;
            border-color: #b36b2c;
            color: #884F22;
        }

        .save-btn {
            background: linear-gradient(135deg, #b36b2c, #884F22);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.7rem 1.7rem;
            margin: 18px auto 0 auto;
            box-shadow: 0 4px 12px #e5c7b0;
            letter-spacing: 0.5px;
            transition: all 0.18s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .save-btn:hover {
            background: linear-gradient(135deg, #884F22, #b36b2c);
            box-shadow: 0 6px 16px #b36b2c;
        }

        .alert-warning {
            background: #fff7ed;
            border: 1.5px solid #e0c3a0;
            border-radius: 10px;
            color: #b36b2c;
            box-shadow: 0 2px 8px #f3e5d0;
            padding: 1rem 1.2rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            text-align: left;
        }

        .stock-alert {
            background: #fff7ed;
            border: 1.5px solid #e0c3a0;
            border-radius: 8px;
            color: #b36b2c;
            padding: 0.5rem 0.8rem;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-alert.warning {
            background: #fff7ed;
            border-color: #e0c3a0;
            color: #b36b2c;
        }

        .stock-alert.danger {
            background: #fff5f5;
            border-color: #feb2b2;
            color: #c53030;
        }

        .stock-alert i {
            font-size: 1rem;
        }

        @media (max-width: 900px) {
            .product-grid {
                flex-direction: column;
                gap: 20px;
            }

            .product-card {
                width: 100%;
            }

            .img-wrapper {
                height: 140px;
            }
        }

        @media (max-width: 600px) {
            .dashboard-container {
                padding: 1rem;
            }

            .product-card {
                padding: 1.2rem 0.3rem;
            }

            .img-wrapper {
                height: 100px;
            }
        }
    </style>

    <script>
        function stepLimit(id, step) {
            const input = document.getElementById(id);
            if (!input) return;
            let value = parseInt(input.value) || 0;
            value += step;
            if (value < 0) value = 0;
            input.value = value;
        }
        function resetLimit(id) {
            const input = document.getElementById(id);
            if (!input) return;
            input.value = input.getAttribute('data-default');
        }
    </script>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Kelola Limit Stok</h2>
        </div>
        @if($stockLimitAlerts->isNotEmpty())
            <div class="alert-warning">
                <strong>Perhatian!</strong> Beberapa produk memiliki stok yang mendekati atau di bawah batas:
                <ul>
                    @foreach($stockLimitAlerts as $alert)
                        <li>
                            {{ $alert->product_name }} ({{ $alert->color_name }} - {{ $alert->size_name }}):
                            Stok {{ $alert->stock }} dari batas {{ $alert->stock_limit }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="product-grid">
            @foreach($products as $product)
                    @php
                        $stock = $product->stocks->first();
                        $currentStock = $stock ? $stock->quantity : 0;
                        $stockLimit = $stock ? $stock->stock_limit : ($product->stock_limit ?? 0);
                        $inputId = 'limit-' . $product->id;
                    @endphp
                    <form action="{{ route('admin.update.stock.limit', [
                    'productId' => $product->id,
                    'colorId' => 0,
                    'sizeId' => 0,
                ]) }}" method="POST" class="product-card" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="img-wrapper">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/500x450?text=No+Image" alt="No Image">
                            @endif
                        </div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="variant-section">
                            <div class="variant-title">Warna</div>
                            <div class="variant-info-list">
                                @php
                                    $productColors = $product->colors->isNotEmpty() ? $product->colors : collect(['-']);
                                @endphp
                                @foreach($productColors as $color)
                                    <div class="variant-info-item">
                                        {{ is_object($color) ? $color->name : $color }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="variant-title">Ukuran</div>
                            <div class="variant-info-list">
                                @php
                                    $productSizes = $product->sizes->isNotEmpty() ? $product->sizes : collect(['-']);
                                @endphp
                                @foreach($productSizes as $size)
                                    <div class="variant-info-item">
                                        {{ is_object($size) ? $size->name : $size }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @foreach($productSizes as $size)
                            @php
                                $sizeId = is_object($size) ? $size->id : 0;
                                $sizeName = is_object($size) ? $size->name : '-';
                                $stock = $product->stocks->where('size_id', $sizeId)->first();
                                $currentStock = $stock ? $stock->quantity : 0;
                                $stockLimit = $stock ? $stock->stock_limit : ($product->stock_limit ?? 0);
                                $inputId = 'limit-' . $product->id . '-' . $sizeId;
                                $isLowStock = $stockLimit > 0 && $currentStock <= $stockLimit;
                                $alertClass = $currentStock == 0 ? 'danger' : 'warning';
                            @endphp
                            <div class="stock-row">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <span class="stock-info">{{ $sizeName }} Stock: <b>{{ $currentStock }}</b></span>
                                    @if($isLowStock)
                                        <div class="stock-alert {{ $alertClass }}">
                                            <i
                                                class="fas {{ $currentStock == 0 ? 'fa-exclamation-circle' : 'fa-exclamation-triangle' }}"></i>
                                            {{ $currentStock == 0 ? 'Stok Habis!' : 'Stok Mendekati Batas!' }}
                                        </div>
                                    @endif
                                </div>
                                <div class="limit-group">
                                    <button type="button" class="limit-btn" onclick="stepLimit('{{ $inputId }}', -1)">&#8722;</button>
                                    <input type="text" name="stock_limit[{{ $sizeId }}]" id="{{ $inputId }}" class="limit-input"
                                        value="{{ $stockLimit }}" min="0" data-default="{{ $stockLimit }}" readonly>
                                    <button type="button" class="limit-btn" onclick="stepLimit('{{ $inputId }}', 1)">&#43;</button>
                                    <button type="button" class="reset-btn" onclick="resetLimit('{{ $inputId }}')">
                                        <i class="fas fa-sync-alt"></i> Reset
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="save-btn">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
            @endforeach
        </div>
    </div>
    @include('layouts.footer')
@endsection