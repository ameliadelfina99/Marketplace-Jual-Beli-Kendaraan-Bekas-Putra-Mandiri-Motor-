<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Method untuk menampilkan daftar pesanan pengguna
    public function index()
    {
        // Ambil semua transaksi milik user yang sedang login
        $orders = \App\Models\Transaction::where('user_id', Auth::id())
                                         ->latest()
                                         ->get();
        
        return view('user.orders', compact('orders'));
    }
}