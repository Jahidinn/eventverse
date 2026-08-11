@extends('layouts.main')

<style>
/* ===========================================================
   EVENTCONNECT COMPLETE CHECKOUT THEME & OVERRIDES
   =========================================================== */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* Reset & Font Global */
.checkout-section, 
.checkout-section * {
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
    box-sizing: border-box !important;
}

:root {
    --primary: #0066FF;
    --primary-hover: #0052CC;
    --primary-light: #F0F6FF;
    --primary-border: #C2DCFF;
    --success: #10B981;
    --danger: #EF4444;
    --bg: #F8FAFC;
    --card: #FFFFFF;
    --text: #0F172A;
    --muted: #64748B;
    --border: #E2E8F0;
    --border-light: #F1F5F9;
    --radius-sm: 10px;
    --radius-md: 14px;
    --radius-lg: 20px;
}

.checkout-section {
    background: var(--bg) !important;
    min-height: 100vh;
}

/* 1. HERO TITLE & PROGRESS BAR */
.checkout-hero { text-align: center !important; margin-bottom: 24px !important; }
.checkout-title { font-size: 26px !important; font-weight: 800 !important; color: var(--text) !important; letter-spacing: -0.5px !important; }

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
.progress-active { background: var(--primary) !important; color: #FFFFFF !important; box-shadow: 0 4px 12px rgba(0,102,255,.25) !important; }
.progress-wait { background: #E2E8F0 !important; color: #94A3B8 !important; }
.progress-line { width: 45px !important; height: 2px !important; background: #E2E8F0 !important; }

/* 2. CARD WRAPPER */
.checkout-card {
    background: var(--card) !important;
    border: 1px solid var(--border) !important;
    border-radius: var(--radius-lg) !important;
    overflow: hidden !important;
    box-shadow: 0 10px 25px -5px rgba(15,23,42,.04) !important;
}
.checkout-card-body { padding: 26px !important; }
.checkout-section-title { font-size: 18px !important; font-weight: 800 !important; color: var(--text) !important; margin-bottom: 20px !important; }

/* 3. USER PROFILE CARD (PEMESAN) */
.checkout-user-card {
    display: flex !important;
    align-items: center !important;
    gap: 14px !important;
    padding: 14px 16px !important;
    margin-bottom: 22px !important;
    background: var(--primary-light) !important;
    border: 1px solid var(--primary-border) !important;
    border-radius: var(--radius-md) !important;
}
.user-avatar {
    width: 42px !important; height: 42px !important;
    border-radius: 50% !important; background: var(--primary) !important;
    color: #fff !important; display: flex !important; align-items: center !important;
    justify-content: center !important; font-weight: 700 !important; font-size: 15px !important;
}
.user-name { font-size: 14px !important; font-weight: 700 !important; color: var(--text) !important; }
.user-email { font-size: 12.5px !important; color: var(--muted) !important; margin-top: 1px !important; }

/* 4. FORM INPUTS & LABELS (MENG-OVERRIDE BOOTSTRAP) */
.form-group, .checkout-field { margin-bottom: 20px !important; }
.checkout-label {
    display: block !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #334155 !important;
    margin-bottom: 6px !important;
}

.checkout-input, 
.form-control.checkout-input {
    width: 100% !important;
    height: 46px !important;
    padding: 0 14px !important;
    border: 1.5px solid #CBD5E1 !important;
    border-radius: var(--radius-sm) !important;
    background: #FFFFFF !important;
    font-size: 13.5px !important;
    color: var(--text) !important;
    outline: none !important;
    box-shadow: none !important;
    transition: all 0.2s ease !important;
}
.checkout-input:focus, 
.form-control.checkout-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12) !important;
}
.checkout-input[readonly] {
    background-color: #F1F5F9 !important;
    color: #64748B !important;
}

.option-group{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:12px;
}

.option-card{
    position:relative;
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    border:1.5px solid var(--border);
    border-radius:12px;
    background:#fff;
    cursor:pointer;
    transition:.2s ease;
}

.option-card:hover{
    border-color:var(--primary);
    background:var(--primary-light);
}

.option-card input{
    width:18px;
    height:18px;
    accent-color:var(--primary);
    margin:0;
    flex-shrink:0;
}

.option-card span{
    flex:1;
    font-size:13.5px;
    font-weight:600;
    color:var(--text);
}

.option-card:has(input:checked){
    border-color:var(--primary);
    background:var(--primary-light);
    box-shadow:0 0 0 3px rgba(0,102,255,.12);
}

.image-preview{
    display:block;
    width:100%;
    max-width:220px;
    height:160px;
    object-fit:cover;
    margin-top:12px;
    border:1px solid var(--border);
    border-radius:var(--radius-sm);
    background:#F8FAFC;
    box-shadow:0 2px 8px rgba(15,23,42,.05);
}

.checkout-textarea{
    min-height:120px !important;
    height:120px !important;
    padding:12px 14px !important;
    resize:vertical !important;
    line-height:1.6 !important;
}

/* Choices.js */
.choices{
    margin:0 !important;
}

.choices__inner{
    min-height:46px !important;
    height:46px !important;
    padding:0 14px !important;
    border:1.5px solid #CBD5E1 !important;
    border-radius:var(--radius-sm) !important;
    background:#FFF !important;
    display:flex !important;
    align-items:center !important;
}

.choices__list--single{
    padding:0 !important;
}

.choices[data-type*="select-one"]::after{
    right:14px !important;
}

.choices.is-focused .choices__inner{
    border-color:var(--primary) !important;
    box-shadow:0 0 0 3px rgba(0,102,255,.12) !important;
}

/* 5. FIX PHONE INPUT (intl-tel-input v25) */
.iti {
    width: 100% !important;
    display: block !important;
}
.iti .checkout-input{
    padding-left:50px !important;
}

.iti__dropdown-content {
    border-radius: 10px !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid #E2E8F0 !important;
    z-index: 99 !important;
}

/* 6. TICKET QUANTITY COUNTER */
.ticket-qty {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    background: #F1F5F9 !important;
    border: 1px solid var(--border) !important;
    padding: 4px !important;
    border-radius: var(--radius-sm) !important;
    width: 130px !important;
}
.qty-btn {
    width: 34px !important; height: 34px !important;
    border: none !important; border-radius: 6px !important;
    background: #FFFFFF !important; font-size: 14px !important;
    font-weight: 700 !important; color: var(--text) !important;
    cursor: pointer !important; display: flex !important;
    align-items: center !important; justify-content: center !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08) !important;
    padding: 0 !important; margin: 0 !important;
}
.qty-btn:hover { background: var(--primary) !important; color: #FFF !important; }
.qty-input {
    width: 45px !important; height: 34px !important;
    border: none !important; background: transparent !important;
    text-align: center !important; font-size: 15px !important;
    font-weight: 700 !important; color: var(--text) !important;
    outline: none !important; padding: 0 !important; margin: 0 !important;
}

/* 7. CARD PESERTA (PARTICIPANT CARD) */
.participant-card {
    background: #FFFFFF !important;
    border: 1.5px solid var(--border) !important;
    border-radius: var(--radius-md) !important;
    padding: 22px !important;
    margin-bottom: 20px !important;
    box-shadow: 0 2px 8px rgba(15,23,42,.03) !important;
}
.participant-header {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding-bottom: 16px !important;
    margin-bottom: 20px !important;
    border-bottom: 1px solid var(--border-light) !important;
    gap: 12px !important;
}
.participant-title { font-size: 16px !important; font-weight: 800 !important; color: var(--text) !important; margin: 0 !important; }
.participant-desc { font-size: 12.5px !important; color: var(--muted) !important; margin: 2px 0 0 0 !important; }

/* Checkbox "Samakan Data Pemesan" */
.participant-copy-box, 
.participant-copy-box.form-check {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 6px 14px !important;
    background: var(--primary-light) !important;
    border: 1px solid var(--primary-border) !important;
    border-radius: 30px !important;
    margin: 0 !important; min-height: auto !important;
}
.participant-copy-box input[type="checkbox"], 
.participant-copy-box .form-check-input {
    width: 15px !important; height: 15px !important;
    margin: 0 !important; padding: 0 !important;
    float: none !important; position: static !important;
    cursor: pointer !important; accent-color: var(--primary) !important;
}
.participant-copy-box label, 
.participant-copy-box .form-check-label {
    font-size: 12px !important; font-weight: 700 !important;
    color: var(--primary) !important; margin: 0 !important;
    padding: 0 !important; cursor: pointer !important;
    white-space: nowrap !important; display: inline-block !important;
}

/* Select Option Dropdown Fix */
.participant-card select,
.participant-card select.form-control,
.participant-card .ev-select {
    width: 100% !important;
    height: 46px !important;
    padding: 0 36px 0 14px !important;
    border: 1.5px solid #CBD5E1 !important;
    border-radius: var(--radius-sm) !important;
    background: #FFFFFF url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%3C64748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 14px center !important;
    font-size: 13.5px !important;
    color: var(--text) !important;
    appearance: none !important;
    outline: none !important;
}

/* 8. FIX FILE & IMAGE UPLOAD BOX */
.upload-field-wrapper input[type="file"] {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    border: 0 !important;
}

.upload-box, 
label.upload-box {
    display: flex !important;
    align-items: center !important;
    gap: 14px !important;
    padding: 14px 16px !important;
    border: 1.5px dashed var(--primary-border) !important;
    border-radius: var(--radius-sm) !important;
    background: var(--primary-light) !important;
    cursor: pointer !important;
    margin: 0 !important;
    width: 100% !important;
    transition: all 0.2s ease !important;
}
.upload-box:hover {
    border-color: var(--primary) !important;
    background: #E6F0FF !important;
}
.upload-icon {
    width: 40px !important; height: 40px !important;
    border-radius: 8px !important; background: #FFFFFF !important;
    color: var(--primary) !important; display: flex !important;
    align-items: center !important; justify-content: center !important;
    font-size: 20px !important; flex-shrink: 0 !important;
    box-shadow: 0 2px 4px rgba(0,102,255,0.08) !important;
}
.upload-content {
    display: flex !important;
    flex-direction: column !important;
    gap: 2px !important;
    overflow: hidden !important;
}
.upload-content strong,
.upload-content .upload-title {
    display: block !important;
    font-size: 13px !important;
    color: var(--text) !important;
    font-weight: 700 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}
.upload-content small,
.upload-content .upload-subtitle {
    display: block !important;
    font-size: 11.5px !important;
    color: var(--muted) !important;
}

.checkout-note {
    margin-top: 16px !important;
    padding: 12px 14px !important;
    border-radius: var(--radius-sm) !important;
    border: 1px solid #FDE68A !important;
    background: #FFFBEA !important;
    color: #92400E !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
}

/* 9. SUMMARY CARD & SIDEBAR STICKY FIX */

/* PERBAIKAN 1: Mencegah Flexbox Bootstrap memaksa tinggi kolom kanan sama dengan kolom kiri */
.col-lg-5 {
    align-self: flex-start !important;
}
.col-lg-5{
    align-self:flex-start;
}

/* PERBAIKAN 2: Penyesuaian Sticky Sidebar */
.summary-sidebar-wrapper.fixed{
    position: fixed;
    top: 90px;
    width: 370px;
}

.summary-sidebar-wrapper.bottom{
    position: absolute;
    bottom: 0;
}

.summary-cover { width: 100% !important; height: 160px !important; object-fit: cover !important; }
.summary-content { padding: 22px !important; }
.summary-title { font-size: 18px !important; font-weight: 800 !important; color: var(--text) !important; margin-bottom: 10px !important; line-height: 1.3 !important; }
.summary-meta { display: flex !important; align-items: center !important; gap: 8px !important; font-size: 13px !important; color: var(--muted) !important; margin-bottom: 8px !important; }

.ticket-box {
    margin-top: 16px !important;
    background: var(--bg) !important;
    border: 1px solid var(--border-light) !important;
    border-radius: var(--radius-sm) !important;
    padding: 12px 14px !important;
    font-size: 13px !important;
}

/* CARD KHUSUS AKSI CHECKOUT (COUNTDOWN, TOTAL, BUTTON) */
.sticky-checkout-action {
    background: var(--card) !important;
    border: 1px solid var(--border) !important;
    border-radius: var(--radius-lg) !important;
    padding: 22px !important;
    margin-top: 16px !important;
    box-shadow: 0 10px 25px -5px rgba(15,23,42,.04) !important;
}

.price-box { 
    margin-top: 0 !important; 
    padding-top: 0 !important; 
    border-top: none !important; 
}
.price-box small { color: var(--muted) !important; font-size: 12px !important; display: block !important; }
.price-amount { font-size: 28px !important; font-weight: 800 !important; color: var(--primary) !important; margin-top: 2px !important; letter-spacing: -0.5px !important; }

.trust-card { margin-top: 16px !important; background: #ECFDF5 !important; border: 1px solid #A7F3D0 !important; border-radius: var(--radius-sm) !important; padding: 12px 14px !important; }
.trust-item { display: flex !important; align-items: center !important; gap: 8px !important; color: #065F46 !important; font-size: 12px !important; font-weight: 600 !important; }
.trust-item + .trust-item { margin-top: 6px !important; }

/* Checkbox Persetujuan Syarat & Ketentuan */
.summary-sidebar-wrapper .form-check {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 20 !important;
    margin-top: 10px !important;
    min-height: auto !important;
    font-size: 13px !important;

}
.summary-sidebar-wrapper.form-check-input {
    width: 16px !important; height: 16px !important;
    margin: 0 !important; padding: 0 !important;
    float: none !important; position: static !important;
    accent-color: var(--primary) !important;
    cursor: pointer !important; flex-shrink: 0 !important;
}
.summary-sidebar-wrapper.form-check-label {
    font-size: 13px !important; color: var(--text) !important;
    margin: 0 !important; cursor: pointer !important;
}

/* Tombol Pembayaran */
.checkout-pay-btn {
    width: 100% !important;
    height: 48px !important;
    border: none !important;
    border-radius: var(--radius-sm) !important;
    background: var(--primary) !important;
    color: #FFF !important;
    font-size: 14.5px !important;
    font-weight: 700 !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    box-shadow: 0 4px 14px rgba(0,102,255,.25) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
}
.checkout-pay-btn:hover { background: var(--primary-hover) !important; transform: translateY(-1px) !important; box-shadow: 0 6px 18px rgba(0,102,255,.35) !important; }

.reservation-countdown{
    display:flex !important;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin:0 0 16px 0 !important;
    padding:10px 18px;
    background:#FFF7ED;
    border:1px solid #FED7AA;
    color:#C2410C;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
    width: 100% !important;
}

.reservation-countdown.expired{
    background:#FEF2F2;
    border-color:#FECACA;
    color:#DC2626;
}

/* Responsive Adjustments (Mobile Sticky Bottom Bar Fix) */
@media(max-width: 991px) {
    .summary-sidebar-wrapper { 
        position: relative !important; 
        top: 0 !important; 
        margin-top: 24px !important; 
    }
    
    /* .sticky-checkout-action {
        position: -webkit-sticky !important;
        position: sticky !important;
        bottom: 0 !important;
        z-index: 1000 !important;
        margin-top: 20px !important;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
        box-shadow: 0 -10px 25px rgba(15,23,42,.1) !important;
        background: #FFFFFF !important;
    } */
}

@media (max-width: 991.98px) {

    .sticky-checkout-action{
        position: fixed !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        z-index: 1050 !important;

        background: #fff !important;
        padding: 16px !important;

        border-top: 1px solid #e9ecef !important;
        box-shadow: 0 -6px 20px rgba(0,0,0,.08) !important;
    }

    /* Supaya isi halaman tidak tertutup sticky */
    .checkout-page{
        padding-bottom: 260px;
    }

    /* Countdown tidak perlu ditampilkan di sticky mobile */
    .sticky-checkout-action .reservation-countdown{
        display: none;
    }

    /* Harga dan tombol */
    .sticky-checkout-action .price-box{
        margin-bottom: 12px;
    }

    .sticky-checkout-action .checkout-pay-btn{
        width: 100%;
    }

}


/* Mobile */
@media (max-width: 991.98px){

    .price-box{
        display:flex;
        justify-content:space-between;
        align-items:center;
        text-align:left;
        padding:0 0 12px;
        margin-bottom:12px;
        border-bottom:1px solid #eee;
    }

    .price-box small{
        display:inline;
        margin:0;
        font-size:14px;
        color:#6c757d;
    }

    .price-amount{
        display:inline;
        margin:0;
        font-size:22px;
        font-weight:700;
        line-height:1;
    }

}

@media(max-width: 768px) {
    .checkout-card-body, .summary-content { padding: 18px !important; }
    .progress-step span { display: none !important; }
    .progress-line { width: 20px !important; }
    .participant-header { flex-direction: column !important; align-items: flex-start !important; }
    .participant-copy-box { width: 100% !important; justify-content: center !important; }
}
</style>

@section('content')
<div class="bg-eventconnect header-hight"></div>

<section class="checkout-section pt-4 pb-5">
<div class="container">

    <div class="checkout-hero">
        <div class="checkout-title">
            Selesaikan Pemesanan
        </div>

        <input
            type="hidden"
            id="reservationExpiredAt"
            value="{{ $reservation->expired_at->toIso8601String() }}">
    </div>

    <div class="checkout-progress">
        <div class="progress-step">
            <div class="progress-circle progress-done">
                <i class="ti ti-check"></i>
            </div>
            <span>Pilih Tiket</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-step">
            <div class="progress-circle progress-active">
                2
            </div>
            <span>Data Peserta</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-step">
            <div class="progress-circle progress-wait">
                3
            </div>
            <span>Pembayaran</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-step">
            <div class="progress-circle progress-wait">
                4
            </div>
            <span>Tiket</span>
        </div>
    </div>

    <form
        method="POST"
        enctype="multipart/form-data"
        id="checkout-event">

        @csrf

        <div class="row g-4 position-relative">

            {{-- FORM LEFT --}}
            <div class="col-lg-7">

                <div class="checkout-card">
                    <div class="checkout-card-body">

                        <div class="checkout-section-title">
                            Data Pemesan
                        </div>

                        @if(auth()->check())
                        <div class="checkout-user-card">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </div>

                            <div>
                                <div class="user-name">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="user-email">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <input type="hidden" name="is_login" id="is_login"
                            value="{{ auth()->check() ? 1 : 0 }}">

                        <input type="hidden" name="user_login_id" id="user_login_id"
                            value="{{ auth()->check() ? auth()->user()->id : '0' }}">

                        <div class="form-group mb-3">
                            <label for="buyerName" class="checkout-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>

                            <input
                                class="form-control checkout-input"
                                name="buyer[name]"
                                id="buyerName"
                                type="text"
                                placeholder="Masukkan nama lengkap"
                                required
                                autocomplete="on"
                                {{ auth()->check() ? 'readonly' : '' }}
                                value="{{ auth()->check() ? auth()->user()->name : '' }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="buyerEmail" class="checkout-label">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input
                                class="form-control checkout-input"
                                name="buyer[email]"
                                type="email"
                                placeholder="example@email.com"
                                id="buyerEmail"
                                required
                                autocomplete="on"
                                {{ auth()->check() ? 'readonly' : '' }}
                                value="{{ auth()->check() ? auth()->user()->email : '' }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="buyerPhone" class="checkout-label">
                                Nomor HP <span class="text-danger">*</span>
                            </label>

                            <input
                                class="form-control checkout-input"
                                name="buyer[phone]"
                                type="text"
                                id="buyerPhone"
                                placeholder="+62 821 3355 3002"
                                value="+62"
                                required>
                        </div>

                        <div class="checkout-field">
                            <label class="checkout-label">
                                Jumlah Tiket
                            </label>

                            <div class="ticket-qty">
                                <button
                                    type="button"
                                    class="qty-btn"
                                    id="qtyMinus">
                                    <i class="ti ti-minus"></i>
                                </button>

                                <input
                                    id="ticketQty"
                                    class="qty-input"
                                    type="number"
                                    min="1"
                                    value="{{ $reservation->quantity }}"
                                    readonly>

                                <button
                                    type="button"
                                    class="qty-btn"
                                    id="qtyPlus">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="checkout-note mt-4">
                            Form dapat di ubah jika registrasi menggunakan akun!
                        </div>

                    </div>
                </div>

                @include('transaction.participant')

            </div>

            {{-- SUMMARY RIGHT --}}
            <div class="col-lg-5">
                
                {{-- Pembungkus Sticky Sidebar --}}
                <div class="summary-sidebar-wrapper">
                

                    {{-- Card Informasi Event & Tiket --}}
                    <div class="checkout-card summary-card">
                        <img
                            src="{{ asset('storage/event-images/' . $event->image) }}"
                            class="summary-cover">

                        <div class="summary-content">
                            <div class="summary-title">
                                {{ $event->title }}
                            </div>

                            <div class="summary-meta">
                                <i class="ti ti-user"></i>
                                {{ $event->penyelenggara->name }}
                            </div>

                            <div class="summary-meta">
                                <i class="ti ti-map-pin"></i>

                                @if(strtolower($event->location_jenis)=='online')
                                    Online
                                @else
                                    {{ $event->location_detail }}
                                    <br>
                                    {{ $event->location_city }},
                                    {{ $event->province->name }}
                                @endif
                            </div>

                            <div class="ticket-box">
                                <strong>
                                    {{ $ticket->ticket_name }}
                                </strong>
                                <br>
                                <small class="text-muted" id="summaryQty">
                                    Qty 1 Ticket
                                </small>
                            </div>

                            <div class="trust-card">
                                <div class="trust-item">
                                    <i class="ti ti-shield-check"></i> Secure payment
                                </div>

                                <div class="trust-item">
                                    <i class="ti ti-ticket"></i> Verify and generate tickets automatically
                                </div>
                            </div>

                            <!-- 3. Persetujuan Syarat & Ketentuan -->
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="persetujuan"
                                    required>

                                <label
                                    class="form-check-label"
                                    for="persetujuan">
                                    Saya setuju dengan <strong>Syarat & Ketentuan</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- CARD KHUSUS: COUNTDOWN + TOTAL PRICE + ACTION BUTTON (Sticky) --}}
                    <div class="sticky-checkout-action">
                        
                        <!-- 1. Countdown Pindah ke Atas Total Harga -->
                        <div class="reservation-countdown" id="reservationCountdown">
                            <i class="ti ti-clock"></i>
                            <span id="countdownText">Memuat sisa waktu...</span>
                        </div>

                        <!-- 2. Price Box -->
                        <div class="price-box">
                            <small>Total Pembayaran</small>
                            <div class="price-amount" id="summaryPrice">
                                Rp {{ number_format($ticket->ticket_price,0,',','.') }}
                            </div>
                        </div>

                        <input
                            type="hidden"
                            name="reservation_code"
                            value="{{ $reservation->reservation_code }}">

                        <input
                            type="hidden"
                            id="quantity"
                            name="quantity" value="{{ $reservation->quantity }}">
                        <input type="hidden" id="ticketPrice" value="{{ $ticket->ticket_price }}">
                        <input type="hidden" id="totalPrice" name="totalPrice" value="{{ $ticket->ticket_price }}">

                        <!-- 4. Tombol Lanjut ke Pembayaran -->
                        <button
                            type="submit"
                            id="checkout-button"
                            class="checkout-pay-btn mt-3">
                            <i class="ti ti-credit-card"></i>
                            Lanjut ke Pembayaran
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>
</section>

<!-- Modal konfirmasi checkout -->
@include('transaction.payment-confirmation')

{{-- NEW script --}}
@push('transaction-scripts')
    @include('transaction.scripts.participant-init')
    @include('transaction.scripts.participant')
    @include('transaction.scripts.participant-copy')
    @include('transaction.scripts.participant-upload')
    @include('transaction.scripts.summary')
    @include('transaction.scripts.payment-confirmation')
    <script>
        const expiredAt = new Date(
            document.getElementById('reservationExpiredAt').value
        );

        const countdownText = document.getElementById('countdownText');
        const countdownBox = document.getElementById('reservationCountdown');

        let reservationExpired = false;

        const timer = setInterval(async function () {

            if (reservationExpired) {
                return;
            }

            const now = new Date();
            const diff = expiredAt - now;

            if (diff <= 0) {

                reservationExpired = true;

                clearInterval(timer);

                countdownBox.classList.add('expired');

                countdownText.innerHTML = 'Reservation telah berakhir';

                try {

                    await $.ajax({
                        url: "{{ route('reservation.expire', ['reservationCode' => $reservation->reservation_code]) }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}"
                        }
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'Waktu reservasi telah habis.'
                    });

                    setTimeout(function () {

                        window.location.href = "{{ url($event->slug) }}";

                    }, 2000);

                } catch (xhr) {

                    console.error(xhr);

                    Toast.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message ??
                            'Gagal mengakhiri reservation. Silakan refresh halaman.'
                    });

                    reservationExpired = false;

                }

                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);

            countdownText.innerHTML =
                `Selesaikan pembayaran dalam ${minutes}:${String(seconds).padStart(2, '0')}`;

        }, 1000);
        
    </script>
@endpush

@endsection