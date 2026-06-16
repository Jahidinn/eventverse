@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h2>Cari event favoritmu disini! 🤩</h2>
            </div>

        </div>

        <!--Waves end-->

    </div>

    <form class="form-serch" method="get" action="" id="search-filter-form">
        @csrf
        <section class="why-us  pt-4 pb-4 px-2">
            <div class="px-0" data-aos="fade-up" date-aos-delay="200">
                <div class="justify-content-center py-3 ">

                    {{-- <div class="form-search">
                        <input type="search" name="key" placeholder="Cari event kesukaan kamu ..."
                            value="{{ request('key') }}">
                        <button class="button" type="submit">Cari</button>
                    </div> --}}

                    <div class="search-modern mb-3">
                        <i class="ti ti-search search-icon"></i>

                        <input
                            type="search"
                            name="key"
                            value="{{ request('key') }}"
                            placeholder="Cari event, seminar, lomba, workshop...">

                        <button class="button" type="submit">
                            <i class="ti ti-search ti-sm"></i> Cari
                        </button>
                    </div>

                    

                    @if (request('catName') || request('location') || request('city') || request('date'))
                        <div class="form-search mt-2">
                            <h6><span class="badge badge-secondary">FILTER</span>
                                @if (request('catName'))
                                    <span class="badge badge-secondary">Kategori: {{ request('catName') }}</span>
                                @endif

                                @if (request('location'))
                                    <span class="badge badge-secondary">{{ request('location') }}</span>
                                @endif

                                @if (request('city'))
                                    <span class="badge badge-secondary">{{ ucwords(strtolower(request('city'))) }}</span>
                                @endif

                                @if (request('date'))
                                    <span class="badge badge-secondary">Waktu {{ request('date') }}</span>
                                @endif
                            </h6>
                        </div>
                    @endif
                </div>
            </div>

            <div class="container shadow-none mt-3 text-center">
                <button class="btn btn-info filter" type="button" data-toggle="modal" data-target="#filterModal"><i
                        class="fas fa-filter"></i> Filter</button>
                <button class="btn btn-info filter" type="button" data-toggle="modal" data-target="#sortModal"><i
                        class="fas fa-sort"></i> Urutkan</button>

                <!-- Modal filter -->
                <div class="modal fade" id="filterModal" aria-labelledby="filterModalLabel" aria-hidden="true"
                    style="z-index: 99999">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filterModalLabel">Filter pencarian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">

                                <div class="form-group mb-1">
                                    <label class="form-control-label" for="filter-category">KATEGORI EVENT</label>
                                    <select class="form-control filter-category" id="filter-category" name="category">
                                        <option value="">Semua kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ ucwords(strtolower($category->category)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- Input tidak dipakai hanya untuk menampilkan kategori filter saja  --}}
                                    <input type="hidden" name="catName" id="cat-name" value="{{ request('catName') }}">
                                </div>

                                <div class="form-group mb-1">
                                    <label class="form-control-label" for="filter-jenis-lokasi">JENIS EVENT</label>
                                    <select class="form-control rounded-0" id="filter-jenis-lokasi" name="location">
                                        @foreach ($jenisevent as $jenis)
                                            <option
                                                value="{{ $jenis['val'] }}"{{ request('location') == $jenis['val'] ? 'selected' : '' }}>
                                                {{ $jenis['text'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-1 container-city"
                                    {{ request('location') == 'Online' ? 'hidden' : '' }}>
                                    <label for="filter-city" class="form-control-label">KOTA</label>
                                    <select class="form-control filter-city" id="filter-city" name="city">
                                        <option value="">Semua kota</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->name }}"
                                                {{ request('city') == $city->name ? 'selected' : '' }}>
                                                {{ ucwords(strtolower($city->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="filter-date" class="form-control-label">WAKTU</label>
                                <div id="datepicker" class="input-group date mb-3" data-date-format="yyyy-mm-dd">
                                    <input class="form-control rounded-0" id="filter-date" name="date" type="text"
                                        placeholder="yyyy-mm-dd" value="{{ request('date') }}">
                                    <span class="input-group-addon"></span>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" id="berbayar"
                                        value="1" {{ request('price') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="berbayar">
                                        Berbayar
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" id="free"
                                        value="0" {{ request('price') == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="free">
                                        Gratis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" id="all"
                                        value="" {{ request('price') == '' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all">
                                        Semua
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i>
                                    Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal  urutkan-->
                <div class="modal fade" id="sortModal" aria-labelledby="sortModalLabel" aria-hidden="true"
                    style="z-index: 99999">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sortModalLabel">Urutkan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-1 test-left">
                                    <select class="form-control rounded-0" id="sort-filter" name="sort">
                                        @foreach ($sorts as $sort)
                                            <option value="{{ $sort }}"
                                                {{ request('sort') == $sort ? 'selected' : '' }}>{{ $sort }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    {{-- Cari event ... --}}
    <section class="event-terbaru-section pt-2 p-0">
        <div class="section-title pb-0">
            <h2 class="mt-0">Search results</h2>
        </div>

        <div class="container-fluid m-auto row pt-0 mt-0 search-result-box">
            @foreach ($eventTerbaru as $terbaru)
                <div class="col-md-3 mb-4 card-event-search">
                    <a href="/{{ $terbaru->slug }}" target="_blank">
                        <div class="card profile-card-5 shadow">
                            <div class="card-img-block rounded">

                                @php
                                    if ($terbaru->image == '' || $terbaru->image == null) {
                                        //Jika gambar kosong
                                        $image = 'assets/default-img/event-images/def-img.png';
                                    } else {
                                        $imgPath = 'storage/event-images/' . $terbaru->image;

                                        // Memeriksa apakah file ada
                                        if (file_exists(public_path($imgPath))) {
                                            $image = 'storage/event-images/' . $terbaru->image;
                                        } else {
                                            // Jika file tidak ada, ganti dengan default
                                            $image = 'assets/default-img/event-images/def-no-img.png';
                                        }
                                    }
                                @endphp

                                <img class="card-img-top" src="{{ asset($image) }}" alt="Image">
                            </div>
                            <div class="card-body pt-0">

                                @php
                                    if (strlen($terbaru->title) > 50) {
                                        $title_search = substr($terbaru->title, 0, 50) . ' ...';
                                    } else {
                                        $title_search = $terbaru->title;
                                    }
                                @endphp
                                <h5 class="card-title pb-0 mb-0">{{ $title_search }}</h5>

                                <small class="location"><i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $terbaru->location_jenis == 'Offline' ? ucwords(strtolower($terbaru->location_city)) : $terbaru->location_jenis }}</small>
                                <hr class="mb-1 mt-1">
                                <small>{{ $terbaru->start_date->format('dd-mm-Y') == $terbaru->end_date->format('dd-mm-Y') ? $terbaru->end_date->format('d M Y') : $terbaru->start_date->format('d M Y') . ' - ' . $terbaru->end_date->format('d M Y') }}</small>
                                <p class="card-text">
                                <div class="alert alert-info" role="alert">
                                    
                                    <small>
                                        <strong>
                                            <i class="fas fa-tag"></i>
                                            @php
                                                $firstTicket = $terbaru->ticket->first();
                                            @endphp

                                            {{ !$firstTicket || $terbaru->ticket_price == 0
                                                ? 'GRATIS!'
                                                : 'Rp ' . number_format($terbaru->ticket_price, 0, ',', '.') }}
                                            
                                        </strong>
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

            {{-- Null event --}}
            @if (count($eventTerbaru) == null)
                <div class="no-data-event mx-auto w-100 px-2">
                    <div class="alert alert-danger" role="alert">
                        <span><strong>Ooopss... event yang kamu cari sepertinya ngga ada guys!</strong></span>
                    </div>
                </div>
            @endif
            {{-- Null event --}}

        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $eventTerbaru->links() }}
        </div>
        {{-- Pagination --}}

    </section>

    {{-- Penawaran --}}
    {{-- <section class="event-terbaru-setion section-bg pt-4 p-0" style="background-color: #1e4356;">
        <div class="container evnt-terbaru pt-0 mt-0 text-white text-center">
            <div class="py-5">
                <h6>Belum punya event di eventconnect.id?</h6> <button class="btn btn-success"><small><strong><i
                                class="fa fa-calendar-plus"></i> BUAT EVENT</strong></small></button>
            </div>
        </div>
    </section> --}}
@endsection
