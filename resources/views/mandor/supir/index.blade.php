@extends('mandor.layouts.vertical', ['page_title' => 'Daftar Supir'])

@section('css')
    @vite([
        'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
        'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css',
        'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css',
        'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
        'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css',
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
                    <h4 class="page-title">Manajemen Supir</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Supir</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar supir yang aktif. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Button tambah supir --}}
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('supir.form') }}" type="button" class="btn btn-success">
                                <i class="ri-add-circle-line"></i>
                                <span>Tambah Supir</span>
                            </a>
                        </div>
                        {{-- Filter --}}
                        <div class="d-flex justify-content-end gap-2 mb-2">
                            <div class="w-25">
                                <select id="filter-jenis-kelamin" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="w-25">
                                <select id="filter-status-supir" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Supir</option>
                                    @foreach ($statusSupirList as $statusSupir)
                                        <option value="{{ $statusSupir }}">{{ $statusSupir }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-25">
                                <select id="filter-status-perjalanan" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Perjalanan</option>
                                    @foreach ($statusPerjalananList as $statusPerjalanan)
                                        <option value="{{ $statusPerjalanan }}">{{ $statusPerjalanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="filter-button" class="btn btn-primary">Filter</button>
                                <button id="reset-button" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        {{-- List data table --}}
                        <table id="datatable-supir" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>Nama Supir</th>
                                    <th>Nama Mandor</th>
                                    <th>Nomor Telp</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Supir</th>
                                    <th>Status Perjalanan</th>
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
    @vite(['resources/js/pages/demo.datatable-init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- JS tampilkan data ke table --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-supir').DataTable({
                processing: true,
                serverSide: true,
                scrollY: true,
                ordering: false,
                'bDestroy': true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET',
                    /* Menjalankan filter */
                    data: function(d) {
                        d.jenis_kelamin = $('#filter-jenis-kelamin').val();
                        d.status_supir = $('#filter-status-supir').val();
                        d.status_perjalanan = $('#filter-status-perjalanan').val();
                    },
                },
                /* Menampilkan kolom */
                columns: [
                    {data: 'nama_supir', name: 'nama_supir'},
                    {data: 'nama_mandor', name: 'nama_mandor'},
                    {data: 'nomor_telp', name: 'nomor_telp'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'status_supir', name: 'status_supir'},
                    {data: 'status_perjalanan', name: 'status_perjalanan'},
                    {data: 'action', name: 'action', orderable: false, searchable: false} 
                ],
            });
    
            /* Trigger action filter */
            $('#filter-button').on('click', function() {
                table.ajax.reload();
            });
            /* Trigger action reset */
            $('#reset-button').on('click', function() {
                $('select').val('').trigger('change');
                table.ajax.reload();
            });
        });
    </script>
@endsection
