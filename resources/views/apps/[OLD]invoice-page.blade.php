@extends('layouts.main')

@section('content')

    <style>
        .invoice-hero{
            background: linear-gradient(135deg,#2563eb,#3b82f6);
            border-radius:24px;
            padding:30px;
            color:white;
            margin-bottom:20px;
            box-shadow:5px 10px 30px rgba(15, 32, 69, 0.367);
        }

        .invoice-id{
            font-size:14px;
            opacity:.9;
        }

        .invoice-section{
            border:none;
            border-radius:20px;
            background:#fff;
            box-shadow:0 10px 30px rgba(15, 23, 42, 0.369);
            padding:24px;
            height:100%;
        }

        .invoice-event{
            display:flex;
            gap:15px;
            align-items:center;
        }

        .invoice-event img{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:16px;
        }

        .invoice-summary-row{
            display:flex;
            justify-content:space-between;
            margin-bottom:12px;
        }

        .invoice-qr{
            text-align:center;
        }

        .invoice-total{
            border-top:1px solid #e5e7eb;
            margin-top:15px;
            padding-top:15px;
            font-size:22px;
            font-weight:700;
            color:#16a34a;
        }

        .invoice-amount{
            font-size:32px;
            font-weight:700;
        }

        .invoice-status{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 18px;
            border-radius:999px;
            font-weight:600;
            margin-top:10px;
            font-size: 15px;
        }

        .status-paid{
            background:#dcfce7;
            color:#166534;
        }

        .status-unpaid{
            background:#fef3c7;
            color:#92400e;
        }

        .status-failed{
            background:#fee2e2;
            color:#991b1b;
        }

        .invoice-card{
            border:none;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(15,23,42,.08);
        }

        .invoice-section{
            background:white;
            border-radius:20px;
            padding:24px;
            box-shadow:0 10px 30px rgba(15,23,42,.06);
            margin-bottom:20px;
        }

        .invoice-title{
            font-size:18px;
            font-weight:700;
            margin-bottom:15px;
        }

        .invoice-actions{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
        }

        .invoice-actions button{
            border:none;
            border-radius:12px;
            padding:10px 18px;
            background:#f8fafc;
            font-weight:600;
            font-size: 14px;
        }

        .invoice-actions .pay{
            background:#dcfce7;
            color:#166534;
        }

        .invoice-event{
            display:flex;
            gap:15px;
            align-items:center;
        }

        .invoice-event img{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:16px;
        }

        .invoice-qr{
            text-align:center;
        }

        .invoice-qr svg{
            max-width:180px;
        }

        .invoice-summary-row{
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
            font-size: 14px;
            
        }

        .invoice-total{
            border-top:1px solid #e5e7eb;
            padding-top:15px;
            margin-top:15px;
            font-size:22px;
            font-weight:700;
            color:#16a34a;
        }

        .invoice-info{
            background:#f8fafc;
            border-radius:16px;
            padding:18px;
            font-size:14px;
            color:#64748b;
        }
    </style>


    <div class="bg-eventconnect header-hight">
    </div>

    <section class="pt-2" id="invoice_page" hidden>
        {{-- <div class="container mx-auto text-center mb-3 px-2">
            <div class="alert alert-primary" role="alert">
                <strong>#Online Invoice</strong>
            </div>
        </div> --}}

        <form action="javascript:void(0)" method="post" id="checkout-event">
            @csrf

            <div class="container row mx-auto px-0">
                <div class="col-md-12 px-2 mt-2 p-0">
                    <div class="card-body p-0">
                        <div class="invoice-hero">

                            <div class="invoice-id">
                                ONLINE INVOICE • #{{ $transaction->transaction_id }}
                            </div>

                            <h4 class="mt-2 mb-2">
                                Halo, {{ $transaction->name }} 👋
                            </h4>

                            <div class="invoice-amount">
                                Rp {{ number_format($transaction->total_price,0,',','.') }}
                            </div>

                            @if ($transaction->status == 'Paid')
                                <span class="invoice-status status-paid">
                                    ✓ Pembayaran Berhasil
                                </span>
                            @elseif($transaction->status == 'Unpaid' || $transaction->status == 'Pending')
                                <span class="invoice-status status-unpaid">
                                    ⏳ Menunggu Pembayaran
                                </span>
                            @else
                                <span class="invoice-status status-failed">
                                    ✕ Pembayaran Gagal
                                </span>
                            @endif

                        </div>

                        <div class="invoice-actions mb-4">

                            <button onClick="window.location.reload();">
                                <i class="ti ti-refresh"></i> Refresh
                            </button>

                            @if ($transaction->status == 'Paid')
                            <button
                                data-id_transaksi="{{ $transaction->id }}"
                                id="download-invoice">

                                <i class="ti ti-file-type-pdf"></i>
                                PDF invoice
                            </button>

                            <button
                                data-id_transaksi="{{ $transaction->id }}"
                                id="download-ticket">

                                <i class="ti ti-ticket"></i>
                                E-Ticket
                            </button>

                            @endif

                            @if ($transaction->status == 'Unpaid' || $transaction->status == 'Pending')
                                <button class="pay"
                                    id="lanjutkan-transaksi"
                                    data-id_transaksi="{{ $transaction->id }}">

                                    <i class="ti ti-wallet"></i>
                                    Bayar Sekarang
                                </button>
                            @endif

                        </div>

                        <div class="row align-items-stretch">

                            <!-- KIRI -->
                            <div class="col-lg-8 mb-3 d-flex">

                                <div class="invoice-section w-100">

                                    <div class="invoice-title">
                                        Detail Event
                                    </div>

                                    <div class="invoice-event mb-4">

                                        <img
                                            src="{{ asset('storage/event-images/' . $event->image) }}">

                                        <div>

                                            <h5 class="mb-1">
                                                {{ $event->title }}
                                            </h5>

                                            <div class="text-muted">
                                                {{ $event->penyelenggara->name }}
                                            </div>

                                            <div class="mt-2">
                                                {{ $ticket->ticket_name }}
                                                ({{ $transaction->quantity }}x)
                                            </div>

                                        </div>

                                    </div>

                                    <hr>

                                    <div class="invoice-title">
                                        Data Peserta
                                    </div>

                                    <div class="invoice-summary-row">
                                        <span>Nama</span>
                                        <strong>{{ $transaction->name }}</strong>
                                    </div>

                                    <div class="invoice-summary-row">
                                        <span>Email</span>
                                        <strong>{{ $transaction->email }}</strong>
                                    </div>

                                    <div class="invoice-summary-row">
                                        <span>Tanggal Order</span>
                                        <strong>{{ $transaction->created_at->format('d M Y') }}</strong>
                                    </div>

                                    <div class="invoice-summary-row">
                                        <span>ID Transaksi</span>
                                        <strong>#{{ $transaction->transaction_id }}</strong>
                                    </div>

                                </div>

                            </div>

                            <!-- KANAN -->
                            <div class="col-lg-4 mb-3 d-flex">

                                <div class="invoice-section w-100 d-flex flex-column justify-content-between">

                                    <div class="invoice-qr">

                                        {!! $qrcode !!}

                                        <div class="mt-2">
                                            <strong>
                                                {{ $transaction->transaction_id }}
                                            </strong>
                                        </div>

                                        <small class="text-muted">
                                            Scan saat check-in
                                        </small>

                                    </div>

                                    <div>

                                        <hr>

                                        <div class="invoice-title">
                                            Ringkasan Pembayaran
                                        </div>

                                        <div class="invoice-summary-row">
                                            <span>{{ $ticket->ticket_name }}</span>

                                            <span>
                                                Rp {{ number_format($transaction->total_price,0,',','.') }}
                                            </span>
                                        </div>

                                        <div class="invoice-total">
                                            Rp {{ number_format($transaction->total_price,0,',','.') }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="invoice-info">

                            <strong>Informasi Penting</strong><br>

                            Invoice ini juga telah dikirim ke email yang terdaftar.
                            Simpan invoice dan QR Code dengan baik untuk keperluan verifikasi dan check-in event.

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!-- Modal konfirmasi checkout -->
    @include('apps.components.modal-checkout')

    {{-- javascript --}}
    @push('transaction-scripts')
        @include('apps.js.payment-process')
    @endpush

    @push('transaction-invoice')
        @include('apps.js.invoice')
    @endpush
@endsection
