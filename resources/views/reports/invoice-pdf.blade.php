<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Invoice {{ $transaction->invoice_number }}</title>

    <style>
       @page {
            size: A4;
            margin: 10mm;
        }

        .page {
            padding: 20px 25px;
            overflow: hidden;
        }

        table {
            table-layout: fixed;
            word-wrap: break-word;
        }

        .header-left, .header-right {
            width: 50%;
        }

        .invoice-title {
            font-size: 22px;
        }
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #1f2937;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
        }



        /* =========================
           HEADER
        ========================= */

        .invoice-header {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 22px;
            margin-bottom: 24px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 60%;
            vertical-align: top;
        }

        .header-right {
            width: 40%;
            text-align: right;
            vertical-align: top;
        }

        .invoice-logo {
            display: block;
            width: 155px;
            height: auto;
            max-height: 55px;
        }

        .company-info {
            margin-top: 10px;
            color: #6b7280;
            font-size: 9px;
            line-height: 1.5;
        }

        .invoice-title {
            margin: 0;
            color: #111827;
            font-size: 27px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .invoice-number {
            margin-top: 5px;
            color: #2563eb;
            font-size: 11px;
            font-weight: bold;
        }

        /* =========================
           META
        ========================= */

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .meta-table td {
            width: 33.33%;
            vertical-align: top;
            padding: 0 10px 0 0;
        }

        .meta-label {
            color: #6b7280;
            font-size: 9px;
            margin-bottom: 3px;
        }

        .meta-value {
            color: #111827;
            font-size: 10px;
            font-weight: bold;
        }

        /* =========================
           INFO
        ========================= */

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-box {
            width: 50%;
            vertical-align: top;
            padding: 14px 15px;
            border: 1px solid #e5e7eb;
        }

        .info-box:first-child {
            border-right: none;
        }

        .section-label {
            color: #6b7280;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 7px;
        }

        .event-name {
            color: #111827;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .info-text {
            color: #4b5563;
            font-size: 9.5px;
            line-height: 1.6;
        }

        /* =========================
           PURCHASE TABLE
        ========================= */

        .purchase-title {
            color: #111827;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .purchase-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .purchase-table thead th {
            background: #f3f4f6;
            border-top: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
            padding: 9px 10px;
            color: #374151;
            font-size: 9px;
            font-weight: bold;
            text-align: left;
        }

        .purchase-table tbody td {
            border-bottom: 1px solid #e5e7eb;
            padding: 11px 10px;
            color: #374151;
            font-size: 10px;
            vertical-align: top;
        }

        .purchase-table .qty {
            width: 12%;
            text-align: center;
        }

        .purchase-table .amount {
            width: 25%;
            text-align: right;
        }

        .ticket-name {
            color: #111827;
            font-weight: bold;
        }

        .ticket-description {
            margin-top: 3px;
            color: #6b7280;
            font-size: 8.5px;
        }

        /* =========================
           TOTAL
        ========================= */

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .payment-info {
            width: 55%;
            vertical-align: top;
            padding-right: 25px;
        }

        .total-info {
            width: 45%;
            vertical-align: top;
        }

        .payment-box {
            border: 1px solid #e5e7eb;
            padding: 13px 15px;
        }

        .payment-row {
            margin-bottom: 6px;
        }

        .payment-label {
            display: inline-block;
            width: 105px;
            color: #6b7280;
            font-size: 9px;
        }

        .payment-value {
            color: #111827;
            font-size: 9.5px;
            font-weight: bold;
        }

        .total-table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 5px 0;
            font-size: 10px;
        }

        .total-label {
            color: #6b7280;
            text-align: left;
        }

        .total-value {
            color: #374151;
            text-align: right;
        }

        .grand-total td {
            border-top: 2px solid #111827;
            padding-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .grand-total .total-label {
            color: #111827;
        }

        .grand-total .total-value {
            color: #00af69;
        }

        /* =========================
           PARTICIPANTS
        ========================= */

        .participants-section {
            margin-top: 5px;
        }

        .participants-title {
            color: #111827;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .participants-table {
            width: 100%;
            border-collapse: collapse;
        }

        .participants-table th {
            background: #f3f4f6;
            border-top: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
            padding: 8px 9px;
            color: #374151;
            font-size: 8.5px;
            font-weight: bold;
            text-align: left;
        }

        .participants-table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 9px;
            color: #4b5563;
            font-size: 9px;
            vertical-align: top;
        }

        .participant-name {
            color: #111827;
            font-weight: bold;
        }

        .ticket-code {
            color: #2563eb;
            font-size: 8.5px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 35px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 8.5px;
            line-height: 1.6;
        }

        .footer strong {
            color: #6b7280;
        }

        .status-paid {
            display: inline-block;
            padding: 3px 8px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            font-size: 8px;
            font-weight: bold;
        }
    </style>
</head>

<body>

@php
    $invoiceDate = $transaction->invoice_issued_at
        ? date('d M Y', strtotime($transaction->invoice_issued_at))
        : date('d M Y', strtotime($transaction->created_at));

    $totalParticipants = $transaction->participants->count();

    $paymentStatus = strtoupper($transaction->status ?? 'PAID');

    $subtotal = (float) ($transaction->subtotal ?? 0);
    $grandTotal = (float) ($transaction->grand_total ?? $subtotal);

    $ticketQuantity = $transaction->ticket_quantity
        ?? $transaction->quantity
        ?? $totalParticipants
        ?? 1;
@endphp

