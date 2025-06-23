<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart; // 1. Import model Cart yang sudah kita buat

class DashboardController extends Controller
{
    public function index()
    {
        // 2. Ambil semua item keranjang milik user yang sedang login
        //    Gunakan 'with('vehicle')' untuk mengambil data kendaraan terkait
        //    secara efisien (menghindari N+1 query problem).
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('vehicle')
                         ->latest()
                         ->get();

        // 3. Kirim data '$cartItems' yang sudah berisi data asli ke view
        return view('user.dashboard', compact('cartItems'));
    }
}
