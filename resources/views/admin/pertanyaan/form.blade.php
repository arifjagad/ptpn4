@extends('admin.layouts.vertical', ['page_title' => isset($pertanyaan) ? 'Edit Pertanyaan' : 'Tambah Pertanyaan'])

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
                    {{-- <h4 class="page-title">{{ isset($pertanyaan) ? 'Edit pertanyaan' : 'Tambah pertanyaan' }}</h4> --}}
                    <h4 class="page-title">Kelola Data Pertanyaan</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{ isset($pertanyaan) ? 'Edit Data Pertanyaan' : 'Tambah Data Pertanyaan' }}</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda mengisi semua data dengan benar dan sesuai.
                        </p>
                        <form action="{{ isset($pertanyaan) ? route('pertanyaan.update', $pertanyaan->id) : route('pertanyaan.store') }}" method="POST">
                            @csrf
                            @if(isset($pertanyaan))
                                @method('PUT')
                            @endif
                            <div class="row g-3">
                                <div class="mb-3 col-md-12">
                                    <label for="pertanyaan" class="form-label">Nama Pertanyaan</label>
                                    <input type="text" id="pertanyaan" name="pertanyaan" class="form-control @error('pertanyaan') is-invalid @enderror" value="{{ old('pertanyaan', isset($pertanyaan) ? json_decode($pertanyaan->pertanyaan)->pertanyaan : '') }}" >
                                    @error('pertanyaan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ isset($pertanyaan) ? 'Update' : 'Tambah' }}</button>
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
