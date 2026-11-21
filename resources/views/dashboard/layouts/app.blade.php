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
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.14.9/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-slate-50 font-['Inter',sans-serif] text-slate-900 antialiased"
      x-data="{
          sidebarOpen: false,
          openSidebar() { this.sidebarOpen = true },
          closeSidebar() { this.sidebarOpen = false },
      }"
      @keydown.escape.window="if (sidebarOpen) closeSidebar()"
      @resize.window="if (window.matchMedia('(min-width: 1024px)').matches) closeSidebar()">
    <a href="#dashboard-content" class="sr-only focus:not-sr-only focus:fixed focus:left-3 focus:top-3 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Lewati ke konten</a>

    <div aria-hidden="true" class="fixed inset-0 z-40 hidden bg-slate-950/55" :class="{ 'max-lg:!block': sidebarOpen }" @click="closeSidebar()"></div>

    @include('dashboard.partials.sidebar')

    <div class="flex min-h-screen min-w-0 flex-col lg:pl-64 {{ $showQuickNav ? 'pb-[calc(3.5rem+env(safe-area-inset-bottom))] lg:pb-0' : '' }}">
        @include('dashboard.partials.topbar')

        <main id="dashboard-content" class="mx-auto w-full max-w-[1440px] flex-1 px-4 py-5 sm:px-6 sm:py-7">
            @include('dashboard.partials.alerts')
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 px-4 py-4 text-center text-xs text-slate-600 sm:px-6">
            Eventverse · {{ $isAdmin ? 'Platform administration' : 'Creator workspace' }} · {{ now()->format('Y') }}
        </footer>
    </div>

    @include('dashboard.partials.mobile-nav')

    @if ($canCreateEvent)
        @include('dashboard.components.create-event-modal')
    @endif
    @stack('scripts')
</body>
</html>
