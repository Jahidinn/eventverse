@extends('layouts.main')

<style>
/* ===========================================================
   EVENTCONNECT CHECKOUT PAGE & PAYMENT MODAL THEME (BS4)
   =========================================================== */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --primary: #0066FF;
    --primary-hover: #0052CC;
    --primary-light: #F0F6FF;
    --primary-border: #C2DCFF;
    --success: #10B981;
    --danger: #EF4444;
    --warning: #F59E0B;
    --bg: #F8FAFC;
    --card: #FFFFFF;
    --text: #0F172A;
    --muted: #64748B;
    --border: #E2E8F0;
    --radius-sm: 10px;
    --radius-md: 14px;
    --radius-lg: 20px;
}

.checkout-section,
.checkout-section * {
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
    box-sizing: border-box !important;
}

.checkout-section {
    background: var(--bg) !important;
    min-height: 100vh;
}

.checkout-hero { text-align: center !important; margin-bottom: 24px !important; }
.checkout-title-box {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 7px 22px;
    border-radius: 999px;
    background: var(--primary-light);
    border: 1px solid var(--primary-border);
    color: var(--primary);
    font-size: 18px;
    font-weight: 800;
}

.checkout-progress {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 12px !important;
    margin-bottom: 32px !important;
}

.progress-step { display: flex !important; align-items: center !important; gap: 8px !important; font-size: 13px !important; font-weight: 600 !important; color: var(--muted) !important; }
.progress-circle { width: 36px !important; height: 36px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; font-size: 13px !important; }
.progress-done { background: #DCFCE7 !important; color: var(--success) !important; }
.progress-active { background: var(--primary) !important; color: #FFF !important; box-shadow: 0 4px 12px rgba(0,102,255,.25) !important; }
.progress-wait { background: #E2E8F0 !important; color: #94A3B8 !important; }
.progress-line { width: 45px !important; height: 2px !important; background: #E2E8F0 !important; }

.checkout-card {
    background: var(--card) !important;
    border: 1px solid var(--border) !important;
    border-radius: var(--radius-lg) !important;
    overflow: hidden !important;
    box-shadow: 0 10px 25px -5px rgba(15,23,42,.04) !important;
}
.checkout-card-body { padding: 28px !important; }

/* TIMER & PAYMENT DISPLAY AREA */
.timer-box {
    background: #FFFBEB;
    border: 1px solid #FDE68A;
    border-radius: var(--radius-md);
    padding: 16px;
    text-align: center;
    margin-bottom: 24px;
}
.timer-title { font-size: 12px; font-weight: 700; color: #B45309; text-transform: uppercase; letter-spacing: 0.5px; }
.timer-countdown { font-size: 26px; font-weight: 800; color: #D97706; margin-top: 2px; }

.payment-method-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    background: #F1F5F9;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
}

.payment-display-area {
    background: #F8FAFC;
    border: 1.5px dashed var(--border);
    border-radius: var(--radius-md);
    padding: 24px;
    text-align: center;
    margin: 20px 0;
}

.qr-code-img {
    width: 220px;
    height: 220px;
    border-radius: 12px;
    border: 1px solid var(--border);
    padding: 8px;
    background: #FFF;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

/* Update pada .va-number-box agar fleksibel di layar kecil */
.va-number-box {
    background: #FFFFFF;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 12px 18px;
    display: inline-flex;
    align-items: center;
    gap: 16px;
    margin-top: 10px;
    max-width: 100%; /* Memastikan tidak melebihi container utama */
    box-sizing: border-box;
}

/* Update pada .va-number agar nomor VA ter-wrap/mengecil saat di mobile */
.va-number { 
    font-size: 17px; 
    font-weight: 800; 
    letter-spacing: 1px; 
    color: var(--primary);
    word-break: break-all; /* Mencegah teks melimpah keluar container */
    overflow-wrap: anywhere;
}

/* Tambahkan penyesuaian khusus tampilan Mobile (max-width: 768px) */
@media (max-width: 768px) {
    .progress-step span{ display:none!important; }
    .progress-line{ width:20px!important; }
    .checkout-card-body{ padding:18px!important; }
    .action-buttons { flex-direction: column; }
    .checkout-progress{ display: none !important; }

    /* Perbaikan tampilan VA di layar HP */
    .va-number-box {
        flex-direction: column; /* Menumpuk nomor VA & tombol Salin secara vertikal */
        gap: 10px;
        padding: 12px;
        width: 100%;
    }

    .va-number {
        font-size: 16px; /* Mengecilkan sedikit ukuran font di HP */
        letter-spacing: 0.5px;
        text-align: center;
    }

    .copy-btn {
        width: 100%; /* Tombol salin menjadi full-width di HP agar mudah ditekan */
    }
}

.copy-btn {
    background: var(--primary-light);
    color: var(--primary);
    border: 1px solid var(--primary-border);
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.copy-btn:hover { background: var(--primary); color: #FFF; }

.action-buttons {
    display: flex;
    gap: 12px;
    margin-top: 24px;
}

.btn-refresh {
    flex: 1;
    height: 46px;
    border: 1.5px solid var(--border);
    background: #FFF;
    color: var(--text);
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-refresh:hover { background: #F1F5F9; }

.btn-change-payment {
    flex: 1;
    height: 46px;
    border: 1.5px solid var(--primary-border);
    background: var(--primary-light);
    color: var(--primary);
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-change-payment:hover { background: var(--primary); color: #FFF; }

.summary-item {
    display: flex;
    justify-content: space-between;
    font-size: 13.5px;
    color: var(--muted);
    margin-bottom: 10px;
}
.summary-item.total {
    border-top: 1px dashed var(--border);
    padding-top: 12px;
    margin-top: 12px;
    font-weight: 800;
    color: var(--text);
    font-size: 16px;
}

/* ===========================================================
   CARD ACCORDION METODE PEMBAYARAN CHECKOUT
   =========================================================== */
.payment-section-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 20px;
}

.payment-section-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.payment-accordion-wrapper {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.payment-category-card {
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
    background: #fff;
    transition: all 0.2s ease;
}

.payment-category-card.is-active {
    border-color: var(--primary-border);
    box-shadow: 0 4px 12px rgba(0, 102, 255, 0.05);
}

.payment-category-header {
    padding: 14px 16px;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
    transition: background 0.2s;
}

.payment-category-header:hover {
    background: #F8FAFC;
}

.payment-category-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
}

.accordion-chevron {
    font-size: 14px;
    color: var(--muted);
    transition: transform 0.3s ease;
}

.payment-category-card.is-active .accordion-chevron {
    transform: rotate(180deg);
    color: var(--primary);
}

.payment-category-body {
    display: none;
    padding: 12px 16px 16px 16px;
    border-top: 1px solid #F1F5F9;
    background: #FAFAFA;
}

.payment-category-card.is-active .payment-category-body {
    display: block;
}

.payment-methods-grid {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.payment-option-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
}

.payment-option-card:hover {
    border-color: var(--primary-border);
}

.payment-option-card.selected {
    border-color: var(--primary);
    background: var(--primary-light);
    box-shadow: 0 0 0 1px var(--primary);
}

.payment-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.payment-logo-img {
    width: 48px;
    height: 26px;
    object-fit: contain;
}

.payment-name-text {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text);
}

.payment-fee-text {
    font-size: 12px;
    font-weight: 700;
    color: var(--primary);
}

.spin-animation {
    animation: spin 1s linear infinite;
}

.btn-open-app{
    display:flex;
    align-items:center;
    justify-content:space-between;
    width:100%;
    padding:16px 20px;
    border-radius:16px;
    background:linear-gradient(135deg,#d4dce7,#dee7f6);
    color:#1e264d !important;
    text-decoration:none !important;
    transition:.25s ease;
}

.btn-open-app:hover{
    transform:translateY(-2px);
    color:#1e264d !important;
}

.btn-open-app-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.btn-open-app-left i{
    width:48px;
    height:48px;
    border-radius:14px;
    background:rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.btn-open-app-left small{
    display:block;
    color:#1e264d;
    font-size:12px;
    margin-bottom:2px;
}

.btn-open-app-left strong{
    display:block;
    font-size:16px;
    font-weight:700;
    color:#1e264d;
}

.btn-open-app > i{
    font-size:22px;
    opacity:.9;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .progress-step span{ display:none!important; }
    .progress-line{ width:20px!important; }
    .checkout-card-body{ padding:18px!important; }
    .action-buttons { flex-direction: column; }

    .checkout-progress{
        display: none !important;
    }
}
</style>

@section('content')

<div class="bg-eventconnect header-hight"></div>

<section class="checkout-section pt-4 pb-5">
    <div class="container">

        <div class="checkout-hero">
            <div class="checkout-title-box">
                <i class="ti ti-credit-card"></i>
                <span>Selesaikan Pembayaran</span>
            </div>
        </div>

        <div class="checkout-progress">
            <div class="progress-step">
                <div class="progress-circle progress-done"><i class="ti ti-check"></i></div>
                <span>Pilih Tiket</span>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="progress-circle progress-done"><i class="ti ti-check"></i></div>
                <span>Data Peserta</span>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="progress-circle progress-active">3</div>
                <span>Pembayaran</span>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="progress-circle progress-wait">4</div>
                <span>Tiket</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="checkout-card mb-4">
                    <div class="checkout-card-body">

                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Kode Transaksi</small>
                                <strong class="text-dark">{{ $transaction->transaction_code }}</strong>
                            </div>
                        </div>

                        <div class="payment-display-area">

                            {{-- QRIS --}}
                            @if(!empty($paymentDisplay['qr_value']))

                                <h6 class="fw-bold mb-2">
                                    Scan QRIS untuk Membayar
                                </h6>

                                <div class="my-3">
                                    <img
                                        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($paymentDisplay['qr_value']) }}"
                                        alt="QRIS Payment Code"
                                        class="qr-code-img"
                                    >
                                </div>

                                <span class="badge badge-light text-dark border">
                                    <i class="ti ti-qrcode me-1"></i>
                                    Verifikasi Otomatis
                                </span>

                            {{-- VIRTUAL ACCOUNT --}}
                            {{-- VIRTUAL ACCOUNT --}}
                                @elseif(!empty($paymentDisplay['va_number']))

                                    <h6 class="fw-bold mb-1">
                                        Nomor Virtual Account
                                    </h6>

                                    <div class="va-number-box">

                                        <span
                                            class="va-number"
                                            id="vaText"
                                        >
                                            {{ $paymentDisplay['va_number'] }}
                                        </span>

                                        <button
                                            type="button"
                                            class="copy-btn"
                                            data-va="{{ $paymentDisplay['va_number'] }}"
                                            onclick="copyToClipboard(this.dataset.va)"
                                        >
                                            <i class="ti ti-copy"></i>
                                            Salin
                                        </button>

                                    </div>

                            {{-- E-WALLET --}}
                            @elseif(!empty($paymentDisplay['deeplink_url']))

                                <h6 class="fw-bold mb-2">
                                    Pembayaran E-Wallet
                                </h6>

                                <a
                                    href="{{ $paymentDisplay['deeplink_url'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-open-app"
                                >
                                    <span class="btn-open-app-left">
                                        <span>
                                            <small>Continue Payment</small>
                                            <strong>
                                                Open {{ strtoupper($transaction->paymentGatewayMethod?->method?->name ?? 'E-Wallet') }}
                                            </strong>
                                        </span>
                                    </span>

                                    <i class="ti ti-arrow-up-right"></i>
                                </a>

                            {{-- DEFAULT --}}
                            @else

                                <div class="py-3">
                                    <i class="ti ti-info-circle text-primary fs-1 mb-2"></i>
                                    <h6 class="font-weight-bold">
                                        Instruksi Pembayaran
                                    </h6>
                                </div>

                            @endif

                        </div>

                        <div class="payment-option-card mb-4 text-center">
                            <div class="payment-left">
                                @if($transaction->paymentGatewayMethod?->method?->icon)
                                    <img
                                        id="payment-method-icon"
                                        class="payment-logo-img"
                                        alt="{{ $transaction->paymentGatewayMethod->method->name }}">
                                @endif

                                <span class="payment-name-text">
                                    {{ $transaction->paymentGatewayMethod?->method?->name }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted font-weight-bold">Total Pembayaran</span>
                                <span class="h4 font-weight-bold text-primary mb-0">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="timer-box">
                            <div class="timer-title">Batas Waktu Pembayaran</div>
                            <div class="timer-countdown" id="countdown-timer">00:00:00</div>
                            <small class="text-muted d-block mt-1">Selesaikan sebelum <strong id="expire-time-formatted">{{ \Carbon\Carbon::parse($transaction->expired_at)->format('d M Y, H:i') }} WIB</strong></small>
                        </div>

                        <div class="action-buttons">
                            <button class="btn-refresh py-2" id="btn-manual-refresh" onclick="checkPaymentStatus(true)">
                                <i class="ti ti-refresh" id="refresh-icon"></i> Cek Status
                            </button>

                            <button class="btn-change-payment py-2" onclick="openChangePaymentModal()">
                                <i class="ti ti-arrows-left-right"></i> Ganti Pembayaran
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-card">
                    <div class="checkout-card-body">
                        <h6 class="font-weight-bold mb-3 text-dark"><i class="ti ti-receipt me-1"></i> Ringkasan Pesanan</h6>
                        
                        <div class="summary-item">
                            <span>Event</span>
                            <strong class="text-dark">{{ $transaction->event->title ?? 'Nama Event' }}</strong>
                        </div>
                        <div class="summary-item">
                            <span>Jenis Tiket</span>
                            <strong class="text-dark">{{ $transaction->ticket->name ?? 'Tiket' }}</strong>
                        </div>
                        <div class="summary-item">
                            <span>Jumlah Tiket</span>
                            <strong class="text-dark">{{ $transaction->quantity }}x</strong>
                        </div>
                        <div class="summary-item">
                            <span>Pembeli</span>
                            <strong class="text-dark">{{ $transaction->buyer_name }}</strong>
                        </div>

                        <hr class="my-3">

                        <div class="summary-item">
                            <span>Subtotal Tiket</span>
                            <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Biaya Platform</span>
                            <span>Rp {{ number_format($transaction->platform_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Biaya Pembayaran</span>
                            <span>Rp {{ number_format($transaction->payment_fee, 0, ',', '.') }}</span>
                        </div>

                        <div class="summary-item total">
                            <span>Grand Total</span>
                            <span class="text-primary">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<div class="modal fade" id="checkoutConfirmModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-lg border-0 shadow-lg">
            
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title font-weight-bold text-dark d-flex align-items-center gap-2">
                    <i class="ti ti-wallet text-primary me-2"></i> Ganti Metode Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                
                <div class="payment-section-card">
                    <div class="payment-section-title">
                        <i class="ti ti-credit-card text-primary me-1"></i> Pilih Metode Pembayaran
                    </div>

                    <div id="payment-methods-loading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Memuat...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Memuat metode pembayaran...</p>
                    </div>

                    <div id="paymentCategoriesAccordion" class="payment-accordion-wrapper d-none">
                        </div>
                </div>

                <div class="bg-light p-3 rounded mt-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small font-weight-bold">Biaya Penanganan</span>
                        <span class="font-weight-bold text-dark" id="modalPaymentFee">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="text-dark font-weight-bold">Total Pembayaran Baru</span>
                        <span class="h5 font-weight-bold text-primary mb-0" id="modalGrandTotal">Rp 0</span>
                    </div>
                </div>

            </div>

            <div class="modal-footer border-top px-4 py-3">
                <button type="button" class="btn btn-light font-weight-bold px-4" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary font-weight-bold px-4" id="btnSubmitCheckout" onclick="submitChangePayment()">
                    <span>Konfirmasi Perubahan</span>
                    <i class="ti ti-arrow-right ms-1"></i>
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/*
|--------------------------------------------------------------------------
| CONFIG & GLOBAL VARS
|--------------------------------------------------------------------------
*/
const expiredAt = new Date(@json(\Carbon\Carbon::parse($transaction->expired_at)->toIso8601String()));
const expireReservationUrl = @json(route('reservation.expire', ['reservationCode' => $transaction->reservation->reservation_code]));
const eventUrl = @json(url($transaction->event->slug));
const checkStatusUrl = @json(route('transaction.check-status', $transaction->transaction_code));
const paymentMethodsUrl = @json(route('transaction.payment-methods', $transaction->transaction_code));
const changePaymentUrl = @json(route('transaction.change-payment', $transaction->transaction_code));
const csrfToken = @json(csrf_token());

let reservationExpired = false;
let timerInterval = null;
let statusInterval = null;
let expireRequestRunning = false;

/*
|--------------------------------------------------------------------------
| HELPER: COPY TO CLIPBOARD
|--------------------------------------------------------------------------
*/
function copyToClipboard(text) {
    if (!text) return;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function () {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nomor VA berhasil disalin',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                alert('Nomor VA berhasil disalin!');
            }
        }).catch(function(err) {
            fallbackCopyTextToClipboard(text);
        });
    } else {
        fallbackCopyTextToClipboard(text);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Nomor VA berhasil disalin',
                showConfirmButton: false,
                timer: 2000
            });
        }
    } catch (err) {
        console.error('Fallback copy failed', err);
    }
    document.body.removeChild(textArea);
}

/*
|--------------------------------------------------------------------------
| REDIRECT & EXPIRE RESERVATION
|--------------------------------------------------------------------------
*/
function redirectToEvent() {
    window.location.href = eventUrl;
}

async function expireReservation() {
    if (expireRequestRunning) return;
    expireRequestRunning = true;

    try {
        const response = await fetch(expireReservationUrl, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        });

        const data = await response.json();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Waktu Habis',
                text: 'Waktu reservasi Anda telah berakhir.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                redirectToEvent();
            });
        } else {
            redirectToEvent();
        }

    } catch (error) {
        console.error('Expire reservation error:', error);
        expireRequestRunning = false;
    }
}

function handleExpired() {
    if (reservationExpired) return;
    reservationExpired = true;

    if (timerInterval) clearInterval(timerInterval);
    if (statusInterval) clearInterval(statusInterval);

    const timerElement = document.getElementById('countdown-timer');
    if (timerElement) {
        timerElement.innerHTML = 'EXPIRED';
        timerElement.classList.add('text-danger');
    }

    expireReservation();
}

function updateCountdown() {
    if (reservationExpired) return;

    const now = new Date();
    const diff = expiredAt.getTime() - now.getTime();

    if (diff <= 0) {
        handleExpired();
        return;
    }

    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

    const timerElement = document.getElementById('countdown-timer');
    if (timerElement) {
        timerElement.innerHTML = 
            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }
}

/*
|--------------------------------------------------------------------------
| CHECK PAYMENT STATUS
|--------------------------------------------------------------------------
*/
async function checkPaymentStatus(isManual = false) {
    if (reservationExpired) return;

    const refreshIcon = document.getElementById('refresh-icon');
    if (refreshIcon) refreshIcon.classList.add('spin-animation');

    try {
        const response = await fetch(checkStatusUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            cache: 'no-store'
        });

        const data = await response.json();

        if (data.status === 'paid' || data.status === 'Paid') {
            if (statusInterval) clearInterval(statusInterval);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil!',
                    text: 'Pembayaran Anda telah diterima.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function () {
                    window.location.href = data.redirect_url || data.url || window.location.href;
                });
            } else {
                window.location.href = data.redirect_url || data.url || window.location.href;
            }
            return;
        }

        if (data.status === 'expired' || data.status === 'failed') {
            handleExpired();
            return;
        }

        if (isManual) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'Belum Diterima',
                    text: 'Pembayaran belum terdeteksi. Silakan selesaikan pembayaran terlebih dahulu.',
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        }

    } catch (error) {
        console.error('Payment status error:', error);
    } finally {
        if (refreshIcon) refreshIcon.classList.remove('spin-animation');
    }
}

