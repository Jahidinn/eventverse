@extends('dashboard.layouts.modern')

@section('title', 'Blog categories')

@section('content')
    <script>
        window.articleCategories = @json($categories);
        window.articleTypes = @json($types);
    </script>

    <div class="dash-page-head">
        <div class="dash-page-head-copy">
            <div class="dash-eyebrow">Content</div>
            <h1 class="dash-title">Blog categories</h1>
            <p class="dash-subtitle">Kelola kategori dan jenis artikel.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h3 class="dash-card-title">Kategori artikel</h3>
                    <p class="dash-card-sub">Kategori untuk pengelompokan artikel.</p>
                </div>
                <button type="button" class="dash-btn dash-btn-primary px-2.5 py-1.5 text-[10px]" data-add-category>
                    <i class="ti ti-plus"></i> Tambah
                </button>
            </div>
            <div class="dash-table-wrap px-3 pb-3 pt-1">
                <table class="dash-table" style="min-width: 360px">
                    <thead><tr><th>Kategori</th><th>Slug</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="is-strong">{{ $category->category }}</td>
                                <td class="text-[10px] text-ink-400">{{ $category->category_id }}</td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-1">
                                        <button type="button" class="dash-btn px-2 py-1.5 text-[10px] js-edit-category" data-id="{{ $category->id }}"><i class="ti ti-pencil"></i></button>
                                        <button type="button" class="dash-btn px-2 py-1.5 text-[10px] text-red-700 js-delete-category" data-id="{{ $category->id }}"><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-5 text-center text-[10px] text-ink-400">Belum ada kategori.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h3 class="dash-card-title">Jenis artikel</h3>
                    <p class="dash-card-sub">Tipe konten yang tersedia.</p>
                </div>
                <button type="button" class="dash-btn dash-btn-primary px-2.5 py-1.5 text-[10px]" data-add-type>
                    <i class="ti ti-plus"></i> Tambah
                </button>
            </div>
            <div class="dash-table-wrap px-3 pb-3 pt-1">
                <table class="dash-table" style="min-width: 360px">
                    <thead><tr><th>Jenis</th><th>Slug</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($types as $type)
                            <tr>
                                <td class="is-strong">{{ $type->type_name }}</td>
                                <td class="text-[10px] text-ink-400">{{ $type->type_slug }}</td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-1">
                                        <button type="button" class="dash-btn px-2 py-1.5 text-[10px] js-edit-type" data-id="{{ $type->id }}"><i class="ti ti-pencil"></i></button>
                                        <button type="button" class="dash-btn px-2 py-1.5 text-[10px] text-red-700 js-delete-type" data-id="{{ $type->id }}"><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-5 text-center text-[10px] text-ink-400">Belum ada jenis artikel.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="taxonomyModal" class="dash-modal" aria-hidden="true">
        <div id="taxonomyOverlay" class="dash-modal-overlay"></div>
        <div class="dash-modal-panel" style="max-width: 440px">
            <div class="dash-card-head">
                <div>
                    <h3 class="dash-card-title" id="taxonomyTitle">Tambah kategori</h3>
                    <p class="dash-card-sub" id="taxonomySub">Lengkapi data.</p>
                </div>
                <button type="button" class="dash-drawer-close" id="closeTaxonomy"><i class="ti ti-x"></i></button>
            </div>
            <form id="taxonomyForm">
                @csrf
                <input type="hidden" id="taxonomyMode">
                <input type="hidden" id="taxonomyId">
                <div class="p-4">
                    <div id="taxonomyError" class="dash-alert is-error mb-3 hidden"></div>
                    <label for="taxonomyName" class="mb-1 block text-[10px] font-bold text-ink-600">Nama</label>
                    <input id="taxonomyName" class="dash-input" required>
                    <label for="taxonomySlug" class="mb-1 mt-3 block text-[10px] font-bold text-ink-600">Slug</label>
                    <input id="taxonomySlug" class="dash-input" required>
                </div>
                <div class="dash-card-head justify-end border-t border-line" style="border-bottom: 0">
                    <button type="button" id="cancelTaxonomy" class="dash-btn">Batal</button>
                    <button type="submit" id="saveTaxonomy" class="dash-btn dash-btn-primary"><i class="ti ti-device-floppy"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            (function () {
                const categories = window.articleCategories || [];
                const types = window.articleTypes || [];
                const modal = document.getElementById('taxonomyModal');
                const form = document.getElementById('taxonomyForm');
                const errorBox = document.getElementById('taxonomyError');
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                let mode = 'category';
                let editingId = null;

                const slugify = (value) => value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                const close = () => {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                };
                const open = function (nextMode, item) {
                    mode = nextMode;
                    editingId = item?.id || null;
                    document.getElementById('taxonomyMode').value = mode;
                    document.getElementById('taxonomyId').value = editingId || '';
                    document.getElementById('taxonomyTitle').textContent = (editingId ? 'Edit ' : 'Tambah ') + (mode === 'category' ? 'kategori' : 'jenis artikel');
                    document.getElementById('taxonomySub').textContent = mode === 'category' ? 'Kategori pengelompokan artikel.' : 'Tipe konten artikel.';
                    document.getElementById('taxonomyName').value = item?.category || item?.type_name || '';
                    document.getElementById('taxonomySlug').value = item?.category_id || item?.type_slug || '';
                    errorBox.classList.add('hidden');
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                };

                document.querySelectorAll('[data-add-category]').forEach((button) => button.addEventListener('click', () => open('category', null)));
                document.querySelectorAll('[data-add-type]').forEach((button) => button.addEventListener('click', () => open('type', null)));
                document.querySelectorAll('.js-edit-category').forEach((button) => button.addEventListener('click', () => {
                    open('category', categories.find((item) => String(item.id) === String(button.dataset.id)));
                }));
                document.querySelectorAll('.js-edit-type').forEach((button) => button.addEventListener('click', () => {
                    open('type', types.find((item) => String(item.id) === String(button.dataset.id)));
                }));
                document.querySelectorAll('.js-delete-category').forEach((button) => button.addEventListener('click', () => remove('category', button.dataset.id, button)));
                document.querySelectorAll('.js-delete-type').forEach((button) => button.addEventListener('click', () => remove('type', button.dataset.id, button)));

                const remove = async function (kind, id, button) {
                    if (!window.confirm('Hapus data ini?')) return;
                    button.disabled = true;
                    try {
                        const response = await fetch(kind === 'category' ? '/administrator/blog-category/delete' : '/administrator/blog-type/delete', {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                            body: new URLSearchParams({ id: id }),
                        });
                        const payload = await response.json();
                        if (payload.success) { window.location.reload(); return; }
                        window.alert(payload.error || 'Gagal menghapus.');
                    } catch (e) { window.alert('Gagal menghapus.'); }
                    button.disabled = false;
                };

                document.getElementById('taxonomyName').addEventListener('input', function () {
                    if (!editingId) document.getElementById('taxonomySlug').value = slugify(this.value);
                });
                document.getElementById('closeTaxonomy').addEventListener('click', close);
                document.getElementById('cancelTaxonomy').addEventListener('click', close);
                document.getElementById('taxonomyOverlay').addEventListener('click', close);
                document.addEventListener('keydown', (event) => { if (event.key === 'Escape') close(); });

                form.addEventListener('submit', async function (event) {
                    event.preventDefault();
                    const save = document.getElementById('saveTaxonomy');
                    save.disabled = true;
                    errorBox.classList.add('hidden');
                    const name = document.getElementById('taxonomyName').value;
                    const slug = document.getElementById('taxonomySlug').value;
                    const body = mode === 'category'
                        ? new URLSearchParams({ category_name: name, category_id: slug, category_key: editingId || '' })
                        : new URLSearchParams({ article_type: name, type_slug: slug, type_id: editingId || '' });
                    const endpoint = mode === 'category'
                        ? (editingId ? '/administrator/blog-category/edit' : '/administrator/blog-category/submit')
                        : (editingId ? '/administrator/blog-type/edit' : '/administrator/blog-type/submit');

                    try {
                        const response = await fetch(endpoint, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                            body: body,
                        });
                        const payload = await response.json();
                        if (payload.success) { window.location.reload(); return; }
                        errorBox.textContent = payload.error || 'Gagal menyimpan.';
                        errorBox.classList.remove('hidden');
                    } catch (e) {
                        errorBox.textContent = 'Gagal menyimpan. Coba lagi.';
                        errorBox.classList.remove('hidden');
                    }
                    save.disabled = false;
                });
            })();
        </script>
    @endpush
@endsection
