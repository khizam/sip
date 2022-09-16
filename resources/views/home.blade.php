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
          <a href="{{ route('barangmasuk.index') }}" class="small-box-footer">Lanjut Barang Masuk<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
      <!-- ./col -->
      @can(['lab_index','lab_create','lab_edit','lab_delete'])
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
          <a href="{{ route('lab.index') }}" class="small-box-footer">Lanjut Lab <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
      <!-- ./col -->
      @can(['labproduksi_index','labproduksi_create','labproduksi_edit','labproduksi_delete'])
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{$labproduksi}}</h3>
            <p>Jumlah Lab Produksi</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ route('lab-produksi.index') }}" class="small-box-footer">Lanjut Lab Produksi<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
      <!-- ./col -->
      @can(['gudang_index','gudang_create','gudang_edit','gudang_delete'])
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{$gudang}}</h3>
            <p>Jumlah bahan gudang</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{ route('gudang.index') }}" class="small-box-footer">Jumlah Bahan Di gudang<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
      <!-- ./col -->
      @can(['gudang_index','gudang_create','gudang_edit','gudang_delete'])
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{$gudangprodukjadi}}</h3>
            <p>Jumlah produk gudang sesuai grade</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{ route('gudang_produksi.index') }}" class="small-box-footer">Jumlah Bahan Di gudang<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
      @can(['gudang_index','gudang_create','gudang_edit','gudang_delete'])
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
          <div class="inner">
            <h3>{{$permintaanbahan}}</h3>
            <p>Gudang permintaan Bahan</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{ route('gudang_request.index') }}" class="small-box-footer">Jumlah Bahan Di gudang<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
      @can(['produksibarang_index','produksibarang_create','produksibarang_edit','produksibarang_delete'])
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{$produksibarang}}</h3>
            <p>Proses Produksi</p>
          </div>
          <div class="icon">
            <i class="ion ion-podium"></i>
          </div>
          <a href="{{ route('produksi.index') }}" class="small-box-footer">Jumlah Produksi<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endcan
</div>

<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Monthly Recap Report</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <div class="btn-group">
                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </div>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-8">
                <p class="text-center">
                  <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                </p>

                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="salesChart" style="height: 180px;"></canvas>
                </div>
                <!-- /.chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <p class="text-center">
                  <strong>Goal Completion</strong>
                </p>

                <div class="progress-group">
                  <span class="progress-text">Add Products to Cart</span>
                  <span class="progress-number"><b>160</b>/200</span>

                  <div class="progress sm">
                    <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                  </div>
                </div>
                <!-- /.progress-group -->
                <div class="progress-group">
                  <span class="progress-text">Complete Purchase</span>
                  <span class="progress-number"><b>310</b>/400</span>

                  <div class="progress sm">
                    <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                  </div>
                </div>
                <!-- /.progress-group -->
                <div class="progress-group">
                  <span class="progress-text">Visit Premium Page</span>
                  <span class="progress-number"><b>480</b>/800</span>

                  <div class="progress sm">
                    <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                  </div>
                </div>
                <!-- /.progress-group -->
                <div class="progress-group">
                  <span class="progress-text">Send Inquiries</span>
                  <span class="progress-number"><b>250</b>/500</span>

                  <div class="progress sm">
                    <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                  </div>
                </div>
                <!-- /.progress-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- ./box-body -->
          <div class="box-footer">
            <div class="row">
              <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                  <h5 class="description-header">$35,210.43</h5>
                  <span class="description-text">TOTAL REVENUE</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                  <h5 class="description-header">$10,390.90</h5>
                  <span class="description-text">TOTAL COST</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                  <h5 class="description-header">$24,813.53</h5>
                  <span class="description-text">TOTAL PROFIT</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-xs-6">
                <div class="description-block">
                  <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                  <h5 class="description-header">1200</h5>
                  <span class="description-text">GOAL COMPLETIONS</span>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
</div>
@endsection
