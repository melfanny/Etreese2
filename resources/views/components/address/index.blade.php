<style>

  .address-list {
    min-height: calc(60vh - 60px);
    background: #EBC4AE;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .button-new-address {
    background-color: #843902;
    color: #ffffff;
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .button-new-address:hover {
    background-color: #6c2f01;
  }

  .address-card {
    border-left: 4px solid #007bff;
    background-color: #f8f9fa;
    padding: 16px 20px;
    margin-bottom: 16px;
    border-radius: 6px;
  }

  .address-card p {
    margin: 4px 0;
    font-size: 14px;
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
    text-align: center;
    color: #666;
    font-style: italic;
  }

  .button-new-address {
  background-color: #28a745;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
}


.address-card {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 8px;
  margin-top: 15px;
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

.delete-button {
  background-color: #dc3545;
  color: white;
  border: none;
}

</style>
<div class="address-list">
  <div class="address-header">
    <h2>Daftar Alamat</h2>
    
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
    <p class="no-address">Belum ada alamat yang disimpan.</p>
  @endforelse
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




