<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\KaryawanPimpinan;
use App\Models\KaryawanPelaksana;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            /* Mengambil data */
            $statusKegiatan = $request->get('status_kegiatan');

            $query = Kegiatan::query();

            /* Mengecek kondisi untuk filter */
            if ($statusKegiatan) {
                $query->where('status_kegiatan', $statusKegiatan);
            }

            /* Menampilkan data yang ada ke datatables, dan menambahkan kolom */
            return DataTables::of($query)
                /* Nama Karyawan */
                ->addColumn('karyawan_id', function ($kegiatan){
                    if($kegiatan->karyawan_id == 4) {
                        $karyawan = KaryawanPimpinan::where('NIK', $kegiatan->nik)
                            ->pluck('NAMA')
                            ->first();
                        return $karyawan;
                    } elseif ($kegiatan->karyawan_id == 5){
                        $karyawan = KaryawanPelaksana::where('NIK', $kegiatan->nik)
                            ->pluck('NAMA')
                            ->first();
                        return $karyawan;
                    } else {
                        $karyawan = $kegiatan->karyawan->user->name;
                        return $karyawan;
                    }
                })
                ->addColumn('tanggal_kegiatan', function($kegiatan) {
                    return Carbon::parse($kegiatan->tanggal_kegiatan)->translatedFormat('d F Y');
                })
                ->addColumn('supir_id', function ($kegiatan){
                    return $kegiatan->supir->nama_supir;
                })
                ->addColumn('mobil_id', function ($kegiatan){
                    return $kegiatan->mobil->nama_mobil;
                })
                ->addColumn('nopol', function ($kegiatan) {
                    return $kegiatan->mobil->nopol;
                })
                ->addCOlumn('status_kegiatan', function ($kegiatan) {
                    $statuses = [
                        'Sedang Diproses' => 'badge bg-info text-white px-2 py-1',
                        'Selesai' => 'badge bg-success text-white px-2 py-1',
                    ];

                    $status = $kegiatan->status_kegiatan;
                    $badgeClass = $statuses[$status] ?? 'badge bg-secondary text-white px-2 py-1';
                    
                    return '<span class="' . $badgeClass . '">' . $status . '</span>';
                })
                /* Action */
                ->addColumn('action', function($row) {
                    $btn = '<button type="button" class="btn btn-info btn-sm me-1 btn-view" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#detail">View</button>';
                    return $btn;
                })
                ->rawColumns(['status_kegiatan', 'action', 'status_perjalanan']) // Raw data
                ->make(true);
        }

        /* Mengambil data untuk filter */
        $statuskegiatanList = Kegiatan::select('status_kegiatan')
            ->distinct()
            ->pluck('status_kegiatan');
        
        return view ('admin.list-kegiatan', compact('statuskegiatanList'));
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
        $kegiatan = Cache::remember("kegiatan_{$id}", 60, function() use ($id) {
            return Kegiatan::with(['karyawan.user', 'supir', 'mobil'])
                ->find($id);
        });

        $kegiatan->tujuan = json_decode($kegiatan->tujuan, true);
        $kegiatan->tujuan = implode(', ', $kegiatan->tujuan);

        // Custom response
        $data = [
            'NIK' => $kegiatan->nik,
            'Nama Karyawan' => $kegiatan->karyawan_id == 4 ? KaryawanPimpinan::where('NIK', $kegiatan->nik)->pluck('NAMA')->first() :
                ($kegiatan->karyawan_id == 5 ? KaryawanPelaksana::where('NIK', $kegiatan->nik)->pluck('NAMA')->first() : $kegiatan->karyawan->user->name),
            'Agenda' => $kegiatan->agenda,
            'Tujuan' => $kegiatan->tujuan,
            'Tanggal Kegiatan' => Carbon::parse($kegiatan->tanggal_kegiatan)->translatedFormat('d F Y'),
            'Nama Supir' => $kegiatan->supir->nama_supir,
            'Nama Mobil' => $kegiatan->mobil->nama_mobil, 
            'Nopol' => $kegiatan->mobil->nopol,
            'Status Kegiatan' => $kegiatan->status_kegiatan,
            'KM awal - KM Akhir' => $kegiatan->jumlah_km_awal . ' KM - ' . $kegiatan->jumlah_km_akhir . ' KM',
        ];

        return response()->json($data);
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
