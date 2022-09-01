<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <style type="text/css" media="print">
        @page {
            size: A4;
        }
    </style>
    {{-- <title>Periksaa PA</title> --}}
</head>

<body style="font-size:13px;" onload="window.print()">
    <div class="container">
        <div class="row relative" style="text-align: center">
            <img src="{{ asset('assets/img/gs-logo.png') }}" width="80px" class="d-inline-block relative"
                style="max-width: 15%">
            <div class="d-inline-block max-width" style="width: 700px;margin: 0 auto; max-width: 70%">
                <ol class="inner text-center">
                    <li>
                        <h2 style="font-weight: bold; font-size: 1.5em">RUMAH SAKIT</h2>
                    </li>
                    <li>
                        <h1 style="color: red; font-weight: bold; font-size: 2em">"GRAHA SEHAT"</h1>
                    </li>
                    <li class="mb-1"><small class="font-weight-1">Jl. Raya Panglima Sudirman No 2 Kraksaan -
                            Probolinggo</small></li>
                    <li><small class="font-weight-1">Telp. (0335) 846500, 846354, 844200 Fax (0335) 846500</small>
                    </li>
                    <li><small class="font-weight">UNIT LABORATORIUM</small></li>
                </ol>
            </div>
            <img src="{{ asset('assets/img/kars-logo.png') }}" width="80px" class="d-inline-block relative"
                style="margin-right: auto; max-width: 15%;">
        </div>
        <hr style="line-height: 3px; background-color: black">
        <h2 class="prt-title" style="font-weight: bold; margin-bottom: 1rem">HASIL LABORATORIUM BARANG MASUK
        </h2>
        <table>
            <tr style="border: none">
                <td>
                    {{-- Left Table List --}}
                    <ol class="inner">
                        <li>
                            <span class="title">Kode Barang Masuk</span>
                            <span>:</span>
                            <span class="body">{{ 'BR0092883' }}</span>
                        </li>
                        <li>
                            <span class="title">Nama Bahan</span>
                            <span>:</span>
                            <span class="body">{{ 'Testing' }}</span>
                        </li>
                        <li>
                            <span class="title" style="vertical-align: top">Kategori Bahan</span>
                            <span style="vertical-align: top">:</span>
                            <span class="body" style="width: auto; max-width: 11rem;">{{ 'Kategori bahan' }}</span>
                        </li>
                        <li>
                            <span class="title">Supplier</span>
                            <span>:</span>
                            <span class="body">{{ 'Nama Supplier' }}</span>
                        </li>
                        <li>
                            <span class="title">Jumlah Bahan</span>
                            <span>:</span>
                            <span class="body"><b>{{ '80' }}</b></span>
                        </li>
                        <li>
                            <span class="title" style="vertical-align: top">Tanggal Dibuat</span>
                            <span style="vertical-align: top">:</span>
                            <span class="body" style="width: auto; max-width: 13rem;">{{ '22-08-2022' }}</span>
                        </li>
                    </ol>
                </td>
                <td>
                    {{-- Right Table List --}}
                    {{-- List --}}
                    {{-- <ol class="inner">
                        <li>
                            <span class="title w-6">Dokter Pengirim</span>
                            <span>:</span>
                            <span class="body">{{ $periksa->labMDokterPengirim->nama_dr }}</span>
                        </li>
                        <li>
                            <span class="title w-6">Ruang / Poli</span>
                            <span>:</span>
                            <span class="body">{{ $periksa->poli }}</span>
                        </li>
                        <li>
                            <span class="title w-6">RS Perujuk</span>
                            <span>:</span>
                            <span class="body">{{ $periksa->rs_perujuk }}</span>
                        </li>
                        <li>
                            <span class="title w-6">Tgl Terima</span>
                            <span>:</span>
                            <span
                                class="body">{{ !is_null($periksa->tgl_terima) ? date('d/m/Y', strtotime($periksa->tgl_terima)) : '-' }}</span>
                        </li>
                        <li>
                            <span class="title w-6">Tgl Periksa</span>
                            <span>:</span>
                            <span
                                class="body">{{ !is_null($periksa->tgl_periksa) ? date('d/m/Y', strtotime($periksa->tgl_periksa)) : '-' }}</span>
                        </li>
                        <li>
                            <span class="title w-6">Tgl Hasil</span>
                            <span>:</span>
                            <span
                                class="body">{{ !is_null($periksa->tgl_hasil) ? date('d/m/Y', strtotime($periksa->tgl_hasil)) : '-' }}</span>
                        </li>
                    </ol> --}}
                </td>
            </tr>
        </table>
        <table class="b-1">
            <thead>
                <th>Kode Barang</th>
                <th>Nama Bahan</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Hasil</th>
                <th>Parameter</th>
                <th>Kesimpulan</th>
                <th>Grid</th>
                <th>Jumlah Bahan</th>
                <th>Status Gudang</th>
            </thead>
            <tr>
                <td>

                </td>
            </tr>
        </table>
    </div>
</body>

</html>
