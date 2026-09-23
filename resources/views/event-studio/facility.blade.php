
@extends('event-studio.layouts.studio')

@section('content')

<section id="facility_step">

    <div class="page-header">

        <div class="page-header-left">

            <div class="ev-section">

                <div class="ev-section-header">

                    <div>

                        <span class="ev-badge">
                            FACILITY MANAGEMENT
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="page-header-right">

            <button
                type="button"
                class="btn btn-primary"
                id="btnAddFacility">

                <i class="fa-solid fa-plus"></i>

                Add Facility

            </button>

        </div>

    </div>


    {{-- =========================================================
        EMPTY STATE
    ========================================================== --}}

    @if($facilities->count() == 0)

        <div class="ev-facility-empty">

            <div class="ev-facility-empty-icon">

                <i class="ti ti-building-store"></i>

            </div>

            <h4>
                No facilities yet
            </h4>

            <p>
                Add facilities that participants will receive
                as part of their registration or ticket.
            </p>

            <button
                type="button"
                class="btn btn-primary"
                id="btnCreateFirstFacility">

                <i class="fa-solid fa-plus"></i>

                Create Facility

            </button>

        </div>

    @else

        <div class="ev-facility-grid">

            @foreach($facilities as $facility)

                @include('event-studio.facility-card')

            @endforeach

        </div>

    @endif

</section>


{{-- =========================================================
    MODAL FACILITY
========================================================= --}}

<div class="ev-modal-backdrop" id="facilityModal">

    <div class="ev-modal">

        <div class="ev-modal-header">

            <div>

                <h3 id="facilityModalTitle">
                    Create Facility
                </h3>

                <p>
                    Configure facility information and availability.
                </p>

            </div>

            <button
                type="button"
                class="ev-modal-close"
                id="closeFacilityModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>


        <form id="facilityForm">

            @csrf

            <input
                type="hidden"
                id="facility_id"
                name="facility_id">


            {{-- =================================================
                BASIC INFORMATION
            ================================================== --}}

            <div class="ev-field">

                <label class="ev-label">
                    Facility Name <span>*</span>
                </label>

                <input
                    type="text"
                    class="ev-input"
                    name="facility_name"
                    placeholder="Example: Finisher Medal">

            </div>


            <div class="ev-field">

                <label class="ev-label">
                    Description
                </label>

                <textarea
                    class="ev-textarea"
                    rows="3"
                    name="facility_description"
                    placeholder="Optional description shown to participants."></textarea>

            </div>


            <div class="ev-divider"></div>


            {{-- =================================================
                ICON
            ================================================== --}}

            <div class="ev-field">

                <label class="ev-label">
                    Icon
                </label>

                <input
                    type="hidden"
                    name="icon"
                    id="facility_icon">


                <button
                    type="button"
                    class="ev-facility-icon-picker"
                    id="btnFacilityIcon">

                    <span
                        class="ev-facility-icon-preview"
                        id="facilityIconPreview">

                        <i class="ti ti-building-store"></i>

                    </span>

                    <span
                        class="ev-facility-icon-text"
                        id="facilityIconText">

                        Select icon

                    </span>

                    <i class="ti ti-chevron-down ev-facility-icon-arrow"></i>

                </button>


                {{-- ICON DROPDOWN --}}

                <div
                    class="ev-facility-icon-dropdown"
                    id="facilityIconDropdown">

                    <div class="ev-facility-icon-search">

                        <i class="ti ti-search"></i>

                        <input
                            type="text"
                            id="facilityIconSearch"
                            placeholder="Search icon...">

                    </div>

                    <div
                        class="ev-facility-icon-grid"
                        id="facilityIconGrid">
                    </div>

                </div>

            </div>


            {{-- =================================================
                AVAILABILITY
            ================================================== --}}

            <div class="ev-field">

                <label class="ev-label">
                    Facility Availability
                </label>


                <div class="ev-scope-grid">


                    {{-- GENERAL --}}

                    <label class="ev-scope-option">

                        <input
                            type="radio"
                            name="scope"
                            value="general"
                            checked>

                        <div>

                            <strong>
                                General
                            </strong>

                            <small>
                                Available for all tickets.
                            </small>

                        </div>

                    </label>


                    {{-- TICKET SPECIFIC --}}

                    <label class="ev-scope-option">

                        <input
                            type="radio"
                            name="scope"
                            value="ticket">

                        <div>

                            <strong>
                                Specific Tickets
                            </strong>

                            <small>
                                Available only for selected tickets.
                            </small>

                        </div>

                    </label>

                </div>

            </div>


            {{-- =================================================
                TICKET SELECTION
            ================================================== --}}

            <div
                class="ev-field"
                id="facilityTicketField"
                style="display:none;">

                <label class="ev-label">
                    Select Tickets
                </label>


                <div class="ev-ticket-select-list">

                    @forelse($tickets as $ticket)

                        <label class="ev-ticket-select-item">

                            <input
                                type="checkbox"
                                name="tickets[]"
                                value="{{ $ticket->id }}">

                            <span>
                                {{ $ticket->ticket_name }}
                            </span>

                        </label>

                    @empty

                        <div class="ev-ticket-select-empty">

                            No tickets available.

                        </div>

                    @endforelse

                </div>

                <small class="ev-helper">
                    Select the ticket types that include this facility.
                </small>

            </div>


            {{-- =================================================
                FOOTER
            ================================================== --}}

            <div class="ev-modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    id="cancelFacility">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Save Facility

                </button>

            </div>

        </form>

    </div>

