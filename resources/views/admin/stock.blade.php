@extends('layouts.app_admin')

@section('styles')
<style>
    body, html {
        background: #f9f6f2;
        font-family: 'Poppins', 'Montserrat', Arial, sans-serif;
        color: #5d4037;
        line-height: 1.6;
    }

    .stock-dashboard {
        min-height: 100vh;
        padding: 2.5rem 1rem;
        position: relative;
    }

    .products-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .product-card-centered {
        background: #fff7ed;
        border-radius: 22px;
        box-shadow: 0 6px 24px rgba(160, 120, 82, 0.10);
        padding: 2.5rem 2rem 2rem 2rem;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 2px solid #f3e5d0;
        position: relative;
    }

    .product-image-large {
        width: 220px;
        height: 220px;
        object-fit: cover;
        border-radius: 18px;
        margin-bottom: 1.2rem;
        box-shadow: 0 4px 16px rgba(160, 120, 82, 0.10);
        background: #f3e5d0;
        border: 2px solid #e0c3a0;
    }

    .product-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #7c4a03;
        margin-bottom: 0.7rem;
        text-align: center;
    }

    .variant-list-centered {
        width: 100%;
        margin: 1.2rem auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .row.align-items-center {
        width: 100%;
        margin: 0.5rem auto;
    }

    .variant-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .variant-label {
        font-size: 1rem;
        font-weight: 500;
        color: #a67c52;
        min-width: 70px;
    }

    .stock-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stock-btn {
        background: #a67c52;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, transform 0.1s;
        box-shadow: 0 2px 6px rgba(160, 120, 82, 0.10);
    }

    .stock-btn:hover {
        background: #7c4a03;
        transform: scale(1.08);
    }

    .stock-input {
        width: 50px;
        text-align: center;
        border: 1.5px solid #e0c3a0;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        color: #7c4a03;
        background: #fff7ed;
        padding: 0.2rem 0.1rem;
        margin: 0 0.1rem;
    }

    .save-btn-centered {
        background: linear-gradient(135deg, #a67c52, #8b5a2b);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0.9rem 2.2rem;
        margin: 2.5rem auto 0 auto;
        box-shadow: 0 4px 12px rgba(160, 120, 82, 0.15);
        letter-spacing: 0.5px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        cursor: pointer;
        width: auto;
        min-width: 140px;
    }

    .save-btn-centered:hover {
        background: linear-gradient(135deg, #8b5a2b, #6d4423);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(160, 120, 82, 0.2);
    }

    .save-btn-centered:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(160, 120, 82, 0.15);
    }

    .save-btn-centered i {
        font-size: 1rem;
        opacity: 0.9;
    }

    .alert.alert-warning {
        position: fixed;
        top: 1rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 100%;
        max-width: 420px;
        margin: 0 auto;
    }

    @media (max-width: 1200px) {
        .products-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .products-container {
            grid-template-columns: 1fr;
            max-width: 420px;
        }
    }

    @media (max-width: 600px) {
        .stock-dashboard {
            padding: 1rem;
        }
        
        .product-card-centered {
            padding: 1.2rem 0.5rem;
        }
        
        .alert.alert-warning {
            position: relative;
            margin-bottom: 1rem;
            top: 0;
        }
        
        .product-image-large {
            width: 100%;
            height: 180px;
        }
    }
</style>
@endsection

@section('content')
<div class="stock-dashboard">
    <div class="products-container">
        @foreach($products as $product)
            @php
                $lowStockItems = [];
                $productColors = $product->colors->isNotEmpty() ? $product->colors : collect([null]);
                $productSizes = $product->sizes->isNotEmpty() ? $product->sizes : collect([null]);
                
                foreach($productColors as $color) {
                    foreach($productSizes as $size) {
                        $stock = $product->stocks()
                            ->when($color, fn($q) => $q->where('color_id', $color->id))
                            ->when($size, fn($q) => $q->where('size_id', $size->id))
                            ->first();
                        
                        $currentStock = $stock ? $stock->quantity : 0;
                        $stockLimit = $stock ? $stock->stock_limit : ($product->stock_limit ?? 0);
                        
                        if($currentStock <= $stockLimit) {
                            $lowStockItems[] = [
                                'variant' => ($color ? $color->name : '') . ($size ? ' / ' . $size->name : ''),
                                'stock' => $currentStock,
                                'limit' => $stockLimit
                            ];
                        }
                    }
                }
            @endphp

            @if(count($lowStockItems))
                <div class="alert alert-warning" style="font-weight:600; color:#a67c52; max-width:420px; margin:0 auto 1rem auto;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Stok beberapa varian produk ini sudah mencapai atau di bawah limit:
                    <ul style="margin-bottom:0;">
                        @foreach($lowStockItems as $item)
                            <li>
                                <b>{{ $item['variant'] }}</b> — Stock: <span style="color:#d2691e">{{ $item['stock'] }}</span> / Limit: <span style="color:#d2691e">{{ $item['limit'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.update.stock.limit', [
                'productId' => $product->id,
                'colorId' => 0,
                'sizeId' => 0,
            ]) }}" method="POST" class="product-card-centered" autocomplete="off">
                @csrf
                @method('PUT')
                
                <div class="product-name" style="font-size:1.35rem; font-weight:700; text-align:center; margin-bottom:0.7rem;">
                    {{ $product->name }}
                </div>
                
                <div style="display:flex; justify-content:center; margin-bottom:1.2rem;">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/180x180?text=No+Image' }}" 
                         style="width:140px; height:140px; object-fit:cover; border-radius:12px; box-shadow:0 2px 8px #e0c3a0; background:#f3e5d0; border:1.5px solid #e0c3a0;" 
                         alt="{{ $product->name }}">
                </div>

                <div class="variant-list-centered" style="width:100%;">
                    @php
                        $productColors = $product->colors->isNotEmpty() ? $product->colors : collect([null]);
                        $productSizes = $product->sizes->isNotEmpty() ? $product->sizes : collect([null]);
                    @endphp

                    @foreach($productColors as $color)
                        @foreach($productSizes as $size)
                            @php
                                $stock = $product->stocks()
                                    ->when($color, function ($query) use ($color) { 
                                        return $query->where('color_id', $color->id); 
                                    })
                                    ->when($size, function ($query) use ($size) { 
                                        return $query->where('size_id', $size->id); 
                                    })
                                    ->first();
                                
                                $currentStock = $stock ? $stock->quantity : 0;
                                $stockLimit = $stock ? $stock->stock_limit : ($product->stock_limit ?? 0);
                                $variantKey = ($color ? $color->id : '0') . '-' . ($size ? $size->id : '0');
                            @endphp

                            <div class="row align-items-center mb-2" style="background:#fff; border-radius:8px; box-shadow:0 1px 4px #f3e5d0; padding:0.5rem 0.7rem;">
                                <div class="col-4" style="font-size:1rem; color:#a67c52; font-weight:500;">
                                    @if($color && $size)
                                        {{ $color->name }} / {{ $size->name }}
                                    @elseif($color)
                                        {{ $color->name }}
                                    @elseif($size)
                                        {{ $size->name }}
                                    @else
                                        Default
                                    @endif
                                </div>
                                
                                <div class="col-3" style="font-size:1rem; color:#7c4a03;">
                                    Stock: <b>{{ $currentStock }}</b>
                                </div>
                                
                                <div class="col-3 d-flex align-items-center" style="gap:0.3rem;">
                                    <input type="number" 
                                           name="stock_limit[{{ $variantKey }}]" 
                                           id="limit-{{ $variantKey }}" 
                                           class="form-control" 
                                           value="{{ $stockLimit }}" 
                                           min="0" 
                                           style="width:60px; font-weight:600; color:#7c4a03; background:#fff7ed; border:1.5px solid #e0c3a0; border-radius:7px;">
                                    <span style="font-size:0.95rem; color:#a67c52;">Limit</span>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>

                <button type="submit" class="save-btn-centered">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    function stepInput(id, step) {
        const input = document.getElementById(id);
        if (!input) return;
        
        let value = parseInt(input.value) || 0;
        value += step;
        if (value < 0) value = 0;
        input.value = value;
    }
</script>
@endsection