<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Method untuk menambah item ke favorit (sudah ada)
    public function store(Request $request)
    {
        $request->validate(['vehicle_id' => 'required|exists:vehicles,id']);

        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'vehicle_id' => $request->vehicle_id,
        ]);

        return back()->with('success', 'Kendaraan telah ditambahkan ke favorit!');
    }

    // Method untuk menghapus item dari favorit (sudah ada)
    public function destroy(Request $request)
    {
        $request->validate(['vehicle_id' => 'required|exists:vehicles,id']);
        
        Favorite::where('user_id', Auth::id())
                ->where('vehicle_id', $request->vehicle_id)
                ->delete();

        return back()->with('success', 'Kendaraan telah dihapus dari favorit.');
    }

    // =======================================================
    // PASTIKAN METHOD INI ADA
    // =======================================================
    /**
     * Mengambil daftar item favorit untuk ditampilkan di panel samping.
     */
    public function getFavoriteItemsForPanel()
    {
        $favoriteItems = Favorite::where('user_id', auth()->id())
                                 ->with('vehicle') // Ambil juga data kendaraannya
                                 ->latest()
                                 ->get();
        return response()->json($favoriteItems);
        
    }
}
