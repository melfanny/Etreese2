@extends('layouts.app_admin')

@section('content')
    <style>
        .dashboard-container {
            padding: 50px 10%;
            font-family: 'Cormorant Garamond', serif;
        }

        .dashboard-header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #65141d;
        }

        .add-button {
            background-color: #843902;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }

        .product-card {
            width: 500px;
            background-color: #EBC4AE;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            width: 100%;
            height: auto;
        }

        .img-wrapper {
            border-left-radius: 20px;
            border-right-radius: 20px;
            overflow: hidden;
        }

        .img-wrapper img {
            display: block;
            width: 100%;
            height: 450px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-left-radius: 40px;
            border-right-radius: 40px;
            object-fit: cover;
        }


        .product-name {
            background-color: #EBC4AE;
            color: #65141d;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #EBC4AE;
            align-items: left;
        }

        .action-buttons button {
            background-color: #843902;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .action-buttons button:hover {
            background-color: #a45640;
        }

        .action-buttons .delete-btn {
            background-color: #843902;
        }

        .action-buttons .delete-btn:hover {
            background-color: #b52b27;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <a href="{{ route('admin.products.create') }}" class="add-button">+ Add New</a>
        </div>


        <div class="product-grid">
            {{-- Product Card 1 --}}
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="https://contents.mediadecathlon.com/p2157319/k$45a8143f29ae498e05be9c1588d95135/kaos-running-dry-fit-baju-lari-pria-breathable-hitam-decathlon-8488034.jpg?f=1920x0&format=auto"
                        alt="Ethereal Bloom">
                </div>
                <div class="product-name">Ethereal Bloom</div>
                <div class="action-buttons">
                    <button class="edit-btn"><i class="fas fa-pen"></i> Edit</button>
                    <button class="delete-btn"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>

            {{-- Product Card 2 --}}
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="https://png.pngtree.com/thumb_back/fh260/background/20230630/pngtree-3d-render-of-a-plain-white-t-shirt-image_3692593.jpg"
                        alt="Ethereal Bloom">
                </div>
                <div class="product-name">Ethereal Bloom</div>
                <div class="action-buttons">
                    <button class="edit-btn"><i class="fas fa-pen"></i> Edit</button>
                    <button class="delete-btn"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>


            {{-- Product Card 3 --}}
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="https://parto.id/asset/foto_produk/Baju_kaos_jpg_171574711527.jpg" alt="Ethereal Bloom">
                </div>
                <div class="product-name">Ethereal Bloom</div>
                <div class="action-buttons">
                    <button class="edit-btn"><i class="fas fa-pen"></i> Edit</button>
                    <button class="delete-btn"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>

        </div>
    </div>

    @include('layouts.footer')
@endsection