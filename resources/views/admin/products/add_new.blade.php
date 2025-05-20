@extends('layouts.app_admin')

@section('content')
    <style>
        .product-form-container {
            background-color: #f3e5d7;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            max-width: 60%;
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
            flex-direction: row;
            align-items: flex-start;
            flex-wrap: wrap;
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
            position: relative;
            overflow: hidden;
        }

        .product-image-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .product-image-upload .image-placeholder {
            color: #843902;
            font-weight: bold;
            position: absolute;
            z-index: 1;
        }

        #preview-image {
            display: none;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 0.5rem;
            z-index: 1;
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
            background-color: rgb(101, 99, 98);
        }
    </style>

    <div class="product-create-container mx-auto p-8 bg-neutral-50 min-h-screen">
        <div class="product-form-container">
            <h2 class="product-form-title">Tambah Produk Baru</h2>

            @if ($errors->any())
                <div style="color:red; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="product-form-grid">
                    <div class="product-image-upload">
                        <img id="preview-image" src="#" alt="Preview">
                        <span class="image-placeholder">Insert Image</span>
                        <input type="file" name="image" id="image" accept="image/*">
                    </div>


                    <div class="product-details" style="flex: 1;">
                        <input type="text" name="name" placeholder="Nama Produk" class="input-field"
                            value="{{ old('name') }}" required>
                        <input type="number" name="price" placeholder="Harga (tanpa Rp)" class="input-field"
                            value="{{ old('price') }}" required min="0">
                        <textarea name="deskripsi" placeholder="Deskripsi"
                            class="textarea-field">{{ old('deskripsi') }}</textarea>

                        <div class="label">Warna</div>
                        <div id="colors-wrapper">
                            <input type="text" name="colors[]" placeholder="Masukkan warna" class="input-attr" required>
                        </div>

                        <div class="label">Ukuran</div>
                        <div id="sizes-wrapper">
                            <input type="text" name="sizes[]" placeholder="Masukkan ukuran" class="input-attr" required>
                        </div>
                        <button type="button" onclick="addSize()" class="submit-btn"
                            style="margin-top: 0; margin-bottom: 1rem;">Tambah Ukuran</button>

                        <div class="label">Stok per Kombinasi</div>
                        <div id="stock-wrapper" style="margin-top: 1rem;"></div>

                        <button type="submit" class="submit-btn">Simpan Produk</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>

    <script>
        function addSize() {
            const wrapper = document.getElementById('sizes-wrapper');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'sizes[]';
            input.className = 'input-attr';
            input.placeholder = 'Masukkan ukuran';
            input.required = true;

            const spacer = document.createElement('div');
            spacer.style.marginTop = '0.5rem';

            wrapper.appendChild(spacer);
            wrapper.appendChild(input);
            updateStockInputs();
        }

        function updateStockInputs() {
            const colors = Array.from(document.querySelectorAll('input[name="colors[]"]')).map(i => i.value.trim()).filter(v => v !== '');
            const sizes = Array.from(document.querySelectorAll('input[name="sizes[]"]')).map(i => i.value.trim()).filter(v => v !== '');

            const stockWrapper = document.getElementById('stock-wrapper');
            stockWrapper.innerHTML = '';

            if (colors.length === 0 || sizes.length === 0) {
                stockWrapper.innerHTML = '<p style="color:gray;">Tambahkan warna dan ukuran terlebih dahulu</p>';
                return;
            }

            colors.forEach(color => {
                const colorDiv = document.createElement('div');
                colorDiv.innerHTML = `<h4 style="margin-top:1rem; color:#8b4513;">Warna: ${color}</h4>`;
                sizes.forEach(size => {
                    const label = document.createElement('label');
                    label.textContent = `Ukuran ${size}: `;
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.name = `stocks[${color}][${size}]`;
                    input.min = 0;
                    input.value = 0;
                    input.required = true;
                    input.className = 'input-attr';
                    label.appendChild(input);
                    colorDiv.appendChild(label);
                    colorDiv.appendChild(document.createElement('br'));
                });
                stockWrapper.appendChild(colorDiv);
            });
        }

        document.getElementById('image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview-image');
            const placeholder = document.querySelector('.image-placeholder');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
        });


        document.querySelector('.image-placeholder').style.display = 'block';
        document.getElementById('colors-wrapper').addEventListener('input', updateStockInputs);
        document.getElementById('sizes-wrapper').addEventListener('input', updateStockInputs);
        window.onload = updateStockInputs;
    </script>

    @include('layouts.footer')

    <!-- Pop Up message -->
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
                title: 'Gagal!',
                text: @json(session('error')),
                confirmButtonColor: '#d33'
            });
        </script>
    @endif


@endsection