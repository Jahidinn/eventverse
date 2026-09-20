{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Eventverse.id - Your Event Partner')
@section('meta_description', 'Discover events, activities, competitions, and experiences happening around you.')

@section('content')

@php
    $cities = ['All locations', 'Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta', 'Bali', 'Medan'];
@endphp

{{-- ================= 2. BANNER / HERO ================= --}}
<section class="relative overflow-hidden bg-white border-b border-[#e2e8f0] py-12 md:py-16">

    {{-- Abstract Background --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">

        {{-- Main blue glow - LEFT --}}
        <div class="absolute -top-40 -left-40 w-[560px] h-[560px] rounded-full bg-[#2282ff]/[0.11] blur-3xl"></div>

        {{-- Secondary blue glow - LEFT / CENTER --}}
        <div class="absolute top-[32%] -left-24 w-[420px] h-[420px] rounded-full bg-[#60a5fa]/[0.08] blur-3xl"></div>

        {{-- Soft blue transition toward center --}}
        <div class="absolute top-[10%] left-[22%] w-[300px] h-[300px] rounded-full bg-[#2282ff]/[0.035] blur-3xl"></div>

        {{-- Soft decorative circle --}}
        <div class="absolute top-16 left-[28%] w-40 h-40 rounded-full border border-[#2282ff]/[0.09]"></div>

        {{-- Small decorative dot --}}
        <div class="absolute top-28 left-[31%] w-3 h-3 rounded-full bg-[#2282ff]/25"></div>

        {{-- Bottom decorative shape --}}
        <div class="absolute bottom-8 left-[36%] w-24 h-24 rounded-[2rem] border border-[#2282ff]/[0.07] rotate-12"></div>

    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

            {{-- =====================================================
                LEFT CONTENT
            ====================================================== --}}
            <div class="lg:col-span-7 space-y-6 lg:space-y-8">

                {{-- Featured Event Badge --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff] text-xs font-semibold border border-[#2282ff]/20">

                    <svg class="w-3.5 h-3.5"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                    </svg>

                    <span>eventverse.id</span>
                </div>


                {{-- Heading --}}
                <div class="space-y-3">

                    <h2 class="text-3xl sm:text-2xl lg:text-3xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15]">
                        The universe of
                        <span class="text-[#2282ff]">events</span>
                    </h2>

                    <p class="text-base sm:text-md text-[#64748b] leading-relaxed max-w-2xl">
                        Discover a variety of events, competitions, concerts, and experiences happening around you.
                    </p>

                </div>


                {{-- Search --}}
                <div class="pt-1 w-full">

                    <form
                        action="/search"
                        method="GET"
                        class="flex items-center w-full p-1.5 rounded-2xl bg-white border border-[#e2e8f0] shadow-[0_8px_30px_rgba(34,130,255,0.08)] focus-within:border-[#2282ff]/40 focus-within:shadow-[0_8px_30px_rgba(34,130,255,0.12)] transition-all"
                    >

                        {{-- Search Icon --}}
                        <div class="flex items-center justify-center w-11 h-11 shrink-0 text-[#64748b]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-4-4"/>
                            </svg>
                        </div>

                        {{-- Input --}}
                        <input
                            type="text"
                            name="key"
                            placeholder="Search events, cities, or categories..."
                            class="flex-1 min-w-0 px-2 py-3 text-sm text-[#0f172a] placeholder:text-[#94a3b8] bg-transparent border-0 outline-none focus:ring-0"
                        >

                        {{-- Search Button --}}
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#2282ff] hover:bg-[#1b6cd6] text-white text-sm font-semibold shadow-sm transition-all hover:-translate-y-0.5 shrink-0"
                        >
                            <span>Search</span>

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>
                            </svg>
                        </button>

                    </form>

                </div>


                {{-- Supporting Info --}}
                <div class="pt-4 border-t border-[#e2e8f0] grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Free --}}
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#ecfdf5] text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-[#0f172a]">100% Free</span>
                            <span class="text-xs text-[#64748b]">manage your event for free</span>
                        </div>
                    </div>


                    {{-- Easy Management --}}
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#ecfdf5] text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-[#0f172a]">Easy amanegement</span>
                            <span class="text-xs text-[#64748b]">simple & powerful</span>
                        </div>
                    </div>


                    {{-- Digital Tickets --}}
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#ecfdf5] text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-[#0f172a]">Secure payment</span>
                            <span class="text-xs text-[#64748b]">multiple payment methods</span>
                        </div>
                    </div>

                </div>

            </div>


            {{-- =====================================================
                RIGHT FEATURED EVENT SLIDER
            ====================================================== --}}
            <div class="lg:col-span-5">

                <div id="featured-slider" class="relative group">

                    {{-- Soft blue glow --}}
                    <div class="absolute -inset-2 rounded-[1.5rem] bg-[#2282ff]/[0.06] blur-xl"></div>

                    {{-- Slider --}}
                    <div class="relative overflow-hidden rounded-2xl border border-[#e2e8f0] bg-white shadow-[0_10px_35px_rgba(34,130,255,0.10)]">

                        <div id="featured-track" class="flex transition-transform duration-700 ease-in-out">

                            @foreach($heroBanners as $index => $banner)

                                @php
                                    if (empty($banner->image)) {
                                        $banner_image = 'assets/default-img/event-images/def-img.png';
                                    } else {
                                        $imgPath = 'storage/event-images/' . $banner->image;

                                        $banner_image = file_exists(public_path($imgPath))
                                            ? $imgPath
                                            : 'assets/default-img/event-images/def-img.png';
                                    }
                                @endphp

                                <article class="featured-slide min-w-full">
                                    <a
                                        href="/{{ $banner->slug }}"
                                        class="group flex flex-col bg-white rounded-2xl border border-[#e2e8f0] shadow-xs hover:shadow-md hover:border-[#cbd5e1] hover:-translate-y-1 transition-all duration-200 overflow-hidden cursor-pointer"
                                    >

                                        {{-- Image --}}
                                        <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-100">

                                            <img src="{{ $banner_image }}"
                                                 alt="{{ $banner->title }}"
                                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                                            {{-- Overlay --}}
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                                            {{-- Category --}}
                                            <div class="absolute top-4 left-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-[#2282ff] text-white shadow-sm">
                                                    {{ $banner->category->name }}
                                                </span>
                                            </div>

                                            {{-- Event Info --}}
                                            @php
                                                if ($banner->organizer == 'org') {
                                                    $penyelenggara = $banner->org->org_name ?? '';
                                                } elseif ($banner->organizer == 'individual') {
                                                    $penyelenggara = $banner->individual->name ?? '';
                                                } else {
                                                    $penyelenggara = '';
                                                }
                                            @endphp

                                            <div class="absolute bottom-4 left-4 right-4 text-white">

                                                <div class="text-xs uppercase tracking-wider text-sky-200">
                                                    {{ $penyelenggara }}
                                                </div>

                                                <h3 class="text-lg sm:text-xl font-bold text-white mt-1">
                                                    {{ $banner->title }}
                                                </h3>

                                            </div>

                                        </div>


                                        {{-- Bottom Info --}}
                                        <div class="p-4 bg-white flex items-center justify-between border-t border-[#e2e8f0]">

                                            <div class="space-y-1 text-xs text-[#64748b]">

                                                <div class="flex items-center gap-1.5">
                                                    <span>📅</span>
                                                    <span>
                                                        {{ $banner->start_date->format('d-m-Y') == $banner->end_date->format('d-m-Y')
                                                            ? $banner->end_date->format('d M Y')
                                                            : $banner->start_date->format('d M Y') . ' - ' . $banner->end_date->format('d M Y')
                                                        }}
                                                    </span>
                                                </div>

                                                <div class="flex items-center gap-1.5">
                                                    <span>📍</span>
                                                    <span>
                                                        {{ $banner->location_jenis == 'Offline'
                                                            ? ucwords(strtolower($banner->location_city))
                                                            : $banner->location_jenis
                                                        }}
                                                    </span>
                                                </div>

                                            </div>


                                            <div class="text-right">

                                                <span class="text-[11px] font-medium text-[#64748b] block">
                                                    Starts from
                                                </span>

                                                <span class="text-base font-bold text-[#2282ff]">
                                                    {{ $banner->ticket->first()->ticket_price == 0
                                                        ? 'GRATIS!'
                                                        : 'Rp ' . number_format($banner->ticket->first()->ticket_price, 0, ',', '.')
                                                    }}
                                                </span>

                                            </div>

                                        </div>

                                    </a>
                                </article>

                            @endforeach

                        </div>


                        {{-- Previous --}}
                        <button type="button"
                                id="featured-prev"
                                aria-label="Previous event"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/95 text-[#0f172a] shadow-md border border-[#e2e8f0] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-white">

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>

                        </button>


                        {{-- Next --}}
                        <button type="button"
                                id="featured-next"
                                aria-label="Next event"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/95 text-[#0f172a] shadow-md border border-[#e2e8f0] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-white">

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>

                        </button>

                    </div>

                    {{-- Dots --}}
                    <div id="featured-dots" class="flex items-center justify-center gap-1.5 mt-4">

                        @foreach($heroBanners as $index => $banner)

                            <button type="button"
                                    data-slide="{{ $index }}"
                                    aria-label="Go to slide {{ $index + 1 }}"
                                    class="featured-dot h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-7 bg-[#2282ff]' : 'w-1.5 bg-[#cbd5e1]' }}">
                            </button>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ================= 5. RECENT EVENTS ================= --}}
<section id="events" class="py-12 md:py-10 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div class="mb-5">
                <h3 class="text-xl sm:text-2xl font-bold tracking-[-0.03em] text-[#0f172a]">
                    <span class="text-[#2282ff]">Recent</span>
                    events
                </h3>

                <p class="mt-1.5 text-sm text-[#64748b] tracking-tight">
                    Discover the latest events added to eventverse
                </p>
            </div>
            <a href="/events" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2282ff] hover:text-[#1b6cd6] group">
                <span>View All</span>
                <span class="transition-transform group-hover:translate-x-1">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($eventTerbaru as $event)

                @php
                    if (empty($event['image'])) {
                        $imgTerbaru = 'assets/default-img/event-images/def-img.png';
                    } else {
                        $imgPath = 'storage/event-images/' . $event['image'];

                        $imgTerbaru = file_exists(public_path($imgPath))
                            ? $imgPath
                            : 'assets/default-img/event-images/def-img.png';
                    }
                @endphp

                <a
                    href="/{{ $event->slug }}"
                    class="group flex flex-col bg-white rounded-2xl border border-[#e2e8f0] shadow-xs hover:shadow-md hover:border-[#cbd5e1] hover:-translate-y-1 transition-all duration-200 overflow-hidden cursor-pointer"
                >
                    {{-- Event Image --}}
                    <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">
                        <img
                            src="{{ $imgTerbaru }}"
                            alt="{{ $event->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        >
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-md text-[10px] sm:text-[11px] font-bold uppercase tracking-wider bg-white/90 text-[#0f172a] border border-[#e2e8f0] shadow-xs backdrop-blur-xs">
                                {{ strtoupper($event->category->name) }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-[#0f172a] group-hover:text-[#2282ff] transition-colors line-clamp-2 leading-snug">
                                {{ $event->title }}
                            </h3>

                            <div class="mt-2 space-y-1 text-[11px] sm:text-xs text-[#64748b]">
                                <div class="flex items-center gap-1.5">
                                    <span>
                                        📅
                                        {{ $event->start_date->format('d-m-Y') == $event->end_date->format('d-m-Y')
                                            ? $event->end_date->format('d M Y')
                                            : $event->start_date->format('d M Y') . ' - ' . $event->end_date->format('d M Y')
                                        }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5 truncate">
                                    <span>
                                        📍
                                        {{ $event->location_jenis == 'Offline'
                                            ? ucwords(strtolower($event->location_city))
                                            : $event->location_jenis
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-3 pt-2 border-t border-[#e2e8f0] flex items-center justify-between">
                            <div>
                                <span class="text-[10px] sm:text-[11px] text-[#64748b] block font-medium">
                                    Start from
                                </span>

                                @if ($event->ticket->isNotEmpty() && $event->ticket->first()->ticket_price !== null)
                                    <span class="text-sm sm:text-base font-bold {{ $event->ticket->first()->ticket_price == 0 ? 'text-emerald-600' : 'text-[#2282ff]' }}">
                                        {{ $event->ticket->first()->ticket_price == 0
                                            ? 'GRATIS!'
                                            : 'Rp ' . number_format($event->ticket->first()->ticket_price, 0, ',', '.')
                                        }}
                                    </span>
                                @else
                                    <span class="text-sm font-semibold text-[#64748b]">
                                        Tidak tersedia
                                    </span>
                                @endif
                            </div>

                            <span class="text-[11px] sm:text-xs font-semibold text-[#0f172a] group-hover:text-[#2282ff] transition-colors">
                                Get Ticket →
                            </span>
                        </div>
                    </div>
                </a>

            @endforeach
        </div>
    </div>
</section>

{{-- ================= 4. SEARCH EVENT ================= --}}
<section class="py-3 bg-white border-y border-[#e2e8f0]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Form search bisa diaktifkan kembali jika diperlukan --}}
        </div>
    </div>
</section>


{{-- ================= 3. EVENT CATEGORIES ================= --}}
<section id="categories" class="py-10 md:py-12 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="mb-5">
            <h2 class="text-xl sm:text-2xl font-bold tracking-[-0.03em] text-[#0f172a]">
                Explore
                <span class="text-[#2282ff]">categories</span>
            </h2>

            <p class="mt-1.5 text-sm text-[#64748b] tracking-tight">
                Find events that match your interests.
            </p>
        </div>

        {{-- Category Slider --}}
        <div id="category-slider" class="group">

            <div class="flex items-center gap-3">

                {{-- Previous Button --}}
                <button
                    type="button"
                    id="category-prev"
                    class="hidden sm:flex flex-none w-9 h-9 rounded-full bg-white/95 text-[#0f172a] shadow-md border border-[#e2e8f0] items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-white hover:text-[#2282ff]"
                    aria-label="Previous categories"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- Category Track --}}
                <div
                    id="category-track"
                    class="flex-1 flex gap-3 sm:gap-4 overflow-x-auto scroll-smooth py-2 pb-6"
                >
                    @foreach ($categories as $category)
                        <a href="/search?category={{ $category->id }}"
                           class="flex-none w-[85px] sm:w-[145px] group/category flex flex-col items-center justify-center text-center p-2 sm:p-4 rounded-xl border border-[#e2e8f0] bg-white hover:border-[#2282ff]/50 hover:bg-[#ebf3ff]/40 hover:-translate-y-0.5 shadow-sm transition-all duration-200">

                            {{-- Icon --}}
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-[#f8fafc] text-[#2282ff] flex items-center justify-center mb-2 sm:mb-3 group-hover/category:bg-white group-hover/category:scale-105 transition-all duration-200">
                                <i class="{{ $category->icon }} text-lg sm:text-xl"></i>
                            </div>

                            {{-- Category Name --}}
                            <span class="text-xs sm:text-sm font-semibold tracking-tight text-[#0f172a] group-hover/category:text-[#2282ff] line-clamp-2">
                                {{ $category->name }}
                            </span>
                        </a>
                    @endforeach
                </div>

                {{-- Next Button --}}
                <button
                    type="button"
                    id="category-next"
                    class="hidden sm:flex flex-none w-9 h-9 rounded-full bg-white/95 text-[#0f172a] shadow-md border border-[#e2e8f0] items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-white hover:text-[#2282ff]"
                    aria-label="Next categories"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

            </div>

        </div>

    </div>
</section>


{{-- ================= 7. POPULAR EVENTS ================= --}}
<section id="popular" class="py-12 md:py-16 bg-white border-t border-[#e2e8f0]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div class="mb-5">
                <h3 class="text-xl sm:text-2xl font-bold tracking-[-0.03em] text-[#0f172a]">
                    <span class="text-[#2282ff]">Popular</span>
                    events
                </h3>

                <p class="mt-1.5 text-sm text-[#64748b] tracking-tight">
                    Events people are interested in right now
                </p>
            </div>
            <a href="/popular-events" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2282ff] hover:text-[#1b6cd6] group">
                <span>View All</span>
                <span class="transition-transform group-hover:translate-x-1">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($eventPopuler as $popularEvent)

                @php
                    if (empty($popularEvent['image'])) {
                        $popularImg = 'assets/default-img/event-images/def-img.png';
                    } else {
                        $imgPath = 'storage/event-images/' . $popularEvent['image'];

                        $popularImg = file_exists(public_path($imgPath))
                            ? $imgPath
                            : 'assets/default-img/event-images/def-img.png';
                    }
                @endphp

                <a
                    href="/{{ $popularEvent->slug }}"
                    class="group flex flex-col bg-white rounded-2xl border border-[#e2e8f0] shadow-xs hover:shadow-md hover:border-[#cbd5e1] hover:-translate-y-1 transition-all duration-200 overflow-hidden cursor-pointer"
                >

                    <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">
                        <img src="{{ $popularImg }}" alt="{{ $popularEvent->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-white/90 text-[#0f172a] border border-[#e2e8f0] shadow-xs">
                                {{ strtoupper($popularEvent->category->name) }}
                            </span>
                            <button type="button" class="p-2 rounded-full bg-white/90 text-slate-600 hover:text-rose-600 shadow-xs transition-colors" aria-label="Favorite">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                </svg>
                            </button>
                        </div>

                        @if (!empty($popularEvent->visitor))
                            <div class="absolute bottom-2.5 left-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-semibold bg-[#0f172a]/85 text-white backdrop-blur-xs">
                                    🔥 {{ $popularEvent->visitor }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold text-[#0f172a] group-hover:text-[#2282ff] transition-colors line-clamp-2 leading-snug">
                                {{ $popularEvent->title }}
                            </h3>
                            <div class="mt-2.5 space-y-1 text-xs text-[#64748b]">
                                <div>
                                    📅 {{ $popularEvent->start_date->format('d-m-Y') == $popularEvent->end_date->format('d-m-Y')
                                            ? $popularEvent->end_date->format('d M Y')
                                            : $popularEvent->start_date->format('d M Y') . ' - ' . $popularEvent->end_date->format('d M Y')
                                        }}
                                </div>
                                <div class="truncate">
                                    📍 {{ $popularEvent->location_jenis == 'Offline'
                                            ? ucwords(strtolower($popularEvent->location_city))
                                            : $popularEvent->location_jenis
                                        }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#e2e8f0] flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-[#64748b] block font-medium">Start from</span>

                                @if ($popularEvent->ticket->isNotEmpty() && $popularEvent->ticket->first()->ticket_price !== null)
                                    <span class="text-sm sm:text-base font-bold {{ $popularEvent->ticket->first()->ticket_price == 0 ? 'text-emerald-600' : 'text-[#2282ff]' }}">
                                        {{ $popularEvent->ticket->first()->ticket_price == 0
                                            ? 'GRATIS!'
                                            : 'Rp ' . number_format($popularEvent->ticket->first()->ticket_price, 0, ',', '.')
                                        }}
                                    </span>
                                @else
                                    <span class="text-sm font-semibold text-[#64748b]">
                                        Tidak tersedia
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs font-semibold text-[#0f172a] group-hover:text-[#2282ff] transition-colors">
                                Get Ticket →
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= 8. BROWSE ALL EVENTS CTA ================= --}}
<section class="py-14 bg-[#f8fafc] border-t border-[#e2e8f0]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-[#0f172a] tracking-tight">Looking for something else?</h2>
        <p class="text-sm sm:text-base text-[#64748b] mt-2 max-w-lg mx-auto">
            Explore all events available on Eventverse.
        </p>
        <div class="mt-6">
            <a href="/all-events" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl text-sm sm:text-base font-semibold text-white bg-[#2282ff] hover:bg-[#1b6cd6] shadow-md shadow-[#2282ff]/20 transition-all hover:-translate-y-0.5">
                <span>View All Events</span>
                <span>→</span>
            </a>
        </div>
    </div>
</section>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       FEATURED SLIDER
    ========================================================= */
    const slider = document.getElementById('featured-slider');
    const track = document.getElementById('featured-track');
    const slides = document.querySelectorAll('.featured-slide');
    const dots = document.querySelectorAll('.featured-dot');
    const prev = document.getElementById('featured-prev');
    const next = document.getElementById('featured-next');

    if (slider && track && slides.length > 1) {

        let current = 0;
        let autoplay = null;

        function updateSlider() {
            track.style.transform = `translateX(-${current * 100}%)`;

            dots.forEach((dot, index) => {
                if (index === current) {
                    dot.classList.remove('w-1.5', 'bg-[#cbd5e1]');
                    dot.classList.add('w-7', 'bg-[#2282ff]');
                } else {
                    dot.classList.remove('w-7', 'bg-[#2282ff]');
                    dot.classList.add('w-1.5', 'bg-[#cbd5e1]');
                }
            });
        }

        function goToSlide(index) {
            current = (index + slides.length) % slides.length;
            updateSlider();
            restartAutoplay();
        }

        function nextSlide() { goToSlide(current + 1); }
        function previousSlide() { goToSlide(current - 1); }

        function startAutoplay() {
            stopAutoplay();
            autoplay = setInterval(function () {
                current = (current + 1) % slides.length;
                updateSlider();
            }, 5000);
        }

        function stopAutoplay() {
            if (autoplay) {
                clearInterval(autoplay);
                autoplay = null;
            }
        }

        function restartAutoplay() {
            stopAutoplay();
            startAutoplay();
        }

        next?.addEventListener('click', nextSlide);
        prev?.addEventListener('click', previousSlide);

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goToSlide(Number(this.dataset.slide));
            });
        });

        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        let touchStartX = 0;
        let touchEndX = 0;

        slider.addEventListener('touchstart', function (event) {
            touchStartX = event.changedTouches[0].screenX;
            stopAutoplay();
        }, { passive: true });

        slider.addEventListener('touchend', function (event) {
            touchEndX = event.changedTouches[0].screenX;
            const distance = touchEndX - touchStartX;

            if (Math.abs(distance) > 50) {
                if (distance < 0) nextSlide();
                else previousSlide();
            }

            startAutoplay();
        }, { passive: true });

        updateSlider();
        startAutoplay();
    }


    /* =========================================================
       CATEGORY SLIDER
    ========================================================= */
    const catTrack = document.getElementById('category-track');
    const catPrev = document.getElementById('category-prev');
    const catNext = document.getElementById('category-next');

    if (catTrack && catPrev && catNext) {

        function getScrollAmount() {
            const card = catTrack.querySelector('a');
            if (!card) return 500;

            const gap = window.innerWidth >= 640 ? 16 : 12;
            return (card.offsetWidth + gap) * 3;
        }

        catNext.addEventListener('click', function () {
            catTrack.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        catPrev.addEventListener('click', function () {
            catTrack.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });
    }

});
</script>
@endpush