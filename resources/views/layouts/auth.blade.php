<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Eventverse')</title>
    <meta name="description" content="@yield('meta_description', 'Eventverse.id - Your Event Partner')">

    {{-- Favicons --}}
    <link href="{{ asset('assets/img/eventverse-icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/eventverse-apple-icon.png') }}" rel="apple-touch-icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">

    {{-- Tailwind (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    {{-- Toastry --}}
    <script src="https://unpkg.com/@oddsrabbit/toastry@1/dist/toastry.js"></script>

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-[#0f172a] antialiased">

    @yield('content')

    @stack('scripts')
</body>
</html>