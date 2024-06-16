@extends('layouts.main')

@section('content')
    {{-- banner --}}
    {{-- <section class="banner">
        <div class="wrapper">
            <div class="banner-carousel">
                <div class="box-image">
                    <img src="{{ asset('assets/img/service-details-1.jpg') }}" alt="First slide">
                </div>

                <div class="box-image"> <img src="{{ asset('assets/img/service-details-2.jpg') }}" alt="Second slide"></div>
                <div class="box-image"> <img src="{{ asset('assets/img/service-details-3.jpg') }}" alt="Third slide"></div>
                <div class="box-image"> <img src="{{ asset('assets/img/service-details-4.jpg') }}" alt="Third slide"></div>
            </div>
        </div>
    </section> --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header flex">
            <div class="wave-content w-100">
                <div class="">
                    <h1><span class="text_1">Buat event cuma 1x klik? bisa dong!</span><span class="text_2">Cari event
                            favoritmu di sini!</span>
                    </h1>
                </div>
                <div class="pt-2">
                    <a href="/event/create" class="btn btn-success rounded-0">Buat event</a>
                    <a href="/search" class="btn btn-info rounded-0"><i class="fas fa-search"></i> Cari event</a>
                </div>
            </div>

        </div>

        <!--Waves Container-->
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </div>
        <!--Waves end-->

    </div>
    <!--Header ends-->


    {{-- Form Pencarian --}}
    <section class="why-us pt-4 pb-4 px-2">
        <div class="container px-0 my-shadow2" data-aos="fade-up" date-aos-delay="200">
            <div class="d-flex flex-column justify-content-center py-5">
                <form class="form-search" method="get" action="/search">
                    @csrf
                    <input type="search" name="key" placeholder="Cari event kesukaan kamu ...">
                    <button class="button btn-success" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </section>

    {{-- Event terbaru --}}
    <section class="event-terbaru-section pt-2 p-0">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event Terbaru</h2>
        </div>

        <div class="container-fluid event-terbaru pt-0 mt-0">
            @foreach ($eventTerbaru as $terbaru)
                <div class="col-md-4 mt-0">
                    <a href="/{{ $terbaru->slug }}">
                        <div class="card profile-card-5 shadow">

                            @php
                                if ($terbaru->image == '' || $terbaru->image == null) {
                                    $imgTerbaru = 'assets/default-img/event-images/def-img.png';
                                } else {
                                    $imgPath = 'storage/event-images/' . $terbaru->image;

                                    // Memeriksa apakah file ada
                                    if (file_exists(public_path($imgPath))) {
                                        $imgTerbaru = 'storage/event-images/' . $terbaru->image;
                                    } else {
                                        $imgTerbaru = 'assets/default-img/event-images/def-img.png';
                                        // Jika file tidak ada, ganti dengan default
                                    }
                                }

                            @endphp

                            <div class="card-img-block rounded">
                                <img class="card-img-top" src="{{ asset($imgTerbaru) }}" alt="Card image cap">
                            </div>
                            <div class="card-body pt-0">

                                {{-- Title / Judul --}}
                                @php
                                    if (strlen($terbaru->title) > 50) {
                                        $title_terbaru = substr($terbaru->title, 0, 50) . ' ...';
                                    } else {
                                        $title_terbaru = $terbaru->title;
                                    }
                                @endphp

                                <div style="height: 45px">
                                    <h5 class="card-title pb-0 mb-0">{{ $title_terbaru }}</h5>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- LOKASI --}}
                                <small class="location"><i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $terbaru->location_jenis == 'Offline' ? ucwords(strtolower($terbaru->location_city)) : $terbaru->location_jenis }}</small>
                                <br>

                                {{-- TANGGAL EVENT --}}
                                <small>
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $terbaru->start_date->format('dd-mm-Y') == $terbaru->end_date->format('dd-mm-Y') ? $terbaru->end_date->format('d M Y') : $terbaru->start_date->format('d M Y') . ' - ' . $terbaru->end_date->format('d M Y') }}</small>
                                <hr class="mb-1 mt-1">

                                {{-- PRICE --}}
                                <div class="alert alert-info mt-3" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $terbaru->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($terbaru->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- ORGANISASI --}}
                                @php
                                    if ($terbaru->organizer == 'org') {
                                        $penyelenggara = $terbaru->org->org_name ?? '';
                                    } elseif ($terbaru->organizer == 'individual') {
                                        $penyelenggara = $terbaru->individual->name ?? '';
                                    } else {
                                        $penyelenggara = '';
                                    }

                                @endphp

                                <div class="text-center">
                                    <small class="event-user text-secondary">
                                        {{ $penyelenggara }}</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Penawaran --}}
    <section class="event-terbaru-setion pt-4 p-0 bg-eventconnect">
        <div class="container evnt-terbaru pt-0 mt-0 text-white text-center">
            <div class="py-5">
                <h6>Jaidikan event kamu lebih keren disini !!!</h6> <button class="btn btn-success">
                    <small><strong>Buat event SEKARANG</strong> <i class="fas fa-rocket"></i></small></button>
            </div>
        </div>
    </section>


    {{-- Event Populer --}}
    <section class="event-terbaru-section section-bg pt-4 p-0" style="background-color: #fff ">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event Populer</h2>
        </div>

        <div class="container-fluid event-terbaru pt-0 mt-0">
            @foreach ($eventPopuler as $populer)
                <div class="col-md-4 mt-0">
                    <a href="/{{ $populer->slug }}">
                        <div class="card profile-card-5 shadow">

                            @php
                                if ($populer->image == '' || $populer->image == null) {
                                    //Jika gambar kosong
                                    $imgPopuler = 'assets/default-img/event-images/def-img.png';
                                } else {
                                    $imgPath = 'storage/event-images/' . $populer->image;

                                    // Memeriksa apakah file ada
                                    if (file_exists(public_path($imgPath))) {
                                        $imgPopuler = 'storage/event-images/' . $populer->image;
                                    } else {
                                        // Jika file tidak ada, ganti dengan default
                                        $imgPopuler = 'assets/default-img/event-images/def-img.png';
                                    }
                                }
                            @endphp

                            <div class="card-img-block rounded">
                                <img class="card-img-top" src="{{ asset($imgPopuler) }}" alt="Card image cap">
                            </div>

                            {{-- INFO LAIN --}}
                            <div class="card-body pt-0">

                                {{-- Title / Judul --}}
                                @php
                                    if (strlen($populer->title) > 50) {
                                        $title_populer = substr($populer->title, 0, 50) . ' ...';
                                    } else {
                                        $title_populer = $populer->title;
                                    }
                                @endphp
                                <div style="height: 45px">
                                    <h5 class="card-title pb-0 mb-0">{{ $title_populer }}</h5>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- Lokasi --}}
                                <small class="location">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $populer->location_jenis == 'Offline' ? ucwords(strtolower($populer->location_city)) : $populer->location_jenis }}</small>
                                <br>

                                {{-- Tanggal event --}}
                                <small>
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $populer->start_date->format('dd-mm-Y') == $populer->end_date->format('dd-mm-Y') ? $populer->end_date->format('d M Y') : $populer->start_date->format('d M Y') . ' - ' . $populer->end_date->format('d M Y') }}</small>
                                <hr class="mb-1 mt-1">

                                {{-- Harga --}}
                                <div class="alert alert-info mt-3" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $populer->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($populer->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- Penyelenggara --}}
                                @php
                                    if ($populer->organizer == 'org') {
                                        $penyelenggara_populer = $populer->org->org_name ?? '';
                                    } elseif ($populer->organizer == 'individual') {
                                        $penyelenggara_populer = $populer->individual->name ?? '';
                                    } else {
                                        $penyelenggara_populer = '';
                                    }
                                @endphp

                                <div class="text-center">
                                    <small class="event-user">
                                        {{ $penyelenggara_populer }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Event pilihan --}}
    <section class="event-terbaru-section section-bg pt-4 p-0" style="background-color: #fff ">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event Pilihan</h2>
        </div>

        <div class="container-fluid event-terbaru pt-0 mt-0">
            @foreach ($eventPilihan as $pilihan)
                <div class="col-md-4 mt-0">
                    <a href="/{{ $pilihan->slug }}">
                        <div class="card profile-card-5 shadow">

                            @php
                                if ($pilihan->image == '' || $pilihan->image == null) {
                                    //Jika gambar kosong
                                    $imgPilihan = 'assets/default-img/event-images/def-img.png';
                                } else {
                                    $imgPath = 'storage/event-images/' . $pilihan->image;

                                    // Memeriksa apakah file ada
                                    if (file_exists(public_path($imgPath))) {
                                        $imgPilihan = 'storage/event-images/' . $pilihan->image;
                                    } else {
                                        // Jika file tidak ada, ganti dengan default
                                        $imgPilihan = 'assets/default-img/event-images/def-img.png';
                                    }
                                }
                            @endphp

                            <div class="card-img-block rounded">
                                <img class="card-img-top" src="{{ asset($imgPilihan) }}" alt="Card image cap">
                            </div>

                            {{-- Isi data --}}
                            <div class="card-body pt-0">

                                {{-- Title / judul --}}
                                @php
                                    if (strlen($pilihan->title) > 50) {
                                        $title_pilihan = substr($pilihan->title, 0, 50) . ' ...';
                                    } else {
                                        $title_pilihan = $pilihan->title;
                                    }
                                @endphp

                                <div style="height: 45px">
                                    <h5 class="card-title pb-0 mb-0">{{ $title_pilihan }}</h5>
                                </div>

                                <hr class="mb-1 mt-1">

                                {{-- Lokasi --}}
                                <small class="location">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $pilihan->location_jenis == 'Offline' ? ucwords(strtolower($pilihan->location_city)) : $pilihan->location_jenis }}</small>
                                <br>
                                {{-- Tanggal event --}}
                                <small>
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $pilihan->start_date->format('dd-mm-Y') == $pilihan->end_date->format('dd-mm-Y') ? $pilihan->end_date->format('d M Y') : $pilihan->start_date->format('d M Y') . ' - ' . $pilihan->end_date->format('d M Y') }}</small>


                                {{-- Harga tiket --}}
                                <div class="alert alert-info mt-3" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $pilihan->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($pilihan->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>

                                <hr class="mt-1 mb-1">

                                {{-- Penyelenggara --}}
                                @php
                                    if ($pilihan->organizer == 'org') {
                                        $penyelenggara_pilihan = $pilihan->org->org_name ?? '';
                                    } elseif ($pilihan->organizer == 'individual') {
                                        $penyelenggara_pilihan = $pilihan->individual->name ?? '';
                                    } else {
                                        $penyelenggara_pilihan = '';
                                    }
                                @endphp
                                <div class="text-center">
                                    <small class="event-user">
                                        {{ $penyelenggara_pilihan }}
                                    </small>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    <!-- ======= Why Us Section ======= -->
    <section class="why-us section-bg px-2" data-aos="fade-up" date-aos-delay="200">
        <div class="container p-4">
            <div class="text-center">
                <h5>Kenapa eventconect.id?</h5>
            </div>
            <hr>
            <div class="mb-3">
                <ul class="text-article">
                    <li class="mb-1">Event kamu bisa jadi lebih <b class="text-success">keren & profesional</b>!</li>
                    <li class="mb-1">Manajemen sistem pendaftaran, ticketing, pembayaran, & data yang lebih baik.</li>
                    <li class="mb-1">Tidak perlu urusin data peserta, kita yang urus!</li>
                    <li class="mb-1">Tidak perlu urus masalaah pembayaran, kita yang urus!</li>
                    <li class="mb-1">Meningkatkan <b class="text-success">kepercayaan</b> peserta!</li>
                    <li class="mb-1">Buat artikel, pengumuman, dan sebagainya dari menu manajemen artikel FREE!</li>
                    <li class="mb-1">Yang pasti kamu bisa menggunkanan platform eventconect.id kapanpun dan <span
                            class="text-success"><b>GRATIS!</b></span>
                    </li>
                </ul>
            </div>
            <hr>
            <div class="text-center">
                <h5>Siapa eventconect.id?</h5>
            </div>
            <hr>
            <div class="text-center">
                <p class="text-article">
                    <b>Eventconnect.id</b> merupakan platform Ticketing Management Sistem yang didirikan oleh <b>PT
                        Konektivitas Tanpa Batas</b> dan dikelola oleh <b>ILB media</b> (IG @Info.lomba.beasiswa) yang
                    menyediakan solusi teknologi dalam mendukung penyelenggaraan event mulai dari distribusi tiket,
                    manajemen pendaftaran, pembayaran, hingga penyediaan report/laporan akhir event.
                </p>
                <a href="/about-us" class="btn btn-info rounded-0">Baca selengkapnya ...</a>
            </div>

        </div>
    </section>
    <!-- End Why Us Section -->
@endsection
