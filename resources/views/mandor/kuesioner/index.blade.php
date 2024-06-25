@extends('mandor.layouts.vertical', ['page_title' => 'Manajemen Kuesioner'])

@section('css')
@vite([
    'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
    'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css',
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
                    <h4 class="page-title">Manajemen Kuesioner</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Kuesioner</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar kuesioner. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Filter --}}
                        <div class="d-flex justify-content-end gap-2 mb-2">
                            <div class="w-25">
                                <select id="filter-status-kuesioner" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Kuesioner</option>
                                    @foreach ($statusKuesionerList as $statusKuesioner)
                                        <option value="{{ $statusKuesioner }}">{{ $statusKuesioner }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="filter-button" class="btn btn-primary">Filter</button>
                                <button id="reset-button" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        {{-- List data table --}}
                        <table id="datatable-mandor-kuesioner" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th>Agenda</th>
                                    <th>Status</th>
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
@endsection

@section('script')
    @vite([
        'resources/js/pages/demo.datatable-init.js',
        'resources/js/custom/mandor-kuesioner.js',
    ])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection