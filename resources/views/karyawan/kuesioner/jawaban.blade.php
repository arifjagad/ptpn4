@extends('karyawan.layouts.vertical', ['page_title' => 'Kuesioner'])

@section('css')
    @vite([
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
                    {{-- <h4 class="page-title">{{ isset($pertanyaan) ? 'Edit pertanyaan' : 'Tambah pertanyaan' }}</h4> --}}
                    <h4 class="page-title">Kuesioner</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Pengisian Kuesioner</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda menjawab kuesioner dengan sejujurnya.
                        </p>
                        <hr>
                        <form action="{{ route('kuesioner.update', $kuesioner->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                @foreach($pertanyaan as $index => $question)
                                    <div class="mb-2">
                                        <div class="repeater-item my-1">
                                            <h5>{{ $index + 1 }}. {{ $question }}</h5>
                                            <input type="hidden" name="pertanyaan[{{ $index }}]" value="{{ $question }}">
                                            <div data-select2-id="select2-data-{{ $index }}">
                                                <select id="pilihan-jawaban" name="jawaban[{{ $index }}]" class="form-control select2 @error('jawaban.' . $index) is-invalid @enderror" data-toggle="select2" data-select2-id="{{ $index }}">
                                                    <option value="">Pilih Jawaban</option>
                                                    <option value="Sangat Baik" {{ old('jawaban.' . $index) == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                                                    <option value="Baik" {{ old('jawaban.' . $index) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup" {{ old('jawaban.' . $index) == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang Baik" {{ old('jawaban.' . $index) == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                                </select>
                                                @error('jawaban.' . $index)
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
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
        $(document).ready(function() {
            $('#pilihan-jawaban-{{ $index }}').select2();
        });
    </script>
@endsection