/*
|--------------------------------------------------------------------------
| PAYMENT CHECKOUT MODAL OBJECT
|--------------------------------------------------------------------------
*/
const PaymentCheckoutModal = {
    selectedPaymentMethodId: @json($transaction->payment_gateway_method_id),
    selectedFee: @json($transaction->payment_fee ?? 0),
    subtotal: @json($transaction->subtotal ?? 0),
    platformFee: @json($transaction->platform_fee ?? 0),

    formatRupiah: function (num) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(Number(num || 0));
    },

    recalculateTotal: function (paymentFee = 0) {
        const grandTotal = Number(this.subtotal || 0) + Number(this.platformFee || 0) + Number(paymentFee || 0);

        const elemFee = document.getElementById('modalPaymentFee');
        if (elemFee) elemFee.innerText = this.formatRupiah(paymentFee);

        const elemTotal = document.getElementById('modalGrandTotal');
        if (elemTotal) elemTotal.innerText = this.formatRupiah(grandTotal);
    },

    renderPaymentCategories: async function (categories) {
        let categoriesHtml = '';

        if (categories && categories.length > 0) {
            for (let index = 0; index < categories.length; index++) {
                const cat = categories[index];
                const isActive = index === 0 ? 'is-active' : '';
                let methodsHtml = '';

                if (cat.methods && cat.methods.length > 0) {
                    for (let mIdx = 0; mIdx < cat.methods.length; mIdx++) {
                        const method = cat.methods[mIdx];
                        const methodIconSrc = await getSvgDataUri(method.icon);

                        let feeCalculated = 0;
                        let feeDisplay = 'Bebas Biaya';

                        if (method.fee_type === 'percent') {
                            feeCalculated = (this.subtotal * Number(method.fee_value)) / 100;
                            feeDisplay = '+' + method.fee_value + '% (' + this.formatRupiah(feeCalculated) + ')';
                        } else if (method.fee_type === 'fixed' && Number(method.fee_value) > 0) {
                            feeCalculated = Number(method.fee_value);
                            feeDisplay = '+' + this.formatRupiah(feeCalculated);
                        }

                        let isSelected = false;
                        if (this.selectedPaymentMethodId && method.payment_gateway_method_id == this.selectedPaymentMethodId) {
                            isSelected = true;
                            this.selectedFee = feeCalculated;
                        } else if (!this.selectedPaymentMethodId && index === 0 && mIdx === 0) {
                            isSelected = true;
                            this.selectedPaymentMethodId = method.payment_gateway_method_id;
                            this.selectedFee = feeCalculated;
                        }

                        methodsHtml += `
                            <div class="payment-option-card ${isSelected ? 'selected' : ''}" 
                                 data-method-id="${method.payment_gateway_method_id}" 
                                 data-fee="${feeCalculated}">
                                <div class="payment-left">
                                    ${methodIconSrc ? `<img src="${methodIconSrc}" class="payment-logo-img" alt="${method.name}">` : ''}
                                    <span class="payment-name-text">${method.name}</span>
                                </div>
                                <span class="payment-fee-text">${feeDisplay}</span>
                            </div>`;
                    }
                } else {
                    methodsHtml = '<div class="text-muted text-center py-2" style="font-size: 11px;">Tidak ada metode aktif.</div>';
                }

                categoriesHtml += `
                    <div class="payment-category-card ${isActive}">
                        <div class="payment-category-header">
                            <div class="payment-category-title">
                                <span>${cat.name}</span>
                            </div>
                            <i class="ti ti-chevron-down accordion-chevron"></i>
                        </div>
                        <div class="payment-category-body">
                            <div class="payment-methods-grid">
                                ${methodsHtml}
                            </div>
                        </div>
                    </div>`;
            }
        }

        const accordionEl = document.getElementById('paymentCategoriesAccordion');
        if (!accordionEl) return;

        accordionEl.innerHTML = categoriesHtml;
        this.recalculateTotal(this.selectedFee);

        /* Bind Accordion Events */
        document.querySelectorAll('.payment-category-header').forEach(header => {
            header.addEventListener('click', function () {
                const card = this.closest('.payment-category-card');
                document.querySelectorAll('.payment-category-card').forEach(c => {
                    if (c !== card) c.classList.remove('is-active');
                });
                card.classList.toggle('is-active');
            });
        });

        /* Bind Method Selection Events */
        const self = this;
        document.querySelectorAll('.payment-option-card').forEach(option => {
            option.addEventListener('click', function (e) {
                e.stopPropagation();
                document.querySelectorAll('.payment-option-card').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');

                self.selectedPaymentMethodId = this.getAttribute('data-method-id');
                self.selectedFee = Number(this.getAttribute('data-fee') || 0);
                self.recalculateTotal(self.selectedFee);
            });
        });
    }
};