<div class="page">

    {{-- =========================
         HEADER
    ========================== --}}
    <div class="invoice-header">

        <table class="header-table">
            <tr>

                <td class="header-left">

                    <img
                        src="{{ public_path('assets/img/eventverse-color.png') }}"
                        class="invoice-logo"
                        alt="Eventverse"
                    >

                    <div class="company-info">
                        Platform Ticketing &amp; Event Management
                    </div>

                </td>

                <td class="header-right">

                    <div class="invoice-title">
                        INVOICE
                    </div>

                    <div class="invoice-number">
                        {{ $transaction->invoice_number }}
                    </div>

                </td>

            </tr>
        </table>

    </div>


    {{-- =========================
         INVOICE META
    ========================== --}}
    <table class="meta-table">
        <tr>

            <td>
                <div class="meta-label">
                    Invoice Date
                </div>

                <div class="meta-value">
                    {{ $invoiceDate }}
                </div>
            </td>

            <td>
                <div class="meta-label">
                    Transaction Number
                </div>

                <div class="meta-value">
                    {{ $transaction->transaction_code }}
                </div>
            </td>

            <td>
                <div class="meta-label">
                    Payment Status
                </div>

                <div class="meta-value">
                    <span class="status-paid">
                        {{ $paymentStatus }}
                    </span>
                </div>
            </td>

        </tr>
    </table>


    {{-- =========================
         EVENT + BILL TO
    ========================== --}}
    <table class="info-table">

        <tr>

            <td class="info-box">

                <div class="section-label">
                    Event
                </div>

                <div class="event-name">
                    {{ $event->title ?? '-' }}
                </div>

                <div class="info-text">

                    @if(!empty($event->start_date))
                        {{ date('d M Y', strtotime($event->start_date)) }}

                        @if(!empty($event->end_date))
                            -
                            {{ date('d M Y', strtotime($event->end_date)) }}
                        @endif

                        <br>
                    @endif

                    {{ $event->location ?? '' }}

                </div>

            </td>


            <td class="info-box">

                <div class="section-label">
                    Billed To
                </div>

                <div class="event-name">
                    {{ $transaction->buyer_name ?? '-' }}
                </div>

                <div class="info-text">

                    {{ $transaction->buyer_email ?? '-' }}

                    @if(!empty($transaction->buyer_phone))
                        <br>
                        {{ $transaction->buyer_phone }}
                    @endif

                </div>

            </td>

        </tr>

    </table>


    {{-- =========================
         PURCHASE DETAILS
    ========================== --}}
    <div class="purchase-title">
        Purchase Details
    </div>

    <table class="purchase-table">

        <thead>
            <tr>
                <th>
                    Description
                </th>

                <th class="qty">
                    Qty
                </th>

                <th class="amount">
                    Amount
                </th>
            </tr>
        </thead>

        <tbody>

            <tr>

                <td>

                    <div class="ticket-name">
                        {{ $ticket->ticket_name ?? 'Ticket' }}
                    </div>

                    @if(!empty($ticket->description))
                        <div class="ticket-description">
                            {{ $ticket->description }}
                        </div>
                    @endif

                </td>

                <td class="qty">
                    {{ $ticketQuantity }}
                </td>

                <td class="amount">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </td>

            </tr>

        </tbody>

    </table>


    {{-- =========================
         PAYMENT + TOTAL
    ========================== --}}
    <table class="summary-table">

        <tr>

            <td class="payment-info">

                <div class="payment-box">

                    <div class="section-label">
                        Payment Information
                    </div>

                    <div class="payment-row">
                        <span class="payment-label">
                            Payment Method
                        </span>

                        <span class="payment-value">
                            {{ $transaction->paymentGatewayMethod?->method?->name ?? '-' }}
                        </span>
                    </div>

                    <div class="payment-row">
                        <span class="payment-label">
                            Payment Status
                        </span>

                        <span class="payment-value">
                            {{ $paymentStatus }}
                        </span>
                    </div>

                </div>

            </td>


            <td class="total-info">

                <table class="total-table">

                    <tr>
                        <td class="total-label">
                            Subtotal
                        </td>

                        <td class="total-value">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </td>
                    </tr>

                    @php
                        $additionalFee = $grandTotal - $subtotal;
                    @endphp

                    @if($additionalFee > 0)

                        <tr>
                            <td class="total-label">
                                Additional Fee
                            </td>

                            <td class="total-value">
                                Rp {{ number_format($additionalFee, 0, ',', '.') }}
                            </td>
                        </tr>

                    @endif

                    <tr class="grand-total">

                        <td class="total-label">
                            Total
                        </td>

                        <td class="total-value">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>


    {{-- =========================
         PARTICIPANTS
    ========================== --}}
    @if($transaction->participants->count())

        <div class="participants-section">

            <div class="participants-title">
                Participant Details
            </div>

            <table class="participants-table">

                <thead>
                    <tr>

                        <th style="width: 6%;">
                            No.
                        </th>

                        <th style="width: 34%;">
                            Participant
                        </th>

                        <th style="width: 32%;">
                            Email
                        </th>

                        <th style="width: 28%;">
                            Ticket Code
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @foreach($transaction->participants as $index => $participant)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <span class="participant-name">
                                    {{ $participant->name ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $participant->email ?? '-' }}
                            </td>

                            <td>
                                <span class="ticket-code">
                                    {{ $participant->ticket_code ?? '-' }}
                                </span>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif


    {{-- =========================
         FOOTER
    ========================== --}}
    <div class="footer">

        <strong>Eventverse.id</strong>
        <br>

        This invoice is electronically generated and does not require a signature.

        <br>

        Thank you for your purchase.

    </div>

</div>

</body>
</html>