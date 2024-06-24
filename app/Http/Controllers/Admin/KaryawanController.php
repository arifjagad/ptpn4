<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $jenisKelamin = $request->get('jenis_kelamin');

            // Cache 60 menit
            $cacheKey = 'karyawan_tamu_data_' . ($jenisKelamin ?? 'all');

            $karyawanData = Cache::remember($cacheKey, 60, function() use ($jenisKelamin) {
                $query = Karyawan::query();

                /* Filter */
                if ($jenisKelamin) {
                    $query->where('jenis_kelamin', $jenisKelamin);
                }

                return $query->whereNotIn('id', [4, 5])->get();
            });
    
            return DataTables::of($karyawanData)
                ->addColumn('user_name', function ($karyawan) {
                    return $karyawan->user->name;
                })
                ->make(true);
        }
    
        return view('admin.list-karyawan-tamu');
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
