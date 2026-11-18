@extends('event-studio.layouts.studio')

@section('content')

<section id="ticket_step">

    <p class="ev-event-badge is-amber">{{ $event->title ?: 'Untitled event' }}</p>
    <div class="ev-page-header is-amber">
        <div class="ev-page-title-row">
            <div class="ev-page-icon">
                <i class="fa-solid fa-ticket"></i>
            </div>
            <div class="ev-page-title-copy">
                <h2 class="ev-title">Tickets &amp; <span class="accent">pricing</span></h2>
                <p class="ev-subtitle">Tiers, quota and sales windows.</p>
            </div>
        </div>
        <div class="ev-page-header-actions">
            <button
                type="button"
                class="ev-btn ev-btn-primary"
                id="btnAddTicket">

                <i class="fa-solid fa-plus"></i>

                Add Ticket

            </button>
        </div>
    </div>

    {{-- EMPTY STATE --}}
    @if($tickets->count() == 0)

        <div class="ev-ticket-empty">

            <div class="ev-ticket-empty-icon">

                <i class="fa-solid fa-ticket"></i>

            </div>

            <h4>
                No tickets yet
            </h4>

            <p>
                Create your first ticket for participants.
            </p>

            <button
                type="button"
                class="ev-btn ev-btn-primary"
                id="btnCreateFirstTicket">

                <i class="fa-solid fa-plus"></i>

                Create Ticket

            </button>

        </div>

    @else

        <div class="ev-ticket-grid">

            @foreach($tickets as $ticket)

                @include('event-studio.ticket-card')

            @endforeach

        </div>

    @endif

</section>
{{-- =========================================================
    MODAL TICKET
========================================================= --}}

<div
    class="ev-modal-backdrop"
    id="ticketModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="ticketModalTitle">

    <div class="ev-modal">

        <div class="ev-modal-header">

            <div>

                <h3 id="ticketModalTitle">
                    Create Ticket
                </h3>

                <p>
                    Configure ticket pricing, quota and sales period.
                </p>

            </div>

            <button
                type="button"
                class="ev-modal-close"
                id="closeTicketModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form id="ticketForm">

            @csrf

            <input
                type="hidden"
                id="ticket_id"
                name="ticket_id">

            {{-- =========================
                BASIC
            ========================== --}}

            <div class="ev-field">

                <label class="ev-label">

                    Ticket Name <span>*</span>

                </label>

                <input
                    type="text"
                    class="ev-input"
                    name="ticket_name"
                    placeholder="Example: Regular Ticket">

            </div>

            <div class="ev-field">

                <label class="ev-label">

                    Description

                </label>

                <textarea
                    class="ev-textarea"
                    rows="3"
                    name="ticket_description"
                    placeholder="Optional description shown to participants."></textarea>

            </div>

            <div class="ev-divider"></div>

            {{-- =========================
                PRICE
            ========================== --}}

            <div class="ev-grid-price">

                <div class="ev-field">

                    <label class="ev-label">

                        Ticket Price

                    </label>

                    <div class="ev-input-group">

                        <span>Rp</span>

                        <input
                            type="text"
                            id="ticket_price"
                            class="ev-input"
                            name="ticket_price"
                            value="0"
                            inputmode="numeric"
                            autocomplete="off">

                    </div>

                    <small class="ev-helper">

                        Enter 0 for free ticket.

                    </small>

                </div>

                <div class="ev-field">

                    <label class="ev-label">

                        Ticket Quota

                    </label>

                    <input
                        type="number"
                        min="1"
                        class="ev-input"
                        name="ticket_quota"
                        placeholder="100">

                </div>

                <div class="ev-field">

                    <label class="ev-label">

                        Max Purchase

                    </label>

                    <input
                        type="number"
                        min="1"
                        class="ev-input"
                        name="max_quantity"
                        value="1">

                    <small class="ev-helper">

                        Maximum ticket per transaction.

                    </small>

                </div>

            </div>

            <div class="ev-divider"></div>

            {{-- =========================
                SALES PERIOD
            ========================== --}}

            <div class="ev-grid-3">

                {{-- Sales Start --}}

                <div class="ev-field">

                    <label class="ev-label">

                        Ticket Start

                    </label>

                    <div class="ev-date-input">
                        <i class="fa-regular fa-calendar"></i>
                        <input
                            id="ticket_start"
                            type="text"
                            class="ev-input"
                            name="ticket_start"
                            placeholder="Select start date">
                    </div>

                </div>

                {{-- Sales End --}}

                <div class="ev-field">

                    <label class="ev-label">

                        Ticket End

                    </label>

                    <div class="ev-date-input">
                        <i class="fa-regular fa-calendar"></i>
                        <input
                            id="ticket_end"
                            type="text"
                            class="ev-input"
                            name="ticket_end"
                            placeholder="Select end date">
                    </div>

                </div>

                {{-- Button Text --}}

                <div class="ev-field">

                    <label class="ev-label">

                        Button Text

                    </label>

                    <select
                        id="ticket_button"
                        name="ticket_button"
                        class="ev-choices">

                        <option value="Register" selected>Register</option>
                        <option value="Buy Ticket">Buy Ticket</option>
                        <option value="Book Now">Book Now</option>
                        <option value="Reserve">Reserve</option>
                        <option value="Join Now">Join Now</option>

                    </select>

                </div>

            </div>

            <div class="ev-modal-footer">

                <button
                    type="button"
                    class="ev-btn ev-btn-secondary"
                    id="cancelTicket">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="ev-btn ev-btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Save Ticket

                </button>

            </div>

        </form>

    </div>

