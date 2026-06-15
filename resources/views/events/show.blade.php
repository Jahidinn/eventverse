{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    {{-- Alert ketika sukses edit --}}
    @if (session()->has('success'))
        <script>
            alertify.alert("Sukses!", "<i class='fas fa-check-square text-success'></i> {{ session('success') }}");
        </script>
    @endif

    <div class="bg-eventconnect header-hight"></div>

    <div class="modern-event-detail pt-5 pb-5">
        <div class="container">
            <!-- Stack the columns on mobile by making one full-width and the other half-width -->
            <div class="row g-4">
                <div class="col-lg-8">

                    <div class="event-detail-card modern-card">

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
                        <div class="event-image-container position-relative overflow-hidden">
                            <img src="{{ asset($img) }}" class="event-poster-img" alt="Event Poster">
                            <button class="btn btn-light btn-icon-expand shadow-sm" data-toggle="modal"
                                data-target="#fullImageModal"><i class="fas fa-expand"></i></button>
                        </div>

                        {{-- Detail event --}}
                        <div class="event-content px-4 py-4">

                            {{-- Title / judul --}}
                            <h2 class="event-title mb-3">{{ $detailEvent->title }}</h2>

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
                            <a href="{{ $link }}" class="organizer-badge mb-3 d-inline-block">
                                <i
                                    class="fas fa-user-circle mr-2"></i><span>{{ strlen($penyelenggara) > 40 ? substr($penyelenggara, 0, 40) . ' ...' : $penyelenggara }}</span>
                            </a>

                            <div class="event-meta-info">
                                <div class="meta-row">
                                    {{-- Lokasi event --}}
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div>
                                            <span class="meta-label">Lokasi</span>
                                            <p class="meta-value">{{ $detailEvent->location_jenis == 'Online' ? 'Online' : $detailEvent->location_detail . ', ' . $detailEvent->location_city . ', ' . $detailEvent->province->name }}</p>
                                        </div>
                                    </div>

                                    {{-- Tanggal event --}}
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <div>
                                            <span class="meta-label">Tanggal</span>
                                            <p class="meta-value">
                                                {{ $detailEvent->start_date == $detailEvent->end_date ? date('d-m-Y', strtotime($detailEvent->start_date)) : date('d-m-Y', strtotime($detailEvent->start_date)) . ' - ' . date('d-m-Y', strtotime($detailEvent->end_date)) }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Kategori event --}}
                                    <div class="meta-item">
                                        <i class="fas fa-list"></i>
                                        <div>
                                            <span class="meta-label">Kategori</span>
                                            <p class="meta-value">{{ $detailEvent->categories->category }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="event-actions mt-4">
                                {{-- Informasi event dibuat --}}
                                <p class="posted-info">
                                    <small>Posted
                                        {{ $detailEvent->created_at->diffForHumans() }}
                                    </small>
                                </p>
                                <div class="action-buttons">
                                    <button class="btn btn-icon btn-light" data-toggle="modal"
                                        data-target="#shareQrModal" title="Share QR Code">
                                        <i class="fas fa-qrcode"></i> <span>QR</span>
                                    </button>
                                    <button class="btn btn-icon btn-light copyButton" title="Copy Link">
                                        <i class="fas fa-link"></i> <span>Link</span>
                                    </button>
                                    <button class="btn btn-icon btn-light" data-toggle="modal" data-target="#shareModal" title="Share Event">
                                        <i class="fas fa-share-alt"></i> <span>Share</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="modern-card mt-4 mb-4">
                    <div class="card-body p-4">

                        {{-- Pilihan TAB --}}
                        <div class="modern-tabs mb-4">
                            <button class="tab-link current" data-tab="show-tiket">
                                <i class="ti ti-ticket ti-sm"></i> Tiket Pendaftaran
                            </button>
                            <button class="tab-link" data-tab="show-deskripsi">
                                <i class="ti ti-list ti-sm"></i> Deskripsi
                            </button>
                        </div>

                        {{-- Tab ticket event --}}
                        <div id="show-tiket" class="tab-content current">
                            <h5 class="mb-4">Tiket Pendaftaran</h5>

                            {{-- Looping tiket --}}
                            @foreach ($ticketData as $ticket)
                                <div class="modern-ticket-card">
                                    <div class="ticket-header">
                                        <h6 class="ticket-name">{{ $ticket->ticket_name }}</h6>
                                    </div>

                                    <div class="ticket-body">
                                        @php
                                            $ticketUsed = count($ticketTransaction->where('ticket_id', $ticket->id));
                                            $ticketQuota = $ticket->ticket_quota - $ticketUsed;

                                            $tanggalSekarang = $dateNow;
                                            $ticketStart = $ticket->ticket_start;
                                            $deadline = $ticket->ticket_deadline;

                                        @endphp
                                        <div class="ticket-meta">
                                            <span class="meta-deadline">
                                                <i class="fas fa-hourglass-end"></i>
                                                Berakhir: <strong>{{ $deadline }}</strong>
                                            </span>
                                            <span class="meta-quota">
                                                Kuota:
                                                @if ($ticketStart > $tanggalSekarang)
                                                    <strong>0</strong>
                                                @else
                                                    <strong>{{ $ticketQuota }}</strong>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="ticket-footer">
                                            <div class="ticket-price">
                                                <i class="fas fa-tag"></i>
                                                @if ($ticket->ticket_price == 0 || $ticket->ticket_price == '')
                                                    <strong>GRATIS</strong>
                                                @else
                                                    <strong>Rp {{ number_format($ticket->ticket_price, 0, ',', '.') }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ticket-footer">
                                                @if ($ticketQuota <= 0)
                                                    <button class="btn btn-sm btn-disabled" disabled>
                                                        <i class="fas fa-ban"></i> Kuota FULL
                                                    </button>
                                                @elseif($deadline < $tanggalSekarang)
                                                    <button class="btn btn-sm btn-disabled" disabled>
                                                        <i class="fas fa-times-circle"></i> Closed
                                                    </button>
                                                @elseif($ticketStart > $tanggalSekarang)
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        <i class="fas fa-clock"></i> Opening soon
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-primary ticket-button w-full"
                                                        data-id="{{ $ticket->id }}"
                                                        data-event_id="{{ $detailEvent->id }}"
                                                        data-label_button="{{ $ticket->ticket_button }}">
                                                        {{ $ticket->ticket_button }}
                                                        <i class="fas fa-arrow-right ms-2"></i>
                                                    </button>
                                                @endif
                                            </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- Tab deskripsi --}}
                        <div id="show-deskripsi" class="tab-content">
                            <div>
                                <h5 class="mb-3">Deskripsi</h5>
                                <p class="card-text">
                                <article class="text-article">
                                    {!! $detailEvent->description !!}
                                </article>
                                </p>
                            </div>

                            <div class="mt-5" hidden>
                                <h5 class="mb-3">Syarat & ketentuan</h5>
                                <p class="card-text">
                                <article class="text-article">
                                    {!! $detailEvent->terms !!}
                                </article>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Info penyelenggara organisasi --}}
            <div class="col-lg-4">
                <div class="modern-card organizer-card">
                    <div class="organizer-header">
                        <h5>Info Penyelenggara</h5>
                    </div>

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

                        <div class="organizer-image">
                            <img src="{{ asset($logo) }}" class="org-logo" alt="Organization Logo">
                        </div>

                        <a class="organizer-name"
                            href="/organisasi/{{ $detailEvent->org->org_id }}">
                            <h6>{{ strlen($detailEvent->org->org_name) > 40 ? substr($detailEvent->org->org_name, 0, 40) . ' ...' : $detailEvent->org->org_name }}</h6>
                        </a>
                        <p class="organizer-type">Organisasi</p>

                        <div class="organizer-contact">
                            <p><i class="fas fa-phone me-2"></i>{{ $detailEvent->org->org_contact }}</p>
                            <p><i class="fas fa-building me-2"></i>{{ $detailEvent->org->org_institution }}</p>
                        </div>
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

                        <div class="organizer-image">
                            <img src="{{ asset($logo) }}" class="org-logo" alt="Profile Picture">
                        </div>

                        <a class="organizer-name"
                            href="/user/{{ $detailEvent->individual->username }}">
                            <h6>{{ strlen($detailEvent->individual->name) > 40 ? substr($detailEvent->individual->name, 0, 40) . ' ...' : $detailEvent->individual->name }}</h6>
                        </a>
                        <p class="organizer-type">Individu</p>

                        <div class="organizer-contact">
                            <p><i class="fas fa-envelope me-2"></i>{{ $detailEvent->individual->email }}</p>
                        </div>
                    @else
                        <div class="organizer-image">
                            <img src="{{ asset('storage/profile-images') . '/default-user.jpg' }}"
                                class="org-logo" alt="Default User">
                        </div>

                        <p class="text-center text-muted">Informasi penyelenggara tidak tersedia</p>
                    @endif
                </div>

                <div class="modern-card mt-4 create-event-card">
                    <div class="card-header">
                        <h5>Buat Event Mu!</h5>
                    </div>
                    <div class="p-3">
                        <p class="text-muted mb-3">Mulai membuat event eksklusif sekarang</p>
                        <div class="action-buttons">
                            <a href="/login" class="btn btn-secondary btn-block">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            <a href="/event/create" class="btn btn-primary btn-block">
                                <i class="fas fa-plus-circle mr-2"></i>Buat Event
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modern-card mt-4 guide-card">
                    <div class="card-header">
                        <h5>Panduan Membuat Event</h5>
                    </div>
                    <div class="p-2">
                        {{-- <p class="text-muted mb-3">Pelajari cara membuat event yang menarik</p> --}}
                        <div class="guide-videos">
                            <div class="ratio ratio-16x9 mb-3">
                                <iframe src="https://www.youtube.com/embed/7PKrnsQUx90?si=WL3EBF8-dPjSyijf"
                                    title="YouTube video" allowfullscreen></iframe>
                            </div>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/igdg2VMQjn0?si=8bFsDFrRlrQruHmv"
                                    title="YouTube video" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div>
                            <a href="/creator-guide" class="btn btn-outline-primary btn-sm p-2 w-100">
                            <i class="fas fa-question-circle mr-1"></i>Panduan Lengkap
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Event terbaru --}}
    <section class="modern-recommended-section pt-4 pb-5 mt-2">
        <div class="container">
            <div class="section-header mb-5">
                <h2>Event Menarik Lainnya</h2>
                <p class="text-muted">Temukan event-event lain yang mungkin kamu minati</p>
            </div>

            <div class="event-terbaru m-3">
                @foreach ($recomendedEvents as $moreEvent)
                    <div class="pt-3">
                        <a href="/{{ $moreEvent->slug }}" class="event-card-link">
                            <div class="modern-event-card">

                                @php
                                    if ($moreEvent->image == '' || $moreEvent->image == null) {
                                        $imgmoreEvent = 'assets/default-img/event-images/def-no-img.png';
                                    } else {
                                        $imgPath = 'storage/event-images/' . $moreEvent->image;

                                        if (file_exists(public_path($imgPath))) {
                                            $imgmoreEvent = 'storage/event-images/' . $moreEvent->image;
                                        } else {
                                            $imgmoreEvent = 'assets/default-img/event-images/def-no-img.png';
                                        }
                                    }
                                @endphp

                                <div class="card-image-wrapper">
                                    <img class="card-image" src="{{ asset($imgmoreEvent) }}" alt="Event Image">
                                    <div class="overlay"></div>
                                </div>

                                <div class="card-content">

                                    @php
                                        if (strlen($moreEvent->title) > 50) {
                                            $title_moreEvent = substr($moreEvent->title, 0, 50) . ' ...';
                                        } else {
                                            $title_moreEvent = $moreEvent->title;
                                        }
                                    @endphp
                                    <div class="mb-2 card-title-wrapper">
                                        <h5 class="card-title">{{ $title_moreEvent }}</h5>
                                    </div>

                                    <p class="card-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $moreEvent->location_jenis == 'Offline' ? ucwords(strtolower($moreEvent->location_city)) : $moreEvent->location_jenis }}
                                    </p>

                                    <p class="card-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $moreEvent->start_date->format('dd-mm-Y') == $moreEvent->end_date->format('dd-mm-Y') ? $moreEvent->end_date->format('d M Y') : $moreEvent->start_date->format('d M Y') . ' - ' . $moreEvent->end_date->format('d M Y') }}
                                    </p>

                                    <div class="card-price">
                                        <i class="fas fa-tag"></i>
                                        @php
                                            $firstTicket = $moreEvent->ticket->first();
                                        @endphp

                                        {{ !$firstTicket || $firstTicket->ticket_price == 0
                                            ? 'GRATIS!'
                                            : 'Rp ' . number_format($firstTicket->ticket_price, 0, ',', '.') }}

                                    </div>

                                    @php
                                        if ($moreEvent->organizer == 'org') {
                                            $penyelenggara_moreEvent = $moreEvent->org->org_name ?? '';
                                        } elseif ($moreEvent->organizer == 'individual') {
                                            $penyelenggara_moreEvent = $moreEvent->individual->name ?? '';
                                        } else {
                                            $penyelenggara_moreEvent = '';
                                        }
                                    @endphp

                                    <div class="card-organizer">
                                        <small>
                                            {{ $penyelenggara_moreEvent }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
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
