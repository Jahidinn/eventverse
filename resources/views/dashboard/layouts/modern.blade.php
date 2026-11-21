@php
    $user = auth()->user();
    $hasAdminRole = $user->hasRole('admin');
    $hasOrganizerRole = $user->hasRole('organizer');
    $isAdmin = $hasAdminRole && request()->is('administrator*');
    $isCreator = !$isAdmin && $hasOrganizerRole;
    $roleLabel = $isAdmin ? 'Administrator' : ($isCreator ? 'Organizer' : 'Participant');
    $canCreateEvent = !$isAdmin || $hasOrganizerRole;
    $showQuickNav = !$isAdmin && $hasOrganizerRole;
    $eventCategories = $canCreateEvent ? \App\Models\EventCategory::query()->orderBy('sort_order')->get() : collect();
    $environment = config('xendit.environment', 'sandbox') === 'production' ? 'production' : 'sandbox';

    $profilePath = $user->profile_picture
        ? 'storage/profile-images/' . $user->profile_picture
        : null;
    $profileUrl = $profilePath && file_exists(public_path($profilePath))
        ? asset($profilePath)
        : asset('assets/default-img/profile-images/default-user.jpg');

    $active = static function (array $patterns): bool {
        foreach ($patterns as $pattern) {
            if (request()->is($pattern)) {
                return true;
            }
        }

        return false;
    };
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | Eventverse</title>

    <link rel="icon" href="{{ asset('assets/img/eventverse-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/eventverse-apple-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.35.0/dist/tabler-icons.min.css">
    @stack('legacy_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-app.css') }}?v={{ filemtime(public_path('assets/css/dashboard-app.css')) }}">
    @stack('styles')
