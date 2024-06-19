@extends('mandor.layouts.vertical', ['page_title' => isset($supir) ? 'Edit Supir' : 'Tambah Supir'])

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
                    {{-- <h4 class="page-title">{{ isset($supir) ? 'Edit Supir' : 'Tambah Supir' }}</h4> --}}
                    <h4 class="page-title">Kelola Data Supir</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{ isset($supir) ? 'Edit Data Supir' : 'Tambah Data Supir' }}</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda mengisi semua data dengan benar dan sesuai.
                        </p>
                        <form action="{{ isset($supir) ? route('supir.update', $supir->id) : route('supir.store') }}" method="POST">
                            @csrf
                            @if(isset($supir))
                                @method('PUT')
                            @endif
                            <div class="row g-2">
                                <div class="mb-3 col-md-6">
                                    <label for="mandor_nama" class="form-label">Nama Mandor</label>
                                    <input type="text" id="mandor_nama" name="mandor_nama" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                    <input type="hidden" id="mandor_id" name="mandor_id" class="form-control" value="{{ auth()->user()->mandor->id }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="nama_supir" class="form-label">Nama Supir</label>
                                    <input type="text" id="nama_supir" name="nama_supir" class="form-control @error('nama_supir') is-invalid @enderror" value="{{ old('nama_supir', isset($supir) ? $supir->nama_supir : '') }}" >
                                    @error('nama_supir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="mb-3 col-md-4">
                                    <label for="nomor_telp" class="form-label">Nomor Telepon</label>
                                    <input type="number" id="nomor_telp" name="nomor_telp" class="form-control @error('nomor_telp') is-invalid @enderror" value="{{ old('nomor_telp', isset($supir) ? $supir->nomor_telp : '') }}" >
                                    @error('nomor_telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" data-toggle="select2" >
                                        <option value="Laki-laki" {{ isset($supir) && $supir->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ isset($supir) && $supir->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="status_supir" class="form-label">Status Supir</label>
                                    <select id="status_supir" name="status_supir" class="form-control select2 @error('status_supir') is-invalid @enderror" data-toggle="select2" >
                                        <option value="Tetap" {{ isset($supir) && $supir->status_supir == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                        <option value="Rental" {{ isset($supir) && $supir->status_supir == 'Rental' ? 'selected' : '' }}>Rental</option>
                                    </select>
                                    @error('status_supir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ isset($supir) ? 'Update' : 'Tambah' }}</button>
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
