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

.va-number-box {
    background: #FFFFFF;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 12px 18px;
    display: inline-flex;
    align-items: center;
    gap: 16px;
    margin-top: 10px;
}
.va-number { font-size: 22px; font-weight: 800; letter-spacing: 1px; color: var(--primary); }

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
    /* box-shadow:0 10px 25px rgba(0,102,255,.25); */
    transition:.25s ease;
}

.btn-open-app:hover{
    transform:translateY(-2px);
    /* box-shadow:0 16px 35px rgba(0,102,255,.35); */
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

@php
    $payload = is_array($transaction->payment_payload)
        ? $transaction->payment_payload
        : json_decode($transaction->payment_payload ?? '{}', true);

    $channelCode = $payload['channel_code'] ?? null;

    $qrValue = null;
    $vaNumber = null;
    $deeplinkUrl = null;

    foreach ($payload['actions'] ?? [] as $action) {

        switch ($action['type'] ?? '') {

            case 'PRESENT_TO_CUSTOMER':

                if ($channelCode === 'QRIS') {
                    $qrValue = $action['value'] ?? null;
                }

                if (str_contains($channelCode ?? '', 'VIRTUAL_ACCOUNT')) {
                    $vaNumber = $action['value'] ?? null;
                }

                break;

            case 'DEEPLINK':
            case 'MOBILE_PAYMENT':
            case 'REDIRECT_CUSTOMER':

                $deeplinkUrl = $action['value'] ?? null;

                break;
        }
    }

    // fallback jika Xendit mengirim field account_number
    $vaNumber ??= $payload['account_number'] ?? null;
@endphp

<div class="bg-eventconnect header-hight"></div>

<section class="checkout-section pt-4 pb-5">
    <div class="container">

        <!-- Hero Header -->
        <div class="checkout-hero">
            <div class="checkout-title-box">
                <i class="ti ti-credit-card"></i>
                <span>Selesaikan Pembayaran</span>
            </div>
        </div>

        <!-- Progress Step Bar -->
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
            <!-- Left Side: Main Payment Area -->
            <div class="col-lg-7">
                <div class="checkout-card mb-4">
                    <div class="checkout-card-body">

                        <!-- Header Info Kode & Metode -->
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Kode Transaksi</small>
                                <strong class="text-dark">{{ $transaction->transaction_code }}</strong>
                            </div>
                            {{-- <div class="payment-method-badge">
                                <i class="ti ti-wallet"></i>
                                <span>{{ $transaction->paymentGatewayMethod->name ?? 'Payment Gateway' }}</span>
                            </div> --}}
                        </div>

                        <!-- 2. Dynamic Display Based on Payment Type -->
                        <div class="payment-display-area">
                            @if($qrValue)
                                <h6 class="fw-bold mb-2">Scan QRIS untuk Membayar</h6>
                                {{-- <p class="text-muted small mb-3">Gunakan GoPay, OVO, Dana, ShopeePay, BCA, atau M-Banking Anda</p> --}}
                                
                                <div class="my-3">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($qrValue) }}" 
                                         alt="QRIS Payment Code" 
                                         class="qr-code-img">
                                </div>
                                <span class="badge badge-light text-dark border"><i class="ti ti-qrcode me-1"></i> Verifikasi Otomatis</span>

                            @elseif($vaNumber)
                                <h6 class="fw-bold mb-1">Nomor Virtual Account</h6>
                                {{-- <p class="text-muted small mb-3">Transfer sesuai nominal ke nomor rekening di bawah ini:</p> --}}
                                
                                <div class="va-number-box">
                                    <span class="va-number" id="vaText">{{ $vaNumber }}</span>
                                    <button class="copy-btn" onclick="copyToClipboard('{{ $vaNumber }}')">
                                        <i class="ti ti-copy"></i> Salin
                                    </button>
                                </div>


                            @elseif($deeplinkUrl)
                                <h6 class="fw-bold mb-2">Pembayaran E-Wallet</h6>
                                {{-- <p class="text-muted small mb-3">Klik tombol di bawah untuk membuka aplikasi pembayaran Anda:</p> --}}
                                
                                <a href="{{ $deeplinkUrl }}"
                                target="_blank"
                                class="btn-open-app">
                                    <span class="btn-open-app-left">
                                        {{-- <i class="ti ti-brand-google-play"></i> --}}
                                        <span>
                                            <small>Continue Payment</small>
                                            
                                            <strong>Open {{ strtoupper($transaction->paymentGatewayMethod?->method?->name) }}</strong>
                                        </span>
                                    </span>

                                    <i class="ti ti-arrow-up-right"></i>
                                </a>

                            @else
                                <div class="py-3">
                                    <i class="ti ti-info-circle text-primary fs-1 mb-2"></i>
                                    <h6 class="font-weight-bold">Instruksi Pembayaran</h6>
                                    {{-- <p class="text-muted small">Silakan selesaikan pembayaran sesuai petunjuk pada layanan pembayaran yang dipilih.</p> --}}
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

                        <!-- Total Tagihan -->
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted font-weight-bold">Total Pembayaran</span>
                                <span class="h4 font-weight-bold text-primary mb-0">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- 1. Countdown Box -->
                        <div class="timer-box">
                            <div class="timer-title">Batas Waktu Pembayaran</div>
                            <div class="timer-countdown" id="countdown-timer">00:00:00</div>
                            <small class="text-muted d-block mt-1">Selesaikan sebelum <strong id="expire-time-formatted">{{ \Carbon\Carbon::parse($transaction->expired_at)->format('d M Y, H:i') }} WIB</strong></small>
                        </div>

                        <!-- 3. Action Buttons -->
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

            <!-- Right Side: Order Summary -->
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

