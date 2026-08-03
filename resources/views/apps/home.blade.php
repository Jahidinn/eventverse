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

    {{-- <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header flex">
            <div class="wave-content w-100">
                <div class="">
                    <h1><span class="text_1">Buat event cuma 1x klik? bisa dong!</span><span class="text_2">Cari event
                            favoritmu di sini!</span>
                    </h1>
                </div>
                <div class="pt-2">
                    <a href="/event/create" class="button-21">Create event</a>
                    <a href="/search" class="button-1"><i class="fas fa-search"></i> Cari event</a>
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
    <!--Header ends--> --}}


    {{-- ============================= --}}
    {{-- Featured Event Banner --}}
    {{-- ============================= --}}

@if(count($heroBanners))
<section class="featured-banner-section">

    <div class="swiper featuredSwiper">

        <div class="swiper-wrapper">

            @foreach($heroBanners as $banner)

                <div class="swiper-slide">

                    <a href="{{ $banner['link'] }}" class="featured-banner-card">

                        <img
                            src="{{ $banner['image'] }}"
                            class="featured-banner-image"
                            loading="lazy">

                        <div class="featured-overlay"></div>

                        {{-- <span class="featured-detail-btn">

                            {{ $banner['button_text'] }}

                            <i class="ti ti-arrow-right"></i>

                        </span> --}}

                    </a>

                </div>

            @endforeach

        </div>

        <div class="swiper-pagination"></div>

        <div class="featured-prev">
            <i class="ti ti-chevron-left"></i>
        </div>

        <div class="featured-next">
            <i class="ti ti-chevron-right"></i>
        </div>

    </div>

</section>

@endif


    {{-- Form Pencarian --}}
    {{-- <section class="why-us pt-4 pb-4 px-2">
        <div class="container px-0 my-shadow2" data-aos="fade-up" date-aos-delay="200">
            <div class="d-flex flex-column justify-content-center py-5">
                <form class="form-search" method="get" action="/search">
                    @csrf
                    <input type="search" name="key" placeholder="Cari event kesukaan kamu ...">
                    <button class="button btn-success" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </section> --}}

    <section class="why-us pt-0 pb-2 px-2">
        <div class="mt-1 mb-3">

            <form class="search-modern" method="GET" action="/search">
                <i class="ti ti-search search-icon"></i>

                <input
                    type="search"
                    name="key"
                    placeholder="Cari event, seminar, lomba, workshop..."
                    autocomplete="off">

                <button type="submit">
                    <i class="ti ti-search ti-sm"></i> Cari
                </button>
            </form>

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
                                <div class="alert alert-success mt-3" role="alert">
                                    <small>
                                        <strong><i class="fas fa-tag"></i>
                                            @if ($terbaru->ticket->isNotEmpty() && $terbaru->ticket->first()->ticket_price !== null)
                                                {{ $terbaru->ticket->first()->ticket_price == 0 ? 'GRATIS!' : 'Rp ' . number_format($terbaru->ticket->first()->ticket_price, 0, ',', '.') }}
                                            @else
                                                <span>Tidak tersedia</span>
                                            @endif
                                        </strong>
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

    <section class="event-category-section my-0 py-4">

        <div class="container">

            <div class="section-title">
                <h2>Kategori Event</h2>
            </div>

        </div>

        <div class="category-wrapper">

            <button
                type="button"
                class="category-prev">

                <i class="ti ti-chevron-left"></i>

            </button>

            <div class="container">

                <div class="category-slider">

                    @foreach($categories as $category)

                        <a href="#" class="category-item">

                            <div class="category-icon">

                                <i class="{{ $category->icon }}"></i>

                            </div>

                            <span>{{ $category->name }}</span>

                        </a>

                    @endforeach

                </div>

            </div>

            <button
                type="button"
                class="category-next">

                <i class="ti ti-chevron-right"></i>

            </button>

        </div>

    </section>

    {{-- Penawaran --}}
    <section class="event-terbaru-setion pt-4 p-0 bg-eventconnect">
        <div class="container evnt-terbaru pt-0 mt-0 text-white text-center">
            <div class="py-5">
                <h6>Jaidikan event kamu lebih keren di eventverse !!!</h6> <a class="button-21" href="/event/create">
                    <small><strong>BUAT EVENT SEKARANG</strong> <i class="fas fa-rocket"></i></small></a>
            </div>
        </div>
    </section>


    {{-- Event Populer --}}
    <section class="event-terbaru-section bg-soft pt-4 p-0">
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
    @if(!$eventPilihan->isEmpty())
    <section class="event-terbaru-section section-bg pt-4 p-0 bg-soft">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event Pilihan</h2>
        </div>

        @if($eventPilihan->isEmpty())

            <style>
                .empty-state{
                        background:#fff;
                        border-radius:20px;
                        padding:30px;
                        text-align:center;
                        box-shadow:0 4px 20px rgba(0,0,0,.05);
                    }
            </style>

            <div class="container empty-state mx-auto mt-4">

                <h5>Belum ada event pilihan 🎉</h5>

                <p class="text-muted mb-3">
                    Promosikan eventmu sekarang!.
                </p>

                <a href="/event/create" class="button-40">
                    Promosikan Event
                </a>

            </div>

        @endif

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
    @endif


   <!-- =========================================
    WHY EVENTVERSE
