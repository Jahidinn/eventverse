@extends('event-studio.layouts.studio')

@section('content')

<section id="ticket_step">

    <span class="page-badge">
        Ticket
    </span>

    <div class="page-header">

    <div class="page-header-left">

        <h2 class="page-title">

            Event Tickets

        </h2>

        <p class="page-subtitle">

            Create one or more ticket types for your event.

        </p>

    </div>

    <div class="page-header-right">

        <button
            class="btn btn-primary"
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
                class="btn btn-primary"
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

<div class="ev-modal-backdrop" id="ticketModal">

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

                        Sales Start

                    </label>

                    <input
                        id="ticket_start"
                        type="text"
                        class="ev-input"
                        name="ticket_start">

                </div>

                {{-- Sales End --}}

                <div class="ev-field">

                    <label class="ev-label">

                        Sales End

                    </label>

                    <input
                        id="ticket_end"
                        type="text"
                        class="ev-input"
                        name="ticket_end">

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
                    class="btn btn-light"
                    id="cancelTicket">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Save Ticket

                </button>

            </div>

        </form>

    </div>

</div>

@include('event-studio.components.modal-confirm')


<style>
    /* =========================================================
   TICKET
========================================================= */

.page-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:24px;

    margin-bottom:30px;

}

.page-header-left{

    flex:1;

}

.page-header-right{

    flex-shrink:0;

}

.page-title{

    margin:0 0 8px;

}

.page-subtitle{

    margin:0;

    max-width:650px;

}

/* =========================================================
   EMPTY
========================================================= */

.ev-ticket-empty{

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    text-align:center;

    padding:80px 40px;

    border:1px dashed #CBD5E1;
    border-radius:22px;

    background:#fff;

}

.ev-ticket-empty-icon{

    width:84px;
    height:84px;

    border-radius:22px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#EEF2FF;

    color:var(--primary);

    font-size:34px;

    margin-bottom:24px;

}

.ev-ticket-empty h4{

    margin:0;

    font-size:24px;
    font-weight:700;

}

.ev-ticket-empty p{

    margin:12px 0 28px;

    color:#64748B;

    max-width:460px;

    line-height:1.7;

}

/* =========================================================
   GRID
========================================================= */

.ev-ticket-grid{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(360px,1fr));

    gap:24px;

}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:768px){

    .page-header{

        flex-direction:column;
        align-items:stretch;

    }

    .ev-ticket-grid{

        grid-template-columns:1fr;

    }

}



/* =========================================
   MOBILE
========================================= */

@media(max-width:768px){

    .ev-grid-price,
    .ev-grid-date{

        grid-template-columns:1fr;

    }

      .ev-grid-3{

        grid-template-columns:1fr;

    }

}



/* =========================================================
   FOOTER
========================================================= */

.ev-modal-footer{

    display:flex;
    justify-content:flex-end;

    gap:14px;

    margin-top:30px;

    padding-top:24px;

    border-top:1px solid #EEF2F7;

}

/* =========================================================
   SCROLL
========================================================= */

.ev-modal::-webkit-scrollbar{

    width:8px;

}

.ev-modal::-webkit-scrollbar-thumb{

    background:#CBD5E1;

    border-radius:999px;

}

.is-invalid{

    border-color:#EF4444 !important;

}

.choices.is-invalid .choices__inner{

    border-color:#EF4444 !important;

}

.ev-error{

    margin-top:8px;

    color:#EF4444;

    font-size:13px;

    font-weight:500;

}

/* =========================================================
   ANIMATION
========================================================= */

@keyframes modalShow{

    from{

        opacity:0;

        transform:translateY(20px) scale(.98);

    }

    to{

        opacity:1;

        transform:none;

    }

}

/* =========================================================
   MOBILE
========================================================= */

@media(max-width:768px){

    .ev-modal{

        max-width:100%;

        border-radius:20px;

    }

    .ev-modal-header{

        padding:22px;

    }

    .ev-modal form{

        padding:22px;

    }

    .ev-grid-3{

        grid-template-columns:1fr;

    }

}
</style>

{{-- Ticket card style --}}


<style>

/* =========================================================
   CARD
========================================================= */