<!-- ========================================================= -->
<!-- MODAL GANTI PEMBAYARAN (BOOTSTRAP 4.6 COMPATIBLE) -->
<!-- ========================================================= -->
<div class="modal fade" id="checkoutConfirmModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-lg border-0 shadow-lg">
            
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title font-weight-bold text-dark d-flex align-items-center gap-2">
                    <i class="ti ti-wallet text-primary me-2"></i> Ganti Metode Pembayaran
                </h5>
                <!-- Bootstrap 4 Close Button -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                
                <!-- CARD PILIH METODE PEMBAYARAN -->
                <div class="payment-section-card">
                    <div class="payment-section-title">
                        <i class="ti ti-credit-card text-primary me-1"></i> Pilih Metode Pembayaran
                    </div>

                    <!-- Loading State -->
                    <div id="payment-methods-loading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Memuat...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Memuat metode pembayaran...</p>
                    </div>

                    <!-- Accordion Wrapper -->
                    <div id="paymentCategoriesAccordion" class="payment-accordion-wrapper d-none">
                        <!-- Render via JS -->
                    </div>
                </div>

                <!-- Summary & Total -->
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
                <!-- Bootstrap 4 Modal Dismiss -->
                <button type="button" class="btn btn-light font-weight-bold px-4" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary font-weight-bold px-4" id="btnSubmitCheckout" onclick="submitChangePayment()">
                    <span>Konfirmasi Perubahan</span>
                    <i class="ti ti-arrow-right ms-1"></i>
                </button>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // Countdown Timer
    const expiredAtTime = new Date("{{ \Carbon\Carbon::parse($transaction->expired_at)->toIso8601String() }}").getTime();
    const timerElement = document.getElementById("countdown-timer");

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = expiredAtTime - now;

        if (distance < 0) {
            clearInterval(timerInterval);
            if (timerElement) {
                timerElement.innerHTML = "EXPIRED";
                timerElement.classList.add("text-danger");
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Waktu Pembayaran Habis',
                text: 'Transaksi ini telah kadaluwarsa. Silakan lakukan pemesanan ulang.',
                confirmButtonText: 'Pesan Lagi'
            }).then(() => {
                window.location.reload();
            });
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const hDisplay = hours < 10 ? "0" + hours : hours;
        const mDisplay = minutes < 10 ? "0" + minutes : minutes;
        const sDisplay = seconds < 10 ? "0" + seconds : seconds;

        if (timerElement) {
            timerElement.innerHTML = `${hDisplay}:${mDisplay}:${sDisplay}`;
        }
    }

    updateCountdown();
    const timerInterval = setInterval(updateCountdown, 1000);

    // Polling Status Transaksi
    const checkStatusUrl = "{{ route('transaction.check-status', $transaction->transaction_code) }}";

    window.checkPaymentStatus = function(isManual = false) {
        const refreshIcon = document.getElementById("refresh-icon");
        if (refreshIcon) refreshIcon.classList.add("spin-animation");

        fetch(checkStatusUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (refreshIcon) refreshIcon.classList.remove("spin-animation");

            if (data.status === 'paid' || data.status === 'Paid') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil!',
                    text: 'Terima kasih, pembayaran Anda telah kami terima.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect_url || data.url || window.location.href;
                });
            } else if (data.status === 'expired' || data.status === 'failed') {
                Swal.fire({
                    icon: 'error',
                    title: 'Transaksi Gagal / Kadaluwarsa',
                    text: 'Status transaksi Anda sudah tidak berlaku lagi.'
                }).then(() => {
                    window.location.reload();
                });
            } else if (isManual) {
                Swal.fire({
                    icon: 'info',
                    title: 'Belum Diterima',
                    text: 'Pembayaran belum terdeteksi. Silakan selesaikan pembayaran Anda terlebih dahulu.',
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            if (refreshIcon) refreshIcon.classList.remove("spin-animation");
            console.error("Polling error:", error);
        });
    };

    setInterval(function() {
        checkPaymentStatus(false);
    }, 4000);

});

// =========================================================
// LOGIKA MODAL GANTI PEMBAYARAN (CARD ACCORDION METODE)
// =========================================================
const paymentMethodsUrl = "{{ route('transaction.payment-methods', $transaction->transaction_code) }}";
const changePaymentUrl = "{{ route('transaction.change-payment', $transaction->transaction_code) }}";

