<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

          @can(['supplier_index','bahan_index','produk_index','kategori_index','user_index'])
          <li class="header">Master</li>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>Master Data</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('supplier_index')
              <li class="active"><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i>Supplier</a></li>
              @endcan
              @can('bahan_index')
              <li class="active"><a href="{{ route('bahan.index') }}"><i class="fa fa-reorder"></i>Bahan</a></li>
              @endcan
              @can('produk_index')
              <li class="active"><a href="{{ route('produk.index')}}"><i class="fa fa-cubes"></i>Produk</a></li>
              @endcan
              @can('kategori_index')
              <li class="active"><a href="{{ route('kategori.index') }}"><i class="fa fa-cube"></i>Kategori</a></li>
              @endcan
              @can('user_index')
              <li class="active"><a href="{{ route('user.index') }}"><i class="fa fa-user"></i>User</a></li>
              @endcan
              @can('user_index')
              <li class="active"><a href="{{ route('satuan.index') }}"><i class="fa fa-cube"></i>Satuan</a></li>
              @endcan
              @can('user_index')
              <li class="active"><a href="{{ route('grade.index') }}"><i class="fa fa-sort-amount-asc"></i>Grade</a></li>
              @endcan
              @can('user_index')
              <li class="active"><a href="{{ route('parameter.index') }}"><i class="fa fa-sort-amount-asc"></i>Parameter</a></li>
              @endcan
              @can('user_index')
              <li class="active"><a href="{{route('kemasan.index') }}"><i class="fa fa-caret-square-o-down"></i>Kemasan</a></li>
              @endcan
              @can('user_index')
              <li class="active"><a href="{{route('jenisproduksi.index') }}"><i class="fa  fa-pie-chart"></i>Jenis Produksi</a></li>
              @endcan
            </ul>
          </li>
          @endcan

            @can('barangmasuk_index')
                <li class="header">Barang</li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-th"></i> <span>Barang Masuk</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{ route('barangmasuk.index') }}"><i class=" fa fa-cubes"></i>Bahan
                                Mentah</a></li>
                    </ul>
                </li>
            @endcan

            @can('lab_index')
                <li class="header">Uji Lab</li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-th"></i> <span>Lab</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{ route('lab.index') }}"><i class="fa fa-flask"></i>Uji Bahan Awal</a>
                        </li>
                    </ul>
                </li>
            @endcan

          @can('lab_index')
          <li class="header">Lab Produksi</li>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>Lab Produksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="{{ route('lab-produksi.index') }}"><i class="fa fa-flask"></i>Lab</a></li>
            </ul>
          </li>
          @endcan

            @can('gudang_index')
                <li class="header">Penyimpanan Gudang</li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-th"></i> <span>Gudang</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{ route('gudang.index') }}"><i class="fa fa-circle-o"></i>Gudang
                                Bahan</a></li>
                        <li class="active"><a href="{{ route('gudang_request.index') }}"><i
                                    class="fa fa-circle-o"></i>Permintaan Bahan</a></li>
                        {{-- <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Evaluasi Code</a></li> --}}
                        <li class="active"><a href="{{ route('gudang_produksi.index') }}"><i
                                    class="fa fa-circle-o"></i>Gudang Produk</a></li>
                    </ul>
                </li>
            @endcan

            @can('produksibarang_index')
                <li class="header">Produksi</li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-th"></i> <span>Produksi</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{ route('produksi.index') }}"><i class="fa fa-check"></i>Produksi
                                Barang</a></li>
                        {{-- <li class="active"><a href="{{ route('detailProduksi.index') }}"><i class="fa fa-circle-o"></i>Detail Produksi</a></li> --}}
                        {{-- <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Permintaan Kegudang</a></li>
              <li class="active"><a href=""><i class="fa fa-circle-o"></i>Insert Hasil ke Lab</a></li> --}}
                    </ul>
                </li>
            @endcan

          <li class="header">Permintaan Produksi</li>
          <li>
            <a href="{{ route('owner.index') }}">
              <i class="fa fa-plus-square"></i> <span>Request Produksi</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>

          {{-- <li class="header">Laporan Input</li>
          <li class="active treeview">
              <a href="#">
                  <i class="fa fa-th"></i> <span>Laporan</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li class="active"><a href=""><i class=" fa fa-cubes"></i> Aktivitas Gudang</a></li>
                  <li class="active"><a href=""><i class="fa fa-flask"></i> Aktivitas Lab</a></li>
                  <li class="active"><a href=""><i class="fa fa-area-chart"></i> Aktivitas Produksi</a></a></li>
              </ul>
          </li> --}}


          @can('peralatan_index')
          <li class="header">Peralatan</li>
          <li>
            <a href="{{ route('peralatanKerja.index') }}">
              <i class="fa fa-th"></i> <span>Peralatan Kerja</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
          @endcan

            @can('logactivity_index')
            <li class="header">Log Aktivitas</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-th"></i> <span>Log Aktivitas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('log.activity_user') }}"><i
                                class="fa fa-circle-o"></i>Aktivitas user</a></li>
                </ul>
            </li>
            @endcan

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
