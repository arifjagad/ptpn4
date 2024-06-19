@extends('admin.layouts.vertical', ['page_title' => 'List Karyawan Tamu'])

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
                    <h4 class="page-title">List User</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Fixed Header</h4>
                        <p class="text-muted fs-14">
                            The FixedHeader will freeze in place the header and/or footer in a DataTable, ensuring that title information will remain always visible.
                        </p>
                        <!-- Filters -->
                        <div class="d-flex justify-content-end gap-2 mb-2">
                            <div class="w-25">
                                <select id="filter-jenis-kelamin" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="filter-button" class="btn btn-primary">Filter</button>
                                <button id="reset-button" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        {{-- Table --}}
                        <table id="datatable-karyawan-tamu" class="table table-striped dt-responsive nowrap table-striped w-100">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>NIK SAP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Jabatan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor Telp</th>
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
            var table = $('#datatable-karyawan-tamu').DataTable({
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
                    {data: 'jabatan', name: 'jabatan'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'nomor_telp', name: 'nomor_telp'},
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