.ev-ticket-card{

    position:relative;

    background:#fff;

    border:1px solid #E2E8F0;
    border-radius:22px;

    padding:24px;

    transition:.25s;

}

.ev-ticket-card:hover{

    border-color:#CBD5E1;

    box-shadow:0 16px 40px rgba(15,23,42,.06);

    transform:translateY(-2px);

}

/* =========================================================
   MENU
========================================================= */

.ev-ticket-menu{

    position:absolute;

    top:18px;
    right:18px;

}

.ev-ticket-menu-btn{

    width:38px;
    height:38px;

    border:none;

    border-radius:12px;

    background:#F8FAFC;

    cursor:pointer;

}

.ev-ticket-dropdown{

    position:absolute;

    top:46px;
    right:0;

    width:180px;

    background:#FFF;

    border:1px solid #E2E8F0;

    border-radius:14px;

    box-shadow:0 16px 40px rgba(15,23,42,.08);

    display:none;

    overflow:hidden;

    z-index:20;

}

.ev-ticket-menu.open .ev-ticket-dropdown{

    display:block;

}

.ev-ticket-dropdown button{

    width:100%;

    display:flex;
    align-items:center;
    gap:12px;

    padding:12px 16px;

    border:none;

    background:#FFF;

    cursor:pointer;

    text-align:left;

}

.ev-ticket-dropdown button:hover{

    background:#F8FAFC;

}

.ev-ticket-dropdown hr{

    margin:0;

    border:none;

    border-top:1px solid #EEF2F7;

}

.ev-ticket-dropdown .danger{

    color:#EF4444;

}

/* =========================================================
   HEADER
========================================================= */

.ev-ticket-header{

    display:flex;
    align-items:center;

    gap:16px;

}

.ev-ticket-icon{

    width:58px;
    height:58px;

    border-radius:16px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#EEF2FF;

    color:var(--primary);

    font-size:24px;

    flex-shrink:0;

}

.ev-ticket-header h4{

    margin:0;

    font-size:20px;
    font-weight:700;

    color:#0F172A;

}

.ev-ticket-header p{

    margin:6px 0 0;

    color:#64748B;

    font-size:14px;

    line-height:1.6;

}

/* =========================================================
   PRICE
========================================================= */

.ev-ticket-price{

    margin:28px 0 22px;

    font-size:34px;
    font-weight:800;

    color:var(--primary);

}

.ev-ticket-price.free{

    color:#10B981;

}

/* =========================================================
   INFO
========================================================= */

.ev-ticket-info{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

    margin-bottom:24px;

}

.ev-ticket-info div{

    padding:16px;

    border-radius:16px;

    background:#F8FAFC;

}

.ev-ticket-info small{

    display:block;

    color:#94A3B8;

    margin-bottom:8px;

}

.ev-ticket-info strong{

    font-size:17px;
    font-weight:700;

}

/* =========================================================
   SALE
========================================================= */

.ev-ticket-sale{

    display:flex;
    align-items:center;

    gap:10px;

    padding:14px 16px;

    border-radius:14px;

    background:#F8FAFC;

    color:#475569;

    font-size:14px;

}

.ev-ticket-sale i{

    color:var(--primary);

}

/* =========================================================
   BUTTON LABEL
========================================================= */

.ev-ticket-button{

    margin-top:18px;

    display:inline-flex;

    align-items:center;

    padding:8px 14px;

    border-radius:999px;

    background:#EEF2FF;

    color:var(--primary);

    font-size:13px;
    font-weight:600;

}
</style>


<script>

document.addEventListener("DOMContentLoaded",function(){

    const modal=document.getElementById("ticketModal");

    const openButtons=[

        document.getElementById("btnAddTicket"),

        document.getElementById("btnCreateFirstTicket")

    ];

    openButtons.forEach(btn=>{

        if(!btn) return;

        btn.addEventListener("click",()=>{

            resetTicketModal();

modal.classList.add("show");

        });

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
                    .getElementById("ticketContainer")
                    .insertAdjacentHTML("beforeend", `
                        <div class="ev-ticket-empty">
                            <i class="fa-solid fa-ticket"></i>
                            <h3>No tickets yet</h3>
                            <p>Create your first ticket to start selling.</p>
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