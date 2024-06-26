@extends('mandor.layouts.vertical', ['page_title' => 'Manajemen Karyawan Tamu'])

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
                    <h4 class="page-title">Manajemen Karyawan Tamu</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Karyawan Tamu</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar karyawan tamu. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Button tambah karyawan --}}
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('karyawan.form') }}" type="button" class="btn btn-success">
                                <i class="ri-add-circle-line"></i>
                                <span>Tambah Karyawan</span>
                            </a>
                        </div>
                        {{-- Filter --}}
                        <div class="d-lg-flex justify-content-end gap-1">
                            <div class="mb-2">
                                <select id="filter-jenis-kelamin" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
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
                        <table id="datatable-karyawan" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>NIK SAP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Asal Perusahaan</th>
                                    <th>Jabatan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor Telp</th>
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
            var table = $('#datatable-karyawan').DataTable({
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
                        d.status_perjalanan = $('#filter-status-perjalanan').val();
                    },
                },
                /* Menampilkan kolom */
                columns: [
                    {data: 'nik', name: 'nik'},
                    {data: 'niksap', name: 'niksap'},
                    {data: 'nama_karyawan', name: 'nama_karyawan'},
                    {data: 'asal_perusahaan', name: 'asal_perusahaan'},
                    {data: 'jabatan', name: 'jabatan'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'nomor_telp', name: 'nomor_telp'},
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
