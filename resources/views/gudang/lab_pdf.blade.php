<!DOCTYPE html>
<html>
<head>
	<title>Laporan Lab</title>
</head>
<body>
	<h3>{{ "Laporan Lab" }}</h3>
	<style type="text/css">
		table tr td,
		table tr th{
			
			font-size: 8pt;
		}
	</style>

    <table class='table' border="1">
	<thead>
		<tr>
			<th>No</th>
			<th>kode lab</th>
			<th>tanggal</th>
			<th>nama_bahan</th>
			<th>satuan</th>
			<th>parameter</th>
			<th>hasil</th>
			<th>kesimpulan</th>
			<th>grid</th>
			<th>bahan_layak</th>
			<th>status</th>
		</tr>
	</thead>
	<tbody>
		@php $i=1 @endphp
		@foreach($labs as $l)
		<tr>
			<td>{{ $i++ }}</td>
			<td>{{$l->kode_lab}}</td>
			<td>{{$l->updated_at}}</td>
			<td>{{$l->barang_masuk->bahan->nama_bahan}}</td>
			<td>{{$l->satuan}}</td>
			<td>{{$l->parameter}}</td>
			<td>{{$l->hasil}}</td>
			<td>{{$l->kesimpulan}}</td>
			<td>{{$l->grid}}</td>
			<td>{{$l->bahan_layak}}</td>
			<td>{{$l->status}}</td>
		</tr>
		@endforeach
	</tbody>
    </table>

</body>
</html>
