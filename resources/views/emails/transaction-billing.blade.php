<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Billing Transaksi - Eventverse.id</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f4f5;
    font-family: Arial, Helvetica, sans-serif;
    color: #18181b;
">

    @php
        $transactionUrl = url('/transaction/' . $transaction->transaction_code);
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
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
                        border-radius: 12px;
                        overflow: hidden;
                    "
                >

                    {{-- Header --}}
                    <tr>
                        <td style="padding: 28px 32px; border-bottom: 1px solid #e4e4e7;">

                            <a
                                href="https://eventverse.id"
                                style="
                                    text-decoration: none;
                                    font-size: 18px;
                                    font-weight: 700;
                                    color: #53b6fc;
                                "
                            >
                                Eventverse.id
                            </a>

                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding: 32px;">

                            <h1 style="
                                margin: 0 0 10px;
                                font-size: 24px;
                                line-height: 1.3;
                            ">
                                Menunggu Pembayaran
                            </h1>

                            <p style="
                                margin: 0 0 25px;
                                color: #52525b;
                                font-size: 14px;
                                line-height: 1.7;
                            ">
                                Halo {{ $transaction->buyer_name }},
                                <br>
                                Pesanan tiket Anda telah berhasil dibuat.
                                Silakan selesaikan pembayaran sebelum batas waktu yang ditentukan.
                            </p>

                            {{-- Transaction Code --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="
                                        background-color: #fafafa;
                                        border: 1px solid #e4e4e7;
                                        border-radius: 8px;
                                        padding: 18px;
                                    ">

                                        <div style="
                                            color: #71717a;
                                            font-size: 12px;
                                            margin-bottom: 6px;
                                        ">
                                            Nomor Transaksi
                                        </div>

                                        <div style="
                                            font-size: 16px;
                                            font-weight: 700;
                                            letter-spacing: 0.5px;
                                        ">
                                            {{ $transaction->transaction_code }}
                                        </div>

                                    </td>
                                </tr>
                            </table>

                            {{-- Event --}}
                            <div style="margin-top: 25px;">

                                <div style="
                                    color: #71717a;
                                    font-size: 12px;
                                    margin-bottom: 6px;
                                ">
                                    Event
                                </div>

                                <div style="
                                    font-size: 16px;
                                    font-weight: 700;
                                ">
                                    {{ $transaction->event->title ?? '-' }}
                                </div>

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
                                        padding: 15px 0;
                                        border-bottom: 1px solid #e4e4e7;
                                    ">

                                        <div style="
                                            font-size: 14px;
                                            font-weight: 600;
                                        ">
                                            {{ $transaction->ticket->ticket_name ?? '-' }}
                                        </div>

                                        <div style="
                                            margin-top: 5px;
                                            color: #71717a;
                                            font-size: 13px;
                                        ">
                                            {{ $transaction->quantity }} tiket
                                        </div>

                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding: 15px 0;
                                            border-bottom: 1px solid #e4e4e7;
                                            font-size: 14px;
                                            font-weight: 600;
                                        "
                                    >
                                        Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>

                            {{-- Fees --}}
                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                style="margin-top: 15px;"
                            >

                                <tr>
                                    <td style="
                                        padding: 5px 0;
                                        color: #71717a;
                                        font-size: 13px;
                                    ">
                                        Platform Fee
                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding: 5px 0;
                                            font-size: 13px;
                                        "
                                    >
                                        Rp {{ number_format($transaction->platform_fee, 0, ',', '.') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="
                                        padding: 5px 0;
                                        color: #71717a;
                                        font-size: 13px;
                                    ">
                                        Payment Fee
                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding: 5px 0;
                                            font-size: 13px;
                                        "
                                    >
                                        Rp {{ number_format($transaction->payment_fee, 0, ',', '.') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="
                                        padding: 15px 0 5px;
                                        border-top: 1px solid #e4e4e7;
                                        font-size: 15px;
                                        font-weight: 700;
                                    ">
                                        Total Pembayaran
                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding: 15px 0 5px;
                                            border-top: 1px solid #e4e4e7;
                                            font-size: 18px;
                                            font-weight: 700;
                                        "
                                    >
                                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                    </td>
                                </tr>

                            </table>

                            {{-- Expired --}}
                            @if ($transaction->expired_at)
                                <div style="
                                    margin-top: 25px;
                                    padding: 15px;
                                    background-color: #fff7ed;
                                    border: 1px solid #fed7aa;
                                    border-radius: 8px;
                                ">

                                    <div style="
                                        font-size: 12px;
                                        color: #9a3412;
                                        margin-bottom: 5px;
                                    ">
                                        Batas Pembayaran
                                    </div>

                                    <div style="
                                        font-size: 14px;
                                        font-weight: 700;
                                        color: #7c2d12;
                                    ">
                                        {{ $transaction->expired_at->format('d M Y, H:i') }} WIB
                                    </div>

                                </div>
                            @endif

                            {{-- Button --}}
                            <div style="
                                margin-top: 30px;
                                text-align: center;
                            ">

                                <a
                                    href="{{ $transactionUrl }}"
                                    style="
                                        display: inline-block;
                                        padding: 14px 28px;
                                        background-color: #18181b;
                                        color: #ffffff;
                                        text-decoration: none;
                                        font-size: 14px;
                                        font-weight: 700;
                                        border-radius: 7px;
                                    "
                                >
                                    Lanjutkan Pembayaran
                                </a>

                            </div>

                            {{-- Alternative Link --}}
                            <p style="
                                margin: 22px 0 0;
                                color: #71717a;
                                font-size: 12px;
                                line-height: 1.6;
                                text-align: center;
                            ">
                                Jika tombol di atas tidak dapat digunakan, buka halaman transaksi melalui:
                                <br>
                                <a
                                    href="{{ $transactionUrl }}"
                                    style="
                                        color: #18181b;
                                        word-break: break-all;
                                    "
                                >
                                    {{ $transactionUrl }}
                                </a>
                            </p>

                            <p style="
                                margin: 28px 0 0;
                                padding-top: 20px;
                                border-top: 1px solid #e4e4e7;
                                color: #71717a;
                                font-size: 12px;
                                line-height: 1.7;
                            ">
                                Jika Anda merasa tidak melakukan transaksi ini,
                                Anda dapat mengabaikan email ini.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="
                            padding: 24px 32px;
                            background-color: #fafafa;
                            border-top: 1px solid #e4e4e7;
                            text-align: center;
                        ">

                            <a
                                href="https://eventverse.id"
                                style="
                                    color: #18181b;
                                    font-size: 13px;
                                    font-weight: 700;
                                    text-decoration: none;
                                "
                            >
                                eventverse.id
                            </a>

                            <p style="
                                margin: 8px 0 0;
                                color: #a1a1aa;
                                font-size: 11px;
                            ">
                                Email ini dikirim secara otomatis oleh Eventverse.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
```
