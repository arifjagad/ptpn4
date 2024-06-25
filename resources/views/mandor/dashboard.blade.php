@extends('mandor.layouts.vertical', ['page_title' => 'Dashboard'])

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

            {{-- Count card --}}
            <x-count-card title="Jumlah Supir" count="{{ $jumlahSupir }}" class="col-md-6" /> 
            <x-count-card title="Jumlah Mobil" count="{{ $jumlahMobil }}" class="col-md-6" />

            {{-- Chart --}}
            <div class="col-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Jumlah Kegiatan Tiap Bulan - {{ date('Y') }}</h4>
                    </div>
                    <div class="w-100" style="height: 320px;">
                        <canvas id="kegiatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container -->
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var dataKegiatanSelesai = {!! json_encode($dataKegiatanSelesai) !!};
        var dataKegiatanSedangDiproses = {!! json_encode($dataKegiatanSedangDiproses) !!};

        document.addEventListener('DOMContentLoaded', function () {
            var chartData = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [
                    {
                        label: 'Jumlah Kegiatan Yang Selesai',
                        data: dataKegiatanSelesai,
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        borderColor: 'red',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Kegiatan Yang Sedang Diproses',
                        data: dataKegiatanSedangDiproses,
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        borderColor: 'blue',
                        borderWidth: 1
                    },
                ]
            };

            // Membuat Vertical Bar Chart menggunakan Chart.js
            var ctx = document.getElementById('kegiatanChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
