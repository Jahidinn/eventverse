@props(['label', 'value', 'icon', 'sub' => null, 'tone' => '', 'money' => false])

@php
    $accent = match ($tone) {
        'is-sky' => 'bg-sky-50 text-sky-700',
        'is-green' => 'bg-emerald-50 text-emerald-700',
        'is-amber' => 'bg-amber-50 text-amber-700',
        'is-violet' => 'bg-violet-50 text-violet-700',
        'is-cyan' => 'bg-cyan-50 text-cyan-700',
        default => 'bg-blue-50 text-blue-700',
    };
@endphp

<x-card class="flex h-full flex-col p-4 sm:p-5">
    <div class="flex items-start justify-between gap-3">
        <p class="pt-1 text-sm font-medium text-slate-600">{{ $label }}</p>
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-xl {{ $accent }}" aria-hidden="true">
            <i class="ti {{ $icon }}"></i>
        </span>
    </div>
    <p @class([
        'mt-3 break-words font-semibold leading-tight tracking-tight text-slate-950 tabular-nums',
        'text-xl sm:text-2xl' => $money,
        'text-2xl sm:text-3xl' => !$money,
    ])>{{ $value }}</p>
    @if ($sub !== null && $sub !== '')
        <p class="mt-2 text-xs leading-5 text-slate-600">{{ $sub }}</p>
    @endif
</x-card>
