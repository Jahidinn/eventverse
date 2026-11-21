{{-- resources/views/dashboard/partials/sidebar.blade.php --}}
{{-- Font: Sora. Tambahkan &family=Sora:wght@400;500;600;700 pada link Google Fonts di layout. --}}
@php
    // Format: [label, path, ikon Tabler, pola aktif opsional].
    $menu = $isAdmin ? [
        'Platform' => [
            ['Overview', 'administrator', 'ti-layout-dashboard'],
            ['Payments', 'administrator/payments', 'ti-receipt-2', 'administrator/payments*'],
            ['Withdrawals', 'administrator/wd-request', 'ti-wallet', 'administrator/wd-request*'],
            ['Event Management', 'administrator/event-management/selected', 'ti-calendar-event', 'administrator/event-management*'],
            ['Users', 'administrator/users', 'ti-users', 'administrator/users*'],
            ['Roles & permissions', 'administrator/roles', 'ti-shield-lock', 'administrator/roles*'],
            ['Audit log', 'administrator/audit-logs', 'ti-history', 'administrator/audit-logs*'],
        ],
        'Content' => [
            ['Articles', 'administrator/article', 'ti-news', 'administrator/article*'],
            ['Blog Categories', 'administrator/blog-category', 'ti-category', 'administrator/blog-category*'],
        ],
        'Account' => [
            $hasOrganizerRole
                ? ['Organizer dashboard', 'dashboard', 'ti-layout-dashboard']
                : ['My Event', 'dashboard/myevent', 'ti-ticket'],
            ['Profile', 'dashboard/my-profile', 'ti-settings', 'dashboard/my-profile*'],
        ],
    ] : [
        'Workspace' => [
            ['Overview', 'dashboard', 'ti-layout-dashboard'],
            ['My Event', 'dashboard/myevent', 'ti-ticket', 'dashboard/myevent*'],
        ],
        'Organizer' => $isCreator ? [
            ['Event Management', 'dashboard/manajemen-event', 'ti-calendar-event', 'dashboard/manajemen-event*'],
            ['Participants', 'dashboard/participant-data', 'ti-users', 'dashboard/participant-data*'],
            ['Finance & withdrawals', 'dashboard/transaction-report', 'ti-wallet', 'dashboard/transaction-report*'],
            ['Check-in', 'dashboard/event-checkin', 'ti-user-check', 'dashboard/event-checkin*'],
        ] : [],
        'Account' => [
            ['Organization', 'dashboard/organization', 'ti-users-group', 'dashboard/organization*'],
            ['Profile', 'dashboard/my-profile', 'ti-settings', 'dashboard/my-profile*'],
            ...($hasAdminRole ? [['Admin panel', 'administrator', 'ti-shield-cog']] : []),
        ],
    ];
@endphp
<aside
    id="dashSidebar"
    aria-label="Navigasi dashboard"
    class="invisible fixed inset-y-0 left-0 z-50 isolate flex w-64 max-w-[85vw] -translate-x-full flex-col overflow-hidden border-r border-zinc-200/80 bg-gradient-to-b from-white via-[#f8fafc] {{ $isAdmin ? 'to-[#faf3e3]' : 'to-[#eef3f9]' }} font-['Sora','Inter',sans-serif] text-zinc-900 shadow-[1px_0_0_rgba(255,255,255,0.9)_inset,16px_0_40px_-28px_rgba(15,23,42,0.35)] motion-safe:transition-[transform,visibility] motion-safe:duration-200 lg:visible lg:max-w-none lg:translate-x-0"
    :class="{ 'max-lg:visible max-lg:translate-x-0': sidebarOpen }"
    x-trap.inert.noscroll="sidebarOpen"
