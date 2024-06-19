<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supir;
use App\Models\Kegiatan;
use App\Models\Karyawan;
use App\Models\KaryawanPimpinan;
use App\Models\KaryawanPelaksana;
use App\Models\Mobil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* Sweetalert confirm delete */
        $title = 'Delete kegiatan!';
        $text = "Kamu yakin menghapus data ini?";
        confirmDelete($title, $text);

        // $title = 'Lanjutkan Perjalanan Ini!';
        // $text = "Kamu yakin melanjutkan data ini?";
        // confirmAlert($title, $text);
        /*  */
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
                    $editUrl = route('kegiatan.form', $row->id);
                    $deleteUrl = route('kegiatan.destroy', $row->id);
                    $progressUrl = '#';
                    $finishedUrl = '#';
                
                    $btn = '';

                    /* Kondisi button */
                    if ($row->status_kegiatan === 'Menunggu Keberangkatan') {
                        $btn .= '<a href="'. $progressUrl .'" class="btn btn-success btn-sm me-1" data-confirm-delete="true">Process</a>';
                        $btn .= '<button type="button" class="btn btn-info btn-sm me-1 btn-view" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#detail">View</button>';
                        $btn .= '<a href="'. $editUrl .'" class="btn btn-primary btn-sm me-1">Edit</a>';
                        $btn .= '<a href="'. $deleteUrl .'" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>';
                    } elseif ($row->status_kegiatan === 'Sedang Berjalan') {
                        $btn .= '<button type="button" class="btn btn-info btn-sm me-1 btn-view" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#detail">View</button>';
                        $btn .= '<a href="'. $finishedUrl .'" class="btn btn-success btn-sm me-1">Finished</a>';
                        $btn .= '<a href="'. $deleteUrl .'" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>';
                    } else {
                        $btn .= '<button type="button" class="btn btn-info btn-sm me-1 btn-view" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#detail">View</button>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['status_kegiatan', 'action', 'status_perjalanan']) // Raw data
                ->make(true);
        }

        /* Mengambil data untuk filter */
        $statuskegiatanList = kegiatan::select('status_kegiatan')
            ->distinct()
            ->pluck('status_kegiatan');
        
        return view ('mandor.kegiatan.index', compact('statuskegiatanList'));
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
        /* Ambil id dan nik */
        if($request->tipe_karyawan === 'pimpinan') {
            $karyawanId = 4;
            $nik = $request->karyawan_detail;
        } elseif ($request->tipe_karyawan === 'pelaksana') {
            $karyawanId = 5;
            $nik = $request->karyawan_detail;
        } else {
            $karyawan = Karyawan::find($request->karyawan_detail);
            if ($karyawan !== null) {
                $karyawanId = $karyawan->id;
                $nik = $karyawan->nik;
            }
        }

        /* Validation */
        $validator = Validator::make($request->all(), [
            'tipe_karyawan' => 'required',
            'karyawan_detail' => 'required',
            'supir_id' => 'required',
            'mobil_id' => 'required',
            'agenda' => 'required',
            'tujuan' => 'required',
            'tanggal_kegiatan' => 'required|date',
        ]);

        if ($validator->fails()) {
            Log::error('KegiatanController store, validation error:', $validator->errors()->all());
            Alert::error('Gagal!', 'Gagal menambahkan data mobil');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Kegiatan::create(
            [
                'karyawan_id' => $karyawanId,
                'nik' => $nik,
                'supir_id' => $request->supir_id,
                'mobil_id' => $request->mobil_id,
                'agenda' => $request->agenda,
                'tujuan' => $request->tujuan,
                'tanggal_kegiatan' => $request->tanggal_kegiatan,
                'status_kegiatan' => 'Menunggu Keberangkatan',
                'jumlah_km_awal' => Mobil::find($request->mobil_id)->jumlah_km_awal,
                'jumlah_km_akhir' => NULL,
            ]
        );

        Alert::success('Berhasil!', 'Berhasil menambahkan data kegiatan');
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
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
        $kegiatan = Kegiatan::find($id);

        $validator = Validator::make($request->all(), [
            'tipe_karyawan' => 'required',
            'karyawan_detail' => 'required',
            'supir_id' => 'required',
            'mobil_id' => 'required',
            'agenda' => 'required',
            'tujuan' => 'required',
            'tanggal_kegiatan' => 'required|date',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal memperbarui data kegiatan');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kegiatan->update($request->all());
        Alert::success('Berhasil!', 'Berhasil memperbarui data kegiatan');
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $kegiatan = Kegiatan::find($id);
        $kegiatan->delete();

        try{
            Alert::success('Berhasil!', 'Berhasil menghapus data kegiatan');
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\Exception $e){
            Alert::error('Gagal!', 'Gagal menghapus data kegiatan');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kegiatan. Silakan coba lagi.')->withInput();
        }
    }

    public function form(Kegiatan $kegiatan = null)
    {
        $mandorId = Auth::user()->id;
        $supirList = Supir::select('nama_supir', 'id')->distinct()->pluck('nama_supir', 'id');
        $mobilList = Mobil::select('nama_mobil', 'id')->distinct()->pluck('nama_mobil', 'id');

        return view('mandor.kegiatan.form', compact('kegiatan', 'supirList', 'mobilList'));
    }

    public function getKaryawanByType($type)
    {
        /* type: tamu, pelaksana, pimpinan */
        if ($type == 'tamu') {
            $karyawan = Karyawan::with('user')
                ->where('status_perjalanan', 'Tersedia')
                ->whereNotNull('nik')
                ->get()
                ->map(function ($karyawan) {
                return (object)['id' => $karyawan->id, 'name' => $karyawan->user->name];
            });
        } elseif ($type == 'pelaksana') {
            $karyawan = Cache::remember('karyawan_pelaksana', 60, function () { // Cache selama 60 menit
                return KaryawanPelaksana::where('MBT', '')
                    ->where('PENS', '')
                    ->pluck('NAMA', 'NIK')
                    ->map(function ($nama, $nik) {
                        return (object) ['id' => $nik, 'name' => $nama];
                    });
            });
        } elseif ($type == 'pimpinan') {
            $karyawan = Cache::remember('karyawan_pimpinan', 60, function () { // Cache selama 60 menit
                return KaryawanPimpinan::where('MBT', '')
                    ->where('PENS', '')
                    ->pluck('NAMA', 'NIK')
                    ->map(function ($nama, $nik) {
                        return (object) ['id' => $nik, 'name' => $nama];
                    });
            });
        } else {
            return response()->json([]);
        }
        
        return response()->json($karyawan);
    }

    public function processKegiatan(string $id){
        $kegiatan = Kegiatan::find($id);
        $kegiatan->delete();

        try{
            Alert::success('Berhasil!', 'Berhasil menghapus data kegiatan');
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\Exception $e){
            Alert::error('Gagal!', 'Gagal menghapus data kegiatan');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kegiatan. Silakan coba lagi.')->withInput();
        }
    }
}