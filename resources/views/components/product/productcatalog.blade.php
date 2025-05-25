<style>
.products-section {
    background-color: #EBC4AE;
    padding: 40px;
}

.catalog {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

.product-card {
    background-color: #8B4513;
    border-radius: 15px;
    width: 300px;
    height: 300px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
}

.product-card img {
    width: 100%;
    height: 250px;
    display: block;
    border-radius: 10px;
    flex-shrink: 0;
}

.product-footer {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-name {
    padding-left: 10px;
    font-weight: bold;
    font-size: 14px;
    color: #ffffff;
}

.cart-button {
    background-color: #8B4513; /* Dark brown */
    border: none;
    padding: 8px;
    border-radius: 10px;
    cursor: pointer;
}

.cart-button img {
    width: 30px;
    height: 30px;
}

.product-price {
    color: #ffffff;
}
</style>

<section class="products-section">
    <div class="catalog">
        @foreach ($products as $product)
             <a href="{{ route('product.productdetails', $product->id) }}">
                <div class="product-card">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.jpg') }}" alt="{{ $product->name }}">
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
