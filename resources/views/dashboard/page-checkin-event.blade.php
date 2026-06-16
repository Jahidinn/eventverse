@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="page-header-modern mb-3">
            <div class="page-header-left">

                <div class="page-header-icon">
                    <i class="ti ti-user-check"></i>
                </div>

                <h2 class="page-header-title">
                    CHECK IN PESERTA
                </h2>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <style>

        .search-modern{
            height:50px;
            border:none;
            border-radius:16px;
            background:#fff;
            box-shadow:0 4px 20px rgba(0,0,0,.06);
            padding-left:18px;
        }

        .search-modern:focus{
            box-shadow:0 0 0 4px rgba(59,130,246,.08);
        }

        .checkin-card{
            border:none;
            border-radius:22px;
            overflow:hidden;
            background:#fff;
            box-shadow:0 4px 20px rgba(0,0,0,.06);
            transition:.25s;
            margin-bottom:18px;
        }

        .checkin-card:hover{
            transform:translateY(-3px);
            box-shadow:0 14px 40px rgba(0,0,0,.10);
        }

        .checkin-cover{
            width:100%;
            height:180px;
            object-fit:cover;
            display:block;
        }

        .checkin-body{
            padding:20px;
        }

        .checkin-title{
            font-size:18px;
            font-weight:700;
            color:#0f172a;
            line-height:1.5;
        }

        .checkin-chip{
            display:inline-flex;
            align-items:center;
            gap:6px;

            margin-top:12px;

            padding:8px 14px;

            border-radius:999px;

            background:rgba(16,185,129,.08);

            color:#059669;

            border:1px solid rgba(16,185,129,.12);

            font-size:13px;
            font-weight:600;
        }

        .checkin-action{
            margin-top:18px;
        }

        .empty-state{
            background:#fff;
            border-radius:20px;
            padding:30px;
            text-align:center;
            box-shadow:0 4px 20px rgba(0,0,0,.05);
        }

        .scanner-card{
            background:#fff;
            border-radius:22px;
            padding:20px;
            box-shadow:0 4px 20px rgba(0,0,0,.06);
            margin-bottom:20px;
        }

        .scanner-title{
            font-size:18px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:15px;
        }

        .scanner-subtitle{
            color:#64748b;
            font-size:14px;
            margin-bottom:18px;
        }

        .scanner-input{
            height:60px;
            border:none;
            border-radius:18px;
            background:#f8fafc;
            font-size:18px;
        }

        .table-card{
            background:#fff;
            border-radius:22px;
            overflow:hidden;
            box-shadow:0 4px 20px rgba(0,0,0,.06);
        }

        #data-peserta{
            margin-bottom:0 !important;
        }

        #data-peserta thead th{
            background:#f8fafc !important;
            border:none !important;
            color:#475569;

            text-transform:uppercase;

            font-size:12px;
            letter-spacing:.5px;
            font-weight:700;

            padding:16px;
        }

        #data-peserta tbody td{
            padding:15px;
            vertical-align:middle;
        }

        #data-peserta tbody tr:hover{
            background:#f8fafc;
        }

        @media(max-width:768px){

            .checkin-cover{
                height:140px;
            }

            .checkin-title{
                font-size:16px;
            }

            .scanner-input{
                font-size:16px;
                height:55px;
            }
        }

        </style>

        <div class="card-body p-0 daftar-event text-dark bg-card-blue">

            <form action="" method="GET" {{ $dataEvent->isEmpty() ? 'hidden' : '' }}>

                <div class="mb-4">

                    <input
                        class="form-control search-modern shadow-none"
                        id="search-myevent"
                        name="key"
                        type="search"
                        placeholder="🔍 Cari event..."
                        value="{{ request('key') }}">

                </div>

            </form>

            @if ($dataEvent->isEmpty())

                <div class="empty-state">

                    <h5>Belum ada event 🎉</h5>

                    <p class="text-muted mb-3">
                        Kamu belum mempunyai event.
                    </p>

                    <a href="/event/create" class="button-40">

                        <i class="ti ti-plus"></i>

                        Buat Event

                    </a>

                </div>

            @endif

            @foreach ($dataEvent as $event)

                @php

                    $title = $event->title;

                    if(strlen($title) > 60){
                        $title = substr($title,0,60).'...';
                    }

                    $participant = \App\Models\Transaction::where('event_id',$event->id)
                        ->where('status','Paid')
                        ->count();

                @endphp

                <div class="card checkin-card">

                    <img
                        src="{{ asset('storage/event-images/' . $event->image) }}"
                        class="checkin-cover"
                        alt="{{ $event->title }}">

                    <div class="checkin-body">

                        <div class="checkin-title">

                            {{ $title }}

                        </div>

                        <div class="checkin-chip">

                            <i class="ti ti-users"></i>

                            {{ number_format($participant,0,',','.') }}
                            Peserta

                        </div>

                        <div class="checkin-action">

                            <button
                                type="button"
                                class="button-40 detail-peserta"
                                data-id="{{ $event->id }}"
                                data-participant="{{ $participant }}"
                                data-title="{{ $event->title }}">

                                <i class="fas fa-check-circle"></i>

                                Check-In Peserta

                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

            <div class="d-flex justify-content-center mt-4">

                {{ $dataEvent->links() }}

            </div>

        </div>

        <div class="card-body p-0 daftar-peserta" hidden>

            <button class="button-39 kembali mb-2">
                <i class="fas fa-chevron-circle-left"></i>
                Kembali
            </button>

            <div class="scanner-card">

                <div class="scanner-title">

                    <i class="fas fa-qrcode text-primary"></i>

                    Check-In Peserta

                </div>

                <div class="scanner-subtitle">

                    Scan QR Code atau input ID peserta untuk melakukan check-in.

                </div>

                <form action="javascript:void(0)" id="checkin-form">

                    <input
                        type="text"
                        class="form-control scanner-input shadow-none"
                        placeholder="Scan QR atau input ID peserta..."
                        id="search-transaction">

                </form>

            </div>

            <div class="table-card">

                <div class="table-responsive">

                    <table class="table w-100" id="data-peserta">

                        <thead>

                            <tr>
                                <th style="min-width:150px">Nama Peserta</th>
                                <th style="min-width:150px">Email</th>
                                <th style="min-width:150px">ID</th>
                                <th style="min-width:100px">Check In</th>
                            </tr>

                        </thead>

                    </table>

                </div>

            </div>

        </div>

    </section>

    {{-- Push javascript --}}
    @push('js-checkin')
        @include('dashboard.js.js-page-checkin')
    @endpush

    {{-- Push javascript --}}
    @push('js-myevent')
        @include('dashboard.js.js-myevent')
    @endpush
@endsection
