<style>
    .cart-section {
        background-color: #EBC4AE;
        padding: 50px 20px;
        font-family: sans-serif;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 50px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
        max-width: 1800px;
        min-height: 200px;
    }


    .cart-item-left {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }

    .cart-item-left img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
    }

    .cart-item-left h3 {
        font-size: 16px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .cart-item-left p {
        color: #843902;
        font-weight: bold;
        margin: 0;
    }

    .qty-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-buttons button {
        width: 30px;
        height: 30px;
        border: 1px solid #ccc;
        background-color: white;
        font-weight: bold;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
    }

    .qty-buttons span {
        font-size: 16px;
        font-weight: bold;
    }

    .cart-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 50px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
        max-width: 1800px;
    }

    .cart-footer-left {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .cart-footer button,
    .cart-footer a {
        background-color: #843902;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 15px;
        font-weight: bold;
        transition: background-color 0.2s;
        border: none;
        cursor: pointer;
    }

    .cart-footer a:hover,
    .cart-footer button:hover {
        background-color: #843902;
    }

    .cart-footer span {
        font-size: 18px;
        font-weight: bold;
        margin-right: 10px;
    }

    .remove-button {
        display: flex;
        align-items: center;
        gap: 10px;
        background-color: white;
        border: none;
        font-size: 18px;
        font-weight: bold;
        color: black;
        cursor: pointer;
    }

    .remove-button img {
        width: 25px;
        height: 25px;
    }

    @media (max-width: 600px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .qty-buttons {
            margin-top: 10px;
        }

        .cart-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="cart-section">
    @forelse ($carts as $cart)
        <div class="cart-item">
            <div class="cart-item-left">
                <input type="checkbox" class="product-checkbox" value="{{ $cart->id }}" name="cart_checkbox"
                    data-price="{{ $cart->product->price * $cart->quantity }}">
                <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}">
                <div>
                    <h3>{{ $cart->product->name }}</h3>
                    <h3>{{ $cart->color->name ?? '-' }}</h3>
                    <h3>{{ $cart->size->name ?? '-' }}</h3>
                    <p>Rp{{ number_format($cart->product->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="qty-buttons">
                {{-- Tombol - (decrement) --}}
                <form action="{{ route('cart.decrement', $cart->product->id) }}" method="GET" style="display:inline;">
                    <button type="submit">-</button>
                </form>

                <span>{{ $cart->quantity }}</span>

                {{-- Tombol + (increment) --}}
                <form action="{{ route('cart.increment', $cart->product->id) }}" method="GET" style="display:inline;">
                    <button type="submit">+</button>
                </form>
            </div>
        </div>
    @empty
        <p style="text-align: center; font-weight: bold;">Tidak Ditemukan Produk di Keranjang.</p>
    @endforelse

    @if ($carts->count())
        <div class="cart-footer">
            <div class="cart-footer-left">
                <input type="checkbox" id="checkAll"> <label for="checkAll">All Product</label>

                {{-- Tombol remove satu item (hapus berdasarkan ID cart terakhir di loop) --}}
                <form id="removeSelectedForm" action="{{ route('cart.removeSelected') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="cart_ids[]" id="selectedCartIds">
                    <button type="submit" class="remove-button">
                        <img src="{{ asset('images/trashlogo.png') }}" alt="Trash Icon">
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
            <div>
                <span>Total: Rp<span id="totalPrice">0</span></span>
                <a href="{{ route('checkout') }}" class="checkout-btn">Checkout (<span id="selectedCount"> 0</span>)</a>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: @json(session('success')),
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Stok Tidak Mencukupi!',
            text: @json(session('error')),
            confirmButtonColor: '#d33',
            showCancelButton: true,
            cancelButtonText: 'Kembali',
            confirmButtonText: 'Lihat Stok',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman produk untuk melihat stok
                window.location.href = "{{ route('products.index') }}";
            }
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        const productCheckboxes = document.querySelectorAll('.product-checkbox');
        const totalPriceElem = document.getElementById('totalPrice');
        const selectedCountElem = document.getElementById('selectedCount');
        const checkoutCartIdsInput = document.getElementById('checkoutCartIds');
        const removeSelectedForm = document.getElementById('removeSelectedForm');
        const checkoutBtn = document.querySelector('.checkout-btn');

        function getSelectedCheckboxes() {
            return [...document.querySelectorAll('.product-checkbox:checked')];
        }

        function updateCartSummary() {
            const selected = getSelectedCheckboxes();
            let total = 0;
            let selectedIds = [];

            selected.forEach(cb => {
                total += parseInt(cb.dataset.price);
                selectedIds.push(cb.value);
            });

            // Format total
            const formatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            totalPriceElem.textContent = formatted.replace('Rp', '').trim();
            selectedCountElem.textContent = selected.length;
            checkoutCartIdsInput.value = selectedIds.join(',');
        }

        // Checkbox event
        productCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateCartSummary);
        });

        // Select All checkbox
        checkAll?.addEventListener('change', function () {
            productCheckboxes.forEach(cb => cb.checked = this.checked);
            updateCartSummary();
        });

        // Form Hapus
        removeSelectedForm?.addEventListener('submit', function (e) {
            const selected = getSelectedCheckboxes();

            if (selected.length === 0) {
                e.preventDefault();
                alert('Pilih setidaknya satu produk untuk dihapus.');
                return;
            }

            // Hapus input hidden lama
            this.querySelectorAll('input[name="cart_ids[]"]').forEach(el => el.remove());

            // Tambah input hidden baru
            selected.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart_ids[]';
                input.value = cb.value;
                this.appendChild(input);
            });
        });

        // Tombol Checkout
        checkoutBtn?.addEventListener('click', function (e) {
            const selected = getSelectedCheckboxes();
            if (selected.length === 0) {
                e.preventDefault();
                alert('Pilih setidaknya satu produk untuk checkout.');
                return;
            }
            // hidden input sudah diisi di updateCartSummary()
        });

        updateCartSummary(); // Inisialisasi saat load
    });
</script>