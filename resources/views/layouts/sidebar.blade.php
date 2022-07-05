<aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{asset('template/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>Alexander Pierce</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form -->
        {{-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form> --}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li>
            <a href="{{ route('dashboard') }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>

          <li class="header">Master</li>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>Master Data</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i>Supplier</a></li>
              <li class="active"><a href="{{ route('bahan.index') }}"><i class="fa fa-reorder"></i>Bahan</a></li>
              <li class="active"><a href="{{ route('produk.index')}}"><i class="fa fa-cubes"></i>Produk</a></li>
              <li class="active"><a href="{{ route('kategori.index') }}"><i class="fa fa-cube"></i>Kategori</a></li>
            </ul>
          </li>
          

          <li class="header">Barang</li>
          <li class="active treeview">          
            <a href="#">
              <i class="fa fa-th"></i> <span>Barang Masuk</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="{{ route('barangmasuk.index') }}"><i class=" fa fa-bar-chart"></i>Bahan Mentah</a></li>
            </ul>
          </li>

          <li class="header">Uji Lep</li>

          <li class="active treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>Lep</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="{{ route('lab.index') }}"><i class="fa fa-circle-o"></i>Uji Bahan Awal</a></li>
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Uji Produk Jadi</a></li>
            </ul>
          </li>

          <li class="header">Penyimpanan Gudang</li>

          <li class="active treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>Gudang</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Bahan Produksi</a></li>
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Produk Jadi</a></li>
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Produk Gagal Jadi</a></li>
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Evaluasi Code</a></li>
            </ul>
          </li>

          <li class="header">Produksi</li>

          <li class="active treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>Produksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Request Produksi</a></li>
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Request Permintaan Kegudang</a></li>
              <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Proses Produksi</a></li>
            </ul>
          </li>

          <li class="header">Peralatan</li>
          <li>
            <a href="pages/widgets.html">
              <i class="fa fa-th"></i> <span>Peralatan Kerja</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
</aside>