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
                            <div class="card-img-block rounded">
                                <img class="card-img-top" src="{{ asset('storage/event-images/' . $terbaru->image) }}"
                                    alt="Card image cap">
                            </div>
                            <div class="card-body pt-0">
                                <h5 class="card-title pb-0 mb-0">{{ $terbaru->title }}</h5>
                                <small class="location"><i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $terbaru->location_jenis == 'Offline' ? ucwords(strtolower($terbaru->location_city)) : $terbaru->location_jenis }}</small>
                                <hr class="mb-1 mt-1">
                                <small>{{ $terbaru->start_date->format('dd-mm-Y') == $terbaru->end_date->format('dd-mm-Y') ? $terbaru->end_date->format('d M Y') : $terbaru->start_date->format('d M Y') . ' - ' . $terbaru->end_date->format('d M Y') }}</small>
                                <p class="card-text">
                                <div class="alert alert-info" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $terbaru->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($terbaru->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>
                                </p>
                                <hr>
                                <small class="event-user"><i class="fas fa-user-circle mr-1"></i>
                                    {{ $terbaru->penyelenggara->name }}</small>
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
                            <div class="card-img-block rounded">
                                <img class="card-img-top" src="{{ asset('storage/event-images/' . $populer->image) }}"
                                    alt="Card image cap">
                            </div>
                            <div class="card-body pt-0">
                                <h5 class="card-title pb-0 mb-0">{{ $populer->title }}</h5>
                                <small class="location"><i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $populer->location_jenis == 'Offline' ? ucwords(strtolower($populer->location_city)) : $populer->location_jenis }}</small>
                                <hr class="mb-1 mt-1">
                                <small>{{ $populer->start_date->format('dd-mm-Y') == $populer->end_date->format('dd-mm-Y') ? $populer->end_date->format('d M Y') : $populer->start_date->format('d M Y') . ' - ' . $populer->end_date->format('d M Y') }}</small>
                                <p class="card-text">
                                <div class="alert alert-info" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $populer->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($populer->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>
                                </p>
                                <hr>
                                <small class="event-user"><i class="fas fa-user-circle mr-1"></i>
                                    {{ $populer->penyelenggara->name }}</small>
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
                            <div class="card-img-block rounded">
                                <img class="card-img-top" src="{{ asset('storage/event-images/' . $pilihan->image) }}"
                                    alt="Card image cap">
                            </div>
                            <div class="card-body pt-0">
                                <h5 class="card-title pb-0 mb-0">{{ $pilihan->title }}</h5>
                                <small class="location"><i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $pilihan->location_jenis == 'Offline' ? ucwords(strtolower($pilihan->location_city)) : $pilihan->location_jenis }}</small>
                                <hr class="mb-1 mt-1">
                                <small>{{ $pilihan->start_date->format('dd-mm-Y') == $pilihan->end_date->format('dd-mm-Y') ? $pilihan->end_date->format('d M Y') : $pilihan->start_date->format('d M Y') . ' - ' . $pilihan->end_date->format('d M Y') }}</small>
                                <p class="card-text">
                                <div class="alert alert-info" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            {{ $pilihan->ticket->first()->ticket_price == 0 ? 'GRATIS!' : ' Rp ' . number_format($pilihan->ticket->first()->ticket_price, 0, ',', '.') }}</strong>
                                    </small>
                                </div>
                                </p>
                                <hr>
                                <small class="event-user"><i class="fas fa-user-circle mr-1"></i>
                                    {{ $pilihan->penyelenggara->name }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    <!-- ======= Why Us Section ======= -->
    <section class="why-us section-bg px-2" data-aos="fade-up" date-aos-delay="200">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 video-box">
                    <img src="{{ asset('assets/img/service-details-1.jpg') }}" class="img-fluid" alt="">
                    <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4"
                        data-vbtype="video" data-autoplay="true"></a>
                </div>

                <div class="col-lg-6 d-flex flex-column justify-content-center px-2 py-4">

                    <div class="icon-box">
                        <span class="ml-4"><strong>APA ITU EVENTCONNECT.ID?</strong></span>
                        <p class="description ml-4">Eventconnect.id merupakan platform sharing, ticketing dan manajemen
                            event <strong>Baca selengkapnya ...</strong></p>
                    </div>

                    <div class="icon-box">
                        <span class="ml-4"><strong>KENAPA HARUS EVENTCONNECT.ID?</strong></span>
                        <p class="description ml-4 mb-0 mt-2 pb-0 "><i class="fa fa-check text-success"></i> Posting/buat
                            event lebih mudah!</p>
                        <p class="description ml-4 mb-0 pb-0"><i class="fa fa-check text-success"></i> Manajemen event
                            lebih
                            teratur</p>
                        <p class="description ml-4 mb-0 pb-0 pr-0 mr-0"><i class="fa fa-check text-success"></i> Sistem
                            pendaftaran dan ticketing terogranisir</p>
                        <p class="description ml-4 mb-0 pb-0"><i class="fa fa-check text-success"></i> Pemayaran lebih
                            mudah dan aman</p>
                        <p class="description ml-4 mb-0 pb-0"><i class="fa fa-check text-success"></i> Meminimalisir
                            penipuan event</p>
                    </div>

                </div>
            </div>

        </div>
    </section><!-- End Why Us Section -->
@endsection
