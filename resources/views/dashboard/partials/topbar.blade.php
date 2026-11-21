{{-- resources/views/dashboard/partials/topbar.blade.php --}}
@php
    // Tautan kedua di menu akun menyesuaikan konteks pengguna (sama seperti logika sebelumnya).
    $switchLink = match (true) {
        $isAdmin && $hasOrganizerRole => ['Organizer dashboard', 'dashboard', 'ti-layout-dashboard'],
        $isAdmin => ['My Event', 'dashboard/myevent', 'ti-ticket'],
        $hasAdminRole => ['Admin panel', 'administrator', 'ti-shield-cog'],
        default => ['My Event', 'dashboard/myevent', 'ti-ticket'],
    };

    $accountLinks = [
        ['Profile', 'dashboard/my-profile', 'ti-user-cog'],
        $switchLink,
    ];
@endphp

<header class="sticky top-0 z-30 isolate flex min-h-16 items-center justify-between gap-3 border-b border-zinc-200/70 bg-white/75 px-4 font-['Sora','Inter',sans-serif] backdrop-blur-xl shadow-[inset_0_1px_0_rgba(255,255,255,0.8),0_10px_24px_-20px_rgba(15,23,42,0.3)] sm:px-6">
    {{-- Dekorasi: cahaya biru dan sky yang sangat samar di belakang kaca. --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-10 -top-16 h-40 w-64 rounded-full bg-[#2282ff]/10 blur-3xl"></div>
        <div class="absolute right-24 -top-20 h-36 w-56 rounded-full bg-sky-300/15 blur-3xl"></div>
    </div>

    <div class="flex min-w-0 items-center gap-3">
        <button type="button" x-ref="sidebarToggle" @click="openSidebar()"
                class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white text-lg text-zinc-800 ring-1 ring-zinc-200/80 shadow-[0_1px_2px_rgba(15,23,42,0.06)] transition-colors hover:bg-zinc-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#2282ff] lg:hidden"
                aria-label="Buka menu" aria-controls="dashSidebar" :aria-expanded="sidebarOpen.toString()">
            <i class="ti ti-menu-2" aria-hidden="true"></i>
        </button>

        <div class="min-w-0">
            <p class="truncate text-[15px] font-semibold leading-5 tracking-[-0.015em] text-zinc-900">@yield('title', 'Dashboard')</p>
            <p class="truncate text-xs leading-4 text-zinc-600">{{ $roleLabel }} workspace</p>
        </div>
    </div>

    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
        {{-- Status lingkungan: Live (solid) vs Sandbox (garis putus-putus, terasa "uji coba"). --}}
        @if ($environment === 'production')
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-600/20">
                <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_0_3px_rgba(16,185,129,0.2)]"></span>
                Live
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 rounded-full border border-dashed border-amber-400/80 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-900">
                <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-amber-500 shadow-[0_0_0_3px_rgba(245,158,11,0.2)]"></span>
                Sandbox
            </span>
        @endif

        {{-- Menu akun. Menutup saat klik di luar atau tekan Escape. --}}
        <details class="group/menu relative"
                 x-data
                 @click.outside="$el.removeAttribute('open')"
                 @keydown.escape="$el.removeAttribute('open')">
            <summary aria-label="Menu akun"
                     class="flex cursor-pointer list-none items-center gap-2 rounded-full bg-white/80 py-1 pl-1 pr-2.5 ring-1 ring-zinc-200/80 shadow-[0_1px_2px_rgba(15,23,42,0.06)] transition-colors hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#2282ff] [&::-webkit-details-marker]:hidden">
                <img src="{{ $profileUrl }}" alt=""
                     class="h-9 w-9 shrink-0 rounded-full bg-zinc-100 object-cover ring-2 ring-white shadow-[0_0_0_1px_rgba(15,23,42,0.1)]">

                <span class="hidden min-w-0 max-w-[9rem] text-left sm:block">
                    <span class="block truncate text-[13px] font-semibold leading-4 text-zinc-900">{{ $user->name }}</span>
                    <span class="block truncate text-[11px] leading-4 text-zinc-600">{{ $roleLabel }}</span>
                </span>

                <i aria-hidden="true" class="ti ti-chevron-down text-xs text-zinc-500 transition-transform group-open/menu:rotate-180"></i>
            </summary>

            <div class="absolute right-0 mt-2 w-64 max-w-[calc(100vw-2rem)] rounded-2xl bg-white/95 p-1.5 ring-1 ring-zinc-200/80 backdrop-blur-xl shadow-[0_2px_6px_rgba(15,23,42,0.06),0_20px_40px_-16px_rgba(15,23,42,0.35)]">
                <div class="flex items-center gap-3 rounded-xl bg-gradient-to-br from-[#eaf3ff] to-white px-3 py-2.5">
                    <img src="{{ $profileUrl }}" alt=""
                         class="h-10 w-10 shrink-0 rounded-full bg-zinc-100 object-cover ring-2 ring-white shadow-[0_0_0_1px_rgba(15,23,42,0.1)]">
                    <div class="min-w-0">
                        <p class="truncate text-[13px] font-semibold leading-5 text-zinc-900">{{ $user->name }}</p>
                        <p class="truncate text-xs leading-4 text-zinc-600">{{ $user->email }}</p>
                    </div>
                </div>

                <ul class="mt-1.5 space-y-0.5">
                    @foreach ($accountLinks as [$label, $path, $icon])
                        <li>
                            <a href="{{ url($path) }}"
                               class="group/item flex items-center gap-3 rounded-xl px-2 py-1.5 text-[13px] font-medium text-zinc-700 transition-colors hover:bg-zinc-100 hover:text-zinc-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#2282ff]">
                                <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-[15px] text-zinc-500 ring-1 ring-zinc-200/80 shadow-[0_1px_1.5px_rgba(15,23,42,0.06)] transition-colors group-hover/item:text-[#1765c4]">
                                    <i aria-hidden="true" class="ti {{ $icon }} leading-none"></i>
                                </span>
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ url('/logout') }}" class="mt-1.5 border-t border-zinc-100 pt-1.5">
                    @csrf
                    <button type="submit"
                            class="group/item flex w-full items-center gap-3 rounded-xl px-2 py-1.5 text-left text-[13px] font-medium text-rose-700 transition-colors hover:bg-rose-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-rose-500">
                        <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-[15px] text-rose-600 ring-1 ring-rose-200 shadow-[0_1px_1.5px_rgba(15,23,42,0.06)]">
                            <i aria-hidden="true" class="ti ti-logout leading-none"></i>
                        </span>
                        Logout
                    </button>
                </form>
            </div>
        </details>
    </div>
</header>