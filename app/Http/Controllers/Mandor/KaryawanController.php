<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* Sweetalert confirm delete */
        $title = 'Delete Karyawan!';
        $text = "Kamu yakin menghapus data ini?";
        confirmDelete($title, $text);

        //
        if ($request->ajax()) {
            /* Mengambil data */
            $jenisKelamin = $request->get('jenis_kelamin');
            $statusPerjalanan = $request->get('status_perjalanan');

            $query = Karyawan::query();

            /* Mengecek kondisi untuk filter */
            if ($jenisKelamin) {
                $query->where('jenis_kelamin', $jenisKelamin);
            }
            if ($statusPerjalanan) {
                $query->where('status_perjalanan', $statusPerjalanan);
            }

            $query->whereNotIn('id', [4, 5])->get();

            /* Menampilkan data yang ada ke datatables, dan menambahkan kolom */
            return DataTables::of($query)
                ->addColumn('nama_karyawan', function ($karyawan) {
                    return $karyawan->user->name;
                })
                ->addColumn('status_perjalanan', function ($karyawan) {
                    $badgeClass = ($karyawan->status_perjalanan == 'Tersedia') ? 'badge bg-success text-white px-2 py-1' : 'badge bg-info text-white px-2 py-1';
                    return '<span class="' . $badgeClass . '">' . $karyawan->status_perjalanan . '</span>';
                })
                /* Action */
                ->addColumn('action', function($row) {
                    $editUrl = route('karyawan.form', $row->id);
                    $deleteUrl = route('karyawan.destroy', $row->id);
                
                    $btn = '<a href="'. $editUrl .'" class="btn btn-primary btn-sm me-1">Edit</a>';
                    $btn .= '<a href="'. $deleteUrl .'" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>';
                
                    return $btn;
                })
                ->rawColumns(['status_karyawan', 'action', 'status_perjalanan']) // Raw data
                ->make(true);
        }

        $dataKaryawan = [
            'statusPerjalananList' => Karyawan::select('status_perjalanan')
                ->distinct()
                ->pluck('status_perjalanan'),
        ];

        return view('mandor.karyawan.index', $dataKaryawan);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            Alert::error('Gagal!', 'Gagal menambahkan data karyawan');
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Karyawan::create([
            'user_id' => $user->id,
        ]);

        Alert::success('Berhasil!', 'Berhasil menambahkan data karyawan');
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
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
        $karyawan = Karyawan::findOrFail($id);
        $user = $karyawan->user;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal memperbarui data karyawan');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        Alert::success('Berhasil!', 'Berhasil memperbarui data karyawan');
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $karyawan = Karyawan::find($id);
        $karyawan->delete();

        try{
            Alert::success('Berhasil!', 'Berhasil menghapus data karyawan');
            return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil di hapus');
        } catch (\Exception $e){
            Alert::error('Gagal!', 'Gagal menghapus data karyawan');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus karyawan. Silakan coba lagi.')->withInput();
        }
    }

    public function form(Karyawan $karyawan = null)
    {
        return view('mandor.karyawan.form', compact('karyawan'));
    }
}
