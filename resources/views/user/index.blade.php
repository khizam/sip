@extends('layouts.master')

@section('title')
      User
@endsection

@section('breadcrumb')
@parent
<li class="active">User</li>
@endsection

@section('content')


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <div id="route_create" data-route="{{ route("user.create") }}"></div>
            <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <th width="5%">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('user.form')
@endsection

@push('scripts')
<script>
  let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
              url: '{{ route('user.data') }}',
            },
            columns: [
              {data: 'DT_RowIndex', searchable: false, sortable: false},
              {data: 'name'},
              {data: 'email'},
              {data: 'roles[0].name'},
              {data: 'created_at'},
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
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();
        $('#modal-form form')[0].reset();
        $("#role option").each(function() {
            $(this).remove();
        });
        let url_create = $("#route_create").attr("data-route");
        $.get(url_create)
        .done((response) => {
            let option = '<option value="">Pilih Role</option>'
            response.forEach(value => {
                console.log(value)
                option += '<option value="' + value.id + '">'+value.name+'</option>'
            });
            $("#role").append(option);
        })
        .fail((errors) => {
            alert(errors)
            return;
        });
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_User]').focus();

        $.get(url)
            .done((response) => {
              $('#modal-form [name=nama_User]').val(response.nama_User);
            })
            .fail((errors) => {
                alert(errors)
                return;
            });
    }
      function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
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
