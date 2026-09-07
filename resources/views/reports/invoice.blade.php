@extends('layouts.main')

@section('content')

<div class="bg-eventconnect header-hight"></div>

@php
    // ==============================
    // PENYELENGGARA
    // ==============================
    if ($event->organizer == 'org') {
        $penyelenggara = $event->org->org_name ?? '';
    } elseif ($event->organizer == 'individual') {
        $penyelenggara = $event->individual->name ?? '';
    } else {
        $penyelenggara = '';
    }

    // ==============================
    // EVENT IMAGE
    // ==============================
    $imageExist = $event->image &&
        file_exists(public_path('storage/event-images/' . $event->image));

    if ($imageExist) {
        $eventImagePath = asset('storage/event-images/' . $event->image);
    } else {
        $eventImagePath = asset('assets/default-img/event-images/def-no-img.png');
    }

    // ==============================
    // EVENT DATE
    // ==============================
    if ($event->start_date == $event->end_date) {
        $eventDate = date('d M Y', strtotime($event->start_date));
    } else {
        $eventDate =
            date('d M Y', strtotime($event->start_date)) .
            ' - ' .
            date('d M Y', strtotime($event->end_date));
    }

    // ==============================
    // INVOICE DATE
    // ==============================
    $invoiceDate = $transaction->invoice_issued_at
        ? date('d M Y', strtotime($transaction->invoice_issued_at))
        : date('d M Y', strtotime($transaction->created_at));

    // ==============================
    // TOTAL PARTICIPANTS
    // ==============================
    $totalParticipants = $transaction->participants->count();

    // ==============================
    // STATUS
    // ==============================
    $paymentStatus = strtoupper($transaction->status ?? 'PAID');
@endphp


