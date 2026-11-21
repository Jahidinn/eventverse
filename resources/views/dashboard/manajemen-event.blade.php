@extends('dashboard.layouts.app')

@section('title', 'Event Management')

@section('content')
    @php
        $money = static fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    @endphp
    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        {{-- Header --}}
        <header class="relative isolate flex flex-wrap items-end justify-between gap-5 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white shadow-sm sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Event Management</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-blue-100">Kelola publikasi, penjualan tiket, dan dana dari setiap event.</p>
            </div>
            <div class="flex flex-wrap gap-2 [&>button]:bg-white [&>button]:text-blue-900 [&>button:hover]:bg-blue-50">
                <button type="button" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e]" data-create-event>
                    <i class="ti ti-plus"></i>
                    Buat event
                </button>
            </div>
        </header>
        {{-- Toolbar --}}
        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-2 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm sm:gap-3">
            <form method="GET" action="" class="flex min-w-0 flex-wrap items-center gap-2">
                <div class="flex min-h-11 min-w-[8rem] flex-[1_1_8rem] items-center gap-2 rounded-xl border border-slate-200 px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 sm:w-64">
                    <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                    <input type="search" name="key" aria-label="Cari event" class="min-w-0 flex-1 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-500" value="{{ request('key') }}" placeholder="Cari event...">
                </div>
                <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Cari</button>
                @if (request('key'))
                    <a href="/dashboard/manajemen-event" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Reset</a>
                @endif
            </form>
            <span class="inline-flex self-start items-center gap-1.5 whitespace-nowrap rounded-lg bg-slate-100 sm:self-center px-2.5 py-1.5 text-xs font-semibold text-slate-600 tabular-nums">
                <i class="ti ti-layout-grid"></i>
                {{ number_format($listEvent->total(), 0, ',', '.') }} event
            </span>
        </div>
        {{-- Empty state --}}
        @if ($listEvent->isEmpty())
            <div class="flex flex-col items-center gap-2 rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center text-sm text-slate-600 sm:py-16">
                <span class="mb-1 grid h-14 w-14 place-items-center rounded-2xl bg-blue-50 text-2xl text-blue-700"><i class="ti ti-calendar-plus"></i></span>
                @if (request('key'))
                    <h2 class="text-lg font-bold text-slate-950">Event tidak ditemukan</h2>
                    <p>Coba kata kunci yang berbeda atau tampilkan semua event.</p>
                    <a href="/dashboard/manajemen-event" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Tampilkan semua event</a>
                @else
                    <h2 class="text-lg font-bold text-slate-950">Belum ada event</h2>
                    <p>Buat event pertama, lalu kelola ticketing dan publikasinya di Event Studio.</p>
                    <button type="button" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e] mt-4" data-create-event>
                        <i class="ti ti-plus"></i> Buat event
                    </button>
                @endif
            </div>
        @else
            {{-- Grid cards --}}
            <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 2xl:gap-4">
                @foreach ($listEvent as $event)
                    @php
                        $summary = $finance[$event->id];
                        $imageExists = $event->image && file_exists(public_path('storage/event-images/' . $event->image));
                        $isDraft = $event->event_status === 'draft';
                        $statusClass = $isDraft ? 'bg-amber-50 text-amber-950 ring-amber-200' : 'bg-emerald-50 text-emerald-900 ring-emerald-200';
                    @endphp
                    <article class="flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-colors hover:border-blue-200">
                        {{-- Cover --}}
                        @if ($isDraft)
                            <a
                                href="#"
                                class="group relative isolate block aspect-[16/7] overflow-hidden bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-600"
                                aria-label="Event masih draft"
                                data-draft-detail
                                data-draft-title="{{ $event->title }}"
                                data-draft-studio="/event-studio/{{ $event->event_id }}/basic">
                                <span class="absolute inset-0 grid place-items-center text-3xl text-blue-400"><i class="ti ti-lock"></i></span>
                                @if ($imageExists)
                                    <img src="{{ asset('storage/event-images/' . $event->image) }}" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-cover motion-safe:transition-transform motion-safe:duration-300 motion-safe:group-hover:scale-[1.03]" onerror="this.hidden=true; this.classList.add('hidden')">
                                @endif
                                <span class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">{{ match ($event->event_status) { 'draft' => 'Draf', 'published' => 'Terbit', default => $event->event_status } }}</span>
                            </a>
                        @else
                            <a href="/{{ $event->slug }}" class="group relative isolate block aspect-[16/7] overflow-hidden bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-600" aria-label="Lihat detail {{ $event->title }}">
                                <span class="absolute inset-0 grid place-items-center text-3xl text-blue-400"><i class="ti ti-photo-off"></i></span>
                                @if ($imageExists)
                                    <img src="{{ asset('storage/event-images/' . $event->image) }}" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-cover motion-safe:transition-transform motion-safe:duration-300 motion-safe:group-hover:scale-[1.03]" onerror="this.hidden=true; this.classList.add('hidden')">
                                @endif
                                <span class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">{{ match ($event->event_status) { 'draft' => 'Draf', 'published' => 'Terbit', default => $event->event_status } }}</span>
                            </a>
                        @endif
                        {{-- Body --}}
                        <div class="flex min-w-0 flex-1 flex-col p-3.5">
                            @if ($isDraft)
                                <a
                                    href="#"
                                    class="break-words font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-base font-bold leading-snug tracking-tight text-slate-950 hover:text-blue-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600"
                                    data-draft-detail
                                    data-draft-title="{{ $event->title }}"
                                    data-draft-studio="/event-studio/{{ $event->event_id }}/basic">
                                    {{ $event->title }} <span class="ml-1 inline-block text-sm text-amber-700"><i class="ti ti-lock"></i></span>
                                </a>
                            @else
                                <a href="/{{ $event->slug }}" class="break-words font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-base font-bold leading-snug tracking-tight text-slate-950 hover:text-blue-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">{{ $event->title }}</a>
                            @endif
                            <div class="mt-2 flex items-start gap-2 text-xs leading-5 text-slate-600 [&>i]:shrink-0 [&>i]:text-base [&>i]:text-blue-700">
                                <i class="ti ti-calendar-event"></i>
                                {{ $event->start_date?->format('d M Y') ?? 'Tanggal belum diisi' }}
                                @if ($event->end_date) · s.d. {{ $event->end_date->format('d M Y') }} @endif
                            </div>
                            <div class="mb-3 mt-3 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200">
                                <div class="min-w-0 bg-slate-50 px-2.5 py-1.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:mt-0.5 [&>strong]:block [&>strong]:break-words [&>strong]:text-sm [&>strong]:tabular-nums">
                                    <span>Peserta</span>
                                    <strong>{{ number_format($summary['participants'], 0, ',', '.') }}</strong>
                                </div>
                                <div class="min-w-0 bg-slate-50 px-2.5 py-1.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:mt-0.5 [&>strong]:block [&>strong]:break-words [&>strong]:text-sm [&>strong]:tabular-nums">
                                    <span>Tiket</span>
                                    <strong>{{ number_format($summary['tickets'], 0, ',', '.') }}</strong>
                                </div>
                                <div class="min-w-0 bg-slate-50 px-2.5 py-1.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:mt-0.5 [&>strong]:block [&>strong]:break-words [&>strong]:text-sm [&>strong]:tabular-nums col-span-2 flex flex-wrap items-baseline justify-between gap-x-2 !bg-blue-50/90 text-blue-950">
                                    <span>Dana</span>
                                    <strong>{{ $money($summary['available']) }}</strong>
                                </div>
                            </div>
                            <div class="mt-auto flex flex-wrap items-center justify-between gap-2 border-t border-dashed border-slate-200 pt-3">
                                <a href="/event-studio/{{ $event->event_id }}/basic" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e]">
                                    <i class="ti ti-edit"></i>
                                    Event Studio
                                </a>
                                <button
                                    type="button"
                                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-60 text-slate-600 hover:bg-slate-100 hover:text-slate-900"
                                    data-delete-event="{{ $event->id }}"
                                    aria-label="Hapus {{ $event->title }}">
                                    <i class="ti ti-trash"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if ($listEvent->hasPages())
                @php
                    $pagination = $listEvent->withQueryString();
                    $pageLinks = $pagination->linkCollection()->slice(1, -1);
                    $pageButton = 'inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-sm font-semibold tabular-nums focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
                    $pageLink = $pageButton . ' border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-800';
                @endphp

                <nav aria-label="Halaman event" class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700">
                    <p class="text-xs tabular-nums">
                        {{ $pagination->firstItem() }}–{{ $pagination->lastItem() }} dari {{ number_format($pagination->total(), 0, ',', '.') }} event
                    </p>
                    <div class="flex flex-wrap items-center gap-1.5">
                        @if ($pagination->previousPageUrl())
                            <a href="{{ $pagination->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="{{ $pageLink }}">
                                <i class="ti ti-chevron-left" aria-hidden="true"></i>
                            </a>
                        @endif

                        @foreach ($pageLinks as $link)
                            @if ($link['active'])
                                <span aria-current="page" class="{{ $pageButton }} bg-blue-50 text-blue-800 ring-1 ring-inset ring-blue-200">{{ $link['label'] }}</span>
                            @elseif ($link['url'])
                                <a href="{{ $link['url'] }}" aria-label="Halaman {{ $link['label'] }}" class="{{ $pageLink }}">{{ $link['label'] }}</a>
                            @else
                                <span class="px-1 text-sm text-slate-500">…</span>
                            @endif
                        @endforeach

                        @if ($pagination->nextPageUrl())
                            <a href="{{ $pagination->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="{{ $pageLink }}">
                                <i class="ti ti-chevron-right" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </nav>
            @endif
        @endif
    </div>
    {{-- Draft toast --}}
    <div id="draftNotice" class="fixed bottom-20 right-4 z-40 hidden w-[calc(100%_-_2rem)] max-w-sm rounded-2xl border border-amber-200 bg-white p-4 text-sm shadow-lg lg:bottom-5" role="status" aria-live="polite">
        <div class="flex items-start gap-3">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-amber-100 text-lg text-amber-800"><i class="ti ti-alert-triangle"></i></span>
            <div class="min-w-0 flex-1 [&>p]:mt-1 [&>p]:text-slate-600">
                <strong>Event masih draft</strong>
                <p>Selesaikan detail event di Event Studio terlebih dahulu.</p>
                <a id="draftNoticeLink" href="/dashboard/manajemen-event" class="mt-2 inline-flex items-center gap-1 font-semibold text-blue-700 hover:underline">
                    Buka Event Studio
                    <i class="ti ti-arrow-right"></i>
                </a>
            </div>
            <button type="button" id="closeDraftNotice" class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600" aria-label="Tutup notifikasi">
                <i class="ti ti-x"></i>
            </button>
        </div>
    </div>
    @push('scripts')
        <script>
            (function () {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const draftNotice = document.getElementById('draftNotice');
                const draftNoticeLink = document.getElementById('draftNoticeLink');
                let draftTimer = null;
                const hideDraftNotice = function () {
                    clearTimeout(draftTimer);
                    draftNotice.classList.add('hidden');
                };
                const showDraftNotice = function (studioUrl) {
                    draftNoticeLink.href = studioUrl || '/dashboard/manajemen-event';
                    draftNotice.classList.remove('hidden');
                    clearTimeout(draftTimer);
                    draftTimer = setTimeout(hideDraftNotice, 6000);
                };
                document.querySelectorAll('[data-draft-detail]').forEach(function (trigger) {
                    trigger.addEventListener('click', function (event) {
                        event.preventDefault();
                        showDraftNotice(trigger.dataset.draftStudio);
                    });
                });
                document.getElementById('closeDraftNotice').addEventListener('click', hideDraftNotice);
                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') hideDraftNotice();
                });
                document.querySelectorAll('[data-delete-event]').forEach(function (button) {
                    button.addEventListener('click', async function () {
                        if (!window.confirm('Hapus event ini? Event yang sudah memiliki peserta tidak dapat dihapus.')) {
                            return;
                        }
                        button.disabled = true;
                        try {
                            const response = await fetch('/event/' + encodeURIComponent(button.dataset.deleteEvent), {
                                method: 'DELETE',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                },
                            });
                            const payload = await response.json();
                            if (payload.success) {
                                window.location.reload();
                                return;
                            }
                            window.alert(payload.error || 'Gagal menghapus event.');
                        } catch (error) {
                            window.alert('Gagal menghapus event. Coba lagi.');
                        }
                        button.disabled = false;
                    });
                });
            })();
        </script>
    @endpush
@endsection