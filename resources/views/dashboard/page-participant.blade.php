@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="page-header-modern mb-3">
            <div class="page-header-left">

                <div class="page-header-icon">
                    <i class="ti ti-users"></i>
                </div>

                <h2 class="page-header-title">
                    DATA PESERTA
                </h2>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        {{-- <div class="card bg-secondar"> --}}
            {{-- <div class="card-header">
                <h3 class="card-title">Kelola data peserta dengan mudah! </h3>

            </div> --}}

            <style>
                .search-modern{
                    height:50px;
                    border:none;
                    border-radius:16px;
                    background:#fff;
                    box-shadow:0 4px 16px rgba(0,0,0,.05);
                    padding-left:18px;
                }

                .search-modern:focus{
                    box-shadow:0 0 0 4px rgba(13,110,253,.08);
                }

                .my-event-card{
                    border:none;
                    border-radius:18px;
                    overflow:hidden;

                    background:#fff;

                    box-shadow:
                        0 4px 20px rgba(0,0,0,.05);

                    transition:.25s;
                }

                .my-event-card:hover{
                    transform:translateY(-2px);

                    box-shadow:
                        0 12px 32px rgba(0,0,0,.08);
                }

                .my-event-image{
                    width:100%;
                    height:120px;

                    object-fit:cover;

                    border-radius:14px;
                }

                .event-title-modern{
                    font-size:16px;
                    font-weight:700;
                    line-height:1.5;

                    color:#1e293b;
                }

                .participant-pill{
                    display:inline-flex;
                    align-items:center;

                    gap:6px;

                    padding:7px 12px;

                    border-radius:999px;

                    background:#ecfdf5;

                    color:#059669;

                    font-size:13px;
                    font-weight:600;
                }

                .event-action{
                    margin-top:12px;
                }

                .empty-event{
                    border:none;
                    border-radius:16px;

                    background:#fff8e1;

                    color:#8a6d3b;

                    padding:18px;

                    box-shadow:0 4px 16px rgba(0,0,0,.04);
                }
            </style>

            <div class="px-1 daftar-event text-dark">

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

                    <div class="empty-event">

                        Wah kamu belum <b>punya event</b> sob!

                        <a
                            href="/event/create"
                            class="text-primary text-decoration-none font-weight-bold">

                            Buat event
                            <i class="fas fa-paper-plane"></i>

                        </a>

                    </div>

                @endif

                @foreach ($dataEvent as $event)

                    @php
                        $participant = \App\Models\Transaction::where('event_id', $event->id)
                            ->whereNotIn('status', ['Expired', 'Unpaid', 'Pending'])
                            ->count();

                        $title = $event->title;

                        if(strlen($title) > 60){
                            $title = substr($title,0,60).'...';
                        }
                    @endphp

                    <div class="card my-event-card mt-3">

                        <div class="card-body p-3">

                            <div class="row align-items-center">

                                <div class="col-md-3 col-4">

                                    <img
                                        src="{{ asset('storage/event-images/' . $event->image) }}"
                                        class="my-event-image"
                                        alt="{{ $event->title }}">

                                </div>

                                <div class="col-md-9 col-8">

                                    <div class="event-title-modern mb-3">

                                        {{ $title }}

                                    </div>

                                    <div class="participant-pill">

                                        <i class="ti ti-users"></i>

                                        {{ $participant }} Peserta

                                    </div>

                                    <div class="event-action">

                                        <button
                                            type="button"
                                            class="button-40 detail-peserta"
                                            data-id="{{ $event->id }}"
                                            data-participant="{{ $participant }}"
                                            data-title="{{ $event->title }}">

                                            <i class="ti ti-user-share"></i>

                                            Detail Peserta

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

                <div class="d-flex justify-content-center mt-4">

                    {{ $dataEvent->links() }}

                </div>

            </div>

            {{--  --}}

            <style>
                .participant-wrapper{
                    background:#fff;
                    border-radius:18px;
                    padding:20px;
                    box-shadow:0 8px 30px rgba(0,0,0,.06);
                }

                .participant-toolbar{
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    flex-wrap:wrap;
                    gap:10px;
                    margin-bottom:20px;
                }

                .participant-summary{
                    display:flex;
                    justify-content:space-between;
                    align-items:center;

                    background:linear-gradient(
                        135deg,
                        #ffffff,
                        #f8fbff
                    );

                    border:1px solid #edf2f7;
                    border-radius:16px;

                    padding:18px 22px;
                    margin-bottom:20px;
                }

                .participant-summary .event-title{
                    font-size:18px;
                    font-weight:700;
                    color:#1e293b;
                }

                .participant-summary .total{
                    text-align:right;
                }

                .participant-summary .total small{
                    display:block;
                    color:#64748b;
                }

                .participant-summary .total h4{
                    margin:0;
                    font-weight:700;
                    color:#10b981;
                }

                .search-card{
                    background:#fff;
                    border:1px solid #e5e7eb;
                    border-radius:14px;
                    padding:6px;
                    margin-bottom:15px;
                    box-shadow:0 2px 10px rgba(0,0,0,.03);
                }

                .search-card .input-group-text{
                    background:#fff;
                    border:none;
                    color:#64748b;
                }

                .search-card .form-control{
                    border:none;
                    box-shadow:none !important;
                    height:48px;
                }

                .search-card .btn{
                    border-radius:10px;
                }

                .participant-note{
                    background:#fff8e1;
                    color:#92400e;
                    border-radius:10px;
                    padding:10px 14px;
                    font-size:13px;
                    margin-bottom:15px;
                }

                .table-card{
                    background:#fff;
                    border-radius:16px;
                    overflow:hidden;
                    box-shadow:0 4px 20px rgba(0,0,0,.05);
                }

                #data-peserta{
                    margin-bottom:0 !important;
                }

                #data-peserta thead th{
                    background:#f8fafc !important;
                    color:#475569;
                    border:none !important;

                    font-size:12px;
                    font-weight:700;

                    text-transform:uppercase;
                    letter-spacing:.5px;

                    padding:15px;
                }

                #data-peserta tbody td{
                    padding:15px;
                    vertical-align:middle;
                    border-color:#eef2f7;
                }

                #data-peserta tbody tr{
                    transition:.2s;
                }

                #data-peserta tbody tr:hover{
                    background:#f8fafc;
                }

                @media(max-width:768px){

                    .participant-summary{
                        flex-direction:column;
                        align-items:flex-start;
                        gap:12px;
                    }

                    .participant-summary .total{
                        text-align:left;
                    }
                }
            </style>

            <div class="card-body p-0 daftar-peserta" hidden>

                <div class="participant-wrapper">

                    <div class="participant-toolbar">
                        <div>
                            <button class="button-39 kembali">
                                <i class="fas fa-chevron-circle-left"></i>
                                Kembali
                            </button>

                            <button class="button-39 text-success download-participant-data">
                                <i class="fas fa-file-excel"></i>
                                Download Data
                            </button>
                        </div>
                    </div>

                    <div class="participant-summary">

                        <div>
                            <div class="event-title title-daftar-peserta">
                                Nama Event
                            </div>
                        </div>

                        <div class="total">
                            <small>Total Peserta</small>
                            <h4 class="jumlah-peserta">000</h4>
                        </div>

                    </div>

                    <div class="search-card">

                        <div class="input-group">

                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>

                            <input
                                type="text"
                                class="form-control mr-2"
                                placeholder="Cari nama, email, ID peserta..."
                                id="search-participant">

                            <div class="input-group-append">
                                <button
                                    class="button-39 mt-1"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#filterModal">

                                    <i class="fas fa-filter"></i>
                                    Filter
                                </button>
                            </div>

                        </div>

                    </div>

                    <div class="participant-note">
                        <i class="fas fa-info-circle mr-1"></i>
                        Klik header tabel untuk mengelompokkan data berdasarkan kolom yang dipilih.
                    </div>

                    <div class="table-responsive pb-3">

                        <table class="table table-hover w-100 mb-3" id="data-peserta">

                            <thead>
                                <tr>
                                    <th style="min-width:30px">No</th>
                                    <th style="min-width:150px">Name</th>
                                    <th style="min-width:150px">Email</th>
                                    <th style="min-width:150px">ID</th>
                                    <th style="min-width:150px">Regist Date</th>
                                    <th style="min-width:90px">Status</th>
                                    <th style="min-width:110px">Detail</th>
                                </tr>
                            </thead>

                        </table>

                    </div>

                </div>

            </div>
        {{-- </div> --}}
    </section>

    <!-- Detail peserta transaksi -->
    <div class="modal fade" id="detailTransaksiModal" tabindex="-1" aria-labelledby="detailTransaksiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTransaksiModalLabel">Detail peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body data-pendaftar">
                    <div class="row">
                        <div class="col-4">Nama <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-name"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Email <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-email"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">No HP <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-phone"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Tiket <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-ticket"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Biaya <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-biaya"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">ID <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-id text-info"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Status <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-status"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Pembayaran <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-pembayaran"></b></div>
                    </div>
                    <hr>
                    {{-- Value custom form --}}
                    <div id="data-custom-form">
                        <div class="row">
                            <div class="col-4"><span></span> <span class="float-right">:</span></div>
                            <div class="col-8 pl-0"><b></b></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Filter-->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="filter-value">
                            <option value="">Semua status</option>
                            <option value="Sukses">Sukses</option>
                            <option value="Pending">Pending</option>
                            <option value="Expired">Expired</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="get-filter"><i class="fas fa-filter"></i>
                        Filter</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    @push('js-participant')
        @include('dashboard.js.js-participant')
    @endpush

    {{-- Push javascript --}}
    @push('js-myevent')
        @include('dashboard.js.js-myevent')
    @endpush
@endsection
