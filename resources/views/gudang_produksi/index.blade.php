@extends('layouts.master')

@section('title')
    Gudang Produksi
@endsection

@section('breadcrumb')
    @parent
    <li class="active"> Gudang Produksi </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    {{-- <a href="/lab/cetak_pdf" class="btn btn-primary btn-xs" target="_blank">Cetak PDF</a> --}}
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode Produksi</th>
                            <th>Produk</th>
                            <th>Grade</th>
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


    {{-- @includeIf('gudang_request.form_ket') --}}
@endsection

@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('gudang_produksi.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_produksi'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_grade'
                    },
                    {
                        data: 'jumlah_produk'
                    },
                    {
                        data: 'stok'
                    },
                    @can('gudang_delete')
                        {
                            data: 'aksi',
                            searchable: false,
                            sortable: false
                        },
                    @endcan
                ]
            });

            /*
             * Submit form edit
             */
            $('#modal_form_ket form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
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
                            errors.responseJSON !== '' ? alert(errors.responseJSON) : alert(
                                'Tidak dapat menyimpan data');
                            return;
                        });
                }
            })

        });

        function terimaPermintaanKeGudang(url) {
            if (confirm('Terima Permintaan bahan produksi ?')) {
                $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            '_token': $('[name=csrf-token]').attr('content')
                        },
                        dataType: "json"
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert(errors.responseText);
                        return;
                    });
            }
        }

        function tolakPermintaanKeGudang(url) {
            $('#modal_form_ket').modal('show');
            $('#modal_form_ket .modal-title').text('Keterangan di tolak');

            $('#modal_form_ket form')[0].reset();
            $('#modal_form_ket form').attr('action', url);
            $('#modal_form_ket [name=_method]').val('put');
            $('#modal_form_ket [name=keterangan]').focus();
        }
    </script>
@endpush
