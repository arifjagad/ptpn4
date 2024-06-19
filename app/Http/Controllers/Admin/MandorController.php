<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mandor;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class MandorController extends Controller
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
            $cacheKey = 'mandor_data';
            $mandorData = Cache::remember($cacheKey, 60, function() use ($jenisKelamin) {
                $query = Mandor::query();

                /* Filter */
                if ($jenisKelamin) {
                    $query->where('jenis_kelamin', $jenisKelamin);
                }

                return $query->get();
            });
    
            return DataTables::of($mandorData)
                ->addColumn('user_name', function ($mandor) {
                    return $mandor->user->name;
                })
                ->addColumn('status_mandor', function ($mandor){
                    $badgeClass = ($mandor->status_mandor == 'Aktif') ? 'badge bg-success text-white px-2 py-1' : 'badge bg-warning text-white px-2 py-1';
                    return '<span class="' . $badgeClass . '">' . $mandor->status_mandor . '</span>';
                })
                ->rawColumns(['status_mandor'])
                ->make(true);
        }
    
        return view('admin.list-mandor');
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