>
    {{-- Dekorasi bertema ticketing & event, sangat lembut agar teks menu tetap bersih:
         aurora blur + objek kaca (tiket, QR, check-in, sparkle, konfeti) di tepi kanan/pojok + noise halus.
         Objek sengaja menempel di sisi kanan karena teks menu rata kiri. --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        {{-- Aurora --}}
        <div class="absolute -left-16 -top-20 h-56 w-56 rounded-full {{ $isAdmin ? 'bg-[#b78728]/20' : 'bg-[#2282ff]/20' }} blur-3xl"></div>
        <div class="absolute -right-20 top-1/3 h-48 w-48 rounded-full {{ $isAdmin ? 'bg-[#e0bc72]/20' : 'bg-sky-300/20' }} blur-3xl"></div>
        <div class="absolute -bottom-24 -left-10 h-56 w-56 rounded-full {{ $isAdmin ? 'bg-[#edcf8f]/20' : 'bg-indigo-300/20' }} blur-3xl"></div>
        {{-- Definisi bersama: gradasi kaca, bayangan biru, dan simbol tiket (dipakai 2x) --}}
        <svg width="0" height="0" class="absolute">
            <defs>
                <linearGradient id="evGlass" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#fff" stop-opacity="0.9"/>
                    <stop offset="1" stop-color="{{ $isAdmin ? '#e0bc72' : '#8dbcf9' }}" stop-opacity="0.2"/>
                </linearGradient>
                <linearGradient id="evEdge" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#fff" stop-opacity="0.95"/>
                    <stop offset="1" stop-color="{{ $isAdmin ? '#edcf8f' : '#9cc5fa' }}" stop-opacity="0.5"/>
                </linearGradient>
                <filter id="evShadow" x="-30%" y="-30%" width="160%" height="170%">
                    <feDropShadow dx="0" dy="8" stdDeviation="7" flood-color="{{ $isAdmin ? '#c99a4a' : '#7fb2f7' }}" flood-opacity="0.1"/>
                </filter>
                {{-- Tiket: takik di garis perforasi, teks, barcode, dan sparkle di bagian stub --}}
                <g id="evTicket">
                    <path d="M12 0H97A7 7 0 0 0 111 0H138A12 12 0 0 1 150 12V72A12 12 0 0 1 138 84H111A7 7 0 0 0 97 84H12A12 12 0 0 1 0 72V12A12 12 0 0 1 12 0Z"
                          fill="url(#evGlass)" stroke="url(#evEdge)" stroke-width="1.5" filter="url(#evShadow)"/>
                    <path d="M104 14V70" stroke="{{ $isAdmin ? '#c99a4a' : '#7fb2f7' }}" stroke-opacity="0.5" stroke-width="1.5" stroke-dasharray="3 4" stroke-linecap="round"/>
                    <rect x="16" y="16" width="52" height="6" rx="3" fill="{{ $isAdmin ? '#c99a4a' : '#7fb2f7' }}" fill-opacity="0.4"/>
                    <rect x="16" y="28" width="34" height="6" rx="3" fill="{{ $isAdmin ? '#c99a4a' : '#7fb2f7' }}" fill-opacity="0.8"/>
                    <g fill="{{ $isAdmin ? '#ad7a2c' : '#6b9fdc' }}" fill-opacity="0.34">
                        <rect x="16" y="52" width="2" height="14"/><rect x="21" y="52" width="1" height="14"/>
                        <rect x="25" y="52" width="3" height="14"/><rect x="31" y="52" width="1" height="14"/>
                        <rect x="35" y="52" width="2" height="14"/><rect x="40" y="52" width="1" height="14"/>
                        <rect x="44" y="52" width="3" height="14"/><rect x="50" y="52" width="1" height="14"/>
                        <rect x="54" y="52" width="2" height="14"/>
                    </g>
                    <path d="M127 30L130.5 38.5L139 42L130.5 45.5L127 54L123.5 45.5L115 42L123.5 38.5Z" fill="{{ $isAdmin ? '#c99a4a' : '#7fb2f7' }}" fill-opacity="0.65"/>
                </g>
            </defs>
        </svg>
        {{-- Tiket besar, pojok kanan atas (utuh, sedikit miring) --}}
        <svg viewBox="0 0 150 84" class="absolute right-2 top-1 h-[68px] w-[122px] rotate-[8deg] overflow-visible opacity-25">
            <use href="#evTicket"/>
        </svg>
        {{-- Kode QR kaca --}}
        <svg viewBox="0 0 36 36" class="absolute right-4 top-[8.25rem] h-10 w-10 rotate-[8deg] overflow-visible opacity-[0.12]">
            <rect x="0.75" y="0.75" width="34.5" height="34.5" rx="9" fill="url(#evGlass)" stroke="url(#evEdge)" stroke-width="1.5" filter="url(#evShadow)"/>
            <rect x="7" y="7" width="9" height="9" rx="2.5" fill="none" stroke="{{ $isAdmin ? '#ad7a2c' : '#6b9fdc' }}" stroke-opacity="0.65" stroke-width="1.6"/>
            <rect x="10" y="10" width="3" height="3" rx="1" fill="{{ $isAdmin ? '#ad7a2c' : '#6b9fdc' }}" fill-opacity="0.65"/>
            <g fill="{{ $isAdmin ? '#ad7a2c' : '#6b9fdc' }}" fill-opacity="0.5">
                <rect x="21" y="7" width="4" height="4" rx="1.2"/><rect x="26" y="12" width="4" height="4" rx="1.2"/>
                <rect x="7" y="21" width="4" height="4" rx="1.2"/><rect x="13" y="26" width="4" height="4" rx="1.2"/>
                <rect x="21" y="21" width="4" height="4" rx="1.2"/><rect x="26" y="26" width="4" height="4" rx="1.2"/>
            </g>
        </svg>
        {{-- Lencana check-in (utuh, tidak terpotong) --}}
        <svg viewBox="0 0 40 40" class="absolute right-4 top-[54%] h-10 w-10 overflow-visible opacity-[0.3]">
            <circle cx="20" cy="20" r="18" fill="url(#evGlass)" stroke="url(#evEdge)" stroke-width="1.5" filter="url(#evShadow)"/>
            <path d="M12.5 20.5L18 26L28 14.5" fill="none" stroke="{{ $isAdmin ? '#ad7a2c' : '#6b9fdc' }}" stroke-opacity="0.8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{-- Tiket kecil di atas kartu profil --}}
        <svg viewBox="0 0 150 84" class="absolute right-3 bottom-[6.5rem] h-[43px] w-[76px] -rotate-[10deg] overflow-visible opacity-[0.8]">
            <use href="#evTicket"/>
        </svg>
        {{-- Sparkle --}}
        <svg viewBox="0 0 24 24" class="absolute right-6 top-[20rem] h-[18px] w-[18px] opacity-25"><path d="M12 1L14.6 9.4L23 12L14.6 14.6L12 23L9.4 14.6L1 12L9.4 9.4Z" fill="{{ $isAdmin ? '#e0bc72' : '#8dbcf9' }}" fill-opacity="0.7"/></svg>
        <svg viewBox="0 0 24 24" class="absolute right-7 bottom-[12.5rem] h-3.5 w-3.5 opacity-25"><path d="M12 1L14.6 9.4L23 12L14.6 14.6L12 23L9.4 14.6L1 12L9.4 9.4Z" fill="{{ $isAdmin ? '#e0bc72' : '#8dbcf9' }}" fill-opacity="0.7"/></svg>
        {{-- Konfeti kecil --}}
        <span class="absolute right-4 top-[15rem] h-1.5 w-3 rotate-[40deg] rounded-full {{ $isAdmin ? 'bg-[#e0bc72]/55' : 'bg-[#8dbcf9]/55' }} opacity-25"></span>
        <span class="absolute right-9 top-[26rem] h-1.5 w-1.5 rounded-full {{ $isAdmin ? 'bg-[#e0bc72]/70' : 'bg-sky-300/70' }} opacity-25"></span>
        <span class="absolute right-5 bottom-[10rem] h-1.5 w-3 -rotate-[30deg] rounded-full {{ $isAdmin ? 'bg-[#edcf8f]/55' : 'bg-indigo-300/55' }} opacity-25"></span>
        {{-- Noise halus (4%) supaya permukaan terasa bertekstur, tidak plastik --}}
        <svg class="absolute inset-0 h-full w-full opacity-[0.08]" xmlns="http://www.w3.org/2000/svg">
            <filter id="sidebarNoise">
                <feTurbulence type="fractalNoise" baseFrequency="0.8" numOctaves="2" stitchTiles="stitch"/>
                <feColorMatrix type="saturate" values="0"/>
            </filter>
            <rect width="100%" height="100%" filter="url(#sidebarNoise)"/>
        </svg>
    </div>
    {{-- Logo --}}
    <div class="flex h-16 shrink-0 items-center justify-between gap-3 px-5">
        <div class="flex min-w-0 items-center gap-2.5">
            <a href="/"
               class="shrink-0 rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500">
                <img src="{{ asset('assets/img/eventverse-color.png') }}"
                     alt="Eventverse dashboard"
                     class="h-7 w-auto">
            </a>
            @if (($environment ?? 'production') !== 'production')
                <span class="rounded-md bg-amber-50 px-1.5 py-0.5 text-[11px] font-semibold leading-4 text-amber-800 ring-1 ring-amber-300/70">Sandbox</span>
            @endif
        </div>
        <button type="button" x-ref="sidebarClose" @click="closeSidebar()"
                aria-label="Tutup menu"
                class="grid h-11 w-11 shrink-0 place-items-center rounded-lg text-lg text-zinc-600 hover:bg-white hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-zinc-500 lg:hidden">
            <i class="ti ti-x" aria-hidden="true"></i>
        </button>
    </div>
    {{-- Menu --}}
    <nav aria-label="Menu utama"
         class="min-h-0 flex-1 space-y-6 overflow-y-auto overscroll-contain px-3 pb-6 pt-3 [scrollbar-color:#d4d4d8_transparent] [scrollbar-width:thin]">
        @foreach (array_filter($menu) as $group => $items)
            <div>
                {{-- Label grup + garis tipis: memberi struktur di atas pola titik. --}}
                <div class="mb-2 flex items-center gap-2 px-3">
                    <p class="text-xs font-medium leading-4 text-zinc-600">{{ $group }}</p>
                    <span aria-hidden="true" class="h-px flex-1 bg-zinc-300/60"></span>
                </div>
                <ul class="space-y-1">
                    @foreach ($items as $item)
                        @php
                            [$label, $path, $icon] = $item;
                            $current = request()->is($item[3] ?? $path);
                        @endphp
                        <li>
                            <a href="{{ url($path) }}"
                               @if ($current) aria-current="page" @endif
                               @class([
                                   ($isAdmin ? 'group relative flex min-h-11 items-center gap-3 rounded-xl py-1.5 pl-1.5 pr-3 text-[13px] leading-5 tracking-[-0.01em] ring-1 transition-[background-color,box-shadow,color] duration-150 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-[#b78728] lg:min-h-10' : 'group relative flex min-h-11 items-center gap-3 rounded-xl py-1.5 pl-1.5 pr-3 text-[13px] leading-5 tracking-[-0.01em] ring-1 transition-[background-color,box-shadow,color] duration-150 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-[#2282ff] lg:min-h-10'),
                                   // Aktif: kartu putih "terangkat" dengan cahaya biru tipis di bawahnya.
                                   ($isAdmin ? 'bg-white font-semibold text-zinc-950 ring-[#b78728]/25 shadow-[0_1px_2px_rgba(15,23,42,0.06),0_8px_16px_-8px_rgba(183,135,40,0.4)]' : 'bg-white font-semibold text-zinc-950 ring-[#2282ff]/25 shadow-[0_1px_2px_rgba(15,23,42,0.06),0_8px_16px_-8px_rgba(34,130,255,0.4)]') => $current,
                                   'ring-transparent font-medium text-zinc-700 hover:bg-white/80 hover:text-zinc-950 hover:ring-zinc-200/80' => !$current,
                               ])>
                                <span @class([
                                    'grid h-7 w-7 shrink-0 place-items-center rounded-lg text-[15px] transition-colors duration-150',
                                    ($isAdmin ? 'bg-gradient-to-b from-[#9b6716] to-[#70470c] text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_2px_6px_-1px_rgba(112,71,12,0.55)]' : 'bg-gradient-to-b from-[#2f8bff] to-[#1765c4] text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_2px_6px_-1px_rgba(23,101,196,0.55)]') => $current,
                                    ($isAdmin ? 'bg-white text-zinc-500 ring-1 ring-zinc-200/80 shadow-[0_1px_1.5px_rgba(15,23,42,0.06)] group-hover:text-[#70470c] group-hover:ring-[#b78728]/30' : 'bg-white text-zinc-500 ring-1 ring-zinc-200/80 shadow-[0_1px_1.5px_rgba(15,23,42,0.06)] group-hover:text-[#1765c4] group-hover:ring-[#2282ff]/30') => !$current,
                                ])>
                                    <i aria-hidden="true" class="ti {{ $icon }} leading-none"></i>
                                </span>
                                <span class="min-w-0 break-words">{{ $label }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>
    {{-- Profil --}}
    <div class="relative shrink-0 px-3 pt-2 pb-[max(0.75rem,env(safe-area-inset-bottom))]">
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-6 h-6 bg-gradient-to-t {{ $isAdmin ? 'from-[#faf3e3]/90' : 'from-[#eef3f9]/90' }} to-transparent"></div>
        <div class="flex items-center gap-3 rounded-xl bg-white p-2.5 ring-1 ring-zinc-200/80 shadow-[0_1px_2px_rgba(15,23,42,0.05),0_12px_24px_-16px_rgba(15,23,42,0.3)]">
            <img src="{{ $profileUrl }}" alt=""
                 class="h-9 w-9 shrink-0 rounded-full bg-zinc-100 object-cover ring-2 ring-white shadow-[0_0_0_1px_rgba(15,23,42,0.1)]">
            <div class="min-w-0 flex-1">
                <p class="truncate text-[13px] font-semibold leading-5 tracking-[-0.01em]">{{ $user->name }}</p>
                <p class="truncate text-xs leading-4 text-zinc-500">{{ $roleLabel }}</p>
            </div>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" aria-label="Keluar" title="Keluar"
                        class="grid h-11 w-11 place-items-center rounded-lg text-base text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-zinc-500 lg:h-9 lg:w-9">
                    <i class="ti ti-logout" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
