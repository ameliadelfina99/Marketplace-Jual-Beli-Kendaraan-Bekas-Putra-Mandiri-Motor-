<?php

use Illuminate\Support\Facades\Route;
// ... (Import semua controller Anda)
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController; // Kita akan ganti ini nanti
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController; // Jangan lupa import
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\User\OrderController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses semua orang)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
// Fitur: Melihat daftar & mencari produk
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
// Fitur: Melihat detail produk
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
// ... (di bawah rute 'home' atau 'vehicles.index')
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PageController::class, 'sendContactForm'])->name('contact.send');


/*
|--------------------------------------------------------------------------
| Rute Otentikasi
|--------------------------------------------------------------------------
*/
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


/*
|--------------------------------------------------------------------------
| Grup Rute untuk ADMIN (Mengelola Semua Produk)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // SEMUA RUTE PENGELOLAAN KENDARAAN PINDAH KE SINI
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
});
/*
|--------------------------------------------------------------------------
| Grup Rute untuk USER PEMBELI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard'); 
    
    // Rute untuk Keranjang (sudah ada)
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/items', [CartController::class, 'getCartItemsForPanel'])->name('cart.items');

    // =======================================================
    // ROUTE TAMBAH FAVORITE
    // =======================================================
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/favorites/items', [FavoriteController::class, 'getFavoriteItemsForPanel'])->name('favorites.items');
    
    // RUTE BARU UNTUK CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // RUTE BARU UNTUK HALAMAN PESANAN SAYA
    Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('user.orders');
});