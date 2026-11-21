@if ($canCreateEvent ?? ($hasOrganizerRole ?? false))
    <dialog
        id="createEventModal"
        x-ref="eventDialog"
        data-url-check="{{ url('/url-check') }}"
        data-studio-url="{{ url('/event-studio') }}"
        aria-labelledby="createEventTitle"
        aria-describedby="createEventDescription"
        class="m-auto max-h-[calc(100dvh_-_2rem)] w-[calc(100%_-_2rem)] max-w-lg overflow-y-auto overscroll-contain rounded-3xl border border-slate-200 bg-white p-0 text-slate-950 shadow-[0_24px_80px_-24px_rgba(15,23,42,0.5)] backdrop:bg-slate-950/50 backdrop:backdrop-blur-sm"
        x-data="{
            slug: '',
            slugTouched: false,
            slugStatus: 'idle',
            checkedSlug: '',
            slugCheckTimer: null,
            slugCheckVersion: 0,
            submitting: false,
            error: '',

            get canSubmit() {
                return !this.submitting
                    && this.slugStatus === 'available'
                    && this.checkedSlug === this.slug;
            },

            init() {
                this.$watch('slug', value => this.scheduleSlugCheck(value));

                this.$nextTick(() => {
                    if (new URLSearchParams(window.location.search).get('create') === '1') {
                        this.openDialog();
                    }
                });
            },

            openDialog() {
                const dialog = this.$refs.eventDialog;
                if (dialog.open) return;

                this.error = '';
                dialog.showModal();

                if (this.slug) this.scheduleSlugCheck(this.slug);
            },

            syncSlug(value) {
                if (this.slugTouched) return;

                this.slug = value.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            },

            scheduleSlugCheck(slug) {
                clearTimeout(this.slugCheckTimer);

                const version = ++this.slugCheckVersion;
                this.checkedSlug = '';

                if (!slug) {
                    this.slugStatus = 'idle';
                    return;
                }

                if (!/^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(slug)) {
                    this.slugStatus = 'invalid';
                    return;
                }

                this.slugStatus = 'checking';
                this.slugCheckTimer = setTimeout(() => this.checkSlug(slug, version), 350);
            },

            async checkSlug(slug, version) {
                try {
                    const endpoint = new URL(this.$refs.eventDialog.dataset.urlCheck, window.location.href);
                    endpoint.searchParams.set('url', slug);

                    const response = await fetch(endpoint, {
                        headers: { Accept: 'application/json' },
                        cache: 'no-store',
                    });

                    if (!response.ok) throw new Error('Slug check failed');

                    const { result } = await response.json();

                    if (version !== this.slugCheckVersion || slug !== this.slug) return;

                    if (result === 0 || result === '0') {
                        this.checkedSlug = slug;
                        this.slugStatus = 'available';
                    } else if (result === 1 || result === '1') {
                        this.slugStatus = 'taken';
                    } else {
                        this.slugStatus = 'error';
                    }
                } catch {
                    if (version === this.slugCheckVersion && slug === this.slug) {
                        this.slugStatus = 'error';
                    }
                }
            },

            async createEvent(form) {
                if (!this.canSubmit) return;

                const body = new URLSearchParams(new FormData(form));
                if (body.get('slug') !== this.checkedSlug) return;

                const studioUrl = this.$refs.eventDialog.dataset.studioUrl;
                this.error = '';
                this.submitting = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: { Accept: 'application/json' },
                        body,
                    });

                    const payload = await response.json();

                    if (response.ok && payload.success && payload.event_id) {
                        window.location.assign(studioUrl + '/' + encodeURIComponent(payload.event_id) + '/basic');
                        return;
                    }

                    this.error = Object.values(payload.errors || {}).flat()[0]
                        || payload.message
                        || 'Gagal membuat event.';

                    this.scheduleSlugCheck(this.slug);
                } catch {
                    this.error = 'Gagal membuat event. Coba lagi.';
                }

                this.submitting = false;
            },
        }"
        x-on:click.document="if ($event.target instanceof Element && $event.target.closest('[data-create-event]')) openDialog()"
        x-on:click.self="if (!submitting) $refs.eventDialog.close()"
        x-on:cancel="if (submitting) $event.preventDefault()"
    >
        <form id="closeCreateEventForm" method="dialog"
              x-on:submit="if (submitting) $event.preventDefault()"></form>

        <header class="relative isolate overflow-hidden border-b border-blue-100 bg-gradient-to-br from-white via-blue-50 to-[#e4efff] px-5 py-5 sm:px-6">
            <div aria-hidden="true"
                 class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-2/3 bg-[repeating-linear-gradient(135deg,transparent_0_15px,rgba(34,130,255,0.15)_15px_16px)] [mask-image:linear-gradient(to_left,black,transparent)]"></div>

            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <span aria-hidden="true"
                          class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-[#1765c4] text-xl text-white shadow-sm">
                        <i class="ti ti-ticket"></i>
                    </span>

                    <h2 id="createEventTitle" class="font-['Sora','Inter',sans-serif] text-xl font-semibold tracking-tight">
                        Buat event baru
                    </h2>
                    <p id="createEventDescription" class="mt-1 max-w-sm text-sm leading-6 text-slate-600">
                        Event disimpan sebagai draf, lalu dibuka di Event Studio.
                    </p>
                </div>

                <button type="submit" form="closeCreateEventForm"
                        aria-label="Tutup modal" x-bind:disabled="submitting"
                        class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-blue-100 bg-white text-lg text-slate-700 transition-colors hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-50">
                    <i class="ti ti-x" aria-hidden="true"></i>
                </button>
            </div>
        </header>

        <form action="{{ url('/event-studio/store') }}" method="POST"
              x-on:submit.prevent="createEvent($event.currentTarget)"
              x-bind:aria-busy="submitting.toString()">
            @csrf

            <fieldset x-bind:disabled="submitting" class="min-w-0 space-y-4 px-5 py-5 sm:px-6">
                <div>
                    <label for="createEventName" class="mb-1.5 block text-sm font-semibold">
                        Nama event
                    </label>
                    <input id="createEventName" name="name" type="text" required autofocus
                           placeholder="Contoh: Creative Talk 2026"
                           x-on:input="syncSlug($event.target.value)"
                           class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm placeholder:text-slate-500 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div>
                    <label for="createEventSlug" class="mb-1.5 block text-sm font-semibold">
                        URL halaman event
                    </label>

                    <div class="flex items-center rounded-xl border border-slate-200 bg-slate-50 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100">
                        <span aria-hidden="true"
                              class="grid h-11 w-10 shrink-0 place-items-center border-r border-slate-200 text-slate-500">
                            <i class="ti ti-link"></i>
                        </span>

                        <input id="createEventSlug" name="slug" type="text" required
                               x-model="slug" x-on:input="slugTouched = true"
                               pattern="[a-z0-9]+(?:-[a-z0-9]+)*"
                               autocapitalize="none" spellcheck="false"
                               aria-describedby="createEventSlugHint createEventSlugStatus"
                               placeholder="creative-talk-2026"
                               class="min-h-11 min-w-0 flex-1 rounded-r-xl bg-transparent px-3 text-sm outline-none placeholder:text-slate-500">
                    </div>

                    <p id="createEventSlugHint" class="mt-1.5 text-xs leading-5 text-slate-600">
                        Diisi otomatis dari nama event dan bisa diedit.
                    </p>

                    <div class="mt-2 rounded-xl border border-blue-100 bg-blue-50 px-3 py-2.5 text-xs leading-5">
                        <p class="font-medium text-slate-600">Pratinjau URL publik</p>
                        <p class="break-all font-mono text-blue-900">
                            <span>{{ parse_url(url('/'), PHP_URL_HOST) }}/</span><span x-text="slug || 'nama-event'">nama-event</span>
                        </p>
                    </div>

                    <p id="createEventSlugStatus" role="status"
                       class="mt-2 text-xs font-medium leading-5"
                       x-bind:class="{
                           'text-slate-600': slugStatus === 'checking',
                           'text-emerald-700': slugStatus === 'available',
                           'text-amber-800': ['taken', 'invalid', 'error'].includes(slugStatus),
                       }"
                       x-text="({
                           idle: '',
                           checking: 'Mengecek ketersediaan URL…',
                           available: 'URL tersedia.',
                           taken: 'URL sudah dipakai. Coba URL lain.',
                           invalid: 'Gunakan huruf kecil, angka, dan tanda hubung sebagai pemisah.',
                           error: 'Ketersediaan URL belum bisa diperiksa.',
                       })[slugStatus]"></p>

                    <button type="button" x-show="slugStatus === 'error'"
                            x-on:click="scheduleSlugCheck(slug)"
                            class="mt-1 text-xs font-semibold text-blue-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                        Cek ulang
                    </button>
                </div>

                <div>
                    <label for="createEventCategory" class="mb-1.5 block text-sm font-semibold">
                        Kategori
                    </label>
                    <select id="createEventCategory" name="category_id" required
                            class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">Pilih kategori</option>
                        @foreach ($eventCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <p role="alert" x-text="error" x-bind:class="{ hidden: !error }"
                   class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2.5 text-sm text-rose-900"></p>
            </fieldset>

            <footer class="flex flex-wrap justify-end gap-2 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:px-6">
                <button type="submit" form="closeCreateEventForm" x-bind:disabled="submitting"
                        class="min-h-11 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 disabled:opacity-50">
                    Batal
                </button>

                <button type="submit" disabled x-bind:disabled="!canSubmit"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#1765c4] px-4 text-sm font-semibold text-white transition-colors hover:bg-[#174f9e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-60">
                    <span x-text="submitting ? 'Membuat event…' : 'Buat & buka studio'">Buat &amp; buka studio</span>
                    <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </button>
            </footer>
        </form>
    </dialog>
@endif