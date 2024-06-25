@extends('admin.layouts.vertical', ['page_title' => 'Manajemen Mobil'])

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
                    <h4 class="page-title">Manajemen Mobil</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Mobil</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar mobil. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Filter --}}
                        <div class="d-lg-flex justify-content-end gap-1">
                            <div class="mb-2">
                                <select id="filter-status-pemakaian" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Pemakaian</option>
                                    @foreach ($statusPemakaianList as $statusPemakaian)
                                        <option value="{{ $statusPemakaian }}">{{ $statusPemakaian }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-1 mb-2">
                                <button id="filter-button" class="btn btn-primary">Filter</button>
                                <button id="reset-button" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        {{-- List data table --}}
                        <table id="datatable-mobil" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>Nama Mobil</th>
                                    <th>Nama Mandor</th>
                                    <th>Nopol</th>
                                    <th>Status Pemakaian</th>
                                    <th>Terakhir Beroperasi</th>
                                    <th>KM Awal</th>
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
            var table = $('#datatable-mobil').DataTable({
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
                        d.status_pemakaian = $('#filter-status-pemakaian').val();
                    },
                },
                /* Menampilkan kolom */
                columns: [
                    {data: 'nama_mobil', name: 'nama_mobil'},
                    {data: 'nama_mandor', name: 'nama_mandor'},
                    {data: 'nopol', name: 'nopol'},
                    {data: 'status_pemakaian', name: 'status_pemakaian'},
                    {data: 'tanggal_terakhir_beroperasi', name: 'tanggal_terakhir_beroperasi'},
                    {data: 'jumlah_km_awal', name: 'jumlah_km_awal'},
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
