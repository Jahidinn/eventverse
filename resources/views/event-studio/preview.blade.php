@extends('event-studio.layouts.studio')

@section('content')

<div class="ev-summary">

    {{-- Hero --}}

    <section class="ev-hero">

        <div class="ev-hero-left">

            <span class="ev-status">

                <i class="fa-regular fa-circle-check"></i>

                Draft Event

            </span>

            <h1>

                Event Summary

            </h1>

            <p>

                Review all event information before publishing.
                Make sure every section is complete before your event goes live.

            </p>

            <div class="ev-hero-meta">

                <span>

                    <i class="fa-solid fa-ticket"></i>

                    {{ $event->tickets->count() }} Tickets

                </span>

                <span>

                    <i class="fa-solid fa-list-check"></i>

                    {{ $forms->count() }} Registration Fields

                </span>

                <span>

                    <i class="fa-solid fa-image"></i>

                    {{ $event->images->count() }} Gallery

                </span>

            </div>

        </div>

        <div class="ev-hero-right">

            <a href="#" target="_blank" class="ev-btn ev-btn-primary">

                <i class="fa-regular fa-eye"></i>

                Open Live Preview

            </a>

        </div>

    </section>

    {{-- Banner --}}

    <section class="ev-section">

        <div class="ev-section-header">

            <div>

                <h3>

                    Banner

                </h3>

                <p>

                    This image will become the main cover shown to participants.

                </p>

            </div>

        </div>

        <div class="ev-banner">

            @if($event->image)

                <img
                    src="{{ asset('storage/event-images/'.$event->image) }}"
                    alt="{{ $event->title }}">

            @else

                <div class="ev-empty">

                    <i class="fa-regular fa-image"></i>

                    <h4>

                        No Banner Uploaded

                    </h4>

                    <p>

                        Upload a banner from the Basic Information page.

                    </p>

                </div>

            @endif

        </div>

    </section>

    {{-- Gallery --}}

    <section class="ev-section">

        <div class="ev-section-header">

            <div>

                <h3>
                    Gallery
                </h3>

                <p>
                    Additional images displayed on the event page.
                </p>

            </div>

            <span class="ev-counter">

                {{ $event->images->count() }} Image{{ $event->images->count() > 1 ? 's' : '' }}

            </span>

        </div>

        <div class="ev-section-body">

            @if($event->images->count())

                <div class="ev-gallery-grid">

                    @foreach($event->images as $image)

                        <div class="ev-gallery-item">

                            <img
                                src="{{ asset('storage/event-gallery/'.$image->image) }}"
                                alt="Gallery">

                        </div>

                    @endforeach

                </div>

            @else

                <div class="ev-empty">

                    <i class="fa-regular fa-images"></i>

                    <h4>

                        No Gallery Images

                    </h4>

                    <p>

                        Upload gallery images to make your event page more attractive.

                    </p>

                </div>

            @endif

        </div>

    </section>


    {{-- Grid --}}

    <div class="ev-grid">

        <div class="ev-left">

            {{-- Basic Information --}}

            <section class="ev-section">

                <div class="ev-section-header">

                    <div>

                        <h3>

                            Basic Information

                        </h3>

                        <p>

                            General information displayed to visitors.

                        </p>

                    </div>

                </div>

                <div class="ev-section-body">

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Event Name

                        </div>

                        <div class="ev-value">

                            {{ $event->title }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Event URL

                        </div>

                        <div class="ev-value">

                            {{ url($event->slug) }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Category

                        </div>

                        <div class="ev-value">

                            {{ $event->category->name }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Organizer

                        </div>

                        <div class="ev-value">

                            {{ ucfirst($event->organizer) }}

                        </div>

                    </div>

                </div>

            </section>

            {{-- Event Detail --}}

            <section class="ev-section">

                <div class="ev-section-header">

                    <div>

                        <h3>

                            Event Detail

                        </h3>

                        <p>

                            Date, location and event schedule.

                        </p>

                    </div>

                </div>

                <div class="ev-section-body">

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Start Date

                        </div>

                        <div class="ev-value">

                            {{ $event->start_date ?: '-' }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            End Date

                        </div>

                        <div class="ev-value">

                            {{ $event->end_date ?: '-' }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Event Type

                        </div>

                        <div class="ev-value">

                            {{ ucfirst($event->location_jenis) }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Location

                        </div>

                        <div class="ev-value">

                            @if($event->location_jenis=='online')

                                {{ $event->location_online ?: '-' }}

                            @else

                                {{ $event->location_detail ?: '-' }}

                            @endif

                        </div>

                    </div>

                </div>

            </section>            {{-- Tickets --}}

            <section class="ev-section">

                <div class="ev-section-header">

                    <div>

                        <h3>

                            Tickets

                        </h3>

                        <p>

                            Review all ticket categories available for participants.

                        </p>

                    </div>

                    <span class="ev-counter">

                        {{ $event->tickets->count() }} Ticket{{ $event->tickets->count() > 1 ? 's' : '' }}

                    </span>

                </div>

                <div class="ev-section-body">

                    @forelse($event->tickets as $ticket)

                        <div class="ev-ticket">

                            <div class="ev-ticket-top">

                                <div>

                                    <h4>

                                        {{ $ticket->ticket_name }}

                                    </h4>

                                    @if($ticket->ticket_description)

                                        <p>

                                            {{ $ticket->ticket_description }}

                                        </p>

                                    @endif

                                </div>

                                <div class="ev-ticket-price">

                                    @if($ticket->ticket_price > 0)

                                        Rp {{ number_format($ticket->ticket_price,0,',','.') }}

                                    @else

                                        FREE

                                    @endif

                                </div>

                            </div>

                            <div class="ev-ticket-footer">

                                <div>

                                    <span>

                                        <i class="fa-solid fa-users"></i>

                                        {{ $ticket->ticket_quota }} Seats

                                    </span>

                                </div>

                                <div>

                                    <span>

                                        <i class="fa-regular fa-calendar"></i>

                                        {{ \Carbon\Carbon::parse($ticket->ticket_start)->format('d M Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($ticket->ticket_end)->format('d M Y') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="ev-empty">

                            <i class="fa-solid fa-ticket"></i>

                            <h4>

                                No Ticket Available

                            </h4>

                            <p>

                                Create your first ticket before publishing the event.

                            </p>

                        </div>

                    @endforelse

                </div>

            </section>

            {{-- Registration Form --}}

            <section class="ev-section">

                <div class="ev-section-header">

                    <div>

                        <h3>

                            Registration Form

                        </h3>

                        <p>

                            Fields that participants must complete.

                        </p>

                    </div>

                    <span class="ev-counter">

                        {{ $forms->count() }} Field{{ $forms->count() > 1 ? 's' : '' }}

                    </span>

                </div>

                <div class="ev-section-body">

                    @forelse($forms as $form)

                        <div class="ev-form-item">

                            <div class="ev-form-left">

                                <div class="ev-form-icon">

                                    @switch($form->field_type)

                                        @case('text')
                                            <i class="fa-solid fa-font"></i>
                                        @break

                                        @case('textarea')
                                            <i class="fa-solid fa-align-left"></i>
                                        @break

                                        @case('email')
                                            <i class="fa-solid fa-envelope"></i>
                                        @break

                                        @case('phone')
                                            <i class="fa-solid fa-phone"></i>
                                        @break

                                        @case('number')
                                            <i class="fa-solid fa-hashtag"></i>
                                        @break

                                        @case('select')
                                            <i class="fa-solid fa-chevron-down"></i>
                                        @break

                                        @case('radio')
                                            <i class="fa-regular fa-circle-dot"></i>
                                        @break

                                        @case('checkbox')
                                            <i class="fa-regular fa-square-check"></i>
                                        @break

                                        @case('file')
                                            <i class="fa-solid fa-paperclip"></i>
                                        @break

                                        @case('image')
                                            <i class="fa-regular fa-image"></i>
                                        @break

                                        @default
                                            <i class="fa-solid fa-circle"></i>

                                    @endswitch

                                </div>

                                <div>

                                    <h4>

                                        {{ $form->field_label }}

                                    </h4>

                                    <small>

                                        {{ $form->field_help ?: 'No description available.' }}

                                    </small>

                                </div>

                            </div>

                            <div class="ev-form-right">

                                <span class="ev-type">

                                    {{ strtoupper($form->field_type) }}

                                </span>

                                @if($form->field_required)

                                    <span class="ev-required">

                                        Required

                                    </span>

                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="ev-empty">

                            <i class="fa-solid fa-list-check"></i>

                            <h4>

                                Registration Form Empty

                            </h4>

                            <p>

                                Add custom fields before publishing.

                            </p>

                        </div>

                    @endforelse

                </div>

            </section>

        </div>

        {{-- Sidebar --}}

        @php

        $basicComplete =
            !empty($event->title) &&
            !empty($event->slug) &&
            !empty($event->category) &&
            !empty($event->organizer);

        $detailComplete =
            !empty($event->start_date) &&
            !empty($event->end_date) &&
            !empty($event->location_jenis) &&
            (
                ($event->location_jenis == 'online' && !empty($event->location_online))
                ||
                ($event->location_jenis != 'online' && !empty($event->location_detail))
            );

        $bannerComplete = !empty($event->image);

        $galleryComplete = $event->images->count() > 0;

        $ticketComplete = $event->tickets->count() > 0;

        $formComplete = $forms->count() > 0;

        $completed = collect([
            $basicComplete,
            $detailComplete,
            $bannerComplete,
            $galleryComplete,
            $ticketComplete,
            $formComplete
        ])->filter()->count();

        $total = 6;

        $progress = round(($completed / $total) * 100);

        @endphp

        <aside class="ev-right">

            <div class="ev-checklist">

                <div class="ev-check-header">

                    <h3>
                        Publish Readiness
                    </h3>

                    <p>
                        {{ $completed }} of {{ $total }} requirements completed
                    </p>

                    <div class="ev-progress">

                        <div
                            class="ev-progress-bar"
                            style="width: {{ $progress }}%">
                        </div>

                    </div>

                    <div class="ev-progress-text">

                        {{ $progress }}% Ready

                    </div>

                </div>

                <div class="ev-check-body">

                    @foreach([
                        ['Basic Information', $basicComplete],
                        ['Event Detail', $detailComplete],
                        ['Banner', $bannerComplete],
                        ['Gallery', $galleryComplete],
                        ['Ticket', $ticketComplete],
                        ['Registration Form', $formComplete],
                    ] as [$title,$status])

                        <div class="ev-check-item">

                            <span>{{ $title }}</span>

                            @if($status)

                                <i class="fa-solid fa-circle-check ev-success"></i>

                            @else

                                <i class="fa-solid fa-circle-exclamation ev-warning"></i>

                            @endif

                        </div>

                    @endforeach

                </div>

                <div class="ev-check-footer">

                    <a
                        href="#"
                        class="ev-btn ev-btn-outline ev-btn-full">

                        <i class="fa-regular fa-eye"></i>

                        Open Live Preview

                    </a>

                    {{-- <button
                        class="ev-btn ev-btn-primary ev-btn-full mt-3"
                        {{ $progress < 100 ? 'disabled' : '' }}>

                        <i class="fa-solid fa-paper-plane"></i>

                        Publish Event

                    </button> --}}
                    <button
    type="button"
    id="openPublishModal"
    class="ev-btn ev-btn-primary ev-btn-full"
    {{ $progress < 100 ? 'disabled' : '' }}>

    <i class="fa-solid fa-paper-plane"></i>

    Publish Event

</button>

                    @if($progress < 100)

                        <small class="ev-hint">

                            Complete all requirements before publishing.

                        </small>

                    @endif

                </div>

            </div>

        </aside>

    </div>

</div>
<div class="ev-modal-backdrop" id="publishModal">

    <div class="ev-modal ev-modal-sm">

        <div class="ev-modal-header">

            <div>

                <h3>
                    Publish Event
                </h3>

                <p>
                    Your event is ready to go live.
                </p>

            </div>

            <button
                type="button"
                class="ev-modal-close"
                id="closePublishModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form
            id="publishForm">

            @csrf

            <div class="ev-publish-hero">

                <div class="ev-publish-icon">

                    <i class="fa-solid fa-paper-plane"></i>

                </div>

                <h2>

                    Publish this event?

                </h2>

                <p>

                    Your event will be live and available for participants immediately.

                </p>

            </div>

            <div class="ev-status-preview">

                <span class="ev-status-badge ev-status-draft">

                    Draft

                </span>

                <i class="fa-solid fa-arrow-right-long"></i>

                <span class="ev-status-badge ev-status-published">

                    Published

                </span>

            </div>

            <div class="ev-modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    id="cancelPublish">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="publishSubmit">

                    <i class="fa-solid fa-paper-plane"></i>

                    Publish Event

                </button>

            </div>

        </form>

    </div>

</div>

<style>
    /* ==========================================================
   EVENT SUMMARY
========================================================== */

.ev-summary{

    max-width:1500px;

    margin:auto;

    padding:32px;

}


/* ==========================================================
   HERO
========================================================== */

.ev-hero{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:40px;

    padding:42px;

    border-radius:24px;

    background:
    linear-gradient(
        135deg,
        #2563EB,
        #3B82F6
    );

    color:#fff;

    margin-bottom:28px;

    overflow:hidden;

    position:relative;

}

.ev-hero::before{

    content:"";

    position:absolute;

    width:420px;

    height:420px;

    border-radius:100%;

    background:rgba(255,255,255,.08);

    right:-120px;

    top:-150px;

}

.ev-hero::after{

    content:"";

    position:absolute;

    width:260px;

    height:260px;

    border-radius:100%;

    background:rgba(255,255,255,.05);

    bottom:-120px;

    left:-80px;

}

.ev-hero-left{

    position:relative;

    z-index:2;

    flex:1;

}

.ev-hero-right{

    position:relative;

    z-index:2;

}

.ev-status{

    display:inline-flex;

    align-items:center;

    gap:8px;

    background:rgba(255,255,255,.15);

    backdrop-filter:blur(10px);

    padding:9px 16px;

    border-radius:999px;

    font-size:13px;

    font-weight:600;

    margin-bottom:22px;

}

.ev-status i{

    color:#FACC15;

}

.ev-hero h1{

    font-size:38px;

    line-height:1.2;

    margin:0;

    font-weight:700;

}

.ev-hero p{

    margin-top:18px;

    font-size:15px;

    line-height:1.8;

    color:rgba(255,255,255,.88);

    max-width:700px;

}

.ev-hero-meta{

    display:flex;

    gap:14px;

    flex-wrap:wrap;

    margin-top:28px;

}

.ev-hero-meta span{

    display:flex;

    align-items:center;

    gap:8px;

    padding:10px 18px;

    border-radius:999px;

    background:rgba(255,255,255,.12);

    font-size:13px;

    font-weight:600;

}

.ev-hero-meta i{

    opacity:.9;

}


/* ==========================================================
   BUTTON
========================================================== */

.ev-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    padding:14px 22px;

    border-radius:14px;

    text-decoration:none;

    transition:.25s;

    font-weight:600;

    font-size:14px;

    cursor:pointer;

}

.ev-btn-primary{

    background:#fff;

    color:#2563EB;

}

.ev-btn-primary:hover{

    transform:translateY(-2px);

    color:#2563EB;

    box-shadow:
        0 18px 40px rgba(0,0,0,.12);

}

.ev-btn-full{

    width:100%;

}


/* ==========================================================
   GRID
========================================================== */

.ev-grid{

    display:grid;

    grid-template-columns:
        minmax(0,1fr)
        360px;

    gap:28px;

    align-items:start;

}

.ev-left{

    display:flex;

    flex-direction:column;

    gap:28px;

}

.ev-right{

    position:sticky;

    top:95px;

}


/* ==========================================================
   SECTION
========================================================== */

.ev-section{

    background:#fff;

    border:1px solid #E7EDF5;

    border-radius:22px;

    overflow:hidden;

    transition:.25s;

}

.ev-section:hover{

    border-color:#D7E2F1;

}

.ev-section-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:20px;

    padding:26px 30px;

    border-bottom:1px solid #EEF2F6;

}

.ev-section-header h3{

    margin:0;

    font-size:19px;

    font-weight:700;

    color:#111827;

}

.ev-section-header p{

    margin-top:7px;

    color:#6B7280;

    font-size:14px;

}

.ev-section-body{

    padding:30px;

}


/* ==========================================================
   COUNTER
========================================================== */

.ev-counter{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 16px;

    border-radius:999px;

    background:#EEF4FF;

    color:#2563EB;

    font-size:13px;

    font-weight:700;

}


/* ==========================================================
   BANNER
========================================================== */

.ev-banner{

    padding:30px;

}

.ev-banner img{

    width:100%;

    display:block;

    border-radius:18px;

    aspect-ratio:16/6;

    object-fit:cover;

    border:1px solid #EEF2F6;

}

/* ==========================================================
   INFORMATION ROW
========================================================== */

.ev-info-row{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:40px;

    padding:18px 0;

    border-bottom:1px solid #F3F5F8;

}

.ev-info-row:last-child{

    border-bottom:none;

    padding-bottom:0;

}

.ev-info-row:first-child{

    padding-top:0;

}

.ev-label{

    width:220px;

    flex-shrink:0;

    color:#6B7280;

    font-size:14px;

    font-weight:600;

}

.ev-value{

    flex:1;

    text-align:right;

    color:#111827;

    font-size:15px;

    font-weight:600;

    word-break:break-word;

}



/* ==========================================================
   TICKET
========================================================== */

.ev-ticket{

    border:1px solid #E9EEF5;

    border-radius:18px;

    padding:22px;

    transition:.25s;

    margin-bottom:18px;

    background:#fff;

}

.ev-ticket:last-child{

    margin-bottom:0;

}

.ev-ticket:hover{

    border-color:#3B82F6;

    transform:translateY(-2px);

    box-shadow:

        0 15px 35px rgba(37,99,235,.08);

}

.ev-ticket-top{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:24px;

}

.ev-ticket-top h4{

    margin:0;

    font-size:18px;

    font-weight:700;

    color:#111827;

}

.ev-ticket-top p{

    margin-top:8px;

    color:#6B7280;

    line-height:1.6;

    font-size:14px;

}

.ev-ticket-price{

    font-size:28px;

    font-weight:700;

    color:#2563EB;

    white-space:nowrap;

}

.ev-ticket-footer{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-top:22px;

    padding-top:18px;

    border-top:1px solid #F2F4F7;

    color:#64748B;

    font-size:14px;

}

.ev-ticket-footer span{

    display:flex;

    align-items:center;

    gap:8px;

}

.ev-ticket-footer i{

    color:#94A3B8;

}



/* ==========================================================
   FORM
========================================================== */

.ev-form-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:25px;

    padding:18px 0;

    border-bottom:1px solid #F3F5F8;

}

.ev-form-item:last-child{

    border-bottom:none;

    padding-bottom:0;

}

.ev-form-item:first-child{

    padding-top:0;

}

.ev-form-left{

    display:flex;

    align-items:center;

    gap:18px;

    flex:1;

}

.ev-form-icon{

    width:52px;

    height:52px;

    border-radius:16px;

    background:#EEF4FF;

    color:#2563EB;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

    flex-shrink:0;

}

.ev-form-left h4{

    margin:0;

    font-size:16px;

    font-weight:700;

    color:#111827;

}

.ev-form-left small{

    display:block;

    margin-top:6px;

    color:#6B7280;

    line-height:1.5;

    font-size:13px;

}

.ev-form-right{

    display:flex;

    align-items:center;

    gap:10px;

    flex-wrap:wrap;

}



/* ==========================================================
   BADGE
========================================================== */

.ev-type{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    height:34px;

    padding:0 14px;

    border-radius:999px;

    background:#EEF4FF;

    color:#2563EB;

    font-size:12px;

    font-weight:700;

    letter-spacing:.4px;

}

.ev-required{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    height:34px;

    padding:0 14px;

    border-radius:999px;

    background:#DCFCE7;

    color:#15803D;

    font-size:12px;

    font-weight:700;

}



/* ==========================================================
   EMPTY STATE
========================================================== */

.ev-empty{

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    text-align:center;

    padding:60px 20px;

}

.ev-empty i{

    width:72px;

    height:72px;

    border-radius:20px;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#F8FAFC;

    color:#94A3B8;

    font-size:28px;

}

.ev-empty h4{

    margin-top:22px;

    margin-bottom:8px;

    font-size:20px;

    font-weight:700;

    color:#111827;

}

.ev-empty p{

    max-width:420px;

    margin:0;

    color:#6B7280;

    line-height:1.7;

}

/* ==========================================================
   CHECKLIST
========================================================== */

.ev-checklist{

    position:sticky;

    top:90px;

    background:#fff;

    border:1px solid #E7EDF5;

    border-radius:22px;

    overflow:hidden;

}

.ev-check-header{

    padding:28px;

    border-bottom:1px solid #EEF2F6;

}

.ev-check-header h3{

    margin:0;

    font-size:20px;

    font-weight:700;

    color:#111827;

}

.ev-check-header p{

    margin-top:10px;

    color:#6B7280;

    line-height:1.7;

    font-size:14px;

}

.ev-check-body{

    padding:10px 28px;

}

.ev-check-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:18px 0;

    border-bottom:1px solid #F3F5F8;

    font-size:15px;

    font-weight:600;

    color:#111827;

}

.ev-check-item:last-child{

    border-bottom:none;

}

.ev-success{

    color:#10B981;

    font-size:18px;

}

.ev-warning{

    color:#F59E0B;

    font-size:18px;

}

.ev-check-footer{

    padding:28px;

    border-top:1px solid #EEF2F6;

}



/* ==========================================================
   SCROLLBAR
========================================================== */

::-webkit-scrollbar{

    width:10px;

    height:10px;

}

::-webkit-scrollbar-track{

    background:#F8FAFC;

}

::-webkit-scrollbar-thumb{

    background:#CBD5E1;

    border-radius:999px;

}

::-webkit-scrollbar-thumb:hover{

    background:#94A3B8;

}



/* ==========================================================
   TRANSITION
========================================================== */

.ev-section,
.ev-ticket,
.ev-btn,
.ev-checklist,
.ev-form-item{

    transition:

        .25s ease;

}

.ev-ticket:hover .ev-ticket-price{

    color:#1D4ED8;

}

.ev-form-item:hover{

    padding-left:8px;

}

.ev-form-item:hover .ev-form-icon{

    transform:scale(1.05);

}

.ev-form-icon{

    transition:.25s;

}



/* ==========================================================
   FOCUS
========================================================== */

.ev-btn:focus{

    outline:none;

    box-shadow:

        0 0 0 4px rgba(37,99,235,.15);

}



/* ==========================================================
   TEXT
========================================================== */

.ev-summary *{

    box-sizing:border-box;

}

.ev-summary{

    color:#111827;

}

.ev-summary a{

    text-decoration:none;

}

.ev-summary img{

    max-width:100%;

    display:block;

}



/* ==========================================================
   MOBILE
========================================================== */

@media(max-width:1200px){

    .ev-grid{

        grid-template-columns:1fr;

    }

    .ev-right{

        position:relative;

        top:auto;

    }

}

@media(max-width:768px){

    .ev-summary{

        padding:18px;

    }

    .ev-hero{

        flex-direction:column;

        padding:30px;

    }

    .ev-hero h1{

        font-size:30px;

    }

    .ev-hero-meta{

        flex-direction:column;

        align-items:flex-start;

    }

    .ev-section-header{

        flex-direction:column;

        gap:18px;

    }

    .ev-ticket-top{

        flex-direction:column;

    }

    .ev-ticket-price{

        font-size:24px;

    }

    .ev-ticket-footer{

        flex-direction:column;

        align-items:flex-start;

        gap:12px;

    }

    .ev-form-item{

        flex-direction:column;

        align-items:flex-start;

    }

    .ev-form-right{

        width:100%;

    }

    .ev-info-row{

        flex-direction:column;

        gap:8px;

    }

    .ev-label{

        width:100%;

    }

    .ev-value{

        text-align:left;

    }

}

@media(max-width:576px){

    .ev-hero{

        border-radius:18px;

    }

    .ev-section{

        border-radius:18px;

    }

    .ev-checklist{

        border-radius:18px;

    }

    .ev-banner{

        padding:18px;

    }

    .ev-section-body{

        padding:22px;

    }

    .ev-section-header{

        padding:22px;

    }

}



/* ==========================================================
   OPTIONAL ANIMATION
========================================================== */

@keyframes fadeUp{

    from{

        opacity:0;

        transform:translateY(12px);

    }

    to{

        opacity:1;

        transform:none;

    }

}

.ev-section{

    animation:fadeUp .45s ease both;

}

.ev-section:nth-child(2){

    animation-delay:.05s;

}

.ev-section:nth-child(3){

    animation-delay:.1s;

}

.ev-section:nth-child(4){

    animation-delay:.15s;

}

.ev-checklist{

    animation:fadeUp .5s ease;

}

.ev-progress{

    width:100%;

    height:10px;

    background:#EEF2F7;

    border-radius:999px;

    overflow:hidden;

    margin-top:18px;

}

.ev-progress-bar{

    height:100%;

    border-radius:999px;

    background:linear-gradient(90deg,#2563EB,#60A5FA);

    transition:.4s;

}

.ev-progress-text{

    margin-top:10px;

    font-size:13px;

    font-weight:700;

    color:#2563EB;

}

.ev-btn-outline{

    background:#fff;

    border:1px solid #D8E0EA;

    color:#374151;

}

.ev-btn-outline:hover{

    background:#F8FAFC;

}

.ev-btn:disabled{

    opacity:.5;

    cursor:not-allowed;

    transform:none;

    box-shadow:none;

}

.ev-hint{

    display:block;

    margin-top:14px;

    text-align:center;

    color:#EF4444;

    line-height:1.6;

    font-size:13px;

}

/* ==========================================================
   GALLERY
========================================================== */

.ev-gallery-grid{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));

    gap:18px;

}

.ev-gallery-item{

    aspect-ratio:1;

    overflow:hidden;

    border-radius:16px;

    border:1px solid #E7EDF5;

    background:#F8FAFC;

    transition:.25s;

}

.ev-gallery-item:hover{

    transform:translateY(-3px);

    box-shadow:0 12px 30px rgba(0,0,0,.08);

}

.ev-gallery-item img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.35s;

}

.ev-gallery-item:hover img{

    transform:scale(1.05);

}


.ev-modal-sm{
    max-width:620px;
}

.ev-publish-hero{
    padding:20px 20px 28px;
    text-align:center;
}

.ev-publish-icon{
    width:72px;
    height:72px;
    margin:0 auto 20px;
    border-radius:20px;
    background:linear-gradient(135deg,#EEF4FF,#DCE8FF);
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--primary);
    font-size:28px;
}

.ev-publish-hero h2{
    font-size:24px;
    margin-bottom:10px;
    color:var(--heading-color);
}

.ev-publish-hero p{
    max-width:340px;
    margin:auto;
    color:var(--text-muted);
    line-height:1.7;
}

.ev-status-preview{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:14px;
    padding:18px;
    margin-bottom:28px;
}

.ev-status-preview i{
    color:#94A3B8;
}

.ev-status-badge{
    padding:8px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
}

.ev-status-draft{
    background:#F3F4F6;
    color:#6B7280;
}

.ev-status-published{
    background:#DCFCE7;
    color:#16A34A;
}

.ev-modal-footer{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:12px;
    margin-top:28px;
    padding-top:24px;
    border-top:1px solid var(--border-color);
}
</style>

<script>
    const publishModal = document.getElementById('publishModal');

document
.getElementById('openPublishModal')
.addEventListener('click', () => {

    publishModal.classList.add('show');

});

document
.getElementById('closePublishModal')
.addEventListener('click', closePublishModal);

document
.getElementById('cancelPublish')
.addEventListener('click', closePublishModal);

function closePublishModal(){

    publishModal.classList.remove('show');

}

publishModal.addEventListener('click', function(e){

    if(e.target === publishModal){

        closePublishModal();

    }

});

document
.getElementById("publishForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');

    Studio.buttonLoading(submitBtn, true);

    try{

        const { ok, data } = await Studio.request(
            "{{ route('event-studio.publish', $event) }}",
            {
                method: "POST",
                body: new FormData(this)
            }
        );

        if(!ok){

            Studio.toast({
                icon: "error",
                title: data?.message ?? "Failed to publish event."
            });

            return;

        }

        Studio.toast({
            icon: "success",
            title: data.message
        });

        document
            .getElementById("publishModal")
            .classList.remove("show");

        setTimeout(() => {

            window.location.href = data.redirect;

        }, 800);

    }catch(e){

        Studio.toast({
            icon: "error",
            title: "Something went wrong. Please try again."
        });

    }finally{

        Studio.buttonLoading(submitBtn, false);

    }

});

</script>

@endsection
