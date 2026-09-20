@extends('layouts.app')

@section('title', 'Artikel - Eventverse.id')
@section('meta_description', 'Baca artikel, berita, pengumuman, dan informasi menarik seputar event di Eventverse.id.')

@section('content')

{{-- ==================== HERO ==================== --}}
<section class="relative overflow-hidden bg-white border-b border-[#e2e8f0] py-10 sm:py-14 lg:py-16">

    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[560px] h-[560px] rounded-full bg-[#2282ff]/[0.08] blur-3xl"></div>
        <div class="absolute top-[30%] -right-24 w-[420px] h-[420px] rounded-full bg-[#60a5fa]/[0.06] blur-3xl"></div>
        <div class="absolute bottom-8 left-[30%] w-24 h-24 rounded-[2rem] border border-[#2282ff]/[0.07] rotate-12"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff] text-xs font-semibold border border-[#2282ff]/20 mb-5">
                <i class="ti ti-article"></i>
                <span>Artikel</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15] m-0">
                Welcome to
                <span class="text-[#2282ff]">Eventverse Article</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-[#64748b] leading-relaxed">
                Baca artikel, berita, dan pengumuman terbaru seputar event di Eventverse.id.
            </p>

            {{-- Search --}}
            <form action="/blog/search" method="GET" class="mt-6 max-w-xl mx-auto">
                <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-white border border-[#e2e8f0] shadow-[0_4px_20px_-4px_rgba(15,23,42,0.08)] focus-within:border-[#2282ff]/40 focus-within:shadow-[0_8px_30px_-8px_rgba(34,130,255,0.15)] transition-all">

                    <div class="w-11 h-11 flex items-center justify-center text-[#94a3b8] shrink-0">
                        <i class="ti ti-search text-lg"></i>
                    </div>

                    <input type="search"
                           name="key"
                           placeholder="Cari artikel..."
                           autocomplete="off"
                           class="flex-1 min-w-0 px-2 py-3 text-sm text-[#0f172a] placeholder:text-[#94a3b8] bg-transparent border-0 outline-none focus:ring-0">

                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#2282ff] hover:bg-[#1b6cd6] text-white text-sm font-semibold shadow-sm hover:-translate-y-0.5 transition-all shrink-0">
                        <span>Search</span>
                        <i class="ti ti-arrow-right text-sm"></i>
                    </button>

                </div>
            </form>

        </div>
    </div>
</section>


{{-- ==================== BLOG CONTENT ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- ============ FEATURED ARTICLE ============ --}}
    @if ((request()->query('page') == 1 || request()->query('page') == '') && $latestArticle)
        @php
            $img = 'assets/default-img/blog-images/default-img.png';
            if (!empty($latestArticle->input_image)) {
                $imgPath = 'storage/blog-images/' . $latestArticle->input_image;
                if (file_exists(public_path($imgPath))) {
                    $img = $imgPath;
                }
            }
        @endphp

        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-[#fef3c7] text-[#b45309] flex items-center justify-center">
                    <i class="ti ti-star-filled text-sm"></i>
                </div>
                <div class="text-[11px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase">
                    Artikel Terbaru
                </div>
            </div>

            <a href="/blog/{{ $latestArticle->slug }}"
               class="group block bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] hover:shadow-[0_20px_45px_-12px_rgba(34,130,255,0.18)] hover:border-[#c2dcff] hover:-translate-y-0.5 transition-all overflow-hidden">

                <div class="grid grid-cols-1 lg:grid-cols-2">

                    {{-- Image --}}
                    <div class="relative overflow-hidden lg:aspect-auto aspect-[16/10] lg:min-h-[320px]">
                        <img src="{{ asset($img) }}"
                             alt="{{ $latestArticle->title }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white/95 backdrop-blur text-[#0f172a] text-[10px] font-bold uppercase tracking-wider">
                                <i class="ti ti-star-filled text-[#f59e0b] text-xs"></i>
                                Featured
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 sm:p-8 flex flex-col justify-center">

                        <div class="flex items-center gap-2 text-xs text-[#64748b] mb-3">
                            <i class="ti ti-calendar-event"></i>
                            <span>{{ $latestArticle->created_at->format('d F Y') }}</span>
                        </div>

                        <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-[#0f172a] leading-snug mb-3 group-hover:text-[#2282ff] transition-colors">
                            {{ $latestArticle->title }}
                        </h2>

                        <div class="inline-flex items-center gap-2 text-sm font-bold text-[#2282ff] mt-2">
                            <span>Baca Selengkapnya</span>
                            <i class="ti ti-arrow-right text-base group-hover:translate-x-1 transition-transform"></i>
                        </div>

                    </div>

                </div>
            </a>
        </div>
    @endif


    {{-- ============ GRID ARTICLES ============ --}}
    @if($articles->count())
        <div class="flex items-center gap-2 mb-4 mt-2">
            <div class="w-8 h-8 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center">
                <i class="ti ti-layout-grid text-sm"></i>
            </div>
            <div class="text-[11px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase">
                Semua Artikel
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        @forelse ($articles as $article)
            @php
                $img_article = 'assets/default-img/blog-images/default-img.png';
                if (!empty($article->input_image)) {
                    $img_articlePath = 'storage/blog-images/' . $article->input_image;
                    if (file_exists(public_path($img_articlePath))) {
                        $img_article = $img_articlePath;
                    }
                }
            @endphp

            <a href="/blog/{{ $article->slug }}"
               class="group bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_12px_-2px_rgba(15,23,42,0.04)] hover:shadow-[0_12px_30px_-8px_rgba(34,130,255,0.15)] hover:border-[#c2dcff] hover:-translate-y-1 transition-all overflow-hidden flex flex-col h-full">

                {{-- Image --}}
                <div class="relative aspect-[16/10] w-full overflow-hidden bg-[#f1f5f9]">
                    <img src="{{ asset($img_article) }}"
                         alt="{{ $article->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>

                {{-- Body --}}
                <div class="p-4 sm:p-5 flex-1 flex flex-col">

                    <div class="flex items-center gap-2 text-[11px] text-[#64748b] mb-2">
                        <i class="ti ti-calendar-event"></i>
                        <span>{{ $article->created_at->format('d F Y') }}</span>
                    </div>

                    <h3 class="text-sm sm:text-base font-bold text-[#0f172a] leading-snug mb-3 group-hover:text-[#2282ff] transition-colors line-clamp-2 min-h-[2.6em]">
                        {{ $article->title }}
                    </h3>

                    <div class="mt-auto pt-3 border-t border-[#f1f5f9]">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#2282ff]">
                            <span>Read more</span>
                            <i class="ti ti-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>

                </div>

            </a>

        @empty

            <div class="col-span-full">
                <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-10 text-center">
                    <div class="inline-flex w-16 h-16 rounded-2xl bg-[#f1f5f9] text-[#94a3b8] items-center justify-center mb-4">
                        <i class="ti ti-file-off text-3xl"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#0f172a] m-0 mb-1.5">
                        Belum ada artikel
                    </h3>
                    <p class="text-sm text-[#64748b] m-0">
                        Belum ada artikel yang ditemukan. Coba cek lagi nanti.
                    </p>
                </div>
            </div>

        @endforelse

    </div>


    {{-- ============ PAGINATION ============ --}}
    @if($articles->hasPages())
        <div class="mt-8 flex justify-center pagination-modern">
            {{ $articles->links() }}
        </div>
    @endif

</div>
</section>

@endsection


@push('styles')
<style>
    /* Modern pagination untuk Laravel paginator */
    .pagination-modern nav > div:first-child { display: none; } /* Hide "showing X of Y" */

    .pagination-modern nav > div:last-child > span,
    .pagination-modern nav > div:last-child > a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        margin: 0 2px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #0f172a;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination-modern nav > div:last-child > a:hover {
        border-color: #c2dcff;
        color: #2282ff;
        background: #f8fbff;
        transform: translateY(-1px);
    }

    .pagination-modern nav > div:last-child > span[aria-current="page"] > span,
    .pagination-modern nav > div:last-child > span[aria-current="page"] {
        background: #2282ff;
        border-color: #2282ff;
        color: #ffffff;
    }

    .pagination-modern svg {
        width: 16px;
        height: 16px;
    }
</style>
@endpush