</div>

@include('event-studio.components.modal-confirm')


<script>

document.addEventListener("DOMContentLoaded",function(){

    const modal=document.getElementById("ticketModal");

    document.addEventListener("click", function (event) {

        const btn = event.target.closest(
            "#btnAddTicket, #btnCreateFirstTicket"
        );

        if (!btn) return;

        resetTicketModal();

        modal.classList.add("show");

    });

    function closeModal(){

        modal.classList.remove("show");

    }

    document
        .getElementById("closeTicketModal")
        .addEventListener("click",closeModal);

    document
        .getElementById("cancelTicket")
        .addEventListener("click",closeModal);

    modal.addEventListener("click",function(e){

        if(e.target===modal){

            closeModal();

        }

    });

    if(window.flatpickr){

        window.fpTicketStart = flatpickr("#ticket_start",{

            dateFormat:"Y-m-d",

            altInput:true,

            altFormat:"d F Y"

        });

        window.fpTicketEnd = flatpickr("#ticket_end",{

            dateFormat:"Y-m-d",

            altInput:true,

            altFormat:"d F Y"

        });

    }

    /*
|--------------------------------------------------------------------------
| CHOICES
|--------------------------------------------------------------------------
*/

window.evChoices = {};

document.querySelectorAll(".ev-choices").forEach(element => {

    window.evChoices[element.id] = new Choices(element, {

        searchEnabled: false,

        itemSelectText: "",

        shouldSort: false,

        placeholder: true

    });

});

});


const ticketPrice = document.getElementById("ticket_price");

if (ticketPrice) {

    formatCurrency(ticketPrice);

    ticketPrice.addEventListener("input", function () {

        formatCurrency(this);

    });

}

function formatCurrency(input) {

    let value = input.value.replace(/\D/g, "");

    if (value === "") {

        input.value = "";

        return;

    }

    input.value = Number(value).toLocaleString("id-ID");

}

