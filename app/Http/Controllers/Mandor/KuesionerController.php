<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Karyawan;
use App\Models\KaryawanPimpinan;
use App\Models\KaryawanPelaksana;
use App\Models\Mobil;
use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class KuesionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            /* Mengambil data */
            $statusKuesioner = $request->get('status_kuesioner');

            $query = Kuesioner::query();

            /* Mengecek kondisi untuk filter */
            if ($statusKuesioner) {
                $query->where('status_kuesioner', $statusKuesioner);
            }

            /* Menampilkan data yang ada ke datatables, dan menambahkan kolom */
            return DataTables::of($query)
                /* Nama Karyawan */
                ->addColumn('nama_karyawan', function ($kuesioner) {
                    $karyawanId = $kuesioner->kegiatan->karyawan_id;
                    $nik = $kuesioner->kegiatan->nik;

                    if ($karyawanId == 4) {
                        return KaryawanPimpinan::where('NIK', $nik)->value('NAMA') ?? 'Tidak ditemukan';
                    } elseif ($karyawanId == 5) {
                        return KaryawanPelaksana::where('NIK', $nik)->value('NAMA') ?? 'Tidak ditemukan';
                    } else {
                        return $kuesioner->kegiatan->karyawan->user->name;
                    }
                })
                ->addColumn('agenda', function ($kuesioner){
                    return $kuesioner->kegiatan->agenda;
                })
                ->addCOlumn('status_kuesioner', function ($kuesioner) {
                    $statuses = [
                        'Belum Selesai' => 'badge bg-info text-white px-2 py-1',
                        'Selesai' => 'badge bg-success text-white px-2 py-1',
                    ];

                    $status = $kuesioner->status_kuesioner;
                    $badgeClass = $statuses[$status] ?? 'badge bg-secondary text-white px-2 py-1';
                    
                    return '<span class="' . $badgeClass . '">' . $status . '</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('kuesioner.form', $row->id);
                
                    $btn = '';
                    /* Kondisi button */
                    if ($row->status_kuesioner === 'Selesai') {
                        $btn .= '<button type="button" class="btn btn-info btn-sm me-1 btn-view" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#detail">Download PDF</button>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['status_kuesioner', 'action']) // Raw data
                ->make(true);
        }
        return view ('mandor.kuesioner.index');
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
