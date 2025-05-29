<style>
    .checkout-card {
        position: relative;
        display: flex;
        align-items: center;
        background-color: #E6B597;
        padding: 20px;
        border-radius: 8px;
        max-width: 100%;
        margin: 20px auto;
        gap: 20px;
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
        color: #444;
    }

    .checkout-info select {
        border-radius: 12px;
        width: 80px;
        padding: 4px 12px;
        font-size: 12px;
        height: 28px;
        border: 1px solid #ccc;
        background-color: #fff;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
    }

    .proceed-payment-btn {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: #fbe7d0;
        color: #333;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: bold;
        font-family: 'Arial', sans-serif;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
        text-decoration: none;
        white-space: nowrap;
    }

    .proceed-payment-btn:hover {
        background-color: #d2997a;
        color: #fff;
    }
</style>

@if(isset($carts) && $carts->count() > 0)
    <form method="POST" action="{{ route('order.checkout') }}">
        @csrf
        @foreach($carts as $cart)
            @if($cart->product)
                <div class="checkout-card">
                    <input type="checkbox" name="cart_ids[]" value="{{ $cart->id }}" id="cart_{{ $cart->id }}" checked hidden>
                    <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}"
                        class="checkout-image" />
                    <div class="checkout-details">
                        <h3 class="checkout-title">{{ $cart->product->name }}</h3>
                        <p class="checkout-info">Order id: {{ $cart->id }}</p>
                        <p class="checkout-info">Size : {{ $cart->size->name ?? 'N/A' }}</p>
                        <p class="checkout-info">Color : {{ $cart->color->name ?? 'N/A' }}</p>
                        <p class="checkout-info">Qty : {{ $cart->quantity }}</p>
                        <p class="checkout-info">Price : {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                        <p class="checkout-info">Address: {{ $address->recipient_name }} - Telp: {{ $address->phone }} -
                                {{ $address->address }}, {{ $address->city }}, {{ $address->province }} ({{ $address->postal_code }}),</p>
        <input type="hidden" name="address_id" value="{{ $address->id }}">
                        <div class="checkout-info">
                            <label for="shipping_method_{{ $cart->id }}">Ship method:</label>
                            <select name="shipping_method[{{ $cart->id }}]" id="shipping_method_{{ $cart->id }}">
                                <option value="jne">JNE</option>
                                <option value="jnt">J&T</option>
                                <option value="sicepat">SiCepat</option>
                            </select>

                        <p>Ongkir:</p>
                        <select id="shipping_cost" name="shipping_cost">
                            <option value="">-- Pilih Ongkir --</option>
                        </select>

                        </div>
                        <div class="checkout-info">
                            <label for="payment_method_{{ $cart->id }}">Payment method:</label>
                            <select name="payment_method[{{ $cart->id }}]" id="payment_method_{{ $cart->id }}">
                                <option value="bca">BCA</option>
                                <option value="mandiri">Mandiri</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="proceed-payment-btn">Proceed to Payment</button>
                </div>
            @endif
        @endforeach
    </form>
@else
    <p>No items in the cart to checkout.</p>
@endif


