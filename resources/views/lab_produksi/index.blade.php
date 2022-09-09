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
            @can('labproduksi_create')
            <a href="/lab/grade/{id_produksi}" class="btn btn-primary btn-xs" target="_blank">Cetak PDF</a>
            @endcan
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
                <th>Lost Produk</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('lab_produksi.form_selesai')
@includeIf('lab_produksi.form_lost')
@endsection

@push('scripts')
<script>

    let table;
    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('labProduksi.data') }}',
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'kode_produksi'},
            {data: 'created_at'},
            {data: 'nama_produk'},
            {data: 'jumlah'},
            {data: 'jumlah_produksi'},
            {data: 'lost'},
            {data: 'aksi', searchable: false, sortable: false},
          ]
        });

        $('#modal_form_lost form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                  url: $('#modal_form_lost form').attr('action'),
                  method: $('#modal_form_lost [name=_method]').val() ?? 'PUT',
                  data: $('#modal_form_lost form').serialize(),
                  dataType: "json"
              })
              .done((response) => {
                $('#modal_form_lost').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
              });
            }
        })

        $('#modal_form_selesai form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                  url: $('#modal_form_selesai form').attr('action'),
                  method: $('#modal_form_selesai [name=_method]').val() ?? 'PUT',
                  data: $('#modal_form_selesai form').serialize(),
                  dataType: "json"
              })
              .done((response) => {
                $('#modal_form_selesai').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
              });
            }
        })

    });

    function selesaiLostLab(url, url_show) {
        $('#modal_form_selesai').modal('show');
        $('#modal_form_selesai .modal-title').text('lost');

        $('#modal_form_selesai form')[0].reset();
        $('#modal_form_selesai form').attr('action',url);
        $('#modal_form_selesai [name=_method]').val('PUT');
        $('#modal_form_selesai [name=lost]').focus();
    }


    function plusLost(url, url_show) {
        $('#modal_form_lost').modal('show');
        $('#modal_form_lost .modal-title').text('lost');

        $('#modal_form_lost form')[0].reset();
        $('#modal_form_lost form').attr('action' ,url);
        $('#modal_form_lost [name=_method]').val('put');
        $('#modal_form_lost [name=lost]').focus();
    }

</script>
@endpush
