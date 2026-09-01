@extends('layouts.main')
@section('content')
    <div class="bg-eventconnect header-hight"></div>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    .ticket-page {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        padding: 0 15px 40px;
        background: linear-gradient(180deg, #edf4ff 0%, #f7faff 100%);
    }

    .ticket-container {
        max-width: 1000px;
        margin: auto;
    }

    .ticket-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .ticket-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    /* =========================================================
       1. RINGKASAN EVENT (DESAIN CARD KECIL & RESPONSIVE)
    ========================================================= */
    .event-hero-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, .04);
    }

    .event-hero-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .event-hero-img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .event-hero-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    /* Grid Card Kecil untuk Meta Event */
    .event-compact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .event-meta-card {
        background: #f8fafc;
        border-radius: 8px;
        padding: 8px 10px;
    }

    .event-meta-card span {
        display: block;
        color: #64748b;
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .event-meta-card strong {
        display: block;
        color: #0f172a;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /* =========================================================
       2. RINGKASAN TRANSAKSI
    ========================================================= */
    .transaction-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, .04);
    }

    .transaction-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
    }

    .summary-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.2px;
        color: #64748b;
        text-transform: uppercase;
    }

    .summary-status {
        padding: 3px 10px;
        border-radius: 999px;
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 800;
    }

    .transaction-compact-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    .tx-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 8px 10px;
    }

    .tx-item span {
        display: block;
        color: #64748b;
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .tx-item strong {
        display: block;
        color: #0f172a;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /* =========================================================
       3. E-TICKET PARTICIPANT
    ========================================================= */
    .participant-section-header {
        margin-bottom: 14px;
    }

    .participant-section-header h2 {
        margin: 2px 0 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .ticket-modern {
        display: flex;
        min-height: 240px;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: 0 15px 40px rgba(15, 23, 42, .06);
        position: relative;
        margin-bottom: 20px;
    }

    .ticket-left {
        flex: 1;
        padding: 22px 24px;
        color: white;
        position: relative;
        overflow: hidden;
        background-color: #0f172a;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .ticket-left-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        opacity: 0.65;
        z-index: 1;
    }

    .ticket-left-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.75) 0%, rgba(30, 41, 59, 0.88) 100%);
        z-index: 2;
    }

    .ticket-left-content {
        position: relative;
        z-index: 3;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .ticket-top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ticket-brand {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.5px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .ticket-number {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #cbd5e1;
    }

    .ticket-participant-box {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 12px 14px;
        margin: 12px 0;
    }

    .participant-grid-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .p-info-full {
        grid-column: span 2;
    }

    .p-label {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .p-val {
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        word-break: break-word;
    }

    .p-val-sub {
        color: #e2e8f0;
        font-size: 12px;
        font-weight: 500;
    }

    .ticket-bottom-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px dashed rgba(255,255,255,0.2);
        padding-top: 8px;
    }

    .ticket-event-name {
        font-size: 13px;
        font-weight: 700;
        color: #f8fafc;
        max-width: 65%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: left;
    }

    .ticket-code-display {
        text-align: right;
    }

    .ticket-code-display .code-val {
        font-family: monospace;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #38bdf8;
    }

    /* SEPARATOR (DESKTOP) */
    .ticket-separator {
        width: 2px;
        background: #e5e7eb;
        position: relative;
    }

    .ticket-separator:before,
    .ticket-separator:after {
        content: "";
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #edf4ff;
        position: absolute;
        left: -13px;
        z-index: 5;
    }

    .ticket-separator:before { top: -14px; }
    .ticket-separator:after { bottom: -14px; }

    /* RIGHT SIDE (QR CODE) */
    .ticket-right {
        width: 240px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: white;
        padding: 16px;
    }

    .qr-box {
        padding: 8px;
        border-radius: 12px;
        background: #f8fafc;
        box-shadow: 0 4px 12px rgba(0,0,0,.04);
        border: 1px solid #f1f5f9;
    }

    .qr-box svg, .qr-box img {
        width: 120px;
        height: 120px;
        display: block;
    }

    .qr-text {
        margin-top: 8px;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    /* TOMBOL DOWNLOAD UTAMA */
    .download-ticket-main {
        width: 100%;
        margin-top: 10px;
        margin-bottom: 25px;
        height: 50px;
        border: none;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow: 0 8px 20px rgba(37,99,235,.25);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .download-ticket-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37,99,235,.35);
    }

    /* NOTE CARD */
    .ticket-note-card {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(15,23,42,.04);
        overflow: hidden;
    }

    .ticket-note-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 18px;
        font-weight: 700;
        color: #0f172a;
        font-size: 13px;
    }

    .ticket-note-body {
        padding: 14px 18px;
    }

    .ticket-note-list {
        margin: 0;
        padding-left: 16px;
    }

    .ticket-note-list li {
        margin-bottom: 4px;
        color: #475569;
        line-height: 1.5;
        font-size: 12px;
    }


    /* =========================================================
       RESPONSIF MOBILE (POIN 1, 2, DAN 3 DITANGANI DI SINI)
    ========================================================= */
    @media(max-width: 900px) {
        .event-compact-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .transaction-compact-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .ticket-modern {
            flex-direction: column;
        }

        /* REVISI POIN 2: Hilangkan border/garis pada separator saat mobile */
        .ticket-separator {
            width: 100%;
            height: 0;
            background: transparent;
            border: none;
        }

        .ticket-separator:before,
        .ticket-separator:after {
            top: -14px;
            border: none;
        }

        .ticket-separator:before { left: -14px; }
        .ticket-separator:after { left: auto; right: -14px; }

        .ticket-right {
            width: 100%;
            padding: 20px 18px;
        }
    }

    @media(max-width: 576px) {
        /* POIN 1: Meta event kebawah rapi di mobile */
        .event-compact-grid {
            grid-template-columns: 1fr;
        }

        .transaction-compact-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .participant-grid-info {
            grid-template-columns: 1fr;
        }

        .p-info-full {
            grid-column: span 1;
        }

        /* REVISI POIN 3: Rata kiri semua di mobile (Title, Label, dan Ticket Code) */
        .ticket-bottom-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .ticket-event-name {
            max-width: 100%;
            text-align: left;
            white-space: normal;
        }

        .ticket-code-display {
            text-align: left;
            width: 100%;
        }

        .ticket-left {
            padding: 18px;
        }
    }
    </style>

    <section class="ticket-page">
        <div class="ticket-container">

            <div class="ticket-header">
                <h1>Digital Ticket</h1>
            </div>

            @php
                // Penyelenggara Logic
                if ($event->organizer == 'org') {
                    $penyelenggara = $event->org->org_name ?? '';
                } elseif ($event->organizer == 'individual') {
                    $penyelenggara = $event->individual->name ?? '';
                } else {
                    $penyelenggara = '';
                }

                // File storage check
                $imageExist = $event->image && file_exists(public_path('storage/event-images/' . $event->image));
                
                if ($imageExist) {
                    $eventImagePath = asset('storage/event-images/' . $event->image);
                } else {
                    $eventImagePath = asset('assets/default-img/event-images/def-no-img.png');
                }
            @endphp


            {{-- 1. RINGKASAN EVENT (SIMPEL & CARD KECIL) --}}
            <div class="event-hero-card">
                <div class="event-hero-top">
                    <img src="{{ $eventImagePath }}" alt="Event Banner" class="event-hero-img">
                    <h2 class="event-hero-title">{{ $event->title }}</h2>
                </div>

                <div class="event-compact-grid">
                    <div class="event-meta-card">
                        <span>Tanggal Event</span>
                        <strong>
                            @if($event->start_date == $event->end_date)
                                {{ date('d-m-Y', strtotime($event->start_date)) }}
                            @else
                                {{ date('d-m-Y', strtotime($event->start_date)) }} - {{ date('d-m-Y', strtotime($event->end_date)) }}
                            @endif
                        </strong>
                    </div>

                    <div class="event-meta-card">
                        <span>Lokasi Event</span>
                        <strong>
                            @if(strtolower($event->location_jenis) == 'online')
                                Online Event
                            @else
                                {{ $event->location_detail }} ({{ $event->location_city }})
                            @endif
                        </strong>
                    </div>

                    <div class="event-meta-card">
                        <span>Penyelenggara</span>
                        <strong>{{ $penyelenggara ?: '-' }}</strong>
                    </div>
                </div>
            </div>


            {{-- 2. RINGKASAN TRANSAKSI --}}
            <div class="transaction-card">
                <div class="transaction-card-header">
                    <span class="summary-label">RINGKASAN TRANSAKSI</span>
                    <span class="summary-status">PAID</span>
                </div>

                <div class="transaction-compact-grid">
                    <div class="tx-item">
                        <span>Kode Transaksi</span>
                        <strong>{{ $transaction->transaction_code }}</strong>
                    </div>

                    <div class="tx-item">
                        <span>Nama Pembeli</span>
                        <strong>{{ $transaction->buyer_name ?? '-' }}</strong>
                    </div>

                    <div class="tx-item">
                        <span>Email Pembeli</span>
                        <strong title="{{ $transaction->buyer_email ?? '-' }}">{{ $transaction->buyer_email ?? '-' }}</strong>
                    </div>

                    <div class="tx-item">
                        <span>No. Telepon</span>
                        <strong>{{ $transaction->buyer_phone ?? '-' }}</strong>
                    </div>

                    @if(isset($transaction->grand_total))
                        <div class="tx-item">
                            <span>Total Pembayaran</span>
                            <strong>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</strong>
                        </div>
                    @endif
                </div>
            </div>


            {{-- 3. PARTICIPANT TICKET --}}
            <div class="participant-ticket-section">
                <div class="participant-section-header">
                    <span class="summary-label">E-TICKET PESERTA</span>
                    <h2>{{ $transaction->participants->count() }} Tiket</h2>
                </div>

                @forelse($transaction->participants as $index => $participant)
                    @php
                        $participantTicketCode = $participant->ticket_code ?? $transaction->ticket_code ?? $transaction->transaction_code;
                        $participantQrCode = QrCode::size(120)->generate($participantTicketCode);
                    @endphp

                    <div class="ticket-modern">
                        {{-- LEFT TICKET DENGAN FULL BACKGROUND IMAGE --}}
                        <div class="ticket-left">
                            <img src="{{ $eventImagePath }}" alt="Event Background" class="ticket-left-bg">
                            <div class="ticket-left-overlay"></div>

                            <div class="ticket-left-content">
                                <div class="ticket-top-bar">
                                    <div class="ticket-brand">EVENTHUB TICKET</div>
                                    <div class="ticket-number">TIKET #{{ $index + 1 }}</div>
                                </div>

                                <div class="ticket-participant-box">
                                    <div class="participant-grid-info">
                                        <div class="p-info-full">
                                            <div class="p-label">Nama Peserta</div>
                                            <div class="p-val">{{ $participant->name }}</div>
                                        </div>

                                        @if($participant->email)
                                            <div>
                                                <div class="p-label">Email</div>
                                                <div class="p-val-sub">{{ $participant->email }}</div>
                                            </div>
                                        @endif

                                        @if($participant->phone)
                                            <div>
                                                <div class="p-label">Telepon</div>
                                                <div class="p-val-sub">{{ $participant->phone }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="ticket-bottom-info">
                                    <div class="ticket-event-name" title="{{ $event->title }}">
                                        {{ $event->title }}
                                    </div>
                                    <div class="ticket-code-display">
                                        <div class="p-label">TICKET CODE</div>
                                        <div class="code-val">{{ $participantTicketCode }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SEPARATOR --}}
                        <div class="ticket-separator"></div>

                        {{-- RIGHT TICKET (QR) --}}
                        <div class="ticket-right">
                            <div class="qr-box">
                                {!! $participantQrCode !!}
                            </div>
                            <div class="qr-text">Scan saat Check-In</div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        Tidak ada peserta pada transaksi ini.
                    </div>
                @endforelse

                {{-- TOMBOL DOWNLOAD UTAMA --}}
                @if($transaction->participants->count() > 0)
                    <button
                        type="button"
                        class="download-ticket-main download-btn-action"
                        data-transaction-code="{{ $transaction->transaction_code }}"
                    >
                        Download Ticket
                    </button>
                @endif
            </div>


            {{-- INFORMASI PENTING --}}
            <div class="card ticket-note-card mt-3 mb-4">
                <div class="ticket-note-header">
                    🎟️ Informasi Penting
                </div>
                <div class="ticket-note-body">
                    <ul class="ticket-note-list">
                        <li>Simpan tiket dan QR Code dengan baik untuk verifikasi check-in di lokasi acara.</li>
                        <li>Jangan menyebarkan QR Code untuk menghindari klaim ganda oleh pihak lain.</li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <script>
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.download-btn-action');

        if (!btn) return;

        e.preventDefault();

        const transactionCode = btn.dataset.transactionCode;

        if (!transactionCode) return;

        window.location.href =
            `/transaction/${encodeURIComponent(transactionCode)}/ticket/download`;
    });
</script>
@endsection