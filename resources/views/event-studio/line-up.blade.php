@extends('event-studio.layouts.studio')

@section('title', $lineupFeature->label . ' - ' . $event->name)

@section('content')

<style>

/* =========================================================
   PAGE HEADER
========================================================= */

.lineup-page .page-header {

    display: flex;
    justify-content: space-between;
    align-items: flex-start;

    gap: 24px;

    margin-bottom: 30px;
}

.lineup-page .page-header-left {
    flex: 1;
}

.lineup-page .page-header-right {
    flex-shrink: 0;
}

.lineup-page .page-title {

    margin: 0 0 8px;

    color: #0F172A;

    font-size: 24px;
    font-weight: 700;
}

.lineup-page .page-subtitle {

    margin: 0;

    max-width: 650px;

    color: #64748B;

    font-size: 14px;
    line-height: 1.6;
}


/* =========================================================
   BUTTON
========================================================= */

.lineup-page .btn-primary {

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    height: 42px;

    padding: 0 16px;

    border: 0;
    border-radius: 10px;

    background: var(--primary);

    color: #FFFFFF;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;
}


/* =========================================================
   GRID
========================================================= */

.lineup-page .ev-lineup-grid {

    display: grid;

    grid-template-columns: 1fr;

    gap: 18px;

    width: 100%;

    padding: 20px;

    box-sizing: border-box;
}


/* =========================================================
   CARD
========================================================= */

.lineup-page .ev-lineup-card {

    position: relative;

    width: 100%;
    min-width: 0;

    box-sizing: border-box;

    padding: 18px 20px;

    border: 1px solid #E2E8F0;
    border-radius: 16px;

    background: #FFFFFF;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        transform .2s ease;
}

.lineup-page .ev-lineup-card:hover {

    border-color: #D7E3F2;

    box-shadow:
        0 8px 24px rgba(15, 23, 42, .06);

    transform: translateY(-1px);
}


/* =========================================================
   PROFILE
========================================================= */

.lineup-page .ev-lineup-profile {

    display: flex;

    align-items: center;

    gap: 16px;

    padding-right: 50px;
}


/* =========================================================
   PHOTO
========================================================= */

.lineup-page .ev-lineup-card-photo {

    width: 76px;
    height: 76px;

    flex: 0 0 76px;

    overflow: hidden;

    border-radius: 16px;

    background: #EEF5FF;

    border: 1px solid #E2E8F0;
}

.lineup-page .ev-lineup-card-photo img {

    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}

.lineup-page .ev-lineup-avatar-placeholder {

    width: 100%;
    height: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    color: var(--primary);

    font-size: 24px;
}


/* =========================================================
   MAIN
========================================================= */

.lineup-page .ev-lineup-main {

    min-width: 0;
}

.lineup-page .ev-lineup-main h4 {

    margin: 0;

    color: #0F172A;

    font-size: 18px;
    font-weight: 700;

    line-height: 1.4;

    word-break: break-word;
}


/* =========================================================
   ROLE
========================================================= */

.lineup-page .ev-lineup-role {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    margin-top: 7px;

    padding: 5px 9px;

    border-radius: 999px;

    background: #EEF5FF;

    color: var(--primary);

    font-size: 11px;
    font-weight: 600;
}

