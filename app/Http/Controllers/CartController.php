<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function getCartItemsForPanel()
    {
    $cartItems = \App\Models\Cart::where('user_id', auth()->id())->with('vehicle')->latest()->get();
    return response()->json($cartItems);
    }
    
    public function __construct()
    {
        // Memastikan hanya user yang sudah login yang bisa mengakses fitur ini
        $this->middleware('auth');
    }
    /**
     * Menyimpan item baru ke dalam keranjang belanja.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate(['vehicle_id' => 'required|exists:vehicles,id']);

        // Cek apakah item sudah ada di keranjang untuk mencegah duplikasi
        $existingCartItem = Cart::where('user_id', Auth::id())
                                ->where('vehicle_id', $request->vehicle_id)
                                ->first();

        if ($existingCartItem) {
            // Jika sudah ada, kembali dengan pesan error
            return back()->with('error', 'Kendaraan ini sudah ada di keranjang Anda.');
        }

        // Jika belum ada, tambahkan item baru ke keranjang
        Cart::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $request->vehicle_id,
        ]);

        // Redirect ke halaman keranjang (dashboard user) dengan pesan sukses
        return redirect()->route('user.dashboard')->with('success', 'Kendaraan berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus item dari keranjang belanja.
     */
    public function destroy(Cart $cart)
    {
        // Keamanan: Pastikan user hanya bisa menghapus item miliknya sendiri
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $cart->delete();

        return back()->with('success', 'Kendaraan berhasil dihapus dari keranjang.');
    }
}