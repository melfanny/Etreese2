@extends('layouts.app_admin')

@section('content')
    <style>
        .sales-container {
            background-color: #EBC4AE;
            min-height: 100vh;
        }

        .section-title {
            background: #fff;
            border-radius: 6px;
            padding: 10px 18px;
            font-size: 1.1rem;
            color: #b36b2c;
            font-weight: 600;
            border: 1px solid #e5c7b0;
            box-shadow: 0 1px 4px #f3e5d7;
            margin-bottom: 18px;
            display: inline-block;
        }

        .dashboard-container {
            padding: 32px 32px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding: 24px 0 10px 0;
        }

        .dashboard-header h2 {
            font-size: 2.1rem;
            font-weight: bold;
            color: #884F22;
            letter-spacing: 1px;
        }

        .filter-group,
        form[method="GET"] {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 18px;
            margin-top: 18px;
        }

        .filter-btn {
            padding: 7px 18px;
            border-radius: 8px;
            border: 1.5px solid #d1bfa3;
            background: #fff7f0;
            color: #884F22;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.18s, color 0.18s, border 0.18s;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: #ffe3c2;
            color: #b36b2c;
            border-color: #b36b2c;
        }

        .orderModal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.3);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .orderModal.active {
            display: flex !important;
        }

        .period-box {
            background: #fff;
            border-radius: 6px;
            padding: 10px 18px;
            font-size: 1.1rem;
            color: #b36b2c;
            font-weight: 600;
            border: 1px solid #e5c7b0;
            box-shadow: 0 1px 4px #f3e5d7;
            margin-bottom: 18px;
            display: inline-block;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            width: 100%;
            margin-bottom: 32px;
        }

        .product-card {
            background: linear-gradient(120deg, #fff7f0 60%, #f3e5d7 100%);
            border-radius: 16px;
            box-shadow: 0 3px 12px rgba(136, 79, 34, 0.08), 0 1px 3px #e5c7b0;
            overflow: hidden;
            text-align: left;
            border: 1px solid #e5c7b0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .img-wrapper {
            width: 100%;
            max-width: 160px;
            aspect-ratio: 1/1;
            background: #f3e5d7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            padding: 8px;
        }

        .product-card h3 {
            font-size: 1.1rem;
            color: #884F22;
            margin: 12px 0 4px 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .product-card .period-box {
            margin-bottom: 8px;
            font-size: 1rem;
            padding: 5px 10px;
        }

        .product-card .price {
            color: #b36b2c;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .product-card .qty {
            color: #1b7f3a;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0;
        }

        .product-details {
            margin-top: 8px;
            background: #fff7f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.9rem;
            width: 100%;
        }

        .product-details ul {
            margin: 0;
            padding-left: 16px;
        }

        .product-details li {
            margin-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 4px #f3e5d7;
        }

        .table-scroll {
            max-height: 350px;
            overflow-y: auto;
            overflow-x: auto;
            display: block;
        }

        .table-scroll table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-scroll thead th {
            position: sticky;
            top: 0;
            background: #ffe3c2;
            z-index: 10;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 4px #f3e5d7;
        }

        th,
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5c7b0;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #ffe3c2;
            color: #884F22;
            font-weight: bold;
            cursor: pointer;
            position: relative;
            user-select: none;
        }

        .sort-icon {
            margin-left: 6px;
            font-size: 0.7em;
            color: #b36b2c;
        }

        th.sorted-asc .sort-icon::after {
            content: "▲";
        }

        th.sorted-desc .sort-icon::after {
            content: "▼";
        }

        tr:last-child td {
            border-bottom: none;
        }

        @media (max-width: 900px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .img-wrapper {
                max-width: 100%;
            }
        }
    </style>
    <!-- Modal popup detail transaksi -->
    <div id="orderModal" class="orderModal"
        style="display:none; position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:9999; align-items:center; justify-content:center;">
        <div id="orderModalBox"
            style="background:#fff; border-radius:10px; padding:24px; min-width:320px; max-width:90vw; position:relative;">
            <button onclick="closeOrderModal()"
                style="position:absolute; right:16px; top:12px; background:none; border:none; font-size:1.5rem; color:#b36b2c;">&times;</button>
            <h4 style="color:#884F22; margin-bottom:12px;">Detail Transaksi</h4>
            <div id="orderDetailContent"></div>
        </div>
    </div>
    <script>
        function showOrderDetail(orderId, data) {
            if (!Array.isArray(data)) data = [];
            let total = 0;
            let html = `
                                                                                                                                                                                                                         <div style="max-width:350px;margin:0 auto;padding:8px 0;">
                                                                                                                                                                                                                             <div style="text-align:center;font-weight:bold;font-size:1.2rem;color:#884F22;margin-bottom:6px;">DETAIL PEMBELIAN</div>
                                                                                                                                                                                                                             <div style="font-size:0.98rem;margin-bottom:8px;">
                                                                                                                                                                                                                                 <b>ID Order:</b> ${orderId}<br>
                                                                                                                                                                                                                                 <b>Tanggal:</b> ${new Date().toLocaleDateString('id-ID')}
                                                                                                                                                                                                                             </div>
                                                                                                                                                                                                                             <table style="width:100%;border-collapse:collapse;font-size:0.98rem;">
                                                                                                                                                                                                                                 <thead>
                                                                                                                                                                                                                                     <tr style="border-bottom:1px solid #e5c7b0;">
                                                                                                                                                                                                                                         <th style="text-align:left;">Produk</th>
                                                                                                                                                                                                                                         <th style="text-align:center;">Jumlah</th>
                                                                                                                                                                                                                                         <th style="text-align:right;">Harga</th>
                                                                                                                                                                                                                                         <th style="text-align:right;">Subtotal</th>
                                                                                                                                                                                                                                     </tr>
                                                                                                                                                                                                                                 </thead>
                                                                                                                                                                                                                                 <tbody>
                                                                                                                                                                                                                         `;
            data.forEach(item => {
                let subtotal = (item.price ?? 0) * (item.quantity ?? 0);
                total += subtotal;
                html += `
                                                                                                                                                                                                                             <tr>
                                                                                                                                                                                                                                 <td>
                                                                                                                                                                                                                                     ${item.product_name ?? '-'}
                                                                                                                                                                                                                                     ${item.size ? `<br><span style="font-size:0.9em;color:#b36b2c;">Ukuran: ${item.size}</span>` : ''}
                                                                                                                                                                                                                                     ${item.color ? `<br><span style="font-size:0.9em;color:#b36b2c;">Warna: ${item.color}</span>` : ''}
                                                                                                                                                                                                                                     ${item.catatan ? `<br><span style="font-size:0.9em;color:#884F22;">Catatan: ${item.catatan}</span>` : ''}
                                                                                                                                                                                                                                 </td>
                                                                                                                                                                                                                                 <td style="text-align:center;">${item.quantity ?? '-'}</td>
                                                                                                                                                                                                                                 <td style="text-align:right;">Rp${Number(item.price ?? 0).toLocaleString('id-ID')}</td>
                                                                                                                                                                                                                                 <td style="text-align:right;">Rp${subtotal.toLocaleString('id-ID')}</td>
                                                                                                                                                                                                                             </tr>
                                                                                                                                                                                                                         `;
            });
            html += `
                                                                                                                                                                                                                                    </tbody>
                                                                                                                                                                                                                                </table>
                                                                                                                                                                                                                                <div style="border-top:1px dashed #b36b2c;margin:12px 0 4px 0;"></div>
                                                                                                                                                                                                                                <div style="text-align:right;font-weight:bold;font-size:1.08rem;">
                                                                                                                                                                                                                                    Total: Rp${total.toLocaleString('id-ID')}
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            `;
            document.getElementById('orderDetailContent').innerHTML = html;
            document.getElementById('orderModal').style.display = 'flex';
        }
        function closeOrderModal() {
            document.getElementById('orderModal').style.display = 'none';
        }
        document.getElementById('orderModal').addEventListener('click', function (event) {
            if (event.target === this) closeOrderModal();
        });
    </script>

    <script>
        let sortDirection = {}; // Untuk menyimpan arah sort per kolom

        function sortTable(colIndex) {
            const table = document.querySelector("table tbody").parentElement;
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            // Tentukan arah sort
            sortDirection[colIndex] = !sortDirection[colIndex];

            rows.sort((a, b) => {
                let aText = a.children[colIndex].textContent.trim();
                let bText = b.children[colIndex].textContent.trim();

                // Coba convert ke angka jika memungkinkan
                const aNum = parseFloat(aText.replace(/[^\d.-]/g, '').replace(',', '.'));
                const bNum = parseFloat(bText.replace(/[^\d.-]/g, '').replace(',', '.'));

                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return sortDirection[colIndex] ? aNum - bNum : bNum - aNum;
                }

                // Jika berupa tanggal (format dd-mm-yyyy), ubah ke objek Date
                if (/\d{2}-\d{2}-\d{4}/.test(aText)) {
                    const [dayA, monthA, yearA] = aText.split('-').map(Number);
                    const [dayB, monthB, yearB] = bText.split('-').map(Number);
                    const dateA = new Date(yearA, monthA - 1, dayA);
                    const dateB = new Date(yearB, monthB - 1, dayB);
                    return sortDirection[colIndex] ? dateA - dateB : dateB - dateA;
                }

                // Jika berupa teks biasa
                return sortDirection[colIndex]
                    ? aText.localeCompare(bText)
                    : bText.localeCompare(aText);
            });

            // Masukkan ulang hasil sort ke tbody
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>


    <div class="sales-container">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h2>Rekap Penjualan</h2>
            </div>
            <div class="period-box" style="margin-top: 30px;">
                <i class="fas fa-folder-open" style="color:#b36b2c; margin-right:8px;"></i>
                Rekap Produk Terjual
            </div>
            <form method="GET">
                <input type="date" name="start" value="{{ request('start') }}">
                <input type="date" name="end" value="{{ request('end') }}">
                <button type="submit" name="period" value="custom"
                    class="filter-btn {{ $currentPeriod == 'custom' ? 'active' : '' }}">Custom</button>
            </form>
            <div class="period-box">
                <b>Total Pemasukan:</b> Rp{{ number_format($totalOmzet, 0, ',', '.') }}
            </div>
            <div class="product-grid">
                @foreach($salesData as $product)
                    <div class="product-card">
                        <div class="img-wrapper">
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}">
                        </div>
                        <h3>{{ $product['name'] }}</h3>
                        <div class="period-box">
                            <span class="stat-label">Total Pembelian:</span>
                            <span class="stat-value">{{ $product['total_sales'] }} produk</span>
                        </div>
                        <div class="price">Pemasukan: Rp{{ number_format($product['total_income'], 0, ',', '.') }}</div>
                        <div class="product-details">
                            <b>Detail:</b>
                            <ul style="list-style: none; padding-left: 0; margin-top: 8px;">
                                @foreach($product['variant_details'] as $variant)
                                    @if($variant === '')
                                        <li style="margin: 4px 0;"></li>
                                    @elseif(strpos($variant, '<b>') === 0)
                                        <li style="margin: 8px 0 4px 0; color: #884F22;">{!! $variant !!}</li>
                                    @else
                                        <li style="margin: 2px 0; color: #b36b2c;">{!! $variant !!}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="section-title" style="margin-top:32px;">
                <i class="fas fa-chart-line" style="color:#b36b2c; margin-right:8px;"></i>
                Grafik Penjualan
            </div>
            <canvas id="salesChart" height="60"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('salesChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, '#ffb347');
                gradient.addColorStop(1, '#ffcc80');
                const salesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabels ?? []),
                        datasets: [{
                            label: 'Jumlah Produk Terjual',
                            data: @json($chartValues ?? []),
                            backgroundColor: gradient,
                            borderColor: '#b36b2c',
                            borderWidth: 2,
                            borderRadius: 8,
                            maxBarThickness: 40,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return 'Terjual: ' + context.parsed.y + ' produk';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#b36b2c', font: { weight: 'bold' } }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#ffe3c2' },
                                ticks: { color: '#b36b2c' }
                            }
                        }
                    }
                });
            </script>

            <div class="period-box" style="margin-top: 30px;">
                <i class="fas fa-list-alt" style="color:#b36b2c;"></i>
                <span>Daftar Transaksi</span>
            </div>

            <div class="period-box" style="margin-bottom: 30px;">
                <i class="fas fa-file-excel" style="font-size: 20px; color: #1f8c36;"></i>
                <a href="{{ url('/admin/transactions/export') }}" class="px-4 py-2 bg-white">
                    Download Excel
                </a>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">ID <span class="sort-icon"></span></th>
                            <th onclick="sortTable(1)">Tanggal <span class="sort-icon"></span></th>
                            <th onclick="sortTable(2)">Waktu <span class="sort-icon"></span></th>
                            <th onclick="sortTable(3)">User <span class="sort-icon"></span></th>
                            <th onclick="sortTable(4)">Produk <span class="sort-icon"></span></th>
                            <th onclick="sortTable(5)">Jumlah <span class="sort-icon"></span></th>
                            <th onclick="sortTable(6)">Total <span class="sort-icon"></span></th>
                            <th onclick="sortTable(7)">Status <span class="sort-icon"></span></th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($allOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->timezone('Asia/Jakarta')->format('d-m-Y') }}</td>
                                <td>{{ $order->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</td>
                                <td>{{ $order->user->name ?? '-' }}</td>
                                <td>
                                    @php
                                        $produkList = collect($order->checkout_data)->pluck('product_name')->unique()->implode(', ');
                                    @endphp
                                    {{ $produkList }}
                                </td>
                                <td>{{ collect($order->checkout_data)->sum('quantity') }}</td>
                                <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <button class="filter-btn"
                                        onclick='showOrderDetail("{{ $order->id }}", @json($order->checkout_data))'>
                                        Lihat Detail
                                    </button>
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection