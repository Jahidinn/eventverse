@extends('dashboard.layouts.app')

@section('title', 'Users')

@section('content')
    @php
        $users->withQueryString();
        $number = static fn ($value) => number_format($value, 0, ',', '.');
        $pageButton = 'inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-xs font-semibold tabular-nums focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600';
        $pageLink = $pageButton . ' border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-800';
        $roleStyle = [
            'admin' => 'bg-violet-50 text-violet-800',
            'organizer' => 'bg-[#dbeafe] text-[#1d4ed8]',
            'participant' => 'bg-[#dcfce7] text-[#15803d]',
        ];
        $roleIcon = [
            'admin' => 'ti-shield-lock',
            'organizer' => 'ti-calendar-event',
            'participant' => 'ti-ticket',
        ];
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Pengguna</h1>
                <p class="mt-2 text-sm leading-6 text-blue-100">Kelola profil akun, verifikasi email, dan peran pengguna Eventverse.</p>
            </div>
            <a href="/administrator/roles" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-shield-lock" aria-hidden="true"></i> Roles &amp; permissions
            </a>
        </header>

        <dl class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
            @foreach ([
                ['Total akun', $totalUsers, 'ti-users', 'bg-blue-50 text-blue-700'],
                ['Admin', $roleCounts['admin']?->users_count ?? 0, 'ti-shield-lock', 'bg-violet-50 text-violet-700'],
                ['Organizer', $roleCounts['organizer']?->users_count ?? 0, 'ti-calendar-event', 'bg-cyan-50 text-cyan-700'],
                ['Participant', $roleCounts['participant']?->users_count ?? 0, 'ti-ticket', 'bg-emerald-50 text-emerald-700'],
            ] as [$label, $count, $icon, $tone])
                <div class="flex min-w-0 items-center gap-2.5 rounded-xl border border-slate-200 bg-white px-3 py-2.5">
                    <span aria-hidden="true" class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-base {{ $tone }}"><i class="ti {{ $icon }}"></i></span>
                    <div class="min-w-0">
                        <dt class="text-[11px] font-medium leading-4 text-slate-600">{{ $label }}</dt>
                        <dd class="break-words text-base font-semibold leading-5 tracking-tight tabular-nums text-slate-950 sm:text-lg">{{ $number($count) }}</dd>
                    </div>
                </div>
            @endforeach
        </dl>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="p-3 sm:p-4">
                <form method="GET" action="/administrator/users" class="flex flex-wrap items-stretch gap-2">
                    <div class="flex min-h-11 min-w-0 basis-full items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 focus-within:border-blue-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 md:min-w-[12rem] md:flex-1 md:basis-auto">
                        <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                        <input type="search" name="key" value="{{ $search }}" aria-label="Cari pengguna" class="w-full min-w-0 bg-transparent text-base outline-none placeholder:text-slate-500 sm:text-sm" placeholder="Nama, username, email, atau telepon">
                    </div>
                    <select name="role" aria-label="Peran pengguna" class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 !w-auto min-w-0 flex-1 md:flex-none">
                        <option value="">Semua role</option>
                        @foreach ($roles as $roleName)
                            <option value="{{ $roleName }}" @selected($role === $roleName)>{{ ucfirst($roleName) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e]">Cari <i class="ti ti-arrow-right" aria-hidden="true"></i></button>
                    @if ($search !== '' || $role !== '')
                        <a href="/administrator/users" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Reset</a>
                    @endif
                    <span class="ml-auto self-center text-xs font-medium tabular-nums text-slate-600">{{ number_format($users->total(), 0, ',', '.') }} hasil</span>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-4 py-4 sm:px-5">
                <div>
                    <h3 class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Daftar pengguna</h3>
                    <p class="mt-1 text-sm text-slate-600">Ubah profil atau atur peran akun.</p>
                </div>
            </div>

            @if ($users->isEmpty())
                <div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950">
                    <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-users-off"></i></span>
                    <strong>Tidak ada user</strong>
                    <p>Tidak ada user yang cocok dengan filter.</p>
                </div>
            @else
                <div class="lg:overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-blue-600" role="region" aria-label="Tabel pengguna" tabindex="0">
                    <table role="table" class="block w-full text-left text-xs lg:table lg:min-w-[53rem] lg:[&_td]:border-t lg:[&_td]:border-slate-100 lg:[&_td]:px-3 lg:[&_td]:py-2.5 [&_th]:bg-slate-50 [&_th]:px-3 [&_th]:py-2.5 [&_th]:text-[11px] [&_th]:font-semibold [&_th]:text-slate-600">
                        <thead role="rowgroup" class="sr-only lg:not-sr-only">
                            <tr role="row">
                                <th scope="col" role="columnheader">User</th>
                                <th scope="col" role="columnheader">Kontak</th>
                                <th scope="col" role="columnheader">Role</th>
                                <th scope="col" role="columnheader">Status</th>
                                <th scope="col" role="columnheader">Terdaftar</th>
                                <th scope="col" role="columnheader" class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody role="rowgroup" class="block space-y-2 bg-slate-50 p-2.5 lg:table-row-group lg:space-y-0 lg:bg-white lg:p-0">
                            @foreach ($users as $user)
                                <tr role="row" class="grid grid-cols-2 items-center gap-x-2.5 gap-y-1.5 rounded-xl border border-slate-200 bg-white p-3 lg:table-row lg:rounded-none lg:border-0 lg:p-0 lg:even:bg-slate-50/60 lg:hover:bg-blue-50/70">
                                    <td role="cell" class="col-span-2 min-w-0 break-words lg:table-cell">
                                        <div class="flex items-center gap-2.5">
                                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-blue-50 text-xs font-semibold text-blue-800">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            <div class="min-w-0">
                                                <div class="break-words font-semibold text-slate-950">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-600">{{ '@' . $user->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td role="cell" class="col-span-2 min-w-0 break-words lg:table-cell">
                                        <div class="break-all text-xs text-slate-700">{{ $user->email }}</div>
                                        <div class="text-xs text-slate-600">{{ $user->no_tlp ?: 'Belum ada telepon' }}</div>
                                    </td>
                                    <td role="cell" class="col-span-2 min-w-0 break-words lg:table-cell">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse ($user->roles as $userRole)
                                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $roleStyle[$userRole->name] ?? 'bg-slate-100 text-slate-700' }}">
                                                    <i class="ti {{ $roleIcon[$userRole->name] ?? 'ti-user' }}"></i>
                                                    {{ $userRole->name }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-slate-600">Belum ada role</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td role="cell" class="col-span-2 min-w-0 break-words lg:table-cell">
                                        @if ($user->email_verified_at)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-800"><i class="ti ti-circle-check"></i> Terverifikasi</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-900"><i class="ti ti-clock"></i> Belum verifikasi</span>
                                        @endif
                                    </td>
                                    <td role="cell" class="text-xs text-slate-600 lg:table-cell"><span class="block text-slate-500 lg:hidden">Terdaftar</span>{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                                    <td role="cell" class="text-right lg:table-cell">
                                        <button type="button" class="inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-blue-800 hover:bg-blue-50 js-edit-user" data-edit-user="{{ $user->id }}">
                                            <i class="ti ti-pencil"></i>
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <nav aria-label="Halaman pengguna" class="flex flex-col gap-3 border-t border-slate-200 bg-white px-4 py-3.5 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
                        <p class="text-xs tabular-nums text-slate-600">
                            Menampilkan <span class="font-semibold text-slate-900">{{ $number($users->firstItem()) }}–{{ $number($users->lastItem()) }}</span>
                            dari {{ $number($users->total()) }} akun
                        </p>

                        <div class="flex flex-wrap items-center gap-1.5">
                            @if ($users->previousPageUrl())
                                <a href="{{ $users->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="{{ $pageLink }}">
                                    <i class="ti ti-chevron-left" aria-hidden="true"></i>
                                </a>
                            @endif

                            @php
                                $currentPage = $users->currentPage();
                                $lastPage = $users->lastPage();
                                $windowStart = max(1, min($currentPage - 1, $lastPage - 2));
                                $visiblePages = $lastPage <= 5
                                    ? range(1, $lastPage)
                                    : array_values(array_unique([1, ...range($windowStart, $windowStart + 2), $lastPage]));
                            @endphp

                            @foreach ($visiblePages as $index => $page)
                                @if ($index > 0 && $page > $visiblePages[$index - 1] + 1)
                                    <span class="px-1 text-slate-500" aria-hidden="true">…</span>
                                @endif

                                @if ($page === $currentPage)
                                    <span aria-current="page" class="{{ $pageButton }} bg-blue-50 text-blue-800 ring-1 ring-inset ring-blue-200">{{ $page }}</span>
                                @else
                                    <a href="{{ $users->url($page) }}" aria-label="Halaman {{ $page }}" class="{{ $pageLink }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($users->nextPageUrl())
                                <a href="{{ $users->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="{{ $pageLink }}">
                                    <i class="ti ti-chevron-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </nav>
                @endif
            @endif
        </div>

    </div>

    <dialog id="editUserModal" aria-labelledby="editUserTitle"
            class="m-auto max-h-[calc(100dvh_-_2rem)] w-[calc(100%_-_2rem)] max-w-xl overflow-y-auto overscroll-contain rounded-3xl border border-slate-200 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-4 py-4 sm:px-5">
            <div>
                <h2 id="editUserTitle" class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight text-slate-950">Edit pengguna</h2>
                <p class="mt-1 text-sm text-slate-600">Perbarui profil atau peran akses pengguna.</p>
            </div>
            <button type="button" id="closeEditUserModal" class="grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-slate-200 text-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600" aria-label="Tutup"><i class="ti ti-x"></i></button>
        </div>

        <form id="editUserForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div id="editUserError" role="alert" class="rounded-xl bg-amber-50 px-3 py-2.5 text-sm text-amber-950 mx-4 mt-4 hidden"></div>

            <div class="grid grid-cols-1 gap-3 p-4 sm:grid-cols-2">
                <div>
                    <label for="editUserName" class="mb-1 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input id="editUserName" name="name" class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                </div>
                <div>
                    <label for="editUserUsername" class="mb-1 block text-sm font-semibold text-slate-700">Username</label>
                    <input id="editUserUsername" name="username" class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                </div>
                <div>
                    <label for="editUserEmail" class="mb-1 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="editUserEmail" type="email" name="email" class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                </div>
                <div>
                    <label for="editUserPhone" class="mb-1 block text-sm font-semibold text-slate-700">Nomor telepon</label>
                    <input id="editUserPhone" name="no_tlp" class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>
            </div>

            <div class="px-4 pb-4">
                <div class="mb-2">
                    <h4 class="text-sm font-semibold text-slate-950">Role akses</h4>
                    <p class="text-xs text-slate-600">Bisa lebih dari satu role.</p>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <label class="flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:border-blue-200 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50/70">
                        <input type="checkbox" name="roles[]" value="admin" class="edit-user-role mt-1 h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span><span class="inline-flex items-center gap-1 rounded-full bg-violet-50 px-2 py-1 text-xs font-semibold text-violet-800"><i class="ti ti-shield-lock"></i> admin</span><span class="mt-1 block text-xs leading-5 text-slate-600">Akses penuh platform, pembayaran, event, user, dan role.</span></span>
                    </label>
                    <label class="flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:border-blue-200 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50/70">
                        <input type="checkbox" name="roles[]" value="organizer" class="edit-user-role mt-1 h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span><span class="inline-flex items-center gap-1 rounded-full bg-[#dbeafe] px-2 py-1 text-xs font-semibold text-[#1d4ed8]"><i class="ti ti-calendar-event"></i> organizer</span><span class="mt-1 block text-xs leading-5 text-slate-600">Mengelola event sendiri lewat Event Studio, peserta, finance, dan check-in.</span></span>
                    </label>
                    <label class="flex cursor-pointer items-start gap-2.5 rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:border-blue-200 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50/70">
                        <input type="checkbox" name="roles[]" value="participant" class="edit-user-role mt-1 h-4 w-4 shrink-0 accent-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span><span class="inline-flex items-center gap-1 rounded-full bg-[#dcfce7] px-2 py-1 text-xs font-semibold text-[#15803d]"><i class="ti ti-ticket"></i> participant</span><span class="mt-1 block text-xs leading-5 text-slate-600">Membeli tiket, melihat My Event, organization, dan profil.</span></span>
                    </label>
                </div>
            </div>

            <div class="flex flex-wrap justify-end gap-2 border-t border-slate-200 bg-slate-50 p-4">
                <button type="button" id="cancelEditUser" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100">Batal</button>
                <button type="submit" id="submitEditUser" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-3.5 py-2 text-sm font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e]">
                    <i class="ti ti-device-floppy"></i>
                    Simpan perubahan
                </button>
            </div>
        </form>
    </dialog>

    @push('scripts')
        <script>
            (function () {
                const modal = document.getElementById('editUserModal');
                const form = document.getElementById('editUserForm');
                const errorBox = document.getElementById('editUserError');
                const submit = document.getElementById('submitEditUser');
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const users = {{ \Illuminate\Support\Js::from($userPayloads) }};
                let saving = false;

                const close = function () {
                    if (!saving) modal.close();
                };

                const open = function (user) {
                    form.action = '/administrator/users/' + encodeURIComponent(user.id);
                    document.getElementById('editUserName').value = user.name || '';
                    document.getElementById('editUserUsername').value = user.username || '';
                    document.getElementById('editUserEmail').value = user.email || '';
                    document.getElementById('editUserPhone').value = user.no_tlp || '';

                    document.querySelectorAll('.edit-user-role').forEach(function (checkbox) {
                        checkbox.checked = (user.roles || []).includes(checkbox.value);
                    });

                    errorBox.classList.add('hidden');
                    errorBox.textContent = '';
                    submit.disabled = false;
                    if (!modal.open) modal.showModal();
                };

                document.querySelectorAll('.js-edit-user').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const user = Object.values(users || {}).find((item) => String(item.id) === String(button.dataset.editUser));
                        if (user) open(user);
                    });
                });

                document.getElementById('closeEditUserModal').addEventListener('click', close);
                document.getElementById('cancelEditUser').addEventListener('click', close);
                modal.addEventListener('cancel', (event) => {
                    if (saving) event.preventDefault();
                });
                modal.addEventListener('click', (event) => {
                    if (event.target !== modal) return;
                    const bounds = modal.getBoundingClientRect();
                    if (event.clientX < bounds.left || event.clientX > bounds.right
                        || event.clientY < bounds.top || event.clientY > bounds.bottom) close();
                });

                form.addEventListener('submit', async function (event) {
                    event.preventDefault();
                    if (saving) return;
                    saving = true;
                    errorBox.classList.add('hidden');
                    errorBox.textContent = '';
                    submit.disabled = true;

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                            body: new FormData(form),
                        });
                        const payload = await response.json();

                        if (response.ok && payload.success) {
                            window.location.reload();
                            return;
                        }

                        const firstError = payload.errors
                            ? Object.values(payload.errors).flat()[0]
                            : payload.message;
                        errorBox.textContent = firstError || 'Gagal menyimpan perubahan.';
                        errorBox.classList.remove('hidden');
                    } catch (error) {
                        errorBox.textContent = 'Gagal menyimpan perubahan. Coba lagi.';
                        errorBox.classList.remove('hidden');
                    }

                    saving = false;
                    submit.disabled = false;
                });
            })();
        </script>
    @endpush
@endsection

