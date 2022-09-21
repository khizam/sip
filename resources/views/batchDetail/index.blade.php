@extends('layouts.master')

@section('title')
    Batch Produksi
@endsection

@section('breadcrumb')
    @parent
    <li class="active">
        Batch Produksi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <a href="{{ route('produksi.index') }}" class="btn btn-sm btn-flat btn-info">Back</a>
                    <h4>Batch Produksi - @isset($statusProduksi)
                            <i class="bg-primary"
                                style="border-radius: 25% 10%; padding: 3px 5px">{{ $statusProduksi->status->id_status == \App\Models\Enums\StatusProduksiEnum::Terima ? 'Produksi diterima' : $statusProduksi->status->status }}</i>
                        @endisset
                    </h4>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span id="store_url" data-url="{{ route('batch.store') }}"></span>
                            <form action="{{ route('batch.store') }}" method="post" id="form_batch">
                                @csrf
                                @method('post')
                                <input type="hidden" name="id_produksi" value="{{ request()->segment(3) }}">
                                @if (session()->has('fail'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                        {{ session()->get('fail') }}
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
                                @error('id_produksi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group @error('jumlah') has-error @enderror">
                                    <label for="nama">Nama Batch</label>
                                    <input type="text" name="nama" id="nama" class="form-control">
                                    @error('nama')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group @error('jumlah') has-error @enderror">
                                    <label for="jumlah">Jumlah Produksi</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control">
                                    @error('jumlah')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="id_status">Status batch</label>
                                    <select name="id_status" id="id_status" class="form-control" required>
                                        <option value="">Pilih Status Batch</option>
                                        @foreach ($statusbatchs as $key => $item)
                                            <option value="{{ $item->id_status }}">{{ $item->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-flat btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
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

    {{-- @includeIf('detailProduksi.form_edit') --}}
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- wajib jquery  -->
    <script>
        let table;
        $(function() {
            $('.select2').select2()
            let url = '{{ route('batchDetail.data', request()->segment(3)) }}'
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
                        data: 'nama_batch'
                    },
                    {
                        data: 'jumlah_batch'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#form_batch').validator().on('submit', function(e) {
                e.preventDefault()
                let url = $('#form_batch').attr('action')
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('[name=csrf-token]').attr('content')
                        },
                        url: url,
                        method: $('#form_batch [name=_method]').val() ?? 'PUT',
                        data: $('#form_batch').serialize(),
                        dataType: "json"
                    })
                    .done((response) => {
                        table.ajax.reload();
                        resetForm()
                    })
                    .fail((errors) => {
                        errors.responseJSON !== '' ? alert(errors.responseJSON) : alert(
                            'Tidak dapat menyimpan data');
                        return;
                    });
            })
        });


        function editDetailForm(url, formUrl) {
            $('#form_batch').attr('action', formUrl)
            $('#form_batch [name=_method]').val('PUT');
            $.get(url)
                .done((response) => {
                    $('#form_batch [name=id_batch]').val(response.id_batch);
                    $('#form_batch [name=id_produksi]').val(response.id_produksi);
                    $('#form_batch [name=nama]').val(response.nama_batch);
                    $('#form_batch [name=jumlah]').val(response.jumlah_batch);
                    $('#form_batch [name=id_status]').val(response.id_status);
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
                        resetForm()
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function resetForm() {
            $('#form_batch').attr('action', $('#store_url').attr('data-url'))
            $('#form_batch [name=_method]').val('POST');
            $('#form_batch [name=id_batch]').val('');
            $('#form_batch [name=nama]').val('');
            $('#form_batch [name=jumlah]').val('');
        }
    </script>
@endpush
