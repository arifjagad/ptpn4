@extends('admin.layouts.vertical', ['page_title' => isset($pertanyaan) ? 'Edit Pertanyaan' : 'Tambah Pertanyaan'])

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
                    <h4 class="page-title">Kelola Data Pertanyaan</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{ isset($pertanyaan) ? 'Edit Data Pertanyaan' : 'Tambah Data Pertanyaan' }}</h4>
                        <p class="text-muted fs-14">
                            Pastikan Anda mengisi semua data dengan benar dan sesuai.
                        </p>
                        <form action="{{ isset($pertanyaan) ? route('pertanyaan.update', $pertanyaan->id) : route('pertanyaan.store') }}" method="POST">
                            @csrf
                            @if(isset($pertanyaan))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" id="add-repeater">Tambah Pertanyaan</button>
                                    </div>
                                    <label for="pertanyaan" class="form-label">Nama Pertanyaan</label>
                                    <div id="repeater">
                                        @if(old('pertanyaan') || isset($pertanyaan))
                                            @php $questions = old('pertanyaan') ?? json_decode($pertanyaan->pertanyaan, true); @endphp
                                            @foreach($questions as $question)
                                                <div class="repeater-item d-flex align-items-center my-2">
                                                    <input type="text" name="pertanyaan[]" class="form-control @error('pertanyaan') is-invalid @enderror" value="{{ $question }}">
                                                    <button type="button" class="btn btn-danger btn-remove ms-2">Remove</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="repeater-item d-flex align-items-center my-2">
                                                <input type="text" name="pertanyaan[]" class="form-control @error('pertanyaan') is-invalid @enderror" value="">
                                                <button type="button" class="btn btn-danger btn-remove ms-2">Remove</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ isset($pertanyaan) ? 'Update' : 'Tambah' }}</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const repeater = document.getElementById('repeater');
        const addRepeater = document.getElementById('add-repeater');

        // Function to add new item
        const addItem = () => {
            const newItem = document.createElement('div');
            newItem.classList.add('repeater-item', 'd-flex', 'align-items-center', 'my-2');
            newItem.innerHTML = `
                <input type="text" name="pertanyaan[]" class="form-control">
                <button type="button" class="btn btn-danger btn-remove ms-2">Remove</button>
            `;
            repeater.appendChild(newItem);

            // Add event listener for remove button
            newItem.querySelector('.btn-remove').addEventListener('click', function () {
                if (repeater.querySelectorAll('.repeater-item').length > 1) {
                    newItem.remove();
                }
            });
        };

        // Add event listener for the add button
        addRepeater.addEventListener('click', addItem);

        // Add event listener for existing remove buttons
        repeater.querySelectorAll('.btn-remove').forEach(function (button) {
            button.disabled = repeater.querySelectorAll('.repeater-item').length === 1;
            button.addEventListener('click', function () {
                if (repeater.querySelectorAll('.repeater-item').length > 1) {
                    button.parentElement.remove();
                    button.disabled = repeater.querySelectorAll('.repeater-item').length === 1;
                }
            });
        });
    });
</script>
@endsection
