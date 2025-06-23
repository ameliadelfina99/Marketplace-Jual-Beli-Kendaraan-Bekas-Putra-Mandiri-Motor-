<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{ // <-- Kurung kurawal PEMBUKA untuk class

    public function index()
    {
        // Ambil semua data kendaraan, yang terbaru di atas,
    // beserta data relasi kategori dan brand untuk efisiensi.
    $vehicles = \App\Models\Vehicle::with(['category', 'brand', 'user'])->latest()->get();

    // Kirim data ke view
    return view('admin.dashboard', compact('vehicles'));
    }

    // Jika ada fungsi lain, letakkan di sini

} // <-- (SANGAT MUNGKIN) Kurung kurawal PENUTUP ini yang HILANG di kode Anda