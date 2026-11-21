@extends('dashboard.layouts.app')

@section('title', 'Audit log')

@section('content')
    @php
        $logs->withQueryString();
        $hasFilters = $search !== '' || $action !== '';
        $number = static fn ($value) => number_format($value, 0, ',', '.');
        $actionTone = static fn ($name) => match (true) {
            str_starts_with($name, 'withdrawal.') => 'bg-amber-50 text-amber-900',
            str_starts_with($name, 'user.') => 'bg-blue-50 text-blue-800',
            str_starts_with($name, 'role.') => 'bg-violet-50 text-violet-800',
            str_starts_with($name, 'participant.') => 'bg-emerald-50 text-emerald-800',
            default => 'bg-slate-100 text-slate-700',
        };
        $control = 'inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-3 text-[13px] font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
        $pageButton = 'inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-xs font-semibold tabular-nums focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
        $pageLink = $pageButton . ' border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-800';
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 font-['Inter',sans-serif] text-slate-900">
        <header class="border-b border-slate-200 pb-5">
            <h1 class="text-2xl font-semibold leading-tight tracking-tight sm:text-[28px]">Audit Log</h1>
            <p class="mt-1.5 text-[13px] leading-5 text-slate-600">Telusuri perubahan akun, izin, penarikan dana, dan check-in.</p>
        </header>

        <section aria-labelledby="auditActivityTitle" class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="space-y-3 border-b border-slate-200 p-4">
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                    <h2 id="auditActivityTitle" class="text-sm font-semibold">Aktivitas platform</h2>
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium tabular-nums text-slate-600">
                        {{ $number($logs->total()) }} {{ $hasFilters ? 'hasil' : 'aktivitas' }}
                    </span>
                </div>

                <form action="{{ url('/administrator/audit-logs') }}" method="GET" role="search" aria-label="Cari aktivitas"
                      class="flex flex-wrap items-stretch gap-2">
                    <label class="flex min-h-10 min-w-0 basis-full items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 focus-within:border-blue-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 md:min-w-[12rem] md:flex-1 md:basis-auto">
                        <i class="ti ti-search shrink-0 text-base text-slate-500" aria-hidden="true"></i>
                        <span class="sr-only">Aksi, deskripsi, atau pengguna</span>
                        <input type="search" name="key" value="{{ $search }}" placeholder="Aksi, deskripsi, atau pengguna"
                               class="w-full min-w-0 bg-transparent text-base outline-none placeholder:text-slate-500 sm:text-[13px]">
                    </label>

                    <select name="action" aria-label="Jenis aksi"
                            class="min-h-10 min-w-0 flex-1 rounded-lg border border-slate-200 bg-white px-2.5 text-[13px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 md:max-w-[14rem] md:flex-none">
                        <option value="">Semua aksi</option>
                        @foreach ($actions as $actionName)
                            <option value="{{ $actionName }}" @selected($action === $actionName)>{{ $actionName }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="{{ $control }} shrink-0 bg-[#1765c4] text-white hover:bg-[#174f9e]">
                        Cari <i class="ti ti-arrow-right" aria-hidden="true"></i>
                    </button>
                    @if ($hasFilters)
                        <a href="{{ url('/administrator/audit-logs') }}" class="{{ $control }} shrink-0 border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">Reset</a>
                    @endif
                </form>
            </div>

            @if ($logs->isEmpty())
                <div class="space-y-2 px-4 py-10 text-center text-[13px] text-slate-600">
                    <i class="ti ti-history text-2xl text-slate-400" aria-hidden="true"></i>
                    <h3 class="font-semibold text-slate-950">{{ $hasFilters ? 'Aktivitas tidak ditemukan' : 'Belum ada aktivitas' }}</h3>
                    <p>{{ $hasFilters ? 'Coba kata kunci atau jenis aksi lain.' : 'Aktivitas akan tampil setelah tercatat di audit log.' }}</p>
                </div>
            @else
                <div role="region" aria-label="Tabel aktivitas" tabindex="0" class="lg:overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-blue-600">
                    <table role="table" class="block w-full text-left text-xs lg:table lg:min-w-[51rem] lg:[&_td]:border-t lg:[&_td]:border-slate-100 lg:[&_td]:px-3 lg:[&_td]:py-2.5 lg:[&_td]:align-top [&_th]:bg-slate-50 [&_th]:px-3 [&_th]:py-2.5 [&_th]:text-[11px] [&_th]:font-semibold [&_th]:text-slate-600">
                        <thead role="rowgroup" class="sr-only lg:not-sr-only">
                            <tr role="row">
                                @foreach (['Waktu', 'Pengguna', 'Aksi', 'Detail', 'Subjek', 'IP'] as $heading)
                                    <th scope="col" role="columnheader">{{ $heading }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody role="rowgroup" class="block space-y-2 bg-slate-50 p-2.5 lg:table-row-group lg:space-y-0 lg:bg-white lg:p-0">
                            @foreach ($logs as $log)
                                @php $logAction = (string) $log->action; @endphp
                                <tr role="row" class="grid grid-cols-2 items-start gap-x-3 gap-y-2 rounded-xl border border-slate-200 bg-white p-3 lg:table-row lg:rounded-none lg:border-0 lg:p-0 lg:even:bg-slate-50/60 lg:hover:bg-blue-50/40">
                                    <td role="cell" class="col-start-1 row-start-1 tabular-nums text-slate-600 lg:whitespace-nowrap">
                                        {{ $log->created_at?->format('d M Y H:i') ?? '—' }}
                                    </td>
                                    <td role="cell" class="col-span-2 min-w-0 lg:max-w-44">
                                        <span class="block break-words font-semibold text-slate-950">{{ $log->user?->name ?? 'System' }}</span>
                                        <span class="block break-all text-slate-600">{{ $log->user?->email ?? '—' }}</span>
                                    </td>
                                    <td role="cell" class="col-start-2 row-start-1 min-w-0 text-right lg:text-left">
                                        <span class="inline-block max-w-full break-all rounded-md px-2 py-0.5 font-mono text-[11px] font-medium {{ $actionTone($logAction) }}">{{ $logAction ?: '—' }}</span>
                                    </td>
                                    <td role="cell" class="col-span-2 min-w-0 break-words leading-5 text-slate-700 lg:max-w-xs">
                                        {{ $log->description ?: '—' }}

                                        @if (!empty($log->meta))
                                            <details class="group mt-1">
                                                <summary class="inline-flex min-h-8 cursor-pointer list-none items-center gap-1 rounded text-xs font-medium text-blue-800 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 [&::-webkit-details-marker]:hidden">
                                                    <i class="ti ti-chevron-down group-open:rotate-180" aria-hidden="true"></i> Metadata
                                                </summary>
                                                <pre tabindex="0" aria-label="Isi metadata" class="max-h-40 max-w-full overflow-auto whitespace-pre-wrap break-all rounded-lg border border-slate-200 bg-slate-50 p-2.5 font-mono text-[11px] leading-5 text-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">{{ json_encode($log->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                            </details>
                                        @endif
                                    </td>
                                    <td role="cell" class="min-w-0 break-words text-slate-600 lg:max-w-40">
                                        <span class="mb-0.5 block text-[11px] font-medium text-slate-500 lg:hidden">Subjek</span>
                                        @if ($log->subject_type)
                                            <span title="{{ $log->subject_type }}">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td role="cell" class="min-w-0 break-all text-slate-600">
                                        <span class="mb-0.5 block text-[11px] font-medium text-slate-500 lg:hidden">IP</span>
                                        <span class="font-mono text-[11px]">{{ $log->ip_address ?: '—' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    @php
                        $current = $logs->currentPage();
                        $last = $logs->lastPage();
                        $start = max(1, min($current - 1, $last - 2));
                        $pages = $last <= 5
                            ? range(1, $last)
                            : array_values(array_unique([1, ...range($start, $start + 2), $last]));
                    @endphp

                    <nav aria-label="Halaman audit log" class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-4 py-3">
                        <p class="text-xs tabular-nums text-slate-600">{{ $number($logs->firstItem()) }}–{{ $number($logs->lastItem()) }} dari {{ $number($logs->total()) }} aktivitas</p>
                        <div class="flex flex-wrap items-center gap-1.5">
                            @if ($logs->previousPageUrl())
                                <a href="{{ $logs->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="{{ $pageLink }}">
                                    <i class="ti ti-chevron-left" aria-hidden="true"></i>
                                </a>
                            @endif

                            @foreach ($pages as $index => $page)
                                @if ($index > 0 && $page > $pages[$index - 1] + 1)
                                    <span class="px-1 text-slate-500" aria-hidden="true">…</span>
                                @endif

                                @if ($page === $current)
                                    <span aria-current="page" class="{{ $pageButton }} bg-blue-50 text-blue-800 ring-1 ring-inset ring-blue-200">{{ $page }}</span>
                                @else
                                    <a href="{{ $logs->url($page) }}" aria-label="Halaman {{ $page }}" class="{{ $pageLink }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($logs->nextPageUrl())
                                <a href="{{ $logs->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="{{ $pageLink }}">
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
