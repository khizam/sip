@extends('layouts.master')

@section('title')
      Produksi Barang
@endsection

@section('breadcrumb')
@parent
<li class="active">Produksi Barang</li>
@endsection

@section('content')


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            {{-- <button onclick="addForm('{{ route('produksi.store') }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button> --}}
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">No</th>
                {{-- <th>
                  <input type="checkbox" name="select_all" id="select_all">
                </th> --}}
                <th>Kode Produksi</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Jumlah_hasil_produksi</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('produksi.form')
@includeIf('produksi.form_ket')
@includeIf('produksi.form_selesai')
@endsection

@push('scripts')

<script>
  let table;

  $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('produksibarang.data') }}',
            dataSrc: (result) => {
              return result.data.map((result) => {
                  result.satuan = result.satuan ?? 'Data kosong'
                  return result
                }
              )
            }
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'kode_produksi'},
            {data: 'nama_produk'},
            {data: 'jenis'},
            {data: 'jumlah'},
            {data: 'satuan'},
            {data: 'status'},
            {data: 'keterangan'},
            {data: 'jumlah_hasil_produksi'},
            {data: 'aksi', searchable: false, sortable: false},
          ]
        });

        $('#modal_form_ket form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                  url: $('#modal_form_ket form').attr('action'),
                  method: $('#modal_form_ket [name=_method]').val() ?? 'PUT',
                  data: $('#modal_form_ket form').serialize(),
                  dataType: "json"
              })
              .done((response) => {
                $('#modal_form_ket').modal('hide');
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

    function tolakProduksiBarang(url) {
        $('#modal_form_ket').modal('show');
        $('#modal_form_ket .modal-title').text('Keterangan di tolak');

        $('#modal_form_ket form')[0].reset();
        $('#modal_form_ket form').attr('action',url);
        $('#modal_form_ket [name=_method]').val('put');
        $('#modal_form_ket [name=keterangan]').focus();
    }

    function selesaiProduksiBarang(url, url_show) {
        $('#modal_form_selesai').modal('show');
        $('#modal_form_selesai .modal-title').text('jumlah_hasil_produksi');

        $('#modal_form_selesai form')[0].reset();
        $('#modal_form_selesai form').attr('action',url);
        $('#modal_form_selesai [name=_method]').val('put');
        $('#modal_form_selesai [name=jumlah_hasil_produksi]').focus();
    }

    function terimaProduksiBarang(url) {
        if (confirm('Terima Produksi Barang ?')) {
            $.ajax({
                type: "PUT",
                url: url,
                data: {
                    '_token': $('[name=csrf-token]').attr('content')
                },
                dataType: "json"
            })
            .done((response)=>{
                table.ajax.reload();
            })
            .fail((errors)=>{
                alert(errors);
                return;
            });
        }
    }

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah Produksi Barang');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=id_produksi]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Produksi Barang');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action',url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=id_produksi]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=id_produk]').val(response.id_produk);
          $('#modal-form [name=jumlah]').val(response.jumlah);
          $('#modal-form [name=id_satuan]').val(response.id_satuan);
          $('#modal-form [name=keterangan]').val(response.keterangan);
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
