@extends('dashboard.layouts.app')

@section('title', $event->title . ' — Participants')

@section('content')
    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-6 text-white sm:px-8 sm:py-8">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>

            <a href="/dashboard/participant-data" class="inline-flex min-h-9 items-center gap-2 rounded-lg text-sm font-semibold text-blue-100 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-arrow-left" aria-hidden="true"></i> Semua event
            </a>

            <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="break-words font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-2xl font-bold tracking-tight sm:text-4xl">{{ $event->title }}</h1>
                    <p class="mt-2 text-sm leading-6 text-blue-100">Kelola peserta, pembayaran, dan check-in.</p>
                </div>
                <a href="/dashboard/participant-download-excel/{{ $event->event_id }}" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    <i class="ti ti-file-spreadsheet text-lg" aria-hidden="true"></i> Ekspor Excel
                </a>
            </div>
        </header>

        @php
            $stats = [
                ['participantTotal', 'Total peserta', 'ti-users', 'bg-blue-50 text-blue-700'],
                ['participantPaid', 'Lunas', 'ti-circle-check', 'bg-emerald-50 text-emerald-700'],
                ['participantChecked', 'Sudah check-in', 'ti-user-check', 'bg-indigo-50 text-indigo-700'],
                ['participantRemaining', 'Belum check-in', 'ti-clock', 'bg-slate-100 text-slate-600'],
            ];
        @endphp

        <dl class="grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach ($stats as [$id, $label, $icon, $color])
                <div class="flex min-w-0 flex-col gap-2 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm sm:p-4">
                    <dt class="flex min-w-0 flex-wrap items-center justify-between gap-2 text-xs font-medium text-slate-600 sm:text-sm">
                        {{ $label }}
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-base {{ $color }}" aria-hidden="true">
                            <i class="ti {{ $icon }}"></i>
                        </span>
                    </dt>
                    <dd id="{{ $id }}" class="break-words text-xl font-bold tracking-tight text-slate-950 tabular-nums sm:text-2xl">—</dd>
                </div>
            @endforeach
        </dl>

        <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex min-h-11 min-w-[13rem] flex-[1_1_15rem] items-center gap-2 rounded-xl border border-slate-200 px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100">
                    <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                    <input id="participantSearch" aria-label="Cari peserta" class="min-w-0 flex-1 bg-transparent text-sm outline-none placeholder:text-slate-500" type="search" placeholder="Cari nama, email, atau kode tiket...">
                </div>
                <select id="participantStatus" aria-label="Status pembayaran" class="min-h-11 min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 sm:flex-none">
                    <option value="">Semua status</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Pending">Pending</option>
                    <option value="Expired">Expired</option>
                </select>
                <select id="participantCheckin" aria-label="Status check-in" class="min-h-11 min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 sm:flex-none">
                    <option value="">Semua check-in</option>
                    <option value="checked">Sudah check-in</option>
                    <option value="not">Belum check-in</option>
                </select>
            </div>
        </div>

        <section aria-label="Daftar peserta" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div id="participantLoading" class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>span]:mx-auto [&>strong]:block [&>strong]:text-slate-900">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-loader-2 animate-spin"></i></span>
                <strong>Memuat peserta...</strong>
            </div>
            <div id="participantEmpty" class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>span]:mx-auto [&>strong]:block [&>strong]:text-slate-900 hidden">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-users-off"></i></span>
                <strong>Belum ada peserta</strong>
                <p>Tidak ada peserta yang cocok dengan filter.</p>
            </div>
            <div id="participantTableWrap" class="hidden"><div class="overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-blue-600" tabindex="0" role="region" aria-label="Tabel peserta, dapat digulir horizontal">
                <table class="w-full min-w-[52rem] text-left text-sm [&_td]:border-t [&_td]:border-slate-100 [&_td]:px-4 [&_td]:py-3 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:font-semibold [&_th]:text-slate-600 [&_tbody_tr:hover]:bg-blue-50/40">
                    <thead>
                        <tr>
                            <th scope="col">Peserta</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tiket</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Status</th>
                            <th scope="col">Check-in</th>
                            <th scope="col" class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="participantRows"></tbody>
                </table>
                </div>
                <nav aria-label="Halaman peserta" class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-4 py-3">
                    <p id="participantRange" class="text-xs tabular-nums text-slate-600" aria-live="polite"></p>
                    <div id="participantPager" class="flex items-center gap-2">
                        <button type="button" id="participantPrev" aria-label="Halaman sebelumnya" class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-40">
                            <i class="ti ti-chevron-left" aria-hidden="true"></i>
                        </button>
                        <span id="participantPage" class="text-xs font-semibold tabular-nums text-blue-800"></span>
                        <button type="button" id="participantNext" aria-label="Halaman berikutnya" class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-40">
                            <i class="ti ti-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </nav>
            </div>
        </section>
    </div>

    <dialog id="participantDrawer" aria-labelledby="participantDrawerTitle"
            class="fixed inset-y-0 left-auto right-0 m-0 h-dvh max-h-none w-full max-w-md overflow-y-auto overscroll-contain border-0 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white px-5 py-4">
            <div>
                <h2 id="participantDrawerTitle" class="font-['Sora','Inter',sans-serif] text-lg font-semibold tracking-tight">Detail peserta</h2>
                <p class="mt-1 text-sm text-slate-600">Informasi pendaftaran dan pembayaran.</p>
            </div>
            <form method="dialog">
                <button type="submit" aria-label="Tutup detail peserta" autofocus class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                    <i class="ti ti-x" aria-hidden="true"></i>
                </button>
            </form>
        </div>
        <div id="participantDrawerBody" class="space-y-4 p-5"></div>
    </dialog>

    @push('scripts')
        <script>
            (function () {
                const eventId = @json($event->event_id);
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const rowsEl = document.getElementById('participantRows');
                const loading = document.getElementById('participantLoading');
                const empty = document.getElementById('participantEmpty');
                const tableWrap = document.getElementById('participantTableWrap');
                const searchInput = document.getElementById('participantSearch');
                const statusSelect = document.getElementById('participantStatus');
                const checkinSelect = document.getElementById('participantCheckin');
                const drawer = document.getElementById('participantDrawer');
                const drawerBody = document.getElementById('participantDrawerBody');
                const range = document.getElementById('participantRange');
                const pager = document.getElementById('participantPager');
                const pageLabel = document.getElementById('participantPage');
                const previous = document.getElementById('participantPrev');
                const next = document.getElementById('participantNext');
                const pageSize = 20;
                const integer = new Intl.NumberFormat('id-ID');
                let page = 1;
                let rows = [];
                let loaded = false;
                let detailRequest = 0;

                const esc = function (value) {
                    const div = document.createElement('div');
                    div.textContent = value == null ? '' : String(value);
                    return div.innerHTML;
                };
                const money = (value) => 'Rp ' + Number(value || 0).toLocaleString('id-ID');
                const transactionOf = (row) => row.transaction || {};

                const setStats = function () {
                    const paid = rows.filter((row) => transactionOf(row).status === 'Paid').length;
                    const checked = rows.filter((row) => row.checked_in_at).length;
                    document.getElementById('participantTotal').textContent = Number(rows.length).toLocaleString('id-ID');
                    document.getElementById('participantPaid').textContent = Number(paid).toLocaleString('id-ID');
                    document.getElementById('participantChecked').textContent = Number(checked).toLocaleString('id-ID');
                    document.getElementById('participantRemaining').textContent = Number(Math.max(rows.length - checked, 0)).toLocaleString('id-ID');
                };

                const render = function () {
                    if (!loaded) return;
                    const term = (searchInput.value || '').toLowerCase().trim();
                    const status = statusSelect.value;
                    const checkin = checkinSelect.value;
                    const filtered = rows.filter((row) => {
                        const transaction = transactionOf(row);
                        const text = [row.name, row.email, row.ticket_code, transaction.transaction_code]
                            .filter(Boolean).join(' ').toLowerCase();
                        if (term && !text.includes(term)) return false;
                        if (status && transaction.status !== status) return false;
                        if (checkin === 'checked' && !row.checked_in_at) return false;
                        if (checkin === 'not' && row.checked_in_at) return false;
                        return true;
                    });

                    rowsEl.innerHTML = '';
                    empty.classList.toggle('hidden', filtered.length > 0);
                    tableWrap.classList.toggle('hidden', filtered.length === 0);

                    const totalPages = Math.max(1, Math.ceil(filtered.length / pageSize));
                    page = Math.min(page, totalPages);
                    const offset = (page - 1) * pageSize;
                    const visible = filtered.slice(offset, offset + pageSize);
                    range.textContent = filtered.length
                        ? `${integer.format(offset + 1)}–${integer.format(offset + visible.length)} dari ${integer.format(filtered.length)} peserta`
                        : '';
                    pageLabel.textContent = `${page} / ${totalPages}`;
                    pager.classList.toggle('hidden', totalPages <= 1);
                    previous.disabled = page <= 1;
                    next.disabled = page >= totalPages;

                    visible.forEach((row) => {
                        const transaction = transactionOf(row);
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td><span class="font-semibold text-slate-900">${esc(row.name || '—')}</span></td>
                            <td class="text-slate-600">${esc(row.email || '—')}</td>
                            <td>${esc(row.ticket_name || '—')}</td>
                            <td>${esc(row.ticket_code || '—')}</td>
                            <td><span class="inline-flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold ${transaction.status === 'Paid' ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-700'}">${esc(transaction.status || '—')}</span></td>
                            <td>${row.checked_in_at ? '<span class="inline-flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-800"><i class="ti ti-circle-check"></i> Checked in</span>' : '<span class="inline-flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700"><i class="ti ti-clock"></i> Belum</span>'}</td>
                            <td class="whitespace-nowrap text-right">
                                <button type="button" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg border px-2.5 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 border-slate-200 bg-white text-slate-700 hover:bg-slate-100 detail-participant" ><i class="ti ti-eye"></i> Detail</button>
                                ${!row.checked_in_at && transaction.status === 'Paid' ? `<button type="button" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg border px-2.5 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 ml-1 border-blue-200 bg-blue-50 text-blue-800 hover:bg-blue-100 disabled:opacity-50 checkin-participant" ><i class="ti ti-user-check"></i> Check-in</button>` : ''}
                            </td>
                        `;
                        tr.querySelector('.detail-participant').dataset.id = row.participant_id ?? '';
                        const checkinButton = tr.querySelector('.checkin-participant');
                        if (checkinButton) checkinButton.dataset.id = row.participant_id ?? '';
                        rowsEl.appendChild(tr);
                    });

                    rowsEl.querySelectorAll('.detail-participant').forEach((button) => {
                        button.addEventListener('click', () => openDetail(button.dataset.id));
                    });
                    rowsEl.querySelectorAll('.checkin-participant').forEach((button) => {
                        button.addEventListener('click', () => checkIn(button.dataset.id, button));
                    });
                    setStats();
                };

                const checkIn = async function (id, button) {
                    button.disabled = true;
                    try {
                        const response = await fetch('/dashboard/participant-checkin', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                            body: new URLSearchParams({ id: id }),
                        });
                        const payload = await response.json();
                        if (payload.success) {
                            const row = rows.find((item) => String(item.participant_id) === String(id));
                            if (row) row.checked_in_at = new Date().toISOString();
                            render();
                            return;
                        }
                        window.alert(payload.error || 'Gagal check-in.');
                    } catch (e) {
                        window.alert('Gagal check-in. Coba lagi.');
                    }
                    button.disabled = false;
                };

                const load = async function () {
                    loading.classList.remove('hidden');
                    empty.classList.add('hidden');
                    tableWrap.classList.add('hidden');
                    try {
                        const response = await fetch('/dashboard/get-participant?' + new URLSearchParams({ event_id: eventId }).toString(), { headers: { 'Accept': 'application/json' } });
                        if (!response.ok) throw new Error('failed');
                        const payload = await response.json();
                        rows = (payload.data || []).map((row) => ({
                            participant_id: row.participant_id,
                            name: row.name,
                            email: row.email,
                            ticket_name: row.ticket_name,
                            ticket_code: row.ticket_code,
                            checked_in_at: row.checked_in_at,
                            transaction: row.transaction || {},
                        }));
                        loaded = true;
                        loading.classList.add('hidden');
                        render();
                    } catch (e) {
                        loading.classList.add('hidden');
                        empty.classList.remove('hidden');
                        empty.querySelector('strong').textContent = 'Gagal memuat peserta';
                        empty.querySelector('p').textContent = 'Periksa akses event atau coba lagi.';
                    }
                };

                const openDetail = async function (id) {
                    drawerBody.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>span]:mx-auto [&>strong]:block [&>strong]:text-slate-900"><span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-loader-2 animate-spin"></i></span><strong>Memuat detail...</strong></div>';
                    if (!drawer.open) drawer.showModal();
                    const request = ++detailRequest;
                    try {
                        const response = await fetch('/dashboard/participant-detail?id=' + encodeURIComponent(id), { headers: { 'Accept': 'application/json' } });
                        if (!response.ok) throw new Error('failed');
                        const data = await response.json();
                        if (request !== detailRequest || !drawer.open) return;
                        const participant = data.participant || {};
                        const transaction = data.transaction || {};
                        const event = data.event || {};
                        const ticket = data.ticket || {};
                        const forms = data.forms || [];
                        drawerBody.innerHTML = `
                            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold"><h4>Peserta</h4>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Nama</span><strong>${esc(participant.name || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Email</span><strong>${esc(participant.email || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Telepon</span><strong>${esc(participant.phone || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Kode tiket</span><strong>${esc(participant.ticket_code || '-')}</strong></div>
                            </div>
                            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold"><h4>Event &amp; tiket</h4>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Event</span><strong>${esc(event.title || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Tiket</span><strong>${esc(ticket.name || '-')}</strong></div>
                            </div>
                            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold"><h4>Pembayaran</h4>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Kode transaksi</span><strong>${esc(transaction.code || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Status</span><strong>${esc(transaction.status || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Metode</span><strong>${esc(transaction.payment_method || '-')}</strong></div>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>Total bayar</span><strong>${money(transaction.grand_total)}</strong></div>
                            </div>
                            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold"><h4>Form pendaftaran</h4>
                                ${forms.length ? forms.map((form) => `<div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1 border-t border-slate-100 py-2 text-sm text-slate-600 [&>strong]:min-w-0 [&>strong]:break-words [&>strong]:text-slate-900"><span>${esc(form.label)}</span><strong>${esc(form.value || '-')}</strong></div>`).join('') : '<div class="text-sm text-slate-600">Tidak ada data form.</div>'}
                            </div>
                        `;
                    } catch (e) {
                        if (request !== detailRequest || !drawer.open) return;
                        drawerBody.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>span]:mx-auto [&>strong]:block [&>strong]:text-slate-900"><strong>Gagal memuat detail</strong><p>Coba lagi.</p></div>';
                    }
                };

                const applyFilters = function () {
                    page = 1;
                    render();
                };
                searchInput.addEventListener('input', applyFilters);
                statusSelect.addEventListener('change', applyFilters);
                checkinSelect.addEventListener('change', applyFilters);
                previous.addEventListener('click', () => { page--; render(); });
                next.addEventListener('click', () => { page++; render(); });
                drawer.addEventListener('close', () => { detailRequest++; });
                drawer.addEventListener('click', (event) => {
                    if (event.target !== drawer) return;
                    const bounds = drawer.getBoundingClientRect();
                    if (event.clientX < bounds.left || event.clientX > bounds.right
                        || event.clientY < bounds.top || event.clientY > bounds.bottom) drawer.close();
                });

                load();
            })();
        </script>
    @endpush
@endsection
