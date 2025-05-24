<style>
    .home-bestseller-section {
        background-color: #843902;
        padding: 50px 10%;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .home-bestseller-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: white;
        position: relative;
    }

    .home-bestseller-title::after {
        content: '';
        display: inline-block;
        width: 70px;
        height: 20px;
        background: #fbe7d0;
        position: absolute;
        bottom: 5px;
        left: 155px;
        z-index: -1;
        border-radius: 10px;
    }

    .home-bestseller-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .home-bestseller-card {
        width: 100%;
        background-color: #fbe7d0;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .home-bestseller-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .home-bestseller-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .home-bestseller-card .card-body {
        padding: 15px 20px 20px;
    }

    .home-bestseller-card .btn-explore {
        background-color: #E6B597;
        color: white;
        font-weight: bold;
        border-radius: 20px;
        border: 2px solid white;
        padding: 4px 12px;
        font-size: 0.75rem;
        margin-bottom: 8px;
        display: inline-block;
        text-decoration: none;
        transition: background 0.2s;
    }

    .home-bestseller-card .btn-explore:hover {
        background-color: #fbe7d0;
    }

    .home-bestseller-card h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #843902;
        margin: 0;
    }

    @media (max-width: 768px) {
        .home-bestseller-grid {
            grid-template-columns: 1fr;
        }

        .home-bestseller-title {
            text-align: center;
        }

        .home-bestseller-title::after {
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<section class="home-bestseller-section">
    <h2 class="home-bestseller-title">Buyer’s Favourite</h2>
    <div class="home-bestseller-grid">
        @foreach ($products as $product)
            <div class="home-bestseller-card">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}">
                <div class="card-body">
                    <a href="{{ route('product.productdetails', ['id' => $product->id]) }}" class="btn-explore">Explore</a>
                    <h4>{{ $product->name }}</h4>
                </div>
            </div>
        @endforeach
    </div>
</section>