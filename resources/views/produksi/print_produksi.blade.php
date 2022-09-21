<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <style type="text/css" media="print">
        @page {
            size: landscape;
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
        <table class="b-1 table-border t-center">
            <thead>
                <th>No</th>
                <th>Kode Lab</th>
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
            <tbody>
                @php
                    $no = 0;
                @endphp
                @foreach ($produksibarangs as $produksibarang)
                    <tr>
                        {{-- <td>{{ $no + 1 }}</td>
                        <td>{{ $produksibarang->kode_produksi }}</td>
                        <td>{{ $lab->barang_masuk->bahan->nama_bahan }}</td>
                        <td>{{ $lab->barang_masuk->kategori->nama_kategori }}</td>
                        <td>{{ strtoupper($lab->barang_masuk->supplier->nama_supplier) }}</td>
                        <td>{{ $lab->hasil ?? '-' }}</td>
                        <td>@php
                            $lab->parameterLab->each(function ($item) {
                                echo '- ' . $item->parameters->nama_parameter . '<br>';
                            });
                        @endphp</td>
                        <td>{{ $lab->kesimpulan ?? '-' }}</td>
                        <td>{{ $lab->grid ?? '-' }}</td>
                        <td>{{ $lab->bahan_layak ?? '-' }}</td>
                        <td>{{ $lab->status_gudang->status }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
