<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Mobil;
use Carbon\Carbon;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            /* Mengambil data */
            $statusPemakaian = $request->get('status_pemakaian');

            $query = Mobil::query();

            /* Mengecek kondisi untuk filter */
            if ($statusPemakaian) {
                $query->where('status_pemakaian', $statusPemakaian);
            }

            /* Menampilkan data yang ada ke datatables, dan menambahkan kolom */
            return DataTables::of($query)
                ->addColumn('nama_mandor', function ($supir) {
                    return $supir->mandor->user->name;
                })
                ->addColumn('tanggal_terakhir_beroperasi', function($supir){
                    $tanggal_terakhir_beroperasi = Carbon::parse($supir->tanggal_terakhir_beroperasi);
                    $sekarang = Carbon::now();
                    $selisih = $tanggal_terakhir_beroperasi->diffInDays($sekarang);
                
                    if ($sekarang->greaterThan($tanggal_terakhir_beroperasi)) {
                        return $selisih . ' hari lalu';
                    } else {
                        return 'Hari ini';
                    }
                })
                ->addColumn('jumlah_km_awal', function($supir){
                    return number_format($supir->jumlah_km_awal, 0, ',', '.') . ' KM'; 
                })
                ->addColumn('status_pemakaian', function ($supir) {
                    $badgeClass = ($supir->status_pemakaian == 'Tersedia') ? 'badge bg-success text-white px-2 py-1' : 'badge bg-info text-white px-2 py-1';
                    return '<span class="' . $badgeClass . '">' . $supir->status_pemakaian . '</span>';
                })
                ->rawColumns(['status_pemakaian', 'tanggal_terakhir_beroperasi']) // Raw data
                ->make(true);
        }

        $dataMobil = [
            'statusPemakaianList' => Mobil::select('status_pemakaian')
                ->distinct()
                ->pluck('status_pemakaian'),
        ];

        return view ('admin.list-mobil', $dataMobil);
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
