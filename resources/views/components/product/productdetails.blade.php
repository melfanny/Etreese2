<style>
.product-detail-section {
    padding: 40px;
    background-color: #5C2E00;
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

.product-image img {
    margin-top: 15px;
    border-radius: 20px;
    padding: 15px;
}

.cart-image img {
    margin-top: 15px;
    border-radius: 20px;
    padding: 15px;
    margin-left: 50px;
}

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
}

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
    color: #000000;
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

.stock{
    display: flex;
    gap: 40px;
    font-size: 16px;
}

.price-cart {
    margin-left: 20px;
}

.cart-btn {
    border: none;
    padding: 10px;
    border-radius: 12px;
    cursor: pointer;
    padding: 0;
    background: none;
    transition: transform 0.2s ease;
}

.cart-btn img {
    width: 60px;
    border-radius: 12px;
    padding: 5px;
}

.cart-btn:hover {
    transform: scale(1.05);
}

.price-cart-row {
    display: flex;
    align-items: center;
    gap: 20px;
}

.price-value {
    font-size: 24px;
    font-weight: bold;
    color: #000000;
}


.product-summary {
    background-color: #FBE7D0;
    padding: 20px 25px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.option-group button.selected {
    background-color: #5C2E00;
    color: white;
}

.stock-values {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 5px;
}

.stock-item {
    background-color: #FBE7D0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    color: #3F1F0A;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
}

</style>
 
 <section class="product-detail-section">
        <section>
        <div class="product-container">
            <!--  Gambar Produk (ambil dari database langsung) -->
            <div class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                 <section class="price-cart-row">
                    <!-- Harga Produk (ambil dari database langsung) -->
                    <label class="section-label price-cart">Price:</label>
                    <span class="price-value">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <!-- Direct ke page cart ketika menekan tombol cart untuk menambahkan produk ke cart -->
                    <form method="GET" action="{{ route('cart.add', $product->id) }}" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="size_id" id="selectedSizeId">
                        <button class="cart-btn" type="submit">
                            <img src="{{ asset('images/cartlogo.png') }}" alt="Add to Cart">
                        </button>
                    </form>
                </section>
            </div>

            <!-- Informasi Produk (ambil dari database) -->
            <div class="product-info">
                <label class="section-label">Product name</label>
                <div class="product-summary">
                    <h2>{{ $product->name }}</h2>
                </div>
                <section class="product-description">
                    <label class="section-label">Description</label>
                <div class="product-summary">
                    <p>{{ $product->deskripsi }}</p>
                </div>
                </section>

                <!-- Ukuran Produk (ambil dari form input button pelanggan) -->
                <section class="product-options">
                    <div class="option-group">
                        <label class="section-label">Size:</label>
                        @foreach ($product->sizes as $size)
                            <button type="button" class="option-btn size-btn" data-id="{{ $size->id }}">{{ $size->name }}</button>
                        @endforeach
                    </div>

                    <!-- Warna Produk (ambil dari database langsung) -->
                    <div class="option-group">
                        <label class="section-label">Color:</label>
                        @foreach ($product->colors as $color)
                            <div class="stock-item">{{ $color->name }}</div>
                        @endforeach
                    </div>
                </section>

                <!-- Stock Produk (ambil dari database langsung) -->
                <section class="stock">
                    <div class="option-group">
                        <label class="section-label">Stock:</label>
                    <div class="stock-values">
                        @foreach ($product->stocks as $stock)
                            <div class="stock-item">{{ $stock->quantity }}</div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sizeButtons = document.querySelectorAll('.size-btn');
        const sizeInput = document.getElementById('selectedSizeId');

        sizeButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Hapus class selected dari semua tombol
                sizeButtons.forEach(btn => btn.classList.remove('selected'));
                // Tambahkan class selected ke tombol yang diklik
                this.classList.add('selected');
                // Simpan id size ke input hidden
                sizeInput.value = this.dataset.id;
            });
        });

    document.getElementById('addToCartForm').addEventListener('submit', function (e) {
            if (!sizeInput.value) {
                e.preventDefault();
                alert('Silakan pilih ukuran terlebih dahulu!');
            }
        });
    });
</script>
