@extends('layouts.main')

@section('content')
    {{-- banner --}}
    <section class="banner">
        <div class="wrapper">
            <div class="banner-carousel">
                <div class="box-image"> <img src="{{ asset('assets/img/service-details-1.jpg') }}" alt="First slide"></div>
                <div class="box-image"> <img src="{{ asset('assets/img/service-details-2.jpg') }}" alt="Second slide"></div>
                <div class="box-image"> <img src="{{ asset('assets/img/service-details-3.jpg') }}" alt="Third slide"></div>
                <div class="box-image"> <img src="{{ asset('assets/img/service-details-4.jpg') }}" alt="Third slide"></div>
            </div>
        </div>
    </section>

    {{-- Form Pencarian --}}
    <section class="why-us  pt-4 pb-4">
        <div class="container" data-aos="fade-up" date-aos-delay="200">
            <div class="d-flex flex-column justify-content-center py-5 px-1">
                <form class="form-search" method="get" action="#">
                    <input type="search" name="search" placeholder="Cari event kesukaan kamu ...">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </div>
    </section>

    {{-- Event terbaru --}}
    <section class="event-terbaru-section section-bg pt-4 p-0" style="background-color: #EFF8FD ">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event terbaru</h2>
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

    {{-- Event terbaru --}}
    <section class="event-terbaru-setion section-bg pt-4 p-0" style="background-color: #1e4356;">
        <div class="container evnt-terbaru pt-0 mt-0 text-white text-center">
            <div class="py-5">
                <h6>Belum punya event di eventconnect.id?</h6> <button class="btn btn-success"><small><strong><i
                                class="fa fa-calendar-plus"></i> BUAT EVENT</strong></small></button>
            </div>
        </div>
    </section>


    {{-- Event terbaru --}}
    <section class="event-terbaru-section section-bg pt-4 p-0" style="background-color: #fff ">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event pupuler</h2>
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
                            <small>{{ $count }} Oktober 2021</small>
                            <hr>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <hr>
                            <small>{{ $count }} Oktober 2021</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Event terbaru --}}
    <section class="event-terbaru-section section-bg pt-4 p-0" style="background-color: #fff ">
        <div class="section-title pb-0">
            <h2 class="mt-0">Event pilihan</h2>
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
                            <small>{{ $count }} Oktober 2021</small>
                            <hr>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <hr>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- ======= Why Us Section ======= -->
    <section class="why-us section-bg" data-aos="fade-up" date-aos-delay="200">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 video-box">
                    <img src="{{ asset('assets/img/service-details-1.jpg') }}" class="img-fluid" alt="">
                    <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4" data-vbtype="video"
                        data-autoplay="true"></a>
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
                        <p class="description ml-4 mb-0 pb-0"><i class="fa fa-check text-success"></i> Manajemen event lebih
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
