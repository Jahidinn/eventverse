{{-- resources/views/partials/navbar.blade.php --}}
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-sm border-b border-[#e2e8f0]">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between h-[72px]">

            {{-- Logo --}}
            <a href="/" class="flex items-center shrink-0">
                <img src="/assets/img/eventverse-color.png" alt="Eventverse" class="h-9 w-auto">
            </a>

            {{-- DESKTOP MENU --}}
            <nav class="hidden md:flex items-center gap-5">
                <a href="/" class="text-sm font-medium text-[#0f172a] hover:text-[#2282ff] transition-colors">Home</a>
                <a href="/about-us" class="text-sm font-medium text-[#64748b] hover:text-[#2282ff] transition-colors">About us</a>
                <a href="/pricing" class="text-sm font-medium text-[#64748b] hover:text-[#2282ff] transition-colors">Pricing</a>
                <a href="/creator-guide" class="text-sm font-medium text-[#64748b] hover:text-[#2282ff] transition-colors">Guide</a>
                <a href="/blog" class="text-sm font-medium text-[#64748b] hover:text-[#2282ff] transition-colors">Blog</a>
                {{-- Search --}}
                <button
                    type="button"
                    id="navbar-search-btn"
                    class="inline-flex items-center gap-2 px-4 py-1 rounded-full text-sm font-medium
                        text-[#2282ff] bg-[#ebf3ff]
                        hover:bg-[#dbe9ff] hover:text-[#1b6cd6]
                        transition-colors"
                >
                    <i class="ti ti-search text-lg"></i>
                    <span>Search</span>
                </button>

                <button
                    type="button"
                    id="navbar-check-registration-btn"
                    class="inline-flex items-center gap-2 px-4 py-1 rounded-full text-sm font-medium
                        text-[#2282ff] bg-[#ebf3ff]
                        hover:bg-[#dbe9ff] hover:text-[#1b6cd6]
                        transition-colors"
                >
                    <i class="ti ti-user-search text-lg"></i>
                    <span>Check registration</span>
                </button>
            </nav>

            {{-- DESKTOP ACTIONS --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <div class="relative" id="user-dropdown-wrapper">
                        <button
                            type="button"
                            id="user-dropdown-btn"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-[#0f172a] hover:bg-[#f8fafc] transition-colors"
                            aria-expanded="false"
                        >
                            <span class="w-8 h-8 rounded-full bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[140px] truncate">{{ auth()->user()->name }}</span>
                            <svg id="user-dropdown-icon" class="w-4 h-4 text-[#64748b] transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        <div id="user-dropdown" class="hidden absolute right-0 top-full mt-2 w-52 rounded-xl border border-[#e2e8f0] bg-white shadow-lg shadow-slate-900/5 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-[#e2e8f0]">
                                <p class="text-xs text-[#64748b]">Signed in as</p>
                                <p class="mt-0.5 text-sm font-semibold text-[#0f172a] truncate">{{ auth()->user()->name }}</p>
                            </div>

                            <div class="p-1.5">
                                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-[#0f172a] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">
                                    <svg class="w-4 h-4 text-[#64748b]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h7.5V21H3v-7.5Zm10.5-10H21V21h-7.5V3.5ZM3 3.5h7.5v6H3v-6Z"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>

                                <button type="button" id="logout-btn" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-[#0f172a] hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg class="w-4 h-4 text-[#64748b]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 15l3-3-3-3m3 3H9"/>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="/login" class="px-4 py-2 text-sm font-medium text-[#0f172a] hover:text-[#2282ff] transition-colors">
                        Login
                    </a>
                @endauth

                <a href="/dashboard/manajemen-event" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-xl text-white bg-[#2282ff] hover:bg-[#1b6cd6] shadow-sm shadow-[#2282ff]/25 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Create Event</span>
                </a>
            </div>

            {{-- MOBILE HAMBURGER --}}
            <button
                id="mobile-menu-btn"
                type="button"
                class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-[#64748b] hover:text-[#0f172a] hover:bg-[#f1f5f9] transition-colors"
                aria-label="Toggle navigation"
                aria-expanded="false"
            >
                <svg id="mobile-menu-open-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="mobile-menu-close-icon" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6"/>
                </svg>
            </button>

        </div>

        {{-- MOBILE MENU --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-[#e2e8f0]">
            <nav class="py-4 space-y-1 flex flex-col h-full">
                <a href="/" class="mobile-menu-link block px-4 py-3 rounded-lg text-sm font-medium text-[#0f172a] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">Home</a>
                <a href="/about-us" class="mobile-menu-link block px-4 py-3 rounded-lg text-sm font-medium text-[#64748b] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">About us</a>
                <a href="/pricing" class="mobile-menu-link block px-4 py-3 rounded-lg text-sm font-medium text-[#64748b] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">Pricing</a>
                <a href="/creator-guide" class="mobile-menu-link block px-4 py-3 rounded-lg text-sm font-medium text-[#64748b] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">Guide</a>
                <a href="/blog" class="mobile-menu-link block px-4 py-3 rounded-lg text-sm font-medium text-[#64748b] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">Blog</a>
                {{-- Mobile Search --}}
                <div class="mt-3 mb-3 pt-3 border-t border-[#e2e8f0] space-y-2">

                    {{-- Mobile Search --}}
                    <button
                        type="button"
                        id="mobile-navbar-search-btn"
                        class="w-full inline-flex items-center gap-2
                            px-4 py-3 rounded-xl
                            text-sm font-medium
                            text-[#2282ff] bg-[#ebf3ff]
                            hover:bg-[#dbe9ff] hover:text-[#1b6cd6]
                            transition-colors"
                    >
                        <i class="ti ti-search text-lg"></i>
                        <span>Search</span>
                    </button>

                    {{-- Mobile Check Registration --}}
                    <button
                        type="button"
                        id="mobile-check-registration-btn"
                        class="w-full inline-flex items-center gap-2
                            px-4 py-3 rounded-xl
                            text-sm font-medium
                            text-[#2282ff] bg-[#ebf3ff]
                            hover:bg-[#dbe9ff] hover:text-[#1b6cd6]
                            transition-colors"
                    >
                        <i class="ti ti-user-search text-lg"></i>
                        <span>Check registration</span>
                    </button>

                </div>

                {{-- Separator --}}

                <div class="my-3 border-t border-[#e2e8f0]"></div>

                @auth
                    <div class="flex items-center gap-3 px-4 py-3">
                        <span class="w-9 h-9 rounded-full bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-sm font-bold shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs text-[#64748b]">Signed in as</p>
                            <p class="text-sm font-semibold text-[#0f172a] truncate">{{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <a href="/dashboard" class="mobile-menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-[#0f172a] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">
                        <svg class="w-4 h-4 text-[#64748b]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h7.5V21H3v-7.5Zm10.5-10H21V21h-7.5V3.5ZM3 3.5h7.5v6H3v-6Z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <button type="button" id="mobile-logout-btn" class="mobile-menu-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-[#0f172a] hover:bg-red-50 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4 text-[#64748b]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 15l3-3-3-3m3 3H9"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                @else
                    <a href="/login" class="mobile-menu-link block px-4 py-3 rounded-lg text-sm font-medium text-[#0f172a] hover:bg-[#f8fafc] hover:text-[#2282ff] transition-colors">Login</a>
                @endauth

                <a href="/create-event" class="mobile-menu-link flex items-center justify-center gap-2 mt-2 px-4 py-3 rounded-xl text-sm font-semibold text-white bg-[#2282ff] hover:bg-[#1b6cd6] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Create Event</span>
                </a>
            </nav>
        </div>

    </div>
</header>

{{-- =========================================================
    SEARCH MODAL
========================================================= --}}
<div
    id="navbar-search-modal"
    class="fixed inset-0 z-[100] hidden"
    aria-hidden="true"
>
    {{-- Backdrop --}}
    <div
        id="navbar-search-backdrop"
        class="absolute inset-0 bg-slate-950/45 backdrop-blur-sm
               opacity-0 transition-opacity duration-200"
    ></div>

    {{-- Modal Wrapper --}}
    <div class="relative flex min-h-full items-start justify-center px-4 pt-[12vh] sm:px-6">

        {{-- Modal --}}
        <div
            id="navbar-search-panel"
            class="relative w-full max-w-2xl
                   translate-y-[-12px] scale-[0.98] opacity-0
                   rounded-2xl border border-[#e2e8f0]
                   bg-white
                   shadow-2xl shadow-slate-900/15
                   transition-all duration-200"
        >

            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center
                               rounded-xl bg-[#ebf3ff] text-[#2282ff]"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m20 20-4-4"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-[#0f172a]">
                            Search Events
                        </h3>

                        <p class="mt-0.5 text-xs text-[#94a3b8]">
                            Find events, competitions, and activities
                        </p>
                    </div>

                </div>

                {{-- Close --}}
                <button
                    type="button"
                    id="navbar-search-close"
                    class="flex h-9 w-9 items-center justify-center
                           rounded-lg text-[#94a3b8]
                           hover:bg-[#f8fafc]
                           hover:text-[#475569]
                           transition-colors"
                    aria-label="Close search"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>

            </div>


            {{-- Search Form --}}
            <form
                action="{{ url('/search') }}"
                method="GET"
                id="navbar-search-form"
                class="px-5 pb-5 sm:px-6 sm:pb-6"
            >

                <div
                    class="flex items-center gap-3
                           rounded-xl
                           border border-[#e2e8f0]
                           bg-[#f8fafc]
                           px-4 py-2
                           transition-all duration-200
                           focus-within:border-[#2282ff]/40
                           focus-within:bg-white
                           focus-within:ring-4
                           focus-within:ring-[#2282ff]/10"
                >

                    {{-- Search Icon --}}
                    <svg
                        class="w-5 h-5 shrink-0 text-[#94a3b8]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>

                    {{-- Input --}}
                    <input
                        type="text"
                        name="key"
                        id="navbar-search-input"
                        value=""
                        autocomplete="off"
                        placeholder="Search event, competition, workshop..."
                        class="min-w-0 flex-1
                               border-0
                               bg-transparent
                               py-3
                               text-sm
                               text-[#0f172a]
                               outline-none
                               placeholder:text-[#94a3b8]
                               focus:ring-0"
                    >

                    {{-- Desktop Submit --}}
                    <button
                        type="submit"
                        class="hidden sm:inline-flex
                               shrink-0
                               items-center gap-2
                               rounded-lg
                               bg-[#2282ff]
                               px-4 py-2.5
                               text-sm font-semibold
                               text-white
                               shadow-sm shadow-[#2282ff]/20
                               hover:bg-[#1b6cd6]
                               transition-all"
                    >
                        Search

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>
                    </button>

                </div>


                {{-- Mobile Submit --}}
                <button
                    type="submit"
                    class="mt-3
                           flex w-full
                           items-center justify-center gap-2
                           rounded-xl
                           bg-[#2282ff]
                           px-5 py-3
                           text-sm font-semibold
                           text-white
                           shadow-sm shadow-[#2282ff]/20
                           hover:bg-[#1b6cd6]
                           transition-colors
                           sm:hidden"
                >
                    Search Events

                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>
                </button>


                {{-- Footer Hint --}}
                <div class="mt-3 flex items-center justify-between">

                    <span class="text-xs text-[#94a3b8]">
                        Search by event name or keyword
                    </span>

                    <span class="hidden sm:flex items-center gap-1.5 text-xs text-[#94a3b8]">
                        <kbd
                            class="rounded-md border border-[#e2e8f0]
                                   bg-[#f8fafc]
                                   px-1.5 py-0.5
                                   font-sans text-[10px] font-medium"
                        >
                            ESC
                        </kbd>

                        <span>to close</span>
                    </span>

                </div>

            </form>

        </div>
    </div>
</div>

{{-- =========================================================
    CHECK REGISTRATION MODAL
========================================================= --}}
<div
    id="check-registration-modal"
    class="fixed inset-0 z-[100] hidden"
    aria-hidden="true"
>
    {{-- Backdrop --}}
    <div
        id="check-registration-backdrop"
        class="absolute inset-0 bg-slate-950/45 backdrop-blur-sm
               opacity-0 transition-opacity duration-200"
    ></div>

    {{-- Modal Wrapper --}}
    <div class="relative flex min-h-full items-start justify-center px-4 pt-[12vh] sm:px-6">

        {{-- Modal Panel --}}
        <div
            id="check-registration-panel"
            class="relative w-full max-w-2xl
                   translate-y-[-12px] scale-[0.98] opacity-0
                   rounded-2xl border border-[#e2e8f0]
                   bg-white
                   shadow-2xl shadow-slate-900/15
                   transition-all duration-200"
        >

            {{-- ============ HEADER ============ --}}
            <div class="flex items-center justify-between px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#ebf3ff] text-[#2282ff]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-[#0f172a]">
                            Check Registration
                        </h3>
                        <p class="mt-0.5 text-xs text-[#94a3b8]">
                            Cek status tiket dengan kode transaksi atau kode tiket
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    id="check-registration-close"
                    class="flex h-9 w-9 items-center justify-center
                           rounded-lg text-[#94a3b8]
                           hover:bg-[#f8fafc] hover:text-[#475569]
                           transition-colors"
                    aria-label="Close"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>

            </div>

            {{-- =====================================================
                 STATE 1: FORM
            ====================================================== --}}
            <div id="check-registration-form-state" class="px-5 pb-5 sm:px-6 sm:pb-6 space-y-3">

                <form id="check-registration-form" class="space-y-3">

                    {{-- Code Input --}}
                    <div class="flex items-center gap-3 rounded-xl border border-[#e2e8f0] bg-[#f8fafc] px-4 py-2 transition-all duration-200 focus-within:border-[#2282ff]/40 focus-within:bg-white focus-within:ring-4 focus-within:ring-[#2282ff]/10">
                        <svg class="w-5 h-5 shrink-0 text-[#94a3b8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z"/>
                        </svg>
                        <input
                            type="text"
                            name="code"
                            id="check-code"
                            required
                            autocomplete="off"
                            placeholder="Kode transaksi / kode tiket"
                            class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0"
                        >
                    </div>

                    {{-- Email Input --}}
                    <div class="flex items-center gap-3 rounded-xl border border-[#e2e8f0] bg-[#f8fafc] px-4 py-2 transition-all duration-200 focus-within:border-[#2282ff]/40 focus-within:bg-white focus-within:ring-4 focus-within:ring-[#2282ff]/10">
                        <svg class="w-5 h-5 shrink-0 text-[#94a3b8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 6-10 7L2 6"/>
                        </svg>
                        <input
                            type="email"
                            name="email"
                            id="check-email"
                            required
                            autocomplete="email"
                            placeholder="Masukkan email pemesanan"
                            class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0"
                        >
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        id="check-registration-submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#2282ff] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-[#2282ff]/20 hover:bg-[#1b6cd6] transition-all disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-search"></i>
                            <span>Cek Sekarang</span>
                        </span>
                    </button>

                    {{-- Hint --}}
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-xs text-[#94a3b8]">
                            Gunakan kode & email yang sama saat mendaftar
                        </span>
                        <span class="hidden sm:flex items-center gap-1.5 text-xs text-[#94a3b8]">
                            <kbd class="rounded-md border border-[#e2e8f0] bg-[#f8fafc] px-1.5 py-0.5 font-sans text-[10px] font-medium">ESC</kbd>
                            <span>to close</span>
                        </span>
                    </div>
                </form>

            </div>

            {{-- =====================================================
                 STATE 2: RESULT
            ====================================================== --}}
            <div id="check-registration-result-state" class="hidden px-5 pb-5 sm:px-6 sm:pb-6">

                {{-- Status Badge --}}
                <div id="check-status-badge" class="flex items-center gap-3 p-3.5 rounded-xl border mb-4">
                    <div id="check-status-icon" class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ti ti-circle-check text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div id="check-status-title" class="text-sm font-bold text-[#0f172a]">
                            Data Valid & Ready
                        </div>
                        <div id="check-status-subtitle" class="text-xs text-[#64748b] mt-0.5">
                            Tiket Anda siap digunakan
                        </div>
                    </div>
                    <span id="check-status-pill" class="text-[10px] font-extrabold uppercase tracking-wide px-2.5 py-1 rounded-full">
                        Paid
                    </span>
                </div>

                {{-- Detail Card --}}
                <div class="border border-[#e2e8f0] rounded-xl overflow-hidden mb-4">

                    {{-- Header: Tipe & Kode --}}
                    <div class="px-4 py-3 bg-[#f8fafc] border-b border-[#e2e8f0] flex items-center justify-between">
                        <span id="check-type-label" class="text-[11px] font-bold uppercase tracking-wide text-[#2282ff]">
                            Transaction
                        </span>
                        <span id="check-code-display" class="text-xs font-bold text-[#0f172a] font-mono">
                            —
                        </span>
                    </div>

                    {{-- Body: Fields --}}
                    <div class="divide-y divide-[#f1f5f9]">

                        <div class="flex justify-between items-start gap-4 px-4 py-3">
                            <span class="text-xs text-[#64748b] shrink-0">Nama</span>
                            <strong id="check-name" class="text-[13px] text-[#0f172a] text-right break-all">—</strong>
                        </div>

                        <div class="flex justify-between items-start gap-4 px-4 py-3">
                            <span class="text-xs text-[#64748b] shrink-0">Email</span>
                            <strong id="check-email-display" class="text-[13px] text-[#0f172a] text-right break-all">—</strong>
                        </div>

                        <div id="check-phone-row" class="flex justify-between items-start gap-4 px-4 py-3">
                            <span class="text-xs text-[#64748b] shrink-0">Nomor HP</span>
                            <strong id="check-phone" class="text-[13px] text-[#0f172a] text-right break-all">—</strong>
                        </div>

                        <div class="flex justify-between items-start gap-4 px-4 py-3">
                            <span class="text-xs text-[#64748b] shrink-0">Event</span>
                            <strong id="check-event" class="text-[13px] text-[#0f172a] text-right">—</strong>
                        </div>

                        <div class="flex justify-between items-start gap-4 px-4 py-3">
                            <span class="text-xs text-[#64748b] shrink-0">Tiket</span>
                            <strong id="check-ticket" class="text-[13px] text-[#0f172a] text-right">—</strong>
                        </div>

                        <div class="flex justify-between items-start gap-4 px-4 py-3">
                            <span class="text-xs text-[#64748b] shrink-0">Jumlah</span>
                            <strong id="check-quantity" class="text-[13px] text-[#0f172a] text-right">—</strong>
                        </div>

                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-2">
                    <button
                        type="button"
                        id="check-back-btn"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl border-[1.5px] border-[#e2e8f0] bg-white px-4 py-3 text-sm font-bold text-[#0f172a] hover:bg-[#f1f5f9] transition-colors"
                    >
                        <i class="ti ti-arrow-left"></i>
                        <span>Cek Kode Lain</span>
                    </button>

                    <a
                        id="check-edit-btn"
                        href="#"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-[#2282ff] px-4 py-3 text-sm font-bold text-white shadow-sm shadow-[#2282ff]/20 hover:bg-[#1b6cd6] transition-colors"
                    >
                        <i class="ti ti-edit"></i>
                        <span>Edit Data</span>
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- Mobile Navbar ---------- */
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('mobile-menu-open-icon');
    const closeIcon = document.getElementById('mobile-menu-close-icon');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.contains('hidden');

            if (isOpen) {
                mobileMenu.classList.remove('hidden');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
            } else {
                mobileMenu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });

        document.querySelectorAll('.mobile-menu-link').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                mobileMenu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /* ---------- User Dropdown ---------- */
    const userDropdownBtn = document.getElementById('user-dropdown-btn');
    const userDropdown = document.getElementById('user-dropdown');
    const userDropdownIcon = document.getElementById('user-dropdown-icon');

    if (userDropdownBtn && userDropdown) {
        userDropdownBtn.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = !userDropdown.classList.contains('hidden');

            if (isOpen) {
                userDropdown.classList.add('hidden');
                userDropdownIcon?.classList.remove('rotate-180');
                userDropdownBtn.setAttribute('aria-expanded', 'false');
            } else {
                userDropdown.classList.remove('hidden');
                userDropdownIcon?.classList.add('rotate-180');
                userDropdownBtn.setAttribute('aria-expanded', 'true');
            }
        });

        document.addEventListener('click', function (event) {
            if (!userDropdown.contains(event.target) && !userDropdownBtn.contains(event.target)) {
                userDropdown.classList.add('hidden');
                userDropdownIcon?.classList.remove('rotate-180');
                userDropdownBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /* ---------- Logout Confirmation Modal ---------- */
    const logoutBtn = document.getElementById('logout-btn');
    const mobileLogoutBtn = document.getElementById('mobile-logout-btn');
    const logoutModal = document.getElementById('logout-modal');
    const logoutCancelBtn = document.getElementById('logout-cancel-btn');
    const logoutModalBackdrop = document.getElementById('logout-modal-backdrop');

    function openLogoutModal() {
        if (!logoutModal) return;
        logoutModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeLogoutModal() {
        if (!logoutModal) return;
        logoutModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    logoutBtn?.addEventListener('click', openLogoutModal);
    mobileLogoutBtn?.addEventListener('click', openLogoutModal);
    logoutCancelBtn?.addEventListener('click', closeLogoutModal);
    logoutModalBackdrop?.addEventListener('click', closeLogoutModal);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && logoutModal && !logoutModal.classList.contains('hidden')) {
            closeLogoutModal();
        }
    });

    /* ---------- Navbar Search ---------- */
    const navbarSearchBtn = document.getElementById('navbar-search-btn');
    const mobileNavbarSearchBtn = document.getElementById('mobile-navbar-search-btn');

    const navbarSearchModal = document.getElementById('navbar-search-modal');
    const navbarSearchBackdrop = document.getElementById('navbar-search-backdrop');
    const navbarSearchPanel = document.getElementById('navbar-search-panel');
    const navbarSearchClose = document.getElementById('navbar-search-close');
    const navbarSearchInput = document.getElementById('navbar-search-input');

    function openNavbarSearch() {
        if (!navbarSearchModal) return;

        navbarSearchModal.classList.remove('hidden');
        navbarSearchModal.setAttribute('aria-hidden', 'false');

        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(function () {

            navbarSearchBackdrop?.classList.remove('opacity-0');
            navbarSearchBackdrop?.classList.add('opacity-100');

            navbarSearchPanel?.classList.remove(
                'translate-y-[-12px]',
                'scale-[0.98]',
                'opacity-0'
            );

            navbarSearchPanel?.classList.add(
                'translate-y-0',
                'scale-100',
                'opacity-100'
            );

        });

        setTimeout(function () {
            navbarSearchInput?.focus();
        }, 150);
    }

    function closeNavbarSearch() {
        if (!navbarSearchModal) return;

        navbarSearchBackdrop?.classList.remove('opacity-100');
        navbarSearchBackdrop?.classList.add('opacity-0');

        navbarSearchPanel?.classList.remove(
            'translate-y-0',
            'scale-100',
            'opacity-100'
        );

        navbarSearchPanel?.classList.add(
            'translate-y-[-12px]',
            'scale-[0.98]',
            'opacity-0'
        );

        navbarSearchModal.setAttribute('aria-hidden', 'true');

        setTimeout(function () {
            navbarSearchModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    navbarSearchBtn?.addEventListener('click', openNavbarSearch);

    mobileNavbarSearchBtn?.addEventListener('click', function () {

        // Tutup mobile menu
        mobileMenu?.classList.add('hidden');

        openIcon?.classList.remove('hidden');
        closeIcon?.classList.add('hidden');

        mobileMenuBtn?.setAttribute('aria-expanded', 'false');

        // Buka search
        openNavbarSearch();
    });

    navbarSearchClose?.addEventListener('click', closeNavbarSearch);

    navbarSearchBackdrop?.addEventListener('click', closeNavbarSearch);

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            navbarSearchModal &&
            !navbarSearchModal.classList.contains('hidden')
        ) {
            closeNavbarSearch();
        }

    });


    /* ---------- Check Registration Modal ---------- */
const checkRegBtn = document.getElementById('navbar-check-registration-btn');
const mobileCheckRegBtn = document.getElementById('mobile-check-registration-btn');

const checkRegModal = document.getElementById('check-registration-modal');
const checkRegBackdrop = document.getElementById('check-registration-backdrop');
const checkRegPanel = document.getElementById('check-registration-panel');
const checkRegClose = document.getElementById('check-registration-close');
const checkRegForm = document.getElementById('check-registration-form');
const checkRegSubmit = document.getElementById('check-registration-submit');
const checkRegCodeInput = document.getElementById('check-code');

function openCheckReg() {
    if (!checkRegModal) return;

    checkRegModal.classList.remove('hidden');
    checkRegModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');

    requestAnimationFrame(function () {
        checkRegBackdrop?.classList.remove('opacity-0');
        checkRegBackdrop?.classList.add('opacity-100');

        checkRegPanel?.classList.remove('translate-y-[-12px]', 'scale-[0.98]', 'opacity-0');
        checkRegPanel?.classList.add('translate-y-0', 'scale-100', 'opacity-100');
    });

    setTimeout(() => checkRegCodeInput?.focus(), 150);
}

function closeCheckReg() {
    if (!checkRegModal) return;

    checkRegBackdrop?.classList.remove('opacity-100');
    checkRegBackdrop?.classList.add('opacity-0');

    checkRegPanel?.classList.remove('translate-y-0', 'scale-100', 'opacity-100');
    checkRegPanel?.classList.add('translate-y-[-12px]', 'scale-[0.98]', 'opacity-0');

    checkRegModal.setAttribute('aria-hidden', 'true');

    setTimeout(function () {
        checkRegModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }, 200);
}

checkRegBtn?.addEventListener('click', openCheckReg);
mobileCheckRegBtn?.addEventListener('click', function () {
    // Tutup mobile menu dulu
    mobileMenu?.classList.add('hidden');
    openIcon?.classList.remove('hidden');
    closeIcon?.classList.add('hidden');
    mobileMenuBtn?.setAttribute('aria-expanded', 'false');

    openCheckReg();
});

checkRegClose?.addEventListener('click', closeCheckReg);
checkRegBackdrop?.addEventListener('click', closeCheckReg);

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && checkRegModal && !checkRegModal.classList.contains('hidden')) {
        closeCheckReg();
    }
});


    /* ---------- Submit AJAX ---------- */
    const checkRegFormState = document.getElementById('check-registration-form-state');
    const checkRegResultState = document.getElementById('check-registration-result-state');

    function showFormState() {
        checkRegFormState?.classList.remove('hidden');
        checkRegResultState?.classList.add('hidden');
    }

    function showResultState(data) {
        // ── Status badge ──
        const badge = document.getElementById('check-status-badge');
        const iconBox = document.getElementById('check-status-icon');
        const title = document.getElementById('check-status-title');
        const subtitle = document.getElementById('check-status-subtitle');
        const pill = document.getElementById('check-status-pill');

        if (data.status_valid) {
            badge.className = 'flex items-center gap-3 p-3.5 rounded-xl border border-[#a7f3d0] bg-[#ecfdf5] mb-4';
            iconBox.className = 'w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-[#dcfce7] text-[#16a34a]';
            title.textContent = 'Data Valid & Ready';
            subtitle.textContent = 'Tiket Anda siap digunakan';
            pill.className = 'text-[10px] font-extrabold uppercase tracking-wide px-2.5 py-1 rounded-full bg-[#dcfce7] text-[#166534]';
        } else {
            badge.className = 'flex items-center gap-3 p-3.5 rounded-xl border border-[#fecaca] bg-[#fef2f2] mb-4';
            iconBox.className = 'w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-[#fee2e2] text-[#dc2626]';
            title.textContent = 'Pembayaran Belum Selesai';
            subtitle.textContent = 'Selesaikan pembayaran untuk mengaktifkan tiket';
            pill.className = 'text-[10px] font-extrabold uppercase tracking-wide px-2.5 py-1 rounded-full bg-[#fee2e2] text-[#991b1b]';
        }
        pill.textContent = data.status || '—';

        // ── Detail card ──
        document.getElementById('check-type-label').textContent =
            data.type === 'ticket' ? 'Ticket Code' : 'Transaction Code';

        document.getElementById('check-code-display').textContent = data.code || '—';
        document.getElementById('check-name').textContent = data.name || '—';
        document.getElementById('check-email-display').textContent = data.email || '—';
        document.getElementById('check-phone').textContent = data.phone || '—';
        document.getElementById('check-event').textContent = data.event_title || '—';
        document.getElementById('check-ticket').textContent = data.ticket_name || '—';
        document.getElementById('check-quantity').textContent = `${data.quantity || 1} Tiket`;

        // Hide phone row kalau kosong (misal transaction type)
        const phoneRow = document.getElementById('check-phone-row');
        if (data.phone) {
            phoneRow.classList.remove('hidden');
        } else {
            phoneRow.classList.add('hidden');
        }

        // ── Edit button ──
        const editBtn = document.getElementById('check-edit-btn');
        if (data.edit_url) {
            editBtn.href = data.edit_url;
            editBtn.classList.remove('hidden');
        } else {
            editBtn.classList.add('hidden');
        }

        // ── Toggle state ──
        checkRegFormState?.classList.add('hidden');
        checkRegResultState?.classList.remove('hidden');
    }

    // "Cek Kode Lain" button
    document.getElementById('check-back-btn')?.addEventListener('click', function () {
        checkRegForm?.reset();
        showFormState();
        setTimeout(() => checkRegCodeInput?.focus(), 100);
    });


    checkRegForm?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const code = document.getElementById('check-code').value.trim();
        const email = document.getElementById('check-email').value.trim();

        if (!code || !email) return;

        const originalHtml = checkRegSubmit.innerHTML;
        checkRegSubmit.disabled = true;
        checkRegSubmit.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <i class="ti ti-loader-2 animate-spin"></i>
                <span>Mencari...</span>
            </span>
        `;

        try {
            const res = await fetch("{{ route('transaction.check-registration') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ code, email }),
            });

            const data = await res.json();

            if (!res.ok || !data.success) {
                throw new Error(data.message || 'Data tidak ditemukan.');
            }

            // Tampilkan hasil di modal
            showResultState(data.data);

        } catch (err) {
            console.error(err);
            if (typeof toast !== 'undefined') {
                toast.error('Gagal', {
                    description: err.message || 'Terjadi kesalahan. Coba lagi.',
                });
            } else {
                alert(err.message);
            }
        } finally {
            checkRegSubmit.disabled = false;
            checkRegSubmit.innerHTML = originalHtml;
        }
    });
});

function openCheckReg() {
    if (!checkRegModal) return;

    // Reset ke form state setiap kali dibuka
    checkRegForm?.reset();
    showFormState();

    checkRegModal.classList.remove('hidden');
    checkRegModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');

    requestAnimationFrame(function () {
        checkRegBackdrop?.classList.remove('opacity-0');
        checkRegBackdrop?.classList.add('opacity-100');

        checkRegPanel?.classList.remove('translate-y-[-12px]', 'scale-[0.98]', 'opacity-0');
        checkRegPanel?.classList.add('translate-y-0', 'scale-100', 'opacity-100');
    });

    setTimeout(() => checkRegCodeInput?.focus(), 150);
}



</script>
@endpush