<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fungsi ini untuk halaman katalog publik, sudah benar.
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        $query = Vehicle::with(['user', 'category', 'brand'])
                            ->where('is_published', true);

        // ... (semua logika filter Anda tetap di sini, sudah bagus)

        $vehicles = $query->latest()->paginate(12)->appends($request->query());

        return view('vehicles.index', compact('vehicles', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     * HANYA BISA DIAKSES ADMIN
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('vehicles.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     * HANYA BISA DIAKSES ADMIN
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'model' => 'required|string|max:100',
            // ... (validasi lainnya tetap sama)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();
        // Saat admin membuat iklan, user_id bisa di-set ke ID admin itu sendiri
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vehicles', 'public');
            $data['image'] = $path;
        }

        Vehicle::create($data);

        // Redirect ke dashboard admin dengan pesan sukses
        return redirect()->route('admin.dashboard')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        // Fungsi ini untuk halaman detail publik, sudah benar.
        $vehicle->load(['user', 'category', 'brand']);

        if (!$vehicle->is_published && (!Auth::check() || Auth::id() !== $vehicle->user_id)) {
            abort(404);
        }
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     * HANYA BISA DIAKSES ADMIN
     */
    public function edit(Vehicle $vehicle)
    {
        // === PERBAIKAN DI SINI ===
        // Pengecekan kepemilikan dihapus karena rute ini sudah dilindungi middleware admin.
        // Admin boleh mengedit semua kendaraan.

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('vehicles.edit', compact('vehicle', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     * HANYA BISA DIAKSES ADMIN
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        // === PERBAIKAN DI SINI ===
        // Pengecekan kepemilikan dihapus. Admin boleh mengupdate semua kendaraan.
        
        $request->validate([
            'title' => 'required|string|max:255',
            // ... (validasi lainnya tetap sama)
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $path = $request->file('image')->store('vehicles', 'public');
            $data['image'] = $path;
        }

        $vehicle->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * HANYA BISA DIAKSES ADMIN
     */
    public function destroy(Vehicle $vehicle)
    {
        // === PERBAIKAN DI SINI ===
        // Pengecekan kepemilikan dihapus. Admin boleh menghapus semua kendaraan.

        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }

        $vehicle->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
