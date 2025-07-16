<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman checkout dengan ringkasan item dari keranjang.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('vehicle')->get();

        // Jika keranjang kosong, jangan biarkan masuk ke checkout
        if ($cartItems->isEmpty()) {
            return redirect()->route('vehicles.index')->with('info', 'Keranjang Anda kosong. Silakan pilih kendaraan terlebih dahulu.');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->vehicle->price;
        });

        return view('checkout.index', compact('cartItems', 'totalAmount'));
    }

    // Method untuk memproses pesanan dan membuat transaksi
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('vehicle')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total harga
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->vehicle->price;
        });

        // Buat transaksi baru
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'invoice_number' => 'PMM-' . strtoupper(Str::random(10)),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Simpan setiap item keranjang ke dalam transaction_items
        foreach ($cartItems as $item) {
            $transaction->items()->create([
                'vehicle_id' => $item->vehicle_id,
                'vehicle_title' => $item->vehicle->title,
                'price' => $item->vehicle->price,
            ]);
            // Hapus item dari keranjang
            $item->delete();
        }

        // TODO: Integrasi dengan Payment Gateway di sini

        // Untuk sekarang, kita arahkan ke halaman "Pesanan Saya"
        return redirect()->route('user.orders')->with('success', 'Pesanan Anda berhasil dibuat! Silakan lanjutkan pembayaran.');
    }
}
