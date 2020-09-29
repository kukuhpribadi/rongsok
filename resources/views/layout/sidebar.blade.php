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
    <li class="nav-item {{ request()->routeIs('dashboardIndex') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('dashboardIndex')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Transaksi Pembelian
    </div>

    <li class="nav-item {{ request()->routeIs('transaksiBeli') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('transaksiBeli')}}">
        <i class="fas fa-shopping-cart"></i>
          <span>Beli barang</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('barangIndex') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('barangIndex')}}">
            <i class="fas fa-box-open"></i>
          <span>Set harga barang</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('indexTransaksiBeli') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('indexTransaksiBeli')}}">
        <i class="fas fa-ellipsis-h"></i>
        <span>Data Pembelian</span></a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Transaksi Penjualan
    </div>

    <li class="nav-item {{ request()->routeIs('transaksiJual') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('transaksiJual')}}">
          <i class="fas fa-cash-register"></i>
        <span>Jual barang</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('indexTransaksiJual') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('indexTransaksiJual')}}">
        <i class="fas fa-ellipsis-h"></i>
        <span>Data Penjualan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->