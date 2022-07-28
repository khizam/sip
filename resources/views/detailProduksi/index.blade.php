@extends('layouts.master')

@section('title')
      Detail Produksi
@endsection

@section('breadcrumb')
@parent
<li class="active">Detail Produksi</li>
@endsection

@section('content')


<div class="box box-default">
  <div class="box-header with-border">
    {{-- <h3 class="box-title">Select2</h3> --}}
    <a href="{{ route('produksi.index') }}" class="btn btn-sm btn-flat btn-info">Back</a>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <form action="{{ route('detailProduksi.store') }}" method="post">
        @csrf
        @method('post')
        <input type="hidden" name="id_produksi" value="{{ request()->route('id_produksi') }}">
        <div class="col-md-6">
            <div class="form-group">
                <label>Bahan</label>
                <select class="form-control select2" style="width: 100%;" name="id_bahan" id="id_bahan">
                    <option selected="selected" >Pilih Bahan</option>
                    @foreach ($bahan as $item)
                    <option value="{{ $item->id_bahan }}">{{ $item->nama_bahan }}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label for="jumlah">Jumlah Bahan</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="0">
                    <span class="help-block with-errors"></span>
                </div>

                <button class="btn btn-sm btn-flat btn-primary">Simpan</button>
        </div>
        </form>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.box-body -->

</div>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">

      </div>
      <div class="box-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <th width="5%">No</th>
            {{-- <th>
              <input type="checkbox" name="select_all" id="select_all">
            </th> --}}
            <th>Nama Bahan</th>
            <th>Jumlah</th>
            <th>Permintaan Bahan</th>
            <th width="15%"><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- @includeIf('detailProduksi.form') --}}
{{-- @includeIf('detailProduksi.form') --}}
@includeIf('detailProduksi.form_edit')
@endsection

@push('scripts')

<!-- Select2 -->
<script src="{{asset('template/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- wajib jquery  -->
<script>

    let table;

    $(function () {
        $('.select2').select2()
        let url = '{{ route("detailProduksi.data", request()->route("id_produksi")) }}'
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: url,
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            // {data: 'select_all'},
            {data: 'nama_bahan'},
            {data: 'jumlah'},
            {data: "permintaan_bahan"},
            {data: 'aksi', searchable: false, sortable: false},
          ]
        });

        $('#modal-form').validator().on('submit', function (e) {
          if (! e.preventDefault()) {
            $.ajax({
              url: $('#modal-form form').attr('action'),
              method: $('#modal-form [name=_method]').val() ?? 'PUT',
              data: $('#modal-form form').serialize(),
              dataTYPE: "json"
            })
            .done((response) => {
              $('#modal-form').modal('hide');
              table.ajax.reload();
            })
            .fail((errors) => {
              errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
              return;
            });
          }
        })

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                url: $('#modal-form form').attr('action'),
                method: $('#modal-form [name=_method]').val() ?? 'PUT',
                data: $('#mdal-form form').serialize(),
                dataType: "json"
              })
              // $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
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

        $('#modal-form-edit-detail').validator().on('submit', function (e) {
          if ( e.preventDefault()) {
            $.ajax({
              url: $('#modal-form-edit-detail form').attr('action'),
              method: $('#modal-form-edit-detail [name=_method]').val() ?? 'PUT',
              data: $('modal-form-edit-detail form').serialize(),
              dataType: "json"
            })
            .done((response) => {
              $('#modal-form-edit-detail').modal('hide');
              table.ajax.reload();
            })
            .fail((errors) => {
              errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
              return;
            });
          }
        })

      $('#modal-form-edit-detail').validator().on('submit', function (e) {
        if ( e.preventDefault()) {
          $.ajax({
              url: $('#modal-form-edit-detail form').attr('action'),
              method: $('#modal-form-edit-detail [name=_method]').val() ?? 'PUT',
              data: $('#modal-form-edit-detail form').serialize(),
              dataType: "json"
          })
          .done((response) => {
            $('#modal-form-edit-detail'),modal('hide');
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
      $('#modal-form .modal-title').text('Tambah Detail Produksi');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=id_bahan]').focus();
    }

    function editDetailForm(url, formUrl) {
      $('#modal-form-edit-detail').modal('show');
      $('#modal-form-edit-detail .modal-title').text('Edit Detail Produksi');

      $('#modal-form-edit-detail')[0].reset();
      $('#modal-form-edit-detail').attr('action',formUrl);
      $('#modal-form-edit-detail [name=_method]').val('put');
      $('#modal-form-edit-detail [name=id_bahan]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form-edit-detail [name=id_detail]').val(response.id_detail);
          $('#modal-form-edit-detail [name=id_bahan]').val(response.bahan.nama_bahan);
          $('#modal-form-edit-detail [name=id_produksi]').val(response.id_produksi);
          $('#modal-form-edit-detail [name=jumlah]').val(response.jumlah);
        })
      .fail((errors) => {
        alert(errors.responseJSON ?? 'Tidak dapat menampilkan data');
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
