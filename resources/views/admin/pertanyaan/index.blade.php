@extends('admin.layouts.vertical', ['page_title' => 'Manajemen Pertanyaan'])

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
                    <h4 class="page-title">Manajemen Pertanyaan</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Pertanyaan</h4>
                        <p class="text-muted fs-14">
                            Tabel ini menampilkan daftar pertanyaan. Anda dapat mencari, dan memfilter data untuk menemukan informasi yang Anda butuhkan.
                        </p>
                        {{-- Button tambah pertanyaan --}}
                        {{-- <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('pertanyaan.form') }}" type="button" class="btn btn-success">
                                <i class="ri-add-circle-line"></i>
                                <span>Tambah pertanyaan</span>
                            </a>
                        </div> --}}
                        {{-- List data table --}}
                        <table id="datatable-pertanyaan" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
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
            var table = $('#datatable-pertanyaan').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                'bDestroy': true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET',
                },
                /* Menampilkan kolom */
                columns: [
                    {data: 'pertanyaan', name: 'pertanyaan'},
                    {data: 'action', name: 'action', orderable: false, searchable: false} 
                ],
            });
        });
    </script>
@endsection
