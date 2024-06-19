@extends('admin.layouts.vertical', ['page_title' => 'List Kegiatan'])

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
                    <h4 class="page-title">Manajemen Kegiatan Tamu</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Kegiatan Tamu</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar tamu yang aktif. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Filter --}}
                        <div class="d-flex justify-content-end gap-2 mb-2">
                            <div class="w-25">
                                <select id="filter-status-kegiatan" class="form-control select2" data-toggle="select2">
                                    <option value="">Pilih Status Kegiatan</option>
                                    @foreach ($statuskegiatanList as $statusKegiatan)
                                        <option value="{{ $statusKegiatan }}">{{ $statusKegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
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

    @include('mandor.kegiatan.modal-detail')
@endsection

@section('script')
    @vite([
        'resources/js/pages/demo.datatable-init.js',
        'kegiatan.js',
    ])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        /* Menampilkan data ke table */
        $(document).ready(function() {
            var table = $('#datatable-kegiatan').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                scrollX: true,
                'bDestroy': true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET',
                    /* Menjalankan filter */
                    data: function(d) {
                        d.status_kegiatan = $('#filter-status-kegiatan').val();
                    },
                },
                /* Menampilkan kolom */
                columns: [
                    {data: 'nik', name: 'nik'},
                    {data: 'karyawan_id', name: 'karyawan_id'},
                    {data: 'agenda', name: 'agenda'},
                    {data: 'tanggal_kegiatan', name: 'tanggal_kegiatan'},
                    {data: 'status_kegiatan', name: 'status_kegiatan'},
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

        /* Trigger action view */
        $('#datatable-kegiatan').on('click', '.btn-view', function() {
            var id = $(this).data('id');
            console.log('View button clicked, ID:', id); // Debug log
            $.ajax({
                url: '{{ url()->current() }}' + '/' + id,
                type: 'GET',
                success: function(data) {
                    console.log('Data retrieved:', data); // Debug log
                    // Populate modal fields with data
                    $('#detail .modal-body').html(
                        `<table class="table">
                            <tr>
                                <th style="width: 35%">NIK</th>
                                <td style="width: 65%">${data['NIK']}</td>
                            </tr>
                            <tr>
                                <th>Nama Karyawan</th>
                                <td>${data['Nama Karyawan']}</td>
                            </tr>
                            <tr>
                                <th>Agenda</th>
                                <td>${data['Agenda']}</td>
                            </tr>
                            <tr>
                                <th>Tujuan</th>
                                <td>${data['Tujuan']}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Kegiatan</th>
                                <td>${data['Tanggal Kegiatan']}</td>
                            </tr>
                            <tr>
                                <th>Nama Supir</th>
                                <td>${data['Nama Supir']}</td>
                            </tr>
                            <tr>
                                <th>Nama Mobil</th>
                                <td>${data['Nama Mobil']}</td>
                            </tr>
                            <tr>
                                <th>Nopol</th>
                                <td>${data['Nopol']}</td>
                            </tr>
                            <tr>
                                <th>Status Kegiatan</th>
                                <td>${data['Status Kegiatan']}</td>
                            </tr>
                            <tr>
                                <th>KM Mobil</th>
                                <td>${data['KM awal - KM Akhir']}</td>
                            </tr>
                        </table>`
                    );
                    $('#detail').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error); // Debug log
                }
            });
        });
    </script>
@endsection