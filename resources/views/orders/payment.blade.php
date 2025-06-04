@extends('layouts.app_order_users')

<style>
    .payment-body {
        background-color: #EBC4AE;
        width: 100%;
        min-height: 100%;
        padding: 0;
        box-sizing: border-box;
    }

    .payment-container {
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
        border-radius: 12px;
    }

    .payment-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 20px;
        box-sizing: border-box;
    }

    .payment-card {
        display: flex;
        align-items: center;
        background-color: #FFFBEF;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 16px;
        gap: 20px;
        position: relative;
    }

    .payment-image {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        background-color: #f0f0f0;
        padding: 10px;
    }

    .payment-details {
        flex: 1;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .payment-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .payment-info {
        margin: 6px 0;
        font-size: 14px;
    }

    .payment-summary {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #fbe7d0;
        padding: 20px;
        border-radius: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .summary-total {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .proceed-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
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

@section('content')
    <div class="payment-body">
        <div class="payment-container">
            <h2>Pembayaran Order #{{ $order->id }}</h2>

            @if(isset($order->checkout_data) && count($order->checkout_data) > 0)
                @php $totalPrice = 0; @endphp
                @foreach($order->checkout_data as $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $totalPrice += $subtotal;
                    @endphp
                    <div class="payment-card">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['product_name'] }}"
                            class="payment-image" />
                        <div class="payment-details">
                            <h3 class="payment-title">{{ $item['product_name'] }}</h3>
                            <p class="payment-info">Ukuran: {{ $item['size'] ?? 'N/A' }}</p>
                            <p class="payment-info">Warna: {{ $item['color'] ?? 'N/A' }}</p>
                            <p class="payment-info">Qty: {{ $item['quantity'] }}</p>
                            <p class="payment-info">Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="payment-summary">
                    <div>
                        <div class="summary-total">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                        <div class="payment-info">Metode Pengiriman: <b>{{ $order->shipping_method ?? 'N/A' }}</b></div>
                        <div class="payment-info">Metode Pembayaran: <b>{{ $order->payment_method ?? 'N/A' }}</b></div>
                    </div>

                    <div class="proceed-buttons">
                        <form action="{{ route('order.pay', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="proceed-payment-btn">Bayar Sekarang (Simulasi)</button>
                        </form>

                        @if($order->snap_token)
                            <button id="pay-button" class="proceed-payment-btn">Bayar dengan Midtrans</button>
                        @endif
                    </div>
                </div>

            @else
                <p>No items in the order to pay.</p>
            @endif
        </div>

        <!-- Midtrans JS Client -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

        <!-- Snap Payment Script -->
        <script>
            const payBtn = document.getElementById('pay-button');
            if (payBtn) {
                payBtn.addEventListener('click', function () {
                    fetch('{{ route('order.getSnapToken', $order->id) }}')
                        .then(res => {
                            if (!res.ok) throw new Error('Gagal ambil snap token');
                            return res.json();
                        })
                        .then(data => {
                            if (!data.snap_token) {
                                alert('Token pembayaran tidak tersedia.');
                                return;
                            }

                            window.snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    document.getElementById('result-json').textContent = JSON.stringify(result, null, 2);
                                    alert("Pembayaran berhasil!");
                                },
                                onPending: function (result) {
                                    document.getElementById('result-json').textContent = JSON.stringify(result, null, 2);
                                    alert("Pembayaran tertunda.");
                                },
                                onError: function (result) {
                                    document.getElementById('result-json').textContent = JSON.stringify(result, null, 2);
                                    alert("Pembayaran gagal.");
                                },
                                onClose: function () {
                                    alert("Anda menutup popup pembayaran.");
                                }
                            });
                        })
                        .catch(err => {
                            alert("Terjadi kesalahan: " + err.message);
                            console.error(err);
                        });
                });
            }
        </script>
        @include('layouts.footer')
    </div>
@endsection