const PaymentCheckoutModal = {
    selectedPaymentMethodId: {{ $transaction->payment_gateway_method_id ?? 'null' }},
    selectedFee: {{ $transaction->payment_fee ?? 0 }},
    subtotal: {{ $transaction->subtotal ?? 0 }},
    platformFee: {{ $transaction->platform_fee ?? 0 }},

    formatRupiah(num) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(Number(num || 0));
    },

    recalculateTotal(paymentFee = 0) {
        const grandTotal = this.subtotal + this.platformFee + paymentFee;
        
        const elemFee = document.getElementById('modalPaymentFee');
        if (elemFee) {
            elemFee.innerText = this.formatRupiah(paymentFee);
        }

        const elemTotal = document.getElementById('modalGrandTotal');
        if (elemTotal) {
            elemTotal.innerText = this.formatRupiah(grandTotal);
        }
    },

    async renderPaymentCategories(categories) {
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
                            feeDisplay = `+${method.fee_value}% (${this.formatRupiah(feeCalculated)})`;
                        } else if (method.fee_type === 'fixed' && Number(method.fee_value) > 0) {
                            feeCalculated = Number(method.fee_value);
                            feeDisplay = `+${this.formatRupiah(feeCalculated)}`;
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
                            </div>
                        `;
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
                    </div>
                `;
            }
        }

        const accordionEl = document.getElementById('paymentCategoriesAccordion');
        accordionEl.innerHTML = categoriesHtml;

        this.recalculateTotal(this.selectedFee);

        // Accordion click toggle
        document.querySelectorAll('.payment-category-header').forEach(header => {
            header.addEventListener('click', function() {
                const card = this.closest('.payment-category-card');
                document.querySelectorAll('.payment-category-card').forEach(c => {
                    if (c !== card) c.classList.remove('is-active');
                });
                card.classList.toggle('is-active');
            });
        });

        // Payment option selection
        const self = this;
        document.querySelectorAll('.payment-option-card').forEach(option => {
            option.addEventListener('click', function(e) {
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

async function getSvgDataUri(url) {
    if (!url) return '';
    if (url.match(/\.(png|jpg|jpeg|webp)$/i)) return url;

    try {
        const response = await fetch(url);
        if (!response.ok) return url;
        let svgText = await response.text();
        svgText = svgText.replace(/<script[\s\S]*?<\/script>/gi, '');
        if (!svgText.includes('xmlns=')) {
            svgText = svgText.replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"');
        }
        const base64 = btoa(unescape(encodeURIComponent(svgText)));
        return `data:image/svg+xml;base64,${base64}`;
    } catch (e) {
        return url;
    }
}

// Buka Modal dengan Syntax jQuery (Bootstrap 4)
function openChangePaymentModal() {
    if (typeof $ !== 'undefined') {
        $('#checkoutConfirmModal').modal('show');
    } else {
        document.getElementById('checkoutConfirmModal').classList.add('show');
        document.getElementById('checkoutConfirmModal').style.display = 'block';
    }

    const loadingEl = document.getElementById('payment-methods-loading');
    const accordionEl = document.getElementById('paymentCategoriesAccordion');

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
    .catch(err => {
        loadingEl.classList.add('d-none');
        accordionEl.classList.remove('d-none');
        accordionEl.innerHTML = `<p class="text-center text-danger small py-3">Gagal memuat metode pembayaran.</p>`;
    });
}

function submitChangePayment() {
    if (!PaymentCheckoutModal.selectedPaymentMethodId) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Pembayaran',
            text: 'Silakan pilih metode pembayaran terlebih dahulu.'
        });
        return;
    }

    const submitBtn = document.getElementById('btnSubmitCheckout');
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<i class="ti ti-loader-2 spin-animation me-1"></i> Memproses...`;

    const formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('payment_gateway_method_id', PaymentCheckoutModal.selectedPaymentMethodId);

    fetch(changePaymentUrl, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<span>Konfirmasi Perubahan</span> <i class="ti ti-arrow-right ms-1"></i>`;

        if (response.success || response.redirect_url || response.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.message || 'Metode pembayaran berhasil diubah.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = response.redirect_url || response.url || window.location.href;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message || 'Gagal mengubah metode pembayaran.'
            });
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<span>Konfirmasi Perubahan</span> <i class="ti ti-arrow-right ms-1"></i>`;

        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: 'Terjadi kesalahan saat memproses data. Silakan coba lagi.'
        });
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Nomor VA berhasil disalin',
            showConfirmButton: false,
            timer: 2000
        });
    });
}

document.addEventListener('DOMContentLoaded', async function () {
    const icon = document.getElementById('payment-method-icon');

    if (icon) {
        icon.src = await getSvgDataUri(@json($transaction->paymentGatewayMethod->method->icon_url));
    }
});
</script>

@endsection