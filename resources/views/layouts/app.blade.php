{{-- resources/views/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Eventverse.id - Your event partner')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/eventverse-icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/eventverse-apple-icon.png') }}" rel="apple-touch-icon">

    <meta name="description" content="@yield('meta_description', 'Discover events, activities, competitions, and experiences happening around you.')">

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.35.0/dist/tabler-icons.min.css" />

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2282ff',
                        dark: '#0f172a',
                        surface: '#f8fafc',
                        borderSubtle: '#e2e8f0',
                        mutedText: '#64748b'
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@oddsrabbit/toastry@1/dist/toastry.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    {{-- CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/css/intlTelInput.css">

{{-- JS Utama — WAJIB ADA --}}
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/js/intlTelInput.min.js"></script>

{{-- utils.js TIDAK dimuat lewat <script> tag, tapi via opsi loadUtils (lihat di bawah) --}}

    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-[#0f172a] antialiased">

    {{-- ================= NAVBAR ================= --}}
    @include('layouts.partials.navbar')

    {{-- Logout Confirmation Modal --}}
    @include('layouts.partials.logout')

    {{-- ================= CONTENT ================= --}}
    @yield('content')

    {{-- ================= FOOTER ================= --}}
    @include('layouts.partials.footer')

    @stack('scripts')
    @stack('transaction-scripts')
</body>
</html>