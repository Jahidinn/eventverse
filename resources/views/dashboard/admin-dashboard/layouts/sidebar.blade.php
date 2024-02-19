<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/assets/img/logo-e.png" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-light">Eventconnect.id</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @php
                if (!auth()->user()->profile_picture || auth()->user()->profile_picture == '') {
                    $photo = 'default-user.jpg';
                } else {
                    $photo = auth()->user()->profile_picture;
                }

            @endphp

            <div class="image">
                <img src="{{ asset('storage/profile-images') . '/' . $photo }}" class="img-circle elevation-2"
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
                <li class="nav-header">HOME</li>
                <li class="nav-item">
                    <a href="/administrator"
                        class="nav-link {{ Request::is('dashboard/admin') || Request::is('administrator') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">TRANSACTION</li>

                <li class="nav-item">
                    <a href="/administrator/wd-request"
                        class="nav-link {{ Request::is('administrator/wd-request*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Withdraw Request</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/administrator/transaction-check"
                        class="nav-link {{ Request::is('administrator/transaction-check*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-square"></i>
                        <p>Transaction check</p>
                    </a>
                </li>

                <li class="nav-header">PROFIL</li>
                <li class="nav-item">
                    <a href="/dashboard/my-profile"
                        class="nav-link {{ Request::is('dashboard/my-profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p class="text">Setting profil</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
