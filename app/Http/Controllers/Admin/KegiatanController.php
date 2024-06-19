<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\KaryawanPimpinan;
use App\Models\KaryawanPelaksana;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

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
            $jenisKelamin = $request->get('jenis_kelamin');

            $query = Kegiatan::query();

            /* Mengecek kondisi untuk filter */
            if ($jenisKelamin) {
                $query->where('jenis_kelamin', $jenisKelamin);
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
                        $karyawan = $kegiatan->mandor->user->name;
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
                        'Menunggu Keberangkatan' => 'badge bg-warning text-white px-2 py-1',
                        'Sedang Berjalan' => 'badge bg-info text-white px-2 py-1',
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
        $statuskegiatanList = kegiatan::select('status_kegiatan')
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
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            return response()->json(['message' => 'Kegiatan not found'], 404);
        }

        // Custom response
        $data = [
            'NIK' => $kegiatan->nik,
            'Nama Karyawan' => $kegiatan->karyawan_id == 4 ? KaryawanPimpinan::where('NIK', $kegiatan->nik)->pluck('NAMA')->first() :
                ($kegiatan->karyawan_id == 5 ? KaryawanPelaksana::where('NIK', $kegiatan->nik)->pluck('NAMA')->first() : $kegiatan->mandor->user->name),
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