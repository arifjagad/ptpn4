@extends('karyawan.layouts.vertical', ['page_title' => 'Manajemen Profile'])

@section('css')
    @vite([
        'node_modules/select2/dist/css/select2.min.css',
    ])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Manajemen Profile</h4>
                </div>
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Profile User</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.user.karyawan.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                        value="{{ old('name', auth()->user()->name) }}">
                                    @error('name')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('name') is-invalid @enderror" name="email" id="email"
                                        value="{{ old('email', auth()->user()->email) }}">
                                    @error('email')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                    @error('password')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Password Confirm</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                    @error('password_confirmation')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Profile Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.karyawan.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="mb-3 col-md-4">
                                    <label for="name" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                        value="{{ old('name', auth()->user()->name) }}" disabled>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="nik" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik"
                                        value="{{ old('nik', auth()->user()->karyawan->nik) }}">
                                    @error('nik')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="niksap" class="form-label">NIKSAP</label>
                                    <input type="niksap" class="form-control @error('niksap') is-invalid @enderror" name="niksap" id="niksap"
                                        value="{{ old('nik', auth()->user()->karyawan->niksap) }}">
                                    @error('niksap')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="mb-3 col-md-4">
                                    <label for="asal_perusahaan" class="form-label">Asal Perusahaan</label>
                                    <input type="text" class="form-control @error('asal_perusahaan') is-invalid @enderror" name="asal_perusahaan" id="asal_perusahaan"
                                        value="{{ old('asal_perusahaan', auth()->user()->karyawan->asal_perusahaan) }}" disabled>
                                    @error('asal_perusahaan')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="nomor_telp" class="form-label">Nomor Telp</label>
                                    <input type="number" class="form-control @error('nomor_telp') is-invalid @enderror" name="nomor_telp" id="nomor_telp"
                                        value="{{ old('nomor_telp', auth()->user()->karyawan->nomor_telp) }}">
                                    @error('nomor_telp')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" data-toggle="select2">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', auth()->user()->karyawan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', auth()->user()->karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Data Karyawan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container -->
@endsection
