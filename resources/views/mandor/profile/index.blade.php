@extends('mandor.layouts.vertical', ['page_title' => 'Profile'])

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
                    <h4 class="page-title">Profile</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Update Profile</h4>
                        <p class="text-muted fs-14">
                            Lakukan update profile di form ini.
                        </p>
                        <form action="{{ route('profile.user.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name', auth()->user()->name) }}">
                                    </div>
                                    @error('name')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                    @error('email')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    @error('password')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Password Confirm</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                    </div>
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
                        <form action="{{ route('profile.mandor.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name', auth()->user()->name) }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="nik" class="form-control" name="nik" id="nik"
                                            value="{{ old('nik', auth()->user()->mandor->nik) }}">
                                    </div>
                                    @error('nik')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="niksap" class="form-label">NIKSAP</label>
                                        <input type="niksap" class="form-control" name="niksap" id="niksap"
                                            value="{{ old('nik', auth()->user()->mandor->niksap) }}">
                                    </div>
                                    @error('niksap')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nomor_telp" class="form-label">Nomor Telp</label>
                                        <input type="nomor_telp" class="form-control" name="nomor_telp" id="nomor_telp"
                                            value="{{ old('nik', auth()->user()->mandor->nomor_telp) }}">
                                    </div>
                                    @error('nomor_telp')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2" data-toggle="select2">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', auth()->user()->mandor->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', auth()->user()->mandor->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Data Mandor</button>
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
