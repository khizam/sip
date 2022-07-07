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
            <button onclick="cetakLab('{{ route('lab.store') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-id-card"></i> Cetak Lab</button>
            {{-- <button onclick="" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button> --}}
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">
                  <input type="checkbox" name="select_all" id="select_all">
                </th>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Nama bahan</th>
                <th>Jumlah bahan</th>
                <th>Bahan Layak</th>
                <th>Bahan Tdk Layak</th>
                <th>Satuan</th>
                <th>Status</th>
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
@includeIf('lab.form_edit')
@includeIf('lab.form_check')
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
                  return result
                }
              )
            }
          },
          columns: [

            {data: 'select_all', searchable: false, sortable: false},

            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'updated_at'},
            {data: 'nama_bahan'},
            {data: 'jumlah_bahan'},
            {data: 'bahan_layak'},
            {data: 'bahan_tidak_layak'},
            {data: 'satuan'},
            {data: 'status'},
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
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
              });
            }
        })

        $('[name=select_all]').on('click', function () {
          $(':checkbox').prop('checked', this.checked);
        });

        $('#modal-form-edit-lab').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                  url: $('#modal-form-edit-lab form').attr('action'),
                  method: $('#modal-form-edit-lab [name=_method]').val() ?? 'PUT',
                  data: $('#modal-form-edit-lab form').serialize(),
                  dataType: "json"
              })
              .done((response) => {
                $('#modal-form-edit-lab').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
              });
            }
        })

        $('#modal-form-check').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
              $.ajax({
                  url: $('#modal-form-check form').attr('action'),
                  method: $('#modal-form-check [name=_method]').val() ?? 'PUT',
                  data: $('#modal-form-check form').serialize(),
                  dataType: "json"
              })
              .done((response) => {
                $('#modal-form-check').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                errors.responseJSON !== '' ? alert(errors.responseJSON) : alert('Tidak dapat menyimpan data');
                return;
              });
            }
        })
    });

    function check(url, formUrl) {
      $('#modal-form-check').modal('show');
      $('#modal-form-check .modal-title').text('Status');

      $('#modal-form-check form')[0].reset();
      $('#modal-form-check form').attr('action', formUrl);
      $('#modal-form-check [name=_method]').val('put');
      $.get(url)
        .done((response) => {
          $('#modal-form-check [name=id_lab]').val(response.id_lab);
          $('#modal-form-check [name=status][value="'+response.status+'"]').prop('checked', true);
        })
      .fail((errors) => {
          alert(errors.responseJSON ?? 'Tidak dapat menampilkan data');
          return;
      });
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
          $('#modal-form [name=id_lab]').val(response.id_lab);
          $('#modal-form [name=kd_barangmasuk]').val(response.barang_masuk.kode_barangmasuk);
          $('#modal-form [name=id_bahan]').val(response.barang_masuk.bahan.nama_bahan);
          $('#modal-form [name=id_kategori]').val(response.barang_masuk.kategori.nama_kategori);
          $('#modal-form [name=id_supplier]').val(response.barang_masuk.supplier.nama_supplier);
          $('#modal-form [name=jumlah_bahan]').val(response.barang_masuk.jumlah_bahan);
          $('#modal-form [name=bahan_layak]').val(response.bahan_layak);
          $('#modal-form [name=bahan_tidak_layak]').val(response.bahan_tidak_layak);
          $('#modal-form [name=status][value="'+response.status+'"]').prop('checked', true);
        })
      .fail((errors) => {
          alert(errors.responseJSON ?? 'Tidak dapat menampilkan data');
          return;
      });

    }

    function editLabForm(url, formUrl) {
      $('#modal-form-edit-lab').modal('show');
      $('#modal-form-edit-lab .modal-title').text('Edit Lab');

      $('#modal-form-edit-lab form')[0].reset();
      $('#modal-form-edit-lab form').attr('action',formUrl);
      $('#modal-form-edit-lab [name=_method]').val('put');
      $('#modal-form-edit-lab [name=satuan]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form-edit-lab [name=id_lab]').val(response.id_barangmasuk);
          $('#modal-form-edit-lab [name=kd_barangmasuk]').val(response.barang_masuk.kode_barangmasuk);
          $('#modal-form-edit-lab [name=satuan] option[value="'+response.satuan+'"]').attr("selected", "selected");
          $('#modal-form-edit-lab [name=parameter]').val(response.parameter);
          $('#modal-form-edit-lab [name=hasil]').val(response.hasil);
          $('#modal-form-edit-lab [name=kesimpulan]').val(response.kesimpulan);
          $('#modal-form-edit-lab [name=grid]').val(response.grid);
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

    function cetakLab(url) {
          if ($('input:checked').length < 1) {
              alert('Pilih data yang akan dicetak');
              return;
            } else if ($('input:checked').length < 3) {
              alert('Pilih minimal 3 data untuk dicetak');
              return;
            } else {
              $('.form-lab')
              .attr('target', '_blank')
              .attr('action', url)
              .submit();
            }
      }


</script>
@endpush
