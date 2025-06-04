<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AdminOrderController extends Controller
{
    // Fungsi cek manual role admin
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admins';
    }

    public function index(\Illuminate\Http\Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        // status dari semua order (TIDAK TERPENGARUH FILTER)
        $totalOrders = Order::count();
        $waitingPayment = Order::where('status', 'waiting_payment')->count();
        $paid = Order::where('status', 'paid')->count();
        $processed = Order::where('status', 'processed')->count();
        $shipped = Order::where('status', 'shipped')->count();
        $completed = Order::where('status', 'completed')->count();

        // query untuk tampilan status order (terpengaruh filter)
        $query = Order::with(['user', 'product'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->orWhereHas('user', fn($u) => $u->where('name', 'ILIKE', "%$q%"))
                    ->orWhereHas('product', fn($p) => $p->where('name', 'ILIKE', "%$q%"))
                    ->orWhere('status', 'ILIKE', "%$q%")
                    ->orWhereRaw("to_char(created_at, 'YYYY-MM-DD') ILIKE ?", ["%$q%"])
                    ->orWhereRaw("CAST(total AS TEXT) ILIKE ?", ["%$q%"]);
                if (is_numeric($q)) {
                    $sub->orWhere('id', $q);
                }
            });
        }

        $orders = $query->get();

        // untuk menampilkan badge counter ketika ada order yg masuk sebagai notifikasi
        $newPaidOrdersCount = Order::where('status', 'paid')->count();

        return view('admin.orders', compact(
            'orders',
            'totalOrders',
            'waitingPayment',
            'paid',
            'processed',
            'shipped',
            'completed',
            'newPaidOrdersCount'
        ));
    }

    public function confirmPayment(Order $order)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }
        if ($order->status !== 'paid') {
            return back()->with('error', 'Order belum dibayar!');
        }
        $order->update(['status' => 'processed']);


        // Kirim notifikasi pesanan diproses ke pelanggan
        Notification::create([
            'user_id' => $order->user_id,
            'message' => 'Pesanan Anda sedang diproses dan dikemas.'
        ]);

        return back()->with('success', 'Order diproses (packing)!');
    }

    public function ship(Order $order)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }
        if ($order->status !== 'processed') {
            return back()->with('error', 'Order belum diproses!');
        }
        $order->update(['status' => 'shipped']);

        // Kirim notifikasi pesanan sudah dikirim ke pelanggan
        Notification::create([
            'user_id' => $order->user_id,
            'message' => 'Pesanan Anda telah dikirim. Harap menunggu kedatangan paket Anda.'
        ]);

        return back()->with('success', 'Order dikirim!');
    }
}