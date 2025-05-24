<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    // Fungsi cek manual admin
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admins';
    }

    public function index(\Illuminate\Http\Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        // Statistik dari semua order (TIDAK TERPENGARUH FILTER)
        $totalOrders = Order::count();
        $waitingPayment = Order::where('status', 'waiting_payment')->count();
        $paid = Order::where('status', 'paid')->count();
        $processed = Order::where('status', 'processed')->count();
        $shipped = Order::where('status', 'shipped')->count();
        $completed = Order::where('status', 'completed')->count();

        // Query untuk tampilan (boleh difilter)
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

        return view('admin.orders', compact(
            'orders',
            'totalOrders',
            'waitingPayment',
            'paid',
            'processed',
            'shipped',
            'completed'
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
        return back()->with('success', 'Order dikirim!');
    }
}