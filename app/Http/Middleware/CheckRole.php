<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles   // Kita akan mengirim peran yang diizinkan ke sini
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika pengguna tidak login atau perannya tidak termasuk dalam peran yang diizinkan
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Tolak akses. Pengguna akan melihat halaman 403 Forbidden.
            abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK AKSES.');
        }

        // Jika peran sesuai, lanjutkan ke halaman yang dituju.
        return $next($request);
    }
}