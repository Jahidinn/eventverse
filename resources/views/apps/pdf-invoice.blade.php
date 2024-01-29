<!DOCTYPE html>
<html>

<head>
    <title>Laravel 10 Generate PDF Example - ItSolutionStuff.com</title>
    <style>
        /*
  Common invoice styles. These styles will work in a browser or using the HTML
  to PDF anvil endpoint.
*/

        body {
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr td {
            padding: 0;
        }

        table tr td:last-child {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .large {
            font-size: 1.1em;
        }

        .total {
            font-weight: bold;
            color: #fb7578;
        }

        .logo-container {
            margin: 20px 0 40px 0;
        }

        .invoice-info-container {
            font-size: 0.875em;
        }

        .invoice-info-container td {
            padding: 4px 0;
        }

        .client-name {
            font-size: 1.5em;
            vertical-align: top;
        }

        .line-items-container {
            margin: 30px 0;
            font-size: 0.875em;
        }

        .line-items-container th {
            text-align: left;
            color: #999;
            border-bottom: 2px solid #ddd;
            padding: 10px 0 15px 0;
            font-size: 0.75em;
            text-transform: uppercase;
        }

        .line-items-container th:last-child {
            text-align: right;
        }

        .line-items-container td {
            padding: 5px 0;
        }

        .line-items-container tbody tr:first-child td {
            padding-top: 25px;
        }

        .line-items-container.has-bottom-border tbody tr:last-child td {
            padding-bottom: 25px;
            border-bottom: 2px solid #ddd;
        }

        .line-items-container.has-bottom-border {
            margin-bottom: 0;
        }

        .line-items-container th.heading-quantity {
            width: 50px;
        }

        .line-items-container th.heading-price {
            text-align: right;
            width: 100px;
        }

        .line-items-container th.heading-subtotal {
            width: 100px;
        }

        .payment-info {
            width: 38%;
            font-size: 1em;
            line-height: 1.5;
        }

        .footer {
            margin-top: 100px;
        }

        .footer-thanks {
            margin-top: 20px;
            font-size: 1.125em;
        }

        .footer-thanks img {
            display: inline-block;
            position: relative;
            top: 1px;
            width: 16px;
            margin-right: 4px;
        }

        .footer-info {
            float: right;
            margin-top: 5px;
            font-size: 0.75em;
            color: #ccc;
        }

        .footer-info span {
            padding: 0 5px;
            color: black;
        }

        .footer-info span:last-child {
            padding-right: 0;
        }

        .page-container {
            display: none;
        }

        /*
  The styles here for use when generating a PDF invoice with the HTML code.

  * Set up a repeating page counter
  * Place the .footer-info in the last page's footer
*/

        .footer {
            margin-top: 30px;
        }

        .footer-info {
            float: none;
            position: running(footer);
            margin-top: -0px;
            padding: 5px;
            color: #fff;
        }

        .footer-info span {
            color: #fff;
        }

        .page-container {
            display: block;
            position: running(pageContainer);
            margin-top: -20px;
            font-size: 13px;
            text-align: right;
            color: #999;
        }

        .page-container .page::after {
            content: counter(page);
        }

        .page-container .pages::after {
            content: counter(pages);
        }


        @page {
            @bottom-right {
                content: element(pageContainer);
            }

            @bottom-left {
                content: element(footer);
            }
        }
    </style>
</head>

<body>
    <div class="page-container">
        Page
        <span class="page"></span>
        of
        <span class="pages"></span>
    </div>

    <div class="logo-container">
        <img style="height: 60px" src="{{ public_path('/assets/img/logo-2.png') }}">
    </div>

    <table class="invoice-info-container">
        <tr>
            <td rowspan="2" class="client-name">
                INVOICE
            </td>
            <td>
                Participant
            </td>
        </tr>
        <tr>
            <td>
                <b>{{ $transaction->name }}</b>
            </td>
        </tr>
        <tr>
            <td>
                Invoice Date: <strong>{{ date('d M Y') }}</strong>
            </td>
            <td>
                {{ $transaction->email }}
            </td>
        </tr>
        <tr>
            <td>
                Invoice No:
                <strong>{{ '#EC/' . $transaction->id . '/' . $transaction->created_at->format('y') }}</strong>
            </td>
            <td>
                {{ $transaction->phone }}
            </td>
        </tr>
    </table>


    <table class="line-items-container">
        <thead>
            <tr>
                <th class="heading-quantity">Qty</th>
                <th class="heading-description">Description</th>
                <th class="heading-price">Price</th>
                <th class="heading-subtotal">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $transaction->quantity }}</td>
                <td><b>{{ $ticket->ticket_name }}</b> ({{ $event->title }})</td>
                <td class="right">Rp {{ number_format($ticket->ticket_price, 0, ',', '.') }}</td>
                <td class="bold">Rp {{ number_format($ticket->ticket_price * $transaction->quantity, 0, ',', '.') }}
                </td>
            </tr>
            <tr style="border-bottom: 2px solid #ddd;">
                <td style="padding-bottom: 25px;"></td>
                <td style="padding-bottom: 25px;">Biaya admin</td>
                <td style="padding-bottom: 25px;" class="right"></td>
                @if ($transaction->total_price == 0 || $transaction->total_price == '')
                    <td style="padding-bottom: 25px;" class="bold">Rp 0</td>
                @else
                    <td style="padding-bottom: 25px;" class="bold">Rp
                        {{ number_format(config('app.biaya_admin'), 0, ',', '.') }}</td>
                @endif
            </tr>
            <tr>
                <td></td>
                <td><b>Total</b></td>
                <td class="right"></td>
                <td class="bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            </tr>

        </tbody>
    </table>

    <div style="text-align: center; margin-bottom: 10px;"><i>Ticket/registration ID</i></div>
    <div style="background-color: #ddebf4; padding-top:15px; padding-bottom:15px">
        {{-- <div style="text-align: center">{{ $qrcode }}</div> --}}
        <div style="text-align: center">
            <img style="text-align: center;" src="data:image/png;base64,{{ $qrcode }}">
        </div>
    </div>
    <div style="text-align: center; margin-top: 10px;"><b>{{ $transaction->transaction_id }}</b></div>


    <table class="line-items-container has-bottom-border">
        <thead>
            <tr>
                <th>Payment Info</th>
                <th>Payment date</th>
                <th>Total Due</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="payment-info">
                    <div>
                        @if ($transaction->status == 'Paid')
                            {{-- IF PAID --}}
                            <strong style="color: rgb(31, 148, 37)), 55)">Sukses!</strong>
                        @elseif ($transaction->status == 'Unpaid')
                            {{-- IF UNPAID --}}
                            <strong style="color: rgb(187, 38, 38)), 55)">Unpaid!</strong>
                        @elseif ($transaction->status == 'Pending')
                            {{-- IF PENDING --}}
                            <strong style="color: rgb(202, 147, 44)), 55)">Pending!</strong>
                        @elseif ($transaction->status == 'Expired')
                            {{-- IF EXPIRED --}}
                            <strong style="color: rgb(172, 33, 33)), 55)">Expired!</strong>
                        @else
                            {{-- ELSE --}}
                            <strong style="color: rgb(179, 31, 31)), 55)">Gagal!</strong>
                        @endif
                    </div>
                </td>
                <td class="large">{{ $transaction->updated_at->format('d M Y') }}</td>
                @if ($transaction->total_price == 0 || $transaction->total_price == '')
                    <td class="large total">GRATIS</td>
                @else
                    <td class="large total">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                @endif
            </tr>
        </tbody>
    </table>

    <div class="footer" style="background-color: #1e4356">
        <div class="footer-info" style="text-align: center">
            <span>info@eventconnect.id</span> |
            <span>0821 3355 3002</span> |
            <span>www.eventconnect.id</span>
        </div>
        {{-- <div class="footer-thanks">
            <span>Thank you!</span>
        </div> --}}
    </div>

    <div style="margin-top: 30px;">
        <div style="text-align: right">
            <img style="text-align: center;" src="data:image/png;base64,{{ $qrcode_ec }}">
        </div>
    </div>


</body>

</html>
