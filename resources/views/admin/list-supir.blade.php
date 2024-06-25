@extends('admin.layouts.vertical', ['page_title' => 'Manajemen Supir'])

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
                    <h4 class="page-title">Manajemen Supir</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Supir</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar supir. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Filter --}}
                        <div class="d-lg-flex justify-content-end gap-1 mb-2">
                            <div class="mb-2">
                                <select id="filter-jenis-kelamin" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <select id="filter-status-supir" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Supir</option>
                                    @foreach ($statusSupirList as $statusSupir)
                                        <option value="{{ $statusSupir }}">{{ $statusSupir }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <select id="filter-status-perjalanan" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Perjalanan</option>
                                    @foreach ($statusPerjalananList as $statusPerjalanan)
                                        <option value="{{ $statusPerjalanan }}">{{ $statusPerjalanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-1 mb-2">
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
                scrollX: true,
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
