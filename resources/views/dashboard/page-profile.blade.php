@extends('dashboard.layouts.app')

@section('title', 'Profile')

@section('content')
    @php
        $user = auth()->user();
        $photoPath = $user->profile_picture ? 'storage/profile-images/' . $user->profile_picture : null;
        $photoUrl = $photoPath && file_exists(public_path($photoPath))
            ? asset($photoPath)
            : asset('assets/default-img/profile-images/default-user.jpg');
        $isOrganizer = $user->hasRole('organizer');
        $isParticipant = $user->hasRole('participant');
        $accountMode = $isOrganizer && $isParticipant ? 'hybrid' : ($isOrganizer ? 'organizer' : 'participant');
        $roleLabel = $user->hasRole('admin')
            ? 'Administrator'
            : ($accountMode === 'hybrid' ? 'Hybrid' : ($isOrganizer ? 'Organizer' : 'Participant'));
    @endphp

    <div class="mx-auto max-w-6xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Profil</h1>
                <p class="mt-2 text-sm leading-6 text-blue-100">Kelola identitas, keamanan akun, dan rekening penarikan.</p>
            </div>
            <button type="button" id="openEditProfile" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-user-edit text-base" aria-hidden="true"></i> Edit profil
            </button>
        </header>

        <section aria-label="Ringkasan akun" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center gap-4 bg-gradient-to-br from-white via-white to-blue-50/70 p-4 sm:p-6">
                <div class="relative grid h-[72px] w-[72px] shrink-0 place-items-center overflow-hidden rounded-2xl bg-blue-100 text-2xl text-blue-700 ring-1 ring-blue-100">
                    <i class="ti ti-user" aria-hidden="true"></i>
                    <img id="profilePhoto" src="{{ $photoUrl }}" alt="{{ $user->name }}"
                         class="absolute inset-0 h-full w-full object-cover" onerror="this.hidden = true">
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="break-words font-['Sora','Inter',sans-serif] text-lg font-semibold tracking-tight sm:text-xl">{{ $user->name }}</h2>
                    <p class="mt-0.5 break-all text-sm text-slate-600">{{ $user->email }}</p>
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-800">{{ $roleLabel }}</span>
                        @if ($user->email_verified_at)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800"><i class="ti ti-mail-check" aria-hidden="true"></i> Email terverifikasi</span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-900"><i class="ti ti-mail" aria-hidden="true"></i> Email belum terverifikasi</span>
                        @endif
                    </div>
                </div>
                <div class="flex w-full flex-wrap items-center gap-2 sm:w-auto">
                    <button id="chooseProfilePhoto" type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100" aria-describedby="profilePhotoHint">
                        <i class="ti ti-camera" aria-hidden="true"></i> Ganti foto
                    </button>
                    <input id="profilePhotoInput" type="file" class="hidden" accept="image/jpeg,image/png">
                    <p id="profilePhotoHint" class="text-xs text-slate-600">JPG/PNG, maks. 616 KB</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-4 py-3 sm:px-6">
                <p class="text-xs text-slate-600">Terakhir diperbarui {{ $user->updated_at?->diffForHumans() ?? '—' }}</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100" id="openEditPassword"><i class="ti ti-lock" aria-hidden="true"></i> Ubah kata sandi</button>
                    <a href="/dashboard/organization" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100"><i class="ti ti-users-group" aria-hidden="true"></i> Organisasi</a>
                </div>
            </div>
            <p id="profilePhotoStatus" role="status" class="hidden border-t px-4 py-3 text-sm sm:px-6"></p>
        </section>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-6">
                <div>
                    <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Mode akun</h2>
                    <p class="mt-1 text-sm leading-5 text-slate-600">Pilih bagaimana kamu memakai Eventverse.</p>
                </div>
                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-800">{{ ucfirst($accountMode) }}</span>
            </div>
            <form method="POST" action="/dashboard/account-mode">
                @csrf
                <div class="space-y-4 px-4 py-4 sm:px-6">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <label class="flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:border-blue-200 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50/60">
                            <input type="radio" name="mode" value="participant" class="mt-1 h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600" @checked($accountMode === 'participant')>
                            <span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-[#dcfce7] px-2 py-1 text-xs font-semibold text-[#15803d]"><i class="ti ti-ticket"></i> Participant</span>
                                <span class="mt-1 block text-xs leading-5 text-slate-600">Ikut event dan akses My Event.</span>
                            </span>
                        </label>
                        <label class="flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:border-blue-200 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50/60">
                            <input type="radio" name="mode" value="organizer" class="mt-1 h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600" @checked($accountMode === 'organizer')>
                            <span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-[#dbeafe] px-2 py-1 text-xs font-semibold text-[#1d4ed8]"><i class="ti ti-calendar-event"></i> Organizer only</span>
                                <span class="mt-1 block text-xs leading-5 text-slate-600">Fokus mengelola event lewat Event Studio.</span>
                            </span>
                        </label>
                        <label class="flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:border-blue-200 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50/60">
                            <input type="radio" name="mode" value="hybrid" class="mt-1 h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600" @checked($accountMode === 'hybrid')>
                            <span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-[#f3e8ff] px-2 py-1 text-xs font-semibold text-[#7c3aed]"><i class="ti ti-switch-horizontal"></i> Hybrid</span>
                                <span class="mt-1 block text-xs leading-5 text-slate-600">Bisa membuat event sekaligus membeli tiket.</span>
                            </span>
                        </label>
                    </div>
                    @if ($user->hasRole('admin'))
                        <p class="mt-2 text-xs text-slate-600"><i class="ti ti-shield-lock"></i> Role admin tetap dipertahankan saat mode diubah.</p>
                    @endif
                </div>
                <div class="flex justify-end border-t border-slate-100 bg-slate-50 px-4 py-3 sm:px-6">
                    <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e]"><i class="ti ti-check"></i> Simpan mode akun</button>
                </div>
            </form>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-6">
                    <div>
                        <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Informasi akun</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Data yang dipakai untuk identitas dan komunikasi.</p>
                    </div>
                </div>
                <div class="space-y-4 px-4 py-4 sm:px-6">
                    <div class="[&>h4]:mb-2 [&>h4]:text-xs [&>h4]:font-semibold [&>h4]:text-slate-600">
                        <h4>Identitas</h4>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Username</span><strong><span>@</span>{{ $user->username }}</strong></div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Nama lengkap</span><strong>{{ $user->name }}</strong></div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Email</span><strong>{{ $user->email }}</strong></div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>No. telepon</span><strong>{{ $user->no_tlp ?: '—' }}</strong></div>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-6">
                    <div>
                        <h2 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Rekening penarikan</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Dipakai saat organizer mengajukan penarikan dana.</p>
                    </div>
                    <button type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100" id="openEditBank">
                        <i class="ti ti-pencil"></i> Ubah
                    </button>
                </div>
                <div class="space-y-4 px-4 py-4 sm:px-6">
                    <div class="[&>h4]:mb-2 [&>h4]:text-xs [&>h4]:font-semibold [&>h4]:text-slate-600">
                        <h4>Bank tujuan</h4>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Bank</span><strong>{{ $user->bank ?: 'Belum diisi' }}</strong></div>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950"><span>Nomor rekening</span><strong>{{ $user->no_rekening ?: 'Belum diisi' }}</strong></div>
                    </div>

                    @if ($org->isNotEmpty())
                        <div class="[&>h4]:mb-2 [&>h4]:text-xs [&>h4]:font-semibold [&>h4]:text-slate-600">
                            <h4>Organisasi</h4>
                            @foreach ($org as $membership)
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-950">
                                    <span>{{ $membership->org?->org_name ?? 'Organisasi' }}</span>
                                    <strong>{{ $membership->position }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>

    </div>

    <dialog id="profileDrawer" aria-labelledby="profileDrawerTitle"
            class="fixed inset-y-0 left-auto right-0 m-0 h-dvh max-h-none w-full max-w-md overflow-y-auto overscroll-contain border-0 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white px-5 py-4">
            <div>
                <h2 id="profileDrawerTitle" class="font-['Sora','Inter',sans-serif] text-lg font-semibold tracking-tight">Edit profil</h2>
                <p id="profileDrawerSub" class="mt-1 text-sm text-slate-600">Perbarui data akun.</p>
            </div>
            <form method="dialog">
                <button type="submit" autofocus aria-label="Tutup" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                    <i class="ti ti-x" aria-hidden="true"></i>
                </button>
            </form>
        </div>
        <div id="profileDrawerBody" class="p-5"></div>
    </dialog>

    @push('scripts')
        <script>
            (function () {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const drawer = document.getElementById('profileDrawer');
                const title = document.getElementById('profileDrawerTitle');
                const subtitle = document.getElementById('profileDrawerSub');
                const body = document.getElementById('profileDrawerBody');
                const photo = document.getElementById('profilePhoto');
                const input = document.getElementById('profilePhotoInput');

                const open = function (heading, sub) {
                    title.textContent = heading;
                    subtitle.textContent = sub || '';
                    if (!drawer.open) drawer.showModal();
                };

                const request = async function (url, formData) {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: formData,
                    });
                    return response.json();
                };

                const profileForm = function (mode) {
                    const bankOnly = mode === 'bank';
                    title.textContent = bankOnly ? 'Ubah rekening' : 'Edit profil';
                    subtitle.textContent = bankOnly ? 'Rekening tujuan withdrawal.' : 'Perbarui identitas dan kontak.';

                    body.innerHTML = `
                        <div class="mb-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="p_username">Username</label>
                            <input id="p_username" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" value="${esc(@json($user->username))}" readonly>
                        </div>
                        ${bankOnly ? '' : `
                            <div class="mb-3">
                                <label class="mb-1 block text-sm font-semibold text-slate-700" for="p_name">Nama lengkap</label>
                                <input id="p_name" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" value="${esc(@json($user->name))}">
                            </div>
                            <div class="mb-3">
                                <label class="mb-1 block text-sm font-semibold text-slate-700" for="p_email">Email</label>
                                <input id="p_email" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" type="email" autocomplete="email" value="${esc(@json($user->email))}">
                            </div>
                            <div class="mb-3">
                                <label class="mb-1 block text-sm font-semibold text-slate-700" for="p_no_tlp">No. telepon</label>
                                <input id="p_no_tlp" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" type="tel" autocomplete="tel" value="${esc(@json($user->no_tlp))}">
                            </div>
                        `}
                        <div class="mb-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="p_bank">Bank</label>
                            <input id="p_bank" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" value="${esc(@json($user->bank))}" placeholder="BCA / BRI / ...">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="p_no_rekening">Nomor rekening</label>
                            <input id="p_no_rekening" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" value="${esc(@json($user->no_rekening))}" inputmode="numeric">
                        </div>
                        <div id="profileError" role="alert" class="mb-2 hidden rounded-lg bg-rose-50 px-3 py-2 text-sm font-medium text-rose-800"></div>
                        <button id="saveProfile" type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] w-full justify-center">
                            <i class="ti ti-check"></i> Simpan perubahan
                        </button>
                    `;

                    document.getElementById('saveProfile').addEventListener('click', async function () {
                        const error = document.getElementById('profileError');
                        const button = this;
                        const data = new FormData();
                        data.append('p_username', document.getElementById('p_username').value);
                        data.append('p_name', bankOnly ? @json($user->name) : document.getElementById('p_name').value);
                        data.append('p_email', bankOnly ? @json($user->email) : document.getElementById('p_email').value);
                        data.append('p_no_tlp', bankOnly ? @json($user->no_tlp) : document.getElementById('p_no_tlp').value);
                        data.append('p_bank', document.getElementById('p_bank').value);
                        data.append('p_no_rekening', document.getElementById('p_no_rekening').value);

                        error.classList.add('hidden');
                        button.disabled = true;

                        try {
                            const payload = await request('/dashboard/edit-profile-process', data);
                            if (payload.success) {
                                window.location.reload();
                                return;
                            }
                            error.textContent = payload.error || 'Gagal menyimpan.';
                            error.classList.remove('hidden');
                        } catch (e) {
                            error.textContent = 'Gagal menyimpan. Coba lagi.';
                            error.classList.remove('hidden');
                        }
                        button.disabled = false;
                    });
                };

                const passwordForm = function () {
                    title.textContent = 'Ubah password';
                    subtitle.textContent = 'Gunakan password lama sebagai konfirmasi.';
                    body.innerHTML = `
                        <div class="mb-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="oldPassword">Password lama</label>
                            <input id="oldPassword" type="password" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" autocomplete="current-password">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="newPassword">Password baru</label>
                            <input id="newPassword" type="password" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700" for="confirmPassword">Konfirmasi password</label>
                            <input id="confirmPassword" type="password" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 read-only:text-slate-600" autocomplete="new-password">
                        </div>
                        <div id="passwordError" role="alert" class="mb-2 hidden rounded-lg bg-rose-50 px-3 py-2 text-sm font-medium text-rose-800"></div>
                        <button id="savePassword" type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] w-full justify-center">
                            <i class="ti ti-lock"></i> Simpan password
                        </button>
                    `;

                    document.getElementById('savePassword').addEventListener('click', async function () {
                        const error = document.getElementById('passwordError');
                        const button = this;
                        const data = new FormData();
                        data.append('oldPassword', document.getElementById('oldPassword').value);
                        data.append('newPassword', document.getElementById('newPassword').value);
                        data.append('newPasswordConfirm', document.getElementById('confirmPassword').value);

                        error.classList.add('hidden');
                        button.disabled = true;

                        try {
                            const payload = await request('/dashboard/edit-password', data);
                            if (payload.success) {
                                window.location.reload();
                                return;
                            }
                            error.textContent = payload.error || 'Gagal mengubah password.';
                            error.classList.remove('hidden');
                        } catch (e) {
                            error.textContent = 'Gagal mengubah password.';
                            error.classList.remove('hidden');
                        }
                        button.disabled = false;
                    });
                };

                const esc = function (value) {
                    const div = document.createElement('div');
                    div.textContent = value == null ? '' : String(value);
                    return div.innerHTML.replace(/"/g, '&quot;');
                };

                document.getElementById('openEditProfile').addEventListener('click', function () {
                    open('Edit profil', 'Perbarui identitas dan kontak.');
                    profileForm('profile');
                });
                document.getElementById('openEditBank').addEventListener('click', function () {
                    open('Ubah rekening', 'Rekening tujuan withdrawal.');
                    profileForm('bank');
                });
                document.getElementById('openEditPassword').addEventListener('click', function () {
                    open('Ubah password', 'Gunakan password lama sebagai konfirmasi.');
                    passwordForm();
                });
                drawer.addEventListener('click', (event) => {
                    if (event.target !== drawer) return;
                    const bounds = drawer.getBoundingClientRect();
                    if (event.clientX < bounds.left || event.clientX > bounds.right
                        || event.clientY < bounds.top || event.clientY > bounds.bottom) drawer.close();
                });

                const choosePhoto = document.getElementById('chooseProfilePhoto');
                const photoStatus = document.getElementById('profilePhotoStatus');
                const showPhotoStatus = (message, tone) => {
                    const tones = {
                        pending: 'border-blue-100 bg-blue-50 text-blue-900',
                        success: 'border-emerald-100 bg-emerald-50 text-emerald-900',
                        error: 'border-amber-100 bg-amber-50 text-amber-950',
                    };
                    photoStatus.className = 'border-t px-4 py-3 text-sm sm:px-6 ' + tones[tone];
                    photoStatus.textContent = message;
                };
                choosePhoto.addEventListener('click', () => input.click());

                input.addEventListener('change', async () => {
                    const file = input.files?.[0];
                    input.value = '';
                    if (!file || choosePhoto.disabled) return;

                    if (file.size > 616 * 1024) {
                        showPhotoStatus('Ukuran foto maksimal 616 KB.', 'error');
                        return;
                    }

                    const data = new FormData();
                    data.append('imageProfileEdit', file);
                    choosePhoto.disabled = true;
                    showPhotoStatus('Mengunggah foto…', 'pending');

                    try {
                        const payload = await request('/dashboard/edit-profile-image', data);
                        if (payload.success) {
                            const photoUrl = URL.createObjectURL(file);
                            const release = () => {
                                URL.revokeObjectURL(photoUrl);
                                photo.removeEventListener('load', release);
                                photo.removeEventListener('error', release);
                            };
                            photo.addEventListener('load', release);
                            photo.addEventListener('error', release);
                            photo.hidden = false;
                            photo.src = photoUrl;
                            showPhotoStatus('Foto profil diperbarui.', 'success');
                        } else {
                            showPhotoStatus(payload.error || 'Gagal mengubah foto.', 'error');
                        }
                    } catch {
                        showPhotoStatus('Gagal mengubah foto. Coba lagi.', 'error');
                    } finally {
                        choosePhoto.disabled = false;
                    }
                });
            })();
        </script>
    @endpush
@endsection
