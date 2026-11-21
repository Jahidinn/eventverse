@extends('dashboard.layouts.app')

@section('title', 'Withdrawals')

@section('content')
    @php
        $number = static fn ($value) => number_format((float) $value, 0, ',', '.');
        $pendingCount = $stats['Proses']?->total_count ?? 0;
        $pendingAmount = $stats['Proses']?->total_amount ?? 0;
        $secondary = 'inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-50';
        $primary = 'inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#1765c4] px-4 text-sm font-semibold text-white hover:bg-[#174f9e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50';
        $dateInput = 'min-h-11 w-full min-w-0 rounded-xl border border-slate-200 bg-white px-2.5 text-sm text-slate-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100';
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Penarikan Dana</h1>
                <p class="mt-2 text-sm leading-6 text-blue-100">Tinjau pengajuan, verifikasi rekening tujuan, dan pantau riwayat pencairan organizer.</p>
            </div>
            <a href="{{ url('/administrator/payments') }}" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-receipt-2 text-lg" aria-hidden="true"></i> Payments
            </a>
        </header>

        <dl class="grid grid-cols-2 gap-3 lg:grid-cols-[1.4fr_1fr_1fr]">
            <div class="col-span-2 rounded-2xl border border-blue-100 bg-gradient-to-br from-white to-blue-50 p-4 sm:p-5 lg:col-span-1">
                <dt class="flex items-center gap-2 text-sm font-medium text-blue-800"><i class="ti ti-clock text-lg" aria-hidden="true"></i> Menunggu tinjauan</dt>
                <dd id="wdPendingAmount" class="mt-2 break-words text-2xl font-bold tracking-tight tabular-nums">Rp {{ $number($pendingAmount) }}</dd>
                <dd class="mt-1 text-xs text-slate-600"><span id="wdPendingCount" class="font-semibold">{{ $number($pendingCount) }}</span> pengajuan</dd>
            </div>
            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                <dt class="flex items-center gap-2 text-sm font-medium text-slate-600"><i class="ti ti-circle-check text-lg text-emerald-700" aria-hidden="true"></i> Disetujui</dt>
                <dd id="wdApprovedCount" data-count="{{ $stats['Sukses']?->total_count ?? 0 }}" class="mt-2 text-2xl font-bold tracking-tight tabular-nums">{{ $number($stats['Sukses']?->total_count ?? 0) }}</dd>
            </div>
            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                <dt class="flex items-center gap-2 text-sm font-medium text-slate-600"><i class="ti ti-circle-x text-lg" aria-hidden="true"></i> Ditolak</dt>
                <dd id="wdRejectedCount" data-count="{{ $stats['Gagal']?->total_count ?? 0 }}" class="mt-2 text-2xl font-bold tracking-tight tabular-nums">{{ $number($stats['Gagal']?->total_count ?? 0) }}</dd>
            </div>
        </dl>

        <section aria-labelledby="withdrawListTitle" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="space-y-3 border-b border-slate-200 p-4 sm:p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 id="withdrawListTitle" class="font-['Sora','Inter',sans-serif] text-base font-semibold">Pengajuan penarikan</h2>
                    <div role="group" aria-label="Tampilan penarikan" class="flex gap-1 rounded-xl bg-slate-100 p-1">
                        @foreach (['pending' => 'Menunggu', 'history' => 'Riwayat'] as $tab => $label)
                            <button type="button" data-wd-view="{{ $tab }}" aria-pressed="{{ $tab === 'pending' ? 'true' : 'false' }}"
                                    class="min-h-9 rounded-lg px-3 text-sm font-semibold text-slate-600 hover:bg-white/75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 aria-pressed:bg-white aria-pressed:text-blue-800 aria-pressed:shadow-sm">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>
                <label class="flex min-h-11 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 focus-within:border-blue-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100">
                    <i class="ti ti-search text-lg text-slate-500" aria-hidden="true"></i>
                    <span class="sr-only">Cari organizer atau event</span>
                    <input id="wdSearch" type="search" placeholder="Cari organizer atau event"
                           class="w-full min-w-0 bg-transparent text-base outline-none placeholder:text-slate-500 sm:text-sm">
                </label>
                <form id="wdHistoryFilter" class="hidden">
                    <div class="flex flex-wrap items-end gap-2">
                        <label class="min-w-0 flex-1 sm:max-w-44"><span class="mb-1 block text-xs font-semibold">Dari tanggal</span><input id="wdStart" type="date" class="{{ $dateInput }}"></label>
                        <label class="min-w-0 flex-1 sm:max-w-44"><span class="mb-1 block text-xs font-semibold">Sampai tanggal</span><input id="wdEnd" type="date" class="{{ $dateInput }}"></label>
                        <button type="submit" class="{{ $primary }}"><i class="ti ti-filter" aria-hidden="true"></i> Tampilkan</button>
                    </div>
                </form>
            </div>

            <p id="wdNotice" role="status" class="hidden border-b px-4 py-3 text-sm font-medium"></p>
            <p id="wdState" role="status" class="px-5 py-10 text-center text-sm text-slate-600">Memuat pengajuan…</p>

            <div id="wdTableWrap" class="hidden">
                <div role="region" aria-label="Daftar penarikan dana" tabindex="0" class="lg:overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-blue-600">
                    <table role="table" class="block w-full text-left text-sm lg:table lg:min-w-[51rem] lg:[&_td]:border-t lg:[&_td]:border-slate-100 lg:[&_td]:px-4 lg:[&_td]:py-3.5 lg:[&_td]:align-top [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:text-xs [&_th]:font-semibold [&_th]:text-slate-600">
                        <thead role="rowgroup" class="sr-only lg:not-sr-only"><tr id="wdHeaders" role="row"></tr></thead>
                        <tbody id="wdRows" role="rowgroup" class="block space-y-2 bg-slate-50 p-2.5 lg:table-row-group lg:space-y-0 lg:bg-white lg:p-0"></tbody>
                    </table>
                </div>
                <nav aria-label="Halaman penarikan" class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-4 py-3">
                    <p id="wdRange" aria-live="polite" class="text-xs tabular-nums text-slate-600"></p>
                    <div id="wdPagination"></div>
                </nav>
            </div>
        </section>
    </div>

    <dialog id="wdDecision" aria-labelledby="wdDecisionTitle"
            class="m-auto max-h-[calc(100dvh_-_2rem)] w-[calc(100%_-_2rem)] max-w-md overflow-y-auto rounded-3xl border border-slate-200 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <form id="wdDecisionForm">
            <header class="border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white px-5 py-4">
                <h2 id="wdDecisionTitle" class="font-['Sora','Inter',sans-serif] text-lg font-semibold"></h2>
                <p id="wdDecisionContext" class="mt-1 break-words text-sm text-slate-600"></p>
            </header>
            <div class="space-y-3 p-5">
                <p id="wdDecisionHint" class="text-sm leading-6 text-slate-600"></p>
                <dl id="wdDecisionAccount" class="space-y-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-3 text-sm">
                    <div><dt class="text-xs text-slate-600">Organizer</dt><dd id="wdDecisionOrganizer" class="break-words font-semibold"></dd></div>
                    <div><dt class="text-xs text-slate-600">Rekening tujuan</dt><dd id="wdDecisionBank" class="break-all font-semibold tabular-nums"></dd></div>
                </dl>
                <label id="wdReasonWrap" class="block">
                    <span class="mb-1.5 block text-sm font-semibold">Alasan penolakan</span>
                    <textarea id="wdReason" rows="3" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" placeholder="Tulis alasan yang bisa dipahami organizer"></textarea>
                </label>
                <p id="wdDecisionError" role="alert" class="hidden rounded-lg bg-amber-50 px-3 py-2 text-sm text-amber-950"></p>
            </div>
            <footer class="flex flex-wrap justify-end gap-2 border-t border-slate-100 bg-slate-50 px-5 py-4">
                <button id="wdCancel" type="button" class="{{ $secondary }}">Batal</button>
                <button id="wdSubmit" type="submit" class="{{ $primary }}"></button>
            </footer>
        </form>
    </dialog>

    @push('scripts')
        <script>
            (() => {
                const byId = (id) => document.getElementById(id);
                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const search = byId('wdSearch');
                const start = byId('wdStart');
                const end = byId('wdEnd');
                const rows = byId('wdRows');
                const state = byId('wdState');
                const notice = byId('wdNotice');
                const dialog = byId('wdDecision');
                const reason = byId('wdReason');
                const submit = byId('wdSubmit');
                const cancel = byId('wdCancel');
                const error = byId('wdDecisionError');
                const number = new Intl.NumberFormat('id-ID');
                const currency = (amount) => 'Rp ' + number.format(Number(amount || 0));
                const pageSize = 15;
                const buttonStyle = 'inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600';
                let view = 'pending';
                let data = [];
                let page = 1;
                let loadVersion = 0;
                let ready = false;
                let decision = null;
                let sending = false;

                const text = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
                })[character]);

                const dateLabel = (value) => value ? new Date(value).toLocaleDateString('id-ID') : '—';
                const localDate = (date) => [date.getFullYear(), date.getMonth() + 1, date.getDate()]
                    .map((part, index) => String(part).padStart(index ? 2 : 4, '0')).join('-');

                const showState = (message) => {
                    state.textContent = message;
                    state.classList.remove('hidden');
                    byId('wdTableWrap').classList.add('hidden');
                };

                const paginate = (count, from, to, pages) => {
                    byId('wdRange').textContent = `${number.format(from)}–${number.format(to)} dari ${number.format(count)} pengajuan`;
                    const pager = byId('wdPagination');
                    pager.className = 'flex flex-wrap items-center gap-1.5';
                    const targets = [...new Set([1, page - 1, page, page + 1, pages])]
                        .filter((target) => target > 0 && target <= pages).sort((a, b) => a - b);
                    const link = (target, label, title) => `<button type="button" data-wd-page="${target}" aria-label="${title}" class="${buttonStyle}">${label}</button>`;
                    pager.innerHTML = pages <= 1 ? '' : [
                        page > 1 ? link(page - 1, '<i class="ti ti-chevron-left" aria-hidden="true"></i>', 'Halaman sebelumnya') : '',
                        ...targets.flatMap((target, index) => [
                            index && target > targets[index - 1] + 1 ? '<span aria-hidden="true" class="px-1 text-slate-500">…</span>' : '',
                            target === page ? `<span aria-current="page" class="inline-flex min-h-10 items-center rounded-lg bg-blue-50 px-3 text-xs font-semibold text-blue-800 ring-1 ring-inset ring-blue-200">${target}</span>` : link(target, target, 'Halaman ' + target),
                        ]),
                        page < pages ? link(page + 1, '<i class="ti ti-chevron-right" aria-hidden="true"></i>', 'Halaman berikutnya') : '',
                    ].join('');
                };

                const render = () => {
                    if (!ready) return;
                    const pending = view === 'pending';
                    const query = search.value.trim().toLowerCase();
                    const filtered = data.filter((row) => !query || [row.user?.username, row.user?.name, row.user?.email, row.event?.title]
                        .some((value) => String(value ?? '').toLowerCase().includes(query)));

                    if (!filtered.length) {
                        showState(query ? 'Tidak ada pengajuan yang cocok dengan pencarian.' :
                            pending ? 'Tidak ada pengajuan menunggu tinjauan.' : 'Tidak ada riwayat pada rentang tanggal ini.');
                        return;
                    }

                    const pages = Math.ceil(filtered.length / pageSize);
                    page = Math.min(page, pages);
                    const offset = (page - 1) * pageSize;
                    const visible = filtered.slice(offset, offset + pageSize);
                    const headings = pending
                        ? ['Organizer', 'Event', 'Jumlah', 'Rekening', 'Tanggal', 'Aksi']
                        : ['Organizer', 'Event', 'Jumlah', 'Tanggal', 'Status', 'Catatan'];
                    byId('wdHeaders').innerHTML = headings.map((heading) => `<th scope="col" role="columnheader">${heading}</th>`).join('');
                    const cell = (label, value, classes = '') => `<td role="cell" class="min-w-0 break-words lg:table-cell ${classes}"><span class="block text-xs font-normal text-slate-500 lg:hidden">${label}</span>${value}</td>`;
                    rows.innerHTML = visible.map((row, index) => {
                        const name = text(row.user?.username || row.user?.name || '—');
                        const email = text(row.user?.email || '');
                        const event = text(row.event?.title || '—');
                        const amount = currency(row.amount);
                        const status = {
                            Sukses: ['Disetujui', 'bg-emerald-50 text-emerald-800'],
                            Gagal: ['Ditolak', 'bg-slate-100 text-slate-700'],
                            Proses: ['Menunggu', 'bg-amber-50 text-amber-900'],
                        }[row.status] || ['Tidak diketahui', 'bg-slate-100 text-slate-700'];
                        return `<tr role="row" class="grid grid-cols-2 gap-x-3 gap-y-2 rounded-xl border border-slate-200 bg-white p-3.5 lg:table-row lg:rounded-none lg:border-0 lg:p-0 lg:even:bg-slate-50/60 lg:hover:bg-blue-50/70">
                            ${cell('Organizer', `<span class="block font-semibold">${name}</span><span class="block break-all text-xs text-slate-600">${email}</span>`, 'col-span-2')}
                            ${cell('Event', event, 'col-span-2')}
                            ${cell('Jumlah', amount, 'font-semibold tabular-nums lg:whitespace-nowrap')}
                            ${pending ? cell('Rekening', `<span class="block">${text(row.bank || '—')}</span><span class="break-all font-mono text-xs text-slate-600">${text(row.rekening || '')}</span>`) : ''}
                            ${cell('Tanggal', text(dateLabel(pending ? row.created_at : row.updated_at)), 'text-slate-600 lg:whitespace-nowrap')}
                            ${pending
                                ? cell('Aksi', `<div class="mt-1 flex flex-wrap gap-1.5 lg:mt-0">
                                    <button type="button" data-wd-action="approve" data-index="${index}" class="${buttonStyle} !border-blue-200 !bg-blue-50 !text-blue-800 hover:!bg-blue-100">Setujui</button>
                                    <button type="button" data-wd-action="reject" data-index="${index}" class="${buttonStyle}">Tolak</button>
                                </div>`, 'col-span-2')
                                : cell('Status', `<span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ${status[1]}">${status[0]}</span>`) + cell('Catatan', text(row.catatan || '—'), 'col-span-2 text-slate-600')}
                        </tr>`;
                    }).join('');

                    rows.onclick = (event) => {
                        const button = event.target.closest('[data-wd-action]');
                        if (button) openDecision(button.dataset.wdAction, visible[Number(button.dataset.index)]);
                    };
                    state.classList.add('hidden');
                    byId('wdTableWrap').classList.remove('hidden');
                    paginate(filtered.length, offset + 1, offset + visible.length, pages);
                };

                const load = async () => {
                    const version = ++loadVersion;
                    const pending = view === 'pending';
                    ready = false;
                    showState(pending ? 'Memuat pengajuan…' : 'Memuat riwayat…');
                    const historyParams = new URLSearchParams({ start_date: start.value, end_date: end.value, status: '' });
                    try {
                        const response = await fetch(pending ? '/administrator/wd-request/get-data?status=Proses'
                            : '/administrator/wd-history/get-data?' + historyParams, { headers: { Accept: 'application/json' } });
                        if (!response.ok) throw new Error('Gagal memuat');
                        const payload = await response.json();
                        if (version !== loadVersion) return;
                        data = Array.isArray(payload.data) ? payload.data : [];
                        if (pending) {
                            const awaiting = data.filter((row) => row.status === 'Proses');
                            byId('wdPendingCount').textContent = number.format(awaiting.length);
                            byId('wdPendingAmount').textContent = currency(awaiting.reduce((sum, row) => sum + Number(row.amount || 0), 0));
                        }
                        ready = true;
                        render();
                    } catch {
                        if (version === loadVersion) showState('Pengajuan tidak bisa dimuat. Coba muat ulang halaman.');
                    }
                };

                const openDecision = (action, row) => {
                    if (!row || sending) return;
                    const reject = action === 'reject';
                    decision = { row, reject };
                    reason.value = '';
                    reason.required = reject;
                    byId('wdReasonWrap').classList.toggle('hidden', !reject);
                    error.classList.add('hidden');
                    notice.classList.add('hidden');
                    byId('wdDecisionTitle').textContent = reject ? 'Tolak pengajuan' : 'Setujui penarikan';
                    byId('wdDecisionContext').textContent = currency(row.amount) + ' · ' + (row.event?.title || 'Event');
                    byId('wdDecisionAccount').classList.toggle('hidden', reject);
                    byId('wdDecisionOrganizer').textContent = row.user?.username || row.user?.name || '—';
                    byId('wdDecisionBank').textContent = [row.bank, row.rekening].filter(Boolean).join(' · ') || '—';
                    byId('wdDecisionHint').textContent = reject
                        ? 'Cantumkan alasan agar organizer tahu apa yang perlu diperbaiki.'
                        : 'Periksa nominal dan rekening tujuan sebelum menyetujui pengajuan.';
                    submit.textContent = reject ? 'Tolak pengajuan' : 'Setujui penarikan';
                    dialog.showModal();
                    (reject ? reason : cancel).focus();
                };

                cancel.addEventListener('click', () => { if (!sending) dialog.close(); });
                dialog.addEventListener('cancel', (event) => { if (sending) event.preventDefault(); });
                byId('wdDecisionForm').addEventListener('submit', async (event) => {
                    event.preventDefault();
                    if (!decision || sending) return;
                    const { row, reject } = decision;
                    const note = reason.value.trim();
                    error.classList.add('hidden');
                    if (reject && !note) {
                        error.textContent = 'Isi alasan penolakan.';
                        error.classList.remove('hidden');
                        reason.focus();
                        return;
                    }

                    sending = true;
                    submit.disabled = cancel.disabled = reason.disabled = true;
                    submit.textContent = 'Memproses…';
                    try {
                        const body = new URLSearchParams({ id: row.id });
                        if (reject) body.set('catatan', note);
                        const response = await fetch(reject ? '/administrator/wd-request/tolak' : '/administrator/wd-request/accept', {
                            method: 'POST',
                            headers: { Accept: 'application/json', 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': token },
                            body,
                        });
                        const payload = await response.json();
                        if (!response.ok || !payload.success) {
                            error.textContent = payload.error || payload.message || 'Pengajuan gagal diproses.';
                            error.classList.remove('hidden');
                            return;
                        }

                        const counter = byId(reject ? 'wdRejectedCount' : 'wdApprovedCount');
                        counter.dataset.count = String(Number(counter.dataset.count) + 1);
                        counter.textContent = number.format(Number(counter.dataset.count));
                        dialog.close();
                        notice.className = 'border-b border-blue-100 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-900';
                        notice.textContent = reject ? 'Pengajuan ditolak.' : 'Penarikan disetujui.';
                        await load();
                    } catch {
                        error.textContent = 'Pengajuan gagal diproses. Coba lagi.';
                        error.classList.remove('hidden');
                    } finally {
                        sending = false;
                        submit.disabled = cancel.disabled = reason.disabled = false;
                        submit.textContent = reject ? 'Tolak pengajuan' : 'Setujui penarikan';
                    }
                });

                document.querySelectorAll('[data-wd-view]').forEach((button) => {
                    button.addEventListener('click', () => {
                        if (view === button.dataset.wdView) return;
                        view = button.dataset.wdView;
                        document.querySelectorAll('[data-wd-view]').forEach((tab) => tab.setAttribute('aria-pressed', String(tab === button)));
                        byId('wdHistoryFilter').classList.toggle('hidden', view !== 'history');
                        notice.classList.add('hidden');
                        page = 1;
                        load();
                    });
                });

                search.addEventListener('input', () => { page = 1; render(); });
                byId('wdPagination').addEventListener('click', (event) => {
                    const target = event.target.closest('[data-wd-page]');
                    if (target) {
                        page = Number(target.dataset.wdPage);
                        render();
                    }
                });

                byId('wdHistoryFilter').addEventListener('submit', (event) => {
                    event.preventDefault();
                    notice.classList.add('hidden');
                    if (start.value && end.value && start.value > end.value) {
                        notice.className = 'border-b border-amber-100 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-950';
                        notice.textContent = 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.';
                        return;
                    }
                    page = 1;
                    load();
                });

                const now = new Date();
                start.value = localDate(new Date(now.getFullYear(), now.getMonth(), 1));
                end.value = localDate(now);
                load();
            })();
        </script>
    @endpush
@endsection
