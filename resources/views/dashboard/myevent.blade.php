@extends('dashboard.layouts.app')

@section('title', 'My Event')

@section('content')
    @php
        $money = static fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $statusLabel = static fn ($status) => match ($status) {
            'Paid' => 'Lunas',
            'Pending' => 'Menunggu pembayaran',
            'Unpaid' => 'Belum dibayar',
            'Expired' => 'Kedaluwarsa',
            'Cancelled' => 'Dibatalkan',
            'Refunded' => 'Dikembalikan',
            default => $status ?: 'Tidak diketahui',
        };
        $toneClass = static fn ($status) => match ($status) {
            'Paid' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
            'Pending', 'Unpaid' => 'bg-amber-50 text-amber-900 ring-amber-200',
            'Expired', 'Cancelled' => 'bg-rose-50 text-rose-800 ring-rose-200',
            'Refunded' => 'bg-blue-50 text-blue-800 ring-blue-200',
            default => 'bg-slate-100 text-slate-700 ring-slate-200',
        };
        $tabs = ['' => 'Semua', 'Paid' => 'Lunas', 'Pending' => 'Pending', 'Expired' => 'Kedaluwarsa'];
    @endphp
    <div class="mx-auto max-w-6xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-5 overflow-hidden rounded-3xl border border-blue-900/20 bg-gradient-to-br from-[#0d1e3c] via-[#153875] to-[#1854a2] px-5 py-7 text-white shadow-sm sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-3/5 bg-[repeating-linear-gradient(135deg,transparent_0_17px,rgba(147,197,253,0.22)_17px_18px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div class="min-w-0">
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">My Event</h1>
                <p class="mt-2 max-w-lg text-sm leading-6 text-blue-100">Event yang kamu ikuti, status pembayaran, dan akses tiket.</p>
            </div>
            <div class="flex flex-wrap gap-2 [&>a]:border-white/20 [&>a]:bg-white/10 [&>a]:text-white [&>a:hover]:bg-white/20 [&>button]:bg-white [&>button]:text-blue-900 [&>button:hover]:bg-blue-50">
                <a href="/search" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100"><i class="ti ti-search"></i> Jelajah event</a>
                <button type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e]" data-create-event><i class="ti ti-plus"></i> Buat event</button>
            </div>
        </header>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <nav class="flex max-w-full flex-wrap items-center gap-1 rounded-xl bg-slate-100 p-1" aria-label="Filter status">
                @foreach ($tabs as $value => $label)
                    @php $isActive = (string) $activeStatus === (string) $value; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['status' => $value ?: null, 'page' => null]) }}"
                       class="inline-flex min-h-9 items-center rounded-lg px-3 py-1.5 text-sm font-medium transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 {{ $isActive ? 'bg-white text-blue-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-600 hover:bg-white/75 hover:text-slate-900' }}"
                       @if ($isActive) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>
            <span class="text-xs font-medium tabular-nums text-slate-600">{{ number_format($myevents->total(), 0, ',', '.') }} registrasi</span>
            <form method="GET" action="" class="flex w-full min-w-0 flex-wrap items-center gap-2 lg:ml-auto lg:w-auto">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <div class="flex min-h-10 min-w-0 flex-1 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 lg:w-60">
                    <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                    <input type="search" name="key" aria-label="Cari event yang kamu ikuti" class="min-w-0 flex-1 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-500" value="{{ request('key') }}" placeholder="Cari event yang kamu ikuti">
                </div>
                <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Cari</button>
                @if (request('key'))
                    <a href="/dashboard/myevent" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Reset</a>
                @endif
            </form>
        </div>
        @if ($myevents->isEmpty())
            <div class="flex flex-col items-center gap-3 rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center text-sm text-slate-600 sm:py-16">
                <span class="grid h-14 w-14 place-items-center rounded-2xl bg-blue-50 text-2xl text-blue-700"><i class="ti ti-ticket-off"></i></span>
                @if (request('key') || $activeStatus)
                    <h2 class="text-lg font-bold text-slate-950">Tidak ada tiket yang cocok</h2>
                    <p>Coba kata kunci atau status lain.</p>
                @else
                    <h2 class="text-lg font-bold text-slate-950">Belum ada tiket</h2>
                    <p>Daftar ke sebuah event dan tiketmu akan muncul di sini.</p>
                @endif
                <a href="/search" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e]"><i class="ti ti-search"></i> Jelajah event</a>
            </div>
        @else
            <div class="grid gap-4">
                @foreach ($myevents as $myevent)
                    @php
                        $displayPrice = (float) $myevent->grand_total > 0
                            ? (float) $myevent->grand_total
                            : (float) $myevent->subtotal;
                        $eventImage = $myevent->event?->image;
                        $imageExists = $eventImage && file_exists(public_path('storage/event-images/' . $eventImage));
                        $status = $myevent->status;
                        $startDate = $myevent->event?->start_date;
                        $code = $myevent->transaction_code;
                    @endphp
                    <article class="grid min-w-0 grid-cols-[5.25rem_minmax(0,1fr)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_24px_-22px_rgba(15,23,42,0.45)] sm:grid-cols-[8rem_minmax(0,1fr)_11rem] lg:grid-cols-[10rem_minmax(0,1fr)_12.5rem]">
                        <div class="relative isolate min-h-24 self-stretch overflow-hidden bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100 sm:aspect-auto sm:min-h-40">
                            <div class="absolute inset-0 grid place-items-center text-xl text-slate-500 sm:text-3xl"><i class="ti ti-photo-off"></i></div>
                            @if ($imageExists)
                                <img src="{{ asset('storage/event-images/' . $eventImage) }}"
                                     alt=""
                                     class="absolute inset-0 h-full w-full object-cover"
                                     loading="lazy"
                                     x-data
                                     x-on:error="$el.hidden = true; $el.classList.add('hidden')">
                            @endif
                            @if ($startDate)
                                <div class="absolute bottom-3 left-3 hidden min-w-12 sm:flex flex-col items-center rounded-lg border border-white/60 bg-white/95 px-2 py-1.5 text-[11px] font-medium text-slate-700 [&>b]:text-lg [&>b]:leading-5 [&>b]:text-slate-950">
                                    <b>{{ $startDate->format('d') }}</b>
                                    <span>{{ $startDate->format('M Y') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex min-w-0 flex-col items-start gap-1.5 p-3 sm:gap-2 sm:p-5">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $toneClass($status) }}">{{ $statusLabel($status) }}</span>
                            </div>
                            <a href="/{{ $myevent->event?->slug }}" class="break-words font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-sm font-bold leading-snug tracking-tight sm:text-lg text-slate-950 hover:text-blue-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                {{ $myevent->event?->title ?? 'Event tidak ditemukan' }}
                            </a>
                            <div class="flex flex-wrap gap-x-3 gap-y-1 text-xs leading-5 text-slate-600 [&>span]:inline-flex [&>span]:items-center [&>span]:gap-1.5 [&_i]:text-base [&_i]:text-blue-700">
                                <span><i class="ti ti-ticket"></i>{{ $myevent->ticket?->ticket_name ?? 'Tiket' }}</span>
                                @if ($startDate)
                                    <span><i class="ti ti-calendar"></i>{{ $startDate->format('d M Y') }}</span>
                                @endif
                            </div>
                            <button type="button" class="mt-auto inline-flex max-w-full items-center gap-1.5 rounded-md bg-slate-50 px-2 py-1.5 font-mono text-xs text-slate-600 hover:bg-blue-50 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600" data-copy="{{ $code }}" title="Salin kode transaksi">
                                <i class="ti ti-copy"></i><span class="min-w-0 break-all" aria-live="polite">#{{ $code }}</span>
                            </button>
                        </div>
                        <div class="relative col-span-2 flex min-w-0 flex-wrap items-center justify-between gap-x-3 gap-y-2 border-t border-dashed border-slate-200 bg-slate-50/80 px-3 py-2.5 sm:col-span-1 sm:flex-col sm:flex-nowrap sm:items-stretch sm:justify-start sm:gap-3 sm:border-l sm:border-t-0 sm:p-4">
                            <span aria-hidden="true" class="pointer-events-none absolute -left-2 -top-2 h-4 w-4 rounded-full border border-slate-200 bg-slate-50"></span>
                            <span aria-hidden="true" class="pointer-events-none absolute -right-2 -top-2 h-4 w-4 rounded-full border border-slate-200 bg-slate-50 sm:-bottom-2 sm:-left-2 sm:right-auto sm:top-auto"></span>
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 sm:items-start sm:justify-between">
                                <div>
                                    <div class="text-xs font-medium text-slate-600">Total bayar</div>
                                    <div class="mt-0.5 break-words text-sm font-bold tracking-tight text-slate-950 tabular-nums sm:text-base">{{ $money($displayPrice) }}</div>
                                </div>
                                <div class="rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-800">{{ $myevent->quantity }} tiket</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-1.5 sm:mt-auto sm:grid sm:gap-2">
                                @if ($status === 'Paid')
                                    <a href="/transaction/{{ $code }}/ticket" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e] sm:w-full"><i class="ti ti-ticket"></i> Lihat tiket</a>
                                    <div class="flex flex-wrap gap-1.5 sm:grid sm:grid-cols-2 sm:gap-2">
                                        <a href="/transaction/{{ $code }}/detail" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 sm:px-2 sm:text-xs"><i class="ti ti-list"></i> Detail</a>
                                        <a href="/transaction/{{ $code }}/invoice" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 sm:px-2 sm:text-xs"><i class="ti ti-file-description"></i> Invoice</a>
                                    </div>
                                @elseif ($status === 'Pending' || $status === 'Unpaid')
                                    <a href="/transaction/{{ $code }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 bg-[#1765c4] text-white hover:bg-[#174f9e] sm:w-full"><i class="ti ti-cash"></i> Bayar sekarang</a>
                                    <div class="flex flex-wrap gap-1.5 sm:grid sm:grid-cols-2 sm:gap-2">
                                        <a href="/transaction/{{ $code }}/detail" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 sm:px-2 sm:text-xs"><i class="ti ti-list"></i> Detail</a>
                                        <button type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700" aria-label="Hapus registrasi" title="Hapus registrasi" data-delete-transaction="{{ $myevent->id }}"><i class="ti ti-trash"></i></button>
                                    </div>
                                @else
                                    <a href="/transaction/{{ $code }}/detail" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-2.5 py-1.5 text-xs font-semibold sm:px-3.5 sm:py-2 sm:text-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-60 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 sm:w-full"><i class="ti ti-list"></i> Lihat detail</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                {{ $myevents->withQueryString()->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
            (function () {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                document.querySelectorAll('[data-delete-transaction]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        if (!window.confirm('Hapus registrasi ini? Tindakan ini tidak bisa dibatalkan.')) {
                            return;
                        }
                        const id = button.getAttribute('data-delete-transaction');
                        button.disabled = true;
                        fetch('/dashboard/delete-myevent', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-CSRF-TOKEN': token || '',
                                'Accept': 'application/json',
                            },
                            body: new URLSearchParams({ id: id }),
                        })
                            .then(function (response) { return response.json(); })
                            .then(function (payload) {
                                if (payload.success) {
                                    window.location.reload();
                                    return;
                                }
                                window.alert(payload.error || 'Gagal menghapus registrasi.');
                                button.disabled = false;
                            })
                            .catch(function () {
                                window.alert('Gagal menghapus registrasi.');
                                button.disabled = false;
                            });
                    });
                });
                document.querySelectorAll('[data-copy]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const label = button.querySelector('span');
                        const original = label.textContent;
                        if (!navigator.clipboard) {
                            return;
                        }
                        navigator.clipboard.writeText(button.getAttribute('data-copy'))
                            .then(function () {
                                label.textContent = 'Tersalin';
                                button.disabled = true;
                                setTimeout(function () {
                                    label.textContent = original;
                                    button.disabled = false;
                                }, 1400);
                            })
                            .catch(function () { window.alert('Kode transaksi gagal disalin.'); });
                    });
                });
            })();
        </script>
    @endpush
@endsection