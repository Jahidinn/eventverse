<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #1e4356;">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('assets/dashboard/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Eventconnect.id</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dashboard/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Jahidin</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/dashboard/myevent"
                        class="nav-link {{ Request::is('dashboard/myevent*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            My event
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/dashboard/manajemen-event"
                        class="nav-link {{ Request::is('dashboard/manajemen-event*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>Manajemen event</p>
                    </a>
                </li>


                <li class="nav-header">EVENT STATISTIK</li>
                <li class="nav-item">
                    <a href="../../iframe.html" class="nav-link">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>Laporan Transaksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://adminlte.io/docs/3.1/" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pendaftar</p>
                    </a>
                </li>

                <li class="nav-header">PROFIL</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-edit text-primary"></i>
                        <p class="text">Setting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
