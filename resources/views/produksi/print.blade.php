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
    {{-- <body style="font-size:13px;"> --}}
    <div class="container">
        <div class="header" style="text-align: center">
            <img src="{{ asset('img/logojvg.png') }}" width="100px" class="img-header">
            <div class="d-inline-block max-width" style="align-self: center">
                <ol class="inner text-center">
                    <li>
                        <h2 style="font-weight: bold; font-size: 1.5em">JAVAGRI INTI LESTARI</h2>
                    </li>
                    <li>
                        <h1 style="font-weight: bold; font-size: 1.5em">"Esential Oil"</h1>
                    </li>
                    <li class="mb-1"><small style="font-size: 14px">Javagri is an Indonesian family-owned manufacturer
                            of Essential Oil,
                            Aromatic Chemicals and Botanical Extract for Flavors & Fragrance</small></li>
                    <li><small class="font-weight-1">Jl. Tlogo Bedah No.11, Hulaan,
                            Menganti, Gresik
                            EAST JAVA – INDONESIA</small>
                    </li>
                </ol>
            </div>
        </div>
        <hr style="line-height: 3px; background-color: black">
        <h2 class="prt-title" style="font-weight: bold; margin-bottom: 1.5rem">HASIL LABORATORIUM BARANG MASUK
        </h2>
        {{-- <table>
            <tr style="border: none!important"> --}}
        <div class="menu">
            <ol class="inner">
                <li>
                    <span class="title">Kode Produksi</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->kode_produksi }}</span>
                </li>
                <li>
                    <span class="title">Nama Produk</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->produk->nama_produk }}</span>
                </li>
                <li>
                    <span class="title">Jumlah Request Produksi</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->jumlah }}</span>
                </li>
                <li>
                    <span class="title">Keterangan</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->keterangan }}</span>
                </li>
            </ol>
            <ol class="inner">
                <li>
                    <span class="title">Tanggal Produksi</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->created_at }}</span>
                </li>
                <li>
                    <span class="title">Tanggal Selesai Produksi</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->updated_at }}</span>
                </li>
                <li>
                    <span class="title">Satuan</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->satuan->satuan }}</span>
                </li>
                <li>
                    <span class="title">Jumlah Hasil Produksi</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->jumlah_hasil_produksi }}</span>
                </li>
                <li>
                    <span class="title">Nama User</span>
                    <span>:</span>
                    <span class="body">{{ $produksibarang->user->name }}</span>
                </li>
            </ol>
        </div>
        <hr>
        <h2 style="font-size: 16px; font-weight: 600; margin: 1rem 0;">Detail Produksi</h2>
        <table class="b-1 table-border">
            <thead>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Jumlah</th>
            </thead>
            <tbody>
                @php
                    $no = 0;
                @endphp
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>@php
                        $produksibarang->detailProduksi->each(function ($item) {
                            echo '- ' . $item->bahan->nama_bahan . '<br>';
                        });
                    @endphp</td>
                    <td>@php
                        $produksibarang->detailProduksi->each(function ($item) {
                            echo '- ' . $item->jumlah . '<br>';
                        });
                    @endphp</td>


                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
