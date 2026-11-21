@extends('dashboard.layouts.app')

@section('title', $event->title . ' — Check-in')

@section('content')
    <div class="mx-auto max-w-7xl space-y-4 pb-8 sm:space-y-5 text-slate-900">
        <header class="relative isolate overflow-hidden rounded-2xl bg-gradient-to-br sm:rounded-3xl from-[#102040] via-[#183970] to-[#1857a6] px-4 py-4 text-white sm:px-8 sm:py-8">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <a href="/dashboard/event-checkin" class="inline-flex min-h-9 items-center gap-2 rounded-lg text-sm font-semibold text-blue-100 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-arrow-left" aria-hidden="true"></i> Semua event
            </a>
            <h1 class="mt-2 break-words font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-2xl font-bold tracking-tight sm:text-4xl">{{ $event->title }}</h1>
            <p class="mt-2 text-sm text-blue-100">Check-in peserta dengan scanner atau kode tiket.</p>
        </header>

        @php
            $stats = [
                ['checkinTotal', 'Peserta lunas', 'ti-users', 'bg-blue-50 text-blue-700'],
                ['checkinDone', 'Sudah check-in', 'ti-user-check', 'bg-emerald-50 text-emerald-800'],
                ['checkinRemaining', 'Belum check-in', 'ti-clock', 'bg-slate-100 text-slate-700'],
                ['checkinRate', 'Tingkat check-in', 'ti-chart-pie', 'bg-indigo-50 text-indigo-700'],
            ];
        @endphp

        <dl class="grid grid-cols-2 gap-2.5 sm:gap-3 lg:grid-cols-4">
            @foreach ($stats as [$id, $label, $icon, $tone])
                <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm sm:p-4">
                    <dt class="flex flex-wrap items-center justify-between gap-1.5 text-xs font-medium text-slate-600 sm:text-sm">
                        {{ $label }}
                        <span aria-hidden="true" class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-base {{ $tone }}"><i class="ti {{ $icon }}"></i></span>
                    </dt>
                    <dd id="{{ $id }}" class="mt-1 text-xl font-bold tracking-tight tabular-nums sm:text-2xl">—</dd>
                </div>
            @endforeach
        </dl>

        <section aria-labelledby="checkinEntryTitle" class="overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start gap-3">
                <span aria-hidden="true" class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-blue-100 text-xl text-blue-800"><i class="ti ti-qrcode"></i></span>
                <div>
                    <h2 id="checkinEntryTitle" class="font-['Sora','Inter',sans-serif] text-base font-semibold">Scan kode tiket</h2>
                    <p id="checkinCodeHint" class="mt-0.5 text-sm text-slate-600">Gunakan scanner, kamera, atau masukkan kode tiket lalu tekan Enter.</p>
                </div>
            </div>
            <form id="checkinCodeForm" class="mt-3 grid grid-cols-2 gap-2 sm:mt-4 sm:flex sm:flex-wrap sm:items-center">
                <input id="checkinCode" type="text" autofocus autocomplete="off" autocapitalize="off" spellcheck="false"
                       aria-label="Kode tiket" aria-describedby="checkinCodeHint" placeholder="Masukkan kode tiket"
                       class="col-span-2 min-h-12 min-w-0 rounded-xl sm:min-h-11 sm:min-w-[9rem] sm:flex-1 border border-slate-200 bg-white px-3 font-mono text-base focus:border-blue-400 sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-100">
                <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-xl bg-[#1765c4] px-2 text-sm sm:gap-2 sm:px-4 font-semibold text-white hover:bg-[#174f9e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <i class="ti ti-user-check" aria-hidden="true"></i> Check-in
                </button>
                <button id="checkinCameraToggle" type="button" aria-expanded="false" aria-controls="checkinCamera"
                        class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-xl border border-blue-200 bg-white px-2 text-sm sm:gap-2 sm:px-4 font-semibold text-blue-800 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <i class="ti ti-camera" aria-hidden="true"></i>
                    <span id="checkinCameraLabel">Scan kamera</span>
                </button>
            </form>

            <p id="checkinFeedback" role="status" class="mt-3 hidden rounded-xl border px-3 py-2.5 text-sm font-medium"></p>

            <div id="checkinCamera" class="mt-3 hidden w-full max-w-md">
                <div class="relative aspect-[4/3] overflow-hidden sm:aspect-video rounded-xl bg-slate-950">
                    <video id="checkinVideo" autoplay muted playsinline aria-label="Pratinjau kamera untuk scan QR"
                           class="h-full w-full object-contain"></video>
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 grid place-items-center">
                        <div class="aspect-square h-3/4 rounded-xl border-2 border-white/80"></div>
                    </div>
                </div>
                <p class="mt-2 text-xs text-slate-600">Arahkan kode QR tiket ke dalam bingkai.</p>
            </div>

        </section>

        <section aria-labelledby="checkinListTitle" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-slate-100 p-3 sm:flex-row sm:items-center sm:justify-between sm:gap-3 sm:p-4">
                <h2 id="checkinListTitle" class="font-['Sora','Inter',sans-serif] text-base font-semibold">Daftar peserta</h2>
                <label class="flex min-h-10 min-w-[10rem] flex-1 items-center gap-2 rounded-xl border border-slate-200 px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 sm:max-w-md">
                    <i class="ti ti-search text-lg text-slate-500" aria-hidden="true"></i>
                    <span class="sr-only">Cari peserta</span>
                    <input id="checkinSearch" type="search" placeholder="Nama, email, atau kode tiket"
                           class="w-full min-w-0 bg-transparent text-sm outline-none placeholder:text-slate-500">
                </label>
            </div>

            <div id="checkinLoading" role="status" class="flex justify-center gap-2 p-8 text-sm text-slate-600"><i class="ti ti-loader-2 animate-spin" aria-hidden="true"></i> Memuat peserta…</div>
            <div id="checkinEmpty" class="hidden space-y-2 p-8 text-center text-sm text-slate-600">
                <i class="ti ti-users-off text-2xl text-blue-700" aria-hidden="true"></i>
                <p id="checkinEmptyTitle" class="font-semibold text-slate-950"></p>
                <p id="checkinEmptyText"></p>
            </div>

            <div id="checkinTableWrap" class="hidden">
                <div tabindex="0" role="region" aria-label="Daftar peserta check-in"
                     class="lg:overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                    <table role="table" class="block w-full text-left text-sm lg:table lg:min-w-[42rem] lg:[&_td]:border-t lg:[&_td]:border-slate-100 lg:[&_td]:px-4 lg:[&_td]:py-3 [&_th]:bg-slate-50 [&_th]:px-4 [&_th]:py-3 [&_th]:font-semibold [&_th]:text-slate-600">
                        <thead role="rowgroup" class="sr-only lg:not-sr-only">
                            <tr role="row">
                                <th scope="col" role="columnheader">Peserta</th><th scope="col" role="columnheader">Email</th><th scope="col" role="columnheader">Kode tiket</th>
                                <th scope="col" role="columnheader">Status</th><th scope="col" role="columnheader" class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="checkinRows" role="rowgroup" class="block lg:table-row-group"></tbody>
                    </table>
                </div>

                <nav aria-label="Halaman peserta" class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-4 py-3">
                    <p id="checkinRange" class="text-xs tabular-nums text-slate-600" aria-live="polite"></p>
                    <div id="checkinPager" class="flex items-center gap-2">
                        <button id="checkinPrev" type="button" aria-label="Halaman sebelumnya" class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-40"><i class="ti ti-chevron-left" aria-hidden="true"></i></button>
                        <span id="checkinPage" class="text-xs font-semibold tabular-nums text-blue-800"></span>
                        <button id="checkinNext" type="button" aria-label="Halaman berikutnya" class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-40"><i class="ti ti-chevron-right" aria-hidden="true"></i></button>
                    </div>
                </nav>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js" defer></script>
        <script>
            (() => {
                const byId = (id) => document.getElementById(id);
                const eventId = @json($event->event_id);
                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const codeInput = byId('checkinCode');
                const searchInput = byId('checkinSearch');
                const feedback = byId('checkinFeedback');
                const rowsEl = byId('checkinRows');
                const previous = byId('checkinPrev');
                const next = byId('checkinNext');
                const pageSize = 20;
                const formatNumber = new Intl.NumberFormat('id-ID');
                const pending = new Set();
                let page = 1;
                let rows = [];
                let loaded = false;

                const notify = (message, success = false) => {
                    feedback.textContent = message;
                    feedback.classList.remove('hidden');
                    for (const cls of ['bg-emerald-50', 'border-emerald-100', 'text-emerald-900']) feedback.classList.toggle(cls, success);
                    for (const cls of ['bg-amber-50', 'border-amber-100', 'text-amber-950']) feedback.classList.toggle(cls, !success);
                };

                const setEmpty = (title, description) => {
                    byId('checkinEmptyTitle').textContent = title;
                    byId('checkinEmptyText').textContent = description;
                    byId('checkinEmpty').classList.remove('hidden');
                };

                const cell = (value, classes = '') => {
                    const element = document.createElement('td');
                    element.className = 'block min-w-0 lg:table-cell ' + classes;
                    element.setAttribute('role', 'cell');
                    element.textContent = value || '—';
                    return element;
                };

                const render = () => {
                    if (!loaded) return;

                    const total = rows.length;
                    const done = rows.filter((row) => row.checked_in_at).length;
                    byId('checkinTotal').textContent = formatNumber.format(total);
                    byId('checkinDone').textContent = formatNumber.format(done);
                    byId('checkinRemaining').textContent = formatNumber.format(total - done);
                    byId('checkinRate').textContent = total ? Math.round(done / total * 100) + '%' : '0%';

                    const term = searchInput.value.trim().toLowerCase();
                    const filtered = rows.filter((row) => !term || [row.name, row.email, row.ticket_code]
                        .some((value) => String(value ?? '').toLowerCase().includes(term)));

                    rowsEl.replaceChildren();
                    byId('checkinEmpty').classList.toggle('hidden', Boolean(filtered.length));
                    byId('checkinTableWrap').classList.toggle('hidden', !filtered.length);
                    if (!filtered.length) {
                        if (term) setEmpty('Peserta tidak ditemukan', 'Coba nama, email, atau kode tiket lain.');
                        else setEmpty('Belum ada peserta lunas', 'Peserta muncul setelah pembayaran berhasil.');
                        return;
                    }

                    const pages = Math.ceil(filtered.length / pageSize);
                    page = Math.min(Math.max(page, 1), pages);
                    const offset = (page - 1) * pageSize;
                    const visible = filtered.slice(offset, offset + pageSize);
                    byId('checkinRange').textContent = `${formatNumber.format(offset + 1)}–${formatNumber.format(offset + visible.length)} dari ${formatNumber.format(filtered.length)} peserta`;
                    byId('checkinPage').textContent = `${page} / ${pages}`;
                    byId('checkinPager').classList.toggle('hidden', pages <= 1);
                    previous.disabled = page === 1;
                    next.disabled = page === pages;

                    for (const row of visible) {
                        const checked = Boolean(row.checked_in_at);
                        const rowPending = pending.has(String(row.participant_id));
                        const tr = document.createElement('tr');
                        tr.className = 'grid grid-cols-[minmax(0,1fr)_auto] items-center gap-x-2 gap-y-1 border-b border-slate-100 p-3 last:border-0 hover:bg-blue-50/40 lg:table-row lg:border-0 lg:p-0';
                        tr.setAttribute('role', 'row');

                        const statusCell = cell('', 'row-start-1 col-start-2 justify-self-end lg:justify-self-auto');
                        statusCell.textContent = '';
                        const badge = document.createElement('span');
                        badge.className = checked
                            ? 'inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800'
                            : 'inline-flex whitespace-nowrap rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700';
                        badge.textContent = checked ? 'Sudah check-in' : 'Belum check-in';
                        statusCell.append(badge);

                        const action = cell('', 'justify-self-end text-right lg:justify-self-auto');
                        action.textContent = '';
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'min-h-11 whitespace-nowrap rounded-lg border border-blue-100 lg:min-h-9 bg-blue-50 px-2.5 text-xs font-semibold text-blue-800 hover:bg-blue-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-50';
                        button.textContent = checked ? 'Selesai' : rowPending ? 'Memproses…' : 'Check-in';
                        button.disabled = checked || rowPending;
                        button.addEventListener('click', () => checkIn(row));
                        action.append(button);

                        tr.append(cell(row.name, 'row-start-1 col-start-1 break-words font-semibold text-slate-900'),
                            cell(row.email, 'col-span-2 break-all text-xs text-slate-600 lg:text-sm'),
                            cell(row.ticket_code, 'break-all font-mono text-xs text-slate-700'), statusCell, action);
                        rowsEl.append(tr);
                    }
                };

                const checkIn = async (row) => {
                    const id = String(row.participant_id ?? '');
                    if (!id || pending.has(id) || row.checked_in_at) return false;
                    pending.add(id);
                    render();

                    try {
                        const response = await fetch('/dashboard/participant-checkin', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded', Accept: 'application/json', 'X-CSRF-TOKEN': token },
                            body: new URLSearchParams({ id }),
                        });
                        const payload = await response.json();
                        if (!response.ok || !payload.success) {
                            notify(payload.error || 'Gagal check-in.');
                            return false;
                        }
                        row.checked_in_at = new Date().toISOString();
                        notify((row.name || 'Peserta') + ' berhasil check-in.', true);
                        return true;
                    } catch {
                        notify('Gagal check-in. Coba lagi.');
                        return false;
                    } finally {
                        pending.delete(id);
                        render();
                    }
                };

                const scanTicket = (value) => {
                    const code = value.trim().toLowerCase();

                    codeInput.value = '';
                    codeInput.focus({ preventScroll: true });

                    if (!code) return;
                    if (!loaded) {
                        notify('Daftar peserta belum tersedia.');
                        return;
                    }

                    const row = rows.find((item) => String(item.ticket_code ?? '').toLowerCase() === code);
                    if (!row) {
                        notify('Kode tiket tidak ditemukan.');
                        return;
                    }
                    if (row.checked_in_at) {
                        notify('Peserta sudah check-in.');
                        return;
                    }
                    if (pending.has(String(row.participant_id))) return;

                    checkIn(row);
                };

                byId('checkinCodeForm').addEventListener('submit', (event) => {
                    event.preventDefault();
                    scanTicket(codeInput.value);
                });

                const cameraToggle = byId('checkinCameraToggle');
                const cameraPanel = byId('checkinCamera');
                const cameraLabel = byId('checkinCameraLabel');
                const video = byId('checkinVideo');
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d', { willReadFrequently: true });
                let cameraStream = null;
                let cameraVersion = 0;
                let cameraStarting = false;
                let frameId = 0;
                let lastFrame = 0;
                let lastCode = '';
                let lastSeen = 0;

                const stopCamera = () => {
                    cameraVersion++;
                    cameraStarting = false;
                    cancelAnimationFrame(frameId);
                    cameraStream?.getTracks().forEach((track) => track.stop());
                    cameraStream = null;
                    video.pause();
                    video.srcObject = null;
                    codeInput.removeAttribute('inputmode');
                    cameraPanel.classList.add('hidden');
                    cameraToggle.setAttribute('aria-expanded', 'false');
                    cameraLabel.textContent = 'Scan kamera';
                };

                const scanFrame = (timestamp) => {
                    if (!cameraStream) return;
                    frameId = requestAnimationFrame(scanFrame);
                    if (timestamp - lastFrame < 150 || video.readyState < 2 || !video.videoWidth) return;
                    lastFrame = timestamp;

                    const scale = Math.min(1, 640 / Math.max(video.videoWidth, video.videoHeight));
                    const width = Math.round(video.videoWidth * scale);
                    const height = Math.round(video.videoHeight * scale);
                    if (canvas.width !== width) canvas.width = width;
                    if (canvas.height !== height) canvas.height = height;
                    context.drawImage(video, 0, 0, width, height);

                    const pixels = context.getImageData(0, 0, width, height);
                    const qr = window.jsQR(pixels.data, width, height);
                    if (!qr?.data) return;

                    const code = qr.data.trim().toLowerCase();
                    if (code !== lastCode || timestamp - lastSeen > 1200) scanTicket(code);
                    lastCode = code;
                    lastSeen = timestamp;
                };

                cameraToggle.addEventListener('click', async () => {
                    if (cameraStream || cameraStarting) {
                        stopCamera();
                        codeInput.focus({ preventScroll: true });
                        return;
                    }

                    if (!window.isSecureContext || !navigator.mediaDevices?.getUserMedia) {
                        notify('Kamera memerlukan HTTPS dan browser yang mendukung akses kamera.');
                        return;
                    }
                    if (!context || typeof window.jsQR !== 'function') {
                        notify('Pemindai kamera belum tersedia. Gunakan scanner atau masukkan kode tiket.');
                        return;
                    }

                    const version = ++cameraVersion;
                    cameraStarting = true;
                    cameraLabel.textContent = 'Batalkan kamera';
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({
                            audio: false,
                            video: { facingMode: { ideal: 'environment' } },
                        });

                        if (version !== cameraVersion) {
                            stream.getTracks().forEach((track) => track.stop());
                            return;
                        }
                        cameraStream = stream;
                        video.srcObject = stream;
                        cameraPanel.classList.remove('hidden');
                        cameraToggle.setAttribute('aria-expanded', 'true');
                        await video.play();
                        if (version !== cameraVersion) return;
                        cameraStarting = false;
                        cameraLabel.textContent = 'Matikan kamera';
                        codeInput.setAttribute('inputmode', 'none');
                        if (document.activeElement === codeInput) codeInput.blur();
                        codeInput.focus({ preventScroll: true });
                        lastFrame = 0;
                        lastCode = '';
                        lastSeen = 0;
                        frameId = requestAnimationFrame(scanFrame);
                    } catch (error) {
                        if (version !== cameraVersion) return;
                        stopCamera();
                        notify(error?.name === 'NotAllowedError'
                            ? 'Akses kamera ditolak. Izinkan kamera di browser atau masukkan kode tiket.'
                            : 'Kamera tidak bisa dibuka. Gunakan scanner atau masukkan kode tiket.');
                    }
                });

                window.addEventListener('pagehide', stopCamera);

                searchInput.addEventListener('input', () => { page = 1; render(); });
                previous.addEventListener('click', () => { page--; render(); });
                next.addEventListener('click', () => { page++; render(); });

                const load = async () => {
                    try {
                        const query = new URLSearchParams({ event_id: eventId, status: 'Paid' });
                        const response = await fetch('/dashboard/get-participant?' + query, { headers: { Accept: 'application/json' } });
                        if (!response.ok) throw new Error('Gagal memuat peserta');
                        const payload = await response.json();
                        rows = Array.isArray(payload.data) ? payload.data : [];
                        loaded = true;
                        render();
                    } catch {
                        setEmpty('Gagal memuat peserta', 'Periksa akses event atau coba muat ulang halaman.');
                    } finally {
                        byId('checkinLoading').classList.add('hidden');
                    }
                };

                codeInput.focus({ preventScroll: true });
                load();
            })();
        </script>
    @endpush
@endsection
