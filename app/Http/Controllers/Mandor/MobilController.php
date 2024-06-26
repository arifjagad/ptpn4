<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Mobil;
use Carbon\Carbon;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* Sweetalert confirm delete */
        $title = 'Delete Mobil!';
        $text = "Kamu yakin menghapus data ini?";
        confirmDelete($title, $text);

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
                /* Action */
                ->addColumn('action', function($row) {
                    $editUrl = route('mobil.form', $row->id);
                    $deleteUrl = route('mobil.destroy', $row->id);
                
                    $btn = '<a href="'. $editUrl .'" class="btn btn-primary btn-sm me-1">Edit</a>';
                    $btn .= '<a href="'. $deleteUrl .'" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>';
                
                    return $btn;
                })
                ->rawColumns(['status_pemakaian', 'action', 'tanggal_terakhir_beroperasi']) // Raw data
                ->make(true);
        }

        $dataMobil = [
            'statusPemakaianList' => Mobil::select('status_pemakaian')
                ->distinct()
                ->pluck('status_pemakaian'),
        ];

        return view ('mandor.mobil.index', $dataMobil);
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
            'nama_mobil' => 'required|string|max:255',
            'nopol' => 'required|string',
            'tanggal_terakhir_beroperasi' => [
                'required',
                'date',
                'before_or_equal:'.Carbon::now()->format('d-M-Y'),
            ],
            'jumlah_km_awal' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal menambahkan data mobil');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        Mobil::create($request->all());
        Alert::success('Berhasil!', 'Berhasil menambahkan data Mobil');
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
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
        $mobil = Mobil::findOrFail($id);

        /* Validasi */
        $validator = Validator::make($request->all(), [
            'mandor_id' => 'required',
            'nama_mobil' => 'required|string|max:255',
            'nopol' => 'required|string',
            'tanggal_terakhir_beroperasi' => [
                'required',
                'date',
                'before_or_equal:'.Carbon::now()->format('d-M-Y'),
            ],
            'jumlah_km_awal' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal mengupdate data mobil');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $mobil->update($request->all());
        Alert::success('Berhasil!', 'Berhasil mengupdate data mobil');
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        /* Mencari id data-nya */
        $mobil = Mobil::findOrFail($id);

        /* Menghapus data */
        $mobil->delete();

        try{
            Alert::success('Berhasil!', 'Berhasil menghapus data mobil');
            return redirect()->route('mobil.index')->with('success', 'mobil berhasil dihapus.');
        } catch (\Exception $e){
            Alert::error('Berhasil!', 'Gagal menghapus data mobil');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus mobil. Silakan coba lagi.')->withInput();
        }
    }

    public function form(Mobil $mobil = null)
    {
        return view('mandor.mobil.form', compact('mobil'));
    }
}
