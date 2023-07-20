<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Posyandu</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $menu == "dashboard" ? "active" : "" }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Participant
    </div>

    <li class="nav-item {{ $menu == "balita" ? "active" : "" }}">
        <a href="{{ route("balita") }}" class="nav-link">
            <i class="fa fa-baby"></i>
            <span>Balita</span></a>
    </li>
    <li class="nav-item {{ $menu == "remaja" ? "active" : "" }}">
        <a href="{{ route("remaja") }}" class="nav-link">
            <i class="fa fa-child"></i>
            <span>Remaja</span></a>
    </li>
    <li class="nav-item {{ $menu == "lansia" ? "active" : "" }}">
        <a href="{{ route("lansia") }}" class="nav-link">
            <i class="fa fa-person-booth"></i>
            <span>Lansia</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Setting
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ $menu == "laporan" ? "active" : "" }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true"
            aria-controls="collapseLaporan">
            <i class="fa fa-fw fa-table"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse {{ $menu == "laporan" ? "show" : "" }}" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="{{ route("laporan_balita") }}" class="collapse-item {{ $sub_menu == "balita" ? "active" : "" }}">Balita</a>
                <a href="{{ route("laporan_remaja") }}" class="collapse-item {{ $sub_menu == "remaja" ? "active" : "" }}">Remaja</a>
                <a href="{{ route("laporan_lansia") }}" class="collapse-item {{ $sub_menu == "lansia" ? "active" : "" }}">Lansia</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->