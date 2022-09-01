@extends('layouts.master')

@section('title')
    Barang Masuk / Mentah
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Barang Masuk / Mentah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('barangmasuk.store') }}')" class="btn btn-primary btn-xs btn-flat"><i
                            class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode_Bahan</th>
                            <th>Bahan</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Jumlah Bahan</th>
                            <th>Kemasan</th>
                            <th>Nomor Po</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Berat kotor</th>
                            <th>Tara</th>
                            <th>Netto</th>
                            <th>Reject</th>
                            <th>Kendaraan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @includeIf('barangmasuk.form')
@endsection


@push('scripts')
    <script>
        < script src = "{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}" >
    </script>

    </script>

    <script>
        let table;

        $(function() {
            $('#id_bahan').on('change', function(e) {
                e.preventDefault();
                let satuan = $('option:selected', this).attr('data-satuan');
                $('#satuan_bahan').val(satuan);
            });

            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('barangmasuk.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    // {data: 'select_all'},
                    {
                        data: 'kode_barangmasuk'
                    },
                    {
                        data: 'nama_bahan'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'nama_supplier'
                    },
                    {
                        data: 'jumlah_bahan'
                    },
                    {
                        data: 'jenis_kemasan'
                    },
                    {
                        data: 'nomor_po'
                    },
                    {
                        data: 'pengirim'
                    },
                    {
                        data: 'penerima'
                    },
                    {
                        data: 'berat_kotor'
                    },
                    {
                        data: 'tara'
                    },
                    {
                        data: 'netto'
                    },
                    {
                        data: 'reject'
                    },
                    {
                        data: 'kendaraan'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
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
            $('#modal-form .modal-title').text('Tambah Barangmasuk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=id_bahan]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Barangmasuk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=id_bahan]').focus();

            //$('#modal-form [name=satuan]').val(response.satuan.id_satuan);

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=kode_barangmasuk]').val(response.kode_barangmasuk);
                    $('#modal-form [name=id_bahan]').val(response.id_bahan);
                    $('#modal-form [name=id_kategori]').val(response.id_kategori);
                    $('#modal-form [name=id_supplier]').val(response.id_supplier);
                    $('#modal-form [name=id_kemasan]').val(response.id_kemasan);
                    $('#modal-form [name=nomor_po]').val(response.nomor_po);
                    $('#modal-form [name=pengirim]').val(response.pengirim);
                    $('#modal-form [name=penerima]').val(response.penerima);
                    $('#modal-form [name=netto]').val(response.netto);
                    $('#modal-form [name=kendaraan]').val(response.kendaraan);
                    $('#modal-form [name=jumlah_bahan]').val(response.jumlah_bahan);
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
