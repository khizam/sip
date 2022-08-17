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
                {{-- <input type="hidden" name="id_produksi" value="{{ request()->route('id_produksi') }}"> --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" readonly value="{{ $produksibarang->nama_produk }}">
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jumlah Hasil Produksi</label>
                        <input type="number" name="jumlah_produksi" id="jumlah_produksi" class="form-control" readonly value="{{ $labproduksi->jumlah_hasil_produksi }}">
                    </div>
                </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>

<div class="box box-default">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <form action="{{ route('grade-lab-produksi.store') }}" method="post">
            @csrf
            @method('post')
                <input type="hidden" name="id_produksi" value="{{ request()->route('id_produksi') }}">
                <div class="col-md-6">
                    @error('id_produksi')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group @error('id_grade') has-error @enderror">
                        <label>Grade</label>
                        <select class="form-control select2" style="width: 100%;" name="id_grade" id="id_grade">
                            <option value="">Pilih Grade</option>
                            @foreach ($grade as $item)
                            <option value="{{ $item->id_grade }}">{{ $item->nama_grade }}</option>
                            @endforeach
                        </select>
                        @error('id_grade')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-flat btn-primary">Simpan</button>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group @error('jumlah_produk') has-error @enderror">
                        <label for="jumlah_produk">Hasil Bagi Jumlah Produk</label>
                        <input type="number" name="jumlah_produk" id="jumlah_produk" class="form-control">
                        @error('jumlah_produk')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if (session()->has('errors-throw'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        {{ session()->get('errors-throw') }}
                    </div>
                    @endif
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
          <h4>Grade Lab Produksi</h4>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <th width="5%">No</th>
              <th>Nama Grade</th>
              <th>Jumlah Produk</th>
              <th>Stok</th>
              <th width="15%"><i class="fa fa-cog"></i></th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<div class="row" style="margin-bottom: 1rem">
    <div class="col-md-12" style="display: flex; flex-direction: column">
        <button type="button" class="btn btn-success" onclick="tambahkanKeGudangProduksi('{{ route('gudang_produksi.store') }}')" id="tambah_gudang" data-proses="{{ request()->segment(3) }}">Tambahkan ke Gudang Produksi</button>
    </div>
</div>
@endsection

@push('scripts')

<!-- Select2 -->
<script src="{{asset('template/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- wajib jquery  -->
<script>
    let table;
    $(function () {
        $('.select2').select2()
        let url = '{{ route("grade-lab-produksi.data", request()->route("id_produksi")) }}'
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: url,
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'nama_grade'},
            {data: 'jumlah_produk'},
            {data: 'stok'},
            {data: 'aksi', searchable: false, sortable: false},
          ]
        });

        $('#modal_edit_detail').validator().on('submit', function (e) {
            e.preventDefault()
            console.log('da')
            let url = $('#modal_edit_detail').attr('action')
            console.log(url)
            $.ajax({
                url: url,
                method: $('#modal_edit_detail [name=_method]').val() ?? 'PUT',
                data: $('#modal_edit_detail form').serialize(),
                dataType: "json"
            })
            .done((response) => {
                $('#modal_edit_detail').modal('hide');
                table.ajax.reload();
            })
            .fail((errors) => {
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
            });
        })
    });


    function editDetailForm(url, formUrl) {
        $('#modal_edit_detail').modal('show');
        $('#modal_edit_detail .modal-title').text('Edit Detail Produksi');

        $('#modal_edit_detail form')[0].reset();
        $('#modal_edit_detail').attr('action',formUrl);
        $('#modal_edit_detail [name=_method]').val('put');
        $('#modal_edit_detail [name=id_grade]').focus();
        $('#modal_edit_detail [name=id_grade]').find('option:not(:first)').removeAttr('selected',true).trigger('change');
        $.get(url)
            .done((response) => {
                $('#modal_edit_detail [name=id_detail]').val(response.id_detail);
                $('#modal_edit_detail [name=id_produksi]').val(response.id_produksi);
                $('#modal_edit_detail [name=jumlah]').val(response.jumlah);
                $('#modal_edit_detail [name=id_grade] option[value="'+response.id_grade+'"]').attr("selected", true);
                $('#modal_edit_detail [name=id_grade]').trigger('change');
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

    function permintaanKeGudang(url) {
      if (confirm('Permintaan ke gudang ?')) {
        $.post(url, {
          '_token': $('[name=csrf-token]').attr('content'),
        })
        .done((response) => {
          table.ajax.reload();
        })
        .fail((errors) => {
          alert(errors);
          return;
        });
      }
    }

    function tambahkanKeGudangProduksi(url) {
        if (confirm('Apakah akan ditambahkan ke gudang produksi ?')) {

            let id_produksi = $('#tambah_gudang').attr('data-proses')
            let token =  $('[name=csrf-token]').attr('content')
            let data = {
                '_token': $('[name=csrf-token]').attr('content'),
                'id_produksi': id_produksi
            }

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json'
            })
            .done((response) => {
                window.location.href = response
            })
            .fail((errors) => {
                alert(errors.responseJSON);
                return;
            });
        }
    }

</script>
@endpush
