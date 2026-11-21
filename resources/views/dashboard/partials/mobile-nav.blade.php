{{-- resources/views/dashboard/partials/mobile-nav.blade.php --}}
@if ($showQuickNav)
    @php
        // Format: [label, path, ikon Tabler, pola aktif].
        $quickItems = [
            ['Event Management', 'dashboard/manajemen-event', 'ti-calendar-event', ['dashboard/manajemen-event*']],
            ['My Event', 'dashboard/myevent', 'ti-ticket', ['dashboard/myevent*']],
        ];
    @endphp

    {{-- Pill melayang di dasar layar: kaca buram, tepi putih tipis, bayangan berlapis. --}}
    <nav aria-label="Menu cepat organizer"
         class="fixed inset-x-3 bottom-[max(0.75rem,env(safe-area-inset-bottom))] z-30 mx-auto max-w-md font-['Sora','Inter',sans-serif] lg:hidden">
        <ul class="grid grid-cols-2 gap-1 rounded-[1.75rem] bg-white/80 p-1.5 ring-1 ring-zinc-200/80 backdrop-blur-xl shadow-[inset_0_1px_0_rgba(255,255,255,0.9),0_2px_6px_rgba(15,23,42,0.06),0_16px_32px_-12px_rgba(15,23,42,0.3)]">
            @foreach ($quickItems as [$label, $path, $icon, $patterns])
                @php $current = $active($patterns); @endphp

                <li>
                    <a href="{{ url($path) }}"
                       @if ($current) aria-current="page" @endif
                       @class([
                           'flex min-h-[3.25rem] flex-col items-center justify-center gap-0.5 rounded-[1.375rem] px-2 py-1.5 text-[11px] leading-4 tracking-[-0.01em] transition-[background-color,box-shadow,color] duration-150 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#2282ff] motion-safe:active:scale-[0.97]',
                           // Aktif: kapsul biru bergradasi dengan highlight tipis di tepi atas.
                           'bg-gradient-to-b from-[#1d76e8] to-[#1457b0] font-semibold text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_8px_16px_-8px_rgba(23,101,196,0.7)]' => $current,
                           'font-medium text-zinc-600 hover:bg-white/70 hover:text-zinc-950' => !$current,
                       ])>
                        <i aria-hidden="true" class="ti {{ $icon }} text-[22px] leading-none"></i>
                        <span class="max-w-full truncate">{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif