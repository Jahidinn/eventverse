@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
    @endphp

    <nav class="mt-4 flex flex-col gap-3 border-t border-ink-100 pt-3.5 sm:flex-row sm:items-center sm:justify-between" aria-label="Pagination">
        <div class="text-[10px] text-ink-400">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
            dari {{ number_format($paginator->total(), 0, ',', '.') }}
        </div>

        <div class="flex flex-wrap items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-[30px] min-w-[30px] cursor-not-allowed items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-400 opacity-40" aria-disabled="true"><i class="ti ti-chevron-left"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-[30px] min-w-[30px] items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700" rel="prev" aria-label="Halaman sebelumnya">
                    <i class="ti ti-chevron-left"></i>
                </a>
            @endif

            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="inline-flex h-[30px] min-w-[30px] items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700">1</a>
                @if ($start > 2)
                    <span class="inline-flex min-w-[20px] justify-center text-[10px] text-ink-400">…</span>
                @endif
            @endif

            @foreach ($paginator->getUrlRange($start, $end) as $page => $url)
                @if ($page === $current)
                    <span class="inline-flex h-[30px] min-w-[30px] items-center justify-center rounded-lg border border-brand-600 bg-brand-600 px-2 text-[10px] font-bold text-white shadow-[0_6px_14px_-10px_rgba(34,130,255,0.9)]" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="inline-flex h-[30px] min-w-[30px] items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700">{{ $page }}</a>
                @endif
            @endforeach

            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="inline-flex min-w-[20px] justify-center text-[10px] text-ink-400">…</span>
                @endif
                <a href="{{ $paginator->url($last) }}" class="inline-flex h-[30px] min-w-[30px] items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700">{{ $last }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-[30px] min-w-[30px] items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700" rel="next" aria-label="Halaman berikutnya">
                    <i class="ti ti-chevron-right"></i>
                </a>
            @else
                <span class="inline-flex h-[30px] min-w-[30px] cursor-not-allowed items-center justify-center rounded-lg border border-line bg-white px-2 text-[10px] font-bold text-ink-400 opacity-40" aria-disabled="true"><i class="ti ti-chevron-right"></i></span>
            @endif
        </div>
    </nav>
@endif
