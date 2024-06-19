<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supir;
use Yajra\DataTables\Facades\DataTables;

class SupirController extends Controller
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
            $statusSupir = $request->get('status_supir');
            $statusPerjalanan = $request->get('status_perjalanan');

            $query = Supir::query();

            /* Mengecek kondisi untuk filter */
            if ($jenisKelamin) {
                $query->where('jenis_kelamin', $jenisKelamin);
            }
            if ($statusSupir) {
                $query->where('status_supir', $statusSupir);
            }
            if ($statusPerjalanan) {
                $query->where('status_perjalanan', $statusPerjalanan);
            }

            /* Menampilkan data yang ada ke datatables, dan menambahkan kolom */
            return DataTables::of($query)
                ->addColumn('nama_mandor', function ($supir) {
                    return $supir->mandor->user->name;
                })
                ->addColumn('status_supir', function ($supir) {
                    $badgeClass = ($supir->status_supir == 'Tetap') ? 'badge bg-success text-white px-2 py-1' : 'badge bg-info text-white px-2 py-1';
                    return '<span class="' . $badgeClass . '">' . $supir->status_supir . '</span>';
                })
                ->addColumn('status_perjalanan', function ($supir) {
                    $badgeClass = ($supir->status_perjalanan == 'Tersedia') ? 'badge bg-success text-white px-2 py-1' : 'badge bg-warning text-white px-2 py-1';
                    return '<span class="' . $badgeClass . '">' . $supir->status_perjalanan . '</span>';
                })
                /* Action */
                ->rawColumns(['status_supir', 'status_perjalanan']) // Raw data
                ->make(true);
        }

        /* Mengambil data untuk filter */
        $dataSupir = [
            'statusSupirList' => Supir::select('status_supir')
                ->distinct()
                ->pluck('status_supir'),
            'statusPerjalananList' => Supir::select('status_perjalanan')
                ->distinct()
                ->pluck('status_perjalanan'),
        ];
        
        return view ('admin.list-supir', $dataSupir);
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
