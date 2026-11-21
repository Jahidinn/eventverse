@extends('dashboard.layouts.app')

@section('title', 'Participants')

@section('content')
    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-5 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true"
                 class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>

            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">
                    Peserta Event
                </h1>
                <p class="mt-2 max-w-lg text-sm leading-6 text-blue-100">
                    Pilih event untuk melihat daftar peserta dan mengelola check-in.
                </p>
            </div>

            <i class="ti ti-users hidden text-5xl text-blue-200/80 sm:block" aria-hidden="true"></i>
        </header>

        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-start gap-2 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm sm:items-center sm:gap-3">
            <form method="GET" class="flex min-w-0 flex-wrap items-center gap-2">
                <div class="flex min-h-11 min-w-[8rem] flex-[1_1_8rem] items-center gap-2 rounded-xl border border-slate-200 px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100">
                    <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                    <input type="search" name="key" value="{{ request('key') }}"
                           aria-label="Cari event" placeholder="Cari event…"
                           class="w-full min-w-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-500">
                </div>

                <button type="submit"
                        class="inline-flex min-h-11 items-center rounded-xl border border-slate-200 px-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                    Cari
                </button>

                @if (request('key'))
                    <a href="{{ url('/dashboard/participant-data') }}"
                       class="inline-flex min-h-11 items-center rounded-xl px-2 text-sm font-semibold text-blue-700 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                        Reset
                    </a>
                @endif
            </form>

            <span class="mt-2 inline-flex items-center gap-1.5 whitespace-nowrap rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold tabular-nums text-slate-600 sm:mt-0">
                <i class="ti ti-layout-grid hidden sm:inline" aria-hidden="true"></i>
                {{ number_format($dataEvent->total(), 0, ',', '.') }} event
            </span>
        </div>

        @if ($dataEvent->isEmpty())
            <section class="flex flex-col items-center gap-2 rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center">
                <span class="mb-1 grid h-12 w-12 place-items-center rounded-xl bg-blue-50 text-2xl text-blue-700" aria-hidden="true">
                    <i class="ti ti-calendar-off"></i>
                </span>

                @if (request('key'))
                    <h2 class="text-lg font-semibold">Event tidak ditemukan</h2>
                    <p class="text-sm text-slate-600">Coba kata kunci lain atau tampilkan semua event.</p>
                    <a href="{{ url('/dashboard/participant-data') }}"
                       class="mt-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-blue-800 hover:bg-blue-50">
                        Tampilkan semua event
                    </a>
                @else
                    <h2 class="text-lg font-semibold">Belum ada event</h2>
                    <p class="text-sm text-slate-600">Buat event terlebih dahulu untuk mengelola peserta.</p>
                    <button type="button" data-create-event
                            class="mt-2 inline-flex min-h-11 items-center gap-2 rounded-xl bg-[#1765c4] px-4 text-sm font-semibold text-white hover:bg-[#174f9e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <i class="ti ti-plus" aria-hidden="true"></i>
                        Buat event
                    </button>
                @endif
            </section>
        @else
            <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                @foreach ($dataEvent as $event)
                    @php
                        $participantsUrl = url('/dashboard/participant-data/' . $event->event_id);
                        $imagePath = $event->image ? 'storage/event-images/' . $event->image : null;
                        $imageExists = $imagePath && file_exists(public_path($imagePath));
                    @endphp

                    <article class="group grid min-w-0 grid-cols-[5.25rem_minmax(0,1fr)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-colors hover:border-blue-200 md:flex md:flex-col">
                        <a href="{{ $participantsUrl }}" aria-label="Lihat peserta {{ $event->title }}"
                           class="relative isolate block min-h-24 overflow-hidden bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-600 md:aspect-[16/7] md:min-h-0">
                            <span class="absolute inset-0 grid place-items-center text-2xl text-blue-500" aria-hidden="true">
                                <i class="ti ti-photo-off"></i>
                            </span>

                            @if ($imageExists)
                                <img src="{{ asset($imagePath) }}" alt="" loading="lazy"
                                     class="absolute inset-0 h-full w-full object-cover motion-safe:transition-transform motion-safe:duration-300 motion-safe:group-hover:scale-[1.03]"
                                     onerror="this.hidden = true; this.classList.add('hidden')">
                            @endif
                        </a>

                        <div class="flex min-w-0 flex-1 flex-col p-3.5">
                            <h2 class="break-words font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-sm font-semibold leading-snug tracking-tight md:text-base">
                                <a href="{{ $participantsUrl }}"
                                   class="hover:text-blue-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                    {{ $event->title }}
                                </a>
                            </h2>

                            <p class="mt-2 flex items-start gap-1.5 text-xs leading-5 text-slate-600">
                                <i class="ti ti-calendar-event shrink-0 text-base text-blue-700" aria-hidden="true"></i>
                                <span>
                                    {{ $event->start_date?->format('d M Y') ?? 'Tanggal belum diisi' }}
                                    @if ($event->end_date)
                                        · s.d. {{ $event->end_date->format('d M Y') }}
                                    @endif
                                </span>
                            </p>

                            <div class="mt-auto pt-3">
                                <a href="{{ $participantsUrl }}"
                                   class="inline-flex min-h-10 w-full items-center gap-2 rounded-xl border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 md:text-sm">
                                    <i class="ti ti-users shrink-0 text-base" aria-hidden="true"></i>
                                    <span class="flex-1">Kelola peserta</span>
                                    <i class="ti ti-arrow-right shrink-0 text-base" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($dataEvent->hasPages())
                @php
                    $pagination = $dataEvent->withQueryString();
                    $pageLinks = $pagination->linkCollection()->slice(1, -1);
                    $pageButton = 'inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-sm font-semibold tabular-nums focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
                    $pageLink = $pageButton . ' border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-800';
                @endphp

                <nav aria-label="Halaman peserta per event"
                     class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700">
                    <p class="text-xs tabular-nums">
                        {{ $pagination->firstItem() }}–{{ $pagination->lastItem() }}
                        dari {{ number_format($pagination->total(), 0, ',', '.') }} event
                    </p>

                    <div class="flex flex-wrap items-center gap-1.5">
                        @if ($pagination->previousPageUrl())
                            <a href="{{ $pagination->previousPageUrl() }}" rel="prev"
                               aria-label="Halaman sebelumnya" class="{{ $pageLink }}">
                                <i class="ti ti-chevron-left" aria-hidden="true"></i>
                            </a>
                        @endif

                        @foreach ($pageLinks as $link)
                            @if ($link['active'])
                                <span aria-current="page"
                                      class="{{ $pageButton }} bg-blue-50 text-blue-800 ring-1 ring-inset ring-blue-200">
                                    {{ $link['label'] }}
                                </span>
                            @elseif ($link['url'])
                                <a href="{{ $link['url'] }}" aria-label="Halaman {{ $link['label'] }}"
                                   class="{{ $pageLink }}">
                                    {{ $link['label'] }}
                                </a>
                            @else
                                <span class="px-1 text-sm text-slate-500">…</span>
                            @endif
                        @endforeach

                        @if ($pagination->nextPageUrl())
                            <a href="{{ $pagination->nextPageUrl() }}" rel="next"
                               aria-label="Halaman berikutnya" class="{{ $pageLink }}">
                                <i class="ti ti-chevron-right" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </nav>
            @endif
        @endif
    </div>
@endsection