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
    <!--Header ends-->


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

    <section class="why-us py-4 px-2">
        <div class="my-4">

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
                                <div class="alert alert-info mt-3" role="alert">
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

    {{-- Penawaran --}}
    <section class="event-terbaru-setion pt-4 p-0 bg-eventconnect">
        <div class="container evnt-terbaru pt-0 mt-0 text-white text-center">
            <div class="py-5">
                <h6>Jaidikan event kamu lebih keren disini !!!</h6> <a class="button-1" href="/event/create">
                    <small><strong>BUAT EVENT SEKARANG</strong> <i class="fas fa-rocket"></i></small></a>
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


    <!-- ======= Why Us Section ======= -->
    <section class="event-terbaru-setion p-0">

        <style>

        .feature-section{

            background:#fff;

            border-radius:28px;

            padding:40px 30px;

            box-shadow:
                0 10px 40px rgba(0,0,0,.05);
        }

        .section-title{

            font-size:22px;

            font-weight:700;

            color:#0f172a;
        }

        .section-subtitle{

            color:#64748b;

            max-width:700px;

            margin:auto;
        }

        .feature-grid{

            display:grid;

            grid-template-columns:
                repeat(auto-fit,minmax(250px,1fr));

            gap:18px;

            margin-top:35px;
        }

        .feature-card{

            background:#fff;

            border:1px solid #eef2f7;

            border-radius:20px;

            padding:22px;

            transition:.25s;
        }

        .feature-card:hover{

            transform:translateY(-4px);

            box-shadow:
                0 10px 25px rgba(0,0,0,.06);
        }

        .feature-icon{

            width:52px;
            height:52px;

            border-radius:16px;

            display:flex;
            align-items:center;
            justify-content:center;

            margin-bottom:14px;

            font-size:22px;

            background:rgba(59,130,246,.08);

            color:#2563eb;
        }

        .feature-title{

            font-size:17px;

            font-weight:700;

            color:#0f172a;

            margin-bottom:8px;
        }

        .feature-desc{

            font-size:14px;

            color:#64748b;

            margin-bottom:0;
        }

        .about-card{

            margin-top:40px;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #ffffff
                );

            border-radius:24px;

            padding:35px;

            border:1px solid #eef2f7;
        }

        .about-title{

            font-size:22px;

            font-weight:700;

            color:#0f172a;
        }

        .about-desc{

            color:#64748b;

            line-height:1.9;
        }

        .about-button{

            margin-top:15px;
        }

        @media(max-width:768px){

            .feature-section{
                padding:25px 20px;
            }

            .section-title{
                font-size:20px;
            }

            .about-title{
                font-size:20px;
            }

        }

        </style>

        <div class=" feature-section">

            <div class="text-center">

                <h3 class="section-title">
                    Mengapa Memilih EventHub?
                </h3>

                <p class="section-subtitle">
                    Platform manajemen event modern untuk membantu penyelenggara mengelola registrasi, ticketing, pembayaran, dan peserta dalam satu dashboard terintegrasi.
                </p>

            </div>

            <div class="feature-grid">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="ti ti-ticket"></i>
                    </div>

                    <div class="feature-title">
                        Ticketing Profesional
                    </div>

                    <p class="feature-desc">
                        Tingkatkan citra event dengan sistem registrasi dan ticketing yang lebih profesional dan terpercaya.
                    </p>

                </div>

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="ti ti-credit-card"></i>
                    </div>

                    <div class="feature-title">
                        Pembayaran Otomatis
                    </div>

                    <p class="feature-desc">
                        Mendukung berbagai metode pembayaran dengan proses transaksi yang cepat dan aman.
                    </p>

                </div>

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="ti ti-qrcode"></i>
                    </div>

                    <div class="feature-title">
                        QR Check-In
                    </div>

                    <p class="feature-desc">
                        Check-in peserta lebih cepat menggunakan QR Code Ticketing yang modern dan akurat.
                    </p>

                </div>

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="ti ti-users"></i>
                    </div>

                    <div class="feature-title">
                        Kelola Peserta
                    </div>

                    <p class="feature-desc">
                        Semua data peserta tersimpan rapi dan dapat diakses kapan saja dari dashboard organizer.
                    </p>

                </div>

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="ti ti-chart-bar"></i>
                    </div>

                    <div class="feature-title">
                        Statistik Real-Time
                    </div>

                    <p class="feature-desc">
                        Pantau peserta, pembayaran, kehadiran, dan performa event secara langsung.
                    </p>

                </div>

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="ti ti-link"></i>
                    </div>

                    <div class="feature-title">
                        Short Link Event
                    </div>

                    <p class="feature-desc">
                        Bagikan event dengan URL yang lebih singkat dan mudah diingat oleh peserta.
                    </p>

                </div>

            </div>

            <div class="about-card">

                <h3 class="about-title">
                    Apa itu EventHub?
                </h3>

                <p class="about-desc">
                    EventHub adalah platform manajemen event dan ticketing online yang membantu komunitas, organisasi, institusi pendidikan, dan perusahaan mengelola event secara lebih profesional.
                </p>

                <p class="about-desc">
                    Mulai dari registrasi peserta, penjualan tiket, pembayaran online, QR Code check-in, sertifikat digital, hingga laporan dan analisis event dapat dikelola dalam satu dashboard yang mudah digunakan.
                </p>

                <a href="/about-us" class="button-40 about-button">
                    Pelajari Lebih Lanjut
                </a>

            </div>

        </div>

        </section>
    <!-- End Why Us Section -->
@endsection
