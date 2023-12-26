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
                <form action="" method="GET">
                    <div class="p-0 form-inline mb-4">
                        <input class="form-control col shadow-none mr-1" id="search-myevent" name="key" type="text"
                            placeholder="Cari event yang kamu ikuti ..." value="{{ request('key') }}">
                    </div>
                </form>

                {{-- Looping data my event --}}
                @foreach ($myevents as $myevent)
                    <div class="card mt-2 ">
                        <div class="col-md-12 row card-body px-3 pb-3">
                            <div class="col-9">
                                {{-- Event --}}
                                <small>
                                    @php
                                        $title = $myevent->event->title . ' (' . $myevent->ticket->ticket_name . ')';
                                        if (strlen($title) > 50) {
                                            $title = substr($title, 0, 50) . '...';
                                        }
                                    @endphp
                                    {{ $title }}
                                </small>
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

                                <div class="mt-2">
                                    {{-- button action --}}
                                    @if ($myevent->status == 'Paid')
                                        {{-- IF PAID --}}
                                        <button type="button" class="btn btn-info btn-sm detail-myevent"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-list"></i> Lihat detail
                                        </button>
                                    @elseif($myevent->status == 'Unpaid')
                                        {{-- IF UNPAID --}}
                                        <button type="button" class="btn btn-info btn-sm lanjutkan-transaksi"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-wallet"></i> Bayar
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm detail-myevent"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" id="delete-myevent"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @elseif($myevent->status == 'Pending')
                                        {{-- IF PENDING --}}
                                        <button type="button" class="btn btn-info btn-sm lanjutkan-transaksi"
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-wallet"></i> Bayar
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm" data-id="{{ $myevent->id }}"><i
                                                class="fas fa-list" detail-myevent></i></button>
                                    @elseif($myevent->status == 'Expired')
                                        {{-- IF EXPIRED --}}
                                        <button type="button" class="btn btn-info btn-sm detail-myevent"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" disabled
                                            data-id="{{ $myevent->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @else
                                        {{-- ELSE --}}
                                        <button type="button" class="btn btn-info btn-sm" data-id="{{ $myevent->id }}">
                                            {{ $myevent->status }}
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm detail-myevent"
                                            data-id="{{ $myevent->id }}"><i class="fas fa-list"></i></button>
                                    @endif

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="myevent-container-img">
                                    <img class="card-img-top"
                                        src="{{ asset('storage/event-images/' . $myevent->event->image) }}"
                                        alt="Card image cap">
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
