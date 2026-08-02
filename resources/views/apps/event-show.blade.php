@extends('layouts.main')

@section('content')

@if(session()->has('success'))
<script>
    alertify.alert(
        "Sukses!",
        "<i class='ti ti-circle-check text-success fs-4'></i> {{ session('success') }}"
    );
</script>
@endif

<div class="bg-eventconnect header-hight"></div>

<div class="modern-event-detail py-4 py-lg-5">
    <div class="container">
        <div class="row g-4 position-relative">

            {{-- ========================================================= --}}
            {{-- LEFT CONTENT --}}
            {{-- ========================================================= --}}
            <div class="col-lg-8">

                @php
                    if(blank($detailEvent->image)){
                        $img = 'assets/default-img/event-images/def-no-img.png';
                    }else{
                        $bannerPath = 'storage/event-images/'.$detailEvent->image;
                        if(file_exists(public_path($bannerPath))){
                            $img = $bannerPath;
                        }else{
                            $img='assets/default-img/event-images/def-no-img.png';
                        }
                    }

                    $gallery = collect();
                    $gallery->push([
                        'image'=>asset($img),
                        'banner'=>true
                    ]);

                    foreach($detailEvent->images as $image){
                        $galleryPath='storage/event-gallery/'.$image->image;
                        if(file_exists(public_path($galleryPath))){
                            $gallery->push([
                                'image'=>asset($galleryPath),
                                'banner'=>false
                            ]);
                        }
                    }

                    if ($detailEvent->organizer == 'org') {
                        $organizerName = $detailEvent->org->org_name ?? '';
                        $organizerUrl  = '/organisasi/'.$detailEvent->org->org_id;
                    } elseif ($detailEvent->organizer == 'individual') {
                        $organizerName = $detailEvent->individual->name ?? '';
                        $organizerUrl  = '/user/'.$detailEvent->individual->username;
                    } else {
                        $organizerName = '';
                        $organizerUrl = '#';
                    }

                    $minPrice = $ticketData->min('ticket_price');
                    $isFree = $ticketData->count()
                        ? $ticketData->every(fn($ticket)=>$ticket->ticket_price==0)
                        : true;
                @endphp

                <!-- MAIN EVENT CARD -->
                <div class="modern-card event-detail-card mb-4">

                    {{-- HERO CAROUSEL --}}
                    <div class="event-hero">
                        <div id="eventCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner">
                                @foreach($gallery as $key=>$photo)
                                    <div class="carousel-item {{ $key==0 ? 'active':'' }}">
                                        <img src="{{ $photo['image'] }}" class="hero-image" alt="{{ $detailEvent->title }}">
                                    </div>
                                @endforeach
                            </div>

                            @if($gallery->count() > 1)
                                <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev">
                                    <i class="ti ti-chevron-left text-dark fs-4"></i>
                                </a>
                                <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next">
                                    <i class="ti ti-chevron-right text-dark fs-4"></i>
                                </a>
                            @endif
                        </div>

                        @if($gallery->count() > 1)
                        <div class="hero-thumbnails">
                            @foreach($gallery as $key=>$photo)
                                <button class="hero-thumb {{ $key==0 ? 'active':'' }}" data-target="#eventCarousel" data-slide-to="{{ $key }}">
                                    <img src="{{ $photo['image'] }}" alt="Thumbnail">
                                    @if($photo['banner'])
                                        <span class="hero-label">Banner</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- CONTENT HEADER & META --}}
                    <div class="event-content">
                        
                        <!-- Badges & Category -->
                        <div class="event-badges">
                            <span class="badge badge-category">
                                <i class="ti ti-tag me-1"></i> {{ $detailEvent->category->name }}
                            </span>
                            <span class="badge badge-location">
                                <i class="ti ti-map-pin me-1"></i> {{ $detailEvent->location_jenis }}
                            </span>
                            @if($isFree)
                                <span class="badge badge-free"><i class="ti ti-gift me-1"></i> Gratis</span>
                            @else
                                <span class="badge badge-price"><i class="ti ti-ticket me-1"></i> Mulai Rp {{ number_format($minPrice,0,',','.') }}</span>
                            @endif
                        </div>

                        <!-- Title & Organizer -->
                        <div class="event-header">
                            <h1 class="event-title">{{ $detailEvent->title }}</h1>
                            <a href="{{ $organizerUrl }}" class="event-organizer-link">
                                <i class="ti ti-circle-check-filled text-primary fs-5"></i>
                                <span>{{ $organizerName }}</span>
                            </a>
                        </div>

                        <!-- Meta Info Grid -->
                        <div class="event-meta-grid">
                            <div class="meta-card">
                                <div class="meta-icon">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                                <div class="meta-info">
                                    <small>Tanggal & Waktu</small>
                                    <h6>
                                        @if($detailEvent->start_date == $detailEvent->end_date)
                                            {{ date('d M Y', strtotime($detailEvent->start_date)) }}
                                        @else
                                            {{ date('d M Y', strtotime($detailEvent->start_date)) }} - {{ date('d M Y', strtotime($detailEvent->end_date)) }}
                                        @endif
                                    </h6>
                                </div>
                            </div>

                            <div class="meta-card">
                                <div class="meta-icon">
                                    <i class="ti ti-map-pin-filled"></i>
                                </div>
                                <div class="meta-info">
                                    <small>Lokasi Event</small>
                                    <h6>
                                        @if(strtolower($detailEvent->location_jenis) == 'online')
                                            Online Event
                                        @else
                                            {{ $detailEvent->location_detail }}<br>
                                            <span class="text-muted fw-normal">{{ $detailEvent->location_city }}, {{ $detailEvent->province->name }}</span>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="event-bottom-bar">
                            <div class="publish-date">
                                <i class="ti ti-clock me-1"></i> Dipublikasikan {{ $detailEvent->created_at->diffForHumans() }}
                            </div>
                            <div class="event-action-group">
                                <button class="btn action-btn" data-toggle="modal" data-target="#shareQrModal" title="QR Code">
                                    <i class="ti ti-qrcode"></i>
                                </button>
                                <button class="btn action-btn copyButton" title="Salin Link">
                                    <i class="ti ti-link"></i>
                                </button>
                                <button class="btn action-btn btn-share-main" data-toggle="modal" data-target="#shareModal" title="Bagikan">
                                    <i class="ti ti-share"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TABS SECTION (TIKET & DESKRIPSI) --}}
                <div class="modern-card p-4">
                    <div class="modern-tabs-wrapper">
                        <div class="modern-tabs mb-0">
                            <button id="ticket-tab" class="nav-link active">
                                <i class="ti ti-ticket fs-5"></i>
                                <span>Tiket</span>
                            </button>
                            <button id="description-tab" class="nav-link">
                                <i class="ti ti-file-text fs-5"></i>
                                <span>Deskripsi</span>
                            </button>
                        </div>
                    </div>

                    <div class="tab-content-container mt-4">
                        {{-- TICKET CONTENT --}}
                        <div id="ticket-content">
                            @include('apps.event-list-ticket')
                        </div>

                        {{-- DESCRIPTION CONTENT --}}
                        <div id="description-content" class="description-wrapper" style="display:none;">
                            <div class="description-header mb-3">
                                <h4 class="fw-bold m-0">Tentang Event</h4>
                                <p class="text-muted small">Informasi lengkap mengenai acara ini.</p>
                            </div>
                            <div class="event-description">
                                {!! $detailEvent->description !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- RIGHT SIDEBAR (STICKY CONTAINER) --}}
            {{-- ========================================================= --}}
            <div class="col-lg-4">
                <div class="sticky-sidebar">

                    <!-- REGISTER CARD (STICKY PRIMARY) -->
                    <div class="modern-card register-card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted fw-semibold d-block">Mulai Dari</small>
                                    <h3 class="mb-0 fw-extrabold text-primary-custom">
                                        @if($isFree)
                                            Gratis
                                        @else
                                            Rp {{ number_format($minPrice,0,',','.') }}
                                        @endif
                                    </h3>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light-primary text-primary-custom px-3 py-2 rounded-pill fw-bold">
                                        {{ $ticketData->count() }} Pilihan Tiket
                                    </span>
                                </div>
                            </div>

                            @php
                                $registrationClosed = false;
                                if(!blank($detailEvent->registration_end)){
                                    $registrationClosed = now()->gt($detailEvent->registration_end);
                                }
                            @endphp

                            @if($registrationClosed)
                                <button class="register-btn register-btn-disabled" disabled>
                                    <i class="ti ti-lock fs-5"></i>
                                    <span>Pendaftaran Ditutup</span>
                                </button>
                            @else
                                <button type="button" class="register-btn btn-gradient" data-toggle="modal" data-target="#ticketSelectModal">
                                    <span>Daftar Sekarang</span>
                                    <i class="ti ti-arrow-right fs-5"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- ORGANIZER CARD -->
                    <div class="modern-card organizer-card mb-4">
                        <div class="card-body p-3 p-xl-4">
                            @php
                                if($detailEvent->organizer == 'org'){
                                    $logo = $detailEvent->org->logo ? asset('storage/organization-logo/'.$detailEvent->org->logo) : asset('assets/default-img/profile.png');
                                    $organizerName = $detailEvent->org->org_name;
                                    $organizerUsername = $detailEvent->org->username ? '@'.$detailEvent->org->username : 'Organisasi Terverifikasi';
                                    $organizerLink = url('/organisasi/'.$detailEvent->org->org_id);
                                    $typeLabel = 'Organisasi';
                                }else{
                                    $logo = $detailEvent->individual->profile_picture ? asset('storage/profile-images/'.$detailEvent->individual->profile_picture) : asset('assets/default-img/profile.png');
                                    $organizerName = $detailEvent->individual->name;
                                    $organizerUsername = '@'.$detailEvent->individual->username;
                                    $organizerLink = url('/user/'.$detailEvent->individual->username);
                                    $typeLabel = 'Single';
                                }
                            @endphp

                            <!-- Header Label -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="organizer-section-title">DISELENGGARAKAN OLEH</span>
                                <span class="badge bg-light-primary text-primary-custom rounded-pill px-2 py-1 fs-xs fw-bold">
                                    {{ $typeLabel }}
                                </span>
                            </div>

                            <!-- Organizer Profile Box -->
                            <div class="organizer-profile-wrapper">
                                <div class="avatar-container">
                                    <img src="{{ $logo }}" class="organizer-avatar-img" alt="{{ $organizerName }}">
                                    <span class="verify-badge-icon" title="Terverifikasi">
                                        <i class="ti ti-circle-check-filled"></i>
                                    </span>
                                </div>

                                <div class="organizer-text-info">
                                    <h6 class="organizer-title-text" title="{{ $organizerName }}">
                                        <a href="{{ $organizerLink }}">{{ $organizerName }}</a>
                                    </h6>
                                    <span class="organizer-handle-text">{{ $organizerUsername }}</span>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="my-3 border-light-subtle">

                            <!-- Action Group -->
                            <div class="d-flex gap-2">
                                <a href="{{ $organizerLink }}" class="btn btn-outline-primary-custom w-100 btn-sm-custom d-flex align-items-center justify-content-center gap-1">
                                    <i class="ti ti-user fs-5"></i>
                                    <span>Lihat Profil</span>
                                </a>
                                <a href="{{ $organizerLink }}" class="btn btn-light-primary btn-icon-custom" title="Kunjungi Profil Penyelenggara">
                                    <i class="ti ti-external-link fs-5"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- CREATE EVENT PROMO CARD -->
                    <div class="modern-card promo-card mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="promo-icon mb-2">
                                <i class="ti ti-rocket text-primary-custom"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Ingin membuat event?</h6>
                            <p class="text-muted small mb-3">Kelola pendaftaran, QR Check-in, sertifikat, & tiket dengan mudah.</p>
                            <a href="{{ url('/event/create') }}" class="btn btn-light-primary w-100 fw-bold">
                                Buat Event Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- PARTICIPANT GUIDE CARD -->
                    <div class="modern-card guide-card">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                <i class="ti ti-info-circle text-primary-custom fs-5"></i> Panduan Peserta
                            </h6>
                            <ul class="guide-list p-0 m-0">
                                <li>
                                    <div class="guide-icon success"><i class="ti ti-check"></i></div>
                                    <span>Pilih jenis tiket yang masih tersedia.</span>
                                </li>
                                <li>
                                    <div class="guide-icon primary"><i class="ti ti-credit-card"></i></div>
                                    <span>Selesaikan pembayaran sesuai metode pilihan.</span>
                                </li>
                                <li>
                                    <div class="guide-icon warning"><i class="ti ti-mail"></i></div>
                                    <span>E-ticket dikirim otomatis via email & akun.</span>
                                </li>
                                <li>
                                    <div class="guide-icon info"><i class="ti ti-qrcode"></i></div>
                                    <span>Tunjukkan QR Code e-ticket saat check-in.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- RECOMMENDED EVENTS --}}
        {{-- ========================================================= --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0 text-dark">Event Lainnya Untuk Anda</h4>
                </div>
            </div>

            @forelse($recomendedEvents as $event)
                @php
                    if(blank($event->image)){
                        $eventImage = asset('assets/default-img/event-images/def-no-img.png');
                    }else{
                        $path = 'storage/event-images/'.$event->image;
                        if(file_exists(public_path($path))){
                            $eventImage = asset($path);
                        }else{
                            $eventImage = asset('assets/default-img/event-images/def-no-img.png');
                        }
                    }

                    $eventMinPrice = $event->tickets->min('ticket_price');
                    $eventFree = $event->tickets->count()
                        ? $event->tickets->every(fn($ticket)=>$ticket->ticket_price==0)
                        : true;
                @endphp

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="modern-event-card">
                        <div class="event-card-img-wrapper">
                            <a href="{{ url('/event/'.$event->slug) }}">
                                <img src="{{ $eventImage }}" class="event-card-image" alt="{{ $event->title }}">
                            </a>
                            <span class="event-card-category-badge">
                                {{ $event->category?->name }}
                            </span>
                        </div>

                        <div class="event-card-body">
                            <h5 class="event-card-title">
                                <a href="{{ url('/event/'.$event->slug) }}">
                                    {{ Str::limit($event->title, 55) }}
                                </a>
                            </h5>

                            <div class="event-card-meta">
                                <div><i class="ti ti-calendar me-1"></i>{{ date('d M Y', strtotime($event->start_date)) }}</div>
                                <div><i class="ti ti-map-pin me-1"></i>{{ $event->location_city }}</div>
                            </div>

                            <div class="event-card-footer">
                                <div class="price">
                                    @if($eventFree)
                                        Gratis
                                    @else
                                        Mulai Rp {{ number_format($eventMinPrice,0,',','.') }}
                                    @endif
                                </div>
                                <a href="{{ url('/event/'.$event->slug) }}" class="btn btn-sm btn-outline-primary-custom px-3 rounded-pill">
                                    Detail <i class="ti ti-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-4 text-center text-muted">
                        Belum ada event lainnya saat ini.
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

{{-- ========================================================= --}}
{{-- MODAL PILIH TIKET (DAFTAR SEKARANG) --}}
{{-- ========================================================= --}}
<div class="modal fade" id="ticketSelectModal" tabindex="-1" aria-labelledby="ticketSelectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: var(--radius-lg); overflow: hidden;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="ticketSelectModalLabel">Pilih Tiket</h5>
                    <p class="text-muted small mb-0">Silakan pilih tiket yang tersedia untuk melanjutkan pendaftaran.</p>
                </div>
                <button type="button" class="close btn-close-custom" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x fs-4"></i>
                </button>
            </div>
            <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                @include('apps.event-list-ticket')
            </div>
        </div>
    </div>
</div>

{{-- MODERN STYLES --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --primary-rgb: 3, 114, 205;
    --primary-color: rgb(3, 114, 205);
    --primary-hover: rgb(2, 90, 163);
    --primary-light: rgba(3, 114, 205, 0.08);
    --primary-gradient: linear-gradient(135deg, rgb(3, 114, 205) 0%, rgb(2, 85, 155) 100%);
    --bg-main: #F8FAFC;
    --card-bg: #FFFFFF;
    --text-dark: #0F172A;
    --text-muted: #64748B;
    --border-color: #E2E8F0;
    --radius-lg: 20px;
    --radius-md: 14px;
    --radius-sm: 10px;
}

body {
    background-color: var(--bg-main);
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
}

.text-primary-custom { color: var(--primary-color) !important; }
.bg-light-primary { background-color: var(--primary-light) !important; }

/* STICKY SIDEBAR */
.sticky-sidebar {
    position: -webkit-sticky;
    position: sticky;
    top: 90px;
    z-index: 10;
}

/* CARDS GENERAL */
.modern-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* HERO CAROUSEL */
.event-hero {
    position: relative;
    background: #0F172A;
}

.hero-image {
    width: 100%;
    height: 420px;
    object-fit: cover;
}

.carousel-control-prev, .carousel-control-next {
    width: 42px;
    height: 42px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    margin: 0 16px;
    opacity: 0.9;
    border: 1px solid var(--border-color);
}
.carousel-control-prev:hover, .carousel-control-next:hover {
    background: #FFFFFF;
    opacity: 1;
}

.hero-thumbnails {
    display: flex;
    gap: 10px;
    padding: 12px 16px;
    background: #FFFFFF;
    border-bottom: 1px solid var(--border-color);
    overflow-x: auto;
}

.hero-thumb {
    position: relative;
    border: none;
    background: transparent;
    padding: 0;
    cursor: pointer;
    border-radius: var(--radius-sm);
    overflow: hidden;
}

.hero-thumb img {
    width: 80px;
    height: 56px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.hero-thumb.active img {
    border-color: var(--primary-color);
}

.hero-label {
    position: absolute;
    bottom: 4px;
    left: 4px;
    background: var(--primary-color);
    color: #FFF;
    font-size: 9px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
}

/* EVENT CONTENT */
.event-content {
    padding: 28px;
}

.event-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.event-badges .badge {
    font-size: 12px;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
}

.badge-category { background: var(--primary-light); color: var(--primary-color); }
.badge-location { background: #E0F2FE; color: #0369A1; }
.badge-free { background: #DCFCE7; color: #15803D; }
.badge-price { background: #FEF3C7; color: #B45309; }

.event-title {
    font-size: 26px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 10px;
    line-height: 1.3;
}

.event-organizer-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--text-muted);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
}
.event-organizer-link:hover { color: var(--primary-color); text-decoration: none; }

/* META GRID */
.event-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin: 24px 0;
}

.meta-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px;
    border-radius: var(--radius-md);
    background: #F8FAFC;
    border: 1px solid var(--border-color);
}

.meta-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(3, 114, 205, 0.1);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.meta-info small { color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 2px; }
.meta-info h6 { margin: 0; font-size: 14px; font-weight: 700; color: var(--text-dark); }

/* ACTION BAR */
.event-bottom-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.publish-date { font-size: 13px; color: var(--text-muted); }
.event-action-group { display: flex; gap: 8px; }

.action-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #F1F5F9;
    color: var(--text-dark);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.2s;
}

.action-btn:hover { background: var(--border-color); color: var(--text-dark); }
.btn-share-main { background: var(--primary-light); color: var(--primary-color); }
.btn-share-main:hover { background: var(--primary-color); color: #FFF; }

/* TABS */
.modern-tabs-wrapper {
    background: #F1F5F9;
    padding: 6px;
    border-radius: 16px;
    display: inline-block;
    width: 100%;
}

.modern-tabs {
    display: flex;
    gap: 6px;
}

.modern-tabs .nav-link {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.2s ease;
}

.modern-tabs .nav-link.active {
    background: #FFF;
    color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* TICKET CARD */
.ticket-grid { display: grid; gap: 16px; }

.ticket-card {
    background: #FFF;
    border: 1.5px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 20px;
    transition: all 0.2s ease;
}

.ticket-card:hover { border-color: var(--primary-color); }

.ticket-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.ticket-title { font-size: 18px; font-weight: 700; color: var(--text-dark); margin: 0; }
.ticket-desc { font-size: 13px; color: var(--text-muted); margin-top: 4px; margin-bottom: 0; }

.status-badge {
    padding: 4px 12px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.status-badge.available { background: #DCFCE7; color: #166534; }
.status-badge.coming { background: #FEF3C7; color: #92400E; }
.status-badge.soldout, .status-badge.closed { background: #F1F5F9; color: #64748B; }

.ticket-date {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 14px;
}

.ticket-progress { margin-top: 14px; }
.ticket-progress .progress { height: 6px; border-radius: 99px; background: #E2E8F0; }
.ticket-progress .fill { background: var(--primary-color); border-radius: 99px; }

.ticket-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 18px;
    padding-top: 14px;
    border-top: 1px dashed var(--border-color);
}

.ticket-bottom .price { font-size: 22px; font-weight: 800; color: var(--text-dark); }
.ticket-bottom .price small { font-size: 14px; font-weight: 600; margin-right: 2px; }

/* BUTTON STYLES */
.btn-gradient {
    background: var(--primary-gradient) !important;
    color: #FFFFFF !important;
    border: none !important;
    box-shadow: 0 4px 14px rgba(3, 114, 205, 0.35);
    transition: all 0.3s ease !important;
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(3, 114, 205, 0.45);
    color: #FFFFFF !important;
}

.btn-outline-primary-custom {
    border: 1.5px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
    font-weight: 700;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
}

.btn-outline-primary-custom:hover {
    background: var(--primary-color) !important;
    color: #FFFFFF !important;
}

.btn-light-primary {
    background: var(--primary-light) !important;
    color: var(--primary-color) !important;
    border: none !important;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
}

.btn-light-primary:hover {
    background: var(--primary-color) !important;
    color: #FFFFFF !important;
}

.btn-ticket {
    padding: 10px 22px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
}

.btn-ticket.disabled { background: #E2E8F0 !important; color: #94A3B8 !important; cursor: not-allowed; box-shadow: none; }

/* ORGANIZER CARD SPECIFIC STYLES */
.organizer-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: 0 4px 18px -4px rgba(15, 23, 42, 0.04);
}

.organizer-section-title {
    font-size: 11px;
    font-weight: 800;
    color: #94A3B8;
    letter-spacing: 0.8px;
}

.fs-xs {
    font-size: 11px !important;
}

.organizer-profile-wrapper {
    display: flex;
    align-items: center;
    gap: 14px;
    width: 100%;
}

.avatar-container {
    position: relative;
    width: 52px;
    height: 52px;
    flex-shrink: 0;
}

.organizer-avatar-img {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    object-fit: cover;
    border: 2px solid #F8FAFC;
    box-shadow: 0 4px 10px rgba(3, 114, 205, 0.12);
}

.verify-badge-icon {
    position: absolute;
    bottom: -4px;
    right: -4px;
    color: rgb(3, 114, 205);
    background: #FFFFFF;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.organizer-text-info {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.organizer-title-text {
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.organizer-title-text a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.2s ease;
}

.organizer-title-text a:hover {
    color: rgb(3, 114, 205);
}

.organizer-handle-text {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    margin-top: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-sm-custom {
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 700;
    border-radius: var(--radius-sm);
}

.btn-icon-custom {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: var(--radius-sm);
}

/* REGISTER CARD */
.register-card { border: 1.5px solid var(--primary-light); background: #FFFFFF; }
.register-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 50px;
    border-radius: var(--radius-md);
    font-weight: 800;
    text-decoration: none;
    font-size: 15px;
}
.register-btn:hover { text-decoration: none; }
.register-btn-disabled { background: #E2E8F0; color: #94A3B8; cursor: not-allowed; }

/* MODAL CUSTOM CLOSE BUTTON */
.btn-close-custom {
    background: transparent;
    border: none;
    color: var(--text-muted);
    padding: 0;
    cursor: pointer;
    transition: color 0.2s;
}
.btn-close-custom:hover { color: var(--text-dark); }

/* PROMO & GUIDE CARDS */
.promo-card { background: linear-gradient(135deg, rgba(3, 114, 205, 0.05) 0%, #FFFFFF 100%); }
.promo-icon { font-size: 28px; }

.guide-list { list-style: none; display: flex; flex-direction: column; gap: 14px; }
.guide-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 13px; color: var(--text-muted); }
.guide-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
    margin-top: 2px;
}
.guide-icon.success { background: #DCFCE7; color: #166534; }
.guide-icon.primary { background: var(--primary-light); color: var(--primary-color); }
.guide-icon.warning { background: #FEF3C7; color: #92400E; }
.guide-icon.info { background: #E0F2FE; color: #0369A1; }

/* RECOMMENDED EVENTS CARD */
.modern-event-card {
    background: #FFF;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.2s ease;
}
.modern-event-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px -4px rgba(0,0,0,0.08); }

.event-card-img-wrapper { position: relative; }
.event-card-image { width: 100%; height: 180px; object-fit: cover; }
.event-card-category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(4px);
    color: var(--text-dark);
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
}

.event-card-body { padding: 16px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
.event-card-title { font-size: 15px; font-weight: 700; line-height: 1.4; margin-bottom: 12px; }
.event-card-title a { color: var(--text-dark); text-decoration: none; }
.event-card-title a:hover { color: var(--primary-color); }

.event-card-meta { font-size: 12px; color: var(--text-muted); display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
.event-card-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid var(--border-color); }
.event-card-footer .price { font-size: 14px; font-weight: 800; color: var(--primary-color); }

@media (max-width: 991px) {
    .sticky-sidebar { position: relative; top: 0; }
    .register-card {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        border-radius: 20px 20px 0 0;
        z-index: 999;
        margin-bottom: 0 !important;
        box-shadow: 0 -8px 24px rgba(0,0,0,0.15);
    }
    .event-meta-grid { grid-template-columns: 1fr; }
    .hero-image { height: 260px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Carousel Thumbnail Switcher
    document.querySelectorAll('.hero-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            document.querySelectorAll('.hero-thumb').forEach(function (item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Copy Event Link to Clipboard
    document.querySelectorAll('.copyButton').forEach(function(btn){
        btn.addEventListener('click', function(){
            navigator.clipboard.writeText(window.location.href).then(function(){
                if(typeof alertify !== 'undefined'){
                    alertify.success('Link berhasil disalin');
                }else{
                    alert('Link berhasil disalin');
                }
            });
        });
    });

    // Manual Tab Switcher Logic
    const ticketTab = document.getElementById('ticket-tab');
    const descriptionTab = document.getElementById('description-tab');

    const ticketContent = document.getElementById('ticket-content');
    const descriptionContent = document.getElementById('description-content');

    if(ticketTab && descriptionTab){
        ticketTab.addEventListener('click', function(e){
            e.preventDefault();
            ticketTab.classList.add('active');
            descriptionTab.classList.remove('active');

            ticketContent.style.display='block';
            descriptionContent.style.display='none';
        });

        descriptionTab.addEventListener('click', function(e){
            e.preventDefault();
            descriptionTab.classList.add('active');
            ticketTab.classList.remove('active');

            ticketContent.style.display='none';
            descriptionContent.style.display='block';
        });
    }

});
</script>

@endsection