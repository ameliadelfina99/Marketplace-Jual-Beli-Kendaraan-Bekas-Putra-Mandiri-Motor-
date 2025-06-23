<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;  // Pastikan Anda meng-import model Vehicle
use App\Models\Category; // Pastikan Anda meng-import model Category

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (beranda).
     */
    public function index()
    {
        // Ambil data yang dibutuhkan untuk halaman beranda
        $categories = Category::all();
        $vehicles = Vehicle::latest()->take(6)->get(); // Contoh: ambil 6 kendaraan terbaru

        // Kirim data ke view 'index.blade.php'
        return view('dashboard', compact('vehicles', 'categories'));
    }
}