/*
|--------------------------------------------------------------------------
| SVG CONVERTER
|--------------------------------------------------------------------------
*/
async function getSvgDataUri(url) {
    if (!url) return '';
    if (/\.(png|jpg|jpeg|webp)$/i.test(url)) return url;

    try {
        const response = await fetch(url);
        if (!response.ok) return url;

        let svgText = await response.text();
        svgText = svgText.replace(/<script[\s\S]*?<\/script>/gi, '');
        if (!svgText.includes('xmlns=')) {
            svgText = svgText.replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"');
        }

        const base64 = btoa(unescape(encodeURIComponent(svgText)));
        return 'data:image/svg+xml;base64,' + base64;
    } catch (error) {
        console.error('SVG error:', error);
        return url;
    }
}

/*
|--------------------------------------------------------------------------
| OPEN CHANGE PAYMENT MODAL
|--------------------------------------------------------------------------
*/
function openChangePaymentModal() {
    if (typeof $ !== 'undefined' && $('#checkoutConfirmModal').length) {
        $('#checkoutConfirmModal').modal('show');
    } else {
        const modal = document.getElementById('checkoutConfirmModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'block';
        }
    }

    const loadingEl = document.getElementById('payment-methods-loading');
    const accordionEl = document.getElementById('paymentCategoriesAccordion');

    if (!loadingEl || !accordionEl) return;

    loadingEl.classList.remove('d-none');
    accordionEl.classList.add('d-none');

    fetch(paymentMethodsUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        loadingEl.classList.add('d-none');
        accordionEl.classList.remove('d-none');
        PaymentCheckoutModal.renderPaymentCategories(response.payment_categories || []);
    })
    .catch(error => {
        console.error(error);
        loadingEl.classList.add('d-none');
        accordionEl.classList.remove('d-none');
        accordionEl.innerHTML = '<p class="text-center text-danger small py-3">Gagal memuat metode pembayaran.</p>';
    });
}

