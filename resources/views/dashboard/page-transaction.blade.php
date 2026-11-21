@extends('dashboard.layouts.app')

@section('title', 'Finance & withdrawals')

@section('content')
    @php
        $money = static fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $legacyTotal = $finance->sum('legacy_count');
        $bankReady = auth()->user()->bank && auth()->user()->no_rekening;
        $totalAvailable = (float) ($totals['available_balance'] ?? 0);
        $totalWithdrawn = (float) ($totals['withdrawn'] ?? 0);
        $totalGross = (float) ($totals['gross'] ?? 0);
        $totalPending = (float) ($totals['pending_withdrawal'] ?? 0);
        $totalParticipants = (int) ($totals['participants'] ?? 0);
        $totalTickets = (int) ($totals['tickets_sold'] ?? 0);
        $totalFunds = $totalAvailable + $totalWithdrawn;
        $withdrawnPercent = $totalFunds > 0 ? min(100, round(($totalWithdrawn / $totalFunds) * 100)) : 0;
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div class="min-w-0">
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Finance &amp; Withdrawals</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-blue-100">Pantau pembayaran event, saldo tersedia, dan pengajuan penarikan.</p>
            </div>
            <a href="#financeSearch" onclick="document.getElementById('financeSearch').focus()"
               class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-white/30 bg-white/10 px-4 text-sm font-semibold text-white hover:bg-white/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-search text-lg" aria-hidden="true"></i> Cari event
            </a>
        </header>

        @if ($legacyTotal > 0)
            <div class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm leading-6 text-blue-950 [&>i]:shrink-0 [&>i]:text-lg">
                <i class="ti ti-info-circle"></i>
                <div><strong>{{ number_format($legacyTotal, 0, ',', '.') }} transaksi legacy</strong> memiliki data pembayaran tidak lengkap. Dana tetap dihitung sebagai hak organizer, tetapi tidak masuk pembayaran terverifikasi.</div>
            </div>
        @endif

        @if (!$bankReady)
            <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-950 [&>i]:shrink-0 [&>i]:text-lg">
                <i class="ti ti-alert-circle"></i>
                <div><strong>Rekening bank belum lengkap.</strong> Lengkapi bank dan nomor rekening di <a href="/dashboard/my-profile" class="font-bold underline">profil</a> sebelum mengajukan penarikan.</div>
            </div>
        @endif

        <section aria-label="Ringkasan dana" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="relative isolate grid gap-5 bg-gradient-to-br from-white via-blue-50/80 to-blue-100/70 p-5 sm:p-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:items-end">
                <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-24 -z-10 h-52 w-52 rounded-full border border-blue-200/70 shadow-[0_0_0_18px_rgba(191,219,254,0.35)]"></div>
                <div class="min-w-0">
                    <p class="flex items-center gap-2 text-sm font-medium text-blue-800"><i class="ti ti-wallet text-lg" aria-hidden="true"></i> Total saldo tersedia</p>
                    <p class="mt-2 break-words font-['Sora','Inter',sans-serif] text-2xl font-bold tracking-tight text-slate-950 tabular-nums sm:text-3xl">{{ $money($totalAvailable) }}</p>
                </div>
                <div class="min-w-0 rounded-xl border border-blue-100 bg-white/75 p-3">
                    <div class="mb-2 flex items-center justify-between gap-2 text-xs font-medium text-slate-700">
                        <span>Dana ditarik</span><span class="tabular-nums">{{ $withdrawnPercent }}%</span>
                    </div>
                    <progress value="{{ $withdrawnPercent }}" max="100" aria-label="Persentase dana ditarik"
                              class="block h-2 w-full appearance-none overflow-hidden rounded-full bg-blue-100 [&::-moz-progress-bar]:bg-blue-600 [&::-webkit-progress-bar]:bg-blue-100 [&::-webkit-progress-value]:bg-blue-600"></progress>
                </div>
            </div>

            @php
                $metrics = [
                    'Pembayaran terverifikasi' => $money($totalGross),
                    'Dana ditarik' => $money($totalWithdrawn),
                    'Penarikan diproses' => $money($totalPending),
                    'Peserta' => number_format($totalParticipants, 0, ',', '.'),
                    'Tiket terjual' => number_format($totalTickets, 0, ',', '.'),
                ];
            @endphp

            <dl class="grid grid-cols-2 gap-px border-t border-slate-200 bg-slate-200 lg:grid-cols-5">
                @foreach ($metrics as $label => $value)
                    <div class="min-w-0 bg-white px-4 py-3.5 last:col-span-2 lg:last:col-span-1">
                        <dt class="text-xs leading-5 text-slate-600">{{ $label }}</dt>
                        <dd class="mt-0.5 break-words text-sm font-semibold text-slate-950 tabular-nums sm:text-base">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>

        <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <div class="grid grid-cols-[minmax(0,1fr)_auto] items-start gap-2 sm:items-center sm:gap-3">
                <form method="GET" action="" class="flex min-w-0 flex-wrap items-center gap-2">
                    <div class="flex min-h-11 min-w-[8rem] flex-[1_1_8rem] items-center gap-2 rounded-xl border border-slate-200 px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100">
                        <i class="ti ti-search"></i>
                        <input id="financeSearch" type="search" name="key" value="{{ request('key') }}" aria-label="Cari event" class="min-w-0 flex-1 bg-transparent text-sm outline-none placeholder:text-slate-500" placeholder="Cari event…">
                    </div>
                    <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Cari</button>
                    @if (request('key'))
                        <a href="/dashboard/transaction-report" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Reset</a>
                    @endif
                </form>
                <span class="mt-2 inline-flex whitespace-nowrap rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold tabular-nums text-slate-600 sm:mt-0">{{ number_format($listEvent->total(), 0, ',', '.') }} event</span>
            </div>
        </div>

        @if ($listEvent->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white">
                <div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950">
                    <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-file-dollar"></i></span>
                    @if (request('key'))
                        <strong>Event tidak ditemukan</strong>
                        <p>Coba kata kunci lain atau tampilkan semua event.</p>
                        <a href="/dashboard/transaction-report" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 mt-3">Tampilkan semua event</a>
                    @else
                        <strong>Belum ada event</strong>
                        <p>Buat event terlebih dahulu untuk melihat laporan keuangan.</p>
                        <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] mt-3" data-create-event><i class="ti ti-plus"></i> Buat event</button>
                    @endif
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 2xl:grid-cols-3">
                @foreach ($listEvent as $event)
                    @php
                        $summary = $finance[$event->id];
                        $funds = (float) $summary['available'] + (float) $summary['withdrawn'];
                        $percent = $funds > 0 ? min(100, round(((float) $summary['withdrawn'] / $funds) * 100)) : 0;
                    @endphp
                    <article class="relative flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-colors hover:border-blue-200">
                        <span class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#2282ff] via-sky-400 to-blue-200"></span>
                        <div class="flex min-w-0 flex-1 flex-col p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <a href="/event-studio/{{ $event->event_id }}/basic" class="block break-words text-base font-semibold leading-snug tracking-tight text-slate-950 hover:text-blue-700 hover:underline">{{ $event->title }}</a>
                                    <div class="mt-1 text-xs leading-5 text-slate-600">{{ $event->start_date?->format('d M Y') ?? 'Tanggal belum diisi' }}@if ($event->end_date) · s.d. {{ $event->end_date->format('d M Y') }}@endif</div>
                                </div>
                                <span class="inline-flex shrink-0 rounded-full px-2 py-1 text-xs font-semibold {{ $event->event_status === 'published' ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-900' }}">{{ match ($event->event_status) { 'draft' => 'Draf', 'published' => 'Terbit', default => $event->event_status } }}</span>
                            </div>

                            <div class="mt-3 flex flex-wrap items-end justify-between gap-2 rounded-xl border border-blue-100 bg-blue-50/70 p-3">
                                <div>
                                    <div class="text-xs font-medium text-blue-800">Dana tersedia</div>
                                    <div class="mt-1 break-words text-lg font-bold tracking-tight text-blue-950 tabular-nums">{{ $money($summary['available']) }}</div>
                                </div>
                                <span class="rounded-lg bg-white px-2 py-1 text-xs font-medium text-slate-700 shadow-sm">Hak {{ $money($summary['total']) }}</span>
                            </div>

                            <div class="mt-3">
                                <div class="mb-1 flex justify-between text-xs text-slate-600"><span>Ditarik</span><span>{{ $percent }}%</span></div>
                                <progress value="{{ $percent }}" max="100" aria-label="Persentase dana ditarik untuk event ini" class="block h-1.5 w-full appearance-none overflow-hidden rounded-full bg-blue-100 [&::-moz-progress-bar]:bg-blue-600 [&::-webkit-progress-bar]:bg-blue-100 [&::-webkit-progress-value]:bg-blue-600"></progress>
                            </div>

                            <div class="mb-3 mt-3 grid grid-cols-2 gap-2">
                                <div class="rounded-lg bg-[#f8fbff] px-2.5 py-2"><span class="block text-xs text-slate-600">Peserta</span><strong class="mt-0.5 block break-words text-sm text-slate-950 tabular-nums">{{ number_format($summary['participants'], 0, ',', '.') }}</strong></div>
                                <div class="rounded-lg bg-[#f8fbff] px-2.5 py-2"><span class="block text-xs text-slate-600">Tiket</span><strong class="mt-0.5 block break-words text-sm text-slate-950 tabular-nums">{{ number_format($summary['tickets'], 0, ',', '.') }}</strong></div>
                                <div class="rounded-lg bg-[#f8fbff] px-2.5 py-2"><span class="block text-xs text-slate-600">Ditarik</span><strong class="mt-0.5 block break-words text-sm text-slate-950 tabular-nums">{{ $money($summary['withdrawn']) }}</strong></div>
                                <div class="rounded-lg bg-[#f8fbff] px-2.5 py-2"><span class="block text-xs text-slate-600">Pending</span><strong class="mt-0.5 block break-words text-sm text-slate-950 tabular-nums">{{ $money($summary['pending_withdrawal']) }}</strong></div>
                            </div>

                            <div class="mt-auto flex flex-wrap gap-1.5 border-t border-slate-200 pt-3">
                                <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 finance-detail" data-event-id="{{ $event->id }}" data-event-title="{{ $event->title }}"><i class="ti ti-chart-pie"></i> Detail</button>
                                <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 finance-history" data-event-id="{{ $event->id }}" data-event-title="{{ $event->title }}"><i class="ti ti-history"></i> Riwayat</button>
                                <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] finance-withdraw" data-event-id="{{ $event->id }}" data-event-title="{{ $event->title }}" @disabled(!$bankReady)><i class="ti ti-cash-banknote-move"></i> Tarik dana</button>
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

    <dialog id="financeDrawer" aria-labelledby="financeDrawerTitle"
            class="fixed inset-y-0 left-auto right-0 m-0 h-dvh max-h-none w-full max-w-lg overflow-y-auto overscroll-contain border-0 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white px-5 py-4">
            <div class="min-w-0">
                <h2 id="financeDrawerTitle" class="text-lg font-semibold tracking-tight">Detail keuangan</h2>
                <p id="financeDrawerSub" class="mt-1 break-words text-sm text-slate-600">Ringkasan dana event.</p>
            </div>
            <form method="dialog">
                <button type="submit" id="closeFinanceDrawer" aria-label="Tutup" autofocus class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-50">
                    <i class="ti ti-x" aria-hidden="true"></i>
                </button>
            </form>
        </div>
        <div id="financeDrawerBody" class="space-y-4 p-5"></div>
    </dialog>

    @push('scripts')
        <script>
            (function () {
                const drawer = document.getElementById('financeDrawer');
                const title = document.getElementById('financeDrawerTitle');
                const subtitle = document.getElementById('financeDrawerSub');
                const body = document.getElementById('financeDrawerBody');
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const bankReady = @json((bool) $bankReady);
                const bankLabel = @json(trim((string) auth()->user()->bank . ' ' . (string) auth()->user()->no_rekening));
                const closeButton = document.getElementById('closeFinanceDrawer');
                let drawerVersion = 0;
                let submitting = false;

                const esc = function (value) {
                    const div = document.createElement('div');
                    div.textContent = value == null ? '' : String(value);
                    return div.innerHTML;
                };
                const money = (value) => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

                const open = function (heading, sub) {
                    title.textContent = heading;
                    subtitle.textContent = sub || '';
                    if (!drawer.open) drawer.showModal();
                    return ++drawerVersion;
                };
                const isCurrent = (version) => drawer.open && version === drawerVersion;

                const loading = function () {
                    body.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-loader-2 animate-spin"></i></span><strong>Memuat data...</strong></div>';
                };

                const getReport = async function (eventId) {
                    const response = await fetch('/dashboard/get-transaction-report?' + new URLSearchParams({ event_id: eventId }).toString(), {
                        headers: { 'Accept': 'application/json' },
                    });
                    if (!response.ok) throw new Error('failed');
                    const payload = await response.json();
                    return payload.data || {};
                };

                const detail = async function (eventId, eventTitle) {
                    loading();
                    const version = open('Detail keuangan', eventTitle);
                    try {
                        const data = await getReport(eventId);
                        if (!isCurrent(version)) return;
                        body.innerHTML = `
                            <div class="rounded-xl border border-slate-200 bg-white p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold">
                                <h4>Ringkasan</h4>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Peserta</span><strong>${esc(data.peserta)}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Tiket</span><strong>${esc(data.tiket)}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Pembayaran masuk</span><strong>${money(data.danaTotal)}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Admin fee</span><strong>${money(data.fee)}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Penarikan</span><strong>${money(data.danaDitarik)}</strong></div>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl bg-blue-50 p-4 text-sm text-blue-950">
                                <span>Saldo tersedia</span>
                                <strong>${money(data.danaBersih)}</strong>
                            </div>
                        `;
                    } catch (error) {
                        if (!isCurrent(version)) return;
                        body.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><strong>Gagal memuat laporan</strong><p>Coba lagi.</p></div>';
                    }
                };

                const history = async function (eventId, eventTitle) {
                    loading();
                    const version = open('Riwayat penarikan', eventTitle);
                    try {
                        const response = await fetch('/dashboard/withdraw-history?' + new URLSearchParams({ id: eventId }).toString(), {
                            headers: { 'Accept': 'application/json' },
                        });
                        if (!response.ok) throw new Error('failed');
                        const payload = await response.json();
                        if (!isCurrent(version)) return;
                        const rows = payload.data || [];
                        body.innerHTML = rows.length
                            ? `<div class="overflow-x-auto rounded-xl border border-slate-200"><table class="w-full text-left text-sm [&_th]:bg-slate-50 [&_th]:p-3 [&_td]:border-t [&_td]:border-slate-100 [&_td]:p-3"><thead><tr><th>Jumlah</th><th>Tanggal</th><th>Status</th></tr></thead><tbody>${rows.map((row) => `<tr><td class="font-semibold tabular-nums">${esc(row.wd)}</td><td>${esc(row.tanggal)}</td><td><span class="inline-flex shrink-0 rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">${esc(row.status)}</span></td></tr>`).join('')}</tbody></table></div>`
                            : '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><strong>Belum ada penarikan</strong><p>Riwayat muncul setelah ada pengajuan.</p></div>';
                    } catch (error) {
                        if (!isCurrent(version)) return;
                        body.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><strong>Gagal memuat riwayat</strong><p>Coba lagi.</p></div>';
                    }
                };

                const withdraw = async function (eventId, eventTitle) {
                    if (!bankReady) {
                        window.alert('Lengkapi data rekening bank terlebih dahulu.');
                        return;
                    }

                    loading();
                    const version = open('Tarik dana', eventTitle);

                    try {
                        const data = await getReport(eventId);
                        if (!isCurrent(version)) return;
                        const available = Number(data.danaBersih || 0);

                        body.innerHTML = `
                            <div class="rounded-xl border border-slate-200 bg-white p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold">
                                <h4>Rekening tujuan</h4>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Bank</span><strong>${esc(bankLabel || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Saldo tersedia</span><strong>${money(available)}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Minimum</span><strong>${money(10000)}</strong></div>
                            </div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="withdrawAmount">Jumlah penarikan</label>
                            <input id="withdrawAmount" class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:opacity-50" type="text" inputmode="numeric" placeholder="Rp 0">
                            <div id="withdrawError" role="alert" class="mt-2 hidden rounded-lg bg-rose-50 px-3 py-2 text-sm font-medium text-rose-800"></div>
                            <button id="submitWithdraw" type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] mt-3 w-full justify-center">
                                <i class="ti ti-cash-banknote-move"></i> Ajukan penarikan
                            </button>
                        `;

                        const input = document.getElementById('withdrawAmount');
                        const error = document.getElementById('withdrawError');
                        const submit = document.getElementById('submitWithdraw');

                        input.addEventListener('input', function () {
                            const digits = input.value.replace(/\D/g, '');
                            input.value = digits ? Number(digits).toLocaleString('id-ID') : '';
                        });

                        submit.addEventListener('click', async function () {
                            const amount = Number(input.value.replace(/\D/g, ''));
                            error.classList.add('hidden');

                            if (!Number.isInteger(amount) || amount < 10000) {
                                error.textContent = 'Minimum penarikan Rp 10.000.';
                                error.classList.remove('hidden');
                                return;
                            }
                            if (amount > available) {
                                error.textContent = 'Jumlah melebihi saldo tersedia.';
                                error.classList.remove('hidden');
                                return;
                            }

                            if (submitting) return;
                            submitting = true;
                            submit.disabled = true;
                            input.disabled = true;
                            closeButton.disabled = true;
                            try {
                                const response = await fetch('/dashboard/withdraw-process', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                    },
                                    body: new URLSearchParams({ event_id: eventId, wdAmount: amount }),
                                });
                                const payload = await response.json();
                                if (payload.success) {
                                    submitting = false;
                                    closeButton.disabled = false;
                                    body.innerHTML = `<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-circle-check"></i></span><strong>Penarikan diajukan</strong><p>Saldo tersedia sekarang ${money(payload.saldo)}.</p><button type="button" id="reloadAfterWithdraw" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] mt-3">Muat ulang halaman</button></div>`;
                                    document.getElementById('reloadAfterWithdraw').addEventListener('click', () => window.location.reload());
                                    return;
                                }
                                error.textContent = payload.error || payload.message || 'Gagal mengajukan penarikan.';
                                error.classList.remove('hidden');
                            } catch (err) {
                                error.textContent = 'Gagal mengajukan penarikan.';
                                error.classList.remove('hidden');
                            }
                            submitting = false;
                            submit.disabled = false;
                            input.disabled = false;
                            closeButton.disabled = false;
                        });
                    } catch (error) {
                        if (!isCurrent(version)) return;
                        body.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><strong>Gagal memuat saldo</strong><p>Coba lagi.</p></div>';
                    }
                };

                document.querySelectorAll('.finance-detail').forEach((button) => {
                    button.addEventListener('click', () => detail(button.dataset.eventId, button.dataset.eventTitle));
                });
                document.querySelectorAll('.finance-history').forEach((button) => {
                    button.addEventListener('click', () => history(button.dataset.eventId, button.dataset.eventTitle));
                });
                document.querySelectorAll('.finance-withdraw').forEach((button) => {
                    button.addEventListener('click', () => withdraw(button.dataset.eventId, button.dataset.eventTitle));
                });

                closeButton.form.addEventListener('submit', (event) => {
                    if (submitting) event.preventDefault();
                });
                drawer.addEventListener('cancel', (event) => {
                    if (submitting) event.preventDefault();
                });
                drawer.addEventListener('click', (event) => {
                    if (submitting || event.target !== drawer) return;
                    const bounds = drawer.getBoundingClientRect();
                    if (event.clientX < bounds.left || event.clientX > bounds.right
                        || event.clientY < bounds.top || event.clientY > bounds.bottom) drawer.close();
                });
            })();
        </script>
    @endpush
@endsection
