<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba untuk mengotentikasi pengguna
        if (Auth::attempt($credentials)) {
            // Jika berhasil...
            $request->session()->regenerate(); // Regenerasi session untuk keamanan

            // Panggil method authenticated untuk redirect berdasarkan peran
            return $this->authenticated($request, Auth::user());
        }

        // 3. Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Menangani redirect setelah pengguna berhasil login.
     * Ini adalah logika yang sudah kita bahas sebelumnya.
     */
     protected function authenticated(Request $request, $user)
    {
        // BARIS DEBUG: Hentikan program dan tampilkan peran (role) user
        // dd($user->role); 

        // Kode di bawah ini tidak akan dijalankan sementara
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    /**
     * Menangani permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}