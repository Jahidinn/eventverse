<div class="ev-ticket-card"

    data-id="{{ $ticket->id }}"
data-ticket-name="{{ $ticket->ticket_name }}"
data-ticket-description="{{ $ticket->ticket_description }}"
data-ticket-price="{{ $ticket->ticket_price }}"
data-ticket-quota="{{ $ticket->ticket_quota }}"
data-max-quantity="{{ $ticket->max_quantity }}"
data-ticket-start="{{ $ticket->ticket_start }}"
data-ticket-end="{{ $ticket->ticket_end }}"
data-ticket-button="{{ $ticket->ticket_button }}"
    >

    <div class="ev-ticket-menu">

        <button
            type="button"
            class="ev-ticket-menu-btn">

            <i class="fa-solid fa-ellipsis"></i>

        </button>

        <div class="ev-ticket-dropdown">

            <button
                type="button"
                class="ticket-edit"
                data-id="{{ $ticket->id }}">

                <i class="fa-regular fa-pen-to-square"></i>

                Edit

            </button>

            <button
                type="button"
                class="ticket-duplicate"
                data-id="{{ $ticket->id }}">

                <i class="fa-regular fa-copy"></i>

                Duplicate

            </button>

            <hr>

            <button
                type="button"
                class="ticket-delete danger"
                data-id="{{ $ticket->id }}">

                <i class="fa-regular fa-trash-can"></i>

                Delete

            </button>

        </div>

    </div>

    <div class="ev-ticket-header">

        <div class="ev-ticket-icon">

            <i class="fa-solid fa-ticket"></i>

        </div>

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

    </div>

    <div class="ev-ticket-price {{ $ticket->ticket_price == 0 ? 'free' : '' }}">

        @if($ticket->ticket_price == 0)

            FREE

        @else

            Rp {{ number_format($ticket->ticket_price,0,',','.') }}

        @endif

    </div>

    <div class="ev-ticket-info">

        <div>

            <small>Quota</small>

            <strong>{{ number_format($ticket->ticket_quota) }}</strong>

        </div>

        <div>

            <small>Max Purchase</small>

            <strong>{{ $ticket->max_quantity }}</strong>

        </div>

    </div>

    <div class="ev-ticket-sale">

        <i class="fa-regular fa-calendar"></i>

        {{ \Carbon\Carbon::parse($ticket->ticket_start)->format('d M Y') }}

        -

        {{ \Carbon\Carbon::parse($ticket->ticket_end)->format('d M Y') }}

    </div>

    <div class="ev-ticket-button">

        {{ $ticket->ticket_button }}

    </div>

</div>
