<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KaryawanPimpinan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class KaryawanPimpinanController extends Controller
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
            $cacheKey = 'karyawan_pimpinan_data_' . ($jenisKelamin ?? 'all') . '_' . ($jabatan ?? 'all');

            // Query data dengan cache
            $karyawanPimpinanData = Cache::remember($cacheKey, 60, function() use ($jenisKelamin, $jabatan) {
                $query = KaryawanPimpinan::query()
                    ->select('NIK', 'NIKSAP', 'NAMA', 'JABATAN', 'KELAMIN', 'BIDANG', 'hp')
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

            return DataTables::of($karyawanPimpinanData)->make(true);
        }

        $jabatanList = KaryawanPimpinan::select('JABATAN')
            ->where('MBT', '')
            ->where('PENS', '')
            ->distinct()
            ->pluck('JABATAN');
        return view('admin.list-karyawan-pimpinan', compact('jabatanList'));
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
