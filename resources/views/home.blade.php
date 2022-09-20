@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        @can(['barangmasuk_index', 'barangmasuk_create', 'barangmasuk_edit', 'barangmasuk_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $barangmasuk }}</h3>
                        <p>Barang Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('barangmasuk.index') }}" class="small-box-footer">Lanjut Barang Masuk<i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        <!-- ./col -->
        @can(['lab_index', 'lab_create', 'lab_edit', 'lab_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $lab }}</h3>
                        <p>Jumlah Barang Lab</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('lab.index') }}" class="small-box-footer">Lanjut Lab <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        <!-- ./col -->
        @can(['labproduksi_index', 'labproduksi_create', 'labproduksi_edit', 'labproduksi_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $labproduksi }}</h3>
                        <p>Jumlah Lab Produksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('lab-produksi.index') }}" class="small-box-footer">Lanjut Lab Produksi<i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        <!-- ./col -->
        @can(['gudang_index', 'gudang_create', 'gudang_edit', 'gudang_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $gudang }}</h3>
                        <p>Jumlah bahan gudang</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('gudang.index') }}" class="small-box-footer">Jumlah Bahan Di gudang<i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        <!-- ./col -->
        @can(['gudang_index', 'gudang_create', 'gudang_edit', 'gudang_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $gudangprodukjadi }}</h3>
                        <p>Jumlah produk gudang sesuai grade</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('gudang_produksi.index') }}" class="small-box-footer">Jumlah Bahan Di gudang<i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        @can(['gudang_index', 'gudang_create', 'gudang_edit', 'gudang_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>{{ $permintaanbahan }}</h3>
                        <p>Gudang permintaan Bahan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('gudang_request.index') }}" class="small-box-footer">Jumlah Bahan Di gudang<i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        @can(['produksibarang_index', 'produksibarang_create', 'produksibarang_edit', 'produksibarang_delete'])
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $produksibarang }}</h3>
                        <p>Proses Produksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-podium"></i>
                    </div>
                    <a href="{{ route('produksi.index') }}" class="small-box-footer">Jumlah Produksi<i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h4>TOTAL PRODUK DIGUDANG</h4>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Produk</th>
                            <th>Grade</th>
                            <th>Jumlah Produk</th>
                            <th>Stok</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('dashboard.total.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_grade'
                    },
                    {
                        data: 'jumlah_count'
                    },
                    {
                        data: 'stok_count'
                    },
                ]
            });

        });
    </script>
@endpush
