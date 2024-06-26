<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* Sweetalert confirm delete */
        $title = 'Delete Pertanyaan!';
        $text = "Kamu yakin menghapus data ini?";
        confirmDelete($title, $text);

        //
        if ($request->ajax()) {
            $query = Pertanyaan::query();

            /* Menampilkan data yang ada ke datatables, dan menambahkan kolom */
            return DataTables::of($query)
                ->addColumn('pertanyaan', function ($pertanyaan) {
                    return 'Pertanyaan Kuesioner';
                })
                /* Action */
                ->addColumn('action', function($row) {
                    $editUrl = route('pertanyaan.form', $row->id);
                    $deleteUrl = route('pertanyaan.destroy', $row->id);
                
                    $btn = '<a href="'. $editUrl .'" class="btn btn-primary btn-sm me-1">Edit</a>';
                    $btn .= '<a href="'. $deleteUrl .'" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>';
                
                    return $btn;
                })
                ->rawColumns(['action']) // Raw data
                ->make(true);
        }
        return view ('admin.pertanyaan.index');
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
        $validatedData = $request->validate([
            'pertanyaan' => 'required|array',
            'pertanyaan.*' => 'required|string'
        ]);

        try {
            $pertanyaanJson = json_encode($validatedData['pertanyaan']);

            // Assuming you have a model named Pertanyaan
            Pertanyaan::create([
                'pertanyaan' => $pertanyaanJson
            ]);

            Alert::success('Berhasil!', 'Berhasil menambahkan data Pertanyaan');
            return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Gagal menambahkan data Pertanyaan');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data Pertanyaan. Silakan coba lagi.')->withInput();
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
        $pertanyaan = Pertanyaan::findOrFail($id);

        try {
            /* Validasi */
            $validatedData = $request->validate([
                'pertanyaan' => 'required|array',
                'pertanyaan.*' => 'required|string'
            ]);

            $pertanyaanJson = json_encode($validatedData['pertanyaan']);

            $pertanyaan->update([
                'pertanyaan' => $pertanyaanJson
            ]);

            Alert::success('Berhasil!', 'Berhasil mengupdate data Pertanyaan');
            return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil diupdate.');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Gagal mengupdate data Pertanyaan');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data Pertanyaan. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        /* Mencari id data-nya */
        $pertanyaan = Pertanyaan::findOrFail($id);

        /* Menghapus data */
        $pertanyaan->delete();

        try{
            Alert::success('Berhasil!', 'Berhasil menghapus data pertanyaan');
            return redirect()->route('admin.pertanyaan.index')->with('success', 'pertanyaan berhasil dihapus.');
        } catch (\Exception $e){
            Alert::error('Gagal!', 'Gagal menghapus data pertanyaan');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pertanyaan. Silakan coba lagi.')->withInput();
        }
    }

    public function form(Pertanyaan $pertanyaan = null)
    {
        return view('admin.pertanyaan.form', compact('pertanyaan'));
    }
}
