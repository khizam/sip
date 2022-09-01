@extends('layouts.master')

@section('title')
    Parameter Lab
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Parameter Lab</li>
@endsection
{{-- {{ dd(session()->all()) }} --}}
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <a href="{{ route('lab.index') }}" class="btn btn-sm btn-flat btn-info">Back</a>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Parameter</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h4>Tambah Parameter</h4>
                </div>
                <div class="box-body">
                    <form action="{{ route('detailParameter.store') }}" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" name="id_lab" value="{{ request()->segment(3) }}">
                        <div class="col-md-12">
                            @if (session()->has('errors'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    {{ session()->get('errors-throw') }}
                                </div>
                            @endif

                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Parameter Lab</label>
                                <select class="form-control select2" multiple="multiple"
                                    data-placeholder="Pilih Parameter Lab" name="id_parameter[]" id="id_parameter"
                                    style="width: 100%;">
                                    @foreach ($parameter as $item)
                                        <option value="{{ $item->id_parameter }}">{{ $item->nama_parameter }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-flat btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @isset($statusProduksi)
        @if (!is_null($statusProduksi) && $statusProduksi->id_status == \App\Models\Enums\StatusProduksiEnum::Terima)
            <div class="row" style="margin-bottom: 1rem">
                <div class="col-md-12" style="display: flex; flex-direction: column">
                    <button type="button" class="btn btn-success"
                        onclick="canProsesProduksi('{{ route('produksi.proses_produksi') }}')" id="proses_produksi"
                        data-proses="{{ request()->segment(3) }}">Proses Produksi</button>
                </div>
            </div>
        @endisset
    @endif

    @includeIf('detailParameter.form_edit')
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- wajib jquery  -->
    <script>
        let table;
        $(function() {
            $('.select2').select2()
            let url = '{{ route('detailParameter.data', request()->route('id_lab')) }}'
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: url,
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_parameter'
                    },
                    // {data: 'proses'},
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#modal_edit_detail').validator().on('submit', function(e) {
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
                        errors.responseJSON !== '' ? alert(errors.responseJSON) : alert(
                            'Tidak dapat menyimpan data');
                        return;
                    });
            })
        });


        function editDetailForm(url, formUrl) {
            $('#modal_edit_detail').modal('show');
            $('#modal_edit_detail .modal-title').text('Edit Detail Produksi');

            $('#modal_edit_detail form')[0].reset();
            $('#modal_edit_detail').attr('action', formUrl);
            $('#modal_edit_detail [name=_method]').val('put');
            $('#modal_edit_detail [name=id_bahan]').focus();
            $('#modal_edit_detail [name=id_bahan]').find('option:not(:first)').removeAttr('selected', true).trigger(
                'change');
            $.get(url)
                .done((response) => {
                    $('#modal_edit_detail [name=id_detail]').val(response.id_detail);
                    $('#modal_edit_detail [name=id_produksi]').val(response.id_produksi);
                    $('#modal_edit_detail [name=jumlah]').val(response.jumlah);
                    $('#modal_edit_detail [name=id_bahan] option[value="' + response.id_bahan + '"]').attr("selected",
                        true);
                    $('#modal_edit_detail [name=id_bahan]').trigger('change');
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

        function canProsesProduksi(url) {
            if (confirm('Apakah akan dilanjutkan ke proses produksi ?')) {

                let id_produksi = $('#proses_produksi').attr('data-proses')
                let token = $('[name=csrf-token]').attr('content')
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
