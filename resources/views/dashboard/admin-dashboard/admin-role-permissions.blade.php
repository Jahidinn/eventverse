@extends('dashboard.layouts.app')

@section('title', 'Permission ' . $role->name)

@section('content')
    @php
        $groups = [
            'Platform' => [
                'platform.view' => 'Lihat overview platform',
                'payments.view' => 'Lihat pembayaran',
                'withdrawals.manage' => 'Kelola penarikan',
                'events.manage' => 'Kelola event platform',
                'users.manage' => 'Kelola pengguna',
                'roles.manage' => 'Kelola peran dan izin',
                'audit.view' => 'Lihat audit log',
            ],
            'Content' => [
                'articles.manage' => 'Kelola semua artikel dan kategori',
                'articles.create' => 'Buat artikel sendiri',
            ],
            'Organizer' => [
                'event-studio.access' => 'Akses Event Studio',
                'participants.manage' => 'Kelola peserta event sendiri',
                'finance.view' => 'Lihat keuangan event sendiri',
                'checkin.manage' => 'Kelola check-in',
            ],
            'Participant' => [
                'my-event.view' => 'Akses My Event',
                'organization.manage' => 'Kelola organisasi',
                'profile.manage' => 'Kelola profil',
            ],
        ];

        $registered = array_fill_keys($permissions->pluck('name')->all(), true);
        $visibleGroups = [];

        foreach ($groups as $group => $items) {
            $available = array_intersect_key($items, $registered);

            if ($available !== []) {
                $visibleGroups[$group] = $available;
            }
        }

        $isAdminRole = $role->name === 'admin';
        $button = 'inline-flex min-h-10 items-center justify-center gap-2 rounded-lg px-3 text-[13px] font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
    @endphp

    <div class="mx-auto max-w-6xl space-y-5 pb-8 font-['Inter',sans-serif] text-slate-900">
        <header class="border-b border-slate-200 pb-5">
            <a href="{{ url('/administrator/roles') }}"
               class="inline-flex min-h-9 items-center gap-1.5 rounded-md text-[13px] font-medium text-slate-600 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                <i class="ti ti-arrow-left text-base" aria-hidden="true"></i>
                Roles &amp; Permissions
            </a>

            <div class="mt-2 flex flex-wrap items-center gap-2.5">
                <h1 class="text-2xl font-semibold leading-tight tracking-tight sm:text-[28px]">
                    Izin peran <span class="capitalize">{{ $role->name }}</span>
                </h1>
                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium tabular-nums text-slate-600">
                    {{ number_format($role->users_count, 0, ',', '.') }} pengguna
                </span>
            </div>

            <p class="mt-1.5 text-[13px] leading-5 text-slate-600">
                Pilih akses yang diberikan kepada pengguna dengan peran ini.
            </p>
        </header>

        <form method="POST" action="{{ route('administrator.roles.permissions.update', $role) }}"
              class="rounded-2xl border border-slate-200 bg-white">
            @csrf
            @method('PUT')

            @if ($isAdminRole)
                <input type="hidden" name="permissions[]" value="roles.manage">
            @endif

            <div class="grid md:grid-cols-[13rem_minmax(0,1fr)]">
                <nav aria-label="Grup izin"
                     class="rounded-t-2xl border-b border-slate-200 bg-slate-50/80 p-3 md:rounded-tr-none md:border-b-0 md:border-r md:p-4">
                    <h2 class="px-2 pb-2 text-xs font-semibold text-slate-700">Grup izin</h2>

                    <ul class="flex flex-wrap gap-1 md:flex-col">
                        @foreach ($visibleGroups as $group => $items)
                            <li>
                                <a href="#permission-{{ strtolower($group) }}"
                                   class="flex min-h-9 items-center justify-between gap-3 rounded-lg px-2.5 text-[13px] text-slate-700 hover:bg-white hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                    <span>{{ $group }}</span>
                                    <span class="text-xs tabular-nums text-slate-500">{{ count($items) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="min-w-0 divide-y divide-slate-100">
                    @forelse ($visibleGroups as $group => $items)
                        <section id="permission-{{ strtolower($group) }}"
                                 aria-labelledby="permission-title-{{ strtolower($group) }}"
                                 class="scroll-mt-20 px-4 py-4 sm:px-6">
                            <h2 id="permission-title-{{ strtolower($group) }}"
                                class="mb-2 text-sm font-semibold text-slate-950">
                                {{ $group }}
                            </h2>

                            <div class="divide-y divide-slate-100 overflow-hidden rounded-xl border border-slate-200">
                                @foreach ($items as $name => $label)
                                    @php
                                        $locked = $isAdminRole && $name === 'roles.manage';
                                    @endphp

                                    <label @class([
                                        'flex min-h-14 items-center justify-between gap-3 px-3 py-2.5 sm:px-4',
                                        'cursor-pointer transition-colors hover:bg-slate-50' => !$locked,
                                        'bg-slate-50' => $locked,
                                    ])>
                                        <span class="min-w-0">
                                            <span class="block text-[13px] font-medium leading-5 text-slate-900">{{ $label }}</span>
                                            <span class="block break-all font-mono text-xs leading-5 text-slate-600">{{ $name }}</span>
                                        </span>

                                        <span class="flex shrink-0 items-center gap-2">
                                            @if ($locked)
                                                <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-600">
                                                    <i class="ti ti-lock" aria-hidden="true"></i> Wajib
                                                </span>
                                            @endif

                                            <input type="checkbox" name="permissions[]" value="{{ $name }}"
                                                   @checked($locked || in_array($name, $assigned, true))
                                                   @disabled($locked)
                                                   class="h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </section>
                    @empty
                        <p class="px-4 py-10 text-center text-[13px] text-slate-600">
                            Belum ada izin yang tersedia untuk diatur.
                        </p>
                    @endforelse
                </div>
            </div>

            <footer class="sticky bottom-0 z-10 flex flex-wrap justify-end gap-2 rounded-b-2xl border-t border-slate-200 bg-white/95 px-4 py-3 backdrop-blur sm:px-6">
                <a href="{{ url('/administrator/roles') }}"
                   class="{{ $button }} border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" @disabled($visibleGroups === [])
                        class="{{ $button }} bg-[#1765c4] text-white hover:bg-[#174f9e] disabled:cursor-not-allowed disabled:opacity-50">
                    <i class="ti ti-check text-base" aria-hidden="true"></i>
                    Simpan izin
                </button>
            </footer>
        </form>
    </div>
@endsection