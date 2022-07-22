@extends('layouts.master')

@section('title')
      Request Produksi
@endsection

@section('breadcrumb')
@parent
<li class="active">Request Produksi</li>
@endsection

@section('content')


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <button onclick="addForm('{{ route('owner.store') }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">No</th>
                {{-- <th>
                  <input type="checkbox" name="select_all" id="select_all">
                </th> --}}
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Status</th>
                <th>Keterangan</th>

                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('owner.form')
@endsection

@push('scripts')
<script>
  let table;

    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('owner.data') }}',
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            // {data: 'select_all'},
            {data: 'nama_produk'},
            {data: 'jumlah'},
            {data: 'satuan'},
            {data: 'status'},
            {data: 'keterangan'},
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
    });

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah Request Produksi');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=id_produk]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Request Produksi');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action',url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=id_produk]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=id_produk]').val(response.kode_barangmasuk);
          $('#modal-form [name=jumlah]').val(response.id_bahan);
          $('#modal-form [name=id_status]').val(response.id_kategori);
          $('#modal-form [name=id_satuan]').val(response.id_supplier);
          $('#modal-form [name=keterangan]').val(response.jumlah_bahan);
        })
      .fail((errors) => {
          alert('Tidak dapat menampilkan data');
          return;
      });

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
