<div
    class="ev-lineup-card"
    data-id="{{ $lineup->id }}"
    data-name="{{ e($lineup->name) }}"
    data-role="{{ e($lineup->role ?? '') }}"
    data-description="{{ e($lineup->description ?? '') }}"
    data-photo="{{ $lineup->photo ? asset('storage/' . $lineup->photo) : '' }}"
>

    {{-- MENU --}}
    <div class="ev-lineup-menu">

        <button
            type="button"
            class="ev-lineup-menu-btn"
            aria-label="More options"
        >
            <i class="fa-solid fa-ellipsis"></i>
        </button>

        <div class="ev-lineup-dropdown">

            <button
                type="button"
                class="lineup-edit"
                data-id="{{ $lineup->id }}"
            >
                <i class="fa-regular fa-pen-to-square"></i>
                Edit
            </button>

            <button
                type="button"
                class="lineup-delete danger"
                data-id="{{ $lineup->id }}"
            >
                <i class="fa-regular fa-trash-can"></i>
                Delete
            </button>

        </div>

    </div>


    {{-- PROFILE --}}
    <div class="ev-lineup-profile">

        <div class="ev-lineup-card-photo">

            @if($lineup->photo)

                <img
                    src="{{ asset('storage/' . $lineup->photo) }}"
                    alt="{{ $lineup->name }}"
                >

            @else

                <div class="ev-lineup-avatar-placeholder">
                    <i class="fa-solid fa-user"></i>
                </div>

            @endif

        </div>


        <div class="ev-lineup-main">

            <h4>
                {{ $lineup->name }}
            </h4>

            @if($lineup->role)

                <div class="ev-lineup-role">
                    <i class="fa-solid fa-user-tag"></i>
                    {{ $lineup->role }}
                </div>

            @endif

        </div>

    </div>


    @if($lineup->description)

        <div class="ev-lineup-description">
            {{ $lineup->description }}
        </div>

    @endif


    <div class="ev-lineup-card-footer">

        <span class="ev-lineup-status">
            <span class="ev-lineup-status-dot"></span>
            Active
        </span>

    </div>

</div>