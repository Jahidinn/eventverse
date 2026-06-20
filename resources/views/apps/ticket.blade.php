@extends('layouts.main')
@section('content')
    <div class="bg-eventconnect header-hight"></div>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    .ticket-page{
        font-family:'Inter',sans-serif;
        min-height:100vh;
        padding:0px 15px;
        background:
        linear-gradient(
            180deg,
            #edf4ff 0%,
            #f7faff 100%
        );
    }

    .ticket-container{
        max-width:1100px;
        margin:auto;
    }

    .ticket-header{
        text-align:center;
        margin-bottom:30px;
    }

    .ticket-header h1{
        font-size:30px;
        font-weight:800;
        color:#0f172a;
        margin-bottom:8px;
    }

    .ticket-header p{
        color:#64748b;
        margin:0;
    }

    /* TICKET */

    .ticket-modern{
        display:flex;
        min-height:300px;
        border-radius:34px;
        overflow:hidden;
        background:white;
        box-shadow:
        0 25px 80px rgba(37,99,235,.08);
        position:relative;
    }

    /* LEFT */

    .ticket-left{
        flex:1;
        padding:32px;
        background:
        linear-gradient(
            135deg,
            #1e293b,
            #5a4775
        );
        color:white;
        position:relative;
    }

    .ticket-brand{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:10px 16px;
        border-radius:999px;
        background:rgba(0, 60, 255, 0.204);
        font-size:11px;
        font-weight:700;
        letter-spacing:2px;
        margin-bottom:18px;
    }

    .event-cover{
        width:100%;
        height:230px;
        overflow:hidden;
        border-radius:20px;
        margin-bottom:24px;
    }

    .event-cover img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .ticket-event{
        font-size:32px;
        line-height:1.2;
        font-weight:800;
        margin-bottom:5px;
    }

    .ticket-organizer{
        color:#cbd5e1;
        margin-bottom:25px;
    }

    .ticket-meta{
        display:flex;
        flex-wrap:wrap;
        gap:14px;
        margin-bottom:25px;
    }

    .ticket-badge{
        background:rgba(255,255,255,.08);
        padding:10px 14px;
        border-radius:14px;
        font-size:14px;
        color:#e2e8f0;
    }

    .ticket-user{
        margin-top:10px;
    }

    .ticket-user strong{
        display:block;
        font-size:18px;
        margin-bottom:3px;
    }

    .ticket-user span{
        color:#cbd5e1;
    }

    .ticket-id{
        margin-top:25px;
        display:flex;
        flex-direction:column;
        gap:4px;
    }

    .ticket-id-label{
        color:#94a3b8;
        font-size:12px;
        letter-spacing:1px;
    }

    .ticket-id strong{
        font-size:18px;
        letter-spacing:1px;
    }

    /* MIDDLE */

    .ticket-separator{
        width:2px;
        background:#e5e7eb;
        position:relative;
    }

    .ticket-separator:before,
    .ticket-separator:after{
        content:"";
        width:40px;
        height:40px;
        border-radius:50%;
        background:#edf4ff;
        position:absolute;
        left:-19px;
    }

    .ticket-separator:before{
        top:-20px;
    }

    .ticket-separator:after{
        bottom:-20px;
    }

    /* RIGHT */

    .ticket-right{
        width:330px;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        background:white;
        padding:10px;
    }

    .qr-box{
        padding:8px;
        border-radius:22px;
        background:#f8fafc;
        box-shadow:
        0 10px 25px rgba(0,0,0,.05);
    }

    .qr-box img{
        width:200px;
        height:200px;
    }

    .qr-text{
        margin-top:15px;
        color:#64748b;
        font-size:13px;
    }

    .ticket-status{
        margin-top:18px;
        background:#dcfce7;
        color:#15803d;
        font-weight:700;
        padding:10px 20px;
        border-radius:999px;
    }

    .ticket-pass{
        margin-top:15px;
        color:#94a3b8;
        font-size:13px;
        text-align:center;
    }

    .download-ticket{
        width:100%;
        margin-top:25px;
        height:58px;
        border:none;
        border-radius:18px;
        font-weight:700;
        color:white;

        background:
        linear-gradient(
            135deg,
            #2563eb,
            #4f46e5
        );

        box-shadow:
        0 10px 30px rgba(37,99,235,.25);
    }

    /* MOBILE */

    @media(max-width:900px){
        .ticket-modern{
            flex-direction:column;
        }

        .ticket-separator{
            width:100%;
            height:2px;
        }

        .ticket-separator:before,
        .ticket-separator:after{
            top:-20px;
        }

        .ticket-separator:before{
            left:-20px;
        }

        .ticket-separator:after{
            left:auto;
            right:-20px;
        }

        .ticket-right{
            width:100%;
        }

        .ticket-event{
            font-size:26px;
        }

    }

    </style>

    <section class="ticket-page">
        <div class="ticket-container">
            <div class="ticket-header">
                <h1>Digital ticket</h1>
                {{-- <p>
                    Tunjukkan QR Code saat proses check-in
                </p> --}}
            </div>

            <div class="ticket-modern">
                <div class="ticket-left">
                    <div class="ticket-brand">
                        EVENTHUB TICKET
                    </div>

                    {{-- <div class="event-cover">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200">
                    </div> --}}
                    <div class="ticket-event">
                        {{ $event->title }}
                    </div>

                    <div class="ticket-organizer">
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

                    <div class="ticket-meta">
                        <div class="ticket-badge">
                            📅 {{ $event->start_date == $event->end_date ? 
                            date('d-m-Y', strtotime($event->start_date)) : 
                            date('d-m-Y', strtotime($event->start_date)) . ' - ' . date('d-m-Y', strtotime($event->end_date)) }}
                        </div>

                        <div class="ticket-badge">
                            📍 {{ $event->location_jenis == 'Online' ? 'Online' : $event->location_detail . ', ' . $event->location_city . ', ' . $event->province->name }}
                        </div>

                    </div>

                    <div class="ticket-user">
                        <strong>{{ $transaction->name }}</strong>
                        <span>{{ $transaction->email }}</span>
                    </div>

                    {{-- <div class="ticket-id">
                        <div class="ticket-id-label">
                            TICKET ID
                        </div>
                        <strong>
                            {{ $transaction->transaction_id }}
                        </strong>
                    </div> --}}
                </div>

                <div class="ticket-separator"></div>

                <div class="ticket-right">
                    <div class="qr-box">{!! $qrcode !!}</div>
                    <div class="qr-text">Scan QR saat check-in</div>
                    <div class="ticket-status">{{ $transaction->transaction_id }}</div>
                    {{-- <div class="ticket-pass">
                        Digital Event Pass
                    </div> --}}
                </div>
            </div>

            <button type="button" class="download-ticket d-flex align-items-center justify-content-center text-decoration-none"
                data-id-transaksi="{{ $transaction->id }}" id="download-ticket">
                <i class="fas fa-file-pdf mr-1"></i> Download ticket
            </button>
        </div>

        <style>
            .ticket-note-card{
                border:none;
                border-radius:18px;
                background:#ffffff;
                box-shadow:
                    0 8px 24px rgba(15,23,42,.06);
                overflow:hidden;
            }

            .ticket-note-header{
                background:
                linear-gradient(135deg,#eff6ff,#f8fafc);
                border-bottom:1px solid #e2e8f0;
                padding:16px 20px;
                font-weight:700;
                color:#0f172a;
            }

            .ticket-note-body{
                padding:20px;
            }

            .ticket-note-list{
                margin:0;
                padding-left:18px;
            }

            .ticket-note-list li{
                margin-bottom:6px;
                color:#475569;
                line-height:1.7;
                font-size: 14px;
            }

            .ticket-help{
                margin-top:15px;
                padding:12px 15px;
                border-radius:12px;
                background:#f8fafc;
                color:#64748b;
                font-size:14px;
            }
        </style>

        <div class="card ticket-note-card mt-4 mb-4">
            <div class="ticket-note-header">
                🎟️ Informasi Penting
            </div>

            <div class="ticket-note-body">
                <ul class="ticket-note-list">
                    <li>
                        Simpan tiket dan QR Code dengan baik. Jangan membagikan QR Code kepada pihak lain untuk menghindari penyalahgunaan tiket.
                    </li>
                    <li>
                        QR Code akan digunakan untuk proses verifikasi dan check-in peserta saat acara berlangsung.
                    </li>
                    <li>
                        Pastikan data peserta pada tiket sudah benar. Perubahan jadwal, lokasi, atau ketentuan acara mengikuti kebijakan penyelenggara.
                    </li>
                    <li>
                        Dengan menggunakan tiket ini, peserta dianggap telah menyetujui syarat dan ketentuan yang berlaku pada event terkait.
                    </li>
                </ul>

                <div class="ticket-help">
                    <strong>Butuh bantuan?</strong><br>
                    Hubungi penyelenggara acara atau tim dukungan EventHub apabila mengalami kendala terkait tiket maupun registrasi.
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('click', function(e){

            const btn = e.target.closest('#download-ticket');
            if(!btn) return;
            e.preventDefault();
            let id_transaksi = btn.dataset.idTransaksi;
            const hashids = new Hashids('eventhub-secret', 25);
            const hashIdTransaction = hashids.encode(Number(id_transaksi));
            window.location.href = '/download-ticket?id_transaksi=' + hashIdTransaction

        });
        
    //     console.log('script loaded');
    //     console.log('jquery:', typeof $);
    // console.log('jquery2:', typeof jQuery);
    //     $('body').on('click', '#download-ticket', function(e) {
    //         e.preventDefault();
    //         var url = '{{ env('APP_URL_INVOICE') }}';

    //         var id_transaksi = $(this).data('id-transaksi');
    //         console.log(id_transaksi);
            
    //         const hashids = new Hashids('eventhub-secret', 15);
    //         const hashIdTransaction = hashids.encode(id_transaksi);
    //         console.log(hashIdTransaction);
    //         // window.location.href = 'download-ticket?id_transaksi=' + hashIdTransaction + '&url=' + url
    //     })
    </script>

@endsection
