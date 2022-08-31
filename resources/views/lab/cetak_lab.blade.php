<!DOCTYPE html>
<html>
<head>
	<title>Laporan Lab</title>
    <style>
    table {
        border-collapse: collapse;
    }

    .table th {
        padding: 5px 5px;
        text-align: center;
        font-size: 10px;
    }

    .table td {
        padding: 3px 3px;
        font-size: 10px;
    }
    </style>
</head>
<body>
	<center class="table">
        <table class="center" width="100%">
            <thead>
            <tr>
                <td><img src="img/logojvg.png" width="100" height="100" ></td>
                <td>
                    <center>
                        <font size="4">JAVAGRI INTI LESTARI</font><br>
                        <font size="5">Esential Oil</font><br>
                        <font size="2">Javagri is an Indonesian family-owned manufacturer of Essential Oil,
                        Aromatic Chemicals and Botanical Extract for Flavors & Fragrance.</font><br>
                        <font size="2">Jl. Tlogo Bedah No.11, Hulaan,
                            Menganti, Gresik
                            EAST JAVA – INDONESIA</font>
                    </center>
                </td>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <table border="1" class="table">
            <thead>
                <tr>
                    <th width="10px">No</th>
                    <th width="50px">kode lab</th>
                    <th width="50px">tanggal</th>
                    <th width="50px">nama_bahan</th>
                    <th width="10px">satuan</th>
                    <th width="50px">parameter</th>
                    <th width="50px">hasil</th>
                    <th width="50px">kesimpulan</th>
                    <th width="10px">grid</th>
                    <th width="50px">bahan_layak</th>
                    <th width="50px">status</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                    @foreach($labs as $l)
                    <tr>
                        <td width="10px">{{ $i++ }}</td>
                        <td width="50px">{{$l->kode_lab}}</td>
                        <td width="50px">{{$l->updated_at}}</td>
                        <td width="50px">{{$l->barang_masuk->bahan->nama_bahan}}</td>
                        <td width="10px">{{$l->satuan}}</td>
                        <td width="50px">{{$l->parameter}}</td>
                        <td width="50px">{{$l->hasil}}</td>
                        <td width="50px">{{$l->kesimpulan}}</td>
                        <td width="10px">{{$l->grid}}</td>
                        <td width="50px">{{$l->bahan_layak}}</td>
                        <td width="50px">{{$l->status}}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </center>
</body>
</html>