</div>


@include('event-studio.components.modal-confirm')


<style>

/* =========================================================
   FACILITY GENERAL
========================================================= */

.ev-section {
    margin-bottom: 5px;
}

.ev-badge {

    display: inline-flex;

    align-items: center;

    padding: 8px 16px;

    border-radius: 999px;

    background: #EEF5FF;

    color: #4495f9;

    font-size: .78rem;

    font-weight: 700;

    margin-bottom: 18px;

}

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 24px;

    margin-bottom: 30px;

}

.page-header-left {
    flex: 1;
}

.page-header-right {
    flex-shrink: 0;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.ev-facility-empty {

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 80px 40px;

    border: 1px dashed #CBD5E1;

    border-radius: 22px;

    background: #fff;

}

.ev-facility-empty-icon {

    width: 84px;

    height: 84px;

    border-radius: 22px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #EEF5FF;

    color: #4495f9;

    font-size: 34px;

    margin-bottom: 24px;

}

.ev-facility-empty h4 {

    margin: 0;

    font-size: 24px;

    font-weight: 700;

}

.ev-facility-empty p {

    margin: 12px 0 28px;

    color: #64748B;

    max-width: 460px;

    line-height: 1.7;

}


/* =========================================================
   FACILITY GRID
========================================================= */

.ev-facility-grid {

    display: grid;

    grid-template-columns: 1fr;

    gap: 16px;

}


/* =========================================================
   FACILITY CARD
========================================================= */

.ev-facility-card {

    position: relative;

    background: #fff;

    border: 1px solid #E2E8F0;

    border-radius: 16px;

    padding: 16px 20px;

    transition: .25s ease;

}

.ev-facility-card:hover {

    border-color: #CBD5E1;

    box-shadow:
        0 8px 24px rgba(15, 23, 42, .05);

}

.ev-facility-header {

    display: flex;

    align-items: center;

    gap: 14px;

    padding-right: 40px;

}

.ev-facility-icon {

    width: 42px;

    height: 42px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #EEF5FF;

    color: #4495f9;

    font-size: 20px;

    flex-shrink: 0;

}

.ev-facility-header h4 {

    margin: 0;

    font-size: 16px;

    font-weight: 700;

    color: #0F172A;

}

.ev-facility-header p {

    margin: 3px 0 0;

    color: #64748B;

    font-size: 12.5px;

    line-height: 1.4;

}

.ev-facility-meta {

    display: flex;

    flex-wrap: wrap;

    gap: 8px;

    margin-top: 14px;

}

.ev-facility-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 5px 10px;

    border-radius: 999px;

    background: #F8FAFC;

    border: 1px solid #F1F5F9;

    color: #475569;

    font-size: 11.5px;

    font-weight: 600;

}

.ev-facility-badge i {

    color: #4495f9;

}


/* =========================================================
   FACILITY MENU
========================================================= */

.ev-facility-menu {

    position: absolute;

    top: 14px;

    right: 14px;

}

.ev-facility-menu-btn {

    width: 34px;

    height: 34px;

    border: none;

    border-radius: 10px;

    background: #F8FAFC;

    color: #64748B;

    cursor: pointer;

    transition: .2s;

}

.ev-facility-menu-btn:hover {

    background: #F1F5F9;

    color: #0F172A;

}

.ev-facility-dropdown {

    position: absolute;

    top: 40px;

    right: 0;

    width: 180px;

    background: #FFF;

    border: 1px solid #E2E8F0;

    border-radius: 14px;

    box-shadow:
        0 16px 40px rgba(15, 23, 42, .08);

    display: none;

    overflow: hidden;

    z-index: 20;

}

.ev-facility-menu.open .ev-facility-dropdown {

    display: block;

}

.ev-facility-dropdown button {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 12px 16px;

    border: none;

    background: #FFF;

    cursor: pointer;

    text-align: left;

    font-size: 13px;

    color: #334155;

}

