@php
    $isAdminPage = $isAdminPage ?? false;
    $articleData = $articles->getCollection()->map(fn ($article) => [
        'id' => $article->id,
        'title' => $article->title,
        'slug' => $article->slug,
        'category_id' => $article->category_id,
        'article_code' => $article->article_code,
        'tag' => $article->tag,
        'body' => $article->body,
        'image' => $article->input_image ? asset('storage/blog-images/' . $article->input_image) : null,
    ])->values();
@endphp

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
@endpush

<div class="dash-page-head">
    <div class="dash-page-head-copy">
        <div class="dash-eyebrow">Content</div>
        <h1 class="dash-title">Articles</h1>
        <p class="dash-subtitle">{{ $isAdminPage ? 'Kelola seluruh artikel platform.' : 'Kelola artikel yang kamu tulis.' }}</p>
    </div>
    <div class="dash-head-actions">
        <button type="button" class="dash-btn dash-btn-primary" data-create-article>
            <i class="ti ti-plus"></i>
            Tulis artikel
        </button>
    </div>
</div>

<div class="dash-card mb-3">
    <div class="dash-card-body">
        <form method="GET" action="" class="flex flex-wrap items-center gap-2">
            <div class="dash-search min-w-[220px] flex-1">
                <i class="ti ti-search"></i>
                <input type="search" name="key" value="{{ request('key') }}" class="dash-input" placeholder="Cari artikel...">
            </div>
            <button type="submit" class="dash-btn">Cari</button>
            @if (request('key'))
                <a href="{{ $isAdminPage ? '/administrator/article' : '/dashboard/article' }}" class="dash-btn">Reset</a>
            @endif
            <span class="ml-auto text-[10px] text-ink-400">{{ number_format($articles->total(), 0, ',', '.') }} artikel</span>
        </form>
    </div>
</div>

