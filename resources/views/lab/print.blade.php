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
                    <span class="title">Kode Barang</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->kode_barangmasuk }}</span>
                </li>
                <li>
                    <span class="title">Nama Bahan</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->bahan->nama_bahan }}</span>
                </li>
                <li>
                    <span class="title">Nama Kategori</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->kategori->nama_kategori }}</span>
                </li>
                <li>
                    <span class="title">Nama Supplier</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->supplier->nama_supplier }}</span>
                </li>
            </ol>
            <ol class="inner">
                <li>
                    <span class="title">Nomor PO</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->nomor_po }}</span>
                </li>
                <li>
                    <span class="title">Nama Kemasan</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->kemasan->jenis_kemasan }}</span>
                </li>
                <li>
                    <span class="title">Nama Pengirim</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->pengirim }}</span>
                </li>
                <li>
                    <span class="title">Nama Penerima</span>
                    <span>:</span>
                    <span class="body">{{ $lab->barang_masuk->penerima }}</span>
                </li>
            </ol>
        </div>
        <hr>
        <h2 style="font-size: 16px; font-weight: 600; margin: 1rem 0;">Detail Barang Masuk</h2>
        <table style="width: 70%">
            <tr style="border: none">
                <td style="border: none">
                    <span class="t-2">BERAT KOTOR</span>
                    <span>:</span>
                    <span>{{ $lab->barang_masuk->berat_kotor }}</span>
                </td>
                <td style="border: none">
                    <span class="t-2">TARA</span>
                    <span>:</span>
                    <span>{{ $lab->barang_masuk->tara }}</span>
                </td>
                <td style="border: none">
                    <span class="t-2">NETTO</span>
                    <span>:</span>
                    <span>{{ $lab->barang_masuk->netto }}</span>
                </td>
                <td style="border: none">
                    <span class="t-2">REJECT</span>
                    <span>:</span>
                    <span>{{ $lab->barang_masuk->reject }}</span>
                </td>
            </tr>
        </table>
        <h2 style="font-size: 16px; font-weight: 600; margin: 1rem 0;">Hasil Laboratorium</h2>
        <table class="b-1 table-border">
            <thead>
                <th>No</th>
                <th>Hasil</th>
                <th>Parameter</th>
                <th>Kesimpulan</th>
                <th>Grid</th>
            </thead>
            <tbody>
                @php
                    $no = 0;
                @endphp
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $lab->hasil ?? '-' }}</td>
                    <td>@php
                        $lab->parameterLab->each(function ($item) {
                            echo '- ' . $item->parameters->nama_parameter . '<br>';
                        });
                    @endphp</td>
                    <td>{{ $lab->kesimpulan ?? '-' }}</td>
                    <td>{{ $lab->grid ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
