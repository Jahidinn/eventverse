<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Eventverse.id</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f5f7fb;
    font-family: Arial, Helvetica, sans-serif;
    color: #18181b;
">

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
                    RESET HEADER
                ====================================================== --}}
                <tr>
                    <td align="center" style="padding: 40px 32px 25px;">

                        {{-- Blue Lock --}}
                        <table
                            width="72"
                            height="72"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                width: 72px;
                                height: 72px;
                                background-color: #eff6ff;
                                border-radius: 50%;
                                margin: 0 auto 20px;
                            "
                        >
                            <tr>
                                <td
                                    align="center"
                                    valign="middle"
                                    style="
                                        color: #2563eb;
                                        font-size: 32px;
                                        font-weight: 700;
                                    "
                                >
                                    🔒
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
                            Reset Password
                        </h1>

                        <p style="
                            margin: 10px 0 0;
                            color: #71717a;
                            font-size: 14px;
                            line-height: 1.6;
                        ">
                            Gunakan link berikut untuk membuat password baru.
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
                            Halo <strong>{{ $user->name }}</strong>,
                            <br><br>

                            Kami menerima permintaan untuk mengatur ulang password
                            akun Eventverse Anda. Klik tombol di bawah untuk membuat
                            password baru.
                        </p>


                        {{-- =================================================
                            ACCOUNT CARD
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
                            <tr>
                                <td style="
                                    padding: 18px 20px;
                                    background-color: #f8fafc;
                                    border-bottom: 1px solid #e5e7eb;
                                ">
                                    <div style="
                                        color: #71717a;
                                        font-size: 11px;
                                        text-transform: uppercase;
                                        letter-spacing: 0.7px;
                                        margin-bottom: 5px;
                                    ">
                                        Akun
                                    </div>

                                    <div style="
                                        color: #18181b;
                                        font-size: 15px;
                                        font-weight: 700;
                                        word-break: break-word;
                                    ">
                                        {{ $user->email }}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 20px;">

                                    <div style="
                                        color: #71717a;
                                        font-size: 11px;
                                        text-transform: uppercase;
                                        letter-spacing: 0.6px;
                                        margin-bottom: 6px;
                                    ">
                                        Permintaan
                                    </div>

                                    <div style="
                                        color: #18181b;
                                        font-size: 15px;
                                        font-weight: 700;
                                    ">
                                        Reset Password
                                    </div>

                                </td>
                            </tr>
                        </table>


                        {{-- =================================================
                            CTA
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
                                        href="{{ $resetUrl }}"
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
                                        Reset Password
                                    </a>

                                </td>
                            </tr>
                        </table>


                        {{-- =================================================
                            ALTERNATIVE URL
                        ================================================== --}}
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
                                href="{{ $resetUrl }}"
                                style="
                                    color: #60a5fa;
                                    text-decoration: none;
                                    word-break: break-all;
                                "
                            >
                                {{ $resetUrl }}
                            </a>
                        </p>


                        {{-- =================================================
                            SECURITY NOTICE
                        ================================================== --}}
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
                                            Demi keamanan akun
                                        </strong>,
                                        jangan bagikan link reset password ini
                                        kepada siapa pun. Jika Anda tidak meminta
                                        reset password, abaikan email ini.
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