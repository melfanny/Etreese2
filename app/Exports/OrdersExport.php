<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::with('user')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                return [
                    'ID' => $order->id,
                    'Tanggal' => $order->created_at->timezone('Asia/Jakarta')->format('d-m-Y'),
                    'Waktu' => $order->created_at->timezone('Asia/Jakarta')->format('H:i'),
                    'User' => $order->user->name ?? '-',
                    'Produk' => collect($order->checkout_data)->pluck('product_name')->unique()->implode(', '),
                    'Jumlah' => collect($order->checkout_data)->sum('quantity'),
                    'Total' => $order->total,
                    'Status' => $order->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Waktu',
            'User',
            'Produk',
            'Jumlah',
            'Total',
            'Status',
        ];
    }
}
