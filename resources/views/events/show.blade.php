{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    <div class="container pt-4 pb-3 px-0">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row">
            <div class="col-md-8">

                <div class="card shadow mb-3 mx-1">
                    <img src="https://cdn.pixabay.com/photo/2014/08/11/11/50/moon-415501_1280.jpg" class="card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title my-3">CONTOH JUDUL EVENT PERTAMA</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>

                <div class="card mb-3 mx-1 shadow">
                    <div class="card-body">
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
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                            </div>
                            <div class="mt-4">
                                <h5 class="card-title">Syarat & ketentuan</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content p-0">
                            <h5 class="card-title">Ticket</h5>

                            <div class="card shadow-sm ticket-card mt-3" id="ticket-example">
                                <div class="card-body">
                                    <div class="alert alert-success w-100 py-2">
                                        <strong>CONTOH TIKET</strong>
                                    </div>
                                    <hr class="dashed">
                                    <p class="card-text">Contoh deskripsi tiket</p>
                                    <p class="card-text pt-0">
                                        <small class="text-muted icon-class">
                                            <i class="fas fa-hourglass-end pr-1"></i>
                                            Berakhir : <strong>12-20-2023</strong>
                                            <span class="alert alert-secondary rounded-0 py-1 ms-2 ml-2">
                                                <strong>Kuota : 100</strong>
                                                <input type="hidden" name="ticket-quota[]">
                                            </span>
                                        </small>
                                    </p>
                                    <hr class="dashed">
                                    <div class="d-inline">
                                        <span class="alert alert-primary py-2 rounded-0 mt-2">
                                            <strong>Rp 100.000</strong>
                                        </span>
                                        <div class="float-right">
                                            <button class="btn btn-success px-3">BELI TIKET</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm ticket-card mt-3" id="ticket-example">
                                <div class="card-body">
                                    <div class="alert alert-success w-100 py-2">
                                        <strong>CONTOH TIKET ke-2</strong>
                                    </div>
                                    <hr class="dashed">
                                    <p class="card-text">Contoh deskripsi tiket</p>
                                    <p class="card-text pt-0">
                                        <small class="text-muted icon-class">
                                            <i class="fas fa-hourglass-end pr-1"></i>
                                            Berakhir : <strong>12-20-2023</strong>
                                            <span class="alert alert-secondary rounded-0 py-1 ms-2 ml-2">
                                                <strong>Kuota : 100</strong>
                                                <input type="hidden" name="ticket-quota[]">
                                            </span>
                                        </small>
                                    </p>
                                    <hr class="dashed">
                                    <div class="d-inline">
                                        <span class="alert alert-primary py-2 rounded-0 mt-2">
                                            <strong>Rp 100.000</strong>
                                        </span>
                                        <div class="float-right">
                                            <button class="btn btn-success px-3">DAFTAR SEKARANG</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">

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
@endsection
