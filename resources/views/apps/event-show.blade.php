@extends('layouts.app')

@section('title', $detailEvent->title.' - Eventverse.id')
@section('meta_description', Str::limit(strip_tags($detailEvent->description), 150))

@section('content')

<div class="py-4 lg:py-6 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-5 relative">

            {{-- ========================================================= --}}
            {{-- LEFT CONTENT --}}
            {{-- ========================================================= --}}
            <div class="lg:col-span-2 space-y-4">

                @php
                    if (blank($detailEvent->image)) {
                        $img = 'assets/default-img/event-images/def-no-img.png';
                    } else {
                        $bannerPath = 'storage/event-images/'.$detailEvent->image;
                        $img = file_exists(public_path($bannerPath))
                            ? $bannerPath
                            : 'assets/default-img/event-images/def-no-img.png';
                    }

                    $gallery = collect();
                    $gallery->push(['image' => asset($img), 'banner' => true]);

                    foreach ($detailEvent->images as $image) {
                        $galleryPath = 'storage/event-gallery/'.$image->image;
                        if (file_exists(public_path($galleryPath))) {
                            $gallery->push(['image' => asset($galleryPath), 'banner' => false]);
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
                        ? $ticketData->every(fn($ticket) => $ticket->ticket_price == 0)
                        : true;
                @endphp

                {{-- ===================== MAIN EVENT CARD ===================== --}}
                <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)] overflow-hidden">

                    {{-- HERO CAROUSEL --}}
                    <div id="eventHero" class="relative bg-[#0f172a] group">
                        <div class="overflow-hidden">
                            <div id="heroTrack" class="flex transition-transform duration-500 ease-in-out">
                                @foreach($gallery as $key => $photo)
                                    <div class="hero-slide min-w-full">
                                        <img src="{{ $photo['image'] }}"
                                             class="w-full h-[240px] sm:h-[300px] lg:h-[380px] object-cover"
                                             alt="{{ $detailEvent->title }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($gallery->count() > 1)
                            <button type="button" id="heroPrev" aria-label="Previous slide"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 hover:bg-white border border-[#e2e8f0] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                <i class="ti ti-chevron-left text-[#0f172a] text-lg"></i>
                            </button>
                            <button type="button" id="heroNext" aria-label="Next slide"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 hover:bg-white border border-[#e2e8f0] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                <i class="ti ti-chevron-right text-[#0f172a] text-lg"></i>
                            </button>
                        @endif
                    </div>

                    @if($gallery->count() > 1)
                        <div class="flex gap-2 px-4 py-3 bg-white border-b border-[#e2e8f0] overflow-x-auto">
                            @foreach($gallery as $key => $photo)
                                <button type="button"
                                        class="hero-thumb relative shrink-0 rounded-lg overflow-hidden p-0 bg-transparent border-0 cursor-pointer {{ $key == 0 ? 'active' : '' }}"
                                        data-slide-to="{{ $key }}">
                                    <img src="{{ $photo['image'] }}"
                                         alt="Thumbnail"
                                         class="w-20 h-14 object-cover rounded-lg border-2 {{ $key == 0 ? 'border-[#2282ff]' : 'border-transparent' }} transition-all duration-200">
                                    @if($photo['banner'])
                                        <span class="absolute bottom-1 left-1 bg-[#2282ff] text-white text-[9px] font-bold px-1.5 py-0.5 rounded">
                                            Banner
                                        </span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- EVENT CONTENT --}}
                    <div class="p-4 sm:p-6">

                        {{-- Badges --}}
                        <div class="flex flex-wrap gap-1.5 mb-3.5">
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-3 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff]">
                                <i class="ti ti-tag"></i> {{ $detailEvent->category->name }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-3 py-1.5 rounded-full bg-[#e0f2fe] text-[#0369a1]">
                                <i class="ti ti-map-pin"></i> {{ $detailEvent->location_jenis }}
                            </span>
                            @if($isFree)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-3 py-1.5 rounded-full bg-[#dcfce7] text-[#15803d]">
                                    <i class="ti ti-gift"></i> Gratis
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-3 py-1.5 rounded-full bg-[#fef3c7] text-[#b45309]">
                                    <i class="ti ti-ticket"></i> Mulai Rp {{ number_format($minPrice, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>

                        {{-- Title & Organizer --}}
                        <div class="mb-5">
                            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f172a] leading-snug mb-2">
                                {{ $detailEvent->title }}
                            </h1>
                            <a href="{{ $organizerUrl }}"
                               class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#64748b] hover:text-[#2282ff] transition-colors">
                                <i class="ti ti-circle-check-filled text-[#2282ff] text-base"></i>
                                <span>{{ $organizerName }}</span>
                            </a>
                        </div>

                        {{-- Meta Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 my-5">
                            <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-[#f8fafc] border border-[#e2e8f0]">
                                <div class="w-10 h-10 rounded-lg bg-[#2282ff]/10 text-[#2282ff] flex items-center justify-center text-lg shrink-0">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                                <div class="min-w-0">
                                    <small class="block text-[11px] text-[#64748b] mb-0.5">Tanggal & Waktu</small>
                                    <h6 class="text-[13px] font-bold text-[#0f172a] m-0 truncate">
                                        @if($detailEvent->start_date == $detailEvent->end_date)
                                            {{ date('d M Y', strtotime($detailEvent->start_date)) }}
                                        @else
                                            {{ date('d M Y', strtotime($detailEvent->start_date)) }} - {{ date('d M Y', strtotime($detailEvent->end_date)) }}
                                        @endif
                                    </h6>
                                </div>
                            </div>

                            <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-[#f8fafc] border border-[#e2e8f0]">
                                <div class="w-10 h-10 rounded-lg bg-[#2282ff]/10 text-[#2282ff] flex items-center justify-center text-lg shrink-0">
                                    <i class="ti ti-map-pin-filled"></i>
                                </div>
                                <div class="min-w-0">
                                    <small class="block text-[11px] text-[#64748b] mb-0.5">Lokasi Event</small>
                                    <h6 class="text-[13px] font-bold text-[#0f172a] m-0 leading-snug">
                                        @if(strtolower($detailEvent->location_jenis) == 'online')
                                            Online Event
                                        @else
                                            {{ $detailEvent->location_detail }}<br>
                                            <span class="text-[#64748b] font-normal">{{ $detailEvent->location_city }}, {{ $detailEvent->province->name }}</span>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>

                        {{-- Action Bar --}}
                        <div class="flex flex-wrap justify-between items-center gap-2 pt-4 border-t border-[#e2e8f0]">
                            <div class="text-xs text-[#64748b]">
                                <i class="ti ti-clock me-1"></i> Dipublikasikan {{ $detailEvent->created_at->diffForHumans() }}
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                        class="w-10 h-10 rounded-lg bg-[#f1f5f9] hover:bg-[#e2e8f0] text-[#0f172a] flex items-center justify-center text-base transition-colors"
                                        data-modal-target="shareQrModal" title="QR Code">
                                    <i class="ti ti-qrcode"></i>
                                </button>
                                <button type="button"
                                        class="copyButton w-10 h-10 rounded-lg bg-[#f1f5f9] hover:bg-[#e2e8f0] text-[#0f172a] flex items-center justify-center text-base transition-colors"
                                        title="Salin Link">
                                    <i class="ti ti-link"></i>
                                </button>
                                <button type="button"
                                        class="w-10 h-10 rounded-lg bg-[#ebf3ff] hover:bg-[#2282ff] text-[#2282ff] hover:text-white flex items-center justify-center text-base transition-colors"
                                        data-modal-target="shareModal" title="Bagikan">
                                    <i class="ti ti-share"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== TABS ===================== --}}
                <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)] p-4 sm:p-5">

                    <div class="bg-[#f1f5f9] p-1.5 rounded-xl">
                        <div class="flex gap-1.5">
                            <button id="description-tab" type="button"
                                    class="nav-link active flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold border-0 transition-all bg-white text-[#2282ff] shadow-[0_2px_6px_rgba(0,0,0,0.05)]">
                                <i class="ti ti-file-text text-lg"></i>
                                <span>Deskripsi</span>
                            </button>
                            <button id="ticket-tab" type="button"
                                    class="nav-link flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold border-0 bg-transparent text-[#64748b] hover:text-[#0f172a] transition-all">
                                <i class="ti ti-ticket text-lg"></i>
                                <span>Tiket</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div id="ticket-content" style="display:none;">
                            @include('apps.event-list-ticket')
                        </div>

                        <div id="description-content">
                            <div class="mb-3">
                                <h4 class="text-base font-bold text-[#0f172a] m-0">Tentang Event</h4>
                                <p class="text-[13px] text-[#64748b] mt-0.5">Informasi lengkap mengenai acara ini.</p>
                            </div>
                            <div class="event-description text-sm text-[#0f172a] leading-relaxed">
                                {!! $detailEvent->description !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- RIGHT SIDEBAR --}}
            {{-- ========================================================= --}}
            <div class="lg:col-span-1">
                <div class="sticky-sidebar space-y-4">

                    {{-- REGISTER CARD --}}
                    <div class="bg-white border-[1.5px] border-[#ebf3ff] rounded-xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                        <div class="p-4 sm:p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <small class="block text-[11px] font-semibold text-[#64748b]">Mulai Dari</small>
                                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#2282ff] m-0">
                                        @if($isFree)
                                            Gratis
                                        @else
                                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                                        @endif
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block bg-[#ebf3ff] text-[#2282ff] text-[11px] font-bold px-2.5 py-1.5 rounded-full">
                                        {{ $ticketData->count() }} Pilihan Tiket
                                    </span>
                                </div>
                            </div>

                            @php
                                $registrationClosed = false;
                                if (!blank($detailEvent->registration_end)) {
                                    $registrationClosed = now()->gt($detailEvent->registration_end);
                                }
                            @endphp

                            @if($registrationClosed)
                                <button class="bg-[#e2e8f0] text-[#94a3b8] cursor-not-allowed flex items-center justify-center gap-2 w-full h-12 rounded-xl font-bold text-sm" disabled>
                                    <i class="ti ti-lock text-lg"></i>
                                    <span>Pendaftaran Ditutup</span>
                                </button>
                            @else
                                <button type="button"
                                        class="flex items-center justify-center gap-2 w-full h-12 rounded-xl font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all"
                                        data-modal-target="ticketSelectModal">
                                    <span>Daftar Sekarang</span>
                                    <i class="ti ti-arrow-right text-lg"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- ORGANIZER CARD --}}
                    <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                        <div class="p-4 sm:p-5">
                            @php
                                if ($detailEvent->organizer == 'org') {
                                    $logo = $detailEvent->org->logo
                                        ? asset('storage/organization-logo/'.$detailEvent->org->logo)
                                        : asset('assets/default-img/org-images/default-user.jpg');
                                    $organizerName = $detailEvent->org->org_name;
                                    $organizerUsername = $detailEvent->org->username ? '@'.$detailEvent->org->username : 'Organisasi Terverifikasi';
                                    $organizerLink = url('/organisasi/'.$detailEvent->org->org_id);
                                    $typeLabel = 'Organisasi';
                                } else {
                                    $logo = $detailEvent->individual->profile_picture
                                        ? asset('storage/profile-images/'.$detailEvent->individual->profile_picture)
                                        : asset('assets/default-img/org-images/default-user.jpg');
                                    $organizerName = $detailEvent->individual->name;
                                    $organizerUsername = '@'.$detailEvent->individual->username;
                                    $organizerLink = url('/user/'.$detailEvent->individual->username);
                                    $typeLabel = 'Single';
                                }
                            @endphp

                            <div class="flex items-center justify-between mb-3.5">
                                <span class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8]">DISELENGGARAKAN OLEH</span>
                                <span class="bg-[#ebf3ff] text-[#2282ff] text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $typeLabel }}</span>
                            </div>

                            <div class="flex items-center gap-3.5 w-full">
                                <div class="relative shrink-0" style="width:48px;height:48px;">
                                    <img src="{{ $logo }}"
                                         class="rounded-xl object-cover border-2 border-[#f8fafc] shadow-[0_4px_10px_rgba(34,130,255,0.12)]"
                                         style="width:48px;height:48px;"
                                         alt="{{ $organizerName }}">
                                    <span class="absolute -bottom-0.5 -right-0.5 w-[18px] h-[18px] bg-white rounded-full flex items-center justify-center text-[#2282ff] text-base shadow-sm">
                                        <i class="ti ti-circle-check-filled"></i>
                                    </span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h6 class="text-sm font-bold text-[#0f172a] m-0 truncate leading-tight">
                                        <a href="{{ $organizerLink }}" class="text-[#0f172a] hover:text-[#2282ff] no-underline transition-colors">{{ $organizerName }}</a>
                                    </h6>
                                    <span class="block text-[11px] text-[#64748b] font-medium mt-0.5 truncate">{{ $organizerUsername }}</span>
                                </div>
                            </div>

                            <hr class="my-3.5 border-[#e2e8f0]">

                            <div class="flex gap-2">
                                <a href="{{ $organizerLink }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 text-xs font-bold rounded-lg border-[1.5px] border-[#2282ff] text-[#2282ff] bg-transparent hover:bg-[#2282ff] hover:text-white transition-all">
                                    <i class="ti ti-user text-base"></i>
                                    <span>Lihat Profil</span>
                                </a>
                                <a href="{{ $organizerLink }}"
                                   class="w-10 h-10 rounded-lg bg-[#ebf3ff] text-[#2282ff] hover:bg-[#2282ff] hover:text-white flex items-center justify-center text-base shrink-0 transition-all"
                                   title="Kunjungi Profil Penyelenggara">
                                    <i class="ti ti-external-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- PROMO CARD --}}
                    <div class="bg-gradient-to-br from-[#2282ff]/5 to-white border border-[#e2e8f0] rounded-xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                        <div class="p-4 sm:p-5 text-center">
                            <div class="text-3xl mb-2">
                                <i class="ti ti-rocket text-[#2282ff]"></i>
                            </div>
                            <h6 class="text-sm font-bold text-[#0f172a] mb-1">Ingin membuat event?</h6>
                            <p class="text-xs text-[#64748b] mb-3.5">Kelola pendaftaran, QR Check-in, sertifikat, & tiket dengan mudah.</p>
                            <a href="{{ url('/event/create') }}"
                               class="block w-full bg-[#ebf3ff] text-[#2282ff] hover:bg-[#2282ff] hover:text-white font-bold text-[13px] py-2.5 rounded-lg transition-all">
                                Buat Event Sekarang
                            </a>
                        </div>
                    </div>

                    {{-- GUIDE CARD --}}
                    <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)]">
                        <div class="p-4 sm:p-5">
                            <h6 class="text-sm font-bold text-[#0f172a] mb-3.5 flex items-center gap-2">
                                <i class="ti ti-info-circle text-[#2282ff] text-lg"></i> Panduan Peserta
                            </h6>
                            <ul class="list-none p-0 m-0 flex flex-col gap-3">
                                <li class="flex items-start gap-2.5 text-xs text-[#64748b]">
                                    <div class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#166534] flex items-center justify-center text-[10px] shrink-0 mt-0.5"><i class="ti ti-check"></i></div>
                                    <span>Pilih jenis tiket yang masih tersedia.</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-[#64748b]">
                                    <div class="w-5 h-5 rounded-full bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-[10px] shrink-0 mt-0.5"><i class="ti ti-credit-card"></i></div>
                                    <span>Selesaikan pembayaran sesuai metode pilihan.</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-[#64748b]">
                                    <div class="w-5 h-5 rounded-full bg-[#fef3c7] text-[#92400e] flex items-center justify-center text-[10px] shrink-0 mt-0.5"><i class="ti ti-mail"></i></div>
                                    <span>E-ticket dikirim otomatis via email & akun.</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-[#64748b]">
                                    <div class="w-5 h-5 rounded-full bg-[#e0f2fe] text-[#0369a1] flex items-center justify-center text-[10px] shrink-0 mt-0.5"><i class="ti ti-qrcode"></i></div>
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
        <div class="mt-6">
            <div class="mb-4">
                <h4 class="text-base sm:text-lg font-bold text-[#0f172a] m-0">
                    Event <span class="text-[#2282ff]">Lainnya</span> Untuk Anda
                </h4>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($recomendedEvents as $event)
                    @php
                        if (blank($event->image)) {
                            $eventImage = asset('assets/default-img/event-images/def-no-img.png');
                        } else {
                            $path = 'storage/event-images/'.$event->image;
                            $eventImage = file_exists(public_path($path))
                                ? asset($path)
                                : asset('assets/default-img/event-images/def-no-img.png');
                        }

                        $eventMinPrice = $event->tickets->min('ticket_price');
                        $eventFree = $event->tickets->count()
                            ? $event->tickets->every(fn($ticket) => $ticket->ticket_price == 0)
                            : true;
                    @endphp

                    <div class="group bg-white border border-[#e2e8f0] rounded-xl overflow-hidden h-full flex flex-col transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_20px_-4px_rgba(0,0,0,0.08)]">
                        <div class="relative overflow-hidden">
                            <a href="{{ url('/event/'.$event->slug) }}">
                                <img src="{{ $eventImage }}"
                                     class="w-full h-[160px] object-cover group-hover:scale-105 transition-transform duration-300"
                                     alt="{{ $event->title }}">
                            </a>
                            <span class="absolute top-2.5 left-2.5 bg-white/95 backdrop-blur text-[#0f172a] text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $event->category?->name }}
                            </span>
                        </div>

                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h5 class="text-sm font-bold leading-snug mb-2.5">
                                    <a href="{{ url('/event/'.$event->slug) }}"
                                       class="text-[#0f172a] hover:text-[#2282ff] no-underline transition-colors">
                                        {{ Str::limit($event->title, 55) }}
                                    </a>
                                </h5>

                                <div class="text-xs text-[#64748b] flex flex-col gap-1 mb-3">
                                    @php
                                        $date =  $event->start_date->format('d-m-Y') == $event->end_date->format('d-m-Y')
                                                            ? $event->end_date->format('d M Y')
                                                            : $event->start_date->format('d M Y') . ' - ' . $event->end_date->format('d M Y')
                                                        
                                    @endphp
                                    <div><i class="ti ti-calendar me-1"></i>{{ $date }}</div>
                                    <div><i class="ti ti-map-pin me-1"></i>{{ $event->location_jenis == 'Offline'
                                                            ? ucwords(strtolower($event->location_city))
                                                            : $event->location_jenis
                                                        }}</div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t border-[#e2e8f0]">
                                <div class="text-sm font-extrabold text-[#2282ff]">
                                    @if($eventFree)
                                        Gratis
                                    @else
                                        Mulai Rp {{ number_format($eventMinPrice, 0, ',', '.') }}
                                    @endif
                                </div>
                                <a href="{{ url('/event/'.$event->slug) }}"
                                   class="text-xs font-bold text-[#2282ff] border-[1.5px] border-[#2282ff] hover:bg-[#2282ff] hover:text-white px-3 py-1.5 rounded-full transition-all">
                                    Detail <i class="ti ti-chevron-right ms-0.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6 text-center text-[#64748b] text-sm">
                        Belum ada event lainnya saat ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>


{{-- ========================================================= --}}
{{-- MODAL: PILIH TIKET --}}
{{-- ========================================================= --}}
<div id="ticketSelectModal" class="fixed inset-0 z-[100] hidden" data-modal>
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close="ticketSelectModal"></div>

    <div class="relative flex items-center justify-center min-h-screen p-3 sm:p-4 pointer-events-none">
        <div class="pointer-events-auto bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden">

            <div class="px-5 pt-4 pb-3.5 border-b border-[#e2e8f0] flex justify-between items-start shrink-0">
                <div>
                    <h5 class="text-base font-bold text-[#0f172a] m-0">Pilih Tiket</h5>
                    <p class="text-[13px] text-[#64748b] mt-0.5 mb-0">Silakan pilih tiket yang tersedia untuk melanjutkan pendaftaran.</p>
                </div>
                <button type="button"
                        class="text-[#64748b] hover:text-[#0f172a] bg-transparent border-0 cursor-pointer p-1 transition-colors"
                        data-modal-close="ticketSelectModal"
                        aria-label="Close">
                    <i class="ti ti-x text-xl"></i>
                </button>
            </div>

            <div class="p-4 sm:p-5 overflow-y-auto">
                @include('apps.event-list-ticket')
            </div>

        </div>
    </div>
</div>


{{-- ========================================================= --}}
{{-- MODAL: QR CODE --}}
{{-- ========================================================= --}}
<div id="shareQrModal" class="fixed inset-0 z-[100] hidden" data-modal>
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close="shareQrModal"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
        <div class="pointer-events-auto bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden">

            <div class="px-4 py-3.5 flex justify-between items-center border-b border-[#e2e8f0]">
                <h5 class="text-sm font-bold text-[#0f172a] m-0">QR Code</h5>
                <button type="button"
                        class="text-[#64748b] hover:text-[#0f172a] bg-transparent border-0 cursor-pointer p-1 transition-colors"
                        data-modal-close="shareQrModal" aria-label="Close">
                    <i class="ti ti-x text-xl"></i>
                </button>
            </div>

            <div class="p-5 text-center">
                <div class="inline-block p-3 bg-white rounded-lg border border-[#e2e8f0]">
                    {!! $qrlink !!}
                </div>
                <div class="mt-3">
                    <a href="/{{ $detailEvent->slug }}" class="text-xs text-[#2282ff] hover:underline break-all">
                        eventverse.id/{{ $detailEvent->slug }}
                    </a>
                </div>
            </div>

            <div class="px-4 py-3 border-t border-[#e2e8f0] flex justify-end">
                <button type="button"
                        class="px-4 py-2 rounded-lg bg-[#f1f5f9] hover:bg-[#e2e8f0] text-[#0f172a] text-xs font-semibold transition-colors"
                        data-modal-close="shareQrModal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


{{-- ========================================================= --}}
{{-- MODAL: SHARE --}}
{{-- ========================================================= --}}
<div id="shareModal" class="fixed inset-0 z-[100] hidden" data-modal>
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close="shareModal"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
        <div class="pointer-events-auto bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">

            <div class="px-4 py-3.5 flex justify-between items-center border-b border-[#e2e8f0]">
                <h5 class="text-sm font-bold text-[#0f172a] m-0">Bagikan Event</h5>
                <button type="button"
                        class="text-[#64748b] hover:text-[#0f172a] bg-transparent border-0 cursor-pointer p-1 transition-colors"
                        data-modal-close="shareModal" aria-label="Close">
                    <i class="ti ti-x text-xl"></i>
                </button>
            </div>

            @php
                $shareUrl = url('/'.$detailEvent->slug);
                $shareText = urlencode($detailEvent->title);
            @endphp

            <div class="p-4">
                <div class="grid grid-cols-2 gap-2">
                    <a href="https://wa.me/?text={{ $shareText }}%20{{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 p-2.5 rounded-lg border border-[#e2e8f0] hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 transition-all">
                        <div class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-base">
                            <i class="ti ti-brand-whatsapp"></i>
                        </div>
                        <span class="text-xs font-semibold text-[#0f172a]">WhatsApp</span>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 p-2.5 rounded-lg border border-[#e2e8f0] hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 transition-all">
                        <div class="w-9 h-9 rounded-full bg-[#dbeafe] text-[#1877f2] flex items-center justify-center text-base">
                            <i class="ti ti-brand-facebook"></i>
                        </div>
                        <span class="text-xs font-semibold text-[#0f172a]">Facebook</span>
                    </a>

                    <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 p-2.5 rounded-lg border border-[#e2e8f0] hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 transition-all">
                        <div class="w-9 h-9 rounded-full bg-[#e0f2fe] text-[#0f172a] flex items-center justify-center text-base">
                            <i class="ti ti-brand-x"></i>
                        </div>
                        <span class="text-xs font-semibold text-[#0f172a]">X / Twitter</span>
                    </a>

                    <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ $shareText }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 p-2.5 rounded-lg border border-[#e2e8f0] hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 transition-all">
                        <div class="w-9 h-9 rounded-full bg-[#e0f2fe] text-[#0284c7] flex items-center justify-center text-base">
                            <i class="ti ti-brand-telegram"></i>
                        </div>
                        <span class="text-xs font-semibold text-[#0f172a]">Telegram</span>
                    </a>
                </div>

                <div class="mt-3.5 pt-3.5 border-t border-[#e2e8f0]">
                    <label class="block text-[11px] font-semibold text-[#64748b] mb-1.5">Link Event</label>
                    <div class="flex gap-2">
                        <input type="text" readonly value="{{ $shareUrl }}"
                               class="flex-1 px-3 py-2.5 text-xs text-[#0f172a] bg-[#f8fafc] border border-[#e2e8f0] rounded-lg outline-none"
                               id="shareUrlInput">
                        <button type="button"
                                class="copyButton px-3.5 py-2.5 rounded-lg bg-[#2282ff] hover:bg-[#1b6cd6] text-white text-xs font-semibold transition-colors shrink-0">
                            Copy
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<style>
    .sticky-sidebar {
        position: sticky;
        top: 84px;
        z-index: 10;
    }

    .event-description img { max-width: 100%; height: auto; border-radius: 10px; margin: 12px 0; }
    .event-description p { margin-bottom: 12px; }
    .event-description h1, .event-description h2, .event-description h3 {
        font-weight: 700; color: #0f172a; margin: 16px 0 8px;
    }
    .event-description ul { list-style: disc; padding-left: 20px; margin-bottom: 12px; }
    .event-description ol { list-style: decimal; padding-left: 20px; margin-bottom: 12px; }
    .event-description a { color: #2282ff; text-decoration: underline; }

    .hero-thumb.active img { border-color: #2282ff !important; }

    body.modal-open { overflow: hidden; }

    @media (max-width: 991px) {
        .sticky-sidebar { position: relative; top: 0; }
    }
</style>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============ MODAL SYSTEM ============ */
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        const anyOpen = document.querySelector('[data-modal]:not(.hidden)');
        if (!anyOpen) document.body.classList.remove('modal-open');
    }

    document.querySelectorAll('[data-modal-target]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            openModal(this.dataset.modalTarget);
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(function (el) {
        el.addEventListener('click', function () {
            closeModal(this.dataset.modalClose);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[data-modal]:not(.hidden)').forEach(function (m) {
                closeModal(m.id);
            });
        }
    });


    /* ============ HERO CAROUSEL ============ */
    const heroTrack = document.getElementById('heroTrack');
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroPrev = document.getElementById('heroPrev');
    const heroNext = document.getElementById('heroNext');
    const heroThumbs = document.querySelectorAll('.hero-thumb');

    if (heroTrack && heroSlides.length > 0) {
        let heroIndex = 0;

        function goToHero(index) {
            heroIndex = (index + heroSlides.length) % heroSlides.length;
            heroTrack.style.transform = `translateX(-${heroIndex * 100}%)`;

            heroThumbs.forEach(function (thumb, i) {
                const img = thumb.querySelector('img');
                if (i === heroIndex) {
                    thumb.classList.add('active');
                    if (img) { img.classList.add('border-[#2282ff]'); img.classList.remove('border-transparent'); }
                } else {
                    thumb.classList.remove('active');
                    if (img) { img.classList.remove('border-[#2282ff]'); img.classList.add('border-transparent'); }
                }
            });
        }

        heroNext?.addEventListener('click', function () { goToHero(heroIndex + 1); });
        heroPrev?.addEventListener('click', function () { goToHero(heroIndex - 1); });

        heroThumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                goToHero(Number(this.dataset.slideTo));
            });
        });

        let touchStartX = 0;
        heroTrack.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        heroTrack.addEventListener('touchend', function (e) {
            const dist = e.changedTouches[0].screenX - touchStartX;
            if (Math.abs(dist) > 50) {
                dist < 0 ? goToHero(heroIndex + 1) : goToHero(heroIndex - 1);
            }
        }, { passive: true });

        goToHero(0);
    }


    /* =========================================================
    COPY LINK — dengan Toastry
    ========================================================= */
    document.querySelectorAll('.copyButton').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const shareInput = document.getElementById('shareUrlInput');

            const text = shareInput && btn.closest('#shareModal')
                ? shareInput.value
                : window.location.href;

            copyToClipboard(text);
        });
    });

    async function copyToClipboard(text) {
        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
                toast.success('Link berhasil disalin');
                return true;
            }

            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';

            document.body.appendChild(textarea);
            textarea.select();

            const success = document.execCommand('copy');

            textarea.remove();

            if (!success) {
                throw new Error('Copy failed');
            }

            toast.success('Link berhasil disalin');
            return true;

        } catch (error) {
            console.error('Copy error:', error);
            toast.error('Gagal menyalin link');
            return false;
        }
    }

    /* ============ TAB SWITCHER ============ */
    const ticketTab = document.getElementById('ticket-tab');
    const descriptionTab = document.getElementById('description-tab');
    const ticketContent = document.getElementById('ticket-content');
    const descriptionContent = document.getElementById('description-content');

    const activeTabClass = ['bg-white', 'text-[#2282ff]', 'shadow-[0_2px_6px_rgba(0,0,0,0.05)]'];
    const inactiveTabClass = ['bg-transparent', 'text-[#64748b]', 'hover:text-[#0f172a]'];

    function activateTab(tab) {
        if (tab === 'ticket') {
            ticketTab.classList.add(...activeTabClass);
            ticketTab.classList.remove(...inactiveTabClass);
            descriptionTab.classList.remove(...activeTabClass);
            descriptionTab.classList.add(...inactiveTabClass);
            ticketContent.style.display = 'block';
            descriptionContent.style.display = 'none';
        } else {
            descriptionTab.classList.add(...activeTabClass);
            descriptionTab.classList.remove(...inactiveTabClass);
            ticketTab.classList.remove(...activeTabClass);
            ticketTab.classList.add(...inactiveTabClass);
            ticketContent.style.display = 'none';
            descriptionContent.style.display = 'block';
        }
    }

    if (ticketTab && descriptionTab) {
        ticketTab.addEventListener('click', function (e) { e.preventDefault(); activateTab('ticket'); });
        descriptionTab.addEventListener('click', function (e) { e.preventDefault(); activateTab('description'); });
    }


    /* ============ QTY +/- ============ */
    document.addEventListener('click', function (e) {
        const plusBtn = e.target.closest('.qty-plus-btn');
        if (plusBtn) {
            const container = plusBtn.closest('.ticket-qty');
            const inputField = container ? container.querySelector('.qty-input-field') : null;
            if (inputField) inputField.value = (parseInt(inputField.value) || 0) + 1;
        }
    });

    document.addEventListener('click', function (e) {
        const minusBtn = e.target.closest('.qty-minus-btn');
        if (minusBtn) {
            const container = minusBtn.closest('.ticket-qty');
            const inputField = container ? container.querySelector('.qty-input-field') : null;
            if (inputField) {
                const val = parseInt(inputField.value) || 1;
                if (val > 1) inputField.value = val - 1;
            }
        }
    });


    /* ============ SUBMIT RESERVASI ============ */
    document.addEventListener('click', async function (e) {
        const ticketBtn = e.target.closest('.ticket-button');
        if (!ticketBtn) return;

        const ticketCard = ticketBtn.closest('.ticket-card');
        const inputField = ticketCard.querySelector('.qty-input-field');

        const ticketId = ticketBtn.dataset.id;
        const eventId = ticketBtn.dataset.event_id;
        const quantity = parseInt(inputField.value);

        const notify = (msg, type = 'error') => {
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon: type, title: msg });
            } else {
                alert(msg);
            }
        };

        if (isNaN(quantity) || quantity < 1) {
            notify('Jumlah tiket minimal 1.');
            inputField.value = 1;
            return;
        }

        const originalButton = ticketBtn.innerHTML;
        ticketBtn.disabled = true;
        ticketBtn.innerHTML = `
            <span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2 align-middle"></span>
            Checking...
        `;

        try {
            const response = await fetch("{{ route('reservation.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    event_id: eventId,
                    ticket_id: ticketId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                const msg = data.message
                    || (data.errors && data.errors[Object.keys(data.errors)[0]]?.[0])
                    || 'Terjadi kesalahan.';
                notify(msg);
                ticketBtn.disabled = false;
                ticketBtn.innerHTML = originalButton;
                return;
            }

            window.location.href = data.redirect_url;

        } catch (err) {
            notify('Terjadi kesalahan pada server.');
            ticketBtn.disabled = false;
            ticketBtn.innerHTML = originalButton;
        }
    });

});
</script>
@endpush