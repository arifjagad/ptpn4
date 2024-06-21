<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\KaryawanPelaksana;
use App\Models\KaryawanPimpinan;
use App\Models\Mobil;
use App\Models\Mandor;
use App\Models\Supir;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        /* $jumlahKaryawan = Karyawan::count() +
            KaryawanPelaksana::where('MBT', '')->where('PENS', '')->count() +
            KaryawanPimpinan::where('MBT', '')->where('PENS', '')->count(); */
        $jumlahKaryawan = Karyawan::count();
        $jumlahMobil = Mobil::count();
        $jumlahMandor = Mandor::count();
        $jumlahSupir = Supir::count();

        return view(
            'admin.dashboard', 
            compact(
                'jumlahKaryawan', 
                'jumlahMobil', 
                'jumlahMandor', 
                'jumlahSupir')
            );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