<div class="dash-card">
    <div class="dash-card-head">
        <div>
            <h3 class="dash-card-title">Daftar artikel</h3>
            <p class="dash-card-sub">Judul, kategori, jenis, dan status publikasi.</p>
        </div>
    </div>

    @if ($articles->isEmpty())
        <div class="dash-empty">
            <span class="dash-empty-icon"><i class="ti ti-news-off"></i></span>
            <strong>Belum ada artikel</strong>
            <p>Artikel yang kamu tulis akan muncul di sini.</p>
        </div>
    @else
        <div class="dash-table-wrap px-3 pb-3 pt-1">
            <table class="dash-table" style="min-width: 760px">
                <thead>
                    <tr>
                        <th>Artikel</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        @if ($isAdminPage)
                            <th>Penulis</th>
                        @endif
                        <th>Tanggal</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        @php
                            $imageExists = $article->input_image && file_exists(public_path('storage/blog-images/' . $article->input_image));
                        @endphp
                        <tr>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <span class="inline-flex h-9 w-11 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-ink-100 text-ink-400">
                                        @if ($imageExists)
                                            <img src="{{ asset('storage/blog-images/' . $article->input_image) }}" alt="" class="h-full w-full object-cover" onerror="this.style.display='none'">
                                        @else
                                            <i class="ti ti-photo"></i>
                                        @endif
                                    </span>
                                    <div class="min-w-0">
                                        <div class="is-strong max-w-[330px] truncate">{{ $article->title }}</div>
                                        <div class="text-[9px] text-ink-400">/{{ $article->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-[10px] text-ink-600">{{ $article->category?->category ?? '—' }}</td>
                            <td class="text-[10px] text-ink-600">{{ $article->type?->type_name ?? '—' }}</td>
                            @if ($isAdminPage)
                                <td class="text-[10px] text-ink-600">{{ $article->user?->name ?? '—' }}</td>
                            @endif
                            <td class="whitespace-nowrap text-[9.5px] text-ink-500">{{ $article->created_at?->format('d M Y') ?? '—' }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-1">
                                    <button type="button" class="dash-btn px-2 py-1.5 text-[10px] js-edit-article" data-article-id="{{ $article->id }}">
                                        <i class="ti ti-pencil"></i> Edit
                                    </button>
                                    <button type="button" class="dash-btn px-2 py-1.5 text-[10px] text-red-700 js-delete-article" data-article-id="{{ $article->id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('dashboard.components.pagination', ['paginator' => $articles])
    @endif
</div>

<script>
    window.articleRows = @json($articleData);
</script>

<div id="articleEditorModal" class="dash-modal" aria-hidden="true">
    <div id="articleEditorOverlay" class="dash-modal-overlay"></div>
    <div class="dash-modal-panel" style="max-width: 760px">
        <div class="dash-card-head">
            <div>
                <h3 class="dash-card-title" id="articleEditorTitle">Tulis artikel</h3>
                <p class="dash-card-sub">Lengkapi data artikel. Body mendukung format Trix.</p>
            </div>
            <button type="button" class="dash-drawer-close" id="closeArticleEditor" aria-label="Tutup"><i class="ti ti-x"></i></button>
        </div>

        <form id="articleEditorForm">
            @csrf
            <input type="hidden" id="articleId">
            <div id="articleEditorError" class="dash-alert is-error mx-4 mt-4 hidden"></div>

            <div class="grid grid-cols-1 gap-3 p-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="articleTitle" class="mb-1 block text-[10px] font-bold text-ink-600">Judul</label>
                    <input id="articleTitle" class="dash-input" required>
                </div>
                <div>
                    <label for="articleSlug" class="mb-1 block text-[10px] font-bold text-ink-600">Slug</label>
                    <input id="articleSlug" class="dash-input" required>
                </div>
                <div>
                    <label for="articleCategory" class="mb-1 block text-[10px] font-bold text-ink-600">Kategori</label>
                    <select id="articleCategory" class="dash-input" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($isAdminPage)
                    <div>
                        <label for="articleType" class="mb-1 block text-[10px] font-bold text-ink-600">Jenis artikel</label>
                        <select id="articleType" class="dash-input">
                            <option value="">Pilih jenis</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" id="articleType" value="3">
                @endif
                <div>
                    <label for="articleTag" class="mb-1 block text-[10px] font-bold text-ink-600">Tag</label>
                    <input id="articleTag" class="dash-input" placeholder="#tag">
                </div>
                <div class="sm:col-span-2">
                    <label for="articleImage" class="mb-1 block text-[10px] font-bold text-ink-600">Gambar</label>
                    <input id="articleImage" type="file" accept="image/*" class="dash-input">
                    <div id="articleImagePreview" class="mt-2 hidden">
                        <img id="articleImagePreviewImg" alt="" class="h-24 w-auto rounded-lg border border-line object-cover">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-[10px] font-bold text-ink-600">Body</label>
                    <input id="articleBody" type="hidden">
                    <trix-editor input="articleBody" class="rounded-xl border border-line bg-white"></trix-editor>
                </div>
            </div>

            <div class="dash-card-head justify-end border-t border-line" style="border-bottom: 0">
                <button type="button" id="cancelArticleEditor" class="dash-btn">Batal</button>
                <button type="submit" id="saveArticleEditor" class="dash-btn dash-btn-primary">
                    <i class="ti ti-device-floppy"></i>
                    Simpan artikel
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script>
        (function () {
            const rows = window.articleRows || [];
            const isAdmin = @json($isAdminPage);
            const modal = document.getElementById('articleEditorModal');
            const form = document.getElementById('articleEditorForm');
            const errorBox = document.getElementById('articleEditorError');
            const bodyInput = document.getElementById('articleBody');
            const editor = document.querySelector('trix-editor');
            const imageInput = document.getElementById('articleImage');
            const preview = document.getElementById('articleImagePreview');
            const previewImg = document.getElementById('articleImagePreviewImg');
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            let editing = null;

            const slugify = (value) => value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');

            const close = function () {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            };

            const open = function (article) {
                editing = article || null;
                document.getElementById('articleEditorTitle').textContent = editing ? 'Edit artikel' : 'Tulis artikel';
                document.getElementById('articleId').value = editing?.id || '';
                document.getElementById('articleTitle').value = editing?.title || '';
                document.getElementById('articleSlug').value = editing?.slug || '';
                document.getElementById('articleCategory').value = editing?.category_id || '';
                document.getElementById('articleType').value = editing?.article_code || (isAdmin ? '' : '3');
                document.getElementById('articleTag').value = editing?.tag || '';
                imageInput.value = '';
                errorBox.classList.add('hidden');
                errorBox.textContent = '';

                if (editing?.image) {
                    previewImg.src = editing.image;
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }

                if (editor?.editor) {
                    editor.editor.loadHTML(editing?.body || '');
                } else {
                    bodyInput.value = editing?.body || '';
                }

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                setTimeout(() => document.getElementById('articleTitle').focus(), 60);
            };

            document.querySelectorAll('[data-create-article]').forEach((button) => button.addEventListener('click', () => open(null)));
            document.querySelectorAll('.js-edit-article').forEach((button) => {
                button.addEventListener('click', () => {
                    const article = rows.find((item) => String(item.id) === String(button.dataset.articleId));
                    if (article) open(article);
                });
            });

            document.querySelectorAll('.js-delete-article').forEach((button) => {
                button.addEventListener('click', async function () {
                    if (!window.confirm('Hapus artikel ini?')) return;
                    button.disabled = true;
                    try {
                        const response = await fetch('/administrator/article/delete', {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                            body: new URLSearchParams({ id: button.dataset.articleId }),
                        });
                        const payload = await response.json();
                        if (payload.success) {
                            window.location.reload();
                            return;
                        }
                        window.alert(payload.error || 'Gagal menghapus artikel.');
                    } catch (e) {
                        window.alert('Gagal menghapus artikel.');
                    }
                    button.disabled = false;
                });
            });

            document.getElementById('articleTitle').addEventListener('input', function () {
                if (!editing) document.getElementById('articleSlug').value = slugify(this.value);
            });

            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) { preview.classList.add('hidden'); return; }
                previewImg.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            });

            document.getElementById('closeArticleEditor').addEventListener('click', close);
            document.getElementById('cancelArticleEditor').addEventListener('click', close);
            document.getElementById('articleEditorOverlay').addEventListener('click', close);
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape') close(); });

            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                const save = document.getElementById('saveArticleEditor');
                save.disabled = true;
                errorBox.classList.add('hidden');

                const fd = new FormData();
                const id = document.getElementById('articleId').value;
                const body = bodyInput.value;
                const image = imageInput.files[0];

                if (id) {
                    fd.append('blog_id_edit', id);
                    fd.append('blog_title_edit', document.getElementById('articleTitle').value);
                    fd.append('slug_edit', document.getElementById('articleSlug').value);
                    fd.append('blog_category_edit', document.getElementById('articleCategory').value);
                    fd.append('blog_article_id_edit', document.getElementById('articleType').value);
                    fd.append('blog_tag_edit', document.getElementById('articleTag').value);
                    fd.append('blog_body_edit', body);
                    if (image) fd.append('blog_image_edit', image);
                } else {
                    fd.append('blog_title', document.getElementById('articleTitle').value);
                    fd.append('slug', document.getElementById('articleSlug').value);
                    fd.append('blog_category', document.getElementById('articleCategory').value);
                    fd.append('blog_article_id', document.getElementById('articleType').value || '3');
                    fd.append('blog_tag', document.getElementById('articleTag').value);
                    fd.append('blog_body', body);
                    if (image) fd.append('blog_image', image);
                }

                try {
                    const response = await fetch(id ? '/administrator/article/edit' : '/administrator/article/post', {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                        body: fd,
                    });
                    const payload = await response.json();
                    if (payload.success) {
                        window.location.reload();
                        return;
                    }
                    errorBox.textContent = payload.error || 'Gagal menyimpan artikel.';
                    errorBox.classList.remove('hidden');
                } catch (e) {
                    errorBox.textContent = 'Gagal menyimpan artikel. Coba lagi.';
                    errorBox.classList.remove('hidden');
                }

                save.disabled = false;
            });
        })();
    </script>
@endpush