.lineup-page .ev-lineup-role i {

    font-size: 10px;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.lineup-page .ev-lineup-description {

    margin-top: 17px;

    padding-top: 15px;

    border-top: 1px solid #EEF2F7;

    color: #64748B;

    font-size: 13px;

    line-height: 1.7;

    display: -webkit-box;

    -webkit-box-orient: vertical;

    -webkit-line-clamp: 3;

    overflow: hidden;
}


/* =========================================================
   FOOTER
========================================================= */

.lineup-page .ev-lineup-card-footer {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-top: 15px;

    padding-top: 13px;

    border-top: 1px solid #F1F5F9;
}

.lineup-page .ev-lineup-status {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    color: #64748B;

    font-size: 11px;
}

.lineup-page .ev-lineup-status-dot {

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #22C55E;

    box-shadow:
        0 0 0 3px rgba(34, 197, 94, .10);
}


/* =========================================================
   MENU
========================================================= */

.lineup-page .ev-lineup-menu {

    position: absolute;

    top: 14px;
    right: 14px;

    z-index: 100;
}

.lineup-page .ev-lineup-menu-btn {

    width: 34px;
    height: 34px;

    display: flex;

    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0;
    border-radius: 9px;

    background: transparent;

    color: #94A3B8;

    cursor: pointer;

    transition: .2s;
}

.lineup-page .ev-lineup-menu-btn:hover {

    background: #F1F5F9;

    color: #334155;
}


/* =========================================================
   DROPDOWN
========================================================= */

.lineup-page .ev-lineup-dropdown {

    position: absolute;

    top: 39px;
    right: 0;

    width: 145px;

    padding: 5px;

    border: 1px solid #E2E8F0;
    border-radius: 10px;

    background: #FFFFFF;

    box-shadow:
        0 14px 30px rgba(15, 23, 42, .12);

    opacity: 0;
    visibility: hidden;

    transform: translateY(-4px);

    transition:
        opacity .15s ease,
        visibility .15s ease,
        transform .15s ease;
}

.lineup-page .ev-lineup-menu.open .ev-lineup-dropdown {

    opacity: 1;

    visibility: visible;

    transform: translateY(0);
}

.lineup-page .ev-lineup-dropdown button {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 9px 10px;

    border: 0;
    border-radius: 7px;

    background: transparent;

    color: #334155;

    font-size: 12px;
    font-weight: 500;

    text-align: left;

    cursor: pointer;
}

.lineup-page .ev-lineup-dropdown button:hover {

    background: #F8FAFC;
}

.lineup-page .ev-lineup-dropdown button.danger {

    color: #DC2626;
}

.lineup-page .ev-lineup-dropdown button.danger:hover {

    background: #FEF2F2;
}


/* =========================================================
   EMPTY
========================================================= */

.lineup-page .ev-lineup-empty {

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 70px 30px;

    border: 1px dashed #CBD5E1;

    border-radius: 18px;

    background: #FFFFFF;
}

.lineup-page .ev-lineup-empty-icon {

    width: 72px;
    height: 72px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 18px;

    border-radius: 18px;

    background: #EEF5FF;

    color: var(--primary);

    font-size: 28px;
}

.lineup-page .ev-lineup-empty h4 {

    margin: 0;

    color: #0F172A;

    font-size: 20px;
    font-weight: 700;
}

.lineup-page .ev-lineup-empty p {

    max-width: 420px;

    margin: 9px 0 20px;

    color: #64748B;

    font-size: 13px;

    line-height: 1.6;
}


/* =========================================================
   MODAL
========================================================= */

.lineup-page .ev-modal-backdrop {

    position: fixed;

    inset: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(15, 23, 42, .45);

    backdrop-filter: blur(6px);

    opacity: 0;
    visibility: hidden;

    transition: .25s;

    z-index: 9999;
}

.lineup-page .ev-modal-backdrop.show {

    opacity: 1;

    visibility: visible;
}


.lineup-page .ev-modal {

    width: 100%;

    max-width: 600px;

    overflow: hidden;

    background: #FFFFFF;

    border-radius: 20px;

    box-shadow:
        0 24px 70px rgba(15, 23, 42, .16);

    animation: modalShow .25s ease;
}


/* =========================================================
   MODAL HEADER
========================================================= */

.lineup-page .ev-modal-header {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 16px;

    padding: 20px 24px 18px;

    border-bottom: 1px solid #EEF2F7;
}

.lineup-page .ev-modal-header h3 {

    margin: 0;

    color: #0F172A;

    font-size: 20px;
    font-weight: 700;

    line-height: 1.35;
}

.lineup-page .ev-modal-header p {

    margin: 5px 0 0;

    color: #64748B;

    font-size: 13px;

    line-height: 1.5;
}

.lineup-page .ev-modal-close {

    width: 36px;
    height: 36px;

    flex: 0 0 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    border: 0;
    border-radius: 10px;

    background: #F8FAFC;

    color: #64748B;

    cursor: pointer;
}

.lineup-page .ev-modal-close:hover {

    background: #EEF2FF;

    color: var(--primary);
}


/* =========================================================
   MODAL FORM
========================================================= */

.lineup-page .ev-modal form {

    padding: 20px 24px 18px;
}

.lineup-page .ev-field {

    display: flex;

    flex-direction: column;

    margin-bottom: 16px;
}

.lineup-page .ev-label {

    display: flex;

    align-items: center;

    gap: 6px;

    margin-bottom: 7px;

    color: #0F172A;

    font-size: 13px;

    font-weight: 600;
}

.lineup-page .ev-label span {

    color: #EF4444;
}


/* =========================================================
   INPUT
========================================================= */

.lineup-page .ev-input,
.lineup-page .ev-textarea {

    width: 100%;

    border: 1px solid #E2E8F0;

    border-radius: 12px;

    background: #FFFFFF;

    color: #0F172A;

    font-family: inherit;

    font-size: 14px;

    transition: .25s;

    box-sizing: border-box;
}

.lineup-page .ev-input {

    height: 48px;

    padding: 0 14px;
}

.lineup-page .ev-textarea {

    min-height: 88px;

    height: 88px;

    padding: 12px 14px;

    line-height: 1.5;

    resize: vertical;
}

.lineup-page .ev-input:focus,
.lineup-page .ev-textarea:focus {

    outline: none;

    border-color: var(--primary);

    box-shadow:
        0 0 0 3px rgba(68, 149, 249, .08);
}

.lineup-page .ev-input::placeholder,
.lineup-page .ev-textarea::placeholder {

    color: #94A3B8;
}


/* =========================================================
   PHOTO
========================================================= */

.lineup-page .ev-lineup-photo-box {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 10px 12px;

    border: 1px solid #E2E8F0;

    border-radius: 12px;

    background: #F8FAFC;
}

.lineup-page .ev-lineup-photo-preview {

    width: 68px;
    height: 68px;

    flex: 0 0 68px;

    display: flex;

    align-items: center;
    justify-content: center;

    overflow: hidden;

    border-radius: 12px;

    background: #EEF5FF;

    border: 1px solid #E2E8F0;

    color: var(--primary);

    font-size: 22px;
}

.lineup-page .ev-lineup-photo-preview img {

    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}

.lineup-page .ev-lineup-photo-content {

    flex: 1;

    min-width: 0;

    display: flex;

    flex-direction: column;

    align-items: flex-start;
}

.lineup-page .ev-lineup-photo-button {

    height: 36px;

    display: inline-flex !important;

    align-items: center;

    gap: 7px;

    padding: 0 11px !important;

    border-radius: 8px !important;

    font-size: 12px !important;

    line-height: 1;
}

.lineup-page .ev-lineup-file-input {

    position: absolute;

    width: 1px;
    height: 1px;

    padding: 0;
    margin: -1px;

    overflow: hidden;

    clip: rect(0,0,0,0);

    white-space: nowrap;

    border: 0;
}

.lineup-page .ev-helper {

    margin-top: 5px;

    margin-bottom: 0;

    color: #94A3B8;

    font-size: 11px;

    line-height: 1.4;
}


/* =========================================================
   ERROR
========================================================= */

.lineup-page .ev-input.is-invalid,
.lineup-page .ev-textarea.is-invalid {

    border-color: #EF4444 !important;
}

.lineup-page .ev-error {

    display: none;

    margin-top: 5px;

    color: #EF4444;

    font-size: 11px;

    line-height: 1.4;
}

.lineup-page .ev-error.show {

    display: block;
}


/* =========================================================
   FOOTER
========================================================= */

.lineup-page .ev-modal-footer {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 8px;

    margin-top: 18px;

    padding-top: 16px;

    border-top: 1px solid #EEF2F7;
}

.lineup-page .ev-modal-footer .btn {

    height: 38px;

    min-width: 82px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 0 13px;

    border-radius: 9px;

    font-size: 12px;

    font-weight: 600;

    line-height: 1;
}

.lineup-page .ev-modal-footer .btn-primary {

    min-width: 120px;
}


/* =========================================================
   TOAST
========================================================= */

.lineup-page #lineupToastContainer {

    position: fixed;

    top: 24px;
    right: 24px;

    z-index: 11000;

    display: flex;

    flex-direction: column;

    gap: 10px;
}

