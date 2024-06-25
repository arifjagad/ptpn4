@extends('mandor.layouts.vertical', ['page_title' => isset($mobil) ? 'Edit Mobil' : 'Tambah Mobil'])

@section('css')
    @vite([
        'node_modules/select2/dist/css/select2.min.css', 
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 
    ])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    {{-- <h4 class="page-title">{{ isset($mobil) ? 'Edit Supir' : 'Tambah Supir' }}</h4> --}}
                    <h4 class="page-title">Kelola Data Mobil</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{ isset($mobil) ? 'Edit Data Mobil' : 'Tambah Data Mobil' }}</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda mengisi semua data dengan benar dan sesuai.
                        </p>
                        <form action="{{ isset($mobil) ? route('mobil.update', $mobil->id) : route('mobil.store') }}" method="POST">
                            @csrf
                            @if(isset($mobil))
                                @method('PUT')
                            @endif
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="mandor_nama" class="form-label">Nama Mandor</label>
                                    <input type="text" id="mandor_nama" name="mandor_nama" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                    <input type="hidden" id="mandor_id" name="mandor_id" class="form-control" value="{{ auth()->user()->mandor->id }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_mobil" class="form-label">Nama Mobil</label>
                                    <input type="text" id="nama_mobil" name="nama_mobil" class="form-control @error('nama_mobil') is-invalid @enderror" value="{{ old('nama_mobil', isset($mobil) ? $mobil->nama_mobil : '') }}" >
                                    @error('nama_mobil')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="nopol" class="form-label">Nomor Polisi</label>
                                    <input type="text" id="nopol" name="nopol" class="form-control @error('nopol') is-invalid @enderror" value="{{ old('nopol', isset($mobil) ? $mobil->nopol : '') }}" >
                                    @error('nopol')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative" id="tanggal_terakhir_beroperasi">
                                        <label class="form-label">Tanggal Terakhir Beroperasi</label>
                                        <input type="text" id="tanggal_terakhir_beroperasi" name="tanggal_terakhir_beroperasi" class="form-control" placeholder="Tanggal Terakhir Beroperasi" data-provide="datepicker" data-date-format="d-M-yyyy" data-date-container="#tanggal_terakhir_beroperasi" value="{{ old('tanggal_terakhir_beroperasi', isset($mobil) ? \Carbon\Carbon::parse($mobil->tanggal_terakhir_beroperasi)->format('d-M-Y') : '') }}">
                                        @error('tanggal_terakhir_beroperasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlah_km_awal" class="form-label">KM Awal</label>
                                    <input type="number" id="jumlah_km_awal" name="jumlah_km_awal" class="form-control @error('jumlah_km_awal') is-invalid @enderror" value="{{ old('jumlah_km_awal', isset($mobil) ? $mobil->jumlah_km_awal : '') }}" >
                                    @error('jumlah_km_awal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ isset($mobil) ? 'Update' : 'Tambah' }}</button>
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
    @vite(['resources/js/pages/demo.form-advanced.js'])
@endsection
