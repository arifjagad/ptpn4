@extends('karyawan.layouts.vertical', ['page_title' => 'Profile'])

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
                    <h4 class="page-title">Profile</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Update Profile</h4>
                        <p class="text-muted fs-14">
                            Lakukan update profile di form ini.
                        </p>
                        <form action="{{ route('profile.user.admin.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                            value="{{ old('name', auth()->user()->name) }}">
                                    </div>
                                    @error('name')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('name') is-invalid @enderror" name="email" id="email"
                                            value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                    @error('email')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                    </div>
                                    @error('password')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Password Confirm</label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                    </div>
                                    @error('password_confirmation')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container -->
@endsection