document
.getElementById("ticketForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    clearErrors();

    const submitBtn = this.querySelector('button[type="submit"]');

    Studio.buttonLoading(submitBtn, true);

    const price = document.getElementById("ticket_price");

    price.value = price.value.replace(/\./g, "");

    const formData = new FormData(this);

    try{

        const ticketId =
        document.getElementById("ticket_id").value;

        const url = ticketId

        ? "{{ route('event-studio.ticket.update',[$event->event_id,':id']) }}"
            .replace(':id',ticketId)

        : "{{ route('event-studio.ticket.store',$event->event_id) }}";

        const formData = new FormData(this);

        if (ticketId) {

            formData.append("_method", "PUT");

        }

        const { ok, data } = await Studio.request(url, {

            method: "POST",

            body: formData

        });

        if(!ok){

            if(data.errors){

                showErrors(data.errors);

            }

            Studio.showStatus(

                "Failed",

                data.message ?? "Please check the form."

            );

            return;

        }

        Studio.showStatus(

            "Saved",

            data.message

        );

        document.getElementById("ticketModal").classList.remove("show");

        resetTicketModal();

        if(ticketId){

            document
                .querySelector(
                    `.ev-ticket-card[data-id="${ticketId}"]`
                )
                .outerHTML = data.html;

        }else{

            appendTicket(data.html);

        }

    }finally{

        Studio.buttonLoading(submitBtn, false);

    }

});

function clearErrors(){

    document.querySelectorAll(".ev-error").forEach(el=>el.remove());

    document.querySelectorAll(".is-invalid").forEach(el=>{

        el.classList.remove("is-invalid");

    });

}

function showErrors(errors){

    clearErrors();

    Object.keys(errors).forEach(field=>{

        const input=document.querySelector(`[name="${field}"]`);

        if(!input) return;

        let target=input;

        if(input.closest(".choices")){

            target=input.closest(".choices");

        }

        target.classList.add("is-invalid");

        const error=document.createElement("div");

        error.className="ev-error";

        error.innerHTML=errors[field][0];

        target.after(error);

    });

}

function appendTicket(html){

    const empty=document.querySelector(".ev-ticket-empty");

    let grid=document.querySelector(".ev-ticket-grid");

    if(empty){

        empty.remove();

    }

    if(!grid){

        grid=document.createElement("div");

        grid.className="ev-ticket-grid";

        document
            .getElementById("ticket_step")
            .appendChild(grid);

    }

    grid.insertAdjacentHTML(

        "beforeend",

        html

    );

}

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".ev-ticket-menu-btn");

    document
        .querySelectorAll(".ev-ticket-menu")
        .forEach(menu => {

            if (!btn || menu !== btn.closest(".ev-ticket-menu")) {

                menu.classList.remove("open");

            }

        });

    if (!btn) return;

    e.stopPropagation();

    btn.closest(".ev-ticket-menu")
        .classList.toggle("open");

});

