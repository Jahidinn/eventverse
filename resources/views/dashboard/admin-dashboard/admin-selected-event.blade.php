@extends('dashboard.layouts.app')

@section('title', 'Featured events')

@section('content')
    @php
        $secondary = 'inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition-colors hover:border-blue-200 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50';
        $searchClass = 'flex min-h-11 items-center gap-2.5 rounded-xl border border-slate-200 bg-slate-50 px-3 focus-within:border-blue-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100';
    @endphp

    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Featured Events</h1>
                <p class="mt-2 text-sm leading-6 text-blue-100">Kelola event pilihan yang ditampilkan di Eventverse.</p>
            </div>
            <button type="button" id="openAddSelected" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-plus text-lg" aria-hidden="true"></i> Tambah event pilihan
            </button>
        </header>

        <section aria-labelledby="selectedTitle" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="space-y-3 border-b border-slate-200 p-4 sm:p-5">
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                    <h2 id="selectedTitle" class="font-['Sora','Inter',sans-serif] text-base font-semibold tracking-tight">Daftar event pilihan</h2>
                    <span id="selectedCount" class="text-xs font-semibold tabular-nums text-slate-600"></span>
                </div>
                <label class="{{ $searchClass }}">
                    <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                    <span class="sr-only">Cari event pilihan</span>
                    <input id="selectedSearch" type="search" placeholder="Cari judul atau slug event"
                           class="min-w-0 flex-1 bg-transparent text-base outline-none placeholder:text-slate-500 sm:text-sm">
                </label>
            </div>

            <p id="selectedNotice" role="status" class="hidden border-b px-4 py-3 text-sm font-medium"></p>
            <p id="selectedState" role="status" class="px-4 py-10 text-center text-sm text-slate-600">Memuat event pilihan…</p>
            <div id="selectedTableWrap" class="hidden">
                <table role="table" class="block w-full text-left text-sm md:table md:[&_td]:border-b md:[&_td]:border-slate-100 md:[&_td]:px-5 md:[&_td]:py-3.5 [&_th]:bg-slate-50 [&_th]:px-5 [&_th]:py-3 [&_th]:text-xs [&_th]:font-semibold [&_th]:text-slate-600">
                    <thead role="rowgroup" class="sr-only md:not-sr-only">
                        <tr role="row">
                            <th scope="col" role="columnheader">Event</th>
                            <th scope="col" role="columnheader">Status</th>
                            <th scope="col" role="columnheader" class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="selectedRows" role="rowgroup" class="block space-y-2 bg-slate-50 p-2.5 md:table-row-group md:space-y-0 md:bg-white md:p-0"></tbody>
                </table>

                <nav aria-label="Halaman event pilihan" class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-4 py-3 sm:px-5">
                    <p id="selectedRange" aria-live="polite" class="text-xs tabular-nums text-slate-600"></p>
                    <div id="selectedPager" class="flex flex-wrap items-center gap-1.5"></div>
                </nav>
            </div>
        </section>
    </div>

    <dialog id="selectedDrawer" aria-labelledby="selectedDrawerTitle"
            class="fixed inset-y-0 left-auto right-0 m-0 h-dvh max-h-none w-full max-w-lg overflow-y-auto overscroll-contain border-0 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <header class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white px-5 py-4">
            <div>
                <h2 id="selectedDrawerTitle" class="font-['Sora','Inter',sans-serif] text-lg font-semibold tracking-tight">Tambah event pilihan</h2>
                <p class="mt-1 text-sm text-slate-600">Pilih event untuk ditambahkan ke daftar pilihan.</p>
            </div>
            <form method="dialog">
                <button type="submit" aria-label="Tutup" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                    <i class="ti ti-x" aria-hidden="true"></i>
                </button>
            </form>
        </header>
        <div class="space-y-3 p-5">
            <label class="{{ $searchClass }}">
                <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                <span class="sr-only">Cari kandidat event pilihan</span>
                <input id="selectedCandidateSearch" type="search" autofocus placeholder="Cari judul atau slug event"
                       class="min-w-0 flex-1 bg-transparent text-base outline-none placeholder:text-slate-500 sm:text-sm">
            </label>
            <p id="selectedCandidateNotice" role="status" class="hidden rounded-xl px-3 py-2.5 text-sm font-medium"></p>
            <p id="selectedCandidateState" role="status" class="py-8 text-center text-sm text-slate-600"></p>
            <ul id="selectedCandidateList" class="space-y-2"></ul>
        </div>
    </dialog>

    @push('scripts')
        <script>
            (() => {
                const byId = (id) => document.getElementById(id);
                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const search = byId('selectedSearch');
                const rowsEl = byId('selectedRows');
                const table = byId('selectedTableWrap');
                const drawer = byId('selectedDrawer');
                const candidateSearch = byId('selectedCandidateSearch');
                const candidateList = byId('selectedCandidateList');
                const pager = byId('selectedPager');
                const pageSize = 15;
                const number = new Intl.NumberFormat('id-ID');
                const button = @json($secondary);
                let rows = [];
                let candidates = [];
                let page = 1;
                let rowsReady = false;
                let candidatesReady = false;
                let candidateVersion = 0;
                let changing = false;

                const esc = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
                })[character]);

                const matches = (row, query) => !query || [row.title, row.slug]
                    .some((value) => String(value ?? '').toLowerCase().includes(query));

                const showNotice = (id, message, success) => {
                    const element = byId(id);
                    element.textContent = message;
                    element.className = 'px-4 py-3 text-sm font-medium ' + (success
                        ? 'bg-emerald-50 text-emerald-900' : 'bg-amber-50 text-amber-950');
                };

                const getRows = async (url) => {
                    const response = await fetch(url, { headers: { Accept: 'application/json' } });
                    if (!response.ok) throw new Error('Gagal memuat');
                    const payload = await response.json();
                    return Array.isArray(payload.data) ? payload.data : [];
                };

                const renderSelected = () => {
                    if (!rowsReady) return;
                    const query = search.value.trim().toLowerCase();
                    const filtered = rows.filter((row) => matches(row, query));
                    byId('selectedCount').textContent = number.format(filtered.length) + (query ? ' hasil' : ' event');
                    const state = byId('selectedState');
                    table.classList.toggle('hidden', !filtered.length);
                    state.classList.toggle('hidden', Boolean(filtered.length));

                    if (!filtered.length) {
                        state.textContent = query ? 'Tidak ada event yang cocok dengan pencarian.' : 'Belum ada event pilihan.';
                        return;
                    }

                    const pages = Math.ceil(filtered.length / pageSize);
                    page = Math.min(Math.max(page, 1), pages);
                    const offset = (page - 1) * pageSize;
                    const visible = filtered.slice(offset, offset + pageSize);
                    rowsEl.innerHTML = visible.map((row, index) => `<tr role="row" class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-2 rounded-xl border border-slate-200 bg-white p-3.5 md:table-row md:rounded-none md:border-0 md:p-0 md:even:bg-slate-50/60 md:hover:bg-blue-50/70">
                        <td role="cell" class="col-span-2 min-w-0 md:table-cell">
                            <span class="block break-words font-semibold text-slate-950">${esc(row.title || 'Event')}</span>
                            <span class="block break-all font-mono text-xs text-slate-600">${esc(row.slug || '')}</span>
                        </td>
                        <td role="cell" class="md:table-cell">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-800"><span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-current"></span> Event pilihan</span>
                        </td>
                        <td role="cell" class="text-right md:table-cell">
                            <button type="button" data-remove-selected="${index}" class="${button}">Keluarkan<span class="sr-only"> event pilihan ${esc(row.title || 'event')}</span></button>
                        </td>
                    </tr>`).join('');
                    rowsEl.onclick = (event) => {
                        const target = event.target.closest('[data-remove-selected]');
                        if (!target || changing || !window.confirm('Keluarkan event dari daftar pilihan?')) return;
                        const row = visible[Number(target.dataset.removeSelected)];
                        updateSelected(row, false, target);
                    };

                    byId('selectedRange').textContent = `${number.format(offset + 1)}–${number.format(offset + visible.length)} dari ${number.format(filtered.length)} event`;
                    const numbered = [...new Set([1, page - 1, page, page + 1, pages])]
                        .filter((target) => target >= 1 && target <= pages).sort((a, b) => a - b);
                    const link = (target, label, description) => `<button type="button" data-page="${target}" aria-label="${description}" class="${button} min-w-10">${label}</button>`;
                    pager.innerHTML = pages <= 1 ? '' : [
                        page > 1 ? link(page - 1, '<i class="ti ti-chevron-left" aria-hidden="true"></i>', 'Halaman sebelumnya') : '',
                        ...numbered.flatMap((target, index) => [
                            index > 0 && target - numbered[index - 1] > 1 ? '<span aria-hidden="true" class="px-1 text-slate-500">…</span>' : '',
                            target === page ? `<span aria-current="page" tabindex="-1" class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-xl bg-blue-50 text-sm font-semibold text-blue-800 ring-1 ring-inset ring-blue-200">${target}</span>` : link(target, target, 'Halaman ' + target),
                        ]),
                        page < pages ? link(page + 1, '<i class="ti ti-chevron-right" aria-hidden="true"></i>', 'Halaman berikutnya') : '',
                    ].join('');
                };

                const loadSelected = async () => {
                    rowsReady = false;
                    const state = byId('selectedState');
                    state.textContent = 'Memuat event pilihan…';
                    state.classList.remove('hidden');
                    table.classList.add('hidden');

                    try {
                        rows = await getRows('/administrator/event-management/get-selected');
                        rowsReady = true;
                        renderSelected();
                    } catch {
                        state.textContent = 'Gagal memuat event pilihan. Coba muat ulang halaman.';
                    }
                };

                const renderCandidates = () => {
                    if (!candidatesReady) return;
                    const query = candidateSearch.value.trim().toLowerCase();
                    const filtered = candidates.filter((row) => matches(row, query));
                    const state = byId('selectedCandidateState');
                    state.classList.toggle('hidden', Boolean(filtered.length));
                    state.textContent = query ? 'Tidak ada kandidat yang cocok.' : 'Belum ada kandidat event pilihan.';

                    candidateList.innerHTML = filtered.map((row, index) => `<li class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div class="min-w-0 flex-1"><p class="break-words text-sm font-semibold">${esc(row.title || 'Event')}</p><p class="break-all font-mono text-xs text-slate-600">${esc(row.slug || '')}</p></div>
                        <button type="button" data-select-candidate="${index}" class="inline-flex min-h-10 items-center gap-1.5 rounded-xl bg-[#1765c4] px-3 text-xs font-semibold text-white hover:bg-[#174f9e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50">
                            <i class="ti ti-plus" aria-hidden="true"></i> Pilih<span class="sr-only"> ${esc(row.title || 'event')}</span>
                        </button>
                    </li>`).join('');
                    candidateList.onclick = (event) => {
                        const target = event.target.closest('[data-select-candidate]');
                        if (target) updateSelected(filtered[Number(target.dataset.selectCandidate)], true, target);
                    };
                };

                const loadCandidates = async () => {
                    const version = ++candidateVersion;
                    candidatesReady = false;
                    candidateList.replaceChildren();
                    const state = byId('selectedCandidateState');
                    state.textContent = 'Memuat kandidat…';
                    state.classList.remove('hidden');
                    try {
                        const result = await getRows('/administrator/event-management/get-event');
                        if (version !== candidateVersion || !drawer.open) return;
                        candidates = result;
                        candidatesReady = true;
                        renderCandidates();
                    } catch {
                        if (version === candidateVersion && drawer.open) state.textContent = 'Gagal memuat kandidat. Tutup panel dan coba lagi.';
                    }
                };

                const updateSelected = async (row, select, source) => {
                    if (changing || row?.id == null) return;
                    changing = true;
                    source.disabled = true;
                    const notice = select ? 'selectedCandidateNotice' : 'selectedNotice';
                    byId(notice).classList.add('hidden');
                    try {
                        const response = await fetch(select ? '/administrator/event-management/select-event' : '/administrator/event-management/unselect-event', {
                            method: 'POST',
                            headers: { Accept: 'application/json', 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': token },
                            body: new URLSearchParams({ id: row.id }),
                        });
                        const payload = await response.json();
                        if (!response.ok || !payload.success) {
                            showNotice(notice, payload.error || 'Perubahan daftar pilihan gagal disimpan.', false);
                            return;
                        }
                        showNotice('selectedNotice', select ? 'Event ditambahkan ke daftar pilihan.' : 'Event dikeluarkan dari daftar pilihan.', true);
                        if (select && drawer.open) showNotice(notice, 'Event ditambahkan ke daftar pilihan.', true);
                        await loadSelected();
                        if (drawer.open) await loadCandidates();
                    } catch {
                        showNotice(notice, 'Perubahan daftar pilihan gagal disimpan. Coba lagi.', false);
                    } finally {
                        changing = false;
                        source.disabled = false;
                    }
                };

                search.addEventListener('input', () => { page = 1; renderSelected(); });
                candidateSearch.addEventListener('input', renderCandidates);
                pager.addEventListener('click', (event) => {
                    const target = event.target.closest('[data-page]');
                    if (!target) return;
                    page = Number(target.dataset.page);
                    renderSelected();
                    pager.querySelector('[aria-current="page"]')?.focus();
                });

                byId('openAddSelected').addEventListener('click', () => {
                    if (drawer.open) return;
                    candidateSearch.value = '';
                    byId('selectedCandidateNotice').classList.add('hidden');
                    drawer.showModal();
                    loadCandidates();
                });
                drawer.addEventListener('close', () => { candidateVersion++; });
                drawer.addEventListener('click', (event) => {
                    if (event.target !== drawer) return;
                    const bounds = drawer.getBoundingClientRect();
                    if (event.clientX < bounds.left || event.clientX > bounds.right
                        || event.clientY < bounds.top || event.clientY > bounds.bottom) drawer.close();
                });
                loadSelected();
            })();
        </script>
    @endpush
@endsection
