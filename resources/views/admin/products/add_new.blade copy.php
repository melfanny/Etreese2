<style>
    .product-form-container {
        background-color: #f3e5d7;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
        max-width: 60rem;
        margin: auto;
    }

    .product-form-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #8b4513;
    }

    .product-form-grid {
        display: flex;
        gap: 2rem;
    }

    .product-image-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f9f2ea;
        border: 2px dashed #843902;
        padding: 1.5rem;
        border-radius: 0.75rem;
        width: 18rem;
        height: 22rem;
    }

    .label {
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #8b4513;
    }

    .input-field,
    .textarea-field,
    .input-attr {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #843902;
        border-radius: 0.5rem;
        background-color: #f9f2ea;
    }

    .submit-btn {
        background-color: #843902;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        margin-top: 1rem;
        transition: background-color 0.2s ease-in-out;
    }

    .submit-btn:hover {
        background-color: #6d3f26;
    }
</style>

@extends('layouts.app_admin')

@section('content')
    <div class="product-create-container mx-auto p-8 bg-neutral-50 min-h-screen">
        <div class="product-form-container">
            <h2 class="product-form-title">Create New Product</h2>

            <form action="{{ route('admin.products.products_admin') }}"> @csrf

                <div class="product-form-grid">
                    <div class="product-image-upload">
                        <label for="image" class="product-image-label">
                            <span class="image-placeholder">Insert Image</span>
                            <input type="file" name="image" id="image" class="hidden">
                        </label>
                    </div>

                    <div class="product-details">
                        <input type="text" name="name" placeholder="Product Name" class="input-field">
                        <input type="number" name="price" placeholder="Price" class="input-field">
                        <textarea name="description" placeholder="Description" class="textarea-field"></textarea>

                        <div class="product-attributes">
                            <input type="text" name="size" placeholder="Size" class="input-attr">
                            <input type="text" name="pattern" placeholder="Pattern" class="input-attr">
                            <input type="text" name="color" placeholder="Color" class="input-attr">
                        </div>

                        <button type="submit" class="submit-btn">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.footer')
@endsection