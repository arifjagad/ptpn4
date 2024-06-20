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
                    $data = json_decode($pertanyaan->pertanyaan);
                    return $data->pertanyaan;
                })
                ->addColumn('jawaban', function ($pertanyaan) {
                    $data = json_decode($pertanyaan->pertanyaan);
                    return implode(', ', $data->jawaban);
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
        //
        /* Validasi */
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required',
        ]);
    
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal menambahkan data pertanyaan');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        Pertanyaan::create([
            'pertanyaan' => json_encode([
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => ['Kurang Baik', 'Cukup', 'Baik', 'Sangat Baik']
            ]),
        ]);
        
        Alert::success('Berhasil!', 'Berhasil menambahkan data Pertanyaan');
        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
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

        /* Validasi */
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required',
        ]);
    
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal mengupdate data pertanyaan');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pertanyaan->update([
            'pertanyaan' => json_encode([
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => ['Kurang Baik', 'Cukup', 'Baik', 'Sangat Baik']
            ]),
        ]);
        
        Alert::success('Berhasil!', 'Berhasil mengupdate data pertanyaan');
        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil diupdate.');
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