========================================= -->

<section class="ev-why py-4 mb-4">

    <div class="container">

        <!-- =========================
                SECTION TITLE
        ========================== -->

        <div class="ev-title">

            <span class="ev-badge">

                <i class="ti ti-sparkles"></i>

                Eventverse.id

            </span>

            <h4>

                Semua kebutuhan event dalam satu platform

            </h4>

            <p>

                Eventverse.id membantu komunitas, organisasi, institusi pendidikan, perusahaan, hingga event organizer mengelola event secara profesional mulai dari registrasi peserta, ticketing, pembayaran, QR Code Check-In, manajemen participant, hingga laporan event dalam satu dashboard modern.

            </p>

        </div>

        <!-- =========================
                CONTENT
        ========================== -->

        <div class="ev-wrapper">

            <!-- =====================================
                        LEFT SIDE
            ====================================== -->

            <div class="ev-left">

                <div class="ev-section-title">

                    <h4>
                        Mengapa Memilih Eventverse?
                    </h4>

                    <p>

                        Semua kebutuhan penyelenggaraan event tersedia
                        dalam satu platform modern sehingga kamu dapat
                        fokus menghadirkan pengalaman terbaik bagi peserta!

                    </p>

                </div>

                <div class="ev-feature-list">

                    <!-- ==================== -->

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <div>
                            <h4>100% Gratis!</h4>
                        </div>
                    </div>

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <div>
                            <h4>Modern event management & ticketing</h4>
                        </div>
                    </div>

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <div>
                            <h4>Payment modern terintegrasi</h4>
                        </div>
                    </div>

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-qrcode"></i>
                        </div>
                        <div>
                            <h4>QR code check in</h4>
                        </div>
                    </div>

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-users-group"></i>
                        </div>
                        <div>
                            <h4>Multi organizer</h4>
                        </div>
                    </div>

                    <!-- ==================== -->

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-mail"></i>
                        </div>

                        <div>
                            <h4>Email & Notifikasi Otomatis</h4>
                        </div>
                    </div>

                    <!-- ==================== -->

                    <div class="ev-feature">
                        <div class="ev-icon">
                            <i class="ti ti-chart-line"></i>
                        </div>
                        <div>
                            <h4>Laporan & Analitik Real-Time</h4>
                        </div>
                    </div>

                </div>

            </div>

            <!-- RIGHT SIDE DIMULAI PADA BAGIAN 2 -->
                        <!-- =====================================
                        RIGHT SIDE
            ====================================== -->

            <div class="ev-right">

                <div class="ev-dashboard">

                    <div class="ev-topbar">

                        <span></span>
                        <span></span>
                        <span></span>

                    </div>

                    <div class="ev-screen">

                        <!-- nanti ganti screenshot dashboard -->

                        <img
                            src="/assets/img/dashboard-ss.png"
                            class="ev-dashboard-image"
                            alt="Dashboard Eventverse">

                    </div>

                </div>

            </div>

        </div>

    </div>


</section>

<style> 
    /* =====================================================
    WHY EVENTVERSE
===================================================== */

