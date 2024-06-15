<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KaryawanPelaksana;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class KaryawanPelaksanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jenisKelamin = $request->get('jenis_kelamin');
            $jabatan = $request->get('jabatan');

            // Cache key yang unik berdasarkan filter
            $cacheKey = 'karyawan_pelaksana_data';

            // Query data dengan cache
            $karyawanPelaksanaData = Cache::remember($cacheKey, 60, function() use ($jenisKelamin, $jabatan) {
                $query = KaryawanPelaksana::query()
                    ->select('NIK', 'NIKSAP', 'NAMA', 'JABATAN', 'KELAMIN', 'BIDANG', 'noPhone')
                    ->where('MBT', '')
                    ->where('PENS', '');

                // Tambahkan filter jenis kelamin jika ada
                if ($jenisKelamin) {
                    $query->where('KELAMIN', $jenisKelamin);
                }

                // Tambahkan filter jabatan jika ada
                if ($jabatan) {
                    $query->where('JABATAN', $jabatan);
                }

                return $query->get();
            });

            return DataTables::of($karyawanPelaksanaData)->make(true);
        }

        $jabatanList = KaryawanPelaksana::select('JABATAN')
            ->where('MBT', '')
            ->where('PENS', '')
            ->distinct()
            ->pluck('JABATAN');
        return view('admin.list-karyawan-pelaksana', compact('jabatanList'));
    }

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $cacheKey = 'karyawan_pelaksana_datatable_data'; // Unique cache key

    //         $data = Cache::remember($cacheKey, 60, function () { // Cache for 60 minutes
    //             $query = KaryawanPelaksana::query()
    //                 ->where('MBT', '')
    //                 ->where('PENS', '');

    //             return DataTables::of($query)->make(true);
    //         });

    //         return $data;
    //     }

    //     return view('admin.list-karyawan-pelaksana');
    // }

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
