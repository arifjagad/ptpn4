@extends('mandor.layouts.vertical', ['page_title' => isset($kegiatan) ? 'Edit Kegiatan' : 'Tambah Kegiatan'])

@section('css')
    @vite([
        'node_modules/select2/dist/css/select2.min.css', 
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 
    ])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    {{-- <h4 class="page-title">{{ isset($kegiatan) ? 'Edit kegiatan' : 'Tambah kegiatan' }}</h4> --}}
                    <h4 class="page-title">Kelola Data Kegiatan</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{ isset($kegiatan) ? 'Edit Data Kegiatan' : 'Tambah Data Kegiatan' }}</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda mengisi semua data dengan benar dan sesuai.
                        </p>
                        <form action="{{ isset($kegiatan) ? route('kegiatan.update', $kegiatan->id) : route('kegiatan.store') }}" method="POST">
                            @csrf
                            @if(isset($kegiatan))
                                @method('PUT')
                            @endif
                            @if(!isset($kegiatan))
                                <div class="row g-2 mb-2">
                                    <div class="col-md-4">
                                        <label for="tipe_karyawan" class="form-label">Tipe Karyawan</label>
                                        <select id="tipe_karyawan" name="tipe_karyawan" class="form-control select2 @error('tipe_karyawan') is-invalid @enderror" data-toggle="select2">
                                            <option value="">Pilih Tipe Karyawan</option>
                                            <option value="pimpinan" {{ old('tipe_karyawan', isset($kegiatan) && $kegiatan->tipe_karyawan == 'pimpinan' ? 'selected' : '') }}>Karyawan Pimpinan</option>
                                            <option value="pelaksana" {{ old('tipe_karyawan', isset($kegiatan) && $kegiatan->tipe_karyawan == 'pelaksana' ? 'selected' : '') }}>Karyawan Pelaksana</option>
                                            <option value="tamu" {{ old('tipe_karyawan', isset($kegiatan) && $kegiatan->tipe_karyawan == 'tamu' ? 'selected' : '') }}>Karyawan Tamu</option>
                                        </select>
                                        @error('tipe_karyawan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="karyawan_detail" class="form-label">Nama Karyawan</label>
                                        <select id="karyawan_detail" name="karyawan_detail" class="form-control select2 @error('karyawan_detail') is-invalid @enderror" data-toggle="select2">
                                            <!-- Options will be populated by AJAX -->
                                            <option value="">Pilih Karyawan</option>
                                        </select>
                                        @error('karyawan_detail')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative" id="tanggal_kegiatan">
                                            <label class="form-label">Tanggal Kegiatan</label>
                                            <input type="text" id="tanggal_kegiatan" name="tanggal_kegiatan" class="form-control @error('tanggal_kegiatan') is-invalid @enderror" placeholder="Tanggal Kegiatan" data-provide="datepicker" data-date-format="d-M-yyyy" data-date-container="#tanggal_kegiatan" value="{{ old('tanggal_kegiatan', isset($kegiatan) ? \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d-M-Y') : '') }}">
                                            @error('tanggal_kegiatan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="agenda">Agenda</label>
                                    <textarea class="form-control @error('agenda') is-invalid @enderror" id="agenda" name="agenda" placeholder="Agenda" style="height: 60px">{{ old('agenda', isset($kegiatan) ? $kegiatan->agenda : '') }}</textarea>
                                    @error('agenda')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="tujuan">Tujuan</label>
                                    <textarea class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" placeholder="Tujuan" style="height: 60px">{{ old('tujuan', isset($kegiatan) ? $kegiatan->tujuan : '') }}</textarea>
                                    @error('tujuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            @if(!isset($kegiatan))
                                <div class="row g-2 mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Mandor</label>
                                        <input type="text" id="mandor_nama" name="mandor_nama" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="supir_id" class="form-label">Nama Supir</label>
                                        <select id="supir_id" name="supir_id" class="form-control select2 @error('supir_id') is-invalid @enderror" data-toggle="select2">
                                            <option value="">Pilih Supir</option>
                                            @foreach ($supirList as $supirId => $supirNama)
                                                <option value="{{ $supirId }}" {{ old('supir_id', isset($kegiatan) ? $kegiatan->supir_id : '') == $supirId ? 'selected' : '' }}>{{ $supirNama }}</option>
                                            @endforeach
                                        </select>
                                        @error('supir_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="mobil_id" class="form-label">Nama Mobil</label>
                                        <select id="mobil_id" name="mobil_id" class="form-control select2 @error('mobil_id') is-invalid @enderror" data-toggle="select2">
                                            <option value="">Pilih Mobil</option>
                                            @foreach ($mobilList as $mobilId => $mobilNama)
                                                <option value="{{ $mobilId }}" {{ old('mobil_id', isset($kegiatan) ? $kegiatan->mobil_id : '') == $mobilId ? 'selected' : '' }}>{{ $mobilNama }}</option>
                                            @endforeach
                                        </select>
                                        @error('mobil_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ isset($kegiatan) ? 'Update' : 'Tambah' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.form-advanced.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const $ = jQuery;
            $('.select2').select2();

            $('#tipe_karyawan').on('change', function () {
                var tipeKaryawan = $(this).val();
                var url = "{{ route('karyawan.byType', ['type' => ':type']) }}"; // Perhatikan perubahan di sini
                url = url.replace(':type', tipeKaryawan);

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        tipe_karyawan: tipeKaryawan,
                        karyawan_id: $('#karyawan_detail').val() 
                    },
                    success: function (data) {
                        var karyawanDetail = $('#karyawan_detail');
                        karyawanDetail.empty();
                        $.each(data, function(index, karyawan) {
                            karyawanDetail.append('<option value="' + karyawan.id + '">' + karyawan.name + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText); // Menampilkan pesan kesalahan di console
                        // Tambahkan logika untuk menampilkan pesan kesalahan ke pengguna di sini
                    }
                });
            });
        });
    </script>
@endsection
