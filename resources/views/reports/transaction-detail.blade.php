@extends('layouts.main')

@section('content')

<div class="bg-eventconnect header-hight"></div>

@php

    /*
    |--------------------------------------------------------------------------
    | PENYELENGGARA
    |--------------------------------------------------------------------------
    */

    if ($event->organizer == 'org') {
        $penyelenggara = $event->org->org_name ?? '';
    } elseif ($event->organizer == 'individual') {
        $penyelenggara = $event->individual->name ?? '';
    } else {
        $penyelenggara = '';
    }


    /*
    |--------------------------------------------------------------------------
    | EVENT IMAGE
    |--------------------------------------------------------------------------
    */

    $imageExist = $event->image &&
        file_exists(
            public_path('storage/event-images/' . $event->image)
        );

    if ($imageExist) {
        $eventImagePath = asset(
            'storage/event-images/' . $event->image
        );
    } else {
        $eventImagePath = asset(
            'assets/default-img/event-images/def-no-img.png'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EVENT DATE
    |--------------------------------------------------------------------------
    */

    if ($event->start_date == $event->end_date) {

        $eventDate = date(
            'd M Y',
            strtotime($event->start_date)
        );

    } else {

        $eventDate =
            date(
                'd M Y',
                strtotime($event->start_date)
            )
            . ' - ' .
            date(
                'd M Y',
                strtotime($event->end_date)
            );

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    $status = strtoupper(
        $transaction->status ?? '-'
    );


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    $subtotal = (float) (
        $transaction->subtotal ?? 0
    );

    $grandTotal = (float) (
        $transaction->grand_total ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | PARTICIPANTS
    |--------------------------------------------------------------------------
    */

    $totalParticipants = $participants->count();

@endphp


<section class="transaction-detail-page">

    <div class="transaction-detail-container">

        {{-- =====================================================
             ACTION
        ====================================================== --}}

        <div class="detail-actions">

            <a
                href="{{ route(
                    'transaction.invoice',
                    $transaction->transaction_code
                ) }}"
                class="btn-secondary"
            >
                <i class="ti ti-file-invoice"></i>
                Invoice
            </a>

            <a
                href="{{ route(
                    'transaction.invoice.download',
                    $transaction->transaction_code
                ) }}"
                class="btn-primary"
            >
                <i class="ti ti-file-type-pdf"></i>
                Download PDF
            </a>

        </div>


        {{-- =====================================================
             TRANSACTION HEADER
        ====================================================== --}}

        <div class="transaction-header-card">

            <div>

                <div class="eyebrow">
                    TRANSACTION DETAIL
                </div>

                <h1>
                    {{ $transaction->transaction_code }}
                </h1>

                <div class="transaction-date">
                    {{ $transaction->created_at?->format('d M Y, H:i') }}
                </div>

            </div>


            <div class="transaction-status">

                <span class="status-dot"></span>

                {{ $status }}

            </div>

        </div>


        {{-- =====================================================
             EVENT
        ====================================================== --}}

        <div class="detail-card event-card">

            <div class="card-title">
                Event
            </div>

            <div class="event-wrapper">

                <img
                    src="{{ $eventImagePath }}"
                    alt="{{ $event->title }}"
                    class="event-image"
                >

                <div class="event-content">

                    <h2>
                        {{ $event->title }}
                    </h2>

                    <div class="event-meta">

                        <div>
                            <i class="ti ti-calendar"></i>

                            <span>
                                {{ $eventDate }}
                            </span>
                        </div>


                        <div>

                            <i class="ti ti-map-pin"></i>

                            <span>

                                @if(strtolower($event->location_jenis) == 'online')

                                    Online Event

                                @else

                                    {{ $event->location_detail }}

                                    @if($event->location_city)
                                        ({{ $event->location_city }})
                                    @endif

                                @endif

                            </span>

                        </div>


                        <div>

                            <i class="ti ti-user"></i>

                            <span>
                                {{ $penyelenggara ?: '-' }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             TRANSACTION INFORMATION
        ====================================================== --}}

        <div class="two-column">

            {{-- TRANSACTION --}}

            <div class="detail-card">

                <div class="card-title">
                    Transaction Information
                </div>

                <div class="detail-list">

                    <div class="detail-row">

                        <span>
                            Transaction Number
                        </span>

                        <strong>
                            {{ $transaction->transaction_code }}
                        </strong>

                    </div>


                    <div class="detail-row">

                        <span>
                            Invoice Number
                        </span>

                        <strong class="blue-text">
                            {{ $transaction->invoice_number ?? '-' }}
                        </strong>

                    </div>


                    <div class="detail-row">

                        <span>
                            Transaction Date
                        </span>

                        <strong>
                            {{ $transaction->created_at?->format('d M Y, H:i') }}
                        </strong>

                    </div>


                    @if($transaction->paid_at)

                        <div class="detail-row">

                            <span>
                                Paid At
                            </span>

                            <strong>
                                {{ $transaction->paid_at->format('d M Y, H:i') }}
                            </strong>

                        </div>

                    @endif


                    <div class="detail-row">

                        <span>
                            Status
                        </span>

                        <strong class="paid-text">
                            {{ $status }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- BUYER --}}

            <div class="detail-card">

                <div class="card-title">
                    Buyer Information
                </div>

                <div class="buyer-detail">

                    <div class="buyer-name">
                        {{ $transaction->buyer_name ?? '-' }}
                    </div>

                    <div class="buyer-contact">

                        <div>
                            <i class="ti ti-mail"></i>
                            {{ $transaction->buyer_email ?? '-' }}
                        </div>

                        <div>
                            <i class="ti ti-phone"></i>
                            {{ $transaction->buyer_phone ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             TICKET
        ====================================================== --}}

        <div class="detail-card">

            <div class="card-title">
                Ticket Purchase
            </div>

            <div class="ticket-purchase">

                <div>

                    <div class="ticket-name">
                        {{ $ticket->ticket_name ?? '-' }}
                    </div>

                    <div class="ticket-type">
                        Event Ticket
                    </div>

                </div>


                <div class="ticket-quantity">

                    <span>
                        Quantity
                    </span>

                    <strong>
                        {{ $totalParticipants }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =====================================================
             PAYMENT
        ====================================================== --}}

        <div class="two-column">

            <div class="detail-card">

                <div class="card-title">
                    Payment Information
                </div>

                <div class="detail-list">

                    <div class="detail-row">

                        <span>
                            Payment Method
                        </span>

                        <strong>
                            {{ $paymentGatewayMethod?->method?->name ?? '-' }}
                        </strong>

                    </div>


                    <div class="detail-row">

                        <span>
                            Payment Gateway
                        </span>

                        <strong>
                            {{ $paymentGatewayMethod?->gateway?->name ?? '-' }}
                        </strong>

                    </div>


                    <div class="detail-row">

                        <span>
                            Payment Status
                        </span>

                        <strong class="paid-text">
                            {{ $status }}
                        </strong>

                    </div>

                </div>

            </div>


            <div class="detail-card">

                <div class="card-title">
                    Payment Summary
                </div>

                <div class="price-summary">

                    <div>

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            Rp {{ number_format(
                                $subtotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>

                    </div>


                    <div class="summary-divider"></div>


                    <div class="grand-total">

                        <span>
                            Total Paid
                        </span>

                        <strong>
                            Rp {{ number_format(
                                $grandTotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             PARTICIPANTS
        ====================================================== --}}

        <div class="detail-card participants-card">

            <div class="participants-heading">

                <div>

                    <div class="card-title">
                        Participants
                    </div>

                    <div class="card-description">
                        {{ $totalParticipants }}
                        participant(s) registered in this transaction.
                    </div>

                </div>

            </div>


            <div class="participants-list">

                @forelse($participants as $index => $participant)

                    @php

                        $participantTicketCode =
                            $participant->ticket_code ??
                            $transaction->ticket_code ??
                            $transaction->transaction_code;

                    @endphp


                    <div class="participant-item">

                        <div class="participant-number">
                            {{ str_pad(
                                $index + 1,
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </div>


                        <div class="participant-main">

                            <div class="participant-name">
                                {{ $participant->name ?? '-' }}
                            </div>

                            @if($participant->email)

                                <div class="participant-email">
                                    {{ $participant->email }}
                                </div>

                            @endif

                        </div>


                        <div class="participant-ticket">

                            <span>
                                Ticket Code
                            </span>

                            <strong>
                                {{ $participantTicketCode }}
                            </strong>

                        </div>


                        {{-- E-TICKET --}}

                        <div>

                            <a
                                href="{{ route(
                                    'transaction.ticket',
                                    $transaction->transaction_code
                                ) }}"
                                class="participant-action"
                            >
                                E-ticket
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">
                        No participants found.
                    </div>

                @endforelse

            </div>

        </div>

        {{-- =====================================================
    CUSTOM FORM
====================================================== --}}

@php

    $hasParticipantForms = $participants->contains(
        fn ($participant) =>
            $participant->forms &&
            $participant->forms->count()
    );

@endphp


@if($hasParticipantForms)

    <div class="detail-card">

        <div class="card-title">
            Participant Information
        </div>

        <div class="forms-wrapper">

            @foreach($participants as $participant)

                @if($participant->forms?->count())

                    <div class="participant-form-block">

                        <div class="form-participant-name">
                            {{ $participant->name ?? '-' }}
                        </div>


                        @foreach($participant->forms as $form)

                            @php

                                $customForm = $form->form;

                                $fieldLabel =
                                    $customForm?->field_label
                                    ?? $form->field_label
                                    ?? 'Field';

                                $fieldType = strtolower(
                                    $customForm?->field_type ?? ''
                                );

                                $value = $form->form_value;

                                $isImage = $fieldType === 'image';
                                $isFile = $fieldType === 'file';

                                $fileUrl = $value
                                    ? asset('storage/' . ltrim($value, '/'))
                                    : null;

                                $fileName = $value
                                    ? basename($value)
                                    : null;

                            @endphp


                            <div class="form-row">

                                <span>
                                    {{ $fieldLabel }}
                                </span>


                                {{-- FIELD KOSONG --}}

                                @if(!$value)

                                    <strong class="form-empty">
                                        -
                                    </strong>


                                {{-- IMAGE --}}

                                @elseif($isImage)

                                    <div class="form-file-wrapper form-file-right">

                                        <div class="form-file-preview">
                                            <img
                                                src="{{ $fileUrl }}"
                                                alt="{{ $fieldLabel }}"
                                                loading="lazy"
                                            >
                                        </div>

                                        <div class="form-file-actions">
                                            <a
                                                href="{{ $fileUrl }}"
                                                target="_blank"
                                                class="btn-file-action btn-view"
                                            >
                                                <i class="ti ti-eye"></i>
                                                View
                                            </a>

                                            <a
                                                href="{{ $fileUrl }}"
                                                download="{{ $fileName }}"
                                                class="btn-file-action btn-download"
                                            >
                                                <i class="ti ti-download"></i>
                                                Download
                                            </a>
                                        </div>

                                    </div>


                                {{-- FILE --}}

                                @elseif($isFile)

                                    <div class="form-file-wrapper form-file-right">

                                        <div class="form-file-info">
                                            <div class="form-file-icon">
                                                <i class="ti ti-file"></i>
                                            </div>

                                            <div class="form-file-name">
                                                {{ $fileName }}
                                            </div>
                                        </div>

                                        <div class="form-file-actions">
                                            <a
                                                href="{{ $fileUrl }}"
                                                download="{{ $fileName }}"
                                                class="btn-file-action btn-download"
                                            >
                                                <i class="ti ti-download"></i>
                                                Download
                                            </a>
                                        </div>

                                    </div>


                                {{-- FIELD BIASA --}}

                                @else

                                    <strong>
                                        {{ $value }}
                                    </strong>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif

            @endforeach

        </div>

    </div>

@endif


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="detail-footer">

            <div>

                <strong>
                    Eventverse
                </strong>

                <span>
                    Event Management & Ticketing
                </span>

            </div>


            <div class="footer-note">
                Transaction information shown on this page is based
                on the completed payment transaction.
            </div>

        </div>

    </div>

</section>


<style>

    .transaction-detail-page {

        font-family: Inter, sans-serif;

        min-height: 100vh;

        padding: 35px 15px 60px;

        background:
            linear-gradient(
                180deg,
                #edf4ff 0%,
                #f7faff 100%
            );

        color: #172033;
    }


    .transaction-detail-container {

        width: 100%;

        max-width: 980px;

        margin: 0 auto;
    }


    /* =====================================================
       ACTION
    ====================================================== */

    .detail-actions {

        display: flex;

        justify-content: flex-end;

        gap: 10px;

        margin-bottom: 16px;
    }


    .btn-primary,
    .btn-secondary {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        padding: 10px 16px;

        border-radius: 8px;

        font-size: 13px;

        font-weight: 600;

        text-decoration: none;

        transition: .2s ease;
    }


    .btn-primary {

        color: #fff;

        background: #2563eb;

        border: 1px solid #2563eb;
    }


    .btn-primary:hover {

        color: #fff;

        background: #1d4ed8;
    }


    .btn-secondary {

        color: #374151;

        background: #fff;

        border: 1px solid #dce2eb;
    }


    .btn-secondary:hover {

        color: #1d4ed8;

        border-color: #bfdbfe;

        background: #f8fbff;
    }


    /* =====================================================
       HEADER
    ====================================================== */

    .transaction-header-card {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        padding: 28px 32px;

        margin-bottom: 18px;

        background: #fff;

        border: 1px solid #e4e9f2;

        border-radius: 14px;

        box-shadow:
            0 12px 35px rgba(24, 48, 88, .06);
    }


    .eyebrow {

        margin-bottom: 7px;

        color: #8993a5;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: .8px;
    }


    .transaction-header-card h1 {

        margin: 0;

        color: #172033;

        font-size: 21px;

        font-weight: 800;

        letter-spacing: -.4px;
    }


    .transaction-date {

        margin-top: 6px;

        color: #8993a5;

        font-size: 11px;
    }


    .transaction-status {

        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 7px 12px;

        color: #15803d;

        background: #ecfdf3;

        border: 1px solid #bbf7d0;

        border-radius: 999px;

        font-size: 10px;

        font-weight: 700;
    }


    .status-dot {

        width: 7px;

        height: 7px;

        border-radius: 50%;

        background: #22c55e;
    }


    /* =====================================================
       CARD
    ====================================================== */

    .detail-card {

        margin-bottom: 18px;

        padding: 24px;

        background: #fff;

        border: 1px solid #e4e9f2;

        border-radius: 12px;

        box-shadow:
            0 8px 25px rgba(24, 48, 88, .04);
    }


    .card-title {

        margin-bottom: 17px;

        color: #273247;

        font-size: 13px;

        font-weight: 700;
    }


    .card-description {

        margin-top: -9px;

        margin-bottom: 17px;

        color: #8993a5;

        font-size: 10px;
    }


    /* =====================================================
       EVENT
    ====================================================== */

    .event-wrapper {

        display: flex;

        align-items: center;

        gap: 18px;
    }


    .event-image {

        width: 110px;

        height: 85px;

        flex: 0 0 110px;

        object-fit: cover;

        border-radius: 9px;

        border: 1px solid #edf0f5;
    }


    .event-content h2 {

        margin: 0 0 10px;

        color: #1d2738;

        font-size: 17px;

        line-height: 1.35;

        font-weight: 700;
    }


    .event-meta {

        display: flex;

        flex-direction: column;

        gap: 7px;

        color: #687386;

        font-size: 11px;
    }


    .event-meta div {

        display: flex;

        align-items: flex-start;

        gap: 8px;
    }


    .event-meta i {

        color: #2563eb;

        font-size: 14px;
    }


    /* =====================================================
       TWO COLUMN
    ====================================================== */

    .two-column {

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 18px;
    }


    /* =====================================================
       DETAIL LIST
    ====================================================== */

    .detail-list {

        display: flex;

        flex-direction: column;
    }


    .detail-row {

        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        gap: 25px;

        padding: 10px 0;

        border-bottom: 1px solid #f0f2f6;

        color: #7a8495;

        font-size: 11px;
    }


    .detail-row:last-child {

        border-bottom: none;

        padding-bottom: 0;
    }


    .detail-row:first-child {

        padding-top: 0;
    }


    .detail-row strong {

        color: #273247;

        font-size: 11px;

        text-align: right;
    }


    .blue-text {

        color: #2563eb !important;
    }


    .paid-text {

        color: #16a34a !important;

        text-transform: uppercase;
    }


    /* =====================================================
       BUYER
    ====================================================== */

    .buyer-name {

        margin-bottom: 15px;

        color: #1d2738;

        font-size: 17px;

        font-weight: 700;
    }


    .buyer-contact {

        display: flex;

        flex-direction: column;

        gap: 10px;

        color: #687386;

        font-size: 11px;
    }


    .buyer-contact div {

        display: flex;

        align-items: center;

        gap: 8px;
    }


    .buyer-contact i {

        color: #2563eb;

        font-size: 14px;
    }


    /* =====================================================
       TICKET
    ====================================================== */

    .ticket-purchase {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        padding: 17px;

        background: #f8fafc;

        border: 1px solid #e7ebf2;

        border-radius: 9px;
    }


    .ticket-name {

        color: #1d2738;

        font-size: 14px;

        font-weight: 700;
    }


    .ticket-type {

        margin-top: 4px;

        color: #929bab;

        font-size: 10px;
    }


    .ticket-quantity {

        display: flex;

        align-items: center;

        gap: 12px;
    }


    .ticket-quantity span {

        color: #8993a5;

        font-size: 10px;
    }


    .ticket-quantity strong {

        display: flex;

        align-items: center;

        justify-content: center;

        min-width: 32px;

        height: 32px;

        border-radius: 7px;

        color: #1d4ed8;

        background: #dbeafe;

        font-size: 12px;
    }


    /* =====================================================
       PRICE
    ====================================================== */

    .price-summary {

        padding: 17px;

        border: 1px solid #e7ebf2;

        border-radius: 9px;

        background: #f8fafc;
    }


    .price-summary > div:first-child {

        display: flex;

        justify-content: space-between;

        gap: 20px;

        color: #697386;

        font-size: 11px;
    }


    .price-summary > div:first-child strong {

        color: #273247;
    }


    .summary-divider {

        height: 1px;

        margin: 14px 0;

        background: #dfe4ec;
    }


    .grand-total {

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 20px;
    }


    .grand-total span {

        color: #273247;

        font-size: 12px;

        font-weight: 700;
    }


    .grand-total strong {

        color: #1d4ed8;

        font-size: 18px;

        font-weight: 800;
    }


    /* =====================================================
       PARTICIPANTS
    ====================================================== */

    .participants-heading {

        margin-bottom: 18px;
    }


    .participants-list {

        border: 1px solid #e7ebf2;

        border-radius: 9px;

        overflow: hidden;
    }


    .participant-item {

        display: grid;

        grid-template-columns: 40px 1fr 190px 90px;

        gap: 15px;

        align-items: center;

        padding: 16px;

        border-bottom: 1px solid #edf0f5;
    }


    .participant-item:last-child {

        border-bottom: none;
    }


    .participant-number {

        color: #9aa4b4;

        font-size: 11px;

        font-weight: 700;
    }


    .participant-name {

        color: #273247;

        font-size: 12px;

        font-weight: 600;
    }


    .participant-email {

        margin-top: 4px;

        color: #9aa4b4;

        font-size: 10px;
    }


    .participant-ticket {

        display: flex;

        flex-direction: column;

        gap: 3px;
    }


    .participant-ticket span {

        color: #9aa4b4;

        font-size: 9px;

        text-transform: uppercase;

        letter-spacing: .5px;
    }


    .participant-ticket strong {

        color: #536075;

        font-family: monospace;

        font-size: 10px;

        word-break: break-all;
    }


    .participant-action {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        padding: 7px 10px;

        color: #2563eb;

        background: #eff6ff;

        border: 1px solid #dbeafe;

        border-radius: 7px;

        font-size: 10px;

        font-weight: 600;

        text-decoration: none;
    }


    .participant-action:hover {

        color: #1d4ed8;

        background: #dbeafe;
    }


    /* =====================================================
       FORMS
    ====================================================== */

    .participant-form-block {

        padding: 16px 0;

        border-bottom: 1px solid #edf0f5;
    }


    .participant-form-block:first-child {

        padding-top: 0;
    }


    .participant-form-block:last-child {

        padding-bottom: 0;

        border-bottom: none;
    }


    .form-participant-name {

        margin-bottom: 10px;

        color: #273247;

        font-size: 12px;

        font-weight: 700;
    }


    .form-row {

        display: flex;

        justify-content: space-between;

        gap: 30px;

        padding: 7px 0;

        color: #7a8495;

        font-size: 10px;
    }


    .form-row strong {

        max-width: 60%;

        color: #374151;

        text-align: right;

        word-break: break-word;
    }


    /* =====================================================
       FOOTER
    ====================================================== */

    .detail-footer {

        display: flex;

        justify-content: space-between;

        gap: 30px;

        padding: 10px 5px 0;

        color: #8b95a5;

        font-size: 9px;
    }


    .detail-footer > div:first-child {

        display: flex;

        flex-direction: column;

        gap: 3px;
    }


    .detail-footer strong {

        color: #4b5563;

        font-size: 10px;
    }


    .footer-note {

        max-width: 400px;

        text-align: right;

        line-height: 1.5;
    }

    .form-empty {
        color: #9ca3af;
    }

    .form-file-image {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .form-image-preview {
        display: block;
        width: 90px;
        height: 65px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: #f3f4f6;
    }

    .form-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .form-file-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-file-download {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .form-file-icon {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        flex-shrink: 0;
    }

    .form-file-name {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #374151;
        font-size: 13px;
    }

    @media (max-width: 768px) {

        .form-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .form-file-download {
            width: 100%;
        }

        .form-file-download .participant-action {
            margin-left: auto;
        }

    }

    /* =====================================================
   FORM FILE & IMAGE - ENHANCED
====================================================== */

.form-file-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    max-width: 100%;
}

/* Khusus untuk image agar tetap proporsional */
.form-file-wrapper.form-file-right {
    align-items: flex-end;
}

/* PREVIEW IMAGE */
.form-file-preview {
    width: 120px;
    height: 90px;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid #e5e9f0;
    background: #f8fafc;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: border-color 0.2s;
    flex-shrink: 0;
}

.form-file-preview:hover {
    border-color: #2563eb;
}

.form-file-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* FILE INFO */
.form-file-info {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 14px 8px 10px;
    background: #f8fafc;
    border: 1px solid #e5e9f0;
    border-radius: 8px;
    min-width: 200px;
    max-width: 100%;
}

.form-file-icon {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    flex-shrink: 0;
    font-size: 16px;
}

.form-file-name {
    color: #1d2738;
    font-size: 12px;
    font-weight: 500;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* MODERN BUTTON ACTIONS */
.form-file-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.btn-file-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
    border: 1px solid transparent;
}

.btn-file-action i {
    font-size: 14px;
}

/* Button View */
.btn-view {
    color: #1d4ed8;
    background: #eff6ff;
    border-color: #bfdbfe;
}

.btn-view:hover {
    color: #1e40af;
    background: #dbeafe;
    border-color: #93c5fd;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
}

/* Button Download */
.btn-download {
    color: #065f46;
    background: #ecfdf5;
    border-color: #a7f3d0;
}

.btn-download:hover {
    color: #047857;
    background: #d1fae5;
    border-color: #6ee7b7;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .form-row strong {
        max-width: 100%;
        text-align: left;
    }

    .form-file-wrapper {
        width: 100%;
        align-items: flex-start !important;
    }

    .form-file-preview {
        width: 100%;
        height: 140px;
    }

    .form-file-info {
        width: 100%;
        min-width: unset;
    }

    .form-file-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .btn-file-action {
        flex: 1;
        min-width: 80px;
    }
}


    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 768px) {

        .transaction-detail-page {

            padding: 20px 10px 40px;
        }


        .detail-actions {

            justify-content: stretch;

            flex-direction: column-reverse;
        }


        .btn-primary,
        .btn-secondary {

            width: 100%;
        }


        .transaction-header-card {

            align-items: flex-start;

            flex-direction: column;

            padding: 22px;
        }


        .detail-card {

            padding: 20px;
        }


        .two-column {

            grid-template-columns: 1fr;
        }


        .event-wrapper {

            align-items: flex-start;

            flex-direction: column;
        }


        .event-image {

            width: 100%;

            height: 160px;

            flex-basis: auto;
        }


        .participant-item {

            grid-template-columns: 30px 1fr;

            gap: 10px;
        }


        .participant-ticket,
        .participant-item > div:last-child {

            grid-column: 2;
        }


        .participant-ticket {

            margin-top: 3px;
        }


        .detail-footer {

            flex-direction: column;
        }


        .footer-note {

            max-width: none;

            text-align: left;
        }

    }

</style>

@endsection