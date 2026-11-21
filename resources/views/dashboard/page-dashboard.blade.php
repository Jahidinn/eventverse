@extends('dashboard.layouts.app')

@section('title', 'Overview')

@section('content')
    @php
        $money = static fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $trendTotal = array_sum($overview['trend']['values']);
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-6 text-slate-900">
        <header class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-[#102657] to-[#123c89] px-5 py-8 text-white shadow-lg shadow-blue-950/10 sm:px-8 sm:py-10">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[radial-gradient(circle_at_center,_rgba(147,197,253,0.5)_1px,_transparent_1px)] [background-size:14px_14px] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-24 -z-10 hidden h-64 w-64 rotate-[-18deg] rounded-[3rem] border border-blue-200/20 shadow-[0_0_0_22px_rgba(147,197,253,0.07),0_0_0_44px_rgba(147,197,253,0.05)] sm:block"></div>
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-blue-200">Halo, {{ auth()->user()->name }}</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-5xl">Overview</h1>
                    <p class="mt-2 max-w-lg text-sm leading-6 text-slate-200">Ringkasan event, peserta, dan dana di akunmu.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="/dashboard/manajemen-event" class="inline-flex min-h-11 items-center rounded-xl border border-white/30 px-4 text-sm font-semibold text-white transition hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Kelola event</a>
                    <button type="button" data-create-event class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-[#2282ff] px-4 text-sm font-bold text-slate-950 shadow-lg shadow-blue-950/20 transition hover:bg-blue-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                        <i class="ti ti-plus text-lg" aria-hidden="true"></i>
                        {{ $overview['events_total'] === 0 ? 'Buat event pertama' : 'Buat event' }}
                    </button>
                </div>
            </div>
        </header>

        @if ($overview['legacy_count'] > 0)
            <div class="flex gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-950 [&>i]:mt-0.5 [&>i]:text-lg">
                <i class="ti ti-info-circle"></i>
                <div>
                    <strong>{{ number_format($overview['legacy_count'], 0, ',', '.') }} transaksi lama</strong>
                    belum memiliki data pembayaran lengkap.
                    Nilai {{ $money($overview['legacy_amount']) }} tetap ditampilkan sebagai hak organizer,
                    tetapi tidak dimasukkan ke pembayaran terverifikasi atau grafik revenue.
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard.kpi
                label="Event"
                :value="number_format($overview['events_total'], 0, ',', '.')"
                :sub="$overview['events_published'] . ' published · ' . $overview['events_draft'] . ' draft'"
                icon="ti-calendar-event"
            />

            <x-dashboard.kpi
                label="Peserta"
                :value="number_format($overview['participants'], 0, ',', '.')"
                :sub="$overview['participants'] > 0 ? number_format($overview['checked_in'], 0, ',', '.') . ' check-in · ' . $overview['checkin_rate'] . '%' : 'Belum ada peserta'"
                icon="ti-users"
                tone="is-violet"
            />

            <x-dashboard.kpi
                label="Tiket terjual"
                :value="number_format($overview['tickets_sold'], 0, ',', '.')"
                :sub="$overview['paid_count'] . ' transaksi Paid'"
                icon="ti-ticket"
                tone="is-cyan"
            />

            <x-dashboard.kpi
                label="Saldo tersedia"
                :value="$money($overview['available_balance'])"
                sub="Hak organizer dikurangi penarikan"
                icon="ti-cash-banknote"
                tone="is-green"
                :money="true"
                :featured="true"
            />
        </div>

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)]">
            <x-card>
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold tracking-tight text-slate-950">Revenue trend</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Pembayaran terverifikasi, 6 bulan terakhir.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold tabular-nums text-blue-800">{{ $money($trendTotal) }} / 6 bln</span>
                        <a href="/dashboard/transaction-report" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">Lihat transaksi</a>
                    </div>
                </div>
                <div class="p-5 sm:p-6">
                    @if ($trendTotal > 0)
                        <div class="relative h-64 min-w-0 sm:h-72">
                            <canvas id="organizerRevenueChart" role="img" aria-label="Grafik pembayaran terverifikasi dalam enam bulan terakhir"></canvas>
                        </div>
                    @else
                        <div class="flex min-h-36 flex-col items-center justify-center gap-2 px-5 py-8 text-center text-sm text-slate-600 [&>strong]:text-base [&>strong]:text-slate-900">
                            <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-chart-line"></i></span>
                            <strong>Belum ada revenue terverifikasi</strong>
                            <p>Grafik akan muncul setelah ada pembayaran dengan data yang lengkap.</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <x-card>
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold tracking-tight text-slate-950">Posisi dana</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Ringkasan hak organizer dan penarikan.</p>
                    </div>
                </div>
                <div class="p-5 sm:p-6">
                    <div class="divide-y divide-slate-100">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:text-slate-900">
                            <span>Pembayaran terverifikasi</span>
                            <strong>{{ $money($overview['gross']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:text-slate-900">
                            <span>Platform fee</span>
                            <strong>{{ $money($overview['platform_fee']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:text-slate-900">
                            <span>Gateway fee (estimasi)</span>
                            <strong>{{ $money($overview['gateway_fee']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:text-slate-900">
                            <span>Hak organizer</span>
                            <strong>{{ $money($overview['organizer_net']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:text-slate-900">
                            <span>Sudah / sedang ditarik</span>
                            <strong>{{ $money($overview['withdrawn']) }}</strong>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-amber-950">Penarikan diproses</p>
                            <p class="mt-0.5 text-xs text-amber-900">{{ number_format($overview['pending_withdrawal_count'], 0, ',', '.') }} permintaan menunggu</p>
                        </div>
                        <strong class="break-words text-sm tabular-nums text-amber-950">{{ $money($overview['pending_withdrawal']) }}</strong>
                    </div>

                    <a href="/dashboard/transaction-report" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 mt-3 w-full justify-center">
                        Kelola penarikan
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </x-card>
        </div>

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(0,1fr)]">
            <x-card>
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold tracking-tight text-slate-950">Event performa terbaik</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Berdasarkan hak organizer dari transaksi Paid.</p>
                    </div>
                    <a href="/dashboard/manajemen-event" class="text-sm font-semibold text-blue-700 hover:underline">
                        Semua event
                    </a>
                </div>

                @if ($overview['top_events']->isEmpty())
                    <div class="flex min-h-36 flex-col items-center justify-center gap-2 px-5 py-8 text-center text-sm text-slate-600 [&>strong]:text-base [&>strong]:text-slate-900">
                        <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-chart-bar"></i></span>
                        <strong>Belum ada performa event</strong>
                        <p>Data akan muncul setelah event memiliki transaksi Paid.</p>
                    </div>
                @else
                    <div class="p-0">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[34rem] text-left text-sm [&_td]:border-t [&_td]:border-slate-100 [&_td]:px-4 [&_td]:py-3 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:font-medium [&_th]:text-slate-600 [&_tbody_tr:hover]:bg-blue-50/40">
                                <thead>
                                    <tr>
                                        <th scope="col">Event</th>
                                        <th scope="col">Tiket</th>
                                        <th scope="col">Transaksi</th>
                                        <th scope="col" class="text-right">Hak organizer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($overview['top_events'] as $event)
                                        <tr>
                                            <td>
                                                <div class="flex min-w-0 items-center gap-3">
                                                    <span class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-lg bg-slate-100 text-lg text-slate-500 [&>img]:h-full [&>img]:w-full [&>img]:object-cover">
                                                        @if ($event['image'] && file_exists(public_path('storage/event-images/' . $event['image'])))
                                                            <img src="{{ asset('storage/event-images/' . $event['image']) }}" alt="">
                                                        @else
                                                            <i class="ti ti-calendar-event"></i>
                                                        @endif
                                                    </span>
                                                    <span class="min-w-0">
                                                        <a href="/event-studio/{{ $event['event_id'] }}/basic" class="block break-words font-semibold text-slate-900 hover:text-blue-700 hover:underline">
                                                            {{ $event['title'] }}
                                                        </a>
                                                        <span class="block text-xs text-slate-600">{{ $event['paid_count'] }} pembayaran</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="font-semibold text-slate-900">{{ number_format($event['tickets'], 0, ',', '.') }}</td>
                                            <td class="whitespace-nowrap text-slate-600">{{ number_format($event['paid_count'], 0, ',', '.') }}</td>
                                            <td class="text-right whitespace-nowrap font-semibold tabular-nums text-slate-900">{{ $money($event['net']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </x-card>

            <x-card>
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold tracking-tight text-slate-950">Event mendatang</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Event published yang belum selesai.</p>
                    </div>
                </div>

                @if ($overview['upcoming_events']->isEmpty())
                    <div class="flex min-h-36 flex-col items-center justify-center gap-2 px-5 py-8 text-center text-sm text-slate-600 [&>strong]:text-base [&>strong]:text-slate-900">
                        <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-calendar-check"></i></span>
                        <strong>Tidak ada event mendatang</strong>
                        <p>Event published akan tampil di sini.</p>
                    </div>
                @else
                    <div class="p-5 sm:p-6">
                        <div class="divide-y divide-slate-100">
                            @foreach ($overview['upcoming_events'] as $event)
                                <div class="flex flex-wrap items-center gap-3 py-3 first:pt-0 last:pb-0">
                                    <span class="flex w-12 shrink-0 flex-col items-center rounded-xl border border-blue-100 bg-blue-50 py-2 text-xs text-blue-800 [&>strong]:text-lg [&>strong]:leading-5">
                                        <strong>{{ $event->start_date?->format('d') ?? '—' }}</strong>
                                        <span>{{ $event->start_date?->format('M') ?? '—' }}</span>
                                    </span>
                                    <span class="min-w-[8rem] flex-1 text-sm text-slate-600 [&>span]:mt-0.5 [&>span]:block [&>span]:text-xs [&>strong]:block [&>strong]:break-words [&>strong]:text-slate-900">
                                        <strong>{{ $event->title }}</strong>
                                        <span>
                                            {{ $event->start_date?->format('d M Y') ?? 'Tanggal belum diisi' }}
                                            @if ($event->end_date)
                                                · s.d. {{ $event->end_date->format('d M Y') }}
                                            @endif
                                        </span>
                                    </span>
                                    <a href="/event-studio/{{ $event->event_id }}/basic" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                        Kelola
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </x-card>
        </div>

        <x-card>
            <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-base font-semibold tracking-tight text-slate-950">Transaksi terbaru</h2>
                    <p class="mt-1 text-sm leading-5 text-slate-600">Pembayaran terbaru dari event yang kamu kelola.</p>
                </div>
                <a href="/dashboard/transaction-report" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">Lihat semua</a>
            </div>

            @if ($overview['recent_payments']->isEmpty())
                <div class="flex min-h-36 flex-col items-center justify-center gap-2 px-5 py-8 text-center text-sm text-slate-600 [&>strong]:text-base [&>strong]:text-slate-900">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-receipt-off"></i></span>
                    <strong>Belum ada transaksi</strong>
                    <p>Transaksi akan tampil setelah peserta melakukan pembayaran.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[40rem] text-left text-sm [&_td]:border-t [&_td]:border-slate-100 [&_td]:px-4 [&_td]:py-3 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:font-medium [&_th]:text-slate-600 [&_tbody_tr:hover]:bg-blue-50/40">
                        <thead>
                            <tr>
                                <th scope="col">Transaksi</th>
                                <th scope="col">Event</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($overview['recent_payments'] as $payment)
                                <tr>
                                    <td>
                                        <span class="font-semibold text-slate-900">{{ $payment->transaction_code }}</span>
                                        <span class="block text-xs text-slate-600">{{ $payment->buyer_name }}</span>
                                    </td>
                                    <td class="max-w-[220px] truncate">{{ $payment->event?->title ?? '—' }}</td>
                                    <td class="whitespace-nowrap text-slate-600">{{ $payment->created_at?->format('d M Y') ?? '—' }}</td>
                                    <td>
                                        <span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold {{ $payment->status === 'Paid' ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $payment->status }}
                                        </span>
                                    </td>
                                    <td class="text-right whitespace-nowrap font-semibold tabular-nums text-slate-900">{{ $money($payment->grand_total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>

    </div>

    @if ($trendTotal > 0)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
            <script>
                (function () {
                    const canvas = document.getElementById('organizerRevenueChart');

                    if (!canvas || typeof Chart === 'undefined') {
                        return;
                    }

                    const labels = @json($overview['trend']['labels']);
                    const values = @json($overview['trend']['values']);
                    const context = canvas.getContext('2d');
                    const gradient = context.createLinearGradient(0, 0, 0, 230);
                    gradient.addColorStop(0, 'rgba(34, 130, 255, 0.24)');
                    gradient.addColorStop(1, 'rgba(34, 130, 255, 0.01)');

                    new Chart(context, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Pembayaran terverifikasi',
                                data: values,
                                borderColor: '#2282ff',
                                backgroundColor: gradient,
                                borderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 4,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#2282ff',
                                pointBorderWidth: 2,
                                fill: true,
                                lineTension: 0.38,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            hover: {
                                intersect: false,
                                mode: 'index',
                            },
                            legend: {
                                display: false,
                            },
                            tooltips: {
                                backgroundColor: '#0f172a',
                                padding: 9,
                                cornerRadius: 8,
                                titleFontFamily: 'Inter',
                                titleFontSize: 10,
                                bodyFontFamily: 'Inter',
                                bodyFontSize: 11,
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return 'Rp ' + Number(tooltipItem.yLabel || 0).toLocaleString('id-ID');
                                    },
                                },
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: { display: false, drawBorder: false },
                                    ticks: {
                                        fontFamily: 'Inter',
                                        fontSize: 9,
                                        fontColor: '#94a3b8',
                                    },
                                }],
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontFamily: 'Inter',
                                        fontSize: 9,
                                        fontColor: '#94a3b8',
                                        callback: function (value) {
                                            return 'Rp ' + Number(value).toLocaleString('id-ID');
                                        },
                                    },
                                    gridLines: {
                                        color: '#f1f5f9',
                                        drawBorder: false,
                                        zeroLineColor: '#f1f5f9',
                                    },
                                }],
                            },
                        },
                    });
                })();
            </script>
        @endpush
    @endif
@endsection
