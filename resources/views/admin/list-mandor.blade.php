@extends('admin.layouts.vertical', ['page_title' => 'Manajemen Mandor'])

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
                    <h4 class="page-title">Manajemen Mandor</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Mandor</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar mandor. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        <!-- Filters -->
                        <div class="d-lg-flex justify-content-end gap-1">
                            <div class="mb-2">
                                <select id="filter-jenis-kelamin" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-1 mb-2">
                                <button id="filter-button" class="btn btn-primary">Filter</button>
                                <button id="reset-button" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        {{-- Table --}}
                        <table id="datatable-list-mandor" class="table table-striped dt-responsive nowrap table-striped w-100">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>NIK SAP</th>
                                    <th>Nama Mandor</th>
                                    <th>Status Mandor</th>
                                    <th>Nomor Telp</th>
                                    <th>Jenis Kelamin</th>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-list-mandor').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                'bDestroy': true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET',
                    data: function(d) {
                        d.jenis_kelamin = $('#filter-jenis-kelamin').val();
                    },
                },
                columns: [
                    {data: 'nik', name: 'nik'},
                    {data: 'niksap', name: 'niksap'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'status_mandor', name: 'status_mandor'},
                    {data: 'nomor_telp', name: 'nomor_telp'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                ],
            });
    
            $('#filter-button').on('click', function() {
                table.ajax.reload();
            });
            $('#reset-button').on('click', function() {
                $('#filter-jenis-kelamin').val('').trigger('change');
                table.ajax.reload();
            });
        });
    </script>
@endsection