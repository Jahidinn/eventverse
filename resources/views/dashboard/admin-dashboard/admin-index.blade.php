@extends('dashboard.layouts.app')

@section('title', 'Platform overview')

@section('content')
    @php
        $money = static fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $trendTotal = array_sum($overview['trend']['values']);
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-5 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Overview Admin</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-blue-100">Pantau pembayaran platform, kewajiban organizer, dan aktivitas event.</p>
            </div>
            <a href="/administrator/payments" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-receipt-2" aria-hidden="true"></i> Monitor pembayaran
            </a>
        </header>

        @if ($overview['legacy_count'] > 0)
            <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-950 [&>i]:shrink-0 [&>i]:text-lg">
                <i class="ti ti-info-circle"></i>
                <div>
                    <strong>{{ number_format($overview['legacy_count'], 0, ',', '.') }} transaksi Paid lama</strong>
                    memiliki data pembayaran yang belum lengkap.
                    Nilai {{ $money($overview['legacy_amount']) }} ditampilkan sebagai data legacy,
                    tetapi tidak dihitung ke gross, platform revenue, atau grafik.
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard.kpi
                label="Gross pembayaran"
                :value="$money($overview['gross'])"
                :sub="number_format($overview['transactions_paid'], 0, ',', '.') . ' transaksi berstatus Paid'"
                icon="ti-receipt-2"
                tone="is-sky"
                :money="true"
            />
            <x-dashboard.kpi
                label="Pendapatan platform"
                :value="$money($overview['platform_fee'])"
                sub="Platform fee terverifikasi"
                icon="ti-building-bank"
                tone="is-green"
                :money="true"
                :featured="true"
            />
            <x-dashboard.kpi
                label="Pengguna"
                :value="number_format($overview['users'], 0, ',', '.')"
                :sub="number_format($overview['organizers'], 0, ',', '.') . ' organizer'"
                icon="ti-user-circle"
                tone="is-violet"
            />
            <x-dashboard.kpi
                label="Event"
                :value="number_format($overview['events_total'], 0, ',', '.')"
                :sub="number_format($overview['events_published'], 0, ',', '.') . ' terbit · ' . number_format($overview['events_active'], 0, ',', '.') . ' aktif'"
                icon="ti-calendar-event"
                tone="is-cyan"
            />
        </div>

        <dl class="grid grid-cols-1 gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200 sm:grid-cols-3">
            <div class="flex flex-wrap items-center justify-between gap-2 bg-white px-4 py-3">
                <dt class="text-sm text-slate-600">Peserta</dt><dd class="font-semibold tabular-nums">{{ number_format($overview['participants'], 0, ',', '.') }}</dd>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2 bg-white px-4 py-3">
                <dt class="text-sm text-slate-600">Sudah check-in</dt><dd class="font-semibold tabular-nums">{{ number_format($overview['checked_in'], 0, ',', '.') }}</dd>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2 bg-white px-4 py-3">
                <dt class="text-sm text-slate-600">Tiket terjual</dt><dd class="font-semibold tabular-nums">{{ number_format($overview['tickets_sold'], 0, ',', '.') }}</dd>
            </div>
        </dl>

        <div class="grid gap-4 xl:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)]">
            <x-card class="overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-5">
                    <div>
                        <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Tren pembayaran terverifikasi</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Nilai bruto pembayaran selama enam bulan terakhir.</p>
                    </div>
                    <a href="/administrator/payments" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                        Detail pembayaran
                    </a>
                </div>
                <div class="p-4 sm:p-5">
                    @if ($trendTotal > 0)
                        <div class="relative h-64 min-w-0 sm:h-72">
                            <canvas id="adminRevenueChart" role="img" aria-label="Grafik nilai bruto pembayaran terverifikasi enam bulan terakhir"></canvas>
                        </div>
                    @else
                        <div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950">
                            <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-chart-line"></i></span>
                            <strong>Belum ada pembayaran terverifikasi</strong>
                            <p>Grafik akan muncul setelah ada pembayaran dengan data lengkap.</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <x-card class="overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-5">
                    <div>
                        <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Perlu perhatian</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Antrean penarikan dan status transaksi platform.</p>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <div class="space-y-2">
                        <a href="/administrator/wd-request" class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2.5 hover:border-blue-200 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                            <span class="min-w-0 [&>span]:mt-0.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:block [&>strong]:text-sm [&>strong]:font-semibold">
                                <strong>Penarikan menunggu verifikasi</strong>
                                <span>{{ $money($overview['pending_withdrawal']) }}</span>
                            </span>
                            <span class="shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-sm font-semibold tabular-nums text-blue-800">{{ $overview['pending_withdrawal_count'] }}</span>
                        </a>

                        <a href="/administrator/payments" class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2.5 hover:border-blue-200 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                            <span class="min-w-0 [&>span]:mt-0.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:block [&>strong]:text-sm [&>strong]:font-semibold">
                                <strong>Transaksi pending</strong>
                                <span>Belum menerima pembayaran</span>
                            </span>
                            <span class="shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-sm font-semibold tabular-nums text-blue-800">{{ $overview['transactions_pending'] }}</span>
                        </a>

                        <a href="/administrator/payments" class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2.5 hover:border-blue-200 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                            <span class="min-w-0 [&>span]:mt-0.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:block [&>strong]:text-sm [&>strong]:font-semibold">
                                <strong>Transaksi expired</strong>
                                <span>Perlu pemantauan status</span>
                            </span>
                            <span class="shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-sm font-semibold tabular-nums text-blue-800">{{ $overview['transactions_expired'] }}</span>
                        </a>

                        <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2.5">
                            <span class="min-w-0 [&>span]:mt-0.5 [&>span]:block [&>span]:text-xs [&>span]:text-slate-600 [&>strong]:block [&>strong]:text-sm [&>strong]:font-semibold">
                                <strong>Data sandbox</strong>
                                <span>Environment terpisah dari production</span>
                            </span>
                            <span class="shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-sm font-semibold tabular-nums text-blue-800">{{ $overview['sandbox_count'] }}</span>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="grid gap-4 xl:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)]">
            <x-card class="overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-5">
                    <div>
                        <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Event dengan hak organizer tertinggi</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Berdasarkan hak organizer dari transaksi Paid.</p>
                    </div>
                    <a href="/administrator/event-management/selected" class="text-sm font-semibold text-blue-700 hover:underline">
                        Kelola event
                    </a>
                </div>

                @if ($overview['top_events']->isEmpty())
                    <div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950">
                        <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-chart-bar"></i></span>
                        <strong>Belum ada data performa</strong>
                        <p>Event akan muncul setelah memiliki transaksi Paid.</p>
                    </div>
                @else
                    <div class="min-w-0">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[34rem] text-left text-sm [&_td]:border-t [&_td]:border-slate-100 [&_td]:px-4 [&_td]:py-3 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:font-semibold [&_th]:text-slate-600 [&_tbody_tr:hover]:bg-blue-50/40">
                                <thead>
                                    <tr>
                                        <th scope="col">Event</th>
                                        <th scope="col">Tiket</th>
                                        <th scope="col" class="text-right">Hak organizer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($overview['top_events'] as $event)
                                        <tr>
                                            <td>
                                                <div class="flex min-w-0 items-center gap-3">
                                                    <span class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-lg bg-blue-50 text-blue-700 [&>img]:h-full [&>img]:w-full [&>img]:object-cover">
                                                        @if ($event['image'] && file_exists(public_path('storage/event-images/' . $event['image'])))
                                                            <img src="{{ asset('storage/event-images/' . $event['image']) }}" alt="">
                                                        @else
                                                            <i class="ti ti-calendar-event"></i>
                                                        @endif
                                                    </span>
                                                    <span class="min-w-0">
                                                        <a href="/{{ $event['slug'] }}" class="block break-words font-semibold text-slate-900 hover:text-blue-700 hover:underline">
                                                            {{ $event['title'] }}
                                                        </a>
                                                        <span class="block text-xs text-slate-600">{{ $event['paid_count'] }} pembayaran</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="font-semibold text-slate-900">{{ number_format($event['tickets'], 0, ',', '.') }}</td>
                                            <td class="text-right whitespace-nowrap font-semibold tabular-nums text-slate-900">{{ $money($event['net']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </x-card>

            <x-card class="overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-5">
                    <div>
                        <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Posisi dana</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Biaya pembayaran, kewajiban organizer, dan penarikan selesai.</p>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <div class="divide-y divide-slate-100">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:tabular-nums [&>strong]:text-slate-950">
                            <span>Gateway fee (estimasi)</span>
                            <strong>{{ $money($overview['gateway_fee']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:tabular-nums [&>strong]:text-slate-950">
                            <span>Kewajiban kepada organizer</span>
                            <strong>{{ $money($overview['organizer_liability']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:tabular-nums [&>strong]:text-slate-950">
                            <span>Saldo tersedia organizer</span>
                            <strong>{{ $money($overview['organizer_available']) }}</strong>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 py-2.5 text-sm text-slate-600 [&>strong]:font-semibold [&>strong]:tabular-nums [&>strong]:text-slate-950">
                            <span>Penarikan selesai</span>
                            <strong>{{ $money($overview['completed_withdrawal']) }}</strong>
                        </div>
                    </div>

                </div>
            </x-card>
        </div>

        <x-card class="overflow-hidden">
            <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-5">
                <div>
                    <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Pembayaran terbaru</h2>
                    <p class="mt-1 text-sm leading-5 text-slate-600">Transaksi terverifikasi terakhir di platform.</p>
                </div>
                <a href="/administrator/payments" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">Lihat semua</a>
            </div>

            @if ($overview['recent_payments']->isEmpty())
                <div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950">
                    <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-receipt-off"></i></span>
                    <strong>Belum ada pembayaran terverifikasi</strong>
                    <p>Pembayaran akan tampil di sini setelah transaksi selesai.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[50rem] text-left text-sm [&_td]:border-t [&_td]:border-slate-100 [&_td]:px-4 [&_td]:py-3 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:font-semibold [&_th]:text-slate-600 [&_tbody_tr:hover]:bg-blue-50/40">
                        <thead>
                            <tr>
                                <th scope="col">Transaksi</th>
                                <th scope="col">Event</th>
                                <th scope="col">Pembeli</th>
                                <th scope="col">Metode</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($overview['recent_payments'] as $payment)
                                <tr>
                                    <td>
                                        <span class="font-semibold text-slate-900">{{ $payment->transaction_code }}</span>
                                        <span class="block text-xs text-slate-600">{{ $payment->paid_at?->format('d M Y H:i') ?? '—' }}</span>
                                    </td>
                                    <td class="max-w-[220px] truncate">{{ $payment->event?->title ?? '—' }}</td>
                                    <td>{{ $payment->buyer_name }}</td>
                                    <td class="text-slate-600">{{ $payment->paymentGatewayMethod?->method?->name ?? '—' }}</td>
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
                    const canvas = document.getElementById('adminRevenueChart');

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
                                label: 'Pembayaran bruto',
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
