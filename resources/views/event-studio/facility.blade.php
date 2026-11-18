
@extends('event-studio.layouts.studio')

@section('content')

<section id="facility_step">

    <p class="ev-event-badge is-green">{{ $event->title ?: 'Untitled event' }}</p>
    <div class="ev-page-header is-green">
        <div class="ev-page-title-row">
            <div class="ev-page-icon">
                <i class="fa-solid fa-gift"></i>
            </div>
            <div class="ev-page-title-copy">
                <h2 class="ev-title">Participant <span class="accent">perks</span></h2>
                <p class="ev-subtitle">Benefits included with each ticket.</p>
            </div>
        </div>
        <div class="ev-page-header-actions">

            <button
                type="button"
                class="ev-btn ev-btn-primary"
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
                class="ev-btn ev-btn-primary"
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

<div
    class="ev-modal-backdrop"
    id="facilityModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="facilityModalTitle">

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
                    class="ev-btn ev-btn-secondary"
                    id="cancelFacility">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="ev-btn ev-btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Save Facility

                </button>

            </div>

        </form>

    </div>

</div>


@include('event-studio.components.modal-confirm')




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
                                    class="ev-btn ev-btn-primary"
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
