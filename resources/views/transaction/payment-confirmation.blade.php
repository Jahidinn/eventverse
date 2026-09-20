{{-- ============================================================ --}}
{{-- MODAL KONFIRMASI & PEMBAYARAN (Alpine)                      --}}
{{-- ============================================================ --}}
<div id="checkoutConfirmModal"
     x-data="checkoutModal()"
     @open-checkout-modal.window="handleOpen($event.detail)"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[100]">

    {{-- BACKDROP --}}
    <div class="absolute inset-0 bg-black/55 backdrop-blur-sm"
         @click="closeModal()"
         x-transition.opacity></div>

    {{-- PANEL --}}
    <div class="relative flex items-center justify-center min-h-screen p-3 sm:p-4 pointer-events-none">
        <div class="pointer-events-auto bg-[#f8fafc] rounded-2xl shadow-[0_25px_50px_-12px_rgba(15,23,42,0.22)] w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden"
             @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-5 sm:px-7 py-4 bg-white border-b border-[#e2e8f0] shrink-0">
                <div>
                    <div class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 uppercase tracking-wide">
                        <i class="ti ti-shield-check"></i> Checkout Safe & Secure
                    </div>
                    <h4 class="text-lg sm:text-xl font-extrabold text-[#0f172a] m-0 mt-0.5">
                        Konfirmasi & Pembayaran
                    </h4>
                </div>
                <button type="button"
                        class="w-9 h-9 rounded-full bg-[#f1f5f9] text-[#64748b] hover:bg-[#e2e8f0] hover:text-[#0f172a] flex items-center justify-center transition-colors"
                        @click="closeModal()"
                        :disabled="isLoading" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            {{-- BODY SCROLL --}}
            <div class="flex-1 overflow-y-auto p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-[1fr_340px] gap-5 items-start">

                    {{-- ============ LEFT COLUMN ============ --}}
                    <div class="space-y-4">

                        {{-- EVENT BANNER --}}
                        <div class="bg-white border border-[#e2e8f0] rounded-2xl overflow-hidden">
                            <div class="relative h-32 w-full bg-[#e2e8f0]">
                                <img :src="eventBannerSrc" alt="Event Banner" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-black/55"></div>
                                <span class="absolute top-3 right-3 bg-[#0f172a]/75 backdrop-blur text-white text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                    <i class="ti ti-ticket"></i> ID: #<span x-text="summary.event?.id || '-'"></span>
                                </span>
                            </div>
                            <div class="p-4 sm:p-5">
                                <h5 class="text-base font-bold text-[#0f172a] m-0 mb-1.5" x-text="summary.event?.title || '-'"></h5>
                                <div class="flex items-center gap-2 text-xs text-[#64748b]">
                                    <i class="ti ti-map-pin"></i>
                                    <span>Lokasi: <strong class="text-[#0f172a] capitalize" x-text="summary.event?.location || '-'"></strong></span>
                                </div>
                            </div>
                        </div>

                        {{-- BUYER --}}
                        <div class="bg-white border border-[#e2e8f0] rounded-2xl p-4 sm:p-5">
                            <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-[#2282ff] mb-3">
                                <i class="ti ti-user-check"></i> Data Pemesan
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] text-[#64748b] mb-0.5">Nama Lengkap</label>
                                    <span class="block text-[13px] font-semibold text-[#0f172a]" x-text="summary.buyer?.name || '-'"></span>
                                </div>
                                <div>
                                    <label class="block text-[11px] text-[#64748b] mb-0.5">Email</label>
                                    <span class="block text-[13px] font-semibold text-[#0f172a] break-all" x-text="summary.buyer?.email || '-'"></span>
                                </div>
                                <div>
                                    <label class="block text-[11px] text-[#64748b] mb-0.5">Nomor HP</label>
                                    <span class="block text-[13px] font-semibold text-[#0f172a]" x-text="summary.buyer?.phone || '-'"></span>
                                </div>
                            </div>
                        </div>

                        {{-- PARTICIPANTS --}}
                        <div class="bg-white border border-[#e2e8f0] rounded-2xl p-4 sm:p-5">
                            <div class="flex justify-between items-center mb-3">
                                <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-[#2282ff]">
                                    <i class="ti ti-users"></i> Daftar Peserta
                                </div>
                                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-[#ebf3ff] text-[#2282ff]"
                                      x-text="`${summary.participants?.length || 0} Peserta`"></span>
                            </div>
                            <div class="flex flex-col gap-2">
                                <template x-for="(p, idx) in (summary.participants || [])" :key="idx">
                                    <div class="bg-[#f8fafc] border border-[#e2e8f0] p-2.5 sm:p-3.5 rounded-lg flex justify-between items-center gap-2.5">
                                        <div class="min-w-0">
                                            <div class="text-[13px] font-semibold text-[#0f172a] truncate">
                                                Peserta <span x-text="p.number || (idx + 1)"></span>:
                                                <span x-text="p.name"></span>
                                            </div>
                                            <div class="text-[11px] text-[#64748b] truncate">
                                                <span x-text="p.email"></span> • <span x-text="p.phone"></span>
                                            </div>
                                        </div>
                                        <span x-show="p.same_as_buyer"
                                              class="text-[10px] bg-[#dcfce7] text-[#15803d] px-1.5 py-0.5 rounded font-semibold whitespace-nowrap">
                                            Sama dgn Pemesan
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- PAYMENT CATEGORIES --}}
                        <div class="bg-white border border-[#e2e8f0] rounded-2xl p-4 sm:p-5">
                            <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-[#2282ff] mb-3">
                                <i class="ti ti-wallet"></i> Pilih Metode Pembayaran
                            </div>

                            <div class="flex flex-col gap-2.5">
                                <template x-for="(cat, cIdx) in categories" :key="cIdx">
                                    <div class="border rounded-xl overflow-hidden bg-white transition-all"
                                         :class="cat.expanded ? 'border-[#93c5fd]' : 'border-[#e2e8f0]'">
                                        <div class="px-3.5 py-3.5 flex justify-between items-center cursor-pointer hover:bg-[#f8fafc] select-none"
                                             @click="toggleCategory(cIdx)">
                                            <div class="text-[13px] font-bold text-[#0f172a]" x-text="cat.name"></div>
                                            <i class="ti ti-chevron-down text-sm text-[#64748b] transition-transform"
                                               :class="cat.expanded && 'rotate-180 text-[#2282ff]'"></i>
                                        </div>

                                        <div x-show="cat.expanded" x-cloak
                                             class="px-4 pt-3 pb-4 border-t border-[#f1f5f9] bg-[#f8fafc]">
                                            <div class="flex flex-col gap-2">
                                                <template x-for="(method, mIdx) in cat.methods" :key="method.id">
                                                    <div class="flex items-center justify-between px-3.5 py-2.5 rounded-lg border-[1.5px] bg-white cursor-pointer transition-all"
                                                         :class="selectedMethodId === method.id
                                                             ? 'border-[#2282ff] bg-[#ebf3ff] shadow-[0_0_0_1px_#2282ff]'
                                                             : 'border-[#e2e8f0] hover:border-[#93c5fd]'"
                                                         @click.stop="selectMethod(cIdx, method)">
                                                        <div class="flex items-center gap-3">
                                                            <img x-show="method.icon" :src="method.icon" class="w-[45px] h-6 object-contain" :alt="method.name">
                                                            <span class="text-[13px] font-semibold text-[#0f172a]" x-text="method.name"></span>
                                                        </div>
                                                        <span class="text-xs font-semibold text-[#2282ff]" x-text="method.feeDisplay"></span>
                                                    </div>
                                                </template>
                                                <template x-if="!cat.methods || cat.methods.length === 0">
                                                    <div class="text-center text-[11px] text-[#64748b] py-2">Tidak ada metode aktif.</div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    {{-- ============ RIGHT SIDEBAR ============ --}}
                    <div class="flex flex-col gap-3.5">

                        {{-- BREAKDOWN --}}
                        <div class="bg-white border border-[#e2e8f0] rounded-2xl p-4 sm:p-5">
                            <h5 class="text-sm font-bold text-[#0f172a] m-0 mb-3 flex items-center gap-1.5">
                                <i class="ti ti-receipt"></i> Rincian Biaya
                            </h5>

                            <div class="p-2.5 rounded-lg bg-[#f8fafc] border border-dashed border-[#e2e8f0] mb-3">
                                <div class="text-xs font-bold text-[#0f172a]" x-text="summary.ticket?.name || '-'"></div>
                                <div class="text-[11px] text-[#64748b] mt-0.5">
                                    <span x-text="formatRupiah(summary.ticket?.price || 0)"></span> × <span x-text="quantity"></span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between text-xs text-[#64748b]">
                                    <span>Subtotal Tiket</span>
                                    <strong class="text-[#0f172a]" x-text="formatRupiah(subtotal)"></strong>
                                </div>
                                <div class="flex justify-between text-xs text-[#64748b]">
                                    <span>Biaya Layanan</span>
                                    <span class="text-emerald-600 font-semibold" x-text="platformFee > 0 ? formatRupiah(platformFee) : 'Gratis'"></span>
                                </div>
                                <div class="flex justify-between text-xs text-[#64748b]">
                                    <span>Biaya Penanganan</span>
                                    <span class="text-emerald-600 font-semibold" x-text="selectedFee > 0 ? formatRupiah(selectedFee) : 'Gratis'"></span>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="action-pay-card bg-white border border-[#cbd5e1] rounded-2xl p-4 sm:p-5 shadow-[0_10px_15px_-3px_rgba(0,0,0,0.05)]">
                            <div class="pay-total-wrapper mb-3">
                                <span class="pay-total-label block text-[11px] font-semibold text-[#64748b] uppercase">
                                    Total Pembayaran
                                </span>
                                <div class="grand-total-price text-xl sm:text-2xl font-extrabold text-[#2282ff] tracking-tight"
                                     x-text="formatRupiah(grandTotal)"></div>
                            </div>

                            <div class="terms-disclaimer flex items-center gap-1 text-[11px] text-[#64748b] mb-3.5">
                                <i class="ti ti-lock-check"></i> Transaksi dienkripsi secara aman.
                            </div>

                            <button type="button" id="btnSubmitCheckout"
                                    @click="submit()"
                                    :disabled="isLoading"
                                    class="w-full h-12 flex items-center justify-center gap-2 rounded-lg bg-[#2282ff] text-white font-bold text-sm hover:bg-[#1b6cd6] hover:shadow-[0_4px_14px_rgba(34,130,255,0.3)] transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                                <template x-if="!isLoading">
                                    <span class="inline-flex items-center gap-2">
                                        <span>Bayar Sekarang</span>
                                        <i class="ti ti-arrow-right"></i>
                                    </span>
                                </template>
                                <template x-if="isLoading">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="ti ti-loader-2 animate-spin"></i>
                                        <span>Membuat Transaksi...</span>
                                    </span>
                                </template>
                            </button>

                            <button type="button"
                                    class="w-full bg-transparent border-0 text-[#64748b] text-xs cursor-pointer pt-2 pb-0"
                                    @click="closeModal()"
                                    :disabled="isLoading">
                                Batal
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<style>
[x-cloak] { display: none !important; }
body.modal-open { overflow: hidden; }

@media (max-width: 767.98px) {
    #checkoutConfirmModal .flex-1.overflow-y-auto { padding-bottom: 120px; }

    .action-pay-card {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        z-index: 1060;
        margin: 0;
        border-radius: 18px 18px 0 0;
        box-shadow: 0 -8px 25px rgba(0,0,0,0.12);
        padding: 12px 18px 16px;
        border: 1px solid #e2e8f0;
        border-bottom: none;
    }
    .action-pay-card .pay-total-wrapper {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;
    }
    .action-pay-card .pay-total-label { font-size: 11px; }
    .action-pay-card .grand-total-price { font-size: 18px; }
    .action-pay-card .terms-disclaimer,
    .action-pay-card .btn-checkout-cancel,
    .action-pay-card button[disabled] { display: none; }
    .action-pay-card button:not([disabled]):last-child { display: none; }
    .action-pay-card .w-full.h-12 { height: 44px; font-size: 14px; }
}
</style>


@push('transaction-scripts')
<script>
document.addEventListener('alpine:init', () => {

    Alpine.data('checkoutModal', () => ({
        open: false,
        isLoading: false,

        // Summary data
        summary: { event: {}, buyer: {}, participants: [], ticket: {} },
        quantity: 1,
        subtotal: 0,
        platformFee: 0,

        // Payment
        categories: [],
        selectedMethodId: null,
        selectedFee: 0,
        formData: null,

        get grandTotal() {
            return Number(this.subtotal) + Number(this.platformFee) + Number(this.selectedFee);
        },

        get eventBannerSrc() {
            const img = this.summary.event?.image;
            if (img) return `/storage/event-images/${img}`;

            // Placeholder inline SVG — no network call, no third party dependency
            return 'data:image/svg+xml;utf8,' + encodeURIComponent(
                '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="200" viewBox="0 0 800 200">' +
                '<rect width="800" height="200" fill="#e2e8f0"/>' +
                '<text x="50%" y="50%" font-family="sans-serif" font-size="18" fill="#94a3b8" ' +
                'text-anchor="middle" dominant-baseline="middle">No Image</text>' +
                '</svg>'
            );
        },

        async handleOpen(detail) {
            const { summary, formData } = detail;

            this.summary = summary || {};
            this.formData = formData;
            this.quantity = Number(summary?.quantity || 1);
            this.subtotal = Number(summary?.subtotal || 0);
            this.platformFee = Number(summary?.platform_fee || 0);

            await this.loadCategories(summary?.payment_categories || []);
            this.openModal();
        },

        async loadCategories(categories) {
            const processed = [];

            for (let i = 0; i < categories.length; i++) {
                const cat = categories[i];
                const methods = [];

                for (let j = 0; j < (cat.methods || []).length; j++) {
                    const method = cat.methods[j];
                    const iconSrc = await svgToDataUri(method.icon);

                    let fee = 0;
                    let feeDisplay = 'Bebas Biaya';

                    if (method.fee_type === 'percent') {
                        fee = (this.subtotal * Number(method.fee_value)) / 100;
                        feeDisplay = `+${method.fee_value}% (${formatRupiah(fee)})`;
                    } else if (method.fee_type === 'fixed' && Number(method.fee_value) > 0) {
                        fee = Number(method.fee_value);
                        feeDisplay = `+${formatRupiah(fee)}`;
                    }

                    methods.push({
                        id: method.payment_gateway_method_id,
                        name: method.name,
                        icon: iconSrc,
                        fee,
                        feeDisplay,
                    });
                }

                processed.push({
                    name: cat.name,
                    methods,
                    expanded: i === 0,
                });
            }

            this.categories = processed;

            if (processed[0]?.methods[0]) {
                this.selectedMethodId = processed[0].methods[0].id;
                this.selectedFee = processed[0].methods[0].fee;
            } else {
                this.selectedMethodId = null;
                this.selectedFee = 0;
            }
        },

        openModal() {
            this.open = true;
            document.body.classList.add('modal-open');

            // Dispatch event setelah Alpine selesai render
            this.$nextTick(() => {
                window.dispatchEvent(new CustomEvent('checkout-modal-opened'));
            });
        },

        closeModal() {
            if (this.isLoading) return;
            this.open = false;
            document.body.classList.remove('modal-open');
        },

        toggleCategory(index) {
            this.categories.forEach((c, i) => c.expanded = i === index);
        },

        selectMethod(catIndex, method) {
            this.categories[catIndex].expanded = true;
            this.selectedMethodId = method.id;
            this.selectedFee = method.fee;
        },

        async submit() {
            if (!this.selectedMethodId) {
                showToast('warning', 'Silakan pilih metode pembayaran.');
                return;
            }

            this.isLoading = true;

            try {
                this.formData.set('payment_gateway_method_id', this.selectedMethodId);
                const result = await submitCheckout(this.formData);
                window.location.replace(result.redirect_url);
            } catch (err) {
                console.error(err);
                showToast('error', err.message || 'Terjadi kesalahan saat memproses pembayaran.');
                this.isLoading = false;
            }
        },
    }));

});


/* =========================================================
   HELPERS (SVG fetch, submit, ESC handler)
========================================================= */
async function svgToDataUri(url) {
    if (!url) return '';
    if (url.match(/\.(png|jpg|jpeg|webp)$/i)) return url;

    try {
        const res = await fetch(url);
        if (!res.ok) return url;
        let svg = await res.text();
        svg = svg.replace(/<script[\s\S]*?<\/script>/gi, '');
        if (!svg.includes('xmlns=')) {
            svg = svg.replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"');
        }
        const b64 = btoa(unescape(encodeURIComponent(svg)));
        return `data:image/svg+xml;base64,${b64}`;
    } catch (e) {
        console.warn('Gagal fetch SVG:', e);
        return url;
    }
}

async function submitCheckout(formData) {
    const csrf = '{{ csrf_token() }}';

    const res = await fetch('/checkout/store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData,
    });

    const ct = res.headers.get('content-type') || '';
    if (!ct.includes('application/json')) {
        throw new Error(res.status >= 500
            ? 'Terjadi kesalahan pada server.'
            : 'Server mengembalikan response yang tidak valid.');
    }

    const data = await res.json();
    if (!res.ok) throw new Error(data.message || 'Checkout gagal.');
    return data;
}

// ESC to close modal
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modalEl = document.getElementById('checkoutConfirmModal');
        if (modalEl && !modalEl.classList.contains('hidden') && window.Alpine) {
            // Trigger via Alpine magic
            window.dispatchEvent(new CustomEvent('close-checkout-modal'));
        }
    }
});
</script>
@endpush