@extends('layouts.app')

@section('title', 'Search Events - Eventverse.id')

@section('meta_description', 'Search and discover events, competitions, workshops, and experiences on Eventverse.id.')

@section('content')

<div class="min-h-screen bg-[#f8fafc]">

    {{-- =========================================================
        SEARCH HEADER
    ========================================================== --}}
    <section class="relative overflow-hidden bg-white border-b border-[#e2e8f0]">

        {{-- Soft Background --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -left-32 w-[520px] h-[520px] rounded-full bg-[#2282ff]/[0.08] blur-3xl"></div>
            <div class="absolute top-20 right-[-180px] w-[420px] h-[420px] rounded-full bg-[#60a5fa]/[0.05] blur-3xl"></div>

            <div class="absolute top-16 left-[22%] w-32 h-32 rounded-full border border-[#2282ff]/[0.07]"></div>
            <div class="absolute top-28 left-[25%] w-2.5 h-2.5 rounded-full bg-[#2282ff]/20"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-4xl mx-auto py-10 md:py-10">

                {{-- Heading --}}
                <div class="text-center mb-7">

                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff] text-xs font-semibold border border-[#2282ff]/20 mb-4">

                        <svg class="w-3.5 h-3.5"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                        </svg>

                        <span>EVENTVERSE.ID</span>
                    </div>

                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold tracking-tight text-[#0f172a] leading-tight">
                        Search your favorite
                        <span class="text-[#2282ff]">events</span>
                    </h1>

                    <p class="mt-2.5 text-sm sm:text-base text-[#64748b]">
                        Discover events, competitions, workshops, and experiences that match your interests.
                    </p>

                </div>


                {{-- =====================================================
                    SEARCH FORM
                ====================================================== --}}
                <form method="GET"
                      action=""
                      id="search-filter-form">

                    {{-- Search Input --}}
                    <div class="flex items-center w-full p-1.5 rounded-2xl bg-white border border-[#e2e8f0]
                                shadow-[0_8px_30px_rgba(34,130,255,0.08)]
                                focus-within:border-[#2282ff]/40
                                focus-within:shadow-[0_8px_30px_rgba(34,130,255,0.12)]
                                transition-all">

                        <div class="flex items-center justify-center w-11 h-11 shrink-0 text-[#64748b]">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m20 20-4-4"/>
                            </svg>

                        </div>

                        <input
                            type="search"
                            name="key"
                            value="{{ request('key') }}"
                            placeholder="Search events, cities, or categories..."
                            autocomplete="off"
                            class="flex-1 min-w-0 px-2 py-3 text-sm text-[#0f172a]
                                   placeholder:text-[#94a3b8]
                                   bg-transparent border-0 outline-none
                                   focus:ring-0"
                        >

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2
                                   px-5 sm:px-6 py-3
                                   rounded-xl
                                   bg-[#2282ff]
                                   hover:bg-[#1b6cd6]
                                   text-white text-sm font-semibold
                                   shadow-sm
                                   transition-all
                                   hover:-translate-y-0.5
                                   shrink-0">

                            <span class="hidden sm:inline">Search</span>

                            <svg class="w-4 h-4"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2.5"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m9 18 6-6-6-6"/>
                            </svg>

                        </button>

                    </div>


                    {{-- =================================================
                        ACTIVE FILTERS
                    ================================================== --}}
                    @if (
                        request('catName') ||
                        request('category') ||
                        request('location') ||
                        request('city') ||
                        request('date') ||
                        request('price') !== null
                    )

                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2">

                            <span class="text-xs font-semibold text-[#64748b] mr-1">
                                Active filters:
                            </span>

                            @if (request('catName'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                             bg-[#ebf3ff] text-[#2282ff]
                                             border border-[#2282ff]/15
                                             text-xs font-semibold">

                                    {{ request('catName') }}

                                </span>
                            @endif


                            @if (request('location'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                             bg-white text-[#475569]
                                             border border-[#e2e8f0]
                                             text-xs font-semibold">

                                    {{ request('location') }}

                                </span>
                            @endif


                            @if (request('city'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                             bg-white text-[#475569]
                                             border border-[#e2e8f0]
                                             text-xs font-semibold">

                                    {{ ucwords(strtolower(request('city'))) }}

                                </span>
                            @endif


                            @if (request('date'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                             bg-white text-[#475569]
                                             border border-[#e2e8f0]
                                             text-xs font-semibold">

                                    {{ request('date') }}

                                </span>
                            @endif


                            @if (request('price') !== null && request('price') !== '')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                             bg-white text-[#475569]
                                             border border-[#e2e8f0]
                                             text-xs font-semibold">

                                    {{ request('price') == 0 ? 'Gratis' : 'Berbayar' }}

                                </span>
                            @endif

                        </div>

                    @endif

                </form>

            </div>

        </div>

    </section>


    {{-- =========================================================
        RESULTS SECTION
    ========================================================== --}}
    <section class="py-8 md:py-10">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            {{-- =====================================================
                TOOLBAR
            ====================================================== --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">

                {{-- Result Information --}}
                <div>

                    <h2 class="text-xl sm:text-2xl font-bold tracking-[-0.03em] text-[#0f172a]">
                        Search
                        <span class="text-[#2282ff]">results</span>
                    </h2>

                    <p class="mt-1 text-sm text-[#64748b]">
                        @if (request('key'))
                            Results for
                            <span class="font-semibold text-[#0f172a]">
                                "{{ request('key') }}"
                            </span>
                        @else
                            Explore events available on Eventverse.
                        @endif
                    </p>

                </div>


                {{-- Filter / Sort --}}
                <div class="flex items-center gap-2">

                    {{-- Filter --}}
                    <button
                        type="button"
                        data-modal-open="filterModal"
                        class="inline-flex items-center justify-center gap-2
                               px-4 py-2.5
                               rounded-xl
                               bg-white
                               border border-[#e2e8f0]
                               text-[#334155]
                               text-sm font-semibold
                               shadow-sm
                               hover:border-[#2282ff]/40
                               hover:text-[#2282ff]
                               hover:bg-[#ebf3ff]/30
                               transition-all">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 5h18M6 12h12m-8 7h4"/>
                        </svg>

                        <span>Filter</span>

                        @if (
                            request('category') ||
                            request('location') ||
                            request('city') ||
                            request('date') ||
                            request('price') !== null
                        )
                            <span class="flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full
                                         bg-[#2282ff] text-white text-[10px] font-bold">
                                !
                            </span>
                        @endif

                    </button>


                    {{-- Sort --}}
                    <button
                        type="button"
                        data-modal-open="sortModal"
                        class="inline-flex items-center justify-center gap-2
                               px-4 py-2.5
                               rounded-xl
                               bg-white
                               border border-[#e2e8f0]
                               text-[#334155]
                               text-sm font-semibold
                               shadow-sm
                               hover:border-[#2282ff]/40
                               hover:text-[#2282ff]
                               hover:bg-[#ebf3ff]/30
                               transition-all">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 7h12M8 12h12M8 17h12M4 7h.01M4 12h.01M4 17h.01"/>
                        </svg>

                        <span>Sort</span>

                    </button>

                </div>

            </div>


            {{-- =====================================================
                EVENT GRID
            ====================================================== --}}
            @if ($eventTerbaru->count())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">

                    @foreach ($eventTerbaru as $event)

                        @php
                            if (empty($event->image)) {
                                $eventImage = 'assets/default-img/event-images/def-img.png';
                            } else {
                                $imgPath = 'storage/event-images/' . $event->image;

                                $eventImage = file_exists(public_path($imgPath))
                                    ? $imgPath
                                    : 'assets/default-img/event-images/def-img.png';
                            }

                            $firstTicket = $event->ticket->first();
                        @endphp


                        <a
                            href="/{{ $event->slug }}"
                            target="_blank"
                            class="group flex flex-col
                                   bg-white
                                   rounded-2xl
                                   border border-[#e2e8f0]
                                   shadow-xs
                                   hover:shadow-md
                                   hover:border-[#cbd5e1]
                                   hover:-translate-y-1
                                   transition-all duration-200
                                   overflow-hidden
                                   cursor-pointer">


                            {{-- ===============================
                                IMAGE
                            ================================ --}}
                            <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">

                                <img
                                    src="{{ asset($eventImage) }}"
                                    alt="{{ $event->title }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover
                                           group-hover:scale-105
                                           transition-transform duration-300">


                                {{-- Category --}}
                                <div class="absolute top-3 left-3">

                                    <span class="inline-flex items-center
                                                 px-2.5 py-1
                                                 rounded-md
                                                 text-[10px] sm:text-[11px]
                                                 font-bold
                                                 uppercase
                                                 tracking-wider
                                                 bg-white/90
                                                 text-[#0f172a]
                                                 border border-[#e2e8f0]
                                                 shadow-xs
                                                 backdrop-blur-sm">

                                        {{ strtoupper($event->category->name ?? 'EVENT') }}

                                    </span>

                                </div>

                            </div>


                            {{-- ===============================
                                CARD BODY
                            ================================ --}}
                            <div class="p-4 flex-1 flex flex-col justify-between">

                                <div>

                                    {{-- Title --}}
                                    <h3 class="text-sm sm:text-base
                                               font-bold
                                               text-[#0f172a]
                                               group-hover:text-[#2282ff]
                                               transition-colors
                                               line-clamp-2
                                               leading-snug">

                                        {{ $event->title }}

                                    </h3>


                                    {{-- Date / Location --}}
                                    <div class="mt-2.5 space-y-1 text-xs text-[#64748b]">

                                        {{-- Date --}}
                                        <div class="flex items-start gap-1.5">

                                            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M8 2v4m8-4v4M3.5 9.5h17M5 4h14a2 2 0 012 2v13a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>

                                            </svg>

                                            <span>
                                                {{ $event->start_date->format('d-m-Y') == $event->end_date->format('d-m-Y')
                                                    ? $event->end_date->format('d M Y')
                                                    : $event->start_date->format('d M Y') . ' - ' . $event->end_date->format('d M Y')
                                                }}
                                            </span>

                                        </div>


                                        {{-- Location --}}
                                        <div class="flex items-start gap-1.5 truncate">

                                            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z"/>

                                                <circle cx="12"
                                                        cy="10"
                                                        r="2.2"/>

                                            </svg>

                                            <span class="truncate">
                                                {{ $event->location_jenis == 'Offline'
                                                    ? ucwords(strtolower($event->location_city))
                                                    : $event->location_jenis
                                                }}
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- ===============================
                                    CARD FOOTER
                                ================================ --}}
                                <div class="mt-4 pt-3
                                            border-t border-[#e2e8f0]
                                            flex items-center justify-between">

                                    <div>

                                        <span class="text-[10px] sm:text-[11px]
                                                     text-[#64748b]
                                                     block
                                                     font-medium">
                                            Start from
                                        </span>


                                        @if ($firstTicket && $firstTicket->ticket_price !== null)

                                            <span class="text-sm sm:text-base
                                                         font-bold
                                                         {{ $firstTicket->ticket_price == 0
                                                             ? 'text-emerald-600'
                                                             : 'text-[#2282ff]' }}">

                                                {{ $firstTicket->ticket_price == 0
                                                    ? 'GRATIS!'
                                                    : 'Rp ' . number_format($firstTicket->ticket_price, 0, ',', '.')
                                                }}

                                            </span>

                                        @else

                                            <span class="text-sm font-semibold text-[#64748b]">
                                                Tidak tersedia
                                            </span>

                                        @endif

                                    </div>


                                    <span class="text-[11px] sm:text-xs
                                                 font-semibold
                                                 text-[#0f172a]
                                                 group-hover:text-[#2282ff]
                                                 transition-colors">

                                        Get Ticket →

                                    </span>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- =================================================
                    PAGINATION
                ================================================== --}}
                @if ($eventTerbaru->hasPages())
                    <div class="mt-12 flex flex-col items-center gap-4">

                        {{-- Pagination --}}
                        <nav class="flex items-center gap-1.5" aria-label="Pagination">

                            {{-- Previous --}}
                            @if ($eventTerbaru->onFirstPage())
                                <span
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl
                                        border border-slate-200 bg-slate-50 px-3
                                        text-sm font-medium text-slate-300 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.79 5.23a.75.75 0 01-.02 1.06L9.06 10l3.71 3.71a.75.75 0 11-1.06 1.06l-4.24-4.24a.75.75 0 010-1.06l4.24-4.24a.75.75 0 011.06-.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a
                                    href="{{ $eventTerbaru->previousPageUrl() }}"
                                    class="group inline-flex h-10 min-w-10 items-center justify-center rounded-xl
                                        border border-slate-200 bg-white px-3
                                        text-sm font-medium text-slate-600
                                        shadow-sm transition-all duration-200
                                        hover:border-[#2282ff]/30 hover:bg-[#2282ff]/5 hover:text-[#2282ff]">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 transition-transform group-hover:-translate-x-0.5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.79 5.23a.75.75 0 01-.02 1.06L9.06 10l3.71 3.71a.75.75 0 11-1.06 1.06l-4.24-4.24a.75.75 0 010-1.06l4.24-4.24a.75.75 0 011.06-.02z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <span class="hidden sm:inline ml-1.5">Previous</span>
                                </a>
                            @endif


                            {{-- Page Numbers --}}
                            @foreach ($eventTerbaru->getUrlRange(
                                max(1, $eventTerbaru->currentPage() - 2),
                                min($eventTerbaru->lastPage(), $eventTerbaru->currentPage() + 2)
                            ) as $page => $url)

                                @if ($page == $eventTerbaru->currentPage())

                                    <span
                                        aria-current="page"
                                        class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl
                                            bg-[#2282ff] px-3
                                            text-sm font-semibold text-white
                                            shadow-sm shadow-[#2282ff]/20">
                                        {{ $page }}
                                    </span>

                                @else

                                    <a
                                        href="{{ $url }}"
                                        class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl
                                            border border-transparent bg-transparent px-3
                                            text-sm font-medium text-slate-500
                                            transition-all duration-200
                                            hover:border-slate-200 hover:bg-white hover:text-[#2282ff]
                                            hover:shadow-sm">
                                        {{ $page }}
                                    </a>

                                @endif

                            @endforeach


                            {{-- Next --}}
                            @if ($eventTerbaru->hasMorePages())
                                <a
                                    href="{{ $eventTerbaru->nextPageUrl() }}"
                                    class="group inline-flex h-10 min-w-10 items-center justify-center rounded-xl
                                        border border-slate-200 bg-white px-3
                                        text-sm font-medium text-slate-600
                                        shadow-sm transition-all duration-200
                                        hover:border-[#2282ff]/30 hover:bg-[#2282ff]/5 hover:text-[#2282ff]">

                                    <span class="hidden sm:inline mr-1.5">Next</span>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L10.94 10 7.23 6.29a.75.75 0 111.06-1.06l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 01-1.06.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl
                                        border border-slate-200 bg-slate-50 px-3
                                        text-sm font-medium text-slate-300 cursor-not-allowed">
                                    <span class="hidden sm:inline mr-1.5">Next</span>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L10.94 10 7.23 6.29a.75.75 0 111.06-1.06l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 01-1.06.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif

                        </nav>

                        {{-- Result information --}}
                        <p class="text-xs font-medium text-slate-400">
                            Showing
                            <span class="text-slate-600">
                                {{ $eventTerbaru->firstItem() ?? 0 }}
                            </span>
                            –
                            <span class="text-slate-600">
                                {{ $eventTerbaru->lastItem() ?? 0 }}
                            </span>
                            of
                            <span class="text-slate-600">
                                {{ $eventTerbaru->total() }}
                            </span>
                            events
                        </p>

                    </div>
                @endif


            @else

                {{-- =================================================
                    EMPTY STATE
                ================================================== --}}
                <div class="py-16">

                    <div class="max-w-md mx-auto text-center">

                        <div class="mx-auto w-16 h-16 rounded-2xl
                                    bg-[#ebf3ff]
                                    text-[#2282ff]
                                    flex items-center justify-center">

                            <svg class="w-7 h-7"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 viewBox="0 0 24 24">

                                <circle cx="11"
                                        cy="11"
                                        r="7"/>

                                <path stroke-linecap="round"
                                      d="m20 20-4-4"/>

                            </svg>

                        </div>


                        <h3 class="mt-5 text-lg font-bold text-[#0f172a]">
                            No events found
                        </h3>

                        <p class="mt-2 text-sm leading-relaxed text-[#64748b]">
                            We couldn't find any events matching your search.
                            Try changing your keywords or adjusting the filters.
                        </p>


                        <a
                            href="/search"
                            class="inline-flex items-center justify-center gap-2
                                   mt-6
                                   px-5 py-2.5
                                   rounded-xl
                                   bg-[#2282ff]
                                   hover:bg-[#1b6cd6]
                                   text-white
                                   text-sm font-semibold
                                   shadow-sm
                                   transition-all">

                            Clear search

                            <svg class="w-4 h-4"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m9 18 6-6-6-6"/>
                            </svg>

                        </a>

                    </div>

                </div>

            @endif

        </div>

    </section>

</div>


{{-- =============================================================
    FILTER MODAL
============================================================== --}}
<div
    id="filterModal"
    class="fixed inset-0 z-[9999] hidden"
    aria-hidden="true">

    {{-- Backdrop --}}
    <div
        data-modal-close="filterModal"
        class="absolute inset-0 bg-[#0f172a]/50 backdrop-blur-sm opacity-0 transition-opacity duration-200">
    </div>


    {{-- Modal Wrapper --}}
    <div class="relative z-10 flex min-h-full items-end sm:items-center justify-center sm:p-4">

        <div
            data-modal-panel
            class="relative w-full sm:max-w-lg
                   bg-white
                   rounded-t-[1.75rem] sm:rounded-2xl
                   shadow-2xl
                   border border-[#e2e8f0]
                   transform translate-y-full sm:translate-y-4
                   opacity-0
                   transition-all duration-200
                   max-h-[92vh]
                   overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between
                        px-5 sm:px-6
                        py-4
                        border-b border-[#e2e8f0]">

                <div>

                    <h3 class="text-base sm:text-lg font-bold text-[#0f172a]">
                        Filter events
                    </h3>

                    <p class="mt-0.5 text-xs text-[#64748b]">
                        Refine your event search
                    </p>

                </div>


                <button
                    type="button"
                    data-modal-close="filterModal"
                    class="w-9 h-9
                           rounded-xl
                           bg-[#f8fafc]
                           text-[#64748b]
                           hover:bg-[#f1f5f9]
                           hover:text-[#0f172a]
                           flex items-center justify-center
                           transition-colors">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 6l12 12M18 6L6 18"/>

                    </svg>

                </button>

            </div>


            {{-- Body --}}
            <div class="px-5 sm:px-6 py-5 overflow-y-auto max-h-[calc(92vh-145px)]">

                {{-- Category --}}
                <div class="mb-5">

                    <label
                        for="filter-category"
                        class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-2">

                        Category

                    </label>

                    <div class="relative">

                        <select
                            id="filter-category"
                            name="category"
                            form="search-filter-form"
                            class="w-full appearance-none
                                   px-4 py-3 pr-10
                                   rounded-xl
                                   bg-[#f8fafc]
                                   border border-[#e2e8f0]
                                   text-sm text-[#0f172a]
                                   outline-none
                                   focus:bg-white
                                   focus:border-[#2282ff]/50
                                   focus:ring-4
                                   focus:ring-[#2282ff]/10
                                   transition-all">

                            <option value="">
                                All categories
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>

                                    {{ ucwords(strtolower($category->name)) }}

                                </option>

                            @endforeach

                        </select>


                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4
                                    text-[#64748b]
                                    pointer-events-none"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="m6 9 6 6 6-6"/>

                        </svg>

                    </div>

                    <input
                        type="hidden"
                        name="catName"
                        id="cat-name"
                        value="{{ request('catName') }}"
                        form="search-filter-form">

                </div>


                {{-- Event Type --}}
                <div class="mb-5">

                    <label
                        for="filter-jenis-lokasi"
                        class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-2">

                        Event type

                    </label>

                    <div class="relative">

                        <select
                            id="filter-jenis-lokasi"
                            name="location"
                            form="search-filter-form"
                            class="w-full appearance-none
                                   px-4 py-3 pr-10
                                   rounded-xl
                                   bg-[#f8fafc]
                                   border border-[#e2e8f0]
                                   text-sm text-[#0f172a]
                                   outline-none
                                   focus:bg-white
                                   focus:border-[#2282ff]/50
                                   focus:ring-4
                                   focus:ring-[#2282ff]/10
                                   transition-all">

                            @foreach ($jenisevent as $jenis)

                                <option
                                    value="{{ $jenis['val'] }}"
                                    {{ request('location') == $jenis['val'] ? 'selected' : '' }}>

                                    {{ $jenis['text'] }}

                                </option>

                            @endforeach

                        </select>


                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4
                                    text-[#64748b]
                                    pointer-events-none"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="m6 9 6 6 6-6"/>

                        </svg>

                    </div>

                </div>


                {{-- City --}}
                <div
                    id="city-filter-wrapper"
                    class="mb-5 {{ request('location') == 'Online' ? 'hidden' : '' }}">

                    <label
                        for="filter-city"
                        class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-2">

                        City

                    </label>

                    <div class="relative">

                        <select
                            id="filter-city"
                            name="city"
                            form="search-filter-form"
                            class="w-full appearance-none
                                   px-4 py-3 pr-10
                                   rounded-xl
                                   bg-[#f8fafc]
                                   border border-[#e2e8f0]
                                   text-sm text-[#0f172a]
                                   outline-none
                                   focus:bg-white
                                   focus:border-[#2282ff]/50
                                   focus:ring-4
                                   focus:ring-[#2282ff]/10
                                   transition-all">

                            <option value="">
                                All cities
                            </option>

                            @foreach ($cities as $city)

                                <option
                                    value="{{ $city->name }}"
                                    {{ request('city') == $city->name ? 'selected' : '' }}>

                                    {{ ucwords(strtolower($city->name)) }}

                                </option>

                            @endforeach

                        </select>


                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4
                                    text-[#64748b]
                                    pointer-events-none"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="m6 9 6 6 6-6"/>

                        </svg>

                    </div>

                </div>


                {{-- Date --}}
                <div class="mb-5">

                    <label
                        for="filter-date"
                        class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-2">

                        Date

                    </label>

                    <div class="relative">

                        <input
                            id="filter-date"
                            name="date"
                            type="date"
                            form="search-filter-form"
                            value="{{ request('date') }}"
                            class="w-full
                                   px-4 py-3
                                   rounded-xl
                                   bg-[#f8fafc]
                                   border border-[#e2e8f0]
                                   text-sm text-[#0f172a]
                                   outline-none
                                   focus:bg-white
                                   focus:border-[#2282ff]/50
                                   focus:ring-4
                                   focus:ring-[#2282ff]/10
                                   transition-all">

                    </div>

                </div>


                {{-- Price --}}
                <div>

                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-2">
                        Price
                    </label>


                    <div class="grid grid-cols-3 gap-2">

                        {{-- All --}}
                        <label class="cursor-pointer">

                            <input
                                type="radio"
                                name="price"
                                value=""
                                form="search-filter-form"
                                class="peer sr-only"
                                {{ request('price') === null || request('price') === '' ? 'checked' : '' }}>

                            <div class="px-3 py-3
                                        rounded-xl
                                        border border-[#e2e8f0]
                                        bg-white
                                        text-center
                                        text-xs sm:text-sm
                                        font-semibold
                                        text-[#64748b]
                                        peer-checked:border-[#2282ff]
                                        peer-checked:bg-[#ebf3ff]
                                        peer-checked:text-[#2282ff]
                                        transition-all">

                                All

                            </div>

                        </label>


                        {{-- Free --}}
                        <label class="cursor-pointer">

                            <input
                                type="radio"
                                name="price"
                                value="0"
                                form="search-filter-form"
                                class="peer sr-only"
                                {{ request('price') == '0' ? 'checked' : '' }}>

                            <div class="px-3 py-3
                                        rounded-xl
                                        border border-[#e2e8f0]
                                        bg-white
                                        text-center
                                        text-xs sm:text-sm
                                        font-semibold
                                        text-[#64748b]
                                        peer-checked:border-emerald-500
                                        peer-checked:bg-emerald-50
                                        peer-checked:text-emerald-600
                                        transition-all">

                                Free

                            </div>

                        </label>


                        {{-- Paid --}}
                        <label class="cursor-pointer">

                            <input
                                type="radio"
                                name="price"
                                value="1"
                                form="search-filter-form"
                                class="peer sr-only"
                                {{ request('price') == '1' ? 'checked' : '' }}>

                            <div class="px-3 py-3
                                        rounded-xl
                                        border border-[#e2e8f0]
                                        bg-white
                                        text-center
                                        text-xs sm:text-sm
                                        font-semibold
                                        text-[#64748b]
                                        peer-checked:border-[#2282ff]
                                        peer-checked:bg-[#ebf3ff]
                                        peer-checked:text-[#2282ff]
                                        transition-all">

                                Paid

                            </div>

                        </label>

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <div class="flex items-center gap-3
                        px-5 sm:px-6
                        py-4
                        bg-white
                        border-t border-[#e2e8f0]">

                <a
                    href="/search"
                    class="flex-1 inline-flex items-center justify-center
                           px-4 py-3
                           rounded-xl
                           bg-[#f8fafc]
                           hover:bg-[#f1f5f9]
                           text-[#475569]
                           text-sm font-semibold
                           border border-[#e2e8f0]
                           transition-colors">

                    Reset

                </a>


                <button
                    type="submit"
                    form="search-filter-form"
                    class="flex-[1.5] inline-flex items-center justify-center gap-2
                           px-4 py-3
                           rounded-xl
                           bg-[#2282ff]
                           hover:bg-[#1b6cd6]
                           text-white
                           text-sm font-semibold
                           shadow-sm
                           transition-all">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/>

                    </svg>

                    Apply filters

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    SORT MODAL
============================================================== --}}
<div
    id="sortModal"
    class="fixed inset-0 z-[9999] hidden"
    aria-hidden="true">

    {{-- Backdrop --}}
    <div
        data-modal-close="sortModal"
        class="absolute inset-0 bg-[#0f172a]/50 backdrop-blur-sm opacity-0 transition-opacity duration-200">
    </div>


    <div class="relative z-10 flex min-h-full items-end sm:items-center justify-center sm:p-4">

        <div
            data-modal-panel
            class="relative w-full sm:max-w-md
                   bg-white
                   rounded-t-[1.75rem] sm:rounded-2xl
                   shadow-2xl
                   border border-[#e2e8f0]
                   transform translate-y-full sm:translate-y-4
                   opacity-0
                   transition-all duration-200
                   overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between
                        px-5 sm:px-6 py-4
                        border-b border-[#e2e8f0]">

                <div>

                    <h3 class="text-base sm:text-lg font-bold text-[#0f172a]">
                        Sort events
                    </h3>

                    <p class="mt-0.5 text-xs text-[#64748b]">
                        Choose how you want to view the results.
                    </p>

                </div>


                <button
                    type="button"
                    data-modal-close="sortModal"
                    class="w-9 h-9 rounded-xl
                           bg-[#f8fafc]
                           text-[#64748b]
                           hover:bg-[#f1f5f9]
                           hover:text-[#0f172a]
                           flex items-center justify-center">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 6l12 12M18 6L6 18"/>

                    </svg>

                </button>

            </div>


            {{-- Sort Options --}}
            <div class="p-5 sm:p-6">

                <div class="space-y-2">

                    @foreach ($sorts as $sort)

                        <label class="block cursor-pointer">

                            <input
                                type="radio"
                                name="sort"
                                value="{{ $sort }}"
                                form="search-filter-form"
                                class="peer sr-only"
                                {{ request('sort') == $sort ? 'checked' : '' }}>

                            <div class="flex items-center justify-between
                                        px-4 py-3.5
                                        rounded-xl
                                        border border-[#e2e8f0]
                                        bg-white
                                        text-sm font-semibold
                                        text-[#475569]
                                        peer-checked:border-[#2282ff]
                                        peer-checked:bg-[#ebf3ff]
                                        peer-checked:text-[#2282ff]
                                        transition-all">

                                <span>
                                    {{ $sort }}
                                </span>


                                <svg class="w-4 h-4 opacity-0 peer-checked:opacity-100"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2.5"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m5 12 4 4L19 6"/>

                                </svg>

                            </div>

                        </label>

                    @endforeach

                </div>

            </div>


            {{-- Footer --}}
            <div class="flex gap-3
                        px-5 sm:px-6 py-4
                        border-t border-[#e2e8f0]">

                <button
                    type="button"
                    data-modal-close="sortModal"
                    class="flex-1
                           px-4 py-3
                           rounded-xl
                           bg-[#f8fafc]
                           hover:bg-[#f1f5f9]
                           border border-[#e2e8f0]
                           text-[#475569]
                           text-sm font-semibold">

                    Cancel

                </button>


                <button
                    type="submit"
                    form="search-filter-form"
                    class="flex-[1.5]
                           inline-flex items-center justify-center gap-2
                           px-4 py-3
                           rounded-xl
                           bg-[#2282ff]
                           hover:bg-[#1b6cd6]
                           text-white
                           text-sm font-semibold
                           shadow-sm">

                    Apply sort

                </button>

            </div>

        </div>

    </div>

</div>


@endsection


{{-- =============================================================
    SCRIPTS
============================================================== --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | MODAL
    |--------------------------------------------------------------------------
    */

    function openModal(id) {

        const modal = document.getElementById(id);

        if (!modal) return;

        const backdrop = modal.querySelector('[data-modal-close]');
        const panel = modal.querySelector('[data-modal-panel]');

        modal.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(function () {

            backdrop?.classList.remove('opacity-0');

            panel?.classList.remove(
                'translate-y-full',
                'sm:translate-y-4',
                'opacity-0'
            );

        });

    }


    function closeModal(id) {

        const modal = document.getElementById(id);

        if (!modal) return;

        const backdrop = modal.querySelector('[data-modal-close]');
        const panel = modal.querySelector('[data-modal-panel]');

        backdrop?.classList.add('opacity-0');

        panel?.classList.add(
            'translate-y-full',
            'sm:translate-y-4',
            'opacity-0'
        );

        setTimeout(function () {

            modal.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');

        }, 200);

    }


    document.querySelectorAll('[data-modal-open]').forEach(function (button) {

        button.addEventListener('click', function () {

            openModal(this.dataset.modalOpen);

        });

    });


    document.querySelectorAll('[data-modal-close]').forEach(function (button) {

        button.addEventListener('click', function () {

            const modal = this.closest('[id$="Modal"]');

            if (modal) {
                closeModal(modal.id);
            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') return;

        document.querySelectorAll('[id$="Modal"]:not(.hidden)').forEach(function (modal) {

            closeModal(modal.id);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | LOCATION TYPE
    |--------------------------------------------------------------------------
    */

    const locationSelect = document.getElementById('filter-jenis-lokasi');
    const cityWrapper = document.getElementById('city-filter-wrapper');

    function updateCityVisibility() {

        if (!locationSelect || !cityWrapper) return;

        if (locationSelect.value === 'Online') {

            cityWrapper.classList.add('hidden');

        } else {

            cityWrapper.classList.remove('hidden');

        }

    }


    locationSelect?.addEventListener('change', updateCityVisibility);

    updateCityVisibility();


    /*
    |--------------------------------------------------------------------------
    | CATEGORY NAME
    |--------------------------------------------------------------------------
    */

    const categorySelect = document.getElementById('filter-category');
    const categoryNameInput = document.getElementById('cat-name');

    categorySelect?.addEventListener('change', function () {

        if (!categoryNameInput) return;

        const selectedOption = this.options[this.selectedIndex];

        categoryNameInput.value =
            this.value
                ? selectedOption.text.trim()
                : '';

    });


    /*
    |--------------------------------------------------------------------------
    | SORT AUTO SUBMIT
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('#sortModal input[name="sort"]').forEach(function (radio) {

        radio.addEventListener('change', function () {

            // Tidak langsung submit.
            // User tetap menekan "Apply sort".

        });

    });

});
</script>

@endpush