{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    {{-- Alert ketika sukses edit --}}
    @if (session()->has('success'))
        <script>
            alertify.alert("Sukses!", "<i class='fas fa-check-square text-success'></i> {{ session('success') }}");
        </script>
    @endif

    <div class="bg-eventconnect header-hight">

    </div>
    <div class="container pt-4 pb-3 px-0 ">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row m-0 p-0">
            <div class="col-md-8 m-0 p-1">

                <div class="card shadow mb-3 mx-1">

                    @php
                        if ($detailEvent->image == '' || $detailEvent->image == null) {
                            //Jika gambar kosong
                            $img = 'assets/default-img/event-images/def-no-img.png';
                        } else {
                            $imgPath = 'storage/event-images/' . $detailEvent->image;

                            // Memeriksa apakah file ada
                            if (file_exists(public_path($imgPath))) {
                                $img = 'storage/event-images/' . $detailEvent->image;
                            } else {
                                // Jika file tidak ada, ganti dengan default
                                $img = 'assets/default-img/event-images/def-no-img.png';
                            }
                        }
                    @endphp

                    {{-- Gambar / Poster --}}
                    <div class="view-image-event position-relative">
                        <img src="{{ asset($img) }}" class="card-img-top" alt="...">
                        <button class="btn btn-dark rounded-0 position-absolute" data-toggle="modal"
                            data-target="#fullImageModal"><i class="fas fa-expand"></i></button>
                    </div>

                    {{-- Detal event --}}
                    <div class="card-body">

                        {{-- Title / judul --}}
                        <h6 class="card-title mt-3 mb-0">{{ $detailEvent->title }}</h6>

                        @php
                            if ($detailEvent->organizer == 'org') {
                                $penyelenggara = $detailEvent->org->org_name ?? '';
                                $link = '/organisasi' . '/' . $detailEvent->org->org_id;
                            } elseif ($detailEvent->organizer == 'individual') {
                                $penyelenggara = $detailEvent->individual->name ?? '';
                                $link = '/user' . '/' . $detailEvent->individual->username;
                            } elseif (
                                $detailEvent->organizer == null ||
                                $detailEvent->organizer_id == null ||
                                $detailEvent->organizer == '' ||
                                $detailEvent->organizer_id == ''
                            ) {
                                $penyelenggara = '';
                                $link = '';
                            } else {
                                $penyelenggara = '';
                                $link = '';
                            }

                        @endphp

                        {{-- Nama Penyelenggara --}}
                        <a href="{{ $link }}" class=" mt-2 badge badge-info">
                            <i
                                class="fas fa-user-circle mr-1"></i>{{ strlen($penyelenggara) > 40 ? substr($penyelenggara, 0, 40) . ' ...' : $penyelenggara }}
                        </a>
                        <hr>

                        <div class="row">

                            {{-- Lokasi event --}}
                            <div class="col-md-4 row mt-1">
                                <div class="col-auto pr-0"><i class="fas fa-map-marker-alt mr-2"></i></div>
                                <div class="col p-0 pr-1">
                                    <small>{{ $detailEvent->location_jenis == 'Online' ? 'Online' : $detailEvent->location_detail . ', ' . $detailEvent->location_city . ',  ' . $detailEvent->province->name }}</small>
                                </div>
                            </div>

                            {{-- Tanggal event --}}
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

                            {{-- Kategori event --}}
                            <div class="col-md-4 row mt-1">
                                <div class="col-auto pr-0"> <i class="fas fa-list mr-2"></i></div>
                                <div class="col p-0 pr-1"><small>{{ $detailEvent->categories->category }}</small></div>
                            </div>
                        </div>

                        <hr>

                        {{-- Informasi event dibuat --}}
                        <p class="card-text">
                            <small class="text-muted">Posted
                                {{ $detailEvent->created_at->diffForHumans() }}
                            </small>
                        </p>
                        <div class="float-right">
                            <button href="" class="btn btn-outline-info me-2" data-toggle="modal"
                                data-target="#shareQrModal">
                                <i class="fas fa-qrcode"></i> <b>QR</b>
                            </button>
                            <button href="" class="btn btn-outline-info me-2 copyButton">
                                <i class="fas fa-link"></i>
                            </button>
                            <button href="" class="btn btn-secondary" data-toggle="modal" data-target="#shareModal">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>


                    </div>
                </div>

                <div class="card mb-3 mx-1 shadow">
                    <div class="card-body p-3 p-sm-2 p-md-2 p-lg-3">

                        {{-- Pilihan TAB --}}
                        <div class="col-md-12 row tabs mb-4 text-article">
                            <div class="col px-0">
                                <button class="tab-link current w-100 m-0 py-2" data-tab="show-tiket">Tiket
                                    Pendaftaran</button>
                            </div>
                            <div class="col p-0">
                                <button class="tab-link w-100 py-2" data-tab="show-deskripsi">Deskripsi</button>
                            </div>
                        </div>

                        {{-- Tab ticket event --}}
                        <div id="show-tiket" class="tab-content current p-0 text-article">
                            <h6 class="card-title">Tiket pendaftaran</h6>

                            {{-- Looping tiket --}}
                            @foreach ($ticketData as $ticket)
                                <div class="card shadow-sm ticket-card mt-3 rounded-0" id="ticket-example">
                                    <div class="card-header text-white rounded-0 bg-ticket">
                                        <small><strong>{{ $ticket->ticket_name }}</strong></small>
                                    </div>

                                    <div class="card-body p-3">
                                        @php
                                            $ticketUsed = count($ticketTransaction->where('ticket_id', $ticket->id));
                                            $ticketQuota = $ticket->ticket_quota - $ticketUsed;

                                            $tanggalSekarang = $dateNow;
                                            $ticketStart = $ticket->ticket_start;
                                            $deadline = $ticket->ticket_deadline;

                                        @endphp
                                        <p class="card-text pt-0">
                                            <small class="text-muted icon-class">
                                                <span class="text-secondary">
                                                    <i class="fas fa-hourglass-end pr-1"></i>
                                                    Berakhir : <strong>{{ $deadline }}</strong>
                                                </span>
                                                <span class="alert alert-success py-1 px-2 ms-1 ml-1">
                                                    Kuota :
                                                    @if ($ticketStart > $tanggalSekarang)
                                                        <strong>0</strong>
                                                    @else
                                                        <strong>{{ $ticketQuota }}</strong>
                                                    @endif
                                                </span>
                                            </small>
                                        </p>

                                        <hr class="dashed">
                                        <div class="row">
                                            <div class="col">
                                                <span class="badge badge-secondary py-2 px-2 rounded-0 ">
                                                    @if ($ticket->ticket_price == 0 || $ticket->ticket_price == '')
                                                        <strong><i class="fas fa-tag"></i> GRATIS </strong>
                                                    @else
                                                        <strong>
                                                            <i class="fas fa-tag"></i> Rp
                                                            {{ number_format($ticket->ticket_price, 0, ',', '.') }}
                                                        </strong>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col text-right">
                                                @if ($ticketQuota <= 0)
                                                    <button class="btn btn-danger bg-none btn-sm ticket-button not-allowed"
                                                        disabled>Kuota FULL
                                                    </button>
                                                @elseif($deadline < $tanggalSekarang)
                                                    <button class="btn btn-danger bg-none btn-sm ticket-button not-allowed"
                                                        disabled>Closed!
                                                    </button>
                                                @elseif($ticketStart > $tanggalSekarang)
                                                    <button class="btn btn-info bg-none btn-sm ticket-button not-allowed"
                                                        disabled>Opening soon!
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-sm ticket-button"
                                                        data-id="{{ $ticket->id }}"
                                                        data-event_id="{{ $detailEvent->id }}"
                                                        data-label_button="{{ $ticket->ticket_button }}">{{ $ticket->ticket_button }}
                                                        <i class="fas fa-arrow-circle-right"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- Tab deskripsi --}}
                        <div id="show-deskripsi" class="tab-content p-0">
                            <div>
                                <h6 class="card-title">Deskripsi</h6>
                                <p class="card-text">
                                <article class="text-article">
                                    {!! $detailEvent->description !!}
                                </article>
                                </p>
                            </div>
                            <hr>

                            <div class="mt-4" hidden>
                                <h6 class="card-title">Syarat & ketentuan</h6>
                                <p class="card-text">
                                <article class="text-article">
                                    {!! $detailEvent->terms !!}
                                </article>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted"></small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Info penyelenggara organisasi --}}
            <div class="col-12 col-md-4 m-0 p-1 ">
                <div class="card mx-1 shadow">
                    <div class="card-body text-left">
                        <h6>Info penyelenggara</h6>
                        <hr />

                        @if ($detailEvent->organizer == 'org' && $detailEvent->organizer_id)
                            {{-- Jika penyelenggar organisasi --}}
                            @php
                                if ($detailEvent->org->org_image == '' || $detailEvent->org->org_image == null) {
                                    $logo = 'assets/default-img/org-images/default-user.jpg';
                                } else {
                                    $logo = 'storage/organization-images/' . $detailEvent->org->org_image;

                                    // Cek file ada atau tidak
                                    if (file_exists(public_path($logo))) {
                                        $logo = 'storage/organization-images/' . $detailEvent->org->org_image;
                                    } else {
                                        // Jika file tidak ada, ganti dengan default
                                        $logo = 'assets/default-img/org-images/default-user.jpg';
                                    }
                                }
                            @endphp

                            <div id="org-info-logo-container">
                                <img src="{{ asset($logo) }}" class="org-info-logo">
                            </div>

                            <a class="mt-3 badge badge-info text-left"
                                href="/organisasi/{{ $detailEvent->org->org_id }}">
                                <b>{{ strlen($detailEvent->org->org_name) > 40 ? substr($detailEvent->org->org_name, 0, 40) . ' ...' : $detailEvent->org->org_name }}</b>
                            </a>
                            <p class="card-text mt-1 mb-1"><small class="text-muted">Organisasi</small></p>

                            <p class="mb-1">{{ $detailEvent->org->org_contact }}</p>
                            <p class="mb-1">{{ $detailEvent->org->org_institution }}</p>
                        @elseif($detailEvent->organizer == 'individual' && $detailEvent->organizer_id)
                            {{-- Jika penyelenggara individual --}}

                            @php
                                if (
                                    $detailEvent->individual->profile_picture == '' ||
                                    $detailEvent->individual->profile_picture == null
                                ) {
                                    $logo = 'assets/default-img/profile-images/default-user.jpg';
                                } else {
                                    $logo = 'storage/profile-images/' . $detailEvent->individual->profile_picture;

                                    // Cek file ada atau tidak
                                    if (file_exists(public_path($logo))) {
                                        $logo = 'storage/profile-images/' . $detailEvent->individual->profile_picture;
                                    } else {
                                        // Jika file tidak ada, ganti dengan default
                                        $logo = 'assets/default-img/profile-images/default-user.jpg';
                                    }
                                }

                            @endphp


                            <div id="org-info-logo-container">
                                <img src="{{ asset($logo) }}" class="org-info-logo">
                            </div>

                            <a class="badge badge-info mt-3"
                                href="/user/{{ $detailEvent->individual->username }}">{{ strlen($detailEvent->individual->name) > 40 ? substr($detailEvent->individual->name, 0, 40) . ' ...' : $detailEvent->individual->name }}</a>

                            <p class="card-text mt-1 mb-1"><small class="text-muted">Individu</small></p>

                            <p class="mb-1">{{ $detailEvent->individual->email }}</p>
                            {{-- Mengatasi jika ada info penyelenggara kosong --}}
                        @else
                            <div id="org-info-logo-container">
                                <img src="{{ asset('storage/profile-images') . '/default-user.jpg' }}"
                                    class="org-info-logo">
                            </div>

                            <a class="badge badge-info mt-3">No info!</a>
                        @endif

                    </div>
                </div>

                <br />

                <div class="card mx-1 shadow">
                    <div class="card-body">
                        <h6>Buat eventmu sekarang!</h6>
                        <hr />
                        <a type="button" href="/login" class="btn btn-light">Login</a>
                        <a type="button" href="/event/create" class="btn btn-dark">Buat!</a>
                    </div>
                </div>
                <br />
                <div class="card mx-1">
                    <div class="card-body">
                        <h6>Bingung? Panduan buat event 👇</h6>
                        <hr />
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/7PKrnsQUx90?si=WL3EBF8-dPjSyijf"
                                title="YouTube video" allowfullscreen></iframe>
                        </div>
                        <div class="ratio ratio-16x9 mt-3">
                            <iframe src="https://www.youtube.com/embed/igdg2VMQjn0?si=8bFsDFrRlrQruHmv"
                                title="YouTube video" allowfullscreen></iframe>
                        </div>
                        <div class="mt-3">
                            <a href="/creator-guide" class="btn btn-info ">Lihat panduan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Event terbaru --}}
    <section class="event-terbaru-section section-bg pt-4 p-0 pb-4" style="background-color: #EFF8FD ">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event menarik lainya</h2>
        </div>

        <div class="container-fluid event-terbaru pt-0 mt-0">
            @foreach ($recomendedEvents as $moreEvent)
                <div class="col-md-4 mt-0">
                    <a href="/{{ $moreEvent->slug }}">
                        <div class="card profile-card-5 shadow">

                            @php
                                if ($moreEvent->image == '' || $moreEvent->image == null) {
                                    //Jika gambar kosong
                                    $imgmoreEvent = 'assets/default-img/event-images/def-img.png';
                                } else {
                                    $imgPath = 'storage/event-images/' . $moreEvent->image;

                                    // Memeriksa apakah file ada
                                    if (file_exists(public_path($imgPath))) {
                                        $imgmoreEvent = 'storage/event-images/' . $moreEvent->image;
                                    } else {
                                        // Jika file tidak ada, ganti dengan default
                                        $imgmoreEvent = 'assets/default-img/event-images/def-img.png';
                                    }
                                }
                            @endphp

                            {{-- Gambar / poster --}}
                            <div class="card-img-block">
                                <img class="card-img-top" src="{{ asset($imgmoreEvent) }}" alt="Card image cap">
                            </div>

                            {{-- Info lain --}}
                            <div class="card-body pt-0">

                                {{-- Title / Judul --}}
                                @php
                                    if (strlen($moreEvent->title) > 50) {
                                        $title_moreEvent = substr($moreEvent->title, 0, 50) . ' ...';
                                    } else {
                                        $title_moreEvent = $moreEvent->title;
                                    }
                                @endphp
                                <div style="height: 45px">
                                    <h5 class="card-title pb-0 mb-0">{{ $title_moreEvent }}</h5>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- Lokasi --}}
                                <small class="location">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $moreEvent->location_jenis == 'Offline' ? ucwords(strtolower($moreEvent->location_city)) : $moreEvent->location_jenis }}</small>
                                <br>

                                {{-- Tanggal event --}}
                                <small>
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $moreEvent->start_date->format('dd-mm-Y') == $moreEvent->end_date->format('dd-mm-Y') ? $moreEvent->end_date->format('d M Y') : $moreEvent->start_date->format('d M Y') . ' - ' . $moreEvent->end_date->format('d M Y') }}</small>
                                <hr class="mb-1 mt-1">

                                {{-- Harga --}}
                                <div class="alert alert-info mt-3" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $moreEvent->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($moreEvent->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- Penyelenggara --}}
                                @php
                                    if ($moreEvent->organizer == 'org') {
                                        $penyelenggara_moreEvent = $moreEvent->org->org_name ?? '';
                                    } elseif ($moreEvent->organizer == 'individual') {
                                        $penyelenggara_moreEvent = $moreEvent->individual->name ?? '';
                                    } else {
                                        $penyelenggara_moreEvent = '';
                                    }
                                @endphp

                                <div class="text-center">
                                    <small class="event-user">
                                        {{ $penyelenggara_moreEvent }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
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
                    <img src="{{ asset($img) }}" class="card-img-top" alt="...">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal share link event --}}
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Share event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <button class="btn btn-secondary copyButton">
                        <i class="fas fa-link"></i> Copy link
                    </button>
                    <!-- Tombol WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode(url()->current()) }}"
                        class="btn btn-success"><i class="fab fa-whatsapp"></i></a>

                    <!-- Tombol LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                        class="btn btn-primary"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Modal share link event --}}

    {{-- Modal share QR CODE link event --}}
    <div class="modal fade" id="shareQrModal" tabindex="-1" aria-labelledby="shareQrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareQrModalLabel">QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    {!! $qrlink !!}
                    <div class="mt-2">
                        <a href="/{{ $detailEvent->slug }}">eventconnect.id/{{ $detailEvent->slug }}</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Modal share QRCODE link event --}}

    {{-- Skrip copy link --}}
    <script>
        document.querySelectorAll('.copyButton').forEach(button => {
            button.addEventListener('click', function() {
                var dummy = document.createElement('input'),
                    text = window.location.href;

                document.body.appendChild(dummy);
                dummy.value = text;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);

                alertify.success('<i class="fas fa-copy"></i> copied to clipboard');
            });
        });
    </script>
@endsection
