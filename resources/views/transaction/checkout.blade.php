@extends('layouts.app')

@section('content')

<section class="checkout-section bg-[#f8fafc] pt-4 pb-5"
        x-data="checkoutPage({
        expiredAt: '{{ $reservation->expired_at->toIso8601String() }}',
        eventUrl: '{{ url($event->slug) }}',
        expireUrl: '{{ route('reservation.expire', ['reservationCode' => $reservation->reservation_code]) }}',
        updateUrl: '{{ route('reservation.update', ['reservationCode' => $reservation->reservation_code]) }}',
        csrf: '{{ csrf_token() }}',
        initialQty: {{ $reservation->quantity }},
        maxQty: {{ (int) ($maxQty ?? 999999) }},
        ticketPrice: {{ $ticket->ticket_price }}
    })"
         x-init="init()">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HERO TITLE --}}
    <div class="text-center mb-5">
        <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f172a] tracking-tight m-0">
            Selesaikan Pemesanan
        </h1>
        <input type="hidden" id="reservationExpiredAt" :value="expiredAtIso">
    </div>

    {{-- PROGRESS BAR --}}
    <div class="flex justify-center items-center gap-2 sm:gap-3 mb-7">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center font-bold text-xs sm:text-sm">
                <i class="ti ti-check"></i>
            </div>
            <span class="hidden sm:inline text-xs font-semibold text-[#64748b]">Pilih Tiket</span>
        </div>
        <div class="w-6 sm:w-10 h-0.5 bg-[#e2e8f0]"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#2282ff] text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-[0_4px_12px_rgba(34,130,255,0.25)]">2</div>
            <span class="hidden sm:inline text-xs font-semibold text-[#0f172a]">Data Peserta</span>
        </div>
        <div class="w-6 sm:w-10 h-0.5 bg-[#e2e8f0]"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#e2e8f0] text-[#94a3b8] flex items-center justify-center font-bold text-xs sm:text-sm">3</div>
            <span class="hidden sm:inline text-xs font-semibold text-[#64748b]">Pembayaran</span>
        </div>
        <div class="w-6 sm:w-10 h-0.5 bg-[#e2e8f0]"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#e2e8f0] text-[#94a3b8] flex items-center justify-center font-bold text-xs sm:text-sm">4</div>
            <span class="hidden sm:inline text-xs font-semibold text-[#64748b]">Tiket</span>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data" id="checkout-event">
        @csrf
        <div class="checkout-page grid grid-cols-1 lg:grid-cols-12 gap-5 relative
            pb-[220px] lg:pb-0">

            {{-- ==================== LEFT: FORM ==================== --}}
            <div class="lg:col-span-7 space-y-5">

                <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                    <div class="p-5 sm:p-6">

                        <h2 class="text-base font-extrabold text-[#0f172a] m-0 mb-5">Data Pemesan</h2>

                        @if(auth()->check())
                        <div class="flex items-center gap-3.5 p-3.5 mb-5 bg-[#ebf3ff] border border-[#c2dcff] rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-[#2282ff] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-[#0f172a] truncate">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-[#64748b] truncate">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                        @endif

                        <input type="hidden" name="is_login" id="is_login" value="{{ auth()->check() ? 1 : 0 }}">
                        <input type="hidden" name="user_login_id" id="user_login_id" value="{{ auth()->check() ? auth()->user()->id : '0' }}">

                        <div class="mb-4">
                            <label for="buyerName" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 read-only:bg-[#f1f5f9] read-only:text-[#64748b]"
                                   name="buyer[name]" id="buyerName" type="text" placeholder="Masukkan nama lengkap"
                                   required autocomplete="on"
                                   {{ auth()->check() ? 'readonly' : '' }}
                                   value="{{ auth()->check() ? auth()->user()->name : '' }}">
                        </div>

                        <div class="mb-4">
                            <label for="buyerEmail" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 read-only:bg-[#f1f5f9] read-only:text-[#64748b]"
                                   name="buyer[email]" id="buyerEmail" type="email" placeholder="example@email.com"
                                   required autocomplete="on"
                                   {{ auth()->check() ? 'readonly' : '' }}
                                   value="{{ auth()->check() ? auth()->user()->email : '' }}">
                        </div>

                        <div class="mb-4">
                            <label for="buyerPhone" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                Nomor HP <span class="text-rose-500">*</span>
                            </label>
                            <input class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                                   name="buyer[phone]" id="buyerPhone" type="text"
                                   placeholder="+62 821 3355 3002" value="+62" required>
                        </div>

                        {{-- QTY --}}
                        <div class="mb-5">
                            <label class="block text-[13px] font-bold text-[#334155] mb-1.5">Jumlah Tiket</label>
                            <div class="inline-flex items-center justify-between bg-[#f1f5f9] border border-[#e2e8f0] p-1 rounded-lg w-[130px]">
                                <button type="button" id="qtyMinus" @click="decrementQty()"
                                        class="w-8 h-8 bg-white rounded-md flex items-center justify-center text-[#0f172a] font-bold text-sm shadow-sm hover:bg-[#2282ff] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        :disabled="qty <= 1">
                                    <i class="ti ti-minus"></i>
                                </button>
                                <input id="ticketQty" class="w-11 h-8 bg-transparent text-center font-bold text-[15px] text-[#0f172a] outline-none"
                                       type="number" min="1" :value="qty" readonly>
                                <button type="button" id="qtyPlus" @click="incrementQty()"
                                        class="w-8 h-8 bg-white rounded-md flex items-center justify-center text-[#0f172a] font-bold text-sm shadow-sm hover:bg-[#2282ff] hover:text-white transition-colors">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>

                        <hr class="my-5 border-[#e2e8f0]">

                        {{-- ============ NOTICE: EDIT POLICY ============ --}}
                            @if($event->allow_edit_form == 1)

                                {{-- Event BOLEH edit setelah registrasi --}}
                                <div class="mt-3 p-3.5 rounded-lg border border-[#a7f3d0] bg-[#ecfdf5] flex items-start gap-2.5">
                                    <div class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-[11px] shrink-0 mt-0.5">
                                        <i class="ti ti-check"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-[#065f46] mb-0.5">
                                            Data peserta masih dapat diubah
                                        </div>
                                        <p class="text-[11px] text-[#065f46]/80 leading-relaxed m-0">
                                            Setelah registrasi selesai, Anda masih bisa mengubah data peserta melalui
                                            fitur <strong>Check Registration</strong> di halaman utama.
                                        </p>
                                    </div>
                                </div>

                            @else

                                {{-- Event TIDAK BOLEH edit setelah registrasi --}}
                                <div class="mt-3 p-3.5 rounded-lg border border-[#fecaca] bg-[#fef2f2] flex items-start gap-2.5">
                                    <div class="w-5 h-5 rounded-full bg-[#fee2e2] text-[#dc2626] flex items-center justify-center text-[11px] shrink-0 mt-0.5">
                                        <i class="ti ti-alert-triangle"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-[#991b1b] mb-0.5">
                                            Data peserta tidak dapat diubah
                                        </div>
                                        <p class="text-[11px] text-[#991b1b]/80 leading-relaxed m-0">
                                            Penyelenggara tidak mengizinkan perubahan data peserta setelah registrasi selesai.
                                            Pastikan semua data sudah benar sebelum melanjutkan.
                                        </p>
                                    </div>
                                </div>

                            @endif

                    </div>
                </div>

                @include('transaction.participant')

            </div>

            {{-- ==================== RIGHT: SUMMARY ==================== --}}
            <div class="lg:col-span-5">
                <div class="summary-sidebar-wrapper space-y-4 lg:sticky lg:top-20 lg:self-start">

                    {{-- CARD INFO EVENT --}}
                    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)] overflow-hidden">
                        <img src="{{ asset('storage/event-images/' . $event->image) }}"
                             class="w-full h-40 object-cover" alt="{{ $event->title }}">

                        <div class="p-5">
                            <h3 class="text-base font-extrabold text-[#0f172a] m-0 mb-2.5 leading-snug">{{ $event->title }}</h3>

                            <div class="flex items-center gap-2 text-[13px] text-[#64748b] mb-2">
                                <i class="ti ti-user"></i>
                                <span>{{ $event->penyelenggara->name }}</span>
                            </div>

                            <div class="flex items-start gap-2 text-[13px] text-[#64748b] mb-4">
                                <i class="ti ti-map-pin mt-0.5"></i>
                                <span>
                                    @if(strtolower($event->location_jenis)=='online')
                                        Online
                                    @else
                                        {{ $event->location_detail }}<br>
                                        {{ $event->location_city }}, {{ $event->province->name }}
                                    @endif
                                </span>
                            </div>

                            <div class="p-3.5 rounded-lg bg-[#f8fafc] border border-[#f1f5f9] text-sm">
                                <strong class="text-[#0f172a]">{{ $ticket->ticket_name }}</strong><br>
                                <small class="text-[#64748b]" id="summaryQty" x-text="`Qty ${qty} Ticket`"></small>
                            </div>

                            <div class="mt-4 p-3.5 rounded-lg bg-[#ecfdf5] border border-[#a7f3d0] space-y-1.5">
                                <div class="flex items-center gap-2 text-xs font-semibold text-[#065f46]">
                                    <i class="ti ti-shield-check"></i> Secure payment
                                </div>
                                <div class="flex items-center gap-2 text-xs font-semibold text-[#065f46]">
                                    <i class="ti ti-ticket"></i> Verify and generate tickets automatically
                                </div>
                            </div>

                            <div class="flex items-center gap-2.5 mt-4">
                                <input type="checkbox" id="persetujuan" required
                                       class="w-4 h-4 accent-[#2282ff] cursor-pointer shrink-0">
                                <label for="persetujuan" class="text-[13px] text-[#0f172a] cursor-pointer">
                                    Saya setuju dengan <strong>Syarat & Ketentuan</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- STICKY ACTION --}}
                    <div class="sticky-checkout-action
                        fixed bottom-0 left-0 right-0 z-50
                        lg:static lg:z-auto
                        bg-white border-t border-[#e2e8f0]
                        lg:border lg:rounded-2xl
                        rounded-t-2xl
                        shadow-[0_-6px_20px_rgba(0,0,0,0.08)] lg:shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]
                        p-4 pb-[calc(1rem+env(safe-area-inset-bottom))] lg:p-5 lg:pb-5">

                        <div class="reservation-countdown flex items-center justify-center gap-2 mb-4 px-4 py-2.5 border rounded-full text-sm font-bold w-full transition-colors"
                             :class="expired
                                 ? 'bg-[#fef2f2] border-[#fecaca] text-[#dc2626]'
                                 : 'bg-[#fff7ed] border-[#fed7aa] text-[#c2410c]'"
                             id="reservationCountdown">
                            <i class="ti ti-clock"></i>
                            <span id="countdownText" x-text="countdownText"></span>
                        </div>

                        <div class="price-box">
                            <small class="block text-xs text-[#64748b]">Total Pembayaran</small>
                            <div class="text-2xl font-extrabold text-[#2282ff] mt-0.5 tracking-tight"
                                 id="summaryPrice"
                                 x-text="formatRupiah(qty * ticketPrice)">
                                Rp {{ number_format($ticket->ticket_price,0,',','.') }}
                            </div>
                        </div>

                        <input type="hidden" name="reservation_code" value="{{ $reservation->reservation_code }}">
                        <input type="hidden" id="quantity" name="quantity" :value="qty">
                        <input type="hidden" id="ticketPrice" :value="ticketPrice">
                        <input type="hidden" id="totalPrice" name="totalPrice" :value="qty * ticketPrice">

                        <button type="submit" id="checkout-button"
                                class="mt-3 w-full h-12 flex items-center justify-center gap-2 rounded-lg font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all">
                            <i class="ti ti-credit-card"></i>
                            <span>Lanjut ke Pembayaran</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
</section>

@include('transaction.payment-confirmation')

@endsection

@push('transaction-scripts')
    @include('transaction.scripts.participant-init')
    @include('transaction.scripts.participant')
    @include('transaction.scripts.participant-copy')
    @include('transaction.scripts.participant-upload')
    @include('transaction.scripts.summary')
    @include('transaction.scripts.payment-confirmation')

<script>
/* =========================================================
   GLOBAL HELPERS
========================================================= */
function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', maximumFractionDigits: 0
    }).format(Number(num || 0));
}

