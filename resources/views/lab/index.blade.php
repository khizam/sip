@extends('layouts.master')

@section('title')
      Lap Uji Bahan Awal
@endsection

@section('breadcrumb')
@parent
<li class="active">Lap Uji Bahan Awal</li>
@endsection

@section('content')


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            {{-- <button onclick="" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button> --}}
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">No</th>
                {{-- <th>
                  <input type="checkbox" name="select_all" id="select_all">
                </th> --}}
                <th>Tanggal</th>
                <th>Nama bahan</th>
                <th>Jumlah bahan</th>
                <th>Bahan Layak</th>
                <th>Bahan Tdk Layak</th>
                {{-- <th>Satuan</th>
                <th>Parameter</th>
                <th>Hasil</th>
                <th>Kesimpulan</th> --}}
                <th>Grid</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('lab.form')
@endsection

@push('scripts')
<script>
  let table;

    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('lab.data') }}',
            dataSrc: (result) => {
              return result.data.map((result) => {
                  result.satuan = result.satuan ?? 'Data kosong'
                //   result.parameter = result.parameter ?? 'Data kosong'
                //   result.hasil = result.hasil ?? 'Data kosong'
                //   result.kesimpulan = result.kesimpulan ?? 'Data kosong'
                //   result.grid = result.grid ?? 'Data kosong'
                  return result
                }
              )
            }
          },
          columns: [
            // console.log(data)
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            // {data: 'select_all'},
            {data: 'updated_at'},
            {data: 'nama_bahan'},
            {data: 'jumlah_bahan'},
            {data: 'bahan_layak'},
            {data: 'bahan_tidak_layak'},
            {data: 'satuan'},
            // {data: 'parameter'},
            // {data: 'hasil'},
            // {data: 'kesimpulan'},
            // {data: 'grid'},
            {data: 'aksi', searchable: false, sortable: false},
          ]
        });

        /*
        * Submit form edit
        */
        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                  url: $('#modal-form form').attr('action'),
                  method: $('#modal-form [name=_method]').val() ?? 'PUT',
                  data: $('#modal-form form').serialize(),
                  dataType: "json"
              })
              .done((response) => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                console.log(errors)
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
              });
            }
        })
    });

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah Barangmasuk');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=id_bahan]').focus();
    }

    function editForm(url, formUrl) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Bahan Layak dan tidak');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action',formUrl);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=bahan_layak]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=id_barangmasuk]').val(response.id_barangmasuk);
          $('#modal-form [name=kd_barangmasuk]').val(response.barang_masuk.kode_barangmasuk);
          $('#modal-form [name=id_bahan]').val(response.barang_masuk.bahan.nama_bahan);
          $('#modal-form [name=id_kategori]').val(response.barang_masuk.kategori.nama_kategori);
          $('#modal-form [name=id_supplier]').val(response.barang_masuk.supplier.nama_supplier);
          $('#modal-form [name=jumlah_bahan]').val(response.barang_masuk.jumlah_bahan);
          $('#modal-form [name=bahan_layak]').val(response.bahan_layak);
          $('#modal-form [name=bahan_tidak_layak]').val(response.bahan_tidak_layak);
          $('#modal-form [name=status][value='+response.status+']').prop('checked', true);
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
