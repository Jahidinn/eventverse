@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white" role="alert">
            <strong>MY EVENT</strong> (Peserta)
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ikut event apapun yang kamu mau! </h3>

            </div>

            <div class="card-body px-3">
                <a href="/search"><button class="btn btn-success mb-2 shadow-none">Jelajah event <i
                            class="far fa-paper-plane"></i></button></a>
                <form action="" method="GET" {{ $myevents->isEmpty() ? 'hidden' : '' }}>
                    <div class="p-0 form-inline mb-4">
                        <input class="form-control col shadow-none mr-1" id="search-myevent" name="key" type="text"
                            placeholder="Cari event yang kamu ikuti ..." value="{{ request('key') }}">
                    </div>
                </form>
                @if ($myevents->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Wah kamu belum <b>ikut event</b> apapun guys!
                    </div>
                @endif

                {{-- Looping data my event --}}
                @foreach ($myevents as $myevent)
                    <div class="card mt-2 ">
                        <div class="col-md-12 row card-body px-3 pb-3">

                            {{-- Poster / Image --}}
                            <div class="p-2">
                                <div class="myevent-container-img">
                                    <img class="card-img-top"
                                        src="{{ asset('storage/event-images/' . $myevent->event->image) }}"
                                        alt="Card image cap">
                                </div>
                            </div>

                            <div class="col">
                                {{-- Event --}}
                                @php
                                    $title = $myevent->event->title ?? '' . ' (' . $myevent->ticket->ticket_name . ')';
                                    if (strlen($title) > 50) {
                                        $title = substr($title, 0, 50) . '...';
                                    }
                                @endphp
                                <a href="/{{ $myevent->event->slug }}"
                                    class="text-info text-decoration-none title-manage-event"><b>{{ $title }}</b></a>

                                <br>

                                {{-- Status --}}
                                @if ($myevent->status == 'Paid')
                                    {{-- IF PAID --}}
                                    <small>
                                        <b class="text-success"><i class="fas fa-check-circle"></i> BERHASIL</b>
                                    </small>
                                @elseif($myevent->status == 'Unpaid')
                                    {{-- IF UNPAID --}}
                                    <small>
                                        <b class="text-secondary"><i class="fas fa-times-circle"></i> Unpaid</b>
                                    </small>
                                @elseif($myevent->status == 'Pending')
                                    {{-- IF PENDING --}}
                                    <small>
                                        <b class="text-warning"><i class="fas fa-times-circle"></i> PENDING</b>
                                    </small>
                                @elseif($myevent->status == 'Expired')
                                    {{-- IF EXPIRED --}}
                                    <small>
                                        <b class="text-danger"><i class="fas fa-times-circle"></i> EXPIRED</b>
                                    </small>
                                @else
                                    {{-- ELSE --}}
                                    <small>
                                        <b class="text-warning"><i class="fas fa-info-circle"></i> $myevent->status</b>
                                    </small>
                                @endif
                                <br>

                                @php

                                    $tanggalHariIni = date('Y-m-d');

                                @endphp

                                <div class="mt-2">
                                    {{-- button action --}}
                                    @if ($myevent->status == 'Paid')
                                        {{-- IF PAID --}}
                                        <button type="button" class="btn btn-outline-info btn-sm rounded-0 info-myevent"
                                            data-id="{{ $myevent->id }}" data-event="{{ $myevent->event->id }}">
                                            <i class="fas fa-list"></i> Detail
                                        </button>
                                        @if ($myevent->event->end_date < $tanggalHariIni)
                                            <button type="button" class="btn btn-info btn-sm rounded-0" disabled>
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-info btn-sm rounded-0 edit-myevent"
                                                data-id="{{ $myevent->id }}" data-event="{{ $myevent->event->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-success btn-sm rounded-0 detail-myevent"
                                            data-id="{{ $myevent->id }}">
                                            <i class="far fa-file-alt"></i> Inv
                                        </button>
                                    @elseif($myevent->status == 'Unpaid')
                                        {{-- IF UNPAID --}}
                                        <button type="button" class="btn btn-info btn-sm rounded-0 lanjutkan-transaksi"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-wallet"></i> Bayar
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm rounded-0 detail-myevent"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"></i></button>
                                        <button type="button" class="btn btn-danger rounded-0 btn-sm" id="delete-myevent"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @elseif($myevent->status == 'Pending')
                                        {{-- IF PENDING --}}
                                        <button type="button" class="btn btn-info btn-sm rounded-0 lanjutkan-transaksi"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-wallet"></i> Bayar
                                        </button>
                                        <button type="button" class="btn btn-info rounded-0 btn-sm"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"
                                                detail-myevent></i></button>
                                    @elseif($myevent->status == 'Expired')
                                        {{-- IF EXPIRED --}}
                                        <button type="button" class="btn btn-info btn-sm rounded-0 detail-myevent"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"></i> Lihat detail</button>
                                        <button type="button" class="btn btn-danger btn-sm rounded-0" disabled
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @else
                                        {{-- ELSE --}}
                                        <button type="button" class="btn btn-info btn-sm rounded-0"
                                            data-id="{{ $myevent->id }}">
                                            {{ $myevent->status }}
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm detail-myevent rounded-0"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"></i></button>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <hr class="mx-2 my-0">
                        <div class="col-md-12 card-body py-2 px-3">
                            <small class="text-secondary">
                                <b>Rp <span>{{ number_format($myevent->total_price, 0, ',', '.') }}
                                    </span></b> (Qty :
                                <span>{{ $myevent->quantity }}</span>)

                            </small>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $myevents->links() }}
                </div>
                {{-- Pagination --}}

            </div>
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
                            Event
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
                            Event
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
