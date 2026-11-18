@extends('event-studio.layouts.studio')

@section('title', $lineupFeature->label . ' - ' . $event->title)

@section('content')



<div class="lineup-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <p class="ev-event-badge is-sky">{{ $event->title ?: 'Untitled event' }}</p>
    <div class="ev-page-header is-sky">
        <div class="ev-page-title-row">
            <div class="ev-page-icon">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="ev-page-title-copy">
                <h2 class="ev-title">Meet your <span class="accent">{{ strtolower($lineupFeature->label) }}</span></h2>
                <p class="ev-subtitle">Profiles shown on your event page.</p>
            </div>
        </div>
        <div class="ev-page-header-actions">
            <button
                type="button"
                class="ev-btn ev-btn-primary"
                id="btnAddLineup"
            >
                <i class="fa-solid fa-plus"></i>

                Add {{ rtrim($lineupFeature->label, 's') }}
            </button>
        </div>
    </div>


    {{-- =====================================================
         EMPTY
    ====================================================== --}}

    <div
        class="ev-lineup-empty"
        id="lineupEmpty"
        style="{{ $lineups->count() > 0 ? 'display:none;' : '' }}"
    >

        <div class="ev-lineup-empty-icon">
            <i class="fa-solid fa-user-group"></i>
        </div>

        <h4>
            No {{ strtolower($lineupFeature->label) }} yet
        </h4>

        <p>
            Add your first
            {{ strtolower($lineupFeature->label) }}
            to display them on your event.
        </p>

        <button
            type="button"
            class="ev-btn ev-btn-primary"
            id="btnCreateFirstLineup"
        >
            <i class="fa-solid fa-plus"></i>

            Add {{ rtrim($lineupFeature->label, 's') }}
        </button>

    </div>


    {{-- =====================================================
         GRID
    ====================================================== --}}

    <div
        class="ev-lineup-grid"
        id="lineupGrid"
        style="{{ $lineups->count() === 0 ? 'display:none;' : '' }}"
    >

        @foreach($lineups as $lineup)

            @include(
                'event-studio.line-up-card',
                ['lineup' => $lineup]
            )

        @endforeach

    </div>


    {{-- =====================================================
         MODAL
    ====================================================== --}}

    <div
        class="ev-modal-backdrop"
        id="lineupModal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="lineupModalTitle"
    >

        <div class="ev-modal">

            <div class="ev-modal-header">

                <div>

                    <h3 id="lineupModalTitle">
                        Add {{ rtrim($lineupFeature->label, 's') }}
                    </h3>

                    <p>
                        Add information for this
                        {{ strtolower(rtrim($lineupFeature->label, 's')) }}.
                    </p>

                </div>


                <button
                    type="button"
                    class="ev-modal-close"
                    id="btnCloseLineupModal"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>


            <form
                id="lineupForm"
                enctype="multipart/form-data"
            >

                @csrf

                <input
                    type="hidden"
                    name="lineup_id"
                    id="lineup_id"
                    value=""
                >


                {{-- NAME --}}

                <div class="ev-field">

                    <label
                        for="lineup_name"
                        class="ev-label"
                    >
                        Name
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="lineup_name"
                        name="name"
                        class="ev-input"
                        maxlength="255"
                        placeholder="Enter name"
                    >

                    <div
                        class="ev-error"
                        id="error_name"
                    ></div>

                </div>


                {{-- ROLE --}}

                <div class="ev-field">

                    <label
                        for="lineup_role"
                        class="ev-label"
                    >
                        Role
                    </label>

                    <input
                        type="text"
                        id="lineup_role"
                        name="role"
                        class="ev-input"
                        maxlength="255"
                        placeholder="e.g. Speaker, Judge, Instructor"
                    >

                    <div
                        class="ev-error"
                        id="error_role"
                    ></div>

                </div>


                {{-- PHOTO --}}

                <div class="ev-field">

                    <label class="ev-label">
                        Photo
                    </label>

                    <div class="ev-lineup-photo-box">

                        <div
                            class="ev-lineup-photo-preview"
                            id="lineupPhotoPreview"
                        >
                            <i class="fa-solid fa-user"></i>
                        </div>


                        <div class="ev-lineup-photo-content">

                            <label
                                for="lineup_photo"
                                class="ev-btn ev-btn-secondary ev-lineup-photo-button"
                            >
                                <i class="fa-solid fa-upload"></i>
                                Choose Photo
                            </label>

                            <input
                                type="file"
                                id="lineup_photo"
                                name="photo"
                                accept="image/jpeg,image/png,image/webp"
                                class="ev-lineup-file-input"
                            >

                            <small class="ev-helper">
                                JPG, PNG or WEBP. Maximum 2 MB.
                            </small>

                        </div>

                    </div>

                    <div
                        class="ev-error"
                        id="error_photo"
                    ></div>

                </div>


                {{-- DESCRIPTION --}}

                <div class="ev-field">

                    <label
                        for="lineup_description"
                        class="ev-label"
                    >
                        Description (optional)
                    </label>

                    <textarea
                        id="lineup_description"
                        name="description"
                        class="ev-textarea"
                        placeholder="Short description..."
                    ></textarea>

                    <div
                        class="ev-error"
                        id="error_description"
                    ></div>

                </div>


                {{-- FOOTER --}}

                <div class="ev-modal-footer">

                    <button
                        type="button"
                        class="ev-btn ev-btn-secondary"
                        id="btnCancelLineup"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="ev-btn ev-btn-primary"
                        id="btnSaveLineup"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         TOAST
    ====================================================== --}}

    <div id="lineupToastContainer"></div>

