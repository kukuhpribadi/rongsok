<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-balance-scale"></i>
      </div>
      <div class="sidebar-brand-text mx-3">rongsok</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('getDataBulanIni') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('getDataBulanIni')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Transaksi
    </div>

    <li class="nav-item {{ request()->routeIs('transaksiBeli') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('transaksiBeli')}}">
        <i class="fas fa-shopping-cart"></i>
          <span>Beli barang</span></a>
    </li>
    
    <li class="nav-item {{ request()->routeIs('transaksiJual') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('transaksiJual')}}">
          <i class="fas fa-cash-register"></i>
        <span>Jual barang</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ Route::is(['barangIndex', 'indexTransaksiBeli', 'indexTransaksiJual'])  ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-fw fa-cog"></i>
        <span>Data & Set transaksi</span>
      </a>
      <div id="collapseOne" class="collapse {{ Route::is(['barangIndex', 'indexTransaksiBeli', 'indexTransaksiJual'])  ? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ Route::is('barangIndex*') ? 'active' : ''}}" href="{{route('barangIndex')}}">Set harga barang</a>
          <a class="collapse-item {{ Route::is('indexTransaksiBeli*') ? 'active' : ''}}" href="{{route('indexTransaksiBeli')}}">Data Pembelian</a>
          <a class="collapse-item {{ Route::is('indexTransaksiJual*') ? 'active' : ''}}" href="{{route('indexTransaksiJual')}}">Data Penjualan</a>
        </div>
      </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Karyawan
    </div>

    <li class="nav-item">
      <a class="nav-link {{ Request::is('karyawan*')  ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-users"></i>
        <span>Karyawan</span>
      </a>
      <div id="collapseTwo" class="collapse {{ Request::is('karyawan*')  ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ request()->routeIs('karyawanIndex*') ? 'active' : ''}}" href="{{route('karyawanIndex')}}">Data Karyawan</a>
          <a class="collapse-item {{ Route::is('karyawanAbsensi*') ? 'active' : ''}}" href="{{route('karyawanAbsensi')}}">Absen Karyawan</a>
          <a class="collapse-item {{ request()->routeIs('absensiIndex*') ? 'active' : ''}}" href="{{route('absensiIndex')}}">Data Absen Karyawan</a>
          {{-- <a class="collapse-item {{ Route::is('karyawanLaporan*')  ? 'active' : ''}}" href="{{route('karyawanLaporan')}}">Laporan Kinerja </a> --}}
          <a class="collapse-item {{ request()->routeIs('karyawanLaporan*')  ? 'active' : ''}}" href="{{route('karyawanLaporan')}}">Laporan Kinerja </a>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->