.ev-facility-dropdown button:hover {

    background: #F8FAFC;

}

.ev-facility-dropdown hr {

    margin: 0;

    border: none;

    border-top: 1px solid #EEF2F7;

}

.ev-facility-dropdown .danger {

    color: #EF4444;

}


/* =========================================================
   MODAL
   SAME SYSTEM AS TICKET
========================================================= */

.ev-modal-backdrop {

    position: fixed;

    top: 0;
    left: 0;
    right: 0;
    bottom: 0;

    background: rgba(15, 23, 42, 0.45);

    backdrop-filter: blur(4px);

    display: flex;

    align-items: center;
    justify-content: center;

    z-index: 1000;

    opacity: 0;

    visibility: hidden;

    transition: all .2s ease;

}

.ev-modal-backdrop.show {

    opacity: 1;

    visibility: visible;

}

.ev-modal {

    background: #ffffff;

    width: 100%;

    max-width: 780px;

    max-height: 90vh;

    border-radius: 20px;

    box-shadow:
        0 20px 50px rgba(15, 23, 42, 0.15);

    overflow-y: auto;

    animation: modalShow .25s ease-out;

}


/* =========================================================
   MODAL HEADER
========================================================= */

.ev-modal-header {

    padding: 24px 28px 20px;

    border-bottom: 1px solid #F1F5F9;

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

}

.ev-modal-header h3 {

    margin: 0;

    font-size: 20px;

    font-weight: 700;

    color: #0F172A;

}

.ev-modal-header p {

    margin: 4px 0 0;

    font-size: 13.5px;

    color: #64748B;

    line-height: 1.5;

}

.ev-modal-close {

    width: 36px;

    height: 36px;

    border: none;

    border-radius: 10px;

    background: #F8FAFC;

    color: #64748B;

    cursor: pointer;

    display: flex;

    align-items: center;

    justify-content: center;

    transition: all .2s;

}

.ev-modal-close:hover {

    background: #F1F5F9;

    color: #0F172A;

}


/* =========================================================
   MODAL FORM
========================================================= */

.ev-modal form {

    padding: 24px 28px;

}

.ev-field {

    margin-bottom: 18px;

}

.ev-label {

    display: block;

    font-size: 13px;

    font-weight: 600;

    color: #334155;

    margin-bottom: 8px;

}

.ev-label span {
    color: #EF4444;
}

.ev-input,
.ev-textarea {

    width: 100%;

    padding: 11px 16px;

    border-radius: 12px;

    border: 1px solid #CBD5E1;

    background: #FFFFFF;

    font-family: inherit;

    font-size: 14px;

    letter-spacing: normal;

    color: #0F172A;

    outline: none;

    transition:
        border-color .2s,
        box-shadow .2s;

}

.ev-textarea {

    resize: vertical;

    min-height: 90px;

    line-height: 1.5;

}

.ev-input::placeholder,
.ev-textarea::placeholder {

    font-family: inherit;

    font-size: 14px;

    letter-spacing: normal;

    color: #94A3B8;

    opacity: 1;

}

.ev-input:focus,
.ev-textarea:focus {

    border-color: #4495f9;

    box-shadow:
        0 0 0 3.5px rgba(68, 149, 249, 0.15);

}

.ev-helper {

    display: block;

    margin-top: 6px;

    font-size: 12px;

    color: #94A3B8;

}

.ev-divider {

    height: 1px;

    background: #F1F5F9;

    margin: 24px 0;

}


/* =========================================================
   ICON PICKER
========================================================= */

.ev-facility-icon-picker {

    position: relative;

    width: 100%;

    min-height: 48px;

    padding: 8px 14px;

    border-radius: 12px;

    border: 1px solid #CBD5E1;

    background: #FFFFFF;

    display: flex;

    align-items: center;

    gap: 12px;

    color: #334155;

    cursor: pointer;

    text-align: left;

    font-family: inherit;

}

.ev-facility-icon-picker:hover {

    border-color: #94A3B8;

}

.ev-facility-icon-preview {

    width: 32px;

    height: 32px;

    border-radius: 9px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #EEF5FF;

    color: #4495f9;

    font-size: 18px;

    flex-shrink: 0;

}

.ev-facility-icon-text {

    flex: 1;

    font-size: 14px;

}

.ev-facility-icon-arrow {

    color: #94A3B8;

}

.ev-facility-icon-dropdown {

    position: relative;

    display: none;

    margin-top: 8px;

    background: #fff;

    border: 1px solid #E2E8F0;

    border-radius: 14px;

    box-shadow:
        0 16px 40px rgba(15, 23, 42, .08);

    padding: 12px;

    z-index: 30;

}

