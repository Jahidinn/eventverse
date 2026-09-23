<div
    class="ev-facility-card"

    data-id="{{ $facility->id }}"
    data-name="{{ $facility->name }}"
    data-description="{{ $facility->description }}"
    data-icon="{{ $facility->icon }}"
    data-scope="{{ $facility->scope }}"

    data-tickets='@json(
        $facility->tickets->pluck("id")->map(fn($id) => (int) $id)->values()
    )'
>

    {{-- MENU --}}
    <div class="ev-facility-menu">

        <button
            type="button"
            class="ev-facility-menu-btn">

            <i class="fa-solid fa-ellipsis"></i>

        </button>

        <div class="ev-facility-dropdown">

            <button
                type="button"
                class="facility-edit"
                data-id="{{ $facility->id }}">

                <i class="fa-regular fa-pen-to-square"></i>

                Edit

            </button>

            <hr>

            <button
                type="button"
                class="facility-delete danger"
                data-id="{{ $facility->id }}">

                <i class="fa-regular fa-trash-can"></i>

                Delete

            </button>

        </div>

    </div>


    {{-- HEADER --}}
    <div class="ev-facility-header">

        <div class="ev-facility-icon">

            <i class="ti ti-{{ $facility->icon ?: 'building-store' }}"></i>

        </div>

        <div>

            <h4>
                {{ $facility->name }}
            </h4>

            @if($facility->description)

                <p>
                    {{ $facility->description }}
                </p>

            @endif

        </div>

    </div>


    {{-- TICKET LIST --}}
    @if($facility->scope === 'general')
        <div class="ev-facility-assignment">

            <div class="ev-facility-assignment-label">
                Available for all participants
            </div>

           

        </div>
    @endif

    @if($facility->scope === 'ticket' && $facility->tickets->count())
    <div class="ev-facility-assignment">

        <div class="ev-facility-assignment-label">
            Available for
        </div>

        <div class="ev-facility-ticket-list">

            @foreach($facility->tickets as $ticket)
                <div class="ev-facility-ticket">

                    <div class="ev-facility-ticket-icon">
                        <i class="ti ti-ticket"></i>
                    </div>

                    <span>
                        {{ $ticket->ticket_name }}
                    </span>

                </div>
            @endforeach

        </div>

    </div>
@endif

</div>