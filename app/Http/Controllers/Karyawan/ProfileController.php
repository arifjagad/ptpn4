<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view ('karyawan.profile.index');
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
    public function update(Request $request)
    {
        //
        /* Mengupdate data */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name,' . auth()->id(),
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal mengupdate data user!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        Alert::success('Berhasil!', 'Berhasil mengupdate data user!');
        return redirect()->back()->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateMandor(Request $request){
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:255|',
            'niksap' => 'required|string|max:255|',
            'nomor_telp' => 'required|string|regex:/^08\d{8,12}$/',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Gagal mengupdate data profile!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find(auth()->id());
        $karyawan = $user->karyawan;
        $karyawan->nik = $request->nik;
        $karyawan->niksap = $request->niksap;
        $karyawan->jabatan = 'TAMU';
        $karyawan->nomor_telp = $request->nomor_telp;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->save();

        Alert::success('Berhasil!', 'Berhasil mengupdate data profile!');
        return redirect()->back();
    }
}