<section class="invoice-page">
    <div class="invoice-container">

        {{-- ACTION --}}
        <div class="invoice-actions">
            <a href="{{ route('transaction.invoice.download', $transaction->transaction_code) }}"
            class="btn-download">
                <i class="ti ti-file-type-pdf"></i>
                Download PDF
            </a>
        </div>

        {{-- =========================================
            INVOICE HEADER
        ========================================== --}}
        <div class="invoice-document">

            <div class="invoice-header">

                <div class="invoice-brand">
                    <img
                        src="/assets/img/eventverse-color.png"
                        alt="Eventverse"
                        class="invoice-logo"
                    >
                </div>


                <div class="invoice-heading">
                    <div class="invoice-title">
                        INVOICE
                    </div>

                    <div class="invoice-status">
                        <span class="status-dot"></span>
                        PAID
                    </div>
                </div>

            </div>


            {{-- =========================================
                INVOICE META
            ========================================== --}}
            <div class="invoice-meta-section">

                <div class="invoice-number-block">
                    <span class="meta-label">
                        Invoice Number
                    </span>

                    <strong class="invoice-number">
                        {{ $transaction->invoice_number ?? '-' }}
                    </strong>
                </div>


                <div class="invoice-meta-grid">

                    <div>
                        <span class="meta-label">
                            Invoice Date
                        </span>

                        <strong>
                            {{ $invoiceDate }}
                        </strong>
                    </div>

                    <div>
                        <span class="meta-label">
                            Transaction Number
                        </span>

                        <strong>
                            {{ $transaction->transaction_code }}
                        </strong>
                    </div>

                </div>

            </div>


            {{-- =========================================
                EVENT + BUYER
            ========================================== --}}
            <div class="info-grid">

                {{-- EVENT --}}
                <div class="info-card">

                    <div class="section-label">
                        EVENT
                    </div>

                    <div class="event-info">

                        <img
                            src="{{ $eventImagePath }}"
                            alt="{{ $event->title }}"
                            class="event-thumbnail"
                        >

                        <div class="event-info-content">

                            <h2>
                                {{ $event->title }}
                            </h2>

                            <div class="event-detail">
                                <span class="detail-icon">◷</span>
                                <span>{{ $eventDate }}</span>
                            </div>

                            <div class="event-detail">
                                <span class="detail-icon">⌖</span>

                                <span>
                                    @if(strtolower($event->location_jenis) == 'online')
                                        Online Event
                                    @else
                                        {{ $event->location_detail }}
                                        ({{ $event->location_city }})
                                    @endif
                                </span>
                            </div>

                            <div class="event-organizer">
                                {{ $penyelenggara ?: '-' }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- BUYER --}}
                <div class="info-card">

                    <div class="section-label">
                        BILLED TO
                    </div>

                    <div class="buyer-info">

                        <div class="buyer-name">
                            {{ $transaction->buyer_name ?? '-' }}
                        </div>

                        <div class="buyer-row">
                            {{ $transaction->buyer_email ?? '-' }}
                        </div>

                        <div class="buyer-row">
                            {{ $transaction->buyer_phone ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================
                PURCHASE DETAIL
            ========================================== --}}
            <div class="invoice-section">

                <div class="section-label">
                    PURCHASE DETAILS
                </div>

                <div class="invoice-table">

                    <div class="table-head">

                        <div>
                            DESCRIPTION
                        </div>

                        <div class="text-center">
                            QTY
                        </div>

                        <div class="text-right">
                            AMOUNT
                        </div>

                    </div>


                    <div class="table-row">

                        <div>

                            <div class="product-name">
                                {{ $ticket->ticket_name ?? '-' }}
                            </div>

                            <div class="product-description">
                                Event Ticket
                            </div>

                        </div>

                        <div class="text-center">
                            {{ $totalParticipants }}
                        </div>

                        <div class="text-right">
                            Rp {{ number_format($transaction->subtotal ?? 0, 0, ',', '.') }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================
                TOTAL
            ========================================== --}}
            <div class="invoice-total-section">

                <div class="payment-information">

                    <div class="section-label">
                        PAYMENT INFORMATION
                    </div>

                    <div class="payment-row">
                        <span>Status</span>

                        <strong class="paid-text">
                            {{ $transaction->status }}
                        </strong>
                    </div>
                    <div class="payment-row">
                        <span>Payment method</span>

                        <strong class="paid-text">
                            {{ $transaction->paymentGatewayMethod?->method?->name ?? '-' }}
                        </strong>
                    </div>

                    {{-- @if(isset($transaction->payment_method))
                        <div class="payment-row">
                            <span>Payment Method</span>

                            <strong>
                                {{ $transaction->payment_method }}
                            </strong>
                        </div>
                    @endif --}}

                </div>


                <div class="total-summary">

                    <div class="summary-row">
                        <span>Subtotal</span>

                        <strong>
                            Rp {{ number_format($transaction->subtotal ?? 0, 0, ',', '.') }}
                        </strong>
                    </div>

                    {{-- Jika nanti ada fee yang tersimpan di transaksi,
                         tambahkan di sini. --}}

                    <div class="summary-divider"></div>

                    <div class="summary-grand-total">

                        <span>
                            Total Paid
                        </span>

                        <strong>
                            Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =========================================
                PARTICIPANTS
            ========================================== --}}
            @if($transaction->participants->count())

                <div class="invoice-section participants-section">

                    <div class="section-label">
                        PARTICIPANTS
                    </div>

                    <div class="participants-table">

                        <div class="participant-head">

                            <div>
                                #
                            </div>

                            <div>
                                PARTICIPANT
                            </div>

                            <div>
                                TICKET CODE
                            </div>

                        </div>


                        @foreach($transaction->participants as $index => $participant)

                            @php
                                $participantTicketCode =
                                    $participant->ticket_code ??
                                    $transaction->ticket_code ??
                                    $transaction->transaction_code;
                            @endphp

                            <div class="participant-row">

                                <div class="participant-number">
                                    {{ $index + 1 }}
                                </div>

                                <div>

                                    <div class="participant-name">
                                        {{ $participant->name }}
                                    </div>

                                    @if($participant->email)
                                        <div class="participant-email">
                                            {{ $participant->email }}
                                        </div>
                                    @endif

                                </div>

                                <div class="participant-code">
                                    {{ $participantTicketCode }}
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- =========================================
                FOOTER NOTE
            ========================================== --}}
            <div class="invoice-footer">

                <div class="footer-message">

                    <strong>
                        Thank you for your purchase.
                    </strong>

                    <span>
                        Simpan invoice ini sebagai bukti pembayaran.
                        E-ticket dapat digunakan untuk proses check-in pada hari acara.
                    </span>

                </div>


                <div class="footer-company">

                    <strong>
                        EVENTVERSE
                    </strong>

                    <span>
                        Event Management & Ticketing
                    </span>

                </div>

            </div>

        </div>

    </div>
