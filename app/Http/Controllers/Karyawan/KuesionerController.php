<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KaryawanPimpinan;
use App\Models\KaryawanPelaksana;
use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

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

            $kuesioner = Kuesioner::query();

            if(auth()->user()->id === 6){
                $nik = session()->get('nik');
                $query = Kuesioner::whereHas('kegiatan', function ($query) use ($nik) {
                    $query->where('nik', $nik);
                });
            } elseif (auth()->user()->id === 7){
                $nik = session()->get('nik');
                $query = Kuesioner::whereHas('kegiatan', function ($query) use ($nik) {
                    $query->where('nik', $nik);
                });
            } else {
                $karyawanId = auth()->user()->karyawan->id;
                $query = Kuesioner::where('karyawan_id', $karyawanId);
            }
            //$query = Kuesioner::query();

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
                    $editUrl = route('kuesioner.jawaban', $row->id);
                    $pdfUrl = url('karyawan/kuesioner/downloadPdf', $row->id);

                    $btn = '';
                    /* Kondisi button */
                    if ($row->status_kuesioner === 'Selesai') {
                        $btn .= '<a href="'. $pdfUrl .'" class="btn btn-info btn-sm me-1">Download PDF</a>';
                    } else {
                        $btn .= '<a href="'. $editUrl .'" class="btn btn-primary btn-sm me-1">Isi Kuesioner</a>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['status_kuesioner', 'action']) // Raw data
                ->make(true);
        }

        /* Mengambil data untuk filter */
        $statusKuesionerList = Kuesioner::select('status_kuesioner')
            ->distinct()
            ->pluck('status_kuesioner');

        return view ('karyawan.kuesioner.index', compact('statusKuesionerList'));
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
    public function update(Request $request, $id) {
        // Definisikan aturan validasi
        $validator = Validator::make($request->all(), [
            'jawaban.*' => 'required|in:Kurang Baik,Cukup,Baik,Sangat Baik',
        ]);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            Log::error('KuesionerController update, validation error:', $validator->errors()->all());
            Alert::error('Gagal!', 'Gagal menyimpan jawaban kuesioner');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $kuesioner = Kuesioner::findOrFail($id);
    
        $pertanyaan = $request->input('pertanyaan');
        $jawaban = $request->input('jawaban');
    
        // Inisialisasi array untuk menyimpan pertanyaan dan jawaban
        $dataJawaban = [];
    
        // Iterasi setiap pertanyaan dan jawaban
        foreach ($pertanyaan as $index => $question) {
            $dataJawaban[$question] = $jawaban[$index];
        }
    
        $kuesioner->jawaban = json_encode($dataJawaban);
        $kuesioner->status_kuesioner = 'Selesai';
        $kuesioner->save();
    
        Alert::success('Berhasil!', 'Jawaban kuesioner berhasil disimpan');
        return redirect()->route('karyawan.kuesioner')->with('success', 'Jawaban berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function jawaban($id) {
        $kuesioner = Kuesioner::findOrFail($id);
        $pertanyaan = json_decode($kuesioner->pertanyaan->pertanyaan, true);
        return view('karyawan.kuesioner.jawaban', compact('kuesioner', 'pertanyaan'));
    }

    public function downloadPdf($id) {
        $kuesioner = Kuesioner::findOrFail($id);
        $jawaban = json_decode($kuesioner->jawaban, true);
    
        // Pastikan untuk memuat semua relasi yang diperlukan
        $kuesioner->load('kegiatan.supir', 'kegiatan.mobil');
    

        $karyawanId = $kuesioner->kegiatan->karyawan_id;
        $nik = $kuesioner->kegiatan->nik;

        if ($karyawanId == 4) {
            $namaKaryawan = KaryawanPimpinan::where('NIK', $nik)->value('NAMA') ?? 'Tidak ditemukan';
        } elseif ($karyawanId == 5) {
            $namaKaryawan = KaryawanPelaksana::where('NIK', $nik)->value('NAMA') ?? 'Tidak ditemukan';
        } else {
            $namaKaryawan = $kuesioner->kegiatan->karyawan->user->name;
        }
    
        $pdf = Pdf::loadView('layouts.shared.pdf', compact('kuesioner', 'jawaban', 'namaKaryawan'));
        return $pdf->download('kuesioner_' . $kuesioner->id . '.pdf');
    }
}
