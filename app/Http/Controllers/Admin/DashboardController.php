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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* $jumlahKaryawan = Karyawan::count() +
            KaryawanPelaksana::where('MBT', '')->where('PENS', '')->count() +
            KaryawanPimpinan::where('MBT', '')->where('PENS', '')->count(); */
        /* Menampilkan data count */
        $jumlahKaryawan = Karyawan::count();
        $jumlahMobil = Mobil::count();
        $jumlahMandor = Mandor::count();
        $jumlahSupir = Supir::count();

        /* Chart */
        $monthlyData = array_fill(1, 12, 0);
        /* Mengambil data kegiatan yang selesai */
        $dataKegiatanSelesai = Kegiatan::where('status_kegiatan', 'Selesai')
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
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        foreach ($dataKegiatanSedangDiproses as $data) {
            $monthlyDataInProgress[$data->month] = $data->total;
        }

        return view(
            'admin.dashboard', 
            compact(
                'jumlahKaryawan', 
                'jumlahMobil', 
                'jumlahMandor', 
                'jumlahSupir',
            ),
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