.ev-facility-icon-dropdown.open {

    display: block;

}

.ev-facility-icon-search {

    position: relative;

    margin-bottom: 12px;

}

.ev-facility-icon-search i {

    position: absolute;

    left: 12px;

    top: 50%;

    transform: translateY(-50%);

    color: #94A3B8;

}

.ev-facility-icon-search input {

    width: 100%;

    padding: 9px 12px 9px 36px;

    border: 1px solid #E2E8F0;

    border-radius: 10px;

    outline: none;

    font-size: 13px;

}

.ev-facility-icon-grid {

    display: grid;

    grid-template-columns: repeat(6, 1fr);

    gap: 8px;

    max-height: 180px;

    overflow-y: auto;

}

.ev-facility-icon-item {

    height: 44px;

    border: 1px solid #F1F5F9;

    background: #F8FAFC;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    color: #475569;

    font-size: 18px;

    transition: .15s;

}

.ev-facility-icon-item:hover {

    background: #EEF5FF;

    border-color: #BFDBFE;

    color: #4495f9;

}

.ev-facility-icon-item.active {

    background: #EEF5FF;

    border-color: #4495f9;

    color: #4495f9;

}


/* =========================================================
   SCOPE
========================================================= */

.ev-scope-grid {

    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 12px;

}

.ev-scope-option {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 14px;

    border: 1px solid #E2E8F0;

    border-radius: 12px;

    cursor: pointer;

    transition: .2s ease;

}

.ev-scope-option:hover {

    border-color: #CBD5E1;

    background: #F8FAFC;

}

.ev-scope-option input {

    margin-top: 3px;

}

.ev-scope-option strong {

    display: block;

    font-size: 13px;

    color: #0F172A;

}

.ev-scope-option small {

    display: block;

    margin-top: 3px;

    font-size: 12px;

    color: #64748B;

}


/* =========================================================
   TICKET SELECTION
========================================================= */

.ev-ticket-select-list {

    display: flex;

    flex-direction: column;

    gap: 8px;

    padding: 8px;

    border: 1px solid #E2E8F0;

    border-radius: 12px;

    max-height: 220px;

    overflow-y: auto;

}

.ev-ticket-select-item {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 10px 12px;

    margin: 0;

    border-radius: 9px;

    cursor: pointer;

}

.ev-ticket-select-item:hover {

    background: #F8FAFC;

}

.ev-ticket-select-item span {

    font-size: 13px;

    color: #334155;

}

.ev-ticket-select-empty {

    padding: 18px;

    text-align: center;

    color: #94A3B8;

    font-size: 13px;

}


/* =========================================================
   MODAL FOOTER
========================================================= */

.ev-modal-footer {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 12px;

    margin-top: 24px;

    padding-top: 20px;

    border-top: 1px solid #F1F5F9;

}

.ev-modal-footer .btn {

    padding: 10px 22px;

    font-size: 13.5px;

    font-weight: 600;

    border-radius: 12px;

    cursor: pointer;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    transition: all .2s;

}

.ev-modal-footer .btn-light {

    background: #F1F5F9;

    color: #475569;

    border: none;

}

.ev-modal-footer .btn-light:hover {

    background: #E2E8F0;

    color: #0F172A;

}

.ev-modal-footer .btn-primary {

    background: #4495f9;

    color: #FFFFFF;

    border: none;

}

.ev-modal-footer .btn-primary:hover {

    background: #3182eb;

}


/* =========================================================
   ERROR
========================================================= */

.is-invalid {

    border-color: #EF4444 !important;

}

.ev-error {

    margin-top: 6px;

    color: #EF4444;

    font-size: 12.5px;

    font-weight: 500;

}

.ev-facility-card {
    position: relative;
}

.ev-facility-menu {
    position: absolute;
    top: 18px;
    right: 18px;
    z-index: 10;
}

.ev-facility-menu-btn {
    width: 34px;
    height: 34px;
    border: 0;
    background: transparent;
    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #64748b;
    cursor: pointer;
}

.ev-facility-menu-btn:hover {
    background: #f1f5f9;
    color: #0f172a;
}

.ev-facility-dropdown {
    position: absolute;
    top: calc(100% + 6px);
    right: 0;

    min-width: 160px;

    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;

    padding: 6px;

    box-shadow: 0 10px 30px rgba(15, 23, 42, .12);

    display: none;
}

.ev-facility-dropdown.show {
    display: block;
}

.ev-facility-dropdown button {
    width: 100%;
    border: 0;
    background: transparent;

    padding: 9px 10px;

    border-radius: 7px;

    display: flex;
    align-items: center;
    gap: 9px;

    font-size: 13px;
    color: #334155;

    cursor: pointer;
    text-align: left;
}

