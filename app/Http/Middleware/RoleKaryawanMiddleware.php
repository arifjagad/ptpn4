<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleKaryawanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna sudah login dan memiliki role karyawan
        if (Auth::check() && Auth::user()->user_type === 'karyawan') {
            return $next($request);
        }

        // Jika tidak, arahkan ke halaman 403 atau halaman lain yang diinginkan
        return abort(403, 'Unauthorized action.');
    }
}
