@extends('dashboard.layouts.app')

@section('title', 'Organization')

@section('content')
    <div class="mx-auto max-w-7xl space-y-5 pb-8 text-slate-900">
        <header class="relative isolate flex flex-wrap items-end justify-between gap-4 overflow-hidden rounded-3xl bg-gradient-to-br from-[#102040] via-[#183970] to-[#1857a6] px-5 py-7 text-white sm:px-8 sm:py-9">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-1/2 bg-[repeating-linear-gradient(135deg,transparent_0_19px,rgba(147,197,253,0.23)_19px_20px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>
            <div>
                <h1 class="font-['Sora','Plus_Jakarta_Sans','Inter',sans-serif] text-3xl font-bold tracking-tight sm:text-4xl">Organisasi</h1>
                <p class="mt-2 text-sm leading-6 text-blue-100">Kelola organisasi, anggota, dan permintaan bergabung.</p>
            </div>
            <button type="button" id="createOrgButton" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-blue-900 hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <i class="ti ti-plus text-lg" aria-hidden="true"></i> Buat organisasi
            </button>
        </header>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 p-3 sm:p-4">
                <div class="flex flex-wrap items-center gap-1 rounded-xl bg-slate-100 p-1" role="group" aria-label="Filter organisasi">
                    <button type="button" class="org-tab min-h-9 rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-white/75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 aria-pressed:bg-white aria-pressed:text-blue-800 aria-pressed:shadow-sm sm:text-sm" aria-pressed="true" data-tab="mine">Organisasi saya</button>
                    <button type="button" class="org-tab min-h-9 rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-white/75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 aria-pressed:bg-white aria-pressed:text-blue-800 aria-pressed:shadow-sm sm:text-sm" aria-pressed="false" data-tab="following">Diikuti</button>
                    <button type="button" class="org-tab min-h-9 rounded-lg px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-white/75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 aria-pressed:bg-white aria-pressed:text-blue-800 aria-pressed:shadow-sm sm:text-sm" aria-pressed="false" data-tab="explore">Jelajahi</button>
                </div>
                <div class="flex min-h-11 w-full min-w-0 basis-full items-center sm:flex-1 sm:basis-auto gap-2 rounded-xl border border-slate-200 px-3 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 sm:min-w-[14rem]">
                    <i class="ti ti-search shrink-0 text-lg text-slate-500" aria-hidden="true"></i>
                    <input id="orgSearch" aria-label="Cari organisasi" class="w-full min-w-0 bg-transparent text-sm outline-none placeholder:text-slate-500" type="search" placeholder="Cari organisasi...">
                </div>
            </div>

            <div class="p-3 sm:p-4">
                <div id="orgLoading" role="status" class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950">
                    <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-loader-2 animate-spin"></i></span>
                    <strong>Memuat organisasi...</strong>
                </div>
                <div id="orgEmpty" role="status" class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950 hidden">
                    <span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-users-group"></i></span>
                    <strong>Belum ada organisasi</strong>
                    <p>Data organisasi akan muncul di sini.</p>
                </div>
                <div id="orgGridWrap" class="hidden"><div id="orgGrid" class="grid gap-3 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"></div></div>
            </div>
        </div>

    </div>

    <dialog id="orgDrawer" aria-labelledby="orgDrawerTitle"
            class="fixed inset-y-0 left-auto right-0 m-0 h-dvh max-h-none w-full max-w-lg overflow-y-auto overscroll-contain border-0 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/50">
        <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white px-5 py-4">
            <div class="min-w-0">
                <h2 id="orgDrawerTitle" class="font-['Sora','Inter',sans-serif] text-lg font-semibold tracking-tight">Organisasi</h2>
                <p id="orgDrawerSub" class="mt-1 break-words text-sm text-slate-600"></p>
            </div>
            <form method="dialog">
                <button type="submit" autofocus aria-label="Tutup" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-lg text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                    <i class="ti ti-x" aria-hidden="true"></i>
                </button>
            </form>
        </div>
        <div id="orgDrawerBody" class="space-y-4 p-5"></div>
    </dialog>

    @push('scripts')
        <script>
            (function () {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const grid = document.getElementById('orgGrid');
                const loading = document.getElementById('orgLoading');
                const empty = document.getElementById('orgEmpty');
                const search = document.getElementById('orgSearch');
                const drawer = document.getElementById('orgDrawer');
                const gridWrap = document.getElementById('orgGridWrap');
                const drawerTitle = document.getElementById('orgDrawerTitle');
                const drawerSub = document.getElementById('orgDrawerSub');
                const drawerBody = document.getElementById('orgDrawerBody');
                let tab = 'mine';
                let items = [];
                let listRequest = 0;
                let drawerRequest = 0;
                let listReady = false;

                const esc = function (value) {
                    const div = document.createElement('div');
                    div.textContent = value == null ? '' : String(value);
                    return div.innerHTML.replace(/"/g, '&quot;');
                };

                const request = async function (url, body, method) {
                    const response = await fetch(url, {
                        method: method || 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: body,
                    });
                    return response.json();
                };

                const open = function (heading, sub) {
                    drawerTitle.textContent = heading;
                    drawerSub.textContent = sub || '';
                    if (!drawer.open) drawer.showModal();
                    return ++drawerRequest;
                };
                const close = () => drawer.close();

                const imageUrl = function (image) {
                    return image ? '/storage/organization-images/' + encodeURIComponent(image) : null;
                };

                const config = {
                    mine: { url: '/dashboard/get-myorganization', label: 'Organisasi saya' },
                    following: { url: '/dashboard/get-foll-organization', label: 'Organisasi diikuti' },
                    explore: { url: '/dashboard/get-organization', label: 'Jelajahi organisasi' },
                };

                let render = function () {
                    if (!listReady) return;
                    const term = (search.value || '').toLowerCase().trim();
                    const filtered = items.filter((row) => {
                        const name = tab === 'following' ? row.org?.org_name : row.org_name;
                        if (tab === 'following' && !row.org) return false;
                        return !term || String(name || '').toLowerCase().includes(term);
                    });

                    grid.innerHTML = '';
                    filtered.forEach((row) => {
                        const org = tab === 'following' ? row.org : row;
                        if (!org) return;
                        const title = org.org_name || 'Organisasi';
                        const image = imageUrl(org.org_image);
                        const position = tab === 'following' ? row.position : null;
                        const card = document.createElement('article');
                        card.className = 'flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition-colors hover:border-blue-200';
                        card.innerHTML = `
                            <div class="relative h-24 overflow-hidden bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100" >
                                <div class="absolute inset-0 grid place-items-center text-3xl text-blue-500"><i class="ti ti-building-community"></i></div>
                                ${image ? `<img src="${image}" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-contain p-3" onerror="this.hidden = true">` : ''}
                            </div>
                            <div class="flex min-w-0 flex-1 flex-col p-3.5">
                                <span class="break-words font-['Sora','Inter',sans-serif] text-base font-semibold leading-snug tracking-tight text-slate-950">${esc(title)}</span>
                                <div class="mt-1 break-words text-xs text-slate-600">${esc(org.org_institution || 'Organisasi')}</div>
                                <div class="mt-2 flex flex-wrap gap-1">
                                    ${position ? `<span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium ${position === 'Owner' ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-700'}">${esc(position)}</span>` : ''}
                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">${esc(org.org_type || 'Public')}</span>
                                </div>
                                <div class="mt-auto flex flex-wrap items-center gap-1.5 pt-3">
                                    ${tab === 'mine' ? `
                                        <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] manage-org" data-id="${esc(org.id)}" data-name="${esc(title)}"><i class="ti ti-settings"></i> Kelola</button>
                                        <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 edit-org" data-id="${esc(org.id)}"><i class="ti ti-pencil"></i> Edit</button>
                                        <button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 delete-org" aria-label="Hapus organisasi" title="Hapus organisasi" data-id="${esc(org.id)}"><i class="ti ti-trash"></i></button>
                                    ` : ''}
                                    ${tab === 'following' ? `
                                        ${row.position === 'Owner' ? '' : `<button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 unfollow-org" data-id="${esc(row.id)}"><i class="ti ti-logout"></i> Keluar</button>`}
                                    ` : ''}
                                    ${tab === 'explore' ? `<button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] follow-org" data-id="${esc(org.id)}"><i class="ti ti-plus"></i> Ikuti</button>` : ''}
                                </div>
                            </div>
                        `;
                        grid.appendChild(card);
                    });

                    loading.classList.add('hidden');
                    empty.querySelector('strong').textContent = term ? 'Organisasi tidak ditemukan' : 'Belum ada organisasi';
                    empty.querySelector('p').textContent = term ? 'Coba kata kunci lain.' : 'Organisasi akan muncul di sini.';
                    empty.classList.toggle('hidden', filtered.length > 0);
                    gridWrap.classList.toggle('hidden', filtered.length === 0);
                };

                const load = async function () {
                    const version = ++listRequest;
                    listReady = false;
                    loading.classList.remove('hidden');
                    empty.classList.add('hidden');
                    gridWrap.classList.add('hidden');
                    try {
                        const response = await fetch(config[tab].url, { headers: { 'Accept': 'application/json' } });
                        if (!response.ok) throw new Error('failed');
                        const payload = await response.json();
                        if (version !== listRequest) return;
                        items = Array.isArray(payload.data) ? payload.data : [];
                        listReady = true;
                        render();
                    } catch (e) {
                        if (version !== listRequest) return;
                        loading.classList.add('hidden');
                        empty.classList.remove('hidden');
                        empty.querySelector('strong').textContent = 'Gagal memuat organisasi';
                        empty.querySelector('p').textContent = 'Coba lagi beberapa saat.';
                    }
                };

                const orgForm = function (edit, data) {
                    open(edit ? 'Edit organisasi' : 'Buat organisasi', edit ? 'Perbarui data organisasi.' : 'Lengkapi data organisasi.');
                    drawerBody.innerHTML = `
                        <div class="mb-3"><label for="orgName" class="mb-1 block text-sm font-semibold text-slate-700">Nama organisasi</label><input id="orgName" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" value="${esc(data?.org_name || '')}"></div>
                        <div class="mb-3"><label for="orgInstitution" class="mb-1 block text-sm font-semibold text-slate-700">Institusi</label><input id="orgInstitution" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" value="${esc(data?.org_institution || '')}"></div>
                        <div class="mb-3"><label for="orgAddress" class="mb-1 block text-sm font-semibold text-slate-700">Alamat</label><input id="orgAddress" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" value="${esc(data?.org_address || '')}"></div>
                        <div class="mb-3"><label for="orgContact" class="mb-1 block text-sm font-semibold text-slate-700">Kontak</label><input id="orgContact" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" value="${esc(data?.org_contact || '')}"></div>
                        <div class="mb-3"><label for="orgType" class="mb-1 block text-sm font-semibold text-slate-700">Tipe</label><select id="orgType" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"><option value="Public" ${data?.org_type === 'Public' ? 'selected' : ''}>Public</option><option value="Private" ${data?.org_type === 'Private' ? 'selected' : ''}>Private</option></select></div>
                        <div class="mb-3"><label for="orgLogo" class="mb-1 block text-sm font-semibold text-slate-700">Logo</label><input id="orgLogo" type="file" class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" accept="image/*"></div>
                        <div id="orgFormError" role="alert" class="mb-2 hidden rounded-lg bg-amber-50 px-3 py-2 text-sm font-medium text-amber-900"></div>
                        <button id="saveOrg" type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 bg-[#1765c4] text-white hover:bg-[#174f9e] w-full justify-center"><i class="ti ti-check"></i> Simpan</button>
                    `;

                    document.getElementById('saveOrg').addEventListener('click', async function () {
                        const button = this;
                        const error = document.getElementById('orgFormError');
                        const form = new FormData();
                        form.append(edit ? 'org_id_edit' : 'org_id', data?.id || '');
                        form.append(edit ? 'org_name_edit' : 'org_name', document.getElementById('orgName').value);
                        form.append(edit ? 'org_institution_edit' : 'org_institution', document.getElementById('orgInstitution').value);
                        form.append(edit ? 'org_address_edit' : 'org_address', document.getElementById('orgAddress').value);
                        form.append(edit ? 'org_contact_edit' : 'org_contact', document.getElementById('orgContact').value);
                        form.append(edit ? 'org_type_edit' : 'org_type', document.getElementById('orgType').value);
                        const logo = document.getElementById('orgLogo').files[0];
                        if (logo) form.append(edit ? 'org_logo_input_edit' : 'org_logo_input', logo);

                        error.classList.add('hidden');
                        button.disabled = true;
                        try {
                            const payload = await request(edit ? '/dashboard/edit-organization' : '/dashboard/add-organization', form);
                            if (payload.success) {
                                close();
                                await load();
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

                const manageOrg = function (id, name) {
                    const version = open('Kelola organisasi', name);
                    drawerBody.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><span class="mx-auto grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-xl text-blue-700"><i class="ti ti-loader-2 animate-spin"></i></span><strong>Memuat anggota...</strong></div>';

                    Promise.all([
                        fetch('/dashboard/get-organization-member?' + new URLSearchParams({ org_id: id }), { headers: { 'Accept': 'application/json' } }).then((r) => r.json()),
                        fetch('/dashboard/get-organization-request?' + new URLSearchParams({ org_id: id }), { headers: { 'Accept': 'application/json' } }).then((r) => r.json()),
                    ]).then(([members, requests]) => {
                        if (!drawer.open || version !== drawerRequest) return;
                        const memberRows = (members.data || []).map((row) => `<div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 py-2.5 text-sm text-slate-700"><span>${esc(row.user?.name || '-')}</span><span class="flex items-center gap-2"><strong>${esc(row.position || '-')}</strong>${row.position !== 'Owner' ? `<button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 remove-member" data-id="${esc(row.id)}">Keluarkan</button>` : ''}</span></div>`).join('') || '<div class="text-sm text-slate-600">Belum ada anggota.</div>';
                        const requestRows = (requests.data || []).map((row) => `<div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 py-2.5 text-sm text-slate-700"><span>${esc(row.user?.name || '-')}</span><button type="button" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 accept-member" data-id="${esc(row.id)}">Terima</button></div>`).join('') || '<div class="text-sm text-slate-600">Tidak ada permintaan bergabung.</div>';
                        drawerBody.innerHTML = `
                            <div class="rounded-xl border border-slate-200 p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold"><h4>Anggota</h4>${memberRows}</div>
                            <div class="rounded-xl border border-slate-200 p-4 [&>h4]:mb-2 [&>h4]:text-sm [&>h4]:font-semibold"><h4>Permintaan bergabung</h4>${requestRows}</div>
                        `;
                        drawerBody.querySelectorAll('.accept-member').forEach((button) => {
                            button.addEventListener('click', async function () {
                                const payload = await request('/dashboard/accept-follow', new URLSearchParams({ org_member_id: button.dataset.id }));
                                if (payload.success) {
                                    if (drawer.open && version === drawerRequest) manageOrg(id, name);
                                } else {
                                    window.alert(payload.error || 'Gagal menerima anggota.');
                                }
                            });
                        });
                        drawerBody.querySelectorAll('.remove-member').forEach((button) => {
                            button.addEventListener('click', async function () {
                                if (!window.confirm('Keluarkan anggota ini?')) return;
                                const payload = await request('/dashboard/remove-member', new URLSearchParams({ org_member_id: button.dataset.id }));
                                if (payload.success) {
                                    if (drawer.open && version === drawerRequest) manageOrg(id, name);
                                } else {
                                    window.alert(payload.error || 'Gagal mengeluarkan anggota.');
                                }
                            });
                        });
                    }).catch(() => {
                        if (!drawer.open || version !== drawerRequest) return;
                        drawerBody.innerHTML = '<div class="space-y-2 px-5 py-10 text-center text-sm text-slate-600 [&>strong]:block [&>strong]:text-slate-950"><strong>Gagal memuat anggota</strong><p>Coba lagi.</p></div>';
                    });
                };

                const bindActions = function () {
                    grid.querySelectorAll('.manage-org').forEach((b) => b.addEventListener('click', () => manageOrg(b.dataset.id, b.dataset.name)));
                    grid.querySelectorAll('.edit-org').forEach((b) => b.addEventListener('click', async () => {
                        const payload = await request('/dashboard/detail-organization', new URLSearchParams({ org_id: b.dataset.id }));
                        if (payload.data) orgForm(true, payload.data);
                    }));
                    grid.querySelectorAll('.delete-org').forEach((b) => b.addEventListener('click', async () => {
                        if (!window.confirm('Hapus organisasi ini?')) return;
                        const payload = await request('/dashboard/delete-organization', new URLSearchParams({ org_id: b.dataset.id }));
                        if (payload.success) { await load(); } else { window.alert(payload.error || 'Gagal menghapus.'); }
                    }));
                    grid.querySelectorAll('.follow-org').forEach((b) => b.addEventListener('click', async () => {
                        const payload = await request('/dashboard/follow-organization', new URLSearchParams({ org_id: b.dataset.id }));
                        if (payload.success) { await load(); } else { window.alert(payload.error || 'Gagal mengikuti.'); }
                    }));
                    grid.querySelectorAll('.unfollow-org').forEach((b) => b.addEventListener('click', async () => {
                        if (!window.confirm('Keluar dari organisasi?')) return;
                        const payload = await request('/dashboard/unfollow-organization', new URLSearchParams({ org_id: b.dataset.id }));
                        if (payload.success) { await load(); } else { window.alert(payload.error || 'Gagal keluar.'); }
                    }));
                };

                const originalRender = render;
                render = function () {
                    originalRender();
                    bindActions();
                };

                document.querySelectorAll('.org-tab').forEach((button) => {
                    button.addEventListener('click', function () {
                        document.querySelectorAll('.org-tab').forEach((tabButton) => tabButton.setAttribute('aria-pressed', String(tabButton === button)));
                        tab = button.dataset.tab;
                        load();
                    });
                });

                document.getElementById('createOrgButton').addEventListener('click', () => orgForm(false, null));
                drawer.addEventListener('click', (event) => {
                    if (event.target !== drawer) return;
                    const bounds = drawer.getBoundingClientRect();
                    if (event.clientX < bounds.left || event.clientX > bounds.right
                        || event.clientY < bounds.top || event.clientY > bounds.bottom) close();
                });
                search.addEventListener('input', render);

                load();
            })();
        </script>
    @endpush
@endsection
