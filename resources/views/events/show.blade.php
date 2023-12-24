{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    {{-- Alert ketika sukses edit --}}
    @if (session()->has('success'))
        <script>
            alertify.alert("Sukses!", "<i class='fas fa-check-square text-success'></i> {{ session('success') }}");
        </script>
    @endif


    <div class="container pt-4 pb-3 px-0 ">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row m-0 p-0">
            <div class="col-md-8 m-0 p-1">

                <div class="card shadow mb-3 mx-1">
                    <div class="view-image-event position-relative">
                        <img src="{{ asset('storage/event-images/' . $detailEvent->image) }}" class="card-img-top"
                            alt="...">
                        <button class="btn btn-dark rounded-0 position-absolute" data-toggle="modal"
                            data-target="#fullImageModal"><i class="fas fa-expand"></i></button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mt-3 mb-0">{{ $detailEvent->title }}</h5>
                        <a href="">
                            <small>
                                <strong> <i
                                        class="fas fa-user-circle mr-1 text-secondary"></i>{{ $detailEvent->penyelenggara->name }}</strong>
                            </small>
                        </a>
                        <hr>

                        <div class="row">
                            <div class="col-md-4 row mt-1">
                                <div class="col-auto pr-0"><i class="fas fa-map-marker-alt mr-2"></i></div>
                                <div class="col p-0 pr-1">
                                    <small>{{ $detailEvent->location_jenis == 'Online' ? 'Online' : $detailEvent->location_detail . ', ' . $detailEvent->location_city . ',  ' . $detailEvent->province->name }}</small>
                                </div>
                            </div>
                            <div class="col-md-4 row mt-1">
                                <div class="col-auto pr-0">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                </div>
                                <div class="col p-0 pr-1">
                                    <small>
                                        {{ $detailEvent->start_date == $detailEvent->end_date ? date('d-m-Y', strtotime($detailEvent->start_date)) : date('d-m-Y', strtotime($detailEvent->start_date)) . ' - ' . date('d-m-Y', strtotime($detailEvent->end_date)) }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 row mt-1">
                                <div class="col-auto pr-0"> <i class="fas fa-list mr-2"></i></div>
                                <div class="col p-0 pr-1"><small>{{ $detailEvent->categories->category }}</small></div>
                            </div>
                        </div>

                        <hr>

                        <p class="card-text"><small class="text-muted">Posted
                                {{ $detailEvent->created_at->diffForHumans() }}</small></p>
                    </div>
                </div>

                <div class="card mb-3 mx-1 shadow">
                    <div class="card-body p-3">
                        <div class="col-md-12 row tabs mb-4">
                            <div class="col px-0">
                                <button class="tab-link current w-100 m-0 py-2" data-tab="tab-1">Deskripsi event</button>
                            </div>
                            <div class="col p-0">
                                <button class="tab-link w-100 py-2" data-tab="tab-2">Tiket</button>
                            </div>
                        </div>

                        <div id="tab-1" class="tab-content current p-0">
                            <div>
                                <h5 class="card-title">Deskripsi</h5>
                                <p class="card-text">
                                <article>
                                    {!! $detailEvent->description !!}
                                </article>
                                </p>
                            </div>
                            <div class="mt-4">
                                <h5 class="card-title">Syarat & ketentuan</h5>
                                <p class="card-text">
                                <article>
                                    {!! $detailEvent->terms !!}
                                </article>
                                </p>
                                <p class="card-text"><small class="text-muted"></small></p>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content p-0">
                            <h5 class="card-title">Ticket</h5>

                            @foreach ($ticketData as $ticket)
                                <div class="card shadow-sm ticket-card mt-3" id="ticket-example">
                                    <div class="card-body p-3">
                                        <small>
                                            <div class="alert alert-info w-100 py-1 pl-2">
                                                <strong>{{ $ticket->ticket_name }}</strong>
                                            </div>
                                        </small>
                                        <hr class="dashed">
                                        @php
                                            $ticketUsed = count($ticketTransaction->where('ticket_id', $ticket->id));
                                            $ticketQuota = $ticket->ticket_quota - $ticketUsed;

                                            $tanggalSekarang = $dateNow;
                                            $deadline = $ticket->ticket_deadline;

                                        @endphp
                                        <p class="card-text pt-0">
                                            <small class="text-muted icon-class">
                                                <span class="text-white">
                                                    <i class="fas fa-hourglass-end pr-1"></i>
                                                    Berakhir : <strong>{{ $deadline }}</strong>
                                                </span>
                                                <span class="alert alert-info py-1 px-2 ms-1 ml-1">
                                                    Kuota :
                                                    <strong>{{ $ticketQuota }}</strong>
                                                </span>
                                            </small>
                                        </p>
                                        <hr class="dashed">
                                        <div class="row">
                                            <div class="col">
                                                <span class="badge badge-secondary py-2 rounded-0 ">
                                                    <strong><i class="fas fa-tag"></i> Rp
                                                        {{ number_format($ticket->ticket_price, 0, ',', '.') }}</strong>
                                                </span>
                                            </div>
                                            <div class="col text-right">
                                                @if ($ticketQuota <= 0)
                                                    <button class="btn btn-danger bg-none btn-sm ticket-button not-allowed"
                                                        disabled>Kuota FULL
                                                    </button>
                                                @elseif($deadline < $tanggalSekarang)
                                                    <button class="btn btn-danger bg-none btn-sm ticket-button not-allowed"
                                                        disabled>Sudah berakhir!
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-sm ticket-button"
                                                        data-id="{{ $ticket->id }}"
                                                        data-event_id="{{ $detailEvent->id }}"
                                                        data-label_button="{{ $ticket->ticket_button }}">{{ $ticket->ticket_button }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 m-0 p-1 ">

                <div class="card mx-1 shadow">
                    <div class="card-body">
                        <h5>A propos de l'auteur</h5>
                        <hr />
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate amet ullam excepturi
                            odio impedit saepe nemo repellendus,</p>
                    </div>
                </div>
                <br />
                <div class="card mx-1 shadow">
                    <div class="card-body">
                        <h5>Les formations</h5>
                        <hr />
                        <button type="button" class="btn btn-light">Payantes</button>
                        <button type="button" class="btn btn-dark">Gratuites</button>
                    </div>
                </div>
                <br />
                <div class="card mx-1">
                    <div class="card-body">
                        <h5>Présentation</h5>
                        <hr />
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/ZEyAs3NWH4A" title="YouTube video"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Event terbaru --}}
    <section class="event-terbaru-section section-bg pt-4 p-0 pb-4" style="background-color: #EFF8FD ">
        <div class="section-title pb-0">
            <h3 class="mt-0">Coba event lain</h3>
        </div>

        <div class="container-fluid event-terbaru pt-0 mt-0">
            @foreach (range(1, 15) as $count)
                <div class="col-md-4 mt-0">
                    <div class="card profile-card-5 shadow">
                        <div class="card-img-block">
                            <img class="card-img-top" src="https://images.unsplash.com/photo-1517832207067-4db24a2ae47c"
                                alt="Card image cap">
                        </div>
                        <div class="card-body pt-0">
                            <h5 class="card-title pb-0 mb-0">Florence Garza</h5>
                            <small>{{ $count }} Oktober 2021 -20 Okt 2023</small>
                            <hr>
                            <p class="card-text">
                            <div class="alert alert-info" role="alert"><strong>Rp 200.000</strong></div>
                            </p>
                            <hr>
                            <small>{{ $count }} Universitas Indonesia</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Full Image Modal -->
    <div class="modal fade" id="fullImageModal" style="z-index: 99999" aria-labelledby="fullImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h4>Full Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-1" style="width: 100%; height:100%">
                    <img src="{{ asset('storage/event-images/' . $detailEvent->image) }}" class="card-img-top"
                        alt="...">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
