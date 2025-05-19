@extends('layouts.admin.navigation_admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Add New Product</h1>

        <form action="{{ route('#') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Product Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 px-4 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Image</label>
                <input type="file" name="image" class="w-full border border-gray-300 px-4 py-2 rounded" required>
            </div>

            <button type="submit" class="bg-[#a9582b] text-white px-6 py-2 rounded">Add Product</button>
        </form>
    </div>
@endsection