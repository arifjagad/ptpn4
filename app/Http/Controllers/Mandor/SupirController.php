<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supir;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* Sweetalert confirm delete */
        $title = 'Delete Supir!';
        $text = "Kamu yakin menghapus data ini?";
        confirmDelete($title, $text);

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
                ->addColumn('action', function($row) {
                    $editUrl = route('supir.form', $row->id);
                    $deleteUrl = route('supir.destroy', $row->id);
                
                    $btn = '<a href="'. $editUrl .'" class="btn btn-primary btn-sm me-1">Edit</a>';
                    $btn .= '<a href="'. $deleteUrl .'" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>';
                
                    return $btn;
                })
                ->rawColumns(['status_supir', 'action', 'status_perjalanan']) // Raw data
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
        
        return view ('mandor.supir.index', $dataSupir);
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
        /* Validasi */
        $validator = Validator::make($request->all(), [
            'mandor_id' => 'required',
            'nama_supir' => 'required|string|max:255',
            'nomor_telp' => 'required|string|regex:/^08\d{8,12}$/',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'status_supir' => 'required|string|in:Tetap,Rental',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            Supir::create($request->all());
            Alert::success('Berhasil!', 'Berhasil menambahkan data supir');
            return redirect()->route('supir.index')->with('success', 'Supir berhasil ditambahkan.');
        } catch (\Exception $e) {
            Alert::error('Berhasil!', 'Gagal menambahkan data supir');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan supir. Silakan coba lagi.')->withInput();
        }
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
        /* Mencari id data-nya */
        $supir = Supir::findOrFail($id);

        /* Validasi */
        $validator = Validator::make($request->all(), [
            'mandor_id' => 'required',
            'nama_supir' => 'required|string|max:255',
            'nomor_telp' => 'required|string|regex:/^08\d{8,12}$/',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'status_supir' => 'required|string|in:Tetap,Rental',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $supir->update($request->all());
            Alert::success('Berhasil!', 'Berhasil mengupdate data supir');
            return redirect()->route('supir.index')->with('success', 'Supir berhasil diupdate.');
        } catch (\Exception $e) {
            Alert::error('Berhasil!', 'Gagal mengupdate data supir');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate supir. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /* Mencari id data-nya */
        $supir = Supir::findOrFail($id);

        /* Menghapus data */
        $supir->delete();

        try{
            Alert::success('Berhasil!', 'Berhasil menghapus data supir');
            return redirect()->route('supir.index')->with('success', 'Supir berhasil dihapus.');
        } catch (\Exception $e){
            Alert::error('Berhasil!', 'Gagal menghapus data supir');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus supir. Silakan coba lagi.')->withInput();
        }
    }

    /* Form add dan edit */
    public function form(Supir $supir = null)
    {
        return view('mandor.supir.form', compact('supir'));
    }
}
