@extends('layouts.app')

@section('title', 'Pembayaran - '.$transaction->transaction_code)

@section('content')

<section class="bg-[#f8fafc] pt-4 pb-5 min-h-screen"
         x-data="paymentPage({
            expiredAt: '{{ \Carbon\Carbon::parse($transaction->expired_at)->toIso8601String() }}',
            eventUrl: '{{ url($transaction->event->slug) }}',
            expireUrl: '{{ route('reservation.expire', ['reservationCode' => $transaction->reservation->reservation_code]) }}',
            checkStatusUrl: '{{ route('transaction.check-status', $transaction->transaction_code) }}',
            paymentMethodsUrl: '{{ route('transaction.payment-methods', $transaction->transaction_code) }}',
            changePaymentUrl: '{{ route('transaction.change-payment', $transaction->transaction_code) }}',
            csrf: '{{ csrf_token() }}',
            subtotal: {{ (int) $transaction->subtotal }},
            platformFee: {{ (int) $transaction->platform_fee }},
            initialFee: {{ (int) ($transaction->payment_fee ?? 0) }},
            initialMethodId: {{ (int) $transaction->payment_gateway_method_id }}
         })"
         x-init="init()">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- ==================== HERO TITLE ==================== --}}
    <div class="text-center mb-5">
        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-[#ebf3ff] border border-[#c2dcff] text-[#2282ff] text-base font-extrabold">
            <i class="ti ti-credit-card text-lg"></i>
            <span>Selesaikan Pembayaran</span>
        </div>
    </div>

    {{-- ==================== PROGRESS ==================== --}}
    <div class="hidden lg:flex justify-center items-center gap-3 mb-7">
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-sm font-bold">
                <i class="ti ti-check"></i>
            </div>
            <span class="text-xs font-semibold text-[#64748b]">Pilih Tiket</span>
        </div>
        <div class="w-10 h-0.5 bg-[#e2e8f0]"></div>
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-sm font-bold">
                <i class="ti ti-check"></i>
            </div>
            <span class="text-xs font-semibold text-[#64748b]">Data Peserta</span>
        </div>
        <div class="w-10 h-0.5 bg-[#e2e8f0]"></div>
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-full bg-[#2282ff] text-white flex items-center justify-center text-sm font-bold shadow-[0_4px_12px_rgba(34,130,255,0.25)]">3</div>
            <span class="text-xs font-semibold text-[#0f172a]">Pembayaran</span>
        </div>
        <div class="w-10 h-0.5 bg-[#e2e8f0]"></div>
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-full bg-[#e2e8f0] text-[#94a3b8] flex items-center justify-center text-sm font-bold">4</div>
            <span class="text-xs font-semibold text-[#64748b]">Tiket</span>
        </div>
    </div>

    {{-- ==================== MAIN GRID ==================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- ========== LEFT: PAYMENT ========== --}}
        <div class="lg:col-span-7">
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                <div class="p-5 sm:p-6">

                    {{-- Transaction Code --}}
                    <div class="flex justify-between items-center pb-4 border-b border-[#e2e8f0] mb-5">
                        <div>
                            <small class="block text-xs text-[#64748b]">Kode Transaksi</small>
                            <strong class="text-sm text-[#0f172a]">{{ $transaction->transaction_code }}</strong>
                        </div>
                    </div>

                    {{-- ==================== PAYMENT DISPLAY ==================== --}}
                    <div class="bg-[#f8fafc] border-[1.5px] border-dashed border-[#e2e8f0] rounded-2xl p-5 sm:p-6 text-center mb-5">

                        {{-- QRIS --}}
                        @if(!empty($paymentDisplay['qr_value']))
                            <h6 class="text-sm font-bold text-[#0f172a] mb-3">Scan QRIS untuk Membayar</h6>

                            <div class="my-4">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($paymentDisplay['qr_value']) }}"
                                     alt="QRIS Payment Code"
                                     class="w-[220px] h-[220px] rounded-xl border border-[#e2e8f0] p-2 bg-white shadow-[0_4px_10px_rgba(0,0,0,0.05)] mx-auto">
                            </div>

                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0f172a] bg-white border border-[#e2e8f0] px-3 py-1.5 rounded-md">
                                <i class="ti ti-qrcode"></i> Verifikasi Otomatis
                            </span>

                        {{-- VIRTUAL ACCOUNT --}}
                        @elseif(!empty($paymentDisplay['va_number']))
                            <h6 class="text-sm font-bold text-[#0f172a] mb-3">Nomor Virtual Account</h6>

                            <div class="inline-flex flex-col sm:flex-row items-center gap-3 p-3 rounded-lg bg-white border border-[#e2e8f0] max-w-full">
                                <span class="text-base sm:text-lg font-extrabold text-[#2282ff] tracking-wider break-all text-center"
                                      id="vaText">
                                    {{ $paymentDisplay['va_number'] }}
                                </span>
                                <button type="button"
                                        class="w-full sm:w-auto px-3 py-1.5 text-xs font-bold rounded-md bg-[#ebf3ff] text-[#2282ff] border border-[#c2dcff] hover:bg-[#2282ff] hover:text-white transition-colors"
                                        data-va="{{ $paymentDisplay['va_number'] }}"
                                        @click="copyToClipboard($el.dataset.va)">
                                    <i class="ti ti-copy"></i> Salin
                                </button>
                            </div>

                        {{-- E-WALLET --}}
                        @elseif(!empty($paymentDisplay['deeplink_url']))
                            <h6 class="text-sm font-bold text-[#0f172a] mb-3">Pembayaran E-Wallet</h6>

                            <a href="{{ $paymentDisplay['deeplink_url'] }}"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center justify-between w-full p-4 rounded-2xl bg-gradient-to-br from-[#d4dce7] to-[#dee7f6] text-[#1e264d] no-underline hover:-translate-y-0.5 hover:no-underline transition-transform">
                                <span class="flex items-center gap-3.5">
                                    <span class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-2xl">
                                        <i class="ti ti-wallet"></i>
                                    </span>
                                    <span class="flex flex-col items-start">
                                        <small class="text-xs mb-0.5">Continue Payment</small>
                                        <strong class="text-base font-bold">
                                            Open {{ strtoupper($transaction->paymentGatewayMethod?->method?->name ?? 'E-Wallet') }}
                                        </strong>
                                    </span>
                                </span>
                                <i class="ti ti-arrow-up-right text-xl opacity-90"></i>
                            </a>

                        {{-- DEFAULT --}}
                        @else
                            <div class="py-3">
                                <i class="ti ti-info-circle text-[#2282ff] text-4xl mb-2 inline-block"></i>
                                <h6 class="text-sm font-bold text-[#0f172a] m-0">Instruksi Pembayaran</h6>
                            </div>
                        @endif

                    </div>

                    {{-- ==================== PAYMENT METHOD BADGE ==================== --}}
                    <div class="flex items-center justify-center gap-3 px-4 py-3 rounded-lg border-[1.5px] border-[#e2e8f0] bg-white mb-5">
                        @if($transaction->paymentGatewayMethod?->method?->icon)
                            <img id="payment-method-icon"
                                 class="w-12 h-7 object-contain"
                                 alt="{{ $transaction->paymentGatewayMethod->method->name }}">
                        @endif
                        <span class="text-sm font-semibold text-[#0f172a]">
                            {{ $transaction->paymentGatewayMethod?->method?->name }}
                        </span>
                    </div>

                    {{-- ==================== TOTAL ==================== --}}
                    <div class="flex justify-between items-center p-4 rounded-lg bg-[#f8fafc] mb-5">
                        <span class="text-xs font-bold text-[#64748b]">Total Pembayaran</span>
                        <span class="text-xl font-extrabold text-[#2282ff]">
                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- ==================== TIMER ==================== --}}
                    <div class="rounded-xl p-4 text-center mb-5 transition-colors"
                         :class="expired
                            ? 'bg-[#fef2f2] border border-[#fecaca]'
                            : 'bg-[#fffbeb] border border-[#fde68a]'">
                        <div class="text-[11px] font-bold uppercase tracking-wide transition-colors"
                             :class="expired ? 'text-[#dc2626]' : 'text-[#b45309]'">
                            Batas Waktu Pembayaran
                        </div>
                        <div class="text-2xl font-extrabold mt-1 transition-colors"
                             :class="expired ? 'text-[#dc2626]' : 'text-[#d97706]'"
                             x-text="countdownText">
                            00:00:00
                        </div>
                        <small class="block text-xs text-[#64748b] mt-1">
                            Selesaikan sebelum
                            <strong>{{ \Carbon\Carbon::parse($transaction->expired_at)->format('d M Y, H:i') }} WIB</strong>
                        </small>
                    </div>

                    {{-- ==================== ACTION BUTTONS ==================== --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button"
                                @click="checkPaymentStatus(true)"
                                :disabled="checking"
                                class="flex-1 h-11 inline-flex items-center justify-center gap-2 rounded-xl border-[1.5px] border-[#e2e8f0] bg-white text-[#0f172a] text-sm font-bold hover:bg-[#f1f5f9] transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                            <i class="ti ti-refresh" :class="checking && 'animate-spin'"></i>
                            Cek Status
                        </button>

                        <button type="button"
                                @click="openModal()"
                                class="flex-1 h-11 inline-flex items-center justify-center gap-2 rounded-xl border-[1.5px] border-[#c2dcff] bg-[#ebf3ff] text-[#2282ff] text-sm font-bold hover:bg-[#2282ff] hover:text-white transition-colors">
                            <i class="ti ti-arrows-left-right"></i>
                            Ganti Pembayaran
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ========== RIGHT: SUMMARY ========== --}}
        <div class="lg:col-span-5">
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                <div class="p-5 sm:p-6">

                    <h6 class="text-sm font-bold text-[#0f172a] mb-4 flex items-center gap-2">
                        <i class="ti ti-receipt"></i> Ringkasan Pesanan
                    </h6>

                    {{-- Info rows --}}
                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Event</span>
                        <strong class="text-[#0f172a] text-right ml-3">{{ $transaction->event->title ?? 'Nama Event' }}</strong>
                    </div>
                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Jenis Tiket</span>
                        <strong class="text-[#0f172a]">{{ $transaction->ticket->name ?? 'Tiket' }}</strong>
                    </div>
                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Jumlah Tiket</span>
                        <strong class="text-[#0f172a]">{{ $transaction->quantity }}x</strong>
                    </div>
                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Pembeli</span>
                        <strong class="text-[#0f172a] text-right ml-3">{{ $transaction->buyer_name }}</strong>
                    </div>

                    <hr class="my-4 border-[#e2e8f0]">

                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Subtotal Tiket</span>
                        <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Biaya Platform</span>
                        <span>Rp {{ number_format($transaction->platform_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[13.5px] text-[#64748b] mb-2.5">
                        <span>Biaya Pembayaran</span>
                        <span>Rp {{ number_format($transaction->payment_fee, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-3 mt-3 border-t border-dashed border-[#e2e8f0]">
                        <span class="text-base font-extrabold text-[#0f172a]">Grand Total</span>
                        <span class="text-base font-extrabold text-[#2282ff]">
                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL: GANTI METODE PEMBAYARAN (Alpine)                     --}}
{{-- ============================================================ --}}
<div x-show="modalOpen"
     x-cloak
     class="fixed inset-0 z-[100]"
     @keydown.escape.window="closeModal()">

    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
         @click="closeModal()"
         x-transition.opacity></div>

    <div class="relative flex items-center justify-center min-h-screen p-3 sm:p-4 pointer-events-none">
        <div class="pointer-events-auto bg-white rounded-2xl shadow-[0_25px_50px_-12px_rgba(15,23,42,0.22)] w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden"
             @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            {{-- Header --}}
            <div class="flex justify-between items-center px-5 py-4 border-b border-[#e2e8f0] shrink-0">
                <h5 class="flex items-center gap-2 text-base font-bold text-[#0f172a] m-0">
                    <i class="ti ti-wallet text-[#2282ff]"></i>
                    Ganti Metode Pembayaran
                </h5>
                <button type="button"
                        @click="closeModal()"
                        :disabled="submitting"
                        class="w-9 h-9 rounded-full bg-[#f1f5f9] text-[#64748b] hover:bg-[#e2e8f0] hover:text-[#0f172a] flex items-center justify-center transition-colors disabled:opacity-50"
                        aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto p-5">

                {{-- Loading --}}
                <div x-show="loadingMethods" class="text-center py-8">
                    <div class="inline-block w-8 h-8 border-4 border-[#2282ff] border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-xs text-[#64748b] mt-3 mb-0">Memuat metode pembayaran...</p>
                </div>

                {{-- Categories --}}
                <div x-show="!loadingMethods"
                     class="flex flex-col gap-2.5">
                    <template x-for="(cat, cIdx) in categories" :key="cIdx">
                        <div class="border rounded-lg overflow-hidden bg-white transition-all"
                             :class="cat.expanded ? 'border-[#c2dcff] shadow-[0_4px_12px_rgba(34,130,255,0.05)]' : 'border-[#e2e8f0]'">

                            <div class="px-4 py-3.5 flex justify-between items-center cursor-pointer hover:bg-[#f8fafc] select-none transition-colors"
                                 @click="toggleCategory(cIdx)">
                                <div class="text-sm font-bold text-[#0f172a]" x-text="cat.name"></div>
                                <i class="ti ti-chevron-down text-sm text-[#64748b] transition-transform"
                                   :class="cat.expanded && 'rotate-180 text-[#2282ff]'"></i>
                            </div>

                            <div x-show="cat.expanded" x-cloak
                                 class="px-4 pt-3 pb-4 border-t border-[#f1f5f9] bg-[#fafafa]">
                                <div class="flex flex-col gap-2">
                                    <template x-for="(method, mIdx) in cat.methods" :key="method.id">
                                        <div class="flex items-center justify-between px-4 py-3 rounded-lg border-[1.5px] bg-white cursor-pointer transition-all"
                                             :class="selectedMethodId === method.id
                                                 ? 'border-[#2282ff] bg-[#ebf3ff] shadow-[0_0_0_1px_#2282ff]'
                                                 : 'border-[#e2e8f0] hover:border-[#c2dcff]'"
                                             @click.stop="selectMethod(cIdx, method)">
                                            <div class="flex items-center gap-3">
                                                <img x-show="method.icon"
                                                     :src="method.icon"
                                                     class="w-12 h-7 object-contain"
                                                     :alt="method.name">
                                                <span class="text-[13.5px] font-semibold text-[#0f172a]" x-text="method.name"></span>
                                            </div>
                                            <span class="text-xs font-bold text-[#2282ff]" x-text="method.feeDisplay"></span>
                                        </div>
                                    </template>
                                    <template x-if="!cat.methods || cat.methods.length === 0">
                                        <div class="text-center text-[11px] text-[#64748b] py-2">
                                            Tidak ada metode aktif.
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Summary --}}
                <div class="mt-5 p-4 rounded-lg bg-[#f8fafc] border border-[#e2e8f0]">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-[#64748b]">Biaya Penanganan</span>
                        <span class="text-sm font-bold text-[#0f172a]"
                              x-text="formatRupiah(selectedFee)"></span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-[#e2e8f0]">
                        <span class="text-sm font-extrabold text-[#0f172a]">Total Pembayaran Baru</span>
                        <span class="text-lg font-extrabold text-[#2282ff]"
                              x-text="formatRupiah(grandTotal)"></span>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-5 py-3.5 border-t border-[#e2e8f0] flex justify-end gap-2 shrink-0">
                <button type="button"
                        @click="closeModal()"
                        :disabled="submitting"
                        class="px-5 py-2.5 rounded-lg bg-[#f1f5f9] hover:bg-[#e2e8f0] text-[#0f172a] text-sm font-bold transition-colors disabled:opacity-50">
                    Batal
                </button>

                <button type="button"
                        @click="submitChange()"
                        :disabled="submitting"
                        class="px-5 py-2.5 rounded-lg bg-[#2282ff] hover:bg-[#1b6cd6] text-white text-sm font-bold transition-colors disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2">
                    <template x-if="!submitting">
                        <span class="inline-flex items-center gap-2">
                            <span>Konfirmasi Perubahan</span>
                            <i class="ti ti-arrow-right"></i>
                        </span>
                    </template>
                    <template x-if="submitting">
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-loader-2 animate-spin"></i>
                            <span>Memproses...</span>
                        </span>
                    </template>
                </button>
            </div>

        </div>
    </div>
</div>

</section>

@endsection


@push('scripts')
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
        alert(title);
        return;
    }

    const map = { success: 'success', error: 'error', warning: 'warning', info: 'info' };
    const method = map[icon] || 'info';

    const payload = {
        description: options.description || undefined,
        duration: options.duration !== undefined ? options.duration : 3000,
    };

    if (options.withButton) {
        payload.duration = 0;
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

async function svgToDataUri(url) {
    if (!url) return '';
    if (/\.(png|jpg|jpeg|webp)$/i.test(url)) return url;

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


/* =========================================================
   ALPINE: paymentPage
========================================================= */
document.addEventListener('alpine:init', () => {

    Alpine.data('paymentPage', (config) => ({
        // Countdown
        expired: false,
        countdownText: '00:00:00',
        timerId: null,
        _started: false,

        // Status polling
        statusIntervalId: null,
        checking: false,

        // Modal
        modalOpen: false,
        loadingMethods: false,
        categories: [],
        selectedMethodId: config.initialMethodId || null,
        selectedFee: config.initialFee || 0,
        submitting: false,

        // Money
        subtotal: config.subtotal || 0,
        platformFee: config.platformFee || 0,

        get grandTotal() {
            return Number(this.subtotal) + Number(this.platformFee) + Number(this.selectedFee);
        },

        init() {
            this.startCountdown(config);
            this.startStatusPolling(config);
            this.loadPaymentMethodIcon();
        },

        /* ---------- COUNTDOWN ---------- */
        startCountdown({ expiredAt, eventUrl, expireUrl, csrf }) {
            if (this._started) return;
            this._started = true;

            const end = new Date(expiredAt);
            let handled = false;

            const tick = async () => {
                if (handled) return;

                const diff = end - new Date();

                if (diff <= 0) {
                    handled = true;
                    this.timerId = null;
                    this.expired = true;
                    this.countdownText = 'EXPIRED';

                    if (this.statusIntervalId) {
                        clearInterval(this.statusIntervalId);
                        this.statusIntervalId = null;
                    }

                    showToast('error', 'Waktu Habis', {
                        description: 'Waktu reservasi Anda telah berakhir.',
                        withButton: true,
                        buttonLabel: 'OK',
                        onClick: () => window.location.href = eventUrl,
                    });

                    try {
                        await fetch(expireUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({}),
                        });
                    } catch (e) {
                        console.error(e);
                    }
                    return;
                }

                const h = Math.floor(diff / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);

                this.countdownText =
                    `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;

                this.timerId = setTimeout(tick, 1000);
            };

            tick();
        },

        /* ---------- STATUS POLLING ---------- */
        startStatusPolling({ checkStatusUrl }) {
            this.statusIntervalId = setInterval(() => {
                if (!this.expired && !this.checking) {
                    this.checkPaymentStatus(false, checkStatusUrl);
                }
            }, 4000);

            // Initial check
            setTimeout(() => this.checkPaymentStatus(false, checkStatusUrl), 1500);
        },

        async checkPaymentStatus(isManual = false, url = null) {
            if (this.expired) return;

            const endpoint = url || config_checkStatusUrl(this);
            if (!endpoint) return;

            if (isManual) this.checking = true;

            try {
                const res = await fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    cache: 'no-store',
                });

                const data = await res.json();

                if (data.status === 'paid' || data.status === 'Paid') {
                    if (this.statusIntervalId) clearInterval(this.statusIntervalId);

                    showToast('success', 'Pembayaran Berhasil!', {
                        description: 'Pembayaran Anda telah diterima.',
                        duration: 1500,
                    });

                    setTimeout(() => {
                        window.location.href = data.redirect_url || data.url || window.location.href;
                    }, 1500);
                    return;
                }

                if (data.status === 'expired' || data.status === 'failed') {
                    this.expired = true;
                    return;
                }

                if (isManual) {
                    showToast('info', 'Belum Diterima', {
                        description: 'Pembayaran belum terdeteksi. Silakan selesaikan pembayaran terlebih dahulu.',
                    });
                }

            } catch (err) {
                console.error('Payment status error:', err);
            } finally {
                this.checking = false;
            }
        },

        /* ---------- COPY CLIPBOARD ---------- */
        copyToClipboard(text) {
            if (!text) return;

            const done = () => showToast('success', 'Nomor VA berhasil disalin');

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done).catch(() => this.fallbackCopy(text, done));
                return;
            }
            this.fallbackCopy(text, done);
        },

        fallbackCopy(text, cb) {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try {
                document.execCommand('copy');
                if (cb) cb();
            } catch (e) {
                console.error(e);
            }
            document.body.removeChild(ta);
        },

        /* ---------- MODAL ---------- */
        openModal() {
            this.modalOpen = true;
            document.body.classList.add('modal-open');
            this.fetchPaymentMethods();
        },

        closeModal() {
            if (this.submitting) return;
            this.modalOpen = false;
            document.body.classList.remove('modal-open');
        },

        async fetchPaymentMethods() {
            this.loadingMethods = true;
            this.categories = [];

            try {
                const res = await fetch(config_paymentMethodsUrl(this), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                const data = await res.json();
                await this.processCategories(data.payment_categories || []);

            } catch (e) {
                console.error(e);
                showToast('error', 'Gagal memuat metode pembayaran.');
            } finally {
                this.loadingMethods = false;
            }
        },

        async processCategories(raw) {
            const processed = [];

            for (let i = 0; i < raw.length; i++) {
                const cat = raw[i];
                const methods = [];

                for (let j = 0; j < (cat.methods || []).length; j++) {
                    const m = cat.methods[j];
                    const icon = await svgToDataUri(m.icon);

                    let fee = 0;
                    let feeDisplay = 'Bebas Biaya';

                    if (m.fee_type === 'percent') {
                        fee = (this.subtotal * Number(m.fee_value)) / 100;
                        feeDisplay = `+${m.fee_value}% (${formatRupiah(fee)})`;
                    } else if (m.fee_type === 'fixed' && Number(m.fee_value) > 0) {
                        fee = Number(m.fee_value);
                        feeDisplay = `+${formatRupiah(fee)}`;
                    }

                    methods.push({
                        id: m.payment_gateway_method_id,
                        name: m.name,
                        icon,
                        fee,
                        feeDisplay,
                    });
                }

                processed.push({ name: cat.name, methods, expanded: i === 0 });
            }

            this.categories = processed;

            // Sync selected fee
            const selected = processed
                .flatMap(c => c.methods)
                .find(m => m.id === this.selectedMethodId);

            if (selected) {
                this.selectedFee = selected.fee;
            } else if (processed[0]?.methods[0]) {
                this.selectedMethodId = processed[0].methods[0].id;
                this.selectedFee = processed[0].methods[0].fee;
            }
        },

        toggleCategory(index) {
            this.categories.forEach((c, i) => c.expanded = i === index);
        },

        selectMethod(catIndex, method) {
            this.categories[catIndex].expanded = true;
            this.selectedMethodId = method.id;
            this.selectedFee = method.fee;
        },

        async submitChange() {
            if (!this.selectedMethodId) {
                showToast('warning', 'Pilih Pembayaran', {
                    description: 'Silakan pilih metode pembayaran terlebih dahulu.',
                    withButton: true,
                });
                return;
            }

            this.submitting = true;

            try {
                const fd = new FormData();
                fd.append('_token', config_csrf(this));
                fd.append('payment_gateway_method_id', this.selectedMethodId);

                const res = await fetch(config_changePaymentUrl(this), {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: fd,
                });

                const data = await res.json();

                if (data.success || data.redirect_url || data.status === 'success') {
                    showToast('success', 'Berhasil!', {
                        description: data.message || 'Metode pembayaran berhasil diubah.',
                        duration: 1500,
                    });

                    setTimeout(() => {
                        window.location.href = data.redirect_url || data.url || window.location.href;
                    }, 1500);
                } else {
                    showToast('error', 'Gagal', {
                        description: data.message || 'Gagal mengubah metode pembayaran.',
                        withButton: true,
                    });
                    this.submitting = false;
                }
            } catch (e) {
                console.error(e);
                showToast('error', 'Kesalahan Sistem', {
                    description: 'Terjadi kesalahan saat memproses data.',
                    withButton: true,
                });
                this.submitting = false;
            }
        },

        /* ---------- ICON ---------- */
        loadPaymentMethodIcon() {
            const icon = document.getElementById('payment-method-icon');
            if (!icon) return;

            const iconUrl = @json($transaction->paymentGatewayMethod?->method?->icon_url);
            svgToDataUri(iconUrl).then(src => {
                if (src) icon.src = src;
            });
        },
    }));

});


/* Helper: ambil config dari Alpine component instance (karena tidak bisa akses langsung) */
function config_checkStatusUrl(component) {
    return component.$el.getAttribute('data-check-status-url')
        || @json(route('transaction.check-status', $transaction->transaction_code));
}
function config_paymentMethodsUrl(component) {
    return @json(route('transaction.payment-methods', $transaction->transaction_code));
}
function config_changePaymentUrl(component) {
    return @json(route('transaction.change-payment', $transaction->transaction_code));
}
function config_csrf(component) {
    return @json(csrf_token());
}
</script>
@endpush


{{-- Custom style untuk x-cloak & body lock --}}
<style>
[x-cloak] { display: none !important; }
body.modal-open { overflow: hidden; }
</style>