.ev-why{

    position: relative;

    overflow:visible;

    padding: 0px 0;

    background:
        radial-gradient(circle at top right,
        rgba(37,99,235,.06),
        transparent 35%),
        linear-gradient(
        180deg,
        #ffffff 0%,
        #f8fbff 100%);

}

/* ====================================== */

.ev-why::before{

    content:"";

    position:absolute;

    width:450px;

    height:450px;

    left:-180px;

    top:-180px;

    border-radius:50%;

    background:#2563eb;

    opacity:.05;

    filter:blur(120px);

}

.ev-why::after{

    content:"";

    position:absolute;

    width:350px;

    height:350px;

    right:-120px;

    bottom:-120px;

    border-radius:50%;

    background:#3b82f6;

    opacity:.04;

    filter:blur(100px);

}

/* ====================================== */

.ev-why .container{

    position:relative;

    z-index:2;

}

/* =====================================================
    SECTION TITLE
===================================================== */

.ev-title{

    max-width:850px;

    margin:0 auto 80px;

    text-align:center;

}

.ev-badge{

    display:inline-flex;

    align-items:center;

    gap:10px;

    padding:10px 20px;

    border-radius:999px;

    background:#eef4ff;

    color:#2563eb;

    font-size:14px;

    font-weight:600;

    margin-bottom:24px;

}

.ev-badge i{

    font-size:18px;

}

.ev-title h4{

    font-size:22px;

    line-height:1.15;

    font-weight:800;

    color:#0f172a;

    letter-spacing:-1px;

    margin-bottom:24px;

}

.ev-title p{

    max-width:760px;

    margin:auto;

    font-size:15px;

    line-height:1.6;

    color:#64748b;

}

/* =====================================================
    CONTENT
===================================================== */

.ev-wrapper{

    display:grid;

    grid-template-columns:1.1fr .9fr;

    gap:70px;

    align-items:start;

}

/* =====================================================
    LEFT
===================================================== */

.ev-left{

    min-width:0;

}

/* =====================================================
    RIGHT
===================================================== */

.ev-right{

    position:sticky;

    top:100px;

    align-self:start;

}

/* =====================================================
    Smooth Animation
===================================================== */

.ev-title,
.ev-left,
.ev-right{

    animation:fadeUp .7s ease;

}

@keyframes fadeUp{

    from{

        opacity:0;

        transform:translateY(35px);

    }

    to{

        opacity:1;

        transform:none;

    }

}

/* =====================================================
    LEFT CONTENT
===================================================== */

.ev-section-title{

    margin-bottom:45px;

}

.ev-section-title h4{

    font-size:22px;

    font-weight:800;

    color:#0f172a;

    letter-spacing:-.5px;

    margin-bottom:15px;

}

.ev-section-title p{

    max-width:560px;

    color:#64748b;

    line-height:1.9;

    font-size:16px;

}

/* =====================================================
    FEATURE LIST
===================================================== */

.ev-feature-list{

    display:flex;

    flex-direction:column;

    gap:16px;

}

/* =====================================================
    FEATURE ITEM
===================================================== */

.ev-feature{

    display:flex;

    align-items:center;

    gap:20px;

    padding:15px 24px;

    background:#fff;

    border-radius:20px;

    border:1px solid #edf2f7;

    transition:.35s;

    position:relative;

}



.ev-feature:hover{

    transform:translateY(-6px);

    border-color:#bfdbfe;

    box-shadow:
        0 18px 45px rgba(15,23,42,.08);

}

/* =====================================================
    ICON
===================================================== */

.ev-icon{

    width:39px;

    height:39px;

    min-width:39px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

    color:#fff;

    font-size:20px;

    transition:.3s;

    box-shadow:
        0 12px 30px rgba(37,99,235,.20);

}

.ev-feature:hover .ev-icon{

    transform:scale(1.08) rotate(-4deg);

}

/* =====================================================
    TEXT
===================================================== */

.ev-feature h4{

    margin:0px;

    color:#0f172a;

    font-size:15px;

    font-weight:500;

}

.ev-feature p{

    margin:0;

    color:#64748b;

    font-size:15px;

    line-height:1.8;

}

/* =====================================================
    SMALL BLUE BAR
===================================================== */

.ev-feature::before{

    content:"";

    position:absolute;

    left:0;

    top:22px;

    bottom:22px;

    width:4px;

    border-radius:20px;

    background:transparent;

    transition:.3s;

}

.ev-feature:hover::before{

    background:#2563eb;

}

/* =====================================================
    SPACING
===================================================== */

.ev-feature:last-child{

    margin-bottom:0;

}

/* =====================================================
    RIGHT SIDE
===================================================== */

.ev-right{

    display:flex;

    flex-direction:column;

    gap:35px;

}

/* =====================================================
    DASHBOARD
===================================================== */

.ev-dashboard{

    background:#fff;

    border-radius:28px;

    overflow:hidden;

    border:1px solid #e5e7eb;

    box-shadow:
        0 25px 60px rgba(15,23,42,.10);

    transition:.35s;

}

.ev-dashboard:hover{

    transform:translateY(-8px);

    box-shadow:
        0 35px 80px rgba(15,23,42,.14);

}

.ev-topbar{

    height:54px;

    display:flex;

    align-items:center;

    gap:10px;

    padding:0 24px;

    background:#f8fafc;

    border-bottom:1px solid #edf2f7;

}

.ev-topbar span{

    width:12px;

    height:12px;

    border-radius:50%;

    background:#cbd5e1;

}

.ev-screen{

    position:relative;

    padding:10px;

    min-height:420px;

    display:flex;

    align-items:center;

    justify-content:center;

    background: #eff1f6;

}

/* =====================================================
    PLACEHOLDER
===================================================== */

.ev-placeholder{

    text-align:center;

    max-width:420px;

}

.ev-placeholder i{

    font-size:70px;

    color:#2563eb;

    margin-bottom:20px;

}

.ev-placeholder h3{

    font-size:28px;

    font-weight:800;

    color:#0f172a;

    margin-bottom:12px;

}

.ev-placeholder p{

    color:#64748b;

    line-height:1.8;

}

/* nanti ketika pakai screenshot */

.ev-dashboard-image{

    width:100%;

    border-radius:12px;

    display:block;

}

/* =====================================================
    ABOUT
===================================================== */

.ev-about{

    background:#fff;

    border-radius:24px;

    padding:35px;

    border:1px solid #edf2f7;

    box-shadow:
        0 10px 35px rgba(15,23,42,.05);

}

.ev-about-badge{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:8px 16px;

    border-radius:999px;

    background:#eef4ff;

    color:#2563eb;

    font-size:14px;

    font-weight:600;

    margin-bottom:20px;

}

.ev-about h3{

    font-size:34px;

    font-weight:800;

    line-height:1.25;

    color:#0f172a;

    margin-bottom:18px;

}

.ev-about p{

    color:#64748b;

    line-height:1.9;

    margin-bottom:18px;

}

/* =====================================================
    HIGHLIGHT
===================================================== */

.ev-highlight{

    margin-top:30px;

    display:grid;

    grid-template-columns:repeat(2,minmax(180px,1fr));

    gap:16px;

}

.ev-highlight div{

    display:flex;

    align-items:center;

    gap:10px;

    color:#334155;

    font-weight:500;

}

.ev-highlight i{

    width:26px;

    height:26px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#ecfdf5;

    color:#16a34a;

    font-size:13px;

    flex-shrink:0;

}

/* =====================================================
    BUTTONS
===================================================== */

.ev-buttons{

    display:flex;

    gap:16px;

    margin-top:35px;

    flex-wrap:wrap;

}

.button-outline{

    background:#fff;

    color:#2563eb;

    border:1px solid #bfdbfe;

}

.button-outline:hover{

    background:#2563eb;

    color:#fff;

}

/* =====================================================
    RESPONSIVE
===================================================== */

@media (max-width:1200px){

    .ev-wrapper{

        grid-template-columns:1fr;

        gap:60px;

    }

    .ev-right{

        position:relative;

        top:0;

    }

    .ev-title{

        margin-bottom:60px;

    }

}

/* ====================================== */

@media (max-width:992px){

    .ev-why{

        padding:90px 0;

    }

    .ev-title h2{

        font-size:42px;

    }

    .ev-section-title h3{

        font-size:30px;

    }

    .ev-about h3{

        font-size:30px;

    }

    .ev-screen{

        min-height:360px;

    }

}

/* ====================================== */

@media (max-width:768px){

    .ev-why{

        padding:70px 0;

    }

    .ev-title{

        margin-bottom:45px;

    }

    .ev-title h2{

        font-size:34px;

    }

    .ev-title p{

        font-size:16px;

        line-height:1.8;

    }

    .ev-wrapper{

        gap:45px;

    }

    .ev-feature{

        padding:18px;

        gap:16px;

    }

    .ev-icon{

        width:52px;

        height:52px;

        min-width:52px;

        font-size:22px;

        border-radius:16px;

    }

    .ev-feature h4{

        font-size:17px;

    }

    .ev-feature p{

        font-size:14px;

    }

    .ev-dashboard{

        border-radius:22px;

    }

    .ev-screen{

        min-height:280px;

        padding:25px;

    }

    .ev-placeholder i{

        font-size:54px;

    }

    .ev-placeholder h3{

        font-size:22px;

    }

    .ev-about{

        padding:28px;

    }

    .ev-about h3{

        font-size:26px;

    }

    .ev-highlight{

        grid-template-columns:1fr;

        gap:14px;

    }

    .ev-buttons{

        flex-direction:column;

    }

    .ev-buttons .button-40{

        width:100%;

        justify-content:center;

    }

}

/* ====================================== */

@media (max-width:480px){

    .ev-badge{

        font-size:13px;

    }

    .ev-title h2{

        font-size:28px;

    }

    .ev-title p{

        font-size:15px;

    }

    .ev-section-title h3{

        font-size:26px;

    }

    .ev-about h3{

        font-size:24px;

    }

    .ev-feature{

        border-radius:18px;

    }

}

/* =====================================================
    SMOOTH ANIMATION
===================================================== */

.ev-feature,
.ev-dashboard,
.ev-about{

    transition:
        transform .35s ease,
        box-shadow .35s ease,
        border-color .35s ease;

}

/* =====================================================
    OPTIONAL SCROLL ANIMATION
===================================================== */

.ev-feature{

    opacity:0;

    transform:translateY(30px);

    animation:evFadeUp .6s forwards;

}

.ev-feature:nth-child(1){ animation-delay:.05s; }
.ev-feature:nth-child(2){ animation-delay:.10s; }
.ev-feature:nth-child(3){ animation-delay:.15s; }
.ev-feature:nth-child(4){ animation-delay:.20s; }
.ev-feature:nth-child(5){ animation-delay:.25s; }
.ev-feature:nth-child(6){ animation-delay:.30s; }
.ev-feature:nth-child(7){ animation-delay:.35s; }
.ev-feature:nth-child(8){ animation-delay:.40s; }
.ev-feature:nth-child(9){ animation-delay:.45s; }
.ev-feature:nth-child(10){ animation-delay:.50s; }
.ev-feature:nth-child(11){ animation-delay:.55s; }
.ev-feature:nth-child(12){ animation-delay:.60s; }

@keyframes evFadeUp{

    to{

        opacity:1;

        transform:translateY(0);

    }

}

/* =====================================================
    IMAGE
===================================================== */

.ev-dashboard-image{

    width:100%;

    display:block;

    border-radius:12px;

}
</style>


    @push('home-js')

    <script>
        new Swiper(".featuredSwiper",{

    loop:true,

    centeredSlides:true,

    slidesPerView:"auto",

    spaceBetween:0,

    speed:700,

    grabCursor:true,

    autoplay:{
        delay:5000,
        disableOnInteraction:false
    },

    pagination:{
        el:".swiper-pagination",
        clickable:true
    },

    navigation:{
        nextEl:".featured-next",
        prevEl:".featured-prev"
    }

});

document.addEventListener("DOMContentLoaded", () => {

    const slider = document.querySelector(".category-slider");

    const prev = document.querySelector(".category-prev");

    const next = document.querySelector(".category-next");

    if (!slider) return;

    const amount = 500;

    next.addEventListener("click", () => {

        slider.scrollBy({

            left: amount,

            behavior: "smooth"

        });

    });

    prev.addEventListener("click", () => {

        slider.scrollBy({

            left: -amount,

            behavior: "smooth"

        });

    });

});
    </script>
        
    @endpush
@endsection
