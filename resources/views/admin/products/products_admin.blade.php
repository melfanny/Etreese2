@extends('layouts.app_admin')

@section('content')
    <style>
        .products-admin-container {
            background-color: #e5c7b0;
        }

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
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            width: 100%;
        }

        @media (max-width: 1100px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }


        .product-card {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            background-color: #F3E5D7;
            color: #65141d;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #F3E5D7;
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
    <div class="products-admin-container">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <a href="{{ route('admin.products.create') }}" class="add-button">+ Tambah Produk Baru</a>
            </div>
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <div class="img-wrapper">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/500x450?text=No+Image" alt="No Image">
                            @endif
                        </div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="action-buttons">
                            <!-- Edit -->
                            <a href="{{ route('admin.products.edit', $product->id) }}">
                                <button class="edit-btn">Edit</button>
                            </a>


                            <!-- Delete -->
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    @include('layouts.footer')
    </div>
@endsection