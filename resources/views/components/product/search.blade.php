<style>
.products-section {
    background-color: #fbe8d3;
    padding: 10px;
}

.search-bar {
   margin-left: 300px; /* supaya search bar ke tengah */
}

.search-bar form {
    display: flex;
    align-items: center; /* supaya logo sejajar horizontal dengan search bar */
    gap: 10px;
}

.search-bar input[type="text"] {
    width: 70%;
    border-radius: 20px;
    border: 1px solid #ccc;
    padding: 10px 20px;
    font-size: 16px;
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
    object-fit: contain; /* mengatur ukuran ikon search */
}

.not-found {
    margin-top: 100px; 
    margin-left: 230px;
}
</style>

<section class="products-section">
    <div class="search-bar">
        <!-- Menggunakan route product untuk melakukan search supaya gak perlu direct ke route baru (search) untuk pencarian -->
        <form action="{{ route('products.index') }}" method="GET"> 
            <input type="text" name="search" value="{{ request('search') }}">
            <button type="submit"></button>
                <img src="{{ asset('images/searchlogo.png') }}" alt="Search" class="search-logo">
        </form>
        <!-- Kondisional jika produk ditemukan maka tampilkan product cartnya. Jika tidak maka menampilkan tulisan produk tidak ditemukan -->
        @if($products->count())
            @foreach($products as $product)
            @endforeach
        @else
            <p class="not-found">Produk tidak ditemukan</p>
        @endif
    </div>
</section>