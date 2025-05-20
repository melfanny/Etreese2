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
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.product-card img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 10px;
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
</style>

<section class="products-section">
    <div class="catalog">
        @foreach ($products as $product)
            <div class="product-card">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.jpg') }}" alt="{{ $product->name }}">
                <div class="product-footer">
                    <span class="product-name">{{ $product->name }}</span>
                    <span class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <button class="cart-button">
                        <img src="{{ asset('images/whitecartlogo.png') }}" alt="Cart" />
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>
