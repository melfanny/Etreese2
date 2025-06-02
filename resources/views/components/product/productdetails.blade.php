<style>
    .product-detail-section {
        padding: 40px;
        background-color: #EBC4AE;
    }

    .product-container {
        display: flex;
        gap: 20px;
        max-width: 1200px;
        margin: auto;
        background-color: #843F02;
        border-radius: 20px;
        padding: 30px;
    }

    .product-image img {
        width: 100%;
        max-width: 500px;
        aspect-ratio: 1 / 1.2;
        padding: 20px;
        box-sizing: border-box;
        object-fit: cover;
        border-radius: 30px;
    }

    .section-label {
        font-weight: bold;
        font-size: 20px;
        color: #FFFBEF;
    }


    .product-description {
        padding: 20px;
        width: 100%;
        max-width: 600px;
    }

    .option-group label {
        display: block;
    }

    .option-group button {
        background-color: #FFFBEF;
        color: #000000;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .option-group button:hover {
        background-color: #ffdbb4;
    }

    .price-cart-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .price-value {
        font-size: 24px;
        font-weight: bold;
        color: #FFFBEF;
    }

    .cart-btn {
        transition: transform 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-btn img {
        display: block;
        width: 100%;
        max-width: 50px;
        height: auto;
        border-radius: 12px;
        padding: 5px;
        object-fit: contain;
    }


    .cart-btn:hover {
        transform: scale(1.05);
    }

    .price-cart-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .price-value {
        font-size: 24px;
        font-weight: bold;
        color: #FFFBEF;
    }


    .product-summary {
        background-color: #FBE7D0;
        padding: 20px 25px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        gap: 20px;
        font-size: 18px;
    }

    .option-group button.selected {
        background-color: #5C2E00;
        color: white;
    }

    .stock-text {
        font-size: 15px;
        color: rgb(206, 179, 161);
    }

    .size-stock-pair {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }
</style>

<section class="product-detail-section">
    <div class="product-container">
        <!--  Gambar Produk (ambil dari database langsung) -->
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            <section class="price-cart-row">
                <div>
                    <!-- Harga Produk (ambil dari database langsung) -->
                    <label class="section-label price-cart">Price:</label>
                    <span class="price-value">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
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
        <div class="product-description">
            <div>
                <label class="section-label">Product name</label>
                <div class="product-summary">
                    <h2>{{ $product->name }}</h2>
                </div>
            </div>

            <div>
                <label class="section-label">Description</label>
                <div class="product-summary">
                    <h2>{{ $product->deskripsi }}</h2>
                </div>
            </div>

            <!-- Ukuran dan Stok Produk -->
            <section class="product-options">
                <div class="option-group">
                    <label class="section-label">Size</label>
                    @foreach ($product->sizes as $size)
                        @php
                            $stockQty = $product->stocks->where('size_id', $size->id)->first()->quantity ?? 0;
                        @endphp
                        <div class="size-stock-pair"
                            style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <button type="button" class="option-btn size-btn" data-id="{{ $size->id }}">
                                {{ $size->name }}
                            </button>
                            <span class="stock-text">Stok: {{ $stockQty }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Warna Produk (ambil dari database langsung) -->
                <div class="option-group">
                    <label class="section-label">Color:</label>
                    @foreach ($product->colors as $color)
                        <div class="product-summary">{{ $color->name }}</div>
                    @endforeach
                </div>
        </div>
    </div>
    </div>
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