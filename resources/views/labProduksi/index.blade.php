@extends('layouts.master')

@section('title')
      Produksi ke Lab
@endsection

@section('breadcrumb')
@parent
<li class="active">Produksi ke Lab</li>
@endsection

@section('content')


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <button onclick="addForm('{{ route('labProduksi.store') }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">No</th>
                <th>Hasil Produksi</th>
                <th>Jumlah Produksi</th>
                <th>Lost</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('grade.form')
@includeIf('lab_produksi.form_selesai')
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
            {data: 'id_produksi'},
            {data: 'jumlah_produksi'},
            {data: 'lost'},
            {data: 'aksi', searchable: false, sortable: false},
          ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
              .done((response) => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                alert('Tidak dapat menyimpan data');
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

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Hasil produksi');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=nama_grade]').focus();
    }

    function editForm(url, url_show) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Grade');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action',url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=nama_grade]').focus();
      $.get(url_show)
        .done((response) => {
          $('#modal-form [name=nama_grade]').val(response.nama_grade);
        })
      .fail((errors) => {
          alert('Tidak dapat menampilkan data');
          return;
      });

    }

    function selesaiLostLab(url, url_show) {
        $('#modal_form_selesai').modal('show');
        $('#modal_form_selesai .modal-title').text('lost');

        $('#modal_form_selesai form')[0].reset();
        $('#modal_form_selesai form').attr('action',url);
        $('#modal_form_selesai [name=_method]').val('put');
        $('#modal_form_selesai [name=lost]').focus();
    }


    function deleteData(url) {
      if (confirm('Yakin ingin menghapus data terpilih')) {
        $.post(url, {
          '_token': $('[name=csrf-token]').attr('content'),
          '_method': 'delete'
        })
        .done((response) => {
          table.ajax.reload();
        })
        .fail((errors) => {
          alert('Tidak dapat menghapus data');
          return;
        });
      }
    }
</script>
@endpush
