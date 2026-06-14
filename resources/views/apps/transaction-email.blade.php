<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Transactional Email</title>
    <style media="all" type="text/css">
        /* -------------------------------------
    GLOBAL RESETS
------------------------------------- */

        body {
            font-family: Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
            line-height: 1.3;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }

        table td {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            vertical-align: top;
        }

        /* -------------------------------------
    BODY & CONTAINER
------------------------------------- */

        body {
            background-color: #f4f5f6;
            margin: 0;
            padding: 0;
        }

        .body {
            background-color: #f4f5f6;
            width: 100%;
        }

        .container {
            margin: 0 auto !important;
            max-width: 600px;
            padding: 0;
            padding-top: 24px;
            width: 600px;
        }

        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 600px;
            padding: 0;
        }

        /* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */

        .main {
            background: #ffffff;
            border: 1px solid #eaebed;
            border-radius: 16px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 24px;
        }

        .footer {
            clear: both;
            padding-top: 15px;
            text-align: center;
            width: 100%;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #9a9ea6;
            font-size: 13px;
            text-align: center;
        }

        /* -------------------------------------
    TYPOGRAPHY
------------------------------------- */

        p {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 16px;
        }

        a {
            color: #0867ec;
            text-decoration: underline;
        }

        /* -------------------------------------
    BUTTONS
------------------------------------- */

        .btn {
            box-sizing: border-box;
            min-width: 100% !important;
            width: 100%;
        }

        .btn>tbody>tr>td {
            padding-bottom: 16px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 4px;
            text-align: center;
        }

        .btn a {
            background-color: #ffffff;
            border: solid 2px #1e4356;
            border-radius: 4px;
            box-sizing: border-box;
            color: #1e4356;
            cursor: pointer;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            padding: 5px 24px;
            text-decoration: none;
            text-transform: capitalize;
        }

        .btn-primary table td {
            background-color: #1e4356;
        }

        .btn-primary a {
            background-color: #1e4356;
            border-color: #1e4356;
            color: #ffffff;
        }

        @media all {
            .btn-primary table td:hover {
                background-color: rgb(75, 177, 227) !important;
            }

            .btn-primary a:hover {
                background-color: rgb(75, 177, 227) !important;
                border-color: rgb(75, 177, 227) !important;
            }
        }

        /* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */

        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .text-link {
            color: #1e4356 !important;
            text-decoration: underline !important;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        /* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */

        @media only screen and (max-width: 640px) {

            .main p {
                font-size: 12px !important;
            }

            .wrapper {
                padding: 8px !important;
            }

            .content {
                padding: 0 !important;
            }

            .container {
                padding: 0 !important;
                padding-top: 8px !important;
                width: 100% !important;
            }

            .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            .btn table {
                max-width: 100% !important;
                width: 100% !important;
            }

            .btn a {
                font-size: 16px !important;
                max-width: 100% !important;
                width: 100% !important;
            }
        }

        /* -------------------------------------
    PRESERVE THESE STYLES IN THE HEAD
------------------------------------- */

        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }
        }
    </style>
</head>

<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">

                    <!-- START CENTERED WHITE CONTAINER -->
                    <span class="preheader">eventhub transaction</span>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper">
                                <h3>Halo, {{ $transaction['name'] }}!</h3>
                                <div style="font-size: 12px;">
                                    <p style="font-size: 13px;">Terimakasih sudah melakukan pendaftaran/pembelian tiket
                                        event di
                                        <a style="text-decoration: none"
                                            href="http://eventhub.web.id"><b>eventhub.web.id</b></a>, berikut kami
                                        kirimkan detail transaksi dan link invoicenya ya!
                                    </p>
                                    <span>Detail transaksi : <b>{{ $ticket->ticket_name }}
                                            ({{ $event->title }})</b></span><br>

                                    <span>Quantity : <b>{{ $transaction->quantity }}</b></span><br>

                                    <span>Total biaya :
                                        <b>Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</b></span>
                                    @if ($transaction->status == 'Paid')
                                        <span style="color: #00762d">(Sukses!)</span>
                                    @else
                                        <span style="color: rgb(167, 17, 17)">(Pending/gagal!)</span>
                                    @endif

                                    <br>

                                    <span>Kode transaksi : <b>#{{ $transaction['transaction_id'] }}</b></span>
                                </div>
                                <div style="text-align: left; margin-top:15px"> {!! QrCode::size(130)->generate($transaction['transaction_id']) !!}</div>

                                {{-- <div style="text-align: center">
                                    <img style="text-align: center;" src="data:image/png;base64,{{ $qrcode }}">
                                </div> --}}

                                <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                    class="btn btn-primary" style="margin-top:20px;">
                                    <tbody>
                                        <tr>
                                            <td align="left">
                                                <table role="presentation" border="0" cellpadding="0"
                                                    cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            @php
                                                                $hashids = new \Hashids\Hashids('eventhub-secret', 15);
                                                            @endphp

                                                            <td>
                                                                <a href="{{ url('/event/redirect-invoice/' . $hashids->encode($transaction['id'])) }}"
                                                                    target="_blank">
                                                                    Lihat invoice
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="text-align: left">
                                    <small style="color: rgb(167, 17, 17)">Jika status pending/gagal tunggu beberapa
                                        saat dan refresh invoice</small>
                                </div>

                                <p>Have a nice day!</p>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <!-- START FOOTER -->
                    <div class="footer" style="margin-bottom: 20px">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <div style="text-align: center">
                                        <img style="text-align: center; height:50px; margin-bottom: 10px;"
                                            src="{{ $message->embed(public_path() . '/assets/img/logo-email.png') }}">
                                    </div>
                                    <span class="apple-link">PT Event Media Nusantara</span>
                                    <br><a href="http://eventconnect.id"
                                        style="text-decoration:none">www.eventconnect.id</a> | info@eventconnect.id
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </table>
                    </div>

                    <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>
