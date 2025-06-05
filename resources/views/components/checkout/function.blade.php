<style>
    .checkout-body {
        background-color: #EBC4AE;
        width: 100%;
        min-height: 100%;
        padding: 0;
        box-sizing: border-box;
    }

    .checkout-container {
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
        border-radius: 12px;
    }

    .checkout-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 20px;
        box-sizing: border-box;
    }

    .checkout-card {
        display: flex;
        align-items: center;
        background-color: #FFFBEF;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 16px;
        gap: 20px;
        position: relative;
    }

    .checkout-image {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        background-color: #f0f0f0;
        padding: 10px;
    }

    .checkout-details {
        flex: 1;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .checkout-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .checkout-info {
        margin: 6px 0;
        font-size: 14px;
    }

    .checkout-info select {
        border-radius: 12px;
        width: 100px;
        padding: 4px 8px;
        font-size: 12px;
        height: 28px;
        border: 1px solid #ccc;
        background-color: #fff;
        appearance: none;
        cursor: pointer;
    }

    .checkout-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fbe7d0;
        padding: 20px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .summary-row {
        margin-bottom: 12px;
        font-size: 16px;
    }

    .summary-total {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 0;
    }

    .summary-select {
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        width: 150px;
        appearance: none;
        cursor: pointer;
        background-color: #fff;
    }

    .proceed-payment-btn {
        background-color: #E6B597;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        font-family: 'Arial', sans-serif;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .proceed-payment-btn:hover {
        background-color: #d2997a;
        color: #fff;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Stok Tidak Mencukupi!',
            text: @json(session('error')),
            confirmButtonColor: '#d33',
            showCancelButton: true,
            cancelButtonText: 'Kembali ke Cart',
            confirmButtonText: 'Lihat Stok',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman produk untuk melihat stok
                window.location.href = "{{ route('products.index') }}";
            } else {
                // Redirect kembali ke cart
                window.location.href = "{{ route('cart.index') }}";
            }
        });
    </script>
@endif

@if(isset($carts) && $carts->count() > 0)
    @php $totalPrice = 0; @endphp
    <form method="POST" action="{{ route('order.checkout') }}">
        @csrf
        <div class="checkout-body">
            <div class="checkout-container">
                @foreach($carts as $cart)
                    @if($cart->product)
                        @php
                            $subtotal = $cart->product->price * $cart->quantity;
                            $totalPrice += $subtotal;
                        @endphp
                        <input type="hidden" name="cart_ids[]" value="{{ $cart->id }}">
                        <div class="checkout-card">
                            <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}"
                                class="checkout-image" />
                            <div class="checkout-details">
                                <h3 class="checkout-title">{{ $cart->product->name }}</h3>
                                <p class="checkout-info">Ukuran: {{ $cart->size->name ?? 'N/A' }}</p>
                                <p class="checkout-info">Warna: {{ $cart->color->name ?? 'N/A' }}</p>
                                <p class="checkout-info">Qty: {{ $cart->quantity }}</p>
                                <p class="checkout-info">Harga: Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>

                                <input type="hidden" name="address_id" value="{{ $address->id }}">

                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="summary-row">
                    <label for="shipping_method">Metode Pengiriman:</label><br>
                    <select name="shipping_method" id="shipping_method" class="summary-select">
                        <option value="jne">JNE</option>
                        <option value="jnt">J&T</option>
                        <option value="sicepat">SiCepat</option>
                    </select>
                </div>

                <div class="summary-row">
                    <label for="payment_method">Metode Pembayaran:</label><br>
                    <select name="payment_method" id="payment_method" class="summary-select">
                        <option value="bca">BCA</option>
                        <option value="mandiri">Mandiri</option>
                    </select>
                </div>
                <div class="checkout-summary">
                    <div class="summary-total">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                    <button type="submit" class="proceed-payment-btn">Bayar</button>
                </div>
            </div>
        </div>
    </form>
@else
    <p>Tidak ada produk di keranjang untuk dibayar.</p>
@endif