/*
|--------------------------------------------------------------------------
| SUBMIT CHANGE PAYMENT
|--------------------------------------------------------------------------
*/
function submitChangePayment() {
    const modal = PaymentCheckoutModal;

    if (!modal.selectedPaymentMethodId) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Pembayaran',
                text: 'Silakan pilih metode pembayaran terlebih dahulu.'
            });
        } else {
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
        }
        return;
    }

    const submitBtn = document.getElementById('btnSubmitCheckout');
    if (!submitBtn) return;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="ti ti-loader-2 spin-animation me-1"></i> Memproses...';

    const formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('payment_gateway_method_id', modal.selectedPaymentMethodId);

    fetch(changePaymentUrl, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>Konfirmasi Perubahan</span><i class="ti ti-arrow-right ms-1"></i>';

        if (response.success || response.redirect_url || response.status === 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Metode pembayaran berhasil diubah.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function () {
                    window.location.href = response.redirect_url || response.url || window.location.href;
                });
            } else {
                window.location.href = response.redirect_url || response.url || window.location.href;
            }
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message || 'Gagal mengubah metode pembayaran.'
                });
            } else {
                alert(response.message || 'Gagal mengubah metode pembayaran.');
            }
        }
    })
    .catch(error => {
        console.error(error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>Konfirmasi Perubahan</span><i class="ti ti-arrow-right ms-1"></i>';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Sistem',
                text: 'Terjadi kesalahan saat memproses data. Silakan coba lagi.'
            });
        }
    });
}

/*
|--------------------------------------------------------------------------
| INITIALIZATION ON DOM READY
|--------------------------------------------------------------------------
*/
document.addEventListener('DOMContentLoaded', function () {
    // Start countdown
    timerInterval = setInterval(updateCountdown, 1000);
    updateCountdown();

    // Start status checking polling (every 4s)
    statusInterval = setInterval(function () {
        if (!reservationExpired) {
            checkPaymentStatus(false);
        }
    }, 4000);

    // Fetch logo icon payment method
    const icon = document.getElementById('payment-method-icon');
    if (icon) {
        const iconUrl = @json($transaction->paymentGatewayMethod?->method?->icon_url);
        getSvgDataUri(iconUrl).then(function (src) {
            if (src) icon.src = src;
        });
    }
});
</script>

@endsection