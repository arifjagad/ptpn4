<!DOCTYPE html>
<html>
<head>
    <title>Kuesioner PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .column {
            float: left;
            width: 50%;
            padding: 10px;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .w-5 { width: 5%; }
        .w-10 { width: 10%; }
        .w-15 { width: 15%; }
        .w-30 { width: 30%; }
        .w-50 { width: 50%; }
        .w-60 { width: 60%; }
        .w-100 { width: 100%; }
    </style>
</head>
<body class="font-sans">
    <div class="text-center">
        <h2 class="text-xl">PT. PERKEBUNAN NUSANTARA IV REGIONAL I <br> (PERSERO)</h2>
    </div>
    <div class="mt-10">
        <table class="w-100">
            <tr class="text-center">
                <td class="w-50">
                    <table>
                        <tr>
                            <th class="text-left w-30">Nama Supir</th>
                            <th class="w-10">:</th>
                            <td class="w-60">{{ $kuesioner->kegiatan->supir->nama_supir }}</td>
                        </tr>
                        <tr>
                            <th class="text-left w-30">Jlh. KM Awal</th>
                            <th class="w-10">:</th>
                            <td class="w-60">{{ $kuesioner->kegiatan->jumlah_km_awal }} KM</td>
                        </tr>
                        <tr>
                            <th class="text-left w-30">Tujuan</th>
                            <th class="w-10">:</th>
                            <td class="w-60">{{ $kuesioner->kegiatan->tujuan }}</td>
                        </tr>
                    </table>
                </td>
                <td class="w-50">
                    <table>
                        <tr>
                            <th class="text-left w-30">Nopol Kendaraan</th>
                            <th class="w-10">:</th>
                            <td class="w-60">{{ $kuesioner->kegiatan->mobil->nopol }}</td>
                        </tr>
                        <tr>
                            <th class="text-left w-30">Jlh. KM Akhir</th>
                            <th class="w-10">:</th>
                            <td class="w-60">{{ $kuesioner->kegiatan->jumlah_km_akhir }} KM</td>
                        </tr>
                        <tr>
                            <th class="text-left w-30">Tanggal</th>
                            <th class="w-10">:</th>
                            <td class="w-60">{{ \Carbon\Carbon::parse($kuesioner->kegiatan->created_at)->locale('id')->format('l, d M Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="mt-10">
        <p>Kuesioner kepuasan penumpang terhadap kinerja supir</p>
        <table class="w-full mt-4 text-sm">
            <thead>
                <tr>
                    <th class="border border-black" style="width: 5%">No</th>
                    <th class="border border-black" style="width: 55%">Pertanyaan</th>
                    <th class="border border-black" style="width: 10%">Kurang Baik</th>
                    <th class="border border-black" style="width: 10%">Cukup</th>
                    <th class="border border-black" style="width: 10%">Baik</th>
                    <th class="border border-black" style="width: 10%">Sangat Baik</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jawaban as $pertanyaan => $jawabanItem)
                <tr>
                    <td class="border border-black text-center">{{ $loop->iteration }}</td>
                    <td class="border border-black pl-1">{{ $pertanyaan }}</td>
                    <td class="border border-black p-2 text-center">
                        @if ($jawabanItem == 'Kurang Baik')
                            X
                        @endif
                    </td>
                    <td class="border border-black p-2 text-center">
                        @if ($jawabanItem == 'Cukup')
                            X
                        @endif
                    </td>
                    <td class="border border-black p-2 text-center">
                        @if ($jawabanItem == 'Baik')
                            X
                        @endif
                    </td>
                    <td class="border border-black p-2 text-center">
                        @if ($jawabanItem == 'Sangat Baik')
                            X
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-sm mt-2">
        <p>Catatan:</p>
        <p>Daftar kuesioner harus diserahkan ke Urusan Rumah Tangga paling lambat 2 (dua) hari setelah kembali</p>
        <p>Kuesioner harus diisi oleh penumpang</p>
    </div>

    <div class="row mt-10">
        <div class="column text-center">
            <h5 class="mt-4"><strong>Nama Penumpang</strong></h5>
            <h5 class="mt-16"><strong>{{ $namaKaryawan }}</strong></h5>
        </div>
        <div class="column text-center">
            <h5><strong>Diketahui oleh, <br> Urusan Rumah Tangga</strong></h5>
            <h5 class="mt-14"><strong>NAMA</strong></h5>
        </div>
    </div>
</body>
</html>
