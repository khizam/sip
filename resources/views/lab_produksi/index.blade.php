@extends('layouts.master')

@section('title')
    Lab Produksi Barang
@endsection

@section('breadcrumb')
@parent
<li class="active">Lab Produksi Barang</li>
@endsection

@section('content')


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <a href="/lab/grade/{id_produksi}" class="btn btn-primary btn-xs" target="_blank">Cetak PDF</a>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">No</th>
                <th>Kode Lab</th>
                <th>Tanggal</th>
                <th>Nama produk</th>
                <th>Jumlah Permintaan</th>
                <th>Jumlah Produksi</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

@endsection

@push('scripts')
<script>

    let table;
    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('lab-produksi.data') }}',
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'id_labproduksi'},
            {data: 'created_at'},
            {data: 'nama_produk'},
            {data: 'jumlah'},
            {data: 'jumlah_produksi'},

            {data: 'aksi', searchable: false, sortable: false},
          ]
        });
    });
</script>
@endpush
