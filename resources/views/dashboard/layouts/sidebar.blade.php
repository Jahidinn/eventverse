<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed" style="background-color: #08334b">
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
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">PESERTA</li>
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
                            Ikut Event
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>


                <li class="nav-header">EVENT MANAGER</li>

                <li class="nav-item">
                    <a href="/dashboard/manajemen-event"
                        class="nav-link {{ Request::is('dashboard/manajemen-event*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>Manajemen Event</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/dashboard/participant-data"
                        class="nav-link {{ Request::is('dashboard/participant-data*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Peserta</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/dashboard/transaction-report"
                        class="nav-link {{ Request::is('dashboard/transaction-report*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>Laporan Transaksi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/dashboard/event-checkin"
                        class="nav-link {{ Request::is('dashboard/event-checkin*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-square"></i>
                        <p>Check in Peserta</p>
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
                <li class="nav-item">
                    <a href="/dashboard/organization"
                        class="nav-link {{ Request::is('dashboard/organization*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p class="text">Organisasi</p>
                    </a>
                </li>

                @if (auth()->user()->category_id > 1)
                    <li class="nav-item">
                        <a href="/administrator" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p class="text">Administrator</p>
                        </a>
                    </li>
                @endif

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
