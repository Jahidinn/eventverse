@extends('dashboard.layouts.app')

@section('title', 'Payments')

@section('content')
    @php
        $money = static fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $number = static fn ($value) => number_format($value, 0, ',', '.');
        $activeStatus = request('status');
        $hasFilters = $search !== '' || $activeStatus;
        $transactions->withQueryString()->onEachSide(1);

        $statuses = [
            'Paid' => ['Lunas', 'bg-emerald-50 text-emerald-800'],
            'Pending' => ['Menunggu', 'bg-amber-50 text-amber-900'],
            'Expired' => ['Kedaluwarsa', 'bg-slate-100 text-slate-700'],
            'Cancelled' => ['Dibatalkan', 'bg-slate-100 text-slate-700'],
            'Refunded' => ['Dikembalikan', 'bg-blue-50 text-blue-800'],
        ];
        $pageButton = 'inline-flex h-10 min-w-10 items-center justify-center gap-1 rounded-xl px-2 text-sm font-semibold tabular-nums focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
        $pageLink = $pageButton . ' border border-slate-200 bg-white text-slate-700 transition-colors hover:border-blue-200 hover:bg-blue-50 hover:text-blue-800';
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Payments</h1>
                <p class="mt-2 text-sm leading-6 text-blue-100">Pantau transaksi, status pembayaran, dan metode pembayaran platform.</p>
            </div>
            <a href="{{ url('/administrator/wd-request') }}"
               class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-wallet text-lg" aria-hidden="true"></i> Penarikan dana
            </a>
        </header>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard.kpi label="Gross terverifikasi" :value="$money($overview['gross'])"
                             sub="Pembayaran lengkap di environment ini" icon="ti-receipt-2" tone="is-sky" :money="true" />
            <x-dashboard.kpi label="Pendapatan platform" :value="$money($overview['platform_fee'])"
                             sub="Platform fee terverifikasi" icon="ti-building-bank" tone="is-green" :money="true" />
            <x-dashboard.kpi label="Transaksi lunas" :value="$number($overview['transactions_paid'])"
                             :sub="$number($overview['tickets_sold']) . ' tiket terjual'" icon="ti-circle-check" tone="is-cyan" />

            <x-card class="p-3.5 sm:p-4">
                <h2 class="text-sm font-semibold">Status transaksi</h2>
                <dl class="mt-2 divide-y divide-slate-100 text-sm">
                    <div class="flex items-center justify-between gap-2 py-1.5">
                        <dt class="text-slate-600">Menunggu</dt>
                        <dd class="font-semibold tabular-nums text-amber-900">{{ $number($overview['transactions_pending']) }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-2 py-1.5">
                        <dt class="text-slate-600">Kedaluwarsa</dt>
                        <dd class="font-semibold tabular-nums">{{ $number($overview['transactions_expired']) }}</dd>
                    </div>
                </dl>
            </x-card>
        </div>

        @if ($overview['legacy_count'] > 0)
            <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-950">
                <i class="ti ti-info-circle shrink-0 text-lg" aria-hidden="true"></i>
                <p><strong>{{ $number($overview['legacy_count']) }} transaksi lama</strong> tetap tampil untuk penelusuran. Gross terverifikasi hanya mencakup pembayaran dengan data lengkap.</p>
            </div>
        @endif

        <section aria-label="Daftar pembayaran" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4 sm:p-5">
                <div class="mb-3 flex flex-wrap items-baseline justify-between gap-2">
                    <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight">Daftar transaksi</h2>
                    <span class="text-xs font-medium tabular-nums text-slate-600">
                        {{ $number($transactions->total()) }} {{ $hasFilters ? 'hasil' : 'transaksi' }}
                    </span>
                </div>

                <form action="{{ url('/administrator/payments') }}" method="GET" role="search" aria-label="Cari dan filter transaksi"
                      class="flex flex-wrap items-stretch gap-2">
                    <label class="flex min-h-11 min-w-0 basis-full items-center gap-2.5 rounded-xl border border-slate-200 bg-slate-50 px-3 focus-within:border-blue-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 md:min-w-[12rem] md:flex-1 md:basis-auto">
                        <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                        <span class="sr-only">Kode transaksi, pembeli, atau event</span>
                        <input type="search" name="key" value="{{ $search }}" placeholder="Kode transaksi, pembeli, atau event"
                               class="w-full min-w-0 bg-transparent text-base outline-none placeholder:text-slate-500 sm:text-sm">
                    </label>

                    <select name="status" aria-label="Status pembayaran" class="min-h-11 min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 md:w-40 md:flex-none">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $status => [$label, $tone])
                            <option value="{{ $status }}" @selected($activeStatus === $status)>{{ $label }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-1.5 rounded-xl bg-[#1765c4] px-4 text-sm font-semibold text-white transition-colors hover:bg-[#174f9e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Cari <i class="ti ti-arrow-right" aria-hidden="true"></i>
                    </button>

                    @if ($hasFilters)
                        <a href="{{ url('/administrator/payments') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-xl px-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if ($transactions->isEmpty())
                <div class="space-y-2 px-5 py-12 text-center text-sm text-slate-600">
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-blue-50 text-2xl text-blue-700" aria-hidden="true"><i class="ti ti-receipt-off"></i></span>
                    <h2 class="text-base font-semibold text-slate-950">{{ $hasFilters ? 'Transaksi tidak ditemukan' : 'Belum ada transaksi' }}</h2>
                    <p>{{ $hasFilters ? 'Coba kata kunci atau status pembayaran lain.' : 'Transaksi akan muncul di sini setelah tercatat.' }}</p>
                </div>
            @else
                <div role="region" aria-label="Tabel transaksi" tabindex="0" class="lg:overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-blue-600">
                    <table role="table" class="block w-full text-left text-sm lg:table lg:min-w-[58rem] lg:[&_td]:border-b lg:[&_td]:border-slate-100 lg:[&_td]:px-4 lg:[&_td]:py-3.5 lg:[&_td]:align-top [&_th]:border-b [&_th]:border-slate-200 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:text-xs [&_th]:font-semibold [&_th]:text-slate-600">
                        <thead role="rowgroup" class="sr-only lg:not-sr-only">
                            <tr role="row">
                                <th scope="col" role="columnheader">Transaksi</th>
                                <th scope="col" role="columnheader">Event</th>
                                <th scope="col" role="columnheader">Pembeli</th>
                                <th scope="col" role="columnheader">Metode</th>
                                <th scope="col" role="columnheader">Tanggal</th>
                                <th scope="col" role="columnheader" class="text-right">Total</th>
                                <th scope="col" role="columnheader" class="text-right">Fee platform</th>
                                <th scope="col" role="columnheader">Status</th>
                            </tr>
                        </thead>

                        <tbody role="rowgroup" class="block space-y-2 bg-slate-50 p-2.5 lg:table-row-group lg:space-y-0 lg:bg-white lg:p-0">
                            @foreach ($transactions as $transaction)
                                @php
                                    [$label, $tone] = $statuses[$transaction->status] ?? [
                                        $transaction->status ?: 'Tidak diketahui', 'bg-slate-100 text-slate-700',
                                    ];
                                @endphp
                                <tr role="row" class="grid grid-cols-2 gap-x-3 gap-y-2 rounded-xl border border-slate-200 bg-white p-3.5 lg:table-row lg:rounded-none lg:border-0 lg:p-0 lg:even:bg-slate-50/60 lg:hover:bg-blue-50/70">
                                    <td role="cell" class="col-start-1 row-start-1 min-w-0 lg:table-cell">
                                        <span class="block break-all font-mono text-xs font-semibold leading-5 text-blue-950">{{ $transaction->transaction_code }}</span>
                                        <span class="block break-all text-xs text-slate-600">{{ $transaction->invoice_number ?: 'Tanpa invoice' }}</span>
                                    </td>
                                    <td role="cell" class="col-span-2 break-words font-semibold lg:table-cell lg:max-w-52">
                                        <span class="block text-xs font-normal text-slate-500 lg:hidden">Event</span>
                                        {{ $transaction->event?->title ?? '—' }}
                                    </td>
                                    <td role="cell" class="col-span-2 min-w-0 break-words lg:table-cell">
                                        <span class="block text-xs text-slate-500 lg:hidden">Pembeli</span>
                                        {{ $transaction->buyer_name ?: '—' }}
                                        <span class="block break-all text-xs text-slate-600">{{ $transaction->buyer_email }}</span>
                                    </td>
                                    <td role="cell" class="min-w-0 break-words text-slate-600 lg:table-cell">
                                        <span class="block text-xs text-slate-500 lg:hidden">Metode</span>
                                        {{ $transaction->paymentGatewayMethod?->method?->name ?? '—' }}
                                    </td>
                                    <td role="cell" class="text-slate-600 lg:table-cell lg:whitespace-nowrap">
                                        <span class="block text-xs text-slate-500 lg:hidden">Tanggal</span>
                                        {{ ($transaction->paid_at ?? $transaction->created_at)?->format('d M Y H:i') ?? '—' }}
                                    </td>
                                    <td role="cell" class="min-w-0 break-words font-semibold tabular-nums lg:table-cell lg:whitespace-nowrap lg:text-right">
                                        <span class="block text-xs font-normal text-slate-500 lg:hidden">Total</span>
                                        {{ $money($transaction->grand_total) }}
                                    </td>
                                    <td role="cell" class="min-w-0 break-words tabular-nums lg:table-cell lg:whitespace-nowrap lg:text-right">
                                        <span class="block text-xs text-slate-500 lg:hidden">Fee platform</span>
                                        {{ $money($transaction->platform_fee) }}
                                    </td>
                                    <td role="cell" class="col-start-2 row-start-1 justify-self-end lg:table-cell">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $tone }}"><span aria-hidden="true" class="h-1.5 w-1.5 shrink-0 rounded-full bg-current"></span>{{ $label }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($transactions->hasPages())
                    <nav aria-label="Halaman transaksi" class="flex flex-col gap-3 border-t border-slate-200 bg-white px-4 py-3.5 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
                        <p class="text-xs tabular-nums text-slate-600">
                            Menampilkan <span class="font-semibold text-slate-900">{{ $number($transactions->firstItem()) }}–{{ $number($transactions->lastItem()) }}</span>
                            dari {{ $number($transactions->total()) }} transaksi
                        </p>

                        <div class="flex flex-wrap items-center gap-1.5">
                            @if ($transactions->previousPageUrl())
                                <a href="{{ $transactions->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="{{ $pageLink }}">
                                    <i class="ti ti-chevron-left" aria-hidden="true"></i>
                                </a>
                            @endif

                            @foreach ($transactions->linkCollection()->slice(1, -1) as $link)
                                @if ($link['active'])
                                    <span aria-current="page" class="{{ $pageButton }} bg-blue-50 text-blue-800 ring-1 ring-inset ring-blue-200">{{ $link['label'] }}</span>
                                @elseif ($link['url'])
                                    <a href="{{ $link['url'] }}" aria-label="Halaman {{ $link['label'] }}" class="{{ $pageLink }}">{{ $link['label'] }}</a>
                                @else
                                    <span class="px-1 text-slate-500" aria-hidden="true">…</span>
                                @endif
                            @endforeach

                            @if ($transactions->nextPageUrl())
                                <a href="{{ $transactions->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="{{ $pageLink }}">
                                    <i class="ti ti-chevron-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </nav>
                @endif
            @endif
        </section>
    </div>
@endsection
