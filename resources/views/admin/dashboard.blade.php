@extends('admin.layouts.vertical', ['page_title' => 'Dashboard'])

@section('css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
            <x-count-card title="Jumlah Karyawan" count="{{ $jumlahKaryawan }}" />
            <x-count-card title="Jumlah Mandor" count="{{ $jumlahMandor }}" />
            <x-count-card title="Jumlah Supir" count="{{ $jumlahSupir }}" />
            <x-count-card title="Jumlah Mobil" count="{{ $jumlahMobil }}" />
        </div>
        
    </div>
    <!-- container -->
@endsection

@section('script')
@endsection