<style>
    .products-section {
        background-color: #fbe8d3;
        padding: 10px;
    }

    .search-bar {
        width: 100%;
        display: flex;
        justify-content: center;
        /* Pusatkan form */
        align-items: center;
        padding: 10px 0;
        box-sizing: border-box;
    }

    .search-bar form {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        max-width: 600px;
        /* agar tidak terlalu lebar di desktop */
    }

    .search-bar input[type="text"] {
        flex: 1;
        /* biar input mengambil sisa ruang */
        border-radius: 20px;
        border: 1px solid #ccc;
        padding: 10px 20px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
    }


    .search-button {
        border: none;
        background: none;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .search-logo {
        width: 25px;
        height: 25px;
        object-fit: contain;
        /* mengatur ukuran ikon search */
    }

    .not-found {
        margin-top: 100px;
        margin-left: 230px;
    }
</style>

<section class="products-section">
    <div class="search-bar">
        <!-- Menggunakan route product untuk melakukan search supaya gak perlu direct ke route baru (search) untuk pencarian -->
        <form id="searchForm" action="{{ route('products.index') }}" method="GET">
            <input type="text" id="searchInput" name="search" value="{{ request('search') }}">
            <button type="submit"></button>
            <img src="{{ asset('images/searchlogo.png') }}" alt="Search" class="search-logo">
        </form>
        <script>
            (function () {
                const form = document.getElementById('searchForm');
                const input = document.getElementById('searchInput');
                let timeout = null;

                input.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        form.submit();
                    }, 300); // debounce delay 300ms
                });
            })();
        </script>
        <!-- Kondisional jika produk ditemukan maka tampilkan product cartnya. Jika tidak maka menampilkan tulisan produk tidak ditemukan -->
        @if($products->count())
            @foreach($products as $product)
            @endforeach
        @else
            <p class="not-found">Produk tidak ditemukan</p>
        @endif
    </div>
</section>