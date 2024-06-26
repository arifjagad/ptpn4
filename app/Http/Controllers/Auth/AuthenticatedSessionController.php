<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\KaryawanPelaksana;
use App\Models\KaryawanPimpinan;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        if (Session::get('isKaryawanPimpinan')) {
            $user = 6; // Akun karyawan pimpinan
            Auth::loginUsingId($user);
            $nik = Session::get('nik');
            $user = KaryawanPimpinan::where('NIK', $nik)->first();
            return redirect('/karyawan/dashboard');
        }

        if (Session::get('isKaryawanPelaksana')) {
            $user = 7; // Akun karyawan pelaksana
            Auth::loginUsingId($user);
            $nik = Session::get('nik');
            $user = KaryawanPelaksana::where('NIK', $nik)->first();
            return redirect('/karyawan/dashboard');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