</section>


<style>

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');


    /* =========================================
       PAGE
    ========================================== */

    .invoice-page {
        font-family: 'Inter', sans-serif;

        min-height: 100vh;

        padding:
            35px
            15px
            60px;

        background:
            linear-gradient(
                180deg,
                #edf4ff 0%,
                #f7faff 100%
            );

        color: #172033;
    }


    .invoice-container {
        width: 100%;
        max-width: 980px;
        margin: 0 auto;
    }

    .invoice-logo {
        display: block;
        width: 170px;
        height: auto;
        max-height: 55px;
        object-fit: contain;
        object-position: left center;
    }


    /* =========================================
       DOCUMENT
    ========================================== */

    .invoice-document {

        background: #ffffff;

        border: 1px solid #e4e9f2;

        border-radius: 14px;

        box-shadow:
            0 15px 45px rgba(24, 48, 88, .08);

        overflow: hidden;
    }


    /* =========================================
       HEADER
    ========================================== */

    .invoice-header {

        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        padding: 36px 42px 30px;

        border-bottom: 1px solid #edf0f5;
    }


    .invoice-brand {

        display: flex;

        align-items: center;

        gap: 12px;
    }


    .brand-mark {

        width: 42px;
        height: 42px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: #2563eb;

        color: white;

        font-size: 14px;

        font-weight: 800;

        letter-spacing: -.5px;
    }


    .brand-name {

        font-size: 18px;

        font-weight: 800;

        letter-spacing: -.4px;

        color: #172033;
    }


    .brand-tagline {

        margin-top: 2px;

        font-size: 11px;

        color: #8a94a6;
    }


    .invoice-heading {

        text-align: right;
    }


    .invoice-title {

        font-size: 30px;

        line-height: 1;

        font-weight: 800;

        letter-spacing: -1px;

        color: #172033;
    }


    .invoice-status {

        display: inline-flex;

        align-items: center;

        gap: 6px;

        margin-top: 10px;

        padding: 5px 10px;

        border-radius: 999px;

        background: #ecfdf3;

        color: #15803d;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: .5px;
    }


    .status-dot {

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: #22c55e;
    }


    /* =========================================
       META
    ========================================== */

    .invoice-meta-section {

        display: flex;

        justify-content: space-between;

        gap: 40px;

        padding: 26px 42px;

        background: #fafbfd;

        border-bottom: 1px solid #edf0f5;
    }


    .invoice-number-block {

        display: flex;

        flex-direction: column;

        gap: 5px;
    }


    .meta-label {

        display: block;

        margin-bottom: 5px;

        color: #8993a5;

        font-size: 10px;

        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: .7px;
    }


    .invoice-number {

        font-size: 18px;

        letter-spacing: -.3px;

        color: #1d4ed8;
    }


    .invoice-meta-grid {

        display: flex;

        gap: 55px;

        align-items: center;
    }


    .invoice-meta-grid strong {

        font-size: 13px;

        color: #273247;
    }


    /* =========================================
       INFO GRID
    ========================================== */

    .info-grid {

        display: grid;

        grid-template-columns: 1.2fr .8fr;

        gap: 20px;

        padding: 30px 42px 0;
    }


    .info-card {

        min-height: 150px;

        padding: 20px;

        border: 1px solid #e8ecf3;

        border-radius: 10px;

        background: #fff;
    }


    .section-label {

        margin-bottom: 15px;

        color: #8993a5;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: .8px;

        text-transform: uppercase;
    }


    /* =========================================
       EVENT
    ========================================== */

    .event-info {

        display: flex;

        align-items: center;

        gap: 14px;
    }


    .event-thumbnail {

        width: 78px;
        height: 78px;

        flex: 0 0 78px;

        object-fit: cover;

        border-radius: 8px;

        border: 1px solid #edf0f5;
    }


    .event-info-content h2 {

        margin: 0 0 8px;

        font-size: 15px;

        line-height: 1.35;

        font-weight: 700;

        color: #1d2738;
    }


    .event-detail {

        display: flex;

        gap: 7px;

        align-items: flex-start;

        margin-top: 5px;

        color: #626d7f;

        font-size: 11px;

        line-height: 1.4;
    }


    .detail-icon {

        width: 13px;

        color: #2563eb;

        font-weight: 700;
    }


    .event-organizer {

        margin-top: 8px;

        color: #8993a5;

        font-size: 10px;
    }


    /* =========================================
       BUYER
    ========================================== */

    .buyer-name {

        margin-bottom: 12px;

        font-size: 15px;

        font-weight: 700;

        color: #1d2738;
    }


    .buyer-row {

        margin-top: 7px;

        color: #626d7f;

        font-size: 11px;

        word-break: break-word;
    }


    /* =========================================
       INVOICE SECTION
    ========================================== */

    .invoice-section {

        padding: 30px 42px 0;
    }


    /* =========================================
       TABLE
    ========================================== */

    .invoice-table {

        border: 1px solid #e7ebf2;

        border-radius: 9px;

        overflow: hidden;
    }


    .table-head,
    .table-row {

        display: grid;

        grid-template-columns: 1fr 90px 180px;

        gap: 15px;

        align-items: center;
    }


    .table-head {

        padding: 12px 16px;

        background: #f8fafc;

        color: #8a94a6;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: .7px;
    }


    .table-row {

        padding: 17px 16px;

        color: #293447;

        font-size: 12px;
    }


    .product-name {

        font-weight: 600;

        color: #202b3c;
    }


    .product-description {

        margin-top: 3px;

        color: #99a2b1;

        font-size: 10px;
    }


    .text-center {
        text-align: center;
    }


    .text-right {
        text-align: right;
    }


    /* =========================================
       TOTAL
    ========================================== */

    .invoice-total-section {

        display: grid;

        grid-template-columns: 1fr 330px;

        gap: 50px;

        padding: 32px 42px;
    }


    .payment-information {

        padding-top: 2px;
    }


    .payment-row {

        display: flex;

        justify-content: space-between;

        gap: 20px;

        padding: 7px 0;

        color: #707b8e;

        font-size: 11px;
    }


    .payment-row strong {

        color: #263246;

        font-size: 11px;

        text-align: right;
    }


    .paid-text {
        text-transform: uppercase;

        color: #16a34a !important;
    }


    .total-summary {

        padding: 18px 20px;

        border-radius: 10px;

        background: #f8fafc;

        border: 1px solid #e7ebf2;
    }


    .summary-row {

        display: flex;

        justify-content: space-between;

        gap: 20px;

        color: #667085;

        font-size: 11px;
    }


    .summary-row strong {

        color: #263246;
    }


    .summary-divider {

        height: 1px;

        margin: 15px 0;

        background: #dfe4ec;
    }


    .summary-grand-total {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;
    }


    .summary-grand-total span {

        color: #263246;

        font-size: 12px;

        font-weight: 700;
    }


    .summary-grand-total strong {

        color: #1d4ed8;

        font-size: 18px;

        font-weight: 800;

        letter-spacing: -.4px;
    }


    /* =========================================
       PARTICIPANTS
    ========================================== */

    .participants-section {

        padding-top: 0;

        padding-bottom: 32px;
    }


    .participants-table {

        border: 1px solid #e7ebf2;

        border-radius: 9px;

        overflow: hidden;
    }


    .participant-head,
    .participant-row {

        display: grid;

        grid-template-columns: 45px 1fr 220px;

        gap: 15px;

        align-items: center;
    }


    .participant-head {

        padding: 11px 16px;

        background: #f8fafc;

        color: #8993a5;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: .7px;
    }


    .participant-row {

        padding: 13px 16px;

        border-top: 1px solid #edf0f5;

        font-size: 11px;
    }


    .participant-number {

        color: #9aa4b4;

        font-weight: 600;
    }


    .participant-name {

        color: #273247;

        font-weight: 600;
    }


    .participant-email {

        margin-top: 3px;

        color: #9aa4b4;

        font-size: 10px;
    }


    .participant-code {

        color: #536075;

        font-family: monospace;

        font-size: 10px;

        text-align: right;

        word-break: break-all;
    }


    /* =========================================
       FOOTER
    ========================================== */

    .invoice-footer {

        display: flex;

        justify-content: space-between;

        gap: 40px;

        padding: 25px 42px 30px;

        border-top: 1px solid #edf0f5;

        background: #fafbfd;
    }


    .footer-message {

        display: flex;

        flex-direction: column;

        gap: 5px;

        max-width: 570px;
    }


    .footer-message strong {

        color: #374151;

        font-size: 11px;
    }


    .footer-message span {

        color: #8b95a5;

        font-size: 10px;

        line-height: 1.6;
    }


    .footer-company {

        display: flex;

        flex-direction: column;

        align-items: flex-end;

        gap: 4px;

        white-space: nowrap;
    }


    .footer-company strong {

        color: #374151;

        font-size: 11px;

        font-weight: 800;
    }


    .footer-company span {

        color: #9aa3b1;

        font-size: 9px;
    }


    /* =========================================
       RESPONSIVE
    ========================================== */

    @media (max-width: 768px) {

        .invoice-page {
            padding: 15px 10px 40px;
        }


        .invoice-header {

            padding: 25px 22px;

            flex-direction: column;

            gap: 25px;
        }


        .invoice-heading {
            text-align: left;
        }


        .invoice-title {
            font-size: 25px;
        }


        .invoice-meta-section {

            padding: 22px;

            flex-direction: column;

            gap: 20px;
        }


        .invoice-meta-grid {

            gap: 35px;

            flex-wrap: wrap;
        }


        .info-grid {

            grid-template-columns: 1fr;

            padding: 22px 22px 0;
        }


        .invoice-section {

            padding: 25px 22px 0;
        }


        .invoice-total-section {

            grid-template-columns: 1fr;

            gap: 25px;

            padding: 25px 22px;
        }


        .table-head,
        .table-row {

            grid-template-columns: 1fr 50px 120px;

            gap: 8px;
        }


        .participant-head,
        .participant-row {

            grid-template-columns: 30px 1fr 130px;

            gap: 8px;
        }


        .invoice-footer {

            padding: 22px;

            flex-direction: column;
        }


        .footer-company {

            align-items: flex-start;
        }

    }


    @media print {

        .bg-eventconnect {
            display: none !important;
        }


        .invoice-page {

            padding: 0;

            background: #fff;
        }


        .invoice-container {

            max-width: none;
        }


        .invoice-document {

            border: none;

            border-radius: 0;

            box-shadow: none;
        }

    }

    .invoice-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 16px;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        padding: 10px 16px;

        background: #2563eb;
        color: #ffffff;

        border: 1px solid #2563eb;
        border-radius: 8px;

        font-size: 13px;
        font-weight: 600;
        line-height: 1;

        text-decoration: none;

        transition:
            background-color 0.2s ease,
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            transform 0.2s ease;
    }

    .btn-download:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;

        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.18);
    }

    .btn-download:active {
        transform: translateY(1px);
    }

    .btn-download i {
        font-size: 14px;
    }

    /* Mobile */
    @media (max-width: 576px) {
        .invoice-actions {
            justify-content: stretch;
        }

        .btn-download {
            width: 100%;
        }
    }

    /* Tidak ikut tercetak */
    @media print {
        .invoice-actions {
            display: none !important;
        }
    }

</style>

@endsection
