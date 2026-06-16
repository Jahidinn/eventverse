@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="page-header-modern mb-3">
            <div class="page-header-left">

                <div class="page-header-icon">
                    <i class="ti ti-ticket"></i>
                </div>

                <h2 class="page-header-title">
                    MEMBER EVENT
                </h2>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <style>
            .joined-toolbar{
                display:flex;
                gap:12px;
                align-items:center;
                justify-content:space-between;
                flex-wrap:wrap;
                margin-bottom:20px;
            }

            .search-modern{
                height:50px;
                border:none;
                border-radius:16px;
                background:#fff;
                box-shadow:0 4px 20px rgba(0,0,0,.06);
                padding-left:18px;
            }

            .search-modern:focus{
                box-shadow:0 0 0 4px rgba(59,130,246,.10);
            }

            .joined-card{
                border:none;
                border-radius:22px;
                overflow:hidden;

                background:#fff;

                box-shadow:
                    0 4px 20px rgba(0,0,0,.06);

                transition:.25s;

                margin-bottom:20px;
            }

            .joined-card:hover{
                transform:translateY(-3px);

                box-shadow:
                    0 14px 40px rgba(0,0,0,.10);
            }

            .joined-cover{
                width:100%;
                height:180px;
                object-fit:cover;
                display:block;
            }

            .joined-body{
                padding:20px;
            }

            .joined-title{
                font-size:18px;
                font-weight:700;
                color:#0f172a;
                line-height:1.5;
            }

            .status-chip{
                display:inline-flex;
                align-items:center;
                gap:6px;

                padding:4px 14px;

                border-radius:999px;

                font-size:12px;
                font-weight:600;
            }

            .status-paid{
                background:rgba(16,185,129,.08);
                border:1px solid rgba(16,185,129,.15);
                color:#059669;
            }

            .status-pending{
                background:rgba(245,158,11,.08);
                border:1px solid rgba(245,158,11,.15);
                color:#d97706;
            }

            .status-unpaid{
                background:rgba(100,116,139,.08);
                border:1px solid rgba(100,116,139,.15);
                color:#475569;
            }

            .status-expired{
                background:rgba(239,68,68,.08);
                border:1px solid rgba(239,68,68,.15);
                color:#dc2626;
            }

            .ticket-card{
                margin-top:16px;

                padding:14px;

                background:#f8fafc;

                border-radius:14px;
            }

            .ticket-name{
                color:#64748b;
                font-size:14px;
            }

            .ticket-price{
                font-size:22px;
                font-weight:700;
                color:#0f172a;
            }

            .ticket-qty{
                font-size:13px;
                color:#64748b;
            }

            .joined-actions{
                display:flex;
                gap:8px;
                flex-wrap:wrap;
                margin-top:16px;
            }

            .action-text{
                margin-left:4px;
            }

            .empty-state{
                background:#fff;
                border-radius:20px;
                padding:30px;
                text-align:center;
                box-shadow:0 4px 20px rgba(0,0,0,.05);
            }

            @media(max-width:768px){

                .joined-cover{
                    height:140px;
                }

                .joined-title{
                    font-size:16px;
                }

                .joined-actions{
                    display:grid;
                    grid-template-columns:repeat(4,1fr);
                    gap:8px;
                }

                .joined-actions .button-39{
                    width:100%;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                }

                .action-text{
                    display:none;
                }

                .joined-actions i{
                    margin:0 !important;
                    font-size:18px;
                }
            }
        </style>

        <div class="joined-toolbar">

            <a href="/search" class="button-40">
                <i class="ti ti-search ti-sm"></i>
                Jelajah Event
            </a>

            <form action="" method="GET" class="flex-grow-1">

                <input
                    class="form-control search-modern shadow-none"
                    id="search-myevent"
                    name="key"
                    type="text"
                    placeholder="Cari event yang kamu ikuti..."
                    value="{{ request('key') }}">

            </form>

        </div>

        @if ($myevents->isEmpty())

            <div class="empty-state">

                <h5>Belum ada event 🎉</h5>

                <p class="text-muted mb-0">
                    Kamu belum mengikuti event apa pun.
                </p>

            </div>

        @endif

        @foreach ($myevents as $myevent)

            @php

                $title = ($myevent->event->title ?? '') . ' (' . $myevent->ticket->ticket_name . ')';

                if(strlen($title) > 70){
                    $title = substr($title,0,70).'...';
                }

                $tanggalHariIni = date('Y-m-d');

            @endphp

            <div class="card joined-card">

                <img
                    src="{{ asset('storage/event-images/' . $myevent->event->image) }}"
                    class="joined-cover"
                    alt="{{ $myevent->event->title }}">

                <div class="joined-body">

                    <a
                        href="/{{ $myevent->event->slug }}"
                        class="joined-title text-decoration-none">

                        {{ $title }}

                    </a>

                    <div class="ticket-card">

                        <div class="ticket-name mb-2">
                            {{ $myevent->ticket->ticket_name }}
                        </div>

                        <div class="ticket-price">
                            Rp {{ number_format($myevent->total_price,0,',','.') }}

                            @if($myevent->status == 'Paid')

                                <div class="status-chip status-paid">
                                    <i class="ti ti-circle-check ti-sm"></i>
                                    Berhasil
                                </div>

                            @elseif($myevent->status == 'Pending')

                                <div class="status-chip status-pending">
                                    <i class="ti ti-clock ti-sm"></i>
                                    Pending
                                </div>

                            @elseif($myevent->status == 'Unpaid')

                                <div class="status-chip status-unpaid">
                                    <i class="ti ti-credit-card ti-sm"></i>
                                    Belum Bayar
                                </div>

                            @elseif($myevent->status == 'Expired')

                                <div class="status-chip status-expired">
                                    <i class="ti ti-alert-circle ti-sm"></i>
                                    Expired
                                </div>

                            @endif
                        </div>

                        <div class="ticket-qty">
                            Qty {{ $myevent->quantity }}
                        </div>

                    </div>

                    <div class="joined-actions">

                        @if ($myevent->status == 'Paid')

                            <button
                                type="button"
                                class="button-39 text-info info-myevent"
                                data-id="{{ $myevent->id }}"
                                data-event="{{ $myevent->event->id }}"
                                title="Detail">

                                <i class="ti ti-list ti-sm"></i>
                                <span class="action-text">Detail</span>

                            </button>

                            @if ($myevent->event->end_date > $tanggalHariIni)

                                <button
                                    type="button"
                                    class="button-39"
                                    disabled>

                                    <i class="ti ti-edit ti-sm"></i>
                                    <span class="action-text">Edit</span>

                                </button>

                            @else

                                <button
                                    type="button"
                                    class="button-39 edit-myevent"
                                    data-id="{{ $myevent->id }}"
                                    data-event="{{ $myevent->event->id }}">

                                    <i class="ti ti-edit ti-sm"></i>
                                    <span class="action-text">Edit</span>

                                </button>

                            @endif

                            <button
                                type="button"
                                class="button-39 detail-myevent"
                                data-id="{{ $myevent->id }}">

                                <i class="ti ti-file-description ti-sm"></i>
                                <span class="action-text">Invoice</span>

                            </button>

                        @elseif($myevent->status == 'Unpaid')

                            <button
                                type="button"
                                class="button-39 bg-success lanjutkan-transaksi"
                                data-id="{{ $myevent->id }}">

                                <i class="ti ti-coin"></i>
                                <span class="action-text">Bayar</span>

                            </button>

                            <button
                                type="button"
                                class="button-39 text-info detail-myevent"
                                data-id="{{ $myevent->id }}">

                                <i class="fas fa-list"></i>
                                <span class="action-text">Detail</span>

                            </button>

                            <button
                                type="button"
                                class="button-39 text-danger"
                                id="delete-myevent"
                                data-id="{{ $myevent->id }}">

                                <i class="fas fa-trash-alt"></i>
                                <span class="action-text">Hapus</span>

                            </button>

                        @elseif($myevent->status == 'Pending')

                            <button
                                type="button"
                                class="button-39 bg-success lanjutkan-transaksi"
                                data-id="{{ $myevent->id }}">

                                <i class="ti ti-coin ti-sm"></i>
                                <span class="action-text">Bayar</span>

                            </button>

                            <button
                                type="button"
                                class="button-39 text-info detail-myevent"
                                data-id="{{ $myevent->id }}">

                                <i class="ti ti-list ti-sm"></i>
                                <span class="action-text">Detail</span>

                            </button>

                        @elseif($myevent->status == 'Expired')

                            <button
                                type="button"
                                class="button-39 text-info detail-myevent"
                                data-id="{{ $myevent->id }}">

                                <i class="ti ti-list ti-sm"></i>
                                <span class="action-text">Detail</span>

                            </button>

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $myevents->links() }}
        </div>

        </section>

    {{-- modal detail form pendaftaran --}}
    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail <b>Transaksi</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            Nama event
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-info detail-trx-title">...</h5>
                            <p class="card-text">Status pembayaran <b class="text-success detail-trx-status">...</b>
                            </p>
                        </div>
                    </div>
                    <div id="detail-trx-container">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit form pendaftaran --}}
    <!-- Modal -->
    <div class="modal fade" id="editFormModal" tabindex="-1" aria-labelledby="editFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFormModalLabel">Edit <b>form pendaftaran</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            Nama event
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-info edit-trx-title">...</h5>
                            </p>
                        </div>
                    </div>
                    <div id="edit-trx-container">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal konfirmasi checkout -->
    @include('apps.components.modal-checkout')

    @if (Session::has('popup'))
        <script type="text/javascript">
            alertify.alert("Sukses!", "{{ session()->get('popup') }}");
        </script>
    @endif

    {{-- Push javascript --}}
    @push('js-myevent')
        @include('apps.js.payment-process')
    @endpush

    {{-- Push javascript --}}
    @push('js-myevent')
        @include('dashboard.js.js-myevent')
    @endpush
@endsection
