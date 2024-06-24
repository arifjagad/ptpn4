<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $nik = session()->get('nik');

        /* Chart */
        $monthlyData = array_fill(1, 12, 0);
        /* Mengambil data kegiatan yang selesai */
        $dataKegiatanSelesai = Kegiatan::where('status_kegiatan', 'Selesai')
            ->where(
                auth()->user()->id == 6 || auth()->user()->id == 7 ? 'nik' : 'karyawan_id', 
                auth()->user()->id == 6 || auth()->user()->id == 7 ? $nik : auth()->user()->karyawan->id)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        foreach ($dataKegiatanSelesai as $data) {
            $monthlyData[$data->month] = $data->total;
        }

        $monthlyDataInProgress = array_fill(1, 12, 0);
        /* Mengambil data kegiatan yang sedang proses */
        $dataKegiatanSedangDiproses = Kegiatan::where('status_kegiatan', 'Sedang Diproses')
            ->where(
                auth()->user()->id == 6 || auth()->user()->id == 7 ? 'nik' : 'karyawan_id', 
                auth()->user()->id == 6 || auth()->user()->id == 7 ? $nik : auth()->user()->karyawan->id)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        foreach ($dataKegiatanSedangDiproses as $data) {
            $monthlyDataInProgress[$data->month] = $data->total;
        }

        return view ('karyawan.dashboard',
            [
                'dataKegiatanSelesai' => array_values($monthlyData),
                'dataKegiatanSedangDiproses' => array_values($monthlyDataInProgress),
            ],
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
