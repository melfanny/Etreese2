<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>User</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Jakarta')->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Jakarta')->format('H:i') }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>
                    @php
                        $produkList = collect($order->checkout_data)->pluck('product_name')->unique()->implode(', ');
                    @endphp
                    {{ $produkList }}
                </td>
                <td>{{ collect($order->checkout_data)->sum('quantity') }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>