@extends('layouts.master')

@section('title')
      Grade_Lab_Produksi
@endsection

@section('breadcrumb')
@parent
<li class="active">Grade_Lab_Produksi</li>
@endsection

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <a href="{{ route('labProduksi.index') }}" class="btn btn-sm btn-flat btn-info">Back</a>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
                    @error('id_produksi')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group @error('id_bahan') has-error @enderror">
                        <label>Produk</label>
                        <select class="form-control select2" style="width: 100%;" name="id_bahan" id="id_bahan">
                            {{-- <option value="">Pilih Bahan</option>
                            @foreach ($bahan as $item)
                            <option value="{{ $item->id_bahan }}">{{ $item->nama_bahan }}</option>
                            @endforeach --}}
                        </select>
                        @error('id_bahan')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group @error('jumlah') has-error @enderror">
                        <label for="jumlah">Stok</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control">
                        @error('jumlah')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-flat btn-primary">Simpan</button>
                    </div>
                </div>
                <div class="col-md-6">
                    @if (session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        {{ session()->get('errors-throw') }}
                    </div>
                    @endif

                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    <div class="form-group @error('jumlah') has-error @enderror">
                        <label for="jumlah">Hasil Produk Jadi</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control">
                        @error('jumlah')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>

<div class="box box-default">
    <div class="box-header with-border">

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" action="">
            <div id="firstproduct">
            <div class="productdiv">
            <div class="form-group row">
                <label class="col-md-2">Bagi Jumlah Produk</label>
                <div class="col-md-8">
                    <input type="number" name="jumlah_hasil_produksi[]" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2">Grade</label>
                <div class="col-md-8">
                    <select name="id_grade[]" id="id_grade" class="form-control" required>
                        <option value="">Pilih Grade</option>
                            <option value="jakarta">Jakarta</option>
                            <option value="jakarta">Bandung</option>
                            <option value="jakarta">Jogja</option>
                    </select>
                </div>
            </div>

            </div>
            </div>

            <div id="moreproduct"></div>
            {{-- <div id="moreproduct"></div> --}}

            <div class="form-group row">
                <label class="col-md-2"></label>
                <div class="col-md-8">
                    <input type="submit" name="submit" value="submit" class="btn btn-primary">
                    <button type="button" class="btn btn-info" onclick="addProduct();">Tambah</button>
                    <button type="button" class="btn btn-info" onclick="removeProduct();">Remove</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
</div>


@includeIf('grade.form')
@endsection

@push('scripts')

<script>
    function addProduct() {
        $('#firstproduct .productdiv').clone().find('input').val('').end().appendTo('#moreproduct');
            find('select').val('').end().appendTo('#moreproduct');
        // $('.gardediv').clone().appendTo('#moregrade');
    }
    function removeProduct() {
        $('#moreproduct .productdiv').last().remove();
    }

</script>

<script>
  let table;

    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('grade.data') }}',
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'nama_grade'},
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
      $('#modal-form .modal-title').text('Tambah Grade');

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