.lineup-page .lineup-toast {

    min-width: 280px;

    padding: 13px 15px;

    border: 1px solid #E2E8F0;

    border-radius: 12px;

    background: #FFFFFF;

    box-shadow:
        0 14px 32px rgba(15, 23, 42, .12);

    animation: lineupToastIn .2s ease;
}

.lineup-page .lineup-toast-title {

    color: #0F172A;

    font-size: 12px;

    font-weight: 700;
}

.lineup-page .lineup-toast-message {

    margin-top: 3px;

    color: #64748B;

    font-size: 11px;

    line-height: 1.5;
}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes modalShow {

    from {

        opacity: 0;

        transform:
            translateY(20px)
            scale(.98);

    }

    to {

        opacity: 1;

        transform: none;

    }
}

@keyframes lineupToastIn {

    from {

        opacity: 0;

        transform: translateY(-8px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .lineup-page .page-header {

        flex-direction: column;
        align-items: stretch;
    }

    .lineup-page .page-header-right {

        width: 100%;
    }

    .lineup-page .page-header-right .btn {

        width: 100%;
    }

    .lineup-page .ev-lineup-grid {

        padding: 14px;

        gap: 14px;
    }

    .lineup-page .ev-lineup-card {

        padding: 16px;
    }

    .lineup-page .ev-lineup-card-photo {

        width: 68px;
        height: 68px;

        flex-basis: 68px;
    }

    .lineup-page .ev-modal-backdrop {

        padding: 12px;
    }

    .lineup-page .ev-modal {

        max-width: 100%;

        border-radius: 18px;
    }

    .lineup-page .ev-modal-header {

        padding: 18px 18px 16px;
    }

    .lineup-page .ev-modal form {

        padding: 18px;
    }

    .lineup-page .ev-lineup-photo-preview {

        width: 64px;
        height: 64px;

        flex-basis: 64px;
    }

    .lineup-page #lineupToastContainer {

        top: 15px;
        left: 15px;
        right: 15px;
    }

    .lineup-page .lineup-toast {

        width: 100%;
        min-width: 0;
    }

}
</style>


<div class="lineup-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="page-header">

        <div class="page-header-left">

            <h2 class="page-title">
                {{ $lineupFeature->label }}
            </h2>

            <p class="page-subtitle">
                Manage
                {{ strtolower($lineupFeature->label) }}
                for {{ $event->name }}.
            </p>

        </div>


        <div class="page-header-right">

            <button
                type="button"
                class="btn btn-primary"
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
            class="btn btn-primary"
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
                                class="btn btn-light ev-lineup-photo-button"
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
                        class="btn btn-light"
                        id="btnCancelLineup"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
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