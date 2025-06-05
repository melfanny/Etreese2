<style>
    .products-section {
        background-color: #EBC4AE;
        padding: 40px 20px;
    }

    .catalog {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .product-card {
        background-color: #8B4513;
        border-radius: 15px;
        width: 280px;
        min-height: 320px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .product-card img {
        width: 100%;
        aspect-ratio: 1 / 1.2;
        padding: 15px;
        box-sizing: border-box;
        object-fit: cover;
        border-radius: 20px;
    }

    .product-footer {
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .product-name {
        font-weight: bold;
        font-size: 16px;
        color: #ffffff;
        flex: 1;
        padding-right: 10px;
        display: block;
        white-space: normal;
        text-overflow: unset;
        word-break: break-word;
    }



    .cart-button:hover {
        background-color: #5a3315;
    }

    .cart-button img {
        width: 24px;
        height: 24px;
    }

    .product-price {
        color: #ffffff;
        font-weight: bold;
        font-size: 14px;
        margin-left: 10px;
        white-space: nowrap;
    }
</style>

<section class="products-section">
    <div class="catalog">
        @foreach ($products as $product)
            <a href="{{ route('product.productdetails', $product->id) }}">
                <div class="product-card">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.jpg') }}"
                        alt="{{ $product->name }}">
                    <div class="product-footer">
                        <span class="product-name">{{ $product->name }}</span>
                        <span class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        <button class="cart-button"></button>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>