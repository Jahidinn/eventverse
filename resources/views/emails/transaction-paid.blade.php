<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran Berhasil - Eventverse.id</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f5f7fb;
    font-family: Arial, Helvetica, sans-serif;
    color: #18181b;
">

@php
    $ticketUrl = url('/transaction/' . $transaction->transaction_code . '/ticket');
@endphp

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="background-color: #f5f7fb;"
>
    <tr>
        <td align="center" style="padding: 40px 15px;">

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    max-width: 600px;
                    background-color: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    border: 1px solid #e5e7eb;
                "
            >

                {{-- =====================================================
                    HEADER
                ====================================================== --}}
                <tr>
                    <td style="
                        padding: 26px 32px;
                        border-bottom: 1px solid #eef0f4;
                    ">

                        <a
                            href="{{ url('/') }}"
                            style="
                                color: #60a5fa;
                                text-decoration: none;
                                font-size: 22px;
                                font-weight: 800;
                                letter-spacing: -0.5px;
                            "
                        >
                            Eventverse.id
                        </a>

                    </td>
                </tr>


                {{-- =====================================================
                    SUCCESS HEADER
                ====================================================== --}}
                <tr>
                    <td align="center" style="padding: 40px 32px 25px;">

                        {{-- Green Check --}}
                        <table
                            width="72"
                            height="72"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                width: 72px;
                                height: 72px;
                                background-color: #dcfce7;
                                border-radius: 50%;
                                margin: 0 auto 20px;
                            "
                        >
                            <tr>
                                <td
                                    align="center"
                                    valign="middle"
                                    style="
                                        color: #16a34a;
                                        font-size: 36px;
                                        font-weight: 700;
                                    "
                                >
                                    ✓
                                </td>
                            </tr>
                        </table>

                        <h1 style="
                            margin: 0;
                            color: #18181b;
                            font-size: 26px;
                            line-height: 1.3;
                            font-weight: 800;
                            letter-spacing: -0.4px;
                        ">
                            Pembayaran Berhasil
                        </h1>

                        <p style="
                            margin: 10px 0 0;
                            color: #71717a;
                            font-size: 14px;
                            line-height: 1.6;
                        ">
                            Pembayaran Anda telah berhasil diterima.
                        </p>

                    </td>
                </tr>


                {{-- =====================================================
                    CONTENT
                ====================================================== --}}
                <tr>
                    <td style="padding: 0 32px 35px;">

                        <p style="
                            margin: 0 0 25px;
                            color: #3f3f46;
                            font-size: 14px;
                            line-height: 1.7;
                        ">
                            Halo <strong>{{ $transaction->buyer_name }}</strong>,
                            <br><br>
                            Terima kasih telah melakukan pembayaran melalui Eventverse.
                            Pesanan Anda telah dikonfirmasi dan e-ticket Anda sudah tersedia.
                        </p>


                        {{-- =================================================
                            TRANSACTION CARD
                        ================================================== --}}
                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                border: 1px solid #e5e7eb;
                                border-radius: 12px;
                                overflow: hidden;
                            "
                        >

                            {{-- Card Header --}}
                            <tr>
                                <td style="
                                    padding: 18px 20px;
                                    background-color: #f8fafc;
                                    border-bottom: 1px solid #e5e7eb;
                                ">

                                    <table
                                        width="100%"
                                        cellpadding="0"
                                        cellspacing="0"
                                        border="0"
                                    >
                                        <tr>

                                            <td>
                                                <div style="
                                                    color: #71717a;
                                                    font-size: 11px;
                                                    text-transform: uppercase;
                                                    letter-spacing: 0.7px;
                                                    margin-bottom: 5px;
                                                ">
                                                    Nomor Transaksi
                                                </div>

                                                <div style="
                                                    color: #18181b;
                                                    font-size: 15px;
                                                    font-weight: 700;
                                                    letter-spacing: 0.3px;
                                                ">
                                                    {{ $transaction->transaction_code }}
                                                </div>
                                            </td>

                                            <td align="right" valign="middle">

                                                <span style="
                                                    display: inline-block;
                                                    padding: 6px 10px;
                                                    background-color: #dcfce7;
                                                    color: #15803d;
                                                    border-radius: 999px;
                                                    font-size: 11px;
                                                    font-weight: 700;
                                                ">
                                                    PAID
                                                </span>

                                            </td>

                                        </tr>
                                    </table>

                                </td>
                            </tr>


                            {{-- Card Body --}}
                            <tr>
                                <td style="padding: 20px;">

                                    {{-- Event --}}
                                    <div style="
                                        color: #71717a;
                                        font-size: 11px;
                                        text-transform: uppercase;
                                        letter-spacing: 0.6px;
                                        margin-bottom: 6px;
                                    ">
                                        Event
                                    </div>

                                    <div style="
                                        color: #18181b;
                                        font-size: 16px;
                                        font-weight: 700;
                                        line-height: 1.4;
                                    ">
                                        {{ $transaction->event->title ?? '-' }}
                                    </div>


                                    {{-- Ticket --}}
                                    <table
                                        width="100%"
                                        cellpadding="0"
                                        cellspacing="0"
                                        border="0"
                                        style="margin-top: 20px;"
                                    >
                                        <tr>

                                            <td style="
                                                padding: 14px 0;
                                                border-top: 1px solid #eef0f4;
                                            ">

                                                <div style="
                                                    color: #18181b;
                                                    font-size: 14px;
                                                    font-weight: 700;
                                                ">
                                                    {{ $transaction->ticket->ticket_name ?? '-' }}
                                                </div>

                                                <div style="
                                                    margin-top: 5px;
                                                    color: #71717a;
                                                    font-size: 12px;
                                                ">
                                                    {{ $transaction->quantity }} tiket
                                                </div>

                                            </td>

                                            <td
                                                align="right"
                                                valign="top"
                                                style="
                                                    padding: 14px 0;
                                                    border-top: 1px solid #eef0f4;
                                                    color: #18181b;
                                                    font-size: 14px;
                                                    font-weight: 700;
                                                "
                                            >
                                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                            </td>

                                        </tr>
                                    </table>


                                    {{-- Paid At --}}
                                    @if ($transaction->paid_at)

                                        <div style="
                                            margin-top: 4px;
                                            padding-top: 15px;
                                            border-top: 1px solid #eef0f4;
                                        ">

                                            <span style="
                                                color: #71717a;
                                                font-size: 12px;
                                            ">
                                                Pembayaran diterima
                                            </span>

                                            <br>

                                            <strong style="
                                                display: inline-block;
                                                margin-top: 4px;
                                                color: #3f3f46;
                                                font-size: 13px;
                                            ">
                                                {{ $transaction->paid_at->format('d M Y, H:i') }} WIB
                                            </strong>

                                        </div>

                                    @endif

                                </td>
                            </tr>


                            {{-- Total --}}
                            <tr>
                                <td style="
                                    padding: 18px 20px;
                                    background-color: #fafafa;
                                    border-top: 1px solid #e5e7eb;
                                ">

                                    <table
                                        width="100%"
                                        cellpadding="0"
                                        cellspacing="0"
                                        border="0"
                                    >
                                        <tr>

                                            <td style="
                                                color: #52525b;
                                                font-size: 13px;
                                                font-weight: 600;
                                            ">
                                                Total Pembayaran
                                            </td>

                                            <td
                                                align="right"
                                                style="
                                                    color: #18181b;
                                                    font-size: 18px;
                                                    font-weight: 800;
                                                "
                                            >
                                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                            </td>

                                        </tr>
                                    </table>

                                </td>
                            </tr>

                        </table>


                        {{-- =================================================
                            TICKET CTA
                        ================================================== --}}
                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="margin-top: 28px;"
                        >
                            <tr>
                                <td align="center">

                                    <a
                                        href="{{ $ticketUrl }}"
                                        style="
                                            display: inline-block;
                                            padding: 15px 32px;
                                            background-color: #60a5fa;
                                            color: #ffffff;
                                            text-decoration: none;
                                            font-size: 14px;
                                            font-weight: 700;
                                            border-radius: 8px;
                                        "
                                    >
                                        Lihat E-Ticket
                                    </a>

                                </td>
                            </tr>
                        </table>


                        {{-- Alternative URL --}}
                        <p style="
                            margin: 20px 0 0;
                            color: #a1a1aa;
                            font-size: 11px;
                            line-height: 1.7;
                            text-align: center;
                        ">
                            Jika tombol tidak dapat digunakan, buka:
                            <br>

                            <a
                                href="{{ $ticketUrl }}"
                                style="
                                    color: #60a5fa;
                                    text-decoration: none;
                                    word-break: break-all;
                                "
                            >
                                {{ $ticketUrl }}
                            </a>
                        </p>


                        {{-- Notice --}}
                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="margin-top: 28px;"
                        >
                            <tr>
                                <td style="
                                    padding: 15px 16px;
                                    background-color: #f0f7ff;
                                    border: 1px solid #dbeafe;
                                    border-radius: 8px;
                                ">

                                    <div style="
                                        color: #3f3f46;
                                        font-size: 12px;
                                        line-height: 1.7;
                                    ">
                                        <strong style="color: #2563eb;">
                                            Simpan email ini
                                        </strong>
                                        sebagai bukti pembayaran dan akses e-ticket Anda.
                                    </div>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>


                {{-- =====================================================
                    FOOTER
                ====================================================== --}}
                <tr>
                    <td
                        align="center"
                        style="
                            padding: 24px 32px;
                            background-color: #f8fafc;
                            border-top: 1px solid #eef0f4;
                        "
                    >

                        <a
                            href="{{ url('/') }}"
                            style="
                                color: #60a5fa;
                                text-decoration: none;
                                font-size: 14px;
                                font-weight: 800;
                            "
                        >
                            eventverse.id
                        </a>

                        <p style="
                            margin: 8px 0 0;
                            color: #a1a1aa;
                            font-size: 11px;
                            line-height: 1.5;
                        ">
                            Email ini dikirim secara otomatis oleh Eventverse.
                            <br>
                            Jangan membalas email ini.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>