document.addEventListener("click",function(e){

    const btn=e.target.closest(".ticket-edit");

    if(!btn) return;

    const card=btn.closest(".ev-ticket-card");

    resetTicketModal();

    document.getElementById("ticket_id").value =
        card.dataset.id;

    document.querySelector('[name="ticket_name"]').value =
        card.dataset.ticketName;

    document.querySelector('[name="ticket_description"]').value =
        card.dataset.ticketDescription;

    document.querySelector('[name="ticket_quota"]').value =
        card.dataset.ticketQuota;

    document.querySelector('[name="max_quantity"]').value =
        card.dataset.maxQuantity;

    document.getElementById("ticket_price").value =
        Number(card.dataset.ticketPrice)
            .toLocaleString("id-ID");

    fpTicketStart.setDate(
        card.dataset.ticketStart
    );

    fpTicketEnd.setDate(
        card.dataset.ticketEnd
    );

    evChoices.ticket_button
        .setChoiceByValue(
            card.dataset.ticketButton
        );

    document.getElementById("ticketModalTitle")
        .innerHTML="Edit Ticket";

    document.querySelector(
        "#ticketModal .ev-modal-header p"
    ).innerHTML="Update ticket information.";

    document.querySelector(
        '#ticketForm button[type="submit"]'
    ).innerHTML=`
        <i class="fa-solid fa-floppy-disk"></i>
        Update Ticket
    `;

    document
        .getElementById("ticketModal")
        .classList.add("show");

});

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".ticket-duplicate");

    if (!btn) return;

    const card = btn.closest(".ev-ticket-card");

    resetTicketModal();

    document.querySelector('[name="ticket_name"]').value =
        (card.dataset.ticketName + " Copy").slice(0, 250);

    document.querySelector('[name="ticket_description"]').value =
        card.dataset.ticketDescription;

    document.querySelector('[name="ticket_quota"]').value =
        card.dataset.ticketQuota;

    document.querySelector('[name="max_quantity"]').value =
        card.dataset.maxQuantity;

    document.getElementById("ticket_price").value =
        Number(card.dataset.ticketPrice)
            .toLocaleString("id-ID");

    fpTicketStart.setDate(
        card.dataset.ticketStart
    );

    fpTicketEnd.setDate(
        card.dataset.ticketEnd
    );

    evChoices.ticket_button
        .setChoiceByValue(
            card.dataset.ticketButton
        );

    document.getElementById("ticketModalTitle")
        .innerHTML = "Duplicate Ticket";

    document.querySelector(
        "#ticketModal .ev-modal-header p"
    ).innerHTML = "Create a copy of this ticket.";

    document.querySelector(
        '#ticketForm button[type="submit"]'
    ).innerHTML = `
        <i class="fa-solid fa-floppy-disk"></i>
        Save Ticket
    `;

    document
        .getElementById("ticketModal")
        .classList.add("show");

});

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".ticket-delete");

    if (!btn) return;

    const ticketId = btn.dataset.id;

    Studio.confirm({

        title: "Delete Ticket?",

        description: "This ticket will be permanently deleted and cannot be recovered.",

        button: "Delete Ticket",

        onConfirm: async () => {

            Studio.showStatus(
                "Saving",
                "Deleting ticket..."
            );

            const { ok, data } = await Studio.request(

                "{{ route('event-studio.ticket.delete', [$event->event_id, ':id']) }}"
                    .replace(':id', ticketId),

                {
                    method: "DELETE"
                }

            );

            if (!ok) {

                Studio.showStatus(
                    "Failed",
                    data?.message ?? "Failed to delete ticket."
                );

                return;

            }

            // Hapus card dari halaman
            btn.closest(".ev-ticket-card").remove();

            Studio.showStatus(
                "Saved",
                data.message
            );

            // Jika ticket habis tampilkan empty state
            if (!document.querySelector(".ev-ticket-card")) {

                const grid = document.querySelector(".ev-ticket-grid");

                if (grid) {

                    grid.remove();

                }

                document
                    .getElementById("ticket_step")
                    .insertAdjacentHTML("beforeend", `
                        <div class="ev-ticket-empty">
                            <div class="ev-ticket-empty-icon">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <h4>No tickets yet</h4>
                            <p>Create your first ticket to start selling.</p>
                            <button
                                type="button"
                                class="ev-btn ev-btn-primary"
                                id="btnCreateFirstTicket">
                                <i class="fa-solid fa-plus"></i>
                                Create Ticket
                            </button>
                        </div>
                    `);

            }

        }

    });

});


// helper reset modal form

function resetTicketModal(){

    const form = document.getElementById("ticketForm");

    form.reset();

    clearErrors();

    document.getElementById("ticket_id").value = "";

    document.getElementById("ticketModalTitle").innerHTML =
        "Create Ticket";

    document.querySelector(
        "#ticketModal .ev-modal-header p"
    ).innerHTML =
        "Configure ticket pricing, quota and sales period.";

    document.querySelector(
        '#ticketForm button[type="submit"]'
    ).innerHTML = `
        <i class="fa-solid fa-floppy-disk"></i>
        Save Ticket
    `;

    document.getElementById("ticket_price").value = "0";

    formatCurrency(
        document.getElementById("ticket_price")
    );

    fpTicketStart.clear();

    fpTicketEnd.clear();

    evChoices.ticket_button
        .setChoiceByValue("Register");

}
</script>

@endsection