.ev-facility-dropdown button:hover {
    background: #f8fafc;
}

.ev-facility-dropdown button.danger {
    color: #dc2626;
}

.ev-facility-dropdown button.danger:hover {
    background: #fef2f2;
}

.ev-facility-dropdown hr {
    border: 0;
    border-top: 1px solid #e2e8f0;
    margin: 5px 0;
}

.ev-facility-assignment {
    margin-top: 18px;
    padding-top: 16px;
    border-top: 1px solid #eef2f7;
}

.ev-facility-assignment-label {
    margin-bottom: 9px;
    font-size: 11px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.ev-facility-ticket-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.ev-facility-ticket {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #334155;
    font-size: 12px;
    font-weight: 500;
}

.ev-facility-ticket-icon {
    width: 20px;
    height: 20px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eff6ff;
    color: #3b82f6;
    flex-shrink: 0;
}

.ev-facility-ticket-icon i {
    font-size: 12px;
}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes modalShow {

    from {

        opacity: 0;

        transform: translateY(20px) scale(.98);

    }

    to {

        opacity: 1;

        transform: none;

    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .page-header {

        flex-direction: column;

        align-items: stretch;

    }

    .ev-scope-grid {

        grid-template-columns: 1fr;

    }

    .ev-modal {

        max-width: 100%;

        border-radius: 20px;

    }

    .ev-modal-header,
    .ev-modal form {

        padding: 20px;

    }

    .ev-facility-icon-grid {

        grid-template-columns: repeat(5, 1fr);

    }

}

</style>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const modal =
        document.getElementById("facilityModal");


    /* =====================================================
       OPEN MODAL
    ====================================================== */

    function openCreateFacility() {

        resetFacilityModal();

        modal.classList.add("show");

    }


    document.addEventListener("click", function (e) {

        const btn =
            e.target.closest(
                "#btnAddFacility, #btnCreateFirstFacility"
            );

        if (!btn) return;

        e.preventDefault();

        openCreateFacility();

    });


    /* =====================================================
       CLOSE MODAL
    ====================================================== */

    function closeModal() {

        modal.classList.remove("show");

        document
            .getElementById("facilityIconDropdown")
            .classList.remove("open");

    }


    document
        .getElementById("closeFacilityModal")
        .addEventListener("click", closeModal);


    document
        .getElementById("cancelFacility")
        .addEventListener("click", closeModal);


    modal.addEventListener("click", function (e) {

        if (e.target === modal) {

            closeModal();

        }

    });


    /* =====================================================
       ICON PICKER
    ====================================================== */

    const icons = [

        "building-store",
        "ticket",
        "medal",
        "trophy",
        "award",
        "gift",
        "shirt",
        "backpack",
        "coffee",
        "bottle",
        "pizza",
        "cake",
        "car",
        "bus",
        "parking",
        "map-pin",
        "wifi",
        "device-mobile",
        "camera",
        "headphones",
        "microphone",
        "music",
        "calendar",
        "clock",
        "heart",
        "star",
        "shield-check",
        "lock",
        "check",
        "circle-check",
        "users",
        "user-check",
        "accessible",
        "bath",
        "home",
        "building",
        "world",
        "flag",
        "sun",
        "cloud",
        "bolt",
        "flame",
        "water-polo",
        "run",
        "bike",
        "swimming",
        "first-aid-kit",
        "medical-cross",
        "restaurant",
        "tools",
        "briefcase",
        "id",
        "qrcode",
        "scan"

    ];


    const iconGrid =
        document.getElementById(
            "facilityIconGrid"
        );

    const iconDropdown =
        document.getElementById(
            "facilityIconDropdown"
        );

    const iconSearch =
        document.getElementById(
            "facilityIconSearch"
        );

    const iconInput =
        document.getElementById(
            "facility_icon"
        );

    const iconPreview =
        document.getElementById(
            "facilityIconPreview"
        );

    const iconText =
        document.getElementById(
            "facilityIconText"
        );


    function renderIcons(search = "") {

        const keyword =
            search.toLowerCase().trim();

        iconGrid.innerHTML = "";

        icons
            .filter(icon =>
                icon.toLowerCase().includes(keyword)
            )
            .forEach(icon => {

                const button =
                    document.createElement("button");

                button.type = "button";

                button.className =
                    "ev-facility-icon-item";

                if (
                    iconInput.value === icon
                ) {

                    button.classList.add(
                        "active"
                    );

                }

                button.innerHTML =
                    `<i class="ti ti-${icon}"></i>`;

                button.title = icon;

                button.addEventListener(
                    "click",
                    function () {

                        selectIcon(icon);

                    }
                );

                iconGrid.appendChild(button);

            });

    }


    function selectIcon(icon) {

        iconInput.value = icon;

        iconPreview.innerHTML =
            `<i class="ti ti-${icon}"></i>`;

        iconText.textContent =
            icon;

        iconDropdown.classList.remove(
            "open"
        );

        renderIcons(
            iconSearch.value
        );

    }


    document
        .getElementById("btnFacilityIcon")
        .addEventListener(
            "click",
            function () {

                iconDropdown.classList.toggle(
                    "open"
                );

                if (
                    iconDropdown.classList.contains(
                        "open"
                    )
                ) {

                    renderIcons();

                    setTimeout(
                        () => {
                            iconSearch.focus();
                        },
                        50
                    );

                }

            }
        );


    iconSearch.addEventListener(
        "input",
        function () {

            renderIcons(
                this.value
            );

        }
    );


    /* =====================================================
       SCOPE
    ====================================================== */

    document
        .querySelectorAll(
            'input[name="scope"]'
        )
        .forEach(input => {

            input.addEventListener(
                "change",
                function () {

                    toggleTicketSelection();

                }
            );

        });


    function toggleTicketSelection() {

        const selected =
            document.querySelector(
                'input[name="scope"]:checked'
            );

        const field =
            document.getElementById(
                "facilityTicketField"
            );

        if (
            !selected ||
            selected.value !== "ticket"
        ) {

            field.style.display =
                "none";

            field
                .querySelectorAll(
                    'input[type="checkbox"]'
                )
                .forEach(
                    checkbox => {

                        checkbox.checked =
                            false;

                    }
                );

            return;

        }

        field.style.display =
            "block";

    }


    /* =====================================================
       SUBMIT
    ====================================================== */

    document
        .getElementById("facilityForm")
        .addEventListener(
            "submit",
            async function (e) {

                e.preventDefault();

                clearFacilityErrors();

                const submitBtn =
                    this.querySelector(
                        'button[type="submit"]'
                    );

                Studio.buttonLoading(
                    submitBtn,
                    true
                );


                try {

                    const facilityId =
                        document
                            .getElementById(
                                "facility_id"
                            )
                            .value;


                    const url = facilityId

                        ? "{{ route('event-studio.facility.update', [$event->event_id, ':id']) }}"
                            .replace(
                                ":id",
                                facilityId
                            )

                        : "{{ route('event-studio.facility.store', $event->event_id) }}";


                    const formData =
                        new FormData(this);


                    if (facilityId) {

                        formData.append(
                            "_method",
                            "PUT"
                        );

                    }


                    const { ok, data } =
                        await Studio.request(
                            url,
                            {
                                method: "POST",
                                body: formData
                            }
                        );


                    if (!ok) {

                        if (data?.errors) {

                            showFacilityErrors(
                                data.errors
                            );

                        }

                        Studio.showStatus(
                            "Failed",
                            data?.message ??
                            "Please check the form."
                        );

                        return;

                    }


                    Studio.showStatus(
                        "Saved",
                        data.message
                    );


                    modal.classList.remove(
                        "show"
                    );


                    resetFacilityModal();


                    /* UPDATE */

                    if (facilityId) {

                        const card =
                            document.querySelector(
                                `.ev-facility-card[data-id="${facilityId}"]`
                            );

                        if (
                            card &&
                            data.html
                        ) {

                            card.outerHTML =
                                data.html;

                        }

                    }


                    /* CREATE */

                    else {

                        appendFacility(
                            data.html
                        );

                    }


                } finally {

                    Studio.buttonLoading(
                        submitBtn,
                        false
                    );

                }

            }
        );


    /* =====================================================
       ERROR
    ====================================================== */

    function clearFacilityErrors() {

        document
            .querySelectorAll(
                ".ev-error"
            )
            .forEach(
                el => el.remove()
            );


        document
            .querySelectorAll(
                ".is-invalid"
            )
            .forEach(
                el => {

                    el.classList.remove(
                        "is-invalid"
                    );

                }
            );

    }


    function showFacilityErrors(errors) {

        clearFacilityErrors();


        Object.keys(errors)
            .forEach(field => {

                let input =
                    document.querySelector(
                        `[name="${field}"]`
                    );


                /*
                 * tickets -> tickets[]
                 */

                if (
                    !input &&
                    field === "tickets"
                ) {

                    input =
                        document.querySelector(
                            '[name="tickets[]"]'
                        );

                }


                if (!input) return;


                input.classList.add(
                    "is-invalid"
                );


                const error =
                    document.createElement(
                        "div"
                    );

                error.className =
                    "ev-error";

                error.innerHTML =
                    errors[field][0];


                input.after(error);

            });

    }


    /* =====================================================
       APPEND CARD
    ====================================================== */

    function appendFacility(html) {

        const empty =
            document.querySelector(
                ".ev-facility-empty"
            );

        let grid =
            document.querySelector(
                ".ev-facility-grid"
            );


        if (empty) {

            empty.remove();

        }


        if (!grid) {

            grid =
                document.createElement(
                    "div"
                );

            grid.className =
                "ev-facility-grid";


            document
                .getElementById(
                    "facility_step"
                )
                .appendChild(
                    grid
                );

        }


        grid.insertAdjacentHTML(
            "beforeend",
            html
        );

    }


    /* =====================================================
       FACILITY MENU
    ====================================================== */

    document.addEventListener(
        "click",
        function (e) {

            const menuButton =
                e.target.closest(
                    ".ev-facility-menu-btn"
                );


            /*
             * Klik ellipsis
             */

            if (menuButton) {

                e.preventDefault();

                e.stopPropagation();


                const menu =
                    menuButton.closest(
                        ".ev-facility-menu"
                    );


                const dropdown =
                    menu.querySelector(
                        ".ev-facility-dropdown"
                    );


                /*
                 * Tutup menu lain
                 */

                document
                    .querySelectorAll(
                        ".ev-facility-dropdown.show"
                    )
                    .forEach(
                        item => {

                            if (
                                item !== dropdown
                            ) {

                                item.classList.remove(
                                    "show"
                                );

                            }

                        }
                    );


                dropdown.classList.toggle(
                    "show"
                );


                return;

            }


            /*
             * Klik Edit
             */

            const editButton =
                e.target.closest(
                    ".facility-edit"
                );


            if (editButton) {

                e.preventDefault();

                e.stopPropagation();


                const card =
                    editButton.closest(
                        ".ev-facility-card"
                    );


                if (!card) return;


                /*
                 * Tutup dropdown
                 */

                const dropdown =
                    editButton.closest(
                        ".ev-facility-dropdown"
                    );


                if (dropdown) {

                    dropdown.classList.remove(
                        "show"
                    );

                }


                editFacility(card);

                return;

            }


            /*
             * Klik Delete
             */

            const deleteButton =
                e.target.closest(
                    ".facility-delete"
                );


            if (deleteButton) {

                e.preventDefault();

                e.stopPropagation();


                const card =
                    deleteButton.closest(
                        ".ev-facility-card"
                    );


                if (!card) return;


                const dropdown =
                    deleteButton.closest(
                        ".ev-facility-dropdown"
                    );


                if (dropdown) {

                    dropdown.classList.remove(
                        "show"
                    );

                }


                deleteFacility(
                    card,
                    deleteButton
                );

                return;

            }


            /*
             * Klik di luar menu
             */

            if (
                !e.target.closest(
                    ".ev-facility-menu"
                )
            ) {

                document
                    .querySelectorAll(
                        ".ev-facility-dropdown.show"
                    )
                    .forEach(
                        dropdown => {

                            dropdown.classList.remove(
                                "show"
                            );

                        }
                    );

            }

        }
    );


    /* =====================================================
       EDIT FACILITY
    ====================================================== */

    function editFacility(card) {

        resetFacilityModal();


        const facilityId =
            card.dataset.id;


        const name =
            card.dataset.name ??
            "";


        const description =
            card.dataset.description ??
            "";


        const icon =
            card.dataset.icon ??
            "";


        const scope =
            card.dataset.scope ??
            "general";


        /*
         * ID
         */

        document
            .getElementById(
                "facility_id"
            )
            .value =
            facilityId;


        /*
         * NAME
         */

        document.querySelector(
            '[name="facility_name"]'
        ).value =
            name;


        /*
         * DESCRIPTION
         */

        document.querySelector(
            '[name="facility_description"]'
        ).value =
            description;


        /*
         * ICON
         */

        if (icon) {

            selectIcon(
                icon
            );

        }


        /*
         * SCOPE
         */

        const scopeInput =
            document.querySelector(
                `input[name="scope"][value="${scope}"]`
            );


        if (scopeInput) {

            scopeInput.checked =
                true;

        }


        toggleTicketSelection();


        /*
         * TICKETS
         */

        let ticketIds = [];


        try {

            ticketIds =
                JSON.parse(
                    card.dataset.tickets ||
                    "[]"
                );

        } catch (error) {

            ticketIds = [];

        }


        document
            .querySelectorAll(
                '#facilityTicketField input[type="checkbox"]'
            )
            .forEach(
                checkbox => {

                    checkbox.checked =
                        ticketIds
                            .map(String)
                            .includes(
                                String(
                                    checkbox.value
                                )
                            );

                }
            );


        /*
         * TITLE
         */

        document
            .getElementById(
                "facilityModalTitle"
            )
            .innerHTML =
            "Edit Facility";


        /*
         * SUBTITLE
         */

        document.querySelector(
            "#facilityModal .ev-modal-header p"
        ).innerHTML =
            "Update facility information.";


        /*
         * SUBMIT BUTTON
         */

        document.querySelector(
            '#facilityForm button[type="submit"]'
        ).innerHTML = `
            <i class="fa-solid fa-floppy-disk"></i>
            Update Facility
        `;


        /*
         * OPEN
         */

        modal.classList.add(
            "show"
        );

    }


    /* =====================================================
       DELETE FACILITY
    ====================================================== */

    async function deleteFacility(
        card,
        button
    ) {

        const facilityId =
            button.dataset.id;


        if (!facilityId) return;


        Studio.confirm({

            title:
                "Delete Facility?",

            description:
                "This facility will be permanently deleted and cannot be recovered.",

            button:
                "Delete Facility",


            onConfirm: async function () {

                Studio.showStatus(
                    "Saving",
                    "Deleting facility..."
                );


                const { ok, data } =
                    await Studio.request(

                        "{{ route('event-studio.facility.delete', [$event->event_id, ':id']) }}"
                            .replace(
                                ":id",
                                facilityId
                            ),

                        {
                            method:
                                "DELETE"
                        }

                    );


                if (!ok) {

                    Studio.showStatus(
                        "Failed",
                        data?.message ??
                        "Failed to delete facility."
                    );

                    return;

                }


                /*
                 * Remove card
                 */

                card.remove();


                /*
                 * Success
                 */

                Studio.showStatus(
                    "Saved",
                    data.message
                );


                /*
                 * Jika sudah tidak ada card
                 */

                if (
                    !document.querySelector(
                        ".ev-facility-card"
                    )
                ) {

                    const grid =
                        document.querySelector(
                            ".ev-facility-grid"
                        );


                    if (grid) {

                        grid.remove();

                    }


                    document
                        .getElementById(
                            "facility_step"
                        )
                        .insertAdjacentHTML(
                            "beforeend",
                            `
                            <div class="ev-facility-empty">

                                <div class="ev-facility-empty-icon">

                                    <i class="ti ti-building-store"></i>

                                </div>

                                <h4>
                                    No facilities yet
                                </h4>

                                <p>
                                    Add facilities that participants will receive
                                    as part of their registration or ticket.
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    id="btnCreateFirstFacility">

                                    <i class="fa-solid fa-plus"></i>

                                    Create Facility

                                </button>

                            </div>
                            `
                        );

                }

            }

        });

    }


    /* =====================================================
       RESET
    ====================================================== */

    window.resetFacilityModal =
        function () {

            const form =
                document.getElementById(
                    "facilityForm"
                );


            form.reset();


            clearFacilityErrors();


            document
                .getElementById(
                    "facility_id"
                )
                .value =
                "";


            /*
             * TITLE
             */

            document
                .getElementById(
                    "facilityModalTitle"
                )
                .innerHTML =
                "Create Facility";


            /*
             * SUBTITLE
             */

            document.querySelector(
                "#facilityModal .ev-modal-header p"
            ).innerHTML =
                "Configure facility information and availability.";


            /*
             * BUTTON
             */

            document.querySelector(
                '#facilityForm button[type="submit"]'
            ).innerHTML = `
                <i class="fa-solid fa-floppy-disk"></i>
                Save Facility
            `;


            /*
             * ICON
             */

            document
                .getElementById(
                    "facility_icon"
                )
                .value =
                "";


            document
                .getElementById(
                    "facilityIconPreview"
                )
                .innerHTML =
                '<i class="ti ti-building-store"></i>';


            document
                .getElementById(
                    "facilityIconText"
                )
                .textContent =
                "Select icon";


            document
                .getElementById(
                    "facilityIconDropdown"
                )
                .classList.remove(
                    "open"
                );


            /*
             * TICKET FIELD
             */

            document
                .getElementById(
                    "facilityTicketField"
                )
                .style.display =
                "none";


            document
                .querySelectorAll(
                    '#facilityTicketField input[type="checkbox"]'
                )
                .forEach(
                    checkbox => {

                        checkbox.checked =
                            false;

                    }
                );


            /*
             * GENERAL
             */

            const general =
                document.querySelector(
                    'input[name="scope"][value="general"]'
                );


            if (general) {

                general.checked =
                    true;

            }


            renderIcons();

        };


    /* =====================================================
       INITIAL ICONS
    ====================================================== */

    renderIcons();

});

</script>

@endsection
