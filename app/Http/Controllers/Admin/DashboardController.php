<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($user->role === 'admins') {
            return redirect()->route('admin.sales');
        } elseif ($user->role === 'users') {
            return redirect()->route('home');
        }

        abort(403);
    }

    public function adminDashboard()
    {
        return view('admin.sales');
    }

    public function userDashboard()
    {
        return view('user.dashboard');
    }
}
