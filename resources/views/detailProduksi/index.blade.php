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

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <form action="" method="post">
        @csrf
        @method('post')

      <div class="col-md-6">
        <div class="form-group">
          <label>Bahan</label>
          <select class="form-control select2" style="width: 100%;"  id="kota">
            <option selected="selected" name="id_bahan" id="id_bahan">Pilih Bahan</option>
            @foreach ($bahan as $key => $item)
              <option value="{{ $key }}">{{ $item }}</option>
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
      <!-- /.col -->
      <div class="col-md-6">
       
        <!-- /.form-group -->
        <div class="form-group">
          {{-- <label>Produk</label> --}}
          {{-- <select class="form-control select2" style="width: 100%;" id="kota2" >
            <option selected="selected">Pilih Produk</option>
            
          </select> --}}
        </div>
        
        <!-- /.form-group -->
      </div>
      <!-- /.col -->
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
@endsection

@push('scripts')

<!-- Select2 -->
<script src="{{asset('template/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- wajib jquery  -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    let table;

    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('detailProduksi.data') }}',
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            // {data: 'select_all'},
            {data: 'nama_bahan'},
            {data: 'jumlah'},
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
      $('#modal-form .modal-title').text('Tambah Detail Produksi');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=id_bahan]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Detail Produksi');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action',url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=id_bahan]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=id_bahan]').val(response.id_bahan);
          $('#modal-form [name=jumlah]').val(response.jumlah);
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

  })
</script>
@endpush