function showToast(icon, title, options = {}) {
    if (typeof window.toast === 'undefined') {
        console.warn('[toast] Toastry tidak ter-load. Fallback ke alert().');
        alert(title);
        return;
    }

    const map = {
        success: 'success',
        error:   'error',
        warning: 'warning',
        info:    'info',
    };

    const method = map[icon] || 'info';

    const payload = {
        description: options.description || undefined,
        duration: options.duration !== undefined ? options.duration : 4000,
    };

    // Kalau butuh tombol OK (seperti SweetAlert)
    if (options.withButton) {
        payload.duration = 0; // tidak auto-dismiss
        payload.action = {
            label: options.buttonLabel || 'OK',
            onClick() {
                if (typeof options.onClick === 'function') options.onClick();
            },
        };
    }

    if (typeof window.toast[method] === 'function') {
        window.toast[method](title, payload);
    } else {
        alert(title);
    }
}

window.openCheckoutModal = function (summary, formData) {
    window.dispatchEvent(new CustomEvent('open-checkout-modal', {
        detail: { summary, formData }
    }));
};


/* =========================================================
   ALPINE: checkoutPage
========================================================= */
document.addEventListener('alpine:init', () => {

    Alpine.data('checkoutPage', (config) => ({
        qty: config.initialQty,
        maxQty: config.maxQty,
        ticketPrice: config.ticketPrice,
        expiredAtIso: config.expiredAt,
        countdownText: 'Memuat sisa waktu...',
        expired: false,
        timerId: null,
        updatingQty: false,

        init() {
            this.startCountdown(config);

            // Dispatch qty awal supaya participant langsung dirender
            this.$nextTick(() => {
                window.dispatchEvent(new CustomEvent('qty-changed', {
                    detail: { qty: this.qty }
                }));
            });
        },

        async incrementQty() {
            if (this.updatingQty) return;

            if (this.qty >= this.maxQty) {
                showToast('warning', `Maksimal ${this.maxQty} tiket tersedia.`);
                return;
            }

            await this.updateQty(this.qty + 1);
        },

        async decrementQty() {
            if (this.updatingQty) return;

            if (this.qty <= 1) {
                showToast('warning', 'Minimal pembelian 1 tiket.');
                return;
            }

            await this.updateQty(this.qty - 1);
        },

        

        async updateQty(newQty) {
            if (!config.updateUrl || config.updateUrl.includes('undefined')) {
                console.error('updateUrl tidak valid:', config.updateUrl);
                showToast('error', 'URL update reservasi tidak valid.');
                return;
            }

            this.updatingQty = true;

            try {
                const res = await fetch(config.updateUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ quantity: newQty }),
                // ... sisa kode sama
                });

                const data = await res.json();
                if (!res.ok) throw data;

                this.qty = Number(data.quantity);

                window.dispatchEvent(new CustomEvent('qty-changed', {
                    detail: { qty: this.qty }
                }));

            } catch (err) {
                let message = 'Terjadi kesalahan pada server.';
                if (err.errors) message = Object.values(err.errors)[0][0];
                else if (err.message) message = err.message;

                showToast('error', message);

            } finally {
                this.updatingQty = false;
            }
        },

        startCountdown({ expiredAt, eventUrl, expireUrl, csrf }) {
            // Guard: kalau sudah pernah jalan, jangan bikin timer baru
            if (this._countdownStarted) return;
            this._countdownStarted = true;

            const end = new Date(expiredAt);
            let handled = false;

            const tick = async () => {
                // Guard: kalau sudah handle expiry, stop total
                if (handled) return;

                const diff = end - new Date();

                if (diff <= 0) {
                    handled = true;
                    this.timerId = null;
                    this.expired = true;
                    this.countdownText = 'Reservation telah berakhir';

                    try {
                        await fetch(expireUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        });

                        showToast('error', 'Waktu reservasi telah habis.');
                        setTimeout(() => window.location.href = eventUrl, 2000);

                    } catch (e) {
                        console.error(e);
                        showToast('error', 'Gagal mengakhiri reservation.');
                    }
                    return;
                }

                const m = Math.floor(diff / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                this.countdownText = `Selesaikan pembayaran dalam ${m}:${String(s).padStart(2, '0')}`;

                // Chain timeout berikutnya
                this.timerId = setTimeout(tick, 1000);
            };

            tick();
        },
    }));

    

});
</script>
@endpush