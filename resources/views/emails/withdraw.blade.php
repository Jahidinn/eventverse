<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Penarikan - Eventverse.id</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f4f5;
    font-family: Arial, Helvetica, sans-serif;
    color: #18181b;
">

    @php
        $isSuccess = $withdraw->status === 'Sukses';
        $statusColor = $isSuccess ? '#16a34a' : '#dc2626';
        $statusBg    = $isSuccess ? '#ecfdf5' : '#fef2f2';
        $statusBorder = $isSuccess ? '#a7f3d0' : '#fecaca';
        $statusText  = $isSuccess ? 'BERHASIL' : 'GAGAL';
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
                                    color: #2282ff;
                                "
                            >
                                Eventverse.id
                            </a>
                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding: 32px;">

                            {{-- Title --}}
                            <h1 style="
                                margin: 0 0 10px;
                                font-size: 24px;
                                line-height: 1.3;
                            ">
                                Informasi Penarikan Dana
                            </h1>

                            <p style="
                                margin: 0 0 25px;
                                color: #52525b;
                                font-size: 14px;
                                line-height: 1.7;
                            ">
                                Halo {{ $withdraw->user->name }},
                                <br>
                                @if($isSuccess)
                                    Berita baik! Penarikan dana Anda telah <strong>berhasil</strong> diproses
                                    dan dana sudah dikirim ke rekening tujuan.
                                @else
                                    Mohon maaf, penarikan dana Anda <strong>gagal</strong> diproses.
                                    Silakan periksa detail di bawah untuk informasi lebih lanjut.
                                @endif
                            </p>

                            {{-- Amount Highlight --}}
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
                                            Jumlah Penarikan
                                        </div>
                                        <div style="
                                            font-size: 22px;
                                            font-weight: 700;
                                            color: #18181b;
                                        ">
                                            Rp {{ number_format($withdraw->amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- Detail Transaksi --}}
                            <div style="margin-top: 25px;">
                                <div style="
                                    color: #71717a;
                                    font-size: 12px;
                                    margin-bottom: 10px;
                                ">
                                    Detail Transaksi
                                </div>

                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                >
                                    {{-- Nomor Rekening --}}
                                    <tr>
                                        <td style="
                                            padding: 12px 0;
                                            border-bottom: 1px solid #e4e4e7;
                                            color: #71717a;
                                            font-size: 13px;
                                        ">
                                            Nomor Rekening
                                        </td>
                                        <td
                                            align="right"
                                            style="
                                                padding: 12px 0;
                                                border-bottom: 1px solid #e4e4e7;
                                                font-size: 14px;
                                                font-weight: 600;
                                            "
                                        >
                                            {{ $withdraw->rekening }}
                                        </td>
                                    </tr>

                                    {{-- Status --}}
                                    <tr>
                                        <td style="
                                            padding: 12px 0;
                                            border-bottom: 1px solid #e4e4e7;
                                            color: #71717a;
                                            font-size: 13px;
                                        ">
                                            Status
                                        </td>
                                        <td
                                            align="right"
                                            style="
                                                padding: 12px 0;
                                                border-bottom: 1px solid #e4e4e7;
                                                font-size: 13px;
                                                font-weight: 700;
                                                color: {{ $statusColor }};
                                                letter-spacing: 0.5px;
                                            "
                                        >
                                            {{ $statusText }}
                                        </td>
                                    </tr>

                                    {{-- Catatan (khusus gagal) --}}
                                    @if(!$isSuccess && $withdraw->catatan)
                                        <tr>
                                            <td
                                                colspan="2"
                                                style="
                                                    padding: 12px 0;
                                                    border-bottom: 1px solid #e4e4e7;
                                                    color: #71717a;
                                                    font-size: 13px;
                                                "
                                            >
                                                Catatan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                colspan="2"
                                                style="
                                                    padding: 0 0 12px;
                                                    border-bottom: 1px solid #e4e4e7;
                                                    font-size: 13px;
                                                    color: #dc2626;
                                                    font-weight: 600;
                                                "
                                            >
                                                {{ $withdraw->catatan }}
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            {{-- Status Box --}}
                            <div style="
                                margin-top: 25px;
                                padding: 15px;
                                background-color: {{ $statusBg }};
                                border: 1px solid {{ $statusBorder }};
                                border-radius: 8px;
                            ">
                                <div style="
                                    font-size: 12px;
                                    color: #71717a;
                                    margin-bottom: 5px;
                                ">
                                    Status Penarikan
                                </div>
                                <div style="
                                    font-size: 14px;
                                    font-weight: 700;
                                    color: {{ $statusColor }};
                                ">
                                    @if($isSuccess)
                                        Dana berhasil dikirim ke rekening Anda
                                    @else
                                        Penarikan dana tidak dapat diproses
                                    @endif
                                </div>
                            </div>

                            {{-- Support Note --}}
                            <p style="
                                margin: 28px 0 0;
                                padding-top: 20px;
                                border-top: 1px solid #e4e4e7;
                                color: #71717a;
                                font-size: 12px;
                                line-height: 1.7;
                            ">
                                Jika Anda memiliki pertanyaan atau kekhawatiran lebih lanjut,
                                silakan hubungi tim dukungan kami di
                                <a
                                    href="mailto:info@eventverse.id"
                                    style="color: #2282ff; text-decoration: none; font-weight: 600;"
                                >
                                    info@eventverse.id
                                </a>
                            </p>

                            <p style="
                                margin: 15px 0 0;
                                color: #52525b;
                                font-size: 13px;
                            ">
                                Have a nice day!
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
                            <img
                                src="{{ $message->embed(public_path() . '/assets/img/eventverse-color.png') }}"
                                alt="Eventverse"
                                style="height: 36px; margin-bottom: 12px;"
                            >

                            <p style="
                                margin: 0;
                                color: #18181b;
                                font-size: 13px;
                                font-weight: 700;
                            ">
                                eventverse.id
                            </p>

                            <p style="
                                margin: 8px 0 0;
                                color: #a1a1aa;
                                font-size: 11px;
                                line-height: 1.6;
                            ">
                                Email ini dikirim secara otomatis oleh Eventverse.<br>
                                &copy; {{ date('Y') }} Eventverse.id
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>