</div>

@include('event-studio.components.modal-confirm')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const modal =
        document.getElementById('lineupModal');

    const form =
        document.getElementById('lineupForm');

    const grid =
        document.getElementById('lineupGrid');

    const emptyState =
        document.getElementById('lineupEmpty');

    const photoInput =
        document.getElementById('lineup_photo');

    const photoPreview =
        document.getElementById('lineupPhotoPreview');

    const lineupIdInput =
        document.getElementById('lineup_id');

    const nameInput =
        document.getElementById('lineup_name');

    const roleInput =
        document.getElementById('lineup_role');

    const descriptionInput =
        document.getElementById('lineup_description');

    const modalTitle =
        document.getElementById('lineupModalTitle');

    const saveButton =
        document.getElementById('btnSaveLineup');

    const countElement =
        document.getElementById('lineupCount');


    /*
    |--------------------------------------------------------------------------
    | ROUTES
    |--------------------------------------------------------------------------
    */

    const storeUrl =
        @json(
            route(
                'event-studio.line-up.store',
                $event->event_id
            )
        );

    const updateUrlTemplate =
        @json(
            route(
                'event-studio.line-up.update',
                [
                    $event->event_id,
                    ':id'
                ]
            )
        );

    const deleteUrlTemplate =
        @json(
            route(
                'event-studio.line-up.delete',
                [
                    $event->event_id,
                    ':id'
                ]
            )
        );


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    const csrfToken =
        @json(csrf_token());


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let originalPhotoUrl = '';


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /*
    |--------------------------------------------------------------------------
    | PHOTO PREVIEW
    |--------------------------------------------------------------------------
    */

    function setPhotoPreview(url = '') {

        if (!photoPreview) {
            return;
        }

        if (url) {

            photoPreview.innerHTML = `
                <img
                    src="${escapeHtml(url)}"
                    alt="Photo Preview"
                >
            `;

        } else {

            photoPreview.innerHTML = `
                <i class="fa-solid fa-user"></i>
            `;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR ERRORS
    |--------------------------------------------------------------------------
    */

    function clearErrors() {

        if (!form) {
            return;
        }

        form
            .querySelectorAll('.ev-error')
            .forEach(function (element) {

                element.textContent = '';

                element.classList.remove(
                    'show'
                );

            });

        form
            .querySelectorAll('.is-invalid')
            .forEach(function (element) {

                element.classList.remove(
                    'is-invalid'
                );

            });

    }


    /*
    |--------------------------------------------------------------------------
    | SHOW VALIDATION ERRORS
    |--------------------------------------------------------------------------
    */

    function showErrors(errors = {}) {

        Object.keys(errors)
            .forEach(function (field) {

                const error =
                    document.getElementById(
                        'error_' + field
                    );

                const input =
                    document.getElementById(
                        'lineup_' + field
                    );


                if (error) {

                    error.textContent =
                        Array.isArray(errors[field])
                            ? errors[field][0]
                            : errors[field];

                    error.classList.add(
                        'show'
                    );

                }


                if (input) {

                    input.classList.add(
                        'is-invalid'
                    );

                }

            });

    }


    /*
    |--------------------------------------------------------------------------
    | TOAST
    |--------------------------------------------------------------------------
    */

    function showToast(
        title,
        message = ''
    ) {

        const container =
            document.getElementById(
                'lineupToastContainer'
            );

        if (!container) {
            return;
        }


        const toast =
            document.createElement(
                'div'
            );

        toast.className =
            'lineup-toast';


        toast.innerHTML = `
            <div class="lineup-toast-title">
                ${escapeHtml(title)}
            </div>

            <div class="lineup-toast-message">
                ${escapeHtml(message)}
            </div>
        `;


        container.appendChild(
            toast
        );


        setTimeout(function () {

            toast.remove();

        }, 3500);

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE LIST / EMPTY STATE
    |--------------------------------------------------------------------------
    */

    function updateListState() {

        if (!grid) {
            return;
        }


        const cards =
            grid.querySelectorAll(
                '.ev-lineup-card'
            );


        const count =
            cards.length;


        if (countElement) {

            countElement.textContent =
                count;

        }


        if (count === 0) {

            grid.style.display =
                'none';


            if (emptyState) {

                emptyState.style.display =
                    '';

            }

        } else {

            grid.style.display =
                '';


            if (emptyState) {

                emptyState.style.display =
                    'none';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | OPEN MODAL
    |--------------------------------------------------------------------------
    */

    function openModal() {

        if (!modal) {
            return;
        }


        modal.classList.add(
            'show'
        );


        document.body.style.overflow =
            'hidden';

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    function closeModal() {

        if (!modal) {
            return;
        }


        modal.classList.remove(
            'show'
        );


        document.body.style.overflow =
            '';

    }


    /*
    |--------------------------------------------------------------------------
    | RESET FORM
    |--------------------------------------------------------------------------
    */

    function resetForm() {

        if (!form) {
            return;
        }


        form.reset();


        clearErrors();


        lineupIdInput.value =
            '';


        originalPhotoUrl =
            '';


        setPhotoPreview(
            ''
        );


        modalTitle.textContent =
            'Add {{ rtrim($lineupFeature->label, "s") }}';


        saveButton.disabled =
            false;


        saveButton.innerHTML = `
            <i class="fa-solid fa-floppy-disk"></i>
            Save
        `;

    }


    /*
    |--------------------------------------------------------------------------
    | ADD LINE-UP
    |--------------------------------------------------------------------------
    */

    const addButton =
        document.getElementById(
            'btnAddLineup'
        );


    if (addButton) {

        addButton.addEventListener(
            'click',
            function () {

                resetForm();

                openModal();


                setTimeout(
                    function () {

                        if (nameInput) {

                            nameInput.focus();

                        }

                    },
                    50
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CREATE FIRST LINE-UP
    |--------------------------------------------------------------------------
    */

    const createFirstButton =
        document.getElementById(
            'btnCreateFirstLineup'
        );


    if (createFirstButton) {

        createFirstButton.addEventListener(
            'click',
            function () {

                resetForm();

                openModal();


                setTimeout(
                    function () {

                        if (nameInput) {

                            nameInput.focus();

                        }

                    },
                    50
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE BUTTON
    |--------------------------------------------------------------------------
    */

    const closeButton =
        document.getElementById(
            'btnCloseLineupModal'
        );


    if (closeButton) {

        closeButton.addEventListener(
            'click',
            closeModal
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL BUTTON
    |--------------------------------------------------------------------------
    */

    const cancelButton =
        document.getElementById(
            'btnCancelLineup'
        );


    if (cancelButton) {

        cancelButton.addEventListener(
            'click',
            closeModal
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLICK BACKDROP
    |--------------------------------------------------------------------------
    */

    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === modal
                ) {

                    closeModal();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal &&
                modal.classList.contains('show')
            ) {

                closeModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PHOTO INPUT
    |--------------------------------------------------------------------------
    */

    if (photoInput) {

        photoInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files &&
                    this.files[0];


                if (!file) {
                    return;
                }


                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                /*
                |----------------------------------------------------------
                | FILE TYPE
                |----------------------------------------------------------
                */

                if (
                    !allowedTypes.includes(
                        file.type
                    )
                ) {

                    alert(
                        'Only JPG, PNG or WEBP images are allowed.'
                    );


                    this.value =
                        '';


                    setPhotoPreview(
                        originalPhotoUrl
                    );


                    return;

                }


                /*
                |----------------------------------------------------------
                | FILE SIZE
                |----------------------------------------------------------
                */

                if (
                    file.size >
                    2 * 1024 * 1024
                ) {

                    alert(
                        'Maximum image size is 2 MB.'
                    );


                    this.value =
                        '';


                    setPhotoPreview(
                        originalPhotoUrl
                    );


                    return;

                }


                /*
                |----------------------------------------------------------
                | PREVIEW
                |----------------------------------------------------------
                */

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        setPhotoPreview(
                            event.target.result
                        );

                    };


                reader.onerror =
                    function () {

                        alert(
                            'Failed to preview the selected image.'
                        );


                        photoInput.value =
                            '';


                        setPhotoPreview(
                            originalPhotoUrl
                        );

                    };


                reader.readAsDataURL(
                    file
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MENU + EDIT + DELETE
    |
    | SATU EVENT HANDLER
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            /*
            |----------------------------------------------------------
            | MENU BUTTON
            |----------------------------------------------------------
            */

            const menuButton =
                event.target.closest(
                    '.ev-lineup-menu-btn'
                );


            if (menuButton) {

                event.preventDefault();

                event.stopPropagation();


                const menu =
                    menuButton.closest(
                        '.ev-lineup-menu'
                    );


                if (!menu) {
                    return;
                }


                document
                    .querySelectorAll(
                        '.ev-lineup-menu.open'
                    )
                    .forEach(
                        function (otherMenu) {

                            if (
                                otherMenu !== menu
                            ) {

                                otherMenu.classList.remove(
                                    'open'
                                );

                            }

                        }
                    );


                menu.classList.toggle(
                    'open'
                );


                return;

            }


            /*
            |----------------------------------------------------------
            | EDIT
            |----------------------------------------------------------
            */

            const editButton =
                event.target.closest(
                    '.lineup-edit'
                );


            if (editButton) {

                event.preventDefault();

                event.stopPropagation();


                const card =
                    editButton.closest(
                        '.ev-lineup-card'
                    );


                if (!card) {
                    return;
                }


                document
                    .querySelectorAll(
                        '.ev-lineup-menu.open'
                    )
                    .forEach(
                        function (menu) {

                            menu.classList.remove(
                                'open'
                            );

                        }
                    );


                clearErrors();


                lineupIdInput.value =
                    card.dataset.id || '';


                nameInput.value =
                    card.dataset.name || '';


                roleInput.value =
                    card.dataset.role || '';


                descriptionInput.value =
                    card.dataset.description || '';


                originalPhotoUrl =
                    card.dataset.photo || '';


                photoInput.value =
                    '';


                setPhotoPreview(
                    originalPhotoUrl
                );


                modalTitle.textContent =
                    'Edit {{ rtrim($lineupFeature->label, "s") }}';


                openModal();


                return;

            }


            /*
            |----------------------------------------------------------
            | DELETE
            |
            | SAMA DENGAN FACILITY
            |----------------------------------------------------------
            */

            const deleteButton =
                event.target.closest(
                    '.lineup-delete'
                );


            if (deleteButton) {

                event.preventDefault();

                event.stopPropagation();


                const card =
                    deleteButton.closest(
                        '.ev-lineup-card'
                    );


                if (!card) {
                    return;
                }


                deleteLineup(
                    card,
                    deleteButton
                );


                return;

            }


            /*
            |----------------------------------------------------------
            | CLICK INSIDE DROPDOWN
            |----------------------------------------------------------
            */

            if (
                event.target.closest(
                    '.ev-lineup-dropdown'
                )
            ) {

                return;

            }


            /*
            |----------------------------------------------------------
            | CLICK OUTSIDE
            |----------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.ev-lineup-menu.open'
                )
                .forEach(
                    function (menu) {

                        menu.classList.remove(
                            'open'
                        );

                    }
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DELETE LINE-UP
    |
    | COPY PATTERN FACILITY
    |--------------------------------------------------------------------------
    */

    async function deleteLineup(
        card,
        button
    ) {

        const lineupId =
            button.dataset.id;


        if (!lineupId) {
            return;
        }


        Studio.confirm({

            title:
                'Delete Line-up?',


            description:
                'This line-up will be permanently deleted and cannot be recovered.',


            button:
                'Delete Line-up',


            onConfirm: async function () {

                Studio.showStatus(
                    'Saving',
                    'Deleting line-up...'
                );


                const { ok, data } =
                    await Studio.request(
                        "{{ route('event-studio.line-up.delete', [$event->event_id, ':id']) }}"
                            .replace(
                                ':id',
                                lineupId
                            ),
                        {
                            method:
                                'DELETE'
                        }
                    );


                if (!ok) {

                    Studio.showStatus(
                        'Failed',
                        data?.message ??
                        'Failed to delete line-up.'
                    );


                    return;

                }


                card.remove();


                Studio.showStatus(
                    'Saved',
                    data.message
                );


                updateListState();

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

    if (form) {

        form.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                clearErrors();


                const lineupId =
                    lineupIdInput.value;


                const isEdit =
                    Boolean(
                        lineupId
                    );


                const url =
                    isEdit

                        ? updateUrlTemplate.replace(
                            ':id',
                            lineupId
                        )

                        : storeUrl;


                const formData =
                    new FormData(
                        form
                    );


                /*
                |----------------------------------------------------------
                | LARAVEL PUT
                |----------------------------------------------------------
                */

                if (isEdit) {

                    formData.append(
                        '_method',
                        'PUT'
                    );

                }


                /*
                |----------------------------------------------------------
                | BUTTON LOADING
                |----------------------------------------------------------
                */

                saveButton.disabled =
                    true;


                saveButton.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Saving...
                `;


                try {

                    /*
                    |--------------------------------------------------------------------------
                    | REQUEST
                    |--------------------------------------------------------------------------
                    */

                    const response =
                        await fetch(
                            url,
                            {
                                method:
                                    'POST',

                                headers: {

                                    'Accept':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest',

                                    'X-CSRF-TOKEN':
                                        csrfToken

                                },

                                body:
                                    formData,

                                credentials:
                                    'same-origin'
                            }
                        );


                    let data = {};


                    try {

                        data =
                            await response.json();

                    } catch (error) {

                        data = {};

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDATION
                    |--------------------------------------------------------------------------
                    */

                    if (
                        response.status === 422
                    ) {

                        showErrors(
                            data.errors || {}
                        );


                        showToast(
                            'Failed',
                            data.message ||
                            'Please check the form.'
                        );


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SERVER ERROR
                    |--------------------------------------------------------------------------
                    */

                    if (!response.ok) {

                        showToast(
                            'Failed',
                            data.message ||
                            'Something went wrong.'
                        );


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE
                    |--------------------------------------------------------------------------
                    */

                    if (!isEdit) {

                        if (grid && data.html) {

                            grid.insertAdjacentHTML(
                                'beforeend',
                                data.html
                            );

                        }

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE
                    |--------------------------------------------------------------------------
                    */

                    else {

                        const oldCard =
                            grid.querySelector(
                                `.ev-lineup-card[data-id="${lineupId}"]`
                            );


                        if (
                            oldCard &&
                            data.html
                        ) {

                            oldCard.outerHTML =
                                data.html;

                        }

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE LIST
                    |--------------------------------------------------------------------------
                    */

                    updateListState();


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */

                    showToast(
                        'Saved',
                        data.message ||
                        'Saved successfully.'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | CLOSE
                    |--------------------------------------------------------------------------
                    */

                    closeModal();


                    /*
                    |--------------------------------------------------------------------------
                    | RESET
                    |--------------------------------------------------------------------------
                    */

                    resetForm();

                } catch (error) {

                    console.error(
                        error
                    );


                    showToast(
                        'Failed',
                        'Unable to connect to the server.'
                    );

                } finally {

                    saveButton.disabled =
                        false;


                    saveButton.innerHTML = `
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save
                    `;

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL STATE
    |--------------------------------------------------------------------------
    */

    updateListState();

});
</script>

@endsection