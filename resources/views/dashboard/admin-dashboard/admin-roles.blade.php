@extends('dashboard.layouts.app')

@section('title', 'Roles & Permissions')

@section('content')
    @php
        $roleMeta = [
            'admin' => ['ti-shield-lock', 'Mengelola platform, pembayaran, event, akun, dan peran.'],
            'organizer' => ['ti-calendar-event', 'Mengelola event sendiri, peserta, check-in, dan keuangan.'],
            'participant' => ['ti-ticket', 'Membeli tiket dan mengakses My Event, organisasi, dan profil.'],
        ];
        $roleNames = ['admin' => 'Admin', 'organizer' => 'Organizer', 'participant' => 'Participant'];
        $number = static fn ($value) => number_format($value, 0, ',', '.');
        $action = 'inline-flex min-h-10 items-center justify-center gap-2 rounded-lg px-3 text-[13px] font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
    @endphp

    <div class="mx-auto max-w-6xl space-y-5 pb-8 font-['Inter',sans-serif] text-slate-900">
        <header class="flex flex-wrap items-end justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-semibold leading-tight tracking-tight sm:text-[28px]">Roles &amp; Permissions</h1>
                <p class="mt-1.5 text-[13px] leading-5 text-slate-600">Kelola izin dan tinjau cakupan akses setiap peran.</p>
            </div>
            <a href="{{ url('/administrator/users') }}" class="{{ $action }} border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                <i class="ti ti-users text-base text-slate-500" aria-hidden="true"></i> Kelola pengguna
            </a>
        </header>

        <section aria-labelledby="rolesTitle" x-data="{ active: 0 }"
                 class="overflow-hidden rounded-2xl border border-slate-200 bg-white [&_[x-cloak]]:hidden">
            <div class="grid md:grid-cols-[14rem_minmax(0,1fr)] xl:grid-cols-[16rem_minmax(0,1fr)]">
                <div class="border-b border-slate-200 bg-slate-50/70 p-3 md:border-b-0 md:border-r md:p-4">
                    <div class="mb-2 flex items-center justify-between gap-2 px-2">
                        <h2 id="rolesTitle" class="text-xs font-semibold text-slate-700">Peran</h2>
                        <span class="text-xs tabular-nums text-slate-500">{{ $number($roles->count()) }}</span>
                    </div>
                    <nav aria-label="Pilih peran" class="grid grid-cols-2 gap-1 sm:grid-cols-3 md:grid-cols-1">
                        @foreach ($roles as $role)
                            @php [$roleIcon] = $roleMeta[$role->name] ?? ['ti-user']; @endphp
                            <button type="button"
                                    aria-controls="role-panel-{{ $loop->index }}"
                                    aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                                    x-bind:aria-pressed="(active === {{ $loop->index }}).toString()"
                                    x-on:click="active = {{ $loop->index }}"
                                    class="flex min-h-11 min-w-0 items-center gap-2 rounded-lg border border-transparent px-2.5 py-2 text-left text-[13px] text-slate-600 transition-colors hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 aria-pressed:border-slate-200 aria-pressed:bg-white aria-pressed:font-semibold aria-pressed:text-blue-800">
                                <i class="ti {{ $roleIcon }} shrink-0 text-base" aria-hidden="true"></i>
                                <span class="min-w-0 flex-1 break-words capitalize">{{ $role->name }}</span>
                                <span class="text-xs font-medium tabular-nums text-slate-500">{{ $number($role->users_count) }}</span>
                            </button>
                        @endforeach
                    </nav>
                </div>

                <div class="min-w-0">
                    @forelse ($roles as $role)
                        @php
                            [$icon, $description] = $roleMeta[$role->name] ?? ['ti-user', 'Peran tambahan.'];
                        @endphp
                        <section id="role-panel-{{ $loop->index }}" aria-labelledby="role-name-{{ $loop->index }}"
                                 x-show="active === {{ $loop->index }}" @if (!$loop->first) x-cloak @endif>
                            <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-start gap-3">
                                        <span aria-hidden="true" class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-blue-50 text-lg text-blue-800"><i class="ti {{ $icon }}"></i></span>
                                        <div class="min-w-0">
                                            <h3 id="role-name-{{ $loop->index }}" class="break-words text-lg font-semibold leading-6 tracking-tight capitalize text-slate-950">{{ $role->name }}</h3>
                                            <p class="mt-1 text-[13px] leading-5 text-slate-600">{{ $description }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('administrator.roles.permissions', $role) }}"
                                       class="{{ $action }} bg-[#1765c4] text-white hover:bg-[#174f9e]">
                                        Kelola izin <i class="ti ti-arrow-right text-sm" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-4 py-3 sm:px-6">
                                <p class="text-[13px] text-slate-600"><strong class="font-semibold tabular-nums text-slate-950">{{ $number($role->users_count) }}</strong> pengguna dengan peran ini</p>
                                <a href="{{ url('/administrator/users') }}?{{ http_build_query(['role' => $role->name]) }}"
                                   class="{{ $action }} border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                                    Lihat pengguna <i class="ti ti-arrow-up-right text-sm" aria-hidden="true"></i>
                                </a>
                            </div>

                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-sm font-semibold text-slate-900">Izin yang diberikan</h4>
                                    <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium tabular-nums text-slate-600">{{ $number($role->permissions->count()) }} izin</span>
                                </div>
                                @if ($role->permissions->isNotEmpty())
                                    <ul class="mt-3 divide-y divide-slate-100 rounded-xl border border-slate-200">
                                        @foreach ($role->permissions as $permission)
                                            <li class="flex items-start gap-2 px-3 py-2.5">
                                                <i class="ti ti-check mt-0.5 shrink-0 text-emerald-700" aria-hidden="true"></i>
                                                <span class="min-w-0 break-all font-mono text-xs leading-5 text-slate-700">{{ $permission->name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mt-3 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-3 py-3 text-[13px] leading-5 text-slate-600">Belum ada izin granular yang diberikan untuk peran ini.</p>
                                @endif
                            </div>
                        </section>
                    @empty
                        <p class="px-5 py-10 text-center text-[13px] text-slate-600">Belum ada peran terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <details class="group overflow-hidden rounded-xl border border-slate-200 bg-white">
            <summary class="flex min-h-12 cursor-pointer list-none items-center justify-between gap-3 px-4 py-3 text-[13px] font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 [&::-webkit-details-marker]:hidden">
                Referensi akses dan izin platform
                <i class="ti ti-chevron-down text-slate-500 group-open:rotate-180" aria-hidden="true"></i>
            </summary>
            <div class="grid items-start gap-4 border-t border-slate-200 bg-slate-50 p-3 sm:p-4 xl:grid-cols-[minmax(0,3fr)_minmax(0,2fr)]">
                <section aria-labelledby="capabilitiesTitle" class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-4 py-3.5">
                        <h2 id="capabilitiesTitle" class="text-sm font-semibold">Cakupan akses peran</h2>
                        <p class="mt-1 text-xs text-slate-600">Akses yang dipakai dashboard saat ini.</p>
                    </div>

                    <div class="overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-blue-600"
                         tabindex="0" role="region" aria-label="Matriks akses peran">
                        <table class="w-full min-w-[23rem] text-left text-xs [&_td]:border-t [&_td]:border-slate-100 [&_td]:px-2.5 [&_td]:py-2 [&_th]:px-2.5 [&_th]:py-2.5">
                            <thead class="bg-slate-50 text-xs text-slate-600">
                                <tr>
                                    <th scope="col">Akses</th>
                                    @foreach ($roleNames as $name)
                                        <th scope="col" class="whitespace-nowrap text-center">{{ $name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($capabilities as $capability)
                                    <tr class="even:bg-slate-50/60 hover:bg-blue-50/60">
                                        <th scope="row" class="border-t border-slate-100 font-medium text-slate-800">{{ $capability['label'] }}</th>
                                        @foreach ($roleNames as $key => $name)
                                            @php $allowed = $capability[$key]; @endphp
                                            <td class="text-center">
                                                <span class="inline-grid h-5 w-5 place-items-center rounded-full {{ $allowed ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                                    <i class="ti {{ $allowed ? 'ti-check' : 'ti-minus' }}" aria-hidden="true"></i>
                                                    <span class="sr-only">{{ $allowed ? 'Diizinkan' : 'Tidak diizinkan' }}</span>
                                                </span>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section aria-labelledby="permissionsTitle" class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                    <div class="flex flex-wrap items-baseline justify-between gap-2 border-b border-slate-200 px-4 py-3.5">
                        <h2 id="permissionsTitle" class="text-sm font-semibold">Izin granular Spatie</h2>
                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium tabular-nums text-slate-600">{{ $number($permissions->count()) }} izin</span>
                    </div>

                    @if ($permissions->isEmpty())
                        <div class="flex items-start gap-2 p-4 text-xs leading-5 text-slate-600">
                            <i class="ti ti-info-circle shrink-0 text-base text-blue-700" aria-hidden="true"></i>
                            <p>Belum ada izin granular terdaftar. Akses saat ini mengikuti peran dan policy aplikasi.</p>
                        </div>
                    @else
                        <ul class="divide-y divide-slate-100">
                            @foreach ($permissions as $permission)
                                <li class="flex items-start justify-between gap-3 px-4 py-2.5">
                                    <span class="min-w-0 break-all font-mono text-xs text-slate-800">{{ $permission->name }}</span>
                                    <span class="shrink-0 rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">{{ $permission->guard_name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            </div>
        </details>
    </div>
@endsection
