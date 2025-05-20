<style>
.product-detail-section {

    padding: 40px;
    background-color: #5C2E00;

}

/* Product Detail Section */
.product-detail {
    padding: 40px;
}

.product-container {
    display: flex;
    gap: 40px;
    max-width: 1200px;
    margin: auto;
    background-color: #EBC4AE;
    border-radius: 20px;
    padding: 30px;
}

/* Left Side */
.product-image img {
    width: 350px;
    border-radius: 20px;
    background-color: white;
    padding: 15px;
}

/* Right Side */
.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
    color: #000000;
}

.section-label {
    font-weight: bold;
    font-size: 14px;
    color: #ffffff;
}

.product-name h2 {
    font-size: 24px;
    color: #000000;
}

.product-description p {
    font-size: 16px;
    line-height: 1.5;
}

/* Option Buttons */
.option-group {
    margin-top: 10px;
}

.option-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.option-group button {
    background-color: white;
    color: #3F1F0A;
    border: none;
    margin: 5px 10px 5px 0;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.option-group button:hover {
    background-color: #ffdbb4;
}

/* Stock & Sold */
.stock-sold {
    display: flex;
    gap: 40px;
    font-size: 16px;
}

/* Price & Cart */
.price-cart {
    display: flex;
    align-items: center;
    gap: 20px;
}

.price {
    font-size: 24px;
    font-weight: bold;
    color: #000000;
}

.cart-btn {
    background-color: #fff;
    border: none;
    padding: 10px;
    border-radius: 12px;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.cart-btn:hover {
    transform: scale(1.05);
}

.cart-btn img {
    width: 30px;
}

img {
    width: 50px;
}

</style>
 
 <section class="product-detail-section">
        <section class="product-detail">
        <div class="product-container">
            <!-- Left Side: Product Image -->
            <div class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            <!-- Right Side: Product Info -->
            <div class="product-info">

            
                
                    <label class="section-label">Product name</label>
                    <h2>{{ $product->name }}</h2>
                

                <section class="product-description">
                    <label class="section-label">Description</label>
                    <p>{{ $product->deskripsi }}</p>
                </section>

                <section class="product-options">
                    <div class="option-group">
                        <label class="section-label">Size:</label>
                        @foreach ($product->sizes as $size)
                            <button class="option-btn">{{ $size->name }}</button>
                        @endforeach
                    </div>

                    <div class="option-group">
                        <label class="section-label">Color:</label>
                        @foreach ($product->colors as $color)
                            <button class="option-btn">{{ $color->name }}</button>
                        @endforeach
                    </div>
                </section>

                <section class="stock-sold">
                    <div class="option stock-sold">
                        <label class="section-label">Stock:</label>
                        @foreach ($product->stocks as $stock)
                        <button>{{ $stock->quantity }}</button>
                        @endforeach
                    </div>
                </section>
                
                <section class="price-cart">
                    <label class="section-label">Price:</label>
                    <span class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <button class="cart-button"><img src="{{ asset('images/cartlogo.png') }}" alt="Add to Cart"></button>
                </section>
            </div>
        </div>
    </section>
</section>
