<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body{
            margin:0;
            /* padding:1px; */
            /* background:#eef4ff; */
            font-family: DejaVu Sans, sans-serif;
            /* border-radius:20px; */
        }

        .wrapper{
            border:2px solid #dbeafe;
            border-radius:20px;
            overflow:hidden;
            background:white;
        }

        .ticket{
            width:100%;
            background:#ffffff;
            border-radius:20px;
            overflow:hidden;
            /* border:3px solid #dbeafe; */
        }

        .left{
            width:68%;
            background:#38365f;
            color:white;
            padding:25px;
            vertical-align:top;
        }

        .right{
            width:32%;
            background:white;
            text-align:center;
            vertical-align:middle;
        }

        .brand{
            display:inline-block;
            background:#1b2a69;
            color:white;
            padding:8px 15px;
            border-radius:20px;
            font-size:11px;
            margin-bottom:0px;
        }

        .cover{
            width:100%;
            height:220px;
            object-fit:cover;
            border-radius:12px;
        }

        .event-title{
            margin-top:10px;
            font-size:22px;
            font-weight:bold;
        }

        .organizer{
            margin-top:8px;
            margin-bottom:7px; 
            color:#cbd5e1;
            font-size:12px;
        }

        .badge{
            /* display:inline-block; */
            background:#575174;
            color:white;
            padding:8px 15px;
            border-radius:10px;
            font-size:11px;
            margin-bottom:0px;
        }

        .user{
            margin-top:25px;
        }

        .user strong{
            font-size:16px;
        }

        .email{
            color:#cbd5e1;
            font-size: 12px;
            margin-top:0px;
        }

        .ticket-id{
            margin-top:8px;
        }

        .ticket-id-label{
            font-size:11px;
            color:#94a3b8;
        }

        .ticket-id-value{
            margin-top:5px;
            font-size:18px;
            font-weight:bold;
        }

        .qr{
            width:150px;
            margin-top:20px;
        }

        .paid{
            margin-top:5px;
            margin-bottom: 10px;
            display:inline-block;
            background:#dcfce7;
            color:#15803d;
            padding:8px 15px;
            border-radius:20px;
            font-size:12px;
            font-weight:bold;
        }

        .scan{
            margin-top:15px;
            color:#64748b;
            font-size:12px;
        }

        .left{
    width:68%;
    background:#38365f;;
    color:white;
    padding:25px 25px 0 25px;
    vertical-align:top;
}

.user-box{

    margin-top:20px;

    background:#2e2c4f;

    margin-left:-25px;
    margin-right:-25px;

    padding:18px 25px;

    border-top:1px solid rgba(255,255,255,.08);
}

.user-name{

    font-size:18px;
    font-weight:700;
    color:#fff;
}

.user-email{

    margin-top:4px;

    font-size:12px;

    color:#cbd5e1;
}

    </style>
</head>

<body>

    <div class="wrapper">
        <table class="ticket" cellpadding="0" cellspacing="0">
            <tr>
                <td class="left">
                    <div class="brand">
                        eventhub e-ticket
                    </div>

                    {{-- <div>
                        <img
                            class="cover"
                            src="{{ public_path('dummy-event.jpg') }}">
                    </div> --}}

                    <div class="event-title">
                        {{ $event->title }}
                    </div>

                    <div class="organizer">
                        @php
                            if ($event->organizer == 'org') {
                                $penyelenggara = $event->org->org_name ?? '';
                                $link = '/organisasi' . '/' . $event->org->org_id;
                            } elseif ($event->organizer == 'individual') {
                                $penyelenggara = $event->individual->name ?? '';
                                $link = '/user' . '/' . $event->individual->username;
                            } elseif (
                                $event->organizer == null ||
                                $event->organizer_id == null ||
                                $event->organizer == '' ||
                                $event->organizer_id == ''
                            ) {
                                $penyelenggara = '';
                                $link = '';
                            } else {
                                $penyelenggara = '';
                                $link = '';
                            }
                        @endphp
                        Organizer: {{ $penyelenggara }}
                    </div>

                    <div>
                        <span class="badge">
                            {{ $event->start_date == $event->end_date ? 
                            date('d-m-Y', strtotime($event->start_date)) : 
                            date('d-m-Y', strtotime($event->start_date)) . ' - ' . date('d-m-Y', strtotime($event->end_date)) }}
                        </span>

                        <span class="badge">
                            {{ $event->location_jenis == 'Online' ? 'Online' : $event->location_detail . ', ' . $event->location_city . ', ' . $event->province->name }}
                        </span>

                    </div>

                    <div class="user-box">

                        <div class="user-name">
                            {{ $transaction->name }}
                        </div>

                        <div class="user-email">
                            {{ $transaction->email }}
                        </div>

                    </div>
                </td>

                <td class="right">

                    {{-- <div class="paid">
                        ✓ PAID
                    </div> --}}

                    <img
                        class="qr"
                        src="data:image/png;base64,{{ $qrcode }}">

                    <div class="scan">
                        Scan QR saat check-in
                    </div>


                    <div class="ticket-id">
                        {{-- <div class="ticket-id-label">
                            TICKET ID
                        </div> --}}
                        {{-- <div class="ticket-id-value">
                            EVT-2026-001
                        </div> --}}

                        <div class="paid">{{ $transaction->transaction_id }}</div>
                    </div>
                </td>
            </tr>
        </table>

        
    </div>

    <style>

.ticket-note{

    margin-top:20px;

    border:1px solid #dbeafe;

    border-radius:12px;

    overflow:hidden;
}

.ticket-note-header{

    background:#eef2ff;

    color:#312e81;

    padding:12px 15px;

    font-size:14px;

    font-weight:bold;

    border-bottom:1px solid #dbeafe;
}

.ticket-note-body{

    padding:15px;

    background:#ffffff;
}

.ticket-note-list{

    margin:0;

    padding-left:18px;
}

.ticket-note-list li{

    margin-bottom:0px;

    color:#475569;

    font-size:11px;

    line-height:1.6;
}

.ticket-help{

    margin-top:12px;

    padding:10px 12px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:8px;

    color:#64748b;

    font-size:11px;

    line-height:1.5;
}

.ticket-help strong{

    color:#0f172a;
}

</style>

<div class="ticket-note">

    <div class="ticket-note-header">
        INFORMASI PENTING
    </div>

    <div class="ticket-note-body">

        <ul class="ticket-note-list">

            <li>
                Simpan tiket dan QR Code dengan baik. Jangan membagikan QR Code kepada pihak lain.
            </li>

            <li>
                QR Code digunakan untuk proses verifikasi dan check-in peserta.
            </li>

            <li>
                Pastikan data peserta pada tiket sudah benar. Perubahan jadwal, lokasi, atau ketentuan acara mengikuti kebijakan penyelenggara.
            </li>

            <li>
                Dengan menggunakan tiket ini, peserta dianggap telah menyetujui syarat dan ketentuan event.
            </li>

        </ul>

        <div class="ticket-help">

            <strong>Butuh bantuan?</strong><br>

            Hubungi penyelenggara acara atau tim dukungan EventHub apabila mengalami kendala terkait tiket maupun registrasi.

        </div>

    </div>

</div>
</body>
</html>