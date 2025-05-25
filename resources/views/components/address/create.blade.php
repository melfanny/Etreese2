<style>
  .address-section {
    background-color: #EBC4AE;
    padding: 30px;
  }

  .button-save {
      margin: 30px;
      padding: 10px 15px;
      background: #8B4513;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
  }

  .autocomplete-box {
    border: 1px solid #ccc;
    display: none;
    max-height: 200px;
    overflow-y: auto;
    background: #fff;
    position: absolute;
    z-index: 1000;
    width: 100%;
  }
  .autocomplete-box div {
    padding: 6px 10px;
    cursor: pointer;
  }
  .autocomplete-box div:hover {
    background-color: #f0f0f0;
  }

  .autocomplete-wrapper {
      position: relative;
      margin-left: 30px;
      margin-bottom: 20px;
  }

  .input-box {
    width: 95%;
    padding: 8px;
  }

  .input-title {
    margin-left: 30px;
    display: block;
    margin-bottom: 5px;
  }

  .form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
  margin-left: 30px;
  width: 90%;
`}
</style>

<section class="address-section">
  <form action="{{ route('addresses.store') }}" method="POST">
    @csrf

    <!-- Form pembuatan alamat baru (field kosong semua) -->
     
    <label class="input-title">Nama Penerima</label>
    <input type="text" name="recipient_name" class="input-box" required>

    <label class="input-title">No. HP</label>
    <input type="text" name="phone" class="input-box" required>

    <label class="input-title" for="province-search">Provinsi</label>
    <div class="autocomplete-wrapper">
      <input class="input-box" type="text" id="province-search" autocomplete="off" placeholder="Ketik nama provinsi..." required>
      <input type="hidden" name="province_id" id="province-id">
      <input type="hidden" name="province" id="province-name">
      <div id="province-suggestions" class="autocomplete-box"></div>
    </div>

    <label class="input-title" for="regency-search">Kota / Kabupaten</label>
    <div class="autocomplete-wrapper">
      <input class="input-box" type="text" id="regency-search" autocomplete="off" placeholder="Ketik nama kota..." required>
      <input type="hidden" name="city_id" id="city-id">
      <input type="hidden" name="city" id="city-name">
      <input type="hidden" name="city_type" id="city-type">
      <div id="regency-suggestions" class="autocomplete-box"></div>
    </div>

    <label class="input-title">Kode Pos</label>
    <input type="text" name="postal_code" class="input-box" required>

    <label class="input-title">Alamat Lengkap</label>
    <textarea name="address" class="input-box" rows="4" required></textarea>

    <button class="button-save" type="submit">Simpan Alamat</button>
  </form>
</section>


<script>
document.addEventListener('DOMContentLoaded', async function () {
  const provinces = await fetch('/json/provinces.json').then(res => res.json());
  const regencies = await fetch('/json/regencies.json').then(res => res.json());

  function setupAutocomplete(inputId, suggestionId, dataList, onSelect) {
    const input = document.getElementById(inputId);
    const suggestionBox = document.getElementById(suggestionId);

    input.addEventListener('input', function () {
      const query = input.value.toLowerCase().trim();
      suggestionBox.innerHTML = '';
      if (query.length < 2) {
        suggestionBox.style.display = 'none';
        return;
      }

      const filtered = dataList.filter(item => {
        return (item.name || item.regency).toLowerCase().includes(query);
      });

      filtered.forEach(item => {
        const div = document.createElement('div');
        const label = item.name || `${item.type} ${item.regency}`;
        div.textContent = label;
        div.addEventListener('click', function () {
          onSelect(item);
          input.value = label;
          suggestionBox.innerHTML = '';
          suggestionBox.style.display = 'none';
        });
        suggestionBox.appendChild(div);
      });

      suggestionBox.style.display = filtered.length ? 'block' : 'none';
    });

    document.addEventListener('click', function(e) {
      if (!suggestionBox.contains(e.target) && e.target !== input) {
        suggestionBox.innerHTML = '';
        suggestionBox.style.display = 'none';
      }
    });
  }

  // Provinsi
  setupAutocomplete('province-search', 'province-suggestions', provinces, function (selected) {
    document.getElementById('province-id').value = selected.id;
    document.getElementById('province-name').value = selected.name;

    // Reset kota saat provinsi dipilih
    document.getElementById('regency-search').value = '';
    document.getElementById('city-id').value = '';
    document.getElementById('city-name').value = '';
    document.getElementById('city-type').value = '';

    const filteredRegencies = regencies.filter(r => r.province_id === parseInt(selected.id));
    setupAutocomplete('regency-search', 'regency-suggestions', filteredRegencies, function (selectedCity) {
      const cityFullName = `${selectedCity.type} ${selectedCity.regency}`;
      document.getElementById('city-id').value = selectedCity.id;
      document.getElementById('city-name').value = selectedCity.regency;
      document.getElementById('city-type').value = selectedCity.type;
      document.getElementById('regency-search').value = cityFullName;
    });
  });

  // Setup kota awal kosong
  setupAutocomplete('regency-search', 'regency-suggestions', [], function (selected) {
    const cityFullName = `${selected.type} ${selected.regency}`;
    document.getElementById('city-id').value = selected.id;
    document.getElementById('city-name').value = selected.regency;
    document.getElementById('city-type').value = selected.type;
    document.getElementById('regency-search').value = cityFullName;
  });
});

document.querySelector('form').addEventListener('submit', function (e) {
  const provId = document.getElementById('province-id').value;
  const cityId = document.getElementById('city-id').value;

  if (!provId || !cityId) {
    e.preventDefault();
    alert("Silakan pilih Provinsi dan Kota dari daftar yang muncul.");
  }
});

// debugging untuk memastikan json terbasa di console
// document.querySelector('form').addEventListener('submit', function (e) {
//   console.log("Province ID:", document.getElementById('province-id').value);
//   console.log("Province Name:", document.getElementById('province-name').value);
//   console.log("City ID:", document.getElementById('city-id').value);
//   console.log("City Name:", document.getElementById('city-name').value);
//   console.log("City Type:", document.getElementById('city-type').value);
// });

</script>