</head>
<body class="{{ $showQuickNav ? 'has-mobile-quicknav' : '' }}">
    <div class="dash-shell">
        <div id="dashOverlay" class="dash-overlay" aria-hidden="true"></div>

        <aside id="dashSidebar" class="dash-sidebar" aria-label="Navigasi dashboard">
            <div class="dash-sidebar-head">
                <a href="{{ $isAdmin ? '/administrator' : '/dashboard' }}" class="dash-brand" aria-label="Eventverse dashboard">
                    <img src="{{ asset('assets/img/eventverse-color.png') }}" alt="Eventverse">
                </a>

                <button type="button" id="dashSidebarClose" class="dash-sidebar-close" aria-label="Tutup menu">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <nav class="dash-sidebar-nav">
                @if ($isAdmin)
                    <div class="dash-nav-section">
                        <p class="dash-nav-label">Platform</p>
                        <a href="/administrator" class="dash-nav-link {{ $active(['administrator']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-layout-dashboard"></i></span>
                            <span class="dash-nav-text">Overview</span>
                        </a>
                        <a href="/administrator/payments" class="dash-nav-link {{ $active(['administrator/payments*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-receipt-2"></i></span>
                            <span class="dash-nav-text">Payments</span>
                        </a>
                        <a href="/administrator/wd-request" class="dash-nav-link {{ $active(['administrator/wd-request*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-wallet"></i></span>
                            <span class="dash-nav-text">Withdrawals</span>
                        </a>
                        <a href="/administrator/event-management/selected" class="dash-nav-link {{ $active(['administrator/event-management*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-calendar-event"></i></span>
                            <span class="dash-nav-text">Event Management</span>
                        </a>
                        <a href="/administrator/users" class="dash-nav-link {{ $active(['administrator/users*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-users"></i></span>
                            <span class="dash-nav-text">Users</span>
                        </a>
                        <a href="/administrator/roles" class="dash-nav-link {{ $active(['administrator/roles*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-shield-lock"></i></span>
                            <span class="dash-nav-text">Roles &amp; permissions</span>
                        </a>
                        <a href="/administrator/audit-logs" class="dash-nav-link {{ $active(['administrator/audit-logs*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-history"></i></span>
                            <span class="dash-nav-text">Audit log</span>
                        </a>
                    </div>

                    <div class="dash-nav-section">
                        <p class="dash-nav-label">Content</p>
                        <a href="/administrator/article" class="dash-nav-link {{ $active(['administrator/article*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-news"></i></span>
                            <span class="dash-nav-text">Articles</span>
                        </a>
                        <a href="/administrator/blog-category" class="dash-nav-link {{ $active(['administrator/blog-category*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-category"></i></span>
                            <span class="dash-nav-text">Blog categories</span>
                        </a>
                    </div>

                    <div class="dash-nav-section">
                        <p class="dash-nav-label">Account</p>
                        @if ($hasOrganizerRole)
                            <a href="/dashboard" class="dash-nav-link">
                                <span class="dash-nav-icon"><i class="ti ti-layout-dashboard"></i></span>
                                <span class="dash-nav-text">Organizer dashboard</span>
                            </a>
                        @else
                            <a href="/dashboard/myevent" class="dash-nav-link">
                                <span class="dash-nav-icon"><i class="ti ti-ticket"></i></span>
                                <span class="dash-nav-text">Participant dashboard</span>
                            </a>
                        @endif
                        <a href="/dashboard/my-profile" class="dash-nav-link {{ $active(['dashboard/my-profile*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-settings"></i></span>
                            <span class="dash-nav-text">Profile</span>
                        </a>
                    </div>
                @else
                    <div class="dash-nav-section">
                        <p class="dash-nav-label">Overview</p>
                        <a href="/dashboard" class="dash-nav-link {{ $active(['dashboard']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-layout-dashboard"></i></span>
                            <span class="dash-nav-text">Overview</span>
                        </a>
                        <a href="/dashboard/myevent" class="dash-nav-link {{ $active(['dashboard/myevent*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-ticket"></i></span>
                            <span class="dash-nav-text">My Event</span>
                        </a>
                    </div>

                    @if ($isCreator)
                        <div class="dash-nav-section">
                            <p class="dash-nav-label">Organizer</p>
                            <a href="/dashboard/manajemen-event" class="dash-nav-link {{ $active(['dashboard/manajemen-event*']) ? 'is-active' : '' }}">
                                <span class="dash-nav-icon"><i class="ti ti-calendar-event"></i></span>
                                <span class="dash-nav-text">Event Management</span>
                            </a>
                            <a href="/dashboard/participant-data" class="dash-nav-link {{ $active(['dashboard/participant-data*']) ? 'is-active' : '' }}">
                                <span class="dash-nav-icon"><i class="ti ti-users"></i></span>
                                <span class="dash-nav-text">Participants</span>
                            </a>
                            <a href="/dashboard/transaction-report" class="dash-nav-link {{ $active(['dashboard/transaction-report*']) ? 'is-active' : '' }}">
                                <span class="dash-nav-icon"><i class="ti ti-file-dollar"></i></span>
                                <span class="dash-nav-text">Finance &amp; withdrawals</span>
                            </a>
                            <a href="/dashboard/event-checkin" class="dash-nav-link {{ $active(['dashboard/event-checkin*']) ? 'is-active' : '' }}">
                                <span class="dash-nav-icon"><i class="ti ti-user-check"></i></span>
                                <span class="dash-nav-text">Check-in</span>
                            </a>
                        </div>
                    @endif

                    <div class="dash-nav-section">
                        <p class="dash-nav-label">Account</p>
                        <a href="/dashboard/organization" class="dash-nav-link {{ $active(['dashboard/organization*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-users-group"></i></span>
                            <span class="dash-nav-text">Organization</span>
                        </a>
                        <a href="/dashboard/my-profile" class="dash-nav-link {{ $active(['dashboard/my-profile*']) ? 'is-active' : '' }}">
                            <span class="dash-nav-icon"><i class="ti ti-settings"></i></span>
                            <span class="dash-nav-text">Profile</span>
                        </a>
                        @if ($hasAdminRole)
                            <a href="/administrator" class="dash-nav-link">
                                <span class="dash-nav-icon"><i class="ti ti-shield-cog"></i></span>
                                <span class="dash-nav-text">Admin panel</span>
                            </a>
                        @endif
                    </div>
                @endif
            </nav>

            <div class="dash-sidebar-foot">
                <div class="dash-sidebar-user">
                    <span class="dash-avatar">
                        <img src="{{ $profileUrl }}" alt="">
                    </span>
                    <span class="dash-user-copy">
                        <span class="dash-user-name">{{ $user->name }}</span>
                        <span class="dash-user-role">{{ $roleLabel }}</span>
                    </span>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="dash-nav-icon border-0 bg-transparent p-0 text-[#94a3b8] hover:text-[#b91c1c]" title="Logout" aria-label="Logout">
                            <i class="ti ti-logout"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="dash-main">
            <header class="dash-topbar">
                <div class="dash-topbar-left">
                    <button type="button" id="dashSidebarToggle" class="dash-menu-button" aria-label="Buka menu" aria-controls="dashSidebar" aria-expanded="false">
                        <i class="ti ti-menu-2"></i>
                    </button>
                    <div class="dash-topbar-context">
                        <strong>Eventverse workspace</strong>
                        <span>{{ $roleLabel }} · {{ $isAdmin ? 'Platform' : ($isCreator ? 'Organizer' : 'Participant') }}</span>
                    </div>
                </div>

                <div class="dash-topbar-right">
                    <span class="dash-env {{ $environment === 'production' ? 'is-live' : '' }}">
                        <span class="dash-env-dot"></span>
                        {{ $environment === 'production' ? 'Live' : 'Sandbox' }}
                    </span>

                    <details class="dash-topbar-user">
                        <summary>
                            <span class="dash-avatar">
                                <img src="{{ $profileUrl }}" alt="">
                            </span>
                            <i class="ti ti-chevron-down text-[11px] text-[#94a3b8]"></i>
                        </summary>
                        <div class="dash-user-menu">
                            <div class="dash-user-menu-head">
                                <strong>{{ $user->name }}</strong>
                                <span>{{ $user->email }}</span>
                            </div>
                            <a href="/dashboard/my-profile" class="dash-menu-link">
                                <i class="ti ti-user-cog"></i> Profile
                            </a>
                            @if ($isAdmin && $hasOrganizerRole)
                                <a href="/dashboard" class="dash-menu-link">
                                    <i class="ti ti-layout-dashboard"></i> Organizer dashboard
                                </a>
                            @elseif ($isAdmin)
                                <a href="/dashboard/myevent" class="dash-menu-link">
                                    <i class="ti ti-ticket"></i> My Event
                                </a>
                            @elseif ($hasAdminRole)
                                <a href="/administrator" class="dash-menu-link">
                                    <i class="ti ti-shield-cog"></i> Admin panel
                                </a>
                            @else
                                <a href="/dashboard/myevent" class="dash-menu-link">
                                    <i class="ti ti-ticket"></i> My Event
                                </a>
                            @endif
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="dash-menu-button-link">
                                    <i class="ti ti-logout"></i> Logout
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            </header>

            <main class="dash-content">
                @if (session('popup'))
                    <div class="dash-alert is-success">
                        <i class="ti ti-circle-check"></i>
                        <div><strong>Berhasil.</strong> {{ session('popup') }}</div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="dash-alert is-success">
                        <i class="ti ti-circle-check"></i>
                        <div><strong>Berhasil.</strong> {{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="dash-alert is-error">
                        <i class="ti ti-alert-circle"></i>
                        <div><strong>Perhatian.</strong> {{ session('error') }}</div>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="dash-alert is-error">
                        <i class="ti ti-alert-circle"></i>
                        <div>
                            <strong>Periksa input.</strong>
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="dash-footer">
                Eventverse · {{ $isAdmin ? 'Platform administration' : 'Creator workspace' }} · {{ now()->format('Y') }}
            </footer>
        </div>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById('dashSidebar');
            const overlay = document.getElementById('dashOverlay');
            const toggle = document.getElementById('dashSidebarToggle');
            const close = document.getElementById('dashSidebarClose');

            if (!sidebar || !overlay || !toggle) {
                return;
            }

            const setOpen = function (open) {
                sidebar.classList.toggle('is-open', open);
                overlay.classList.toggle('is-visible', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                document.body.style.overflow = open ? 'hidden' : '';
            };

            toggle.addEventListener('click', function () {
                setOpen(!sidebar.classList.contains('is-open'));
            });

            if (close) {
                close.addEventListener('click', function () {
                    setOpen(false);
                });
            }

            overlay.addEventListener('click', function () {
                setOpen(false);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setOpen(false);
                }
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    setOpen(false);
                }
            });
        })();
    </script>

    @if ($showQuickNav)
        <nav class="dash-mobile-nav" aria-label="Menu cepat organizer">
            <a href="/dashboard/manajemen-event" class="dash-mobile-nav-link {{ $active(['dashboard/manajemen-event*']) ? 'is-active' : '' }}">
                <i class="ti ti-calendar-event"></i>
                <span>Event Management</span>
            </a>
            <a href="/dashboard/myevent" class="dash-mobile-nav-link {{ $active(['dashboard/myevent*']) ? 'is-active' : '' }}">
                <i class="ti ti-ticket"></i>
                <span>My Event</span>
            </a>
        </nav>
    @endif

    @stack('legacy_scripts')
    @if ($canCreateEvent)
        @include('dashboard.components.create-event-modal')
    @endif
    @stack('scripts')
</body>
</html>
