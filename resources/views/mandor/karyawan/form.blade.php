@extends('mandor.layouts.vertical', ['page_title' => isset($karyawan) ? 'Edit Karyawan' : 'Tambah Karyawan'])

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
                    {{-- <h4 class="page-title">{{ isset($karyawan) ? 'Edit karyawan' : 'Tambah karyawan' }}</h4> --}}
                    <h4 class="page-title">Kelola Data Karyawan</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{ isset($karyawan) ? 'Edit Data Karyawan' : 'Tambah Data Karyawan' }}</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda mengisi semua data dengan benar dan sesuai.
                        </p>
                        <form action="{{ isset($karyawan) ? route('karyawan.update', $karyawan->id) : route('karyawan.store') }}" method="POST">
                            @csrf
                            @if(isset($karyawan))
                                @method('PUT')
                            @endif
                            <div class="row g-2">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Nama Karyawan</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($karyawan) ? $karyawan->user->name : '') }}" >
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="asal_perusahaan" class="form-label">Asal Perusahaan Karyawan</label>
                                    <input type="text" id="asal_perusahaan" name="asal_perusahaan" class="form-control @error('asal_perusahaan') is-invalid @enderror" value="{{ old('asal_perusahaan', isset($karyawan) ? $karyawan->asal_perusahaan : '') }}" >
                                    @error('asal_perusahaan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="mb-3 col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($karyawan) ? $karyawan->user->email : '') }}" >
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" >
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="password_confirmation" class="form-label">Password Confirm</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ isset($karyawan) ? 'Update Karyawan' : 'Tambah Karyawan' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container -->
@endsection

@section('script')
    
@endsection
