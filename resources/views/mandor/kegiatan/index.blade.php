@extends('mandor.layouts.vertical', ['page_title' => 'Manajemen Kegiatan'])

@section('css')
    @vite([
        'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
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
                    <h4 class="page-title">Manajemen Kegiatan</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Kegiatan</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar kegiatan. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Button tambah kegiatan --}}
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('kegiatan.form') }}" type="button" class="btn btn-success">
                                <i class="ri-add-circle-line"></i>
                                <span>Tambah Kegiatan</span>
                            </a>
                        </div>
                        {{-- Filter --}}
                        <div class="d-lg-flex justify-content-end gap-1">
                            <div class="mb-2">
                                <select id="filter-status-kegiatan" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Kegiatan</option>
                                    @foreach ($statuskegiatanList as $statusKegiatan)
                                        <option value="{{ $statusKegiatan }}">{{ $statusKegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-1 mb-2">
                                <button id="filter-button" class="btn btn-primary">Filter</button>
                                <button id="reset-button" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        {{-- List data table --}}
                        <table id="datatable-kegiatan" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>Agenda</th>
                                    <th>Tanggal Kegiatan</th>
                                    <th>Status Kegiatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container -->

    {{-- Modal --}}
    @include('mandor.kegiatan.modal-detail')
    @include('mandor.kegiatan.modal-finished')
    
@endsection

@section('script')
    @vite([
        'resources/js/pages/demo.datatable-init.js',
        'resources/js/custom/kegiatan.js',
    ])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
@endsection
