<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
            font-size: 11px;
        }

        /* CARD RINGKASAN EVENT */
        .hero-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 14px;
        }
        .hero-table {
            width: 100%;
            border-collapse: collapse;
        }
        .hero-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
        }
        .hero-title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            line-height: 1.3;
        }

        /* GRID COMPACT CARDS */
        .meta-grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 0;
            margin-top: 10px;
        }
        .meta-card {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 6px;
            padding: 8px 10px;
            vertical-align: top;
        }
        .meta-label {
            color: #64748b;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }
        .meta-val {
            color: #0f172a;
            font-size: 10px;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* CARD TRANSAKSI */
        .tx-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 20px;
        }
        .tx-header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }
        .tx-label {
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            letter-spacing: 1px;
        }
        .tx-status {
            background-color: #dcfce7;
            color: #15803d;
            font-size: 9px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 10px;
            text-align: right;
        }

        /* SECTION TITLE */
        .section-title-box {
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            margin: 3px 0 0 0;
        }

        /* MODERN E-TICKET CONTAINER */
        .ticket-wrapper {
            page-break-inside: avoid;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #0f172a;
            border-radius: 14px;
            overflow: hidden;
        }

        /* TICKET LEFT */
        .ticket-left {
            width: 68%;
            background-color: #0f172a;
            color: #ffffff;
            padding: 20px 22px;
            vertical-align: top;
        }
        .ticket-brand {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1.2px;
            color: #ffffff;
        }
        .ticket-num {
            float: right;
            font-size: 9px;
            font-weight: bold;
            color: #cbd5e1;
            padding-top: 2px;
        }

        .participant-box {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 12px 14px;
            margin: 14px 0;
        }
        .p-label {
            color: #94a3b8;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .p-val {
            color: #ffffff;
            font-size: 13px;
            font-weight: bold;
            margin-top: 2px;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        .p-sub {
            color: #cbd5e1;
            font-size: 9.5px;
            margin-top: 2px;
        }

        .ticket-bottom-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px dashed rgba(255, 255, 255, 0.25);
            padding-top: 10px;
            margin-top: 6px;
        }
        .t-event-title {
            font-size: 11.5px;
            font-weight: bold;
            color: #f8fafc;
            line-height: 1.3;
        }
        .t-code-val {
            font-family: monospace;
            font-size: 11.5px;
            font-weight: bold;
            color: #38bdf8;
            margin-top: 2px;
        }

        /* TICKET SEPARATOR */
        .ticket-sep {
            width: 1%;
            border-left: 2px dashed #cbd5e1;
            background-color: #ffffff;
        }

        /* TICKET RIGHT (QR) */
        .ticket-right {
            width: 31%;
            background-color: #ffffff;
            text-align: center;
            vertical-align: middle;
            padding: 16px;
        }
        .qr-img {
            width: 110px;
            height: 110px;
        }
        .qr-text {
            color: #64748b;
            font-size: 9px;
            font-weight: bold;
            margin-top: 6px;
        }

        /* GARIS PEMOTONG FULL-WIDTH TANPA TEKS */
        .cutter-divider {
            border: none;
            border-top: 1px dashed #94a3b8;
            margin: 24px 0;
            height: 0;
            width: 100%;
        }

        /* TICKET NOTE */
        .note-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            overflow: hidden;
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .note-header {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-weight: bold;
            color: #0f172a;
            font-size: 10px;
        }
        .note-body {
            padding: 12px 14px;
        }
        .note-list {
            margin: 0;
            padding-left: 14px;
        }
        .note-list li {
            color: #475569;
            font-size: 9px;
            line-height: 1.5;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>

@php
    // Logic Penyelenggara
    if ($event->organizer == 'org') {
        $penyelenggara = $event->org->org_name ?? '';
    } elseif ($event->organizer == 'individual') {
        $penyelenggara = $event->individual->name ?? '';
    } else {
        $penyelenggara = '-';
    }

    // Logic Tanggal Event
    if ($event->start_date == $event->end_date) {
        $eventDate = date('d-m-Y', strtotime($event->start_date));
    } else {
        $eventDate = date('d-m-Y', strtotime($event->start_date)) . ' - ' . date('d-m-Y', strtotime($event->end_date));
    }

    // Logic Lokasi Event
    if (strtolower($event->location_jenis) == 'online') {
        $eventLocation = 'Online Event';
    } else {
        $eventLocation = ($event->location_detail ?? '') . ($event->location_city ? ' (' . $event->location_city . ')' : '');
    }
@endphp

    {{-- 1. RINGKASAN EVENT --}}
    <div class="hero-card">
        <table class="hero-table">
            <tr>
                <td style="width: 56px; vertical-align: middle;">
                    <img src="{{ $img }}" class="hero-img">
                </td>
                <td style="vertical-align: middle; padding-left: 10px;">
                    <h1 class="hero-title">{{ $event->title }}</h1>
                </td>
            </tr>
        </table>

        <table class="meta-grid-table">
            <tr>
                <td class="meta-card" style="width: 33%;">
                    <span class="meta-label">TANGGAL EVENT</span>
                    <div class="meta-val">{{ $eventDate }}</div>
                </td>
                <td class="meta-card" style="width: 34%;">
                    <span class="meta-label">LOKASI EVENT</span>
                    <div class="meta-val">{{ $eventLocation }}</div>
                </td>
                <td class="meta-card" style="width: 33%;">
                    <span class="meta-label">PENYELENGGARA</span>
                    <div class="meta-val">{{ $penyelenggara }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- 2. RINGKASAN TRANSAKSI --}}
    <div class="tx-card">
        <table class="tx-header-table">
            <tr>
                <td class="tx-label">RINGKASAN TRANSAKSI</td>
                <td style="text-align: right;">
                    <span class="tx-status">PAID</span>
                </td>
            </tr>
        </table>

        <table class="meta-grid-table">
            <tr>
                <td class="meta-card" style="width: 20%;">
                    <span class="meta-label">KODE TRANSAKSI</span>
                    <div class="meta-val">{{ $transaction->transaction_code }}</div>
                </td>
                <td class="meta-card" style="width: 20%;">
                    <span class="meta-label">NAMA PEMBELI</span>
                    <div class="meta-val">{{ $transaction->buyer_name ?? '-' }}</div>
                </td>
                <td class="meta-card" style="width: 20%;">
                    <span class="meta-label">EMAIL PEMBELI</span>
                    <div class="meta-val">{{ $transaction->buyer_email ?? '-' }}</div>
                </td>
                <td class="meta-card" style="width: 20%;">
                    <span class="meta-label">NO. TELEPON</span>
                    <div class="meta-val">{{ $transaction->buyer_phone ?? '-' }}</div>
                </td>
                @if(isset($transaction->grand_total))
                <td class="meta-card" style="width: 20%;">
                    <span class="meta-label">TOTAL PEMBAYARAN</span>
                    <div class="meta-val">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                </td>
                @endif
            </tr>
        </table>
    </div>

    {{-- 3. E-TICKET PER PESERTA --}}
    <div class="section-title-box">
        <span class="tx-label">E-TICKET PESERTA</span>
        <h2 class="section-title">{{ $participants->count() }} Tiket</h2>
    </div>

    @foreach($participants as $index => $participant)
        @php
            $participantTicketCode = $participant->ticket_code ?? $transaction->ticket_code ?? $transaction->transaction_code;
            $qrBase64 = $participantQrcodes[$participant->id] ?? '';
        @endphp

        {{-- GARIS PEMOTONG SEBELUM TIKET --}}
        <div class="cutter-divider"></div>

        <div class="ticket-wrapper">
            <table class="ticket-table">
                <tr>
                    {{-- SISI KIRI TIKET --}}
                    <td class="ticket-left">
                        <div>
                            <span class="ticket-brand">EVENTHUB TICKET</span>
                            <span class="ticket-num">TIKET #{{ $index + 1 }}</span>
                        </div>

                        <div class="participant-box">
                            <div class="p-label">Nama Peserta</div>
                            <div class="p-val">{{ $participant->name }}</div>

                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    @if($participant->email)
                                    <td style="width: 50%; padding: 0; vertical-align: top;">
                                        <div class="p-label">Email</div>
                                        <div class="p-sub">{{ $participant->email }}</div>
                                    </td>
                                    @endif
                                    @if($participant->phone)
                                    <td style="width: 50%; padding: 0; vertical-align: top;">
                                        <div class="p-label">Telepon</div>
                                        <div class="p-sub">{{ $participant->phone }}</div>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                        </div>

                        <table class="ticket-bottom-table">
                            <tr>
                                <td style="width: 60%; vertical-align: bottom;">
                                    <div class="t-event-title">{{ $event->title }}</div>
                                </td>
                                <td style="width: 40%; text-align: right; vertical-align: bottom;">
                                    <div class="p-label">TICKET CODE</div>
                                    <div class="t-code-val">{{ $participantTicketCode }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>

                    {{-- PEMISAH GARIS TIKET --}}
                    <td class="ticket-sep"></td>

                    {{-- SISI KANAN TIKET (QR CODE) --}}
                    <td class="ticket-right">
                        @if($qrBase64)
                            <img class="qr-img" src="data:image/svg+xml;base64,{{ $qrBase64 }}">
                        @endif
                        <div class="qr-text">Scan saat Check-In</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- GARIS PEMOTONG SETELAH TIKET TERAKHIR --}}
        @if($loop->last)
            <div class="cutter-divider"></div>
        @endif
    @endforeach

    {{-- INFORMASI PENTING --}}
    <div class="note-card">
        <div class="note-header">
            Informasi Penting
        </div>
        <div class="note-body">
            <ul class="note-list">
                <li>Simpan tiket dan QR Code dengan baik untuk verifikasi check-in di lokasi acara.</li>
                <li>Jangan menyebarkan QR Code untuk menghindari klaim ganda oleh pihak lain.</li>
            </ul>
        </div>
    </div>

</body>
</html>