@extends('event-studio.layouts.studio')

@section('content')

<div class="ev-summary">

    {{-- Hero --}}

    <section class="ev-hero">

        <div class="ev-hero-left">

            <span class="ev-status">

                <i class="fa-regular {{ $event->event_status === 'published' ? 'fa-circle-check' : 'fa-clock' }}"></i>

                {{ $event->event_status === 'published' ? 'Published Event' : 'Draft Event' }}

            </span>

            <p class="ev-hero-event">{{ $event->title ?: 'Untitled event' }}</p>

            <h1>

                Event <span class="accent">summary</span>

            </h1>

            <p>

                Review, refine, then go live.

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

            <a
                href="{{ route('event.show', $event) }}"
                target="_blank"
                rel="noopener"
                class="ev-btn ev-btn-primary">

                <i class="fa-regular fa-eye"></i>

                Open Event Page

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


                    </div>

                </div>

                <div class="ev-section-body">

                    <div class="ev-info-row">

                        <div class="ev-label">

                            Start Date

                        </div>

                        <div class="ev-value">

                            {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d M Y') : '-' }}

                        </div>

                    </div>

                    <div class="ev-info-row">

                        <div class="ev-label">

                            End Date

                        </div>

                        <div class="ev-value">

                            {{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d M Y') : '-' }}

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

                                    @if($form->field_help)
                                        <small>{{ $form->field_help }}</small>
                                    @endif

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
                        href="{{ route('event.show', $event) }}"
                        target="_blank"
                        rel="noopener"
                        class="ev-btn ev-btn-outline ev-btn-full">

                        <i class="fa-regular fa-eye"></i>

                        Open Event Page

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
<div
    class="ev-modal-backdrop"
    id="publishModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="publishModalTitle">

    <div class="ev-modal ev-modal-sm">

        <div class="ev-modal-header">

            <div>

                <h3 id="publishModalTitle">
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
                    class="ev-btn ev-btn-secondary"
                    id="cancelPublish">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="ev-btn ev-btn-primary"
                    id="publishSubmit">

                    <i class="fa-solid fa-paper-plane"></i>

                    Publish Event

                </button>

            </div>

        </form>

    </div>

</div>


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
