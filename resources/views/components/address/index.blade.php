<style>
  .body {
    background-color: #EBC4AE;
    margin: 0;
    padding: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }

  .body p {
    font-size: 18px;
    color: #FFFBEF;
    margin-bottom: 20px;
  }

  .address-list {
    background: #8B4513;
    border-radius: 10px;
    width: 100%;
    max-width: 800px;
    padding: 24px;
    height: auto;
  }

  .address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .button-new-address {
    background: #EBC4AE;
    color: #8B4513;
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    height: fit-content;
  }

  .button-new-address:hover {
    background: #6a2e02;
    color: #FFFBEF;
  }

  .address-card {
    background-color: #FFFBEF;
    padding: 16px 20px;
    margin-bottom: 16px;
    border-radius: 6px;
  }

  .address-card p {
    margin: 4px 0;
    font-size: 15px;
    color: #333;
  }

  .alert-success {
    background-color: #d4edda;
    color: #155724;
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 16px;
    border: 1px solid #c3e6cb;
  }

  .no-address {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #FFFBEF;
    font-size: 15px;
    padding-bottom: 20px;
  }

  .address-actions {
    margin-top: 10px;
  }

  .edit-button,
  .delete-button {
    display: inline-block;
    padding: 6px 10px;
    margin-right: 5px;
    border-radius: 4px;
    font-size: 0.9rem;
  }

  .edit-button {
    background-color: #007bff;
    color: white;
    text-decoration: none;
  }

  .edit-button:hover {
    background-color: #0056b3;
  }

  .delete-button {
    background-color: #dc3545;
    color: white;
    border: none;
  }

  .delete-button:hover {
    background-color: #c82333;
  }
</style>
<section class="body">
  <div class="address-list">
    <div class="address-header">
      <p>Alamat Saya</p>
      <!-- Tampilkan tombol tambah jika belum ada alamat -->
      @if ($addresses->count() == 0)
      <a href="{{ route('addresses.create') }}">
      <button class="button-new-address">+ Tambah Alamat Baru</button>
      </a>
    @endif
    </div>

    <!-- Tampilkan alamat yang sudah dibuat atau diupdate oleh user (yang berhasil tersimpan di database) -->
    @forelse ($addresses as $address)
    <div class="address-card">
      <p><strong>{{ $address->recipient_name }}</strong> &bull; {{ $address->phone }}</p>
      <p>{{ $address->address }}</p>
      <p>{{ $address->city_type }} {{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</p>

      <!-- Mengubah alamat -->
      <div class="address-actions">
      <a href="{{ route('addresses.edit', $address->id) }}" class="edit-button">Edit</a>

      <!-- Menghapus alamat -->
      <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">Delete</button>
      </form>
      </div>
    </div>
    <!-- Tampilkan teks ini jika tidak ada alamat  -->
  @empty
    <div class="no-address">Belum ada alamat yang disimpan.</div>
  @endforelse
  </div>
</section>
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