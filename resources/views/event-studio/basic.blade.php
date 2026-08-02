@extends('event-studio.layouts.studio')

@section('content')

<!-- =======================================================
    BASIC INFORMATION
======================================================= -->

<div class="ev-section">

    <div class="ev-section-header">

        <div>

            <span class="ev-badge">
                Step 1
            </span>

            <h2 class="ev-title">
                Basic Information
            </h2>

            <p class="ev-subtitle">
                Start by introducing your event. Add a banner, event title and basic details that attendees will see first.
            </p>

        </div>

    </div>

</div>

<form id="basicForm">
    @csrf


<!-- =======================================================
    EVENT BANNER
======================================================= -->

<div class="ev-card">

    <div class="ev-card-header">

        <div class="ev-card-icon">

            <i class="fa-regular fa-image"></i>

        </div>

        <div>

            <h5>
                Event Banner
            </h5>

            <p>
                Upload an attractive cover image to increase attendee interest.
            </p>

        </div>

    </div>

    <div class="ev-banner-upload">

    <input
        type="file"
        id="banner"
        name="banner"
        accept="image/*"
        hidden>

    <label for="banner" class="ev-upload-box">

        <div class="ev-upload-preview">

            <img
                id="bannerPreview"
                src="{{ $event->image ? asset('storage/event-images/'.$event->image) : '' }}"
                alt="Banner Preview"
                @if(!$event->image) style="display:none;" @endif>

            <div
                id="bannerPlaceholder"
                @if($event->image) style="display:none;" @endif>

                <div class="ev-upload-icon">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>

                <h5>Upload Event Banner</h5>

                <p>
                    Drag & drop your image here or click to browse.
                </p>

                <span class="ev-upload-button">
                    Choose Image
                </span>

                <small>
                    Recommended size 1600 × 900 px
                </small>

            </div>

            <div
                id="bannerActions"
                class="ev-banner-actions"
                @if($event->image)
                    style="display:flex;"
                @else
                    style="display:none;"
                @endif>

                <label
                    for="banner"
                    class="btn-change-banner">

                    <i class="fa-solid fa-pen"></i>

                    Change Banner

                </label>

                <button
                    type="button"
                    id="removeBanner"
                    class="btn-remove-banner">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>

        </div>

    </label>

</div>

</div>

<!-- =========================================
     ADDITIONAL IMAGES
========================================= -->

<div class="ev-card">

    <div class="ev-section-title">

        <div>

            <h5>Additional Images</h5>

            <p>
                Add optional images such as posters, lineup, venue, sponsors, or other supporting visuals.
            </p>

        </div>

    </div>

    <div id="galleryWrapper" class="ev-gallery">

    @foreach($event->images as $image)

        <div
            class="ev-gallery-item"
            data-id="{{ $image->id }}">

            <img
                src="{{ asset('storage/event-gallery/'.$image->image) }}"
                alt="Gallery">

            <button
                type="button"
                class="ev-gallery-remove">

                <i class="fa-solid fa-times"></i>

            </button>

        </div>

    @endforeach

    <label class="ev-gallery-add">

        <input
            id="galleryInput"
            type="file"
            name="images[]"
            accept="image/*"
            multiple
            hidden>

        <i class="fa-solid fa-plus"></i>

        <span>Add Image</span>

    </label>

</div>

</div>



<div class="ev-card">

    <div class="ev-card-header">

        <div class="ev-card-icon">

            <i class="fa-solid fa-pen-to-square"></i>

        </div>

        <div>

            <h5>Event Information</h5>

            <p>
                Give your event a memorable name and unique public URL.
            </p>

        </div>

    </div>

    <!-- Event Name -->

    <div class="ev-form-group">

        <label>

            Event Name

            <span>*</span>

        </label>

        <input
            type="text"
            id="name"
            name="title"
            class="ev-input"
            placeholder="Example: Tech Innovation Summit 2026"
            value="{{ $event->title }}"
            >


    </div>


<!-- =========================================
    EVENT CATEGORY
========================================= -->
<div class="ev-form-group">

    <label class="ev-label">

        Kategori Event <span>*</span>

    </label>

    <select id="category_id" name="category_id">

        @foreach($categories as $category)

            <option
                value="{{ $category->id }}"
                @selected(old('category_id', $event->category_id ?? null) == $category->id)>

                {{ $category->name }}

            </option>

        @endforeach

    </select>


</div>

    <!-- URL -->

    <div class="ev-form-group">

        <label>

            Event URL

            <span>*</span>

        </label>

        <div class="ev-url-input">

            <div class="ev-url-prefix">

                eventverse.id/

            </div>

            <input
                type="text"
                id="slug"
                name="slug"
                class="ev-input-url"
                placeholder="tech-innovation-summit" value="{{ $event->slug }}">

        </div>

    </div>

    <div class="ev-url-preview">

        <div id="slugAlert" class="ev-url-status info">

    <span id="slugStatus">
        <i class="fa-solid fa-circle-info"></i> URL akan dibuat otomatis
    </span>

</div>

        <div id="urlPreview">

            https://eventverse.id/{{ $event->slug }}

        </div>

    </div>

</div>


<div class="ev-card">

    <div class="ev-card-header">

        <div class="ev-card-icon">

            <i class="fa-solid fa-users"></i>

        </div>

        <div>

            <h5>Organizer</h5>

            <p>
                Choose who will be responsible for managing this event.
            </p>

        </div>

    </div>

    <label class="ev-label">
    Penyelenggara Acara <span>*</span>
</label>

<div class="ev-organizer-grid">

    <!-- INDIVIDU -->
    <label class="ev-organizer-card">

        <input
            type="radio"
            name="organizer"
            value="individual"
            {{ ($event->organizer ?? 'individual') == 'individual' ? 'checked' : '' }}>

        <div class="ev-organizer-content">

            <div class="ev-organizer-icon personal">
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="ev-organizer-body">

                <h5>Single</h5>

                <p>Buat dengan akun pribadi</p>

            </div>

            <div class="ev-organizer-check">

                <i class="fas fa-check-circle"></i>

            </div>

        </div>

    </label>

    <!-- ORGANISASI -->

    <label class="ev-organizer-card">

        <input
            type="radio"
            name="organizer"
            value="org"
            {{ $event->organizer == 'org' ? 'checked' : '' }}>

        <div class="ev-organizer-content">

            <div class="ev-organizer-icon organization">

                <i class="fas fa-building"></i>

            </div>

            <div class="ev-organizer-body">

                <h5>Team</h5>

                <p>Buat dengan akun organisasi</p>

            </div>

            <div class="ev-organizer-check">

                <i class="fas fa-check-circle"></i>

            </div>

        </div>

    </label>

</div>


<!-- PERSONAL -->

<div
    id="personalWrapper"
    style="{{ $event->organizer == 'org' ? 'display:none' : '' }}">

    <label class="ev-label">

        Penanggung Jawab

    </label>

    <div class="ev-account-card">

        <div class="ev-avatar">

            {{ strtoupper(substr(Auth::user()->name,0,1)) }}

        </div>

        <div>

            <strong>{{ Auth::user()->name }}</strong>

            <small>Akun pribadi</small>

        </div>

    </div>

</div>


<!-- ORGANIZATION -->

<div
    id="organizationWrapper"
    style="{{ $event->organizer == 'org' ? '' : 'display:none' }}">

    <label class="ev-label">

        Pilih Organisasi <span>*</span>

    </label>

    <div class="ev-select-icon">
        <i class="fas fa-building"></i>

        <select
            id="organization_id"
            name="organization_id"
            class="ev-choices">

            <option value="">Pilih Organisasi</option>

            @foreach($organizations as $organization)

                <option
                    value="{{ $organization->org_id }}"
                    {{ $event->organizer == 'org' && $event->organizer_id == $organization->org_id ? 'selected' : '' }}>

                    {{ $organization->org->org_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="ev-org-helper">

        <div class="ev-org-icon">

            <i class="fas fa-users"></i>

        </div>

        <div class="ev-org-content">

            <strong>Belum punya organisasi?</strong>

            <p>
                Daftarkan organisasi atau bergabung dengan organisasi yang sudah ada.
            </p>

        </div>

        <div class="ev-org-action">

            <a href="" class="btn btn-primary">

                Buat Organisasi

            </a>

            <a href="" class="btn btn-light">

                Gabung

            </a>

        </div>

    </div>

</div>

</form>

@include('event-studio.components.modal-confirm')

<style>
    /* =====================================================
    SECTION HEADER
===================================================== */

.ev-section{

    margin-bottom:34px;

}

.ev-badge{

    display:inline-flex;

    align-items:center;

    padding:8px 16px;

    border-radius:999px;

    background:#EEF5FF;

    color:#4F8CFF;

    font-size:.78rem;

    font-weight:700;

    margin-bottom:18px;

}

.ev-title{

    font-size:2.3rem;

    font-weight:800;

    color:#0F172A;

    margin-bottom:10px;

}

.ev-subtitle{

    color:#64748B;

    max-width:650px;

    line-height:1.7;

}


/* =====================================================
    CARD
===================================================== */

.ev-card{

    background:#fff;

    border:1px solid #E7EDF5;

    border-radius:24px;

    padding:28px;

    box-shadow:0 10px 30px rgba(15,23,42,.04);

    margin-bottom:28px;

}

.ev-card-header{

    display:flex;

    align-items:center;

    gap:18px;

    margin-bottom:28px;

}

.ev-card-header h5{

    margin:0;

    font-size:1.15rem;

    font-weight:700;

    color:#0F172A;

}

.ev-card-header p{

    margin:6px 0 0;

    color:#64748B;

    font-size:.92rem;

}

.ev-card-icon{

    width:58px;

    height:58px;

    border-radius:18px;

    background:linear-gradient(135deg,#EEF5FF,#DDEAFF);

    display:flex;

    justify-content:center;

    align-items:center;

    color:#4F8CFF;

    font-size:22px;

}


/* =====================================================
    BANNER
===================================================== */

.ev-upload-box{

    display:block;

    cursor:pointer;

}

.ev-upload-preview{

    position:relative;

    overflow:hidden;

}

.ev-upload-preview:hover{

    border-color:#4F8CFF;

    background:#F7FAFF;

}

.ev-upload-preview img{

    display:block;

    width:100%;

    height:420px;

    object-fit:cover;

    border-radius:20px;

}

.ev-banner-actions{

    position:absolute;

    top:18px;

    right:18px;

    display:flex;

    gap:10px;

}

.btn-change-banner{

    padding:10px 18px;

    border-radius:12px;

    background:rgba(255,255,255,.95);

    color:#0F172A;

    font-weight:600;

    cursor:pointer;

    margin:0;

    box-shadow:0 6px 18px rgba(0,0,0,.08);

}

.btn-remove-banner{

    width:46px;

    height:46px;

    border:none;

    border-radius:12px;

    background:white;

    cursor:pointer;

    color:#EF4444;

    box-shadow:0 6px 18px rgba(0,0,0,.08);

}

.btn-change-banner:hover,
.btn-remove-banner:hover{

    transform:translateY(-2px);

}

#bannerPlaceholder{

    padding:70px 30px;

    text-align:center;

}

.ev-upload-icon{

    width:76px;

    height:76px;

    border-radius:22px;

    margin:auto;

    margin-bottom:20px;

    display:flex;

    justify-content:center;

    align-items:center;

    background:linear-gradient(135deg,#EEF5FF,#DDEAFF);

    color:#4F8CFF;

    font-size:28px;

}

.ev-upload-button{

    display:inline-block;

    margin-top:20px;

    padding:12px 24px;

    border-radius:14px;

    background:linear-gradient(135deg,#4F8CFF,#6B63FF);

    color:#fff;

    font-weight:600;

}

#bannerPlaceholder small{

    display:block;

    margin-top:16px;

    color:#94A3B8;

}


/* =====================================================
    MOBILE
===================================================== */

@media(max-width:767px){

.ev-card{

    padding:20px;

}

.ev-title{

    font-size:1.8rem;

}

#bannerPlaceholder{

    padding:45px 18px;

}

.ev-upload-icon{

    width:64px;

    height:64px;

    font-size:24px;

}

}

/* ==========================================
   GALLERY
========================================== */

.ev-gallery{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(170px,1fr));

    gap:18px;

}

.ev-gallery-item{

    position:relative;

    aspect-ratio:1;

    border-radius:18px;

    overflow:hidden;

    border:1px solid #E2E8F0;

    background:#F8FAFC;

}

.ev-gallery-item img{

    width:100%;

    height:100%;

    object-fit:cover;

}

.ev-gallery-remove{

    position:absolute;

    top:10px;

    right:10px;

    width:34px;

    height:34px;

    border:none;

    border-radius:50%;

    background:rgba(15,23,42,.75);

    color:#FFF;

    cursor:pointer;

}

.ev-gallery-add{

    aspect-ratio:1;

    border:2px dashed #CBD5E1;

    border-radius:18px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    gap:10px;

    cursor:pointer;

    transition:.25s;

    color:#64748B;

    background:#FFF;

}

.ev-gallery-add:hover{

    border-color:var(--primary);

    background:#F8FAFF;

    color:var(--primary);

}

.ev-gallery-add i{

    font-size:28px;

}



//kkk

.ev-form-group{

    margin-bottom:24px;
    margin-top: 20px;

}

.ev-form-group label{

    display:block;

    font-weight:700;

    margin-bottom:10px;

    color:#0F172A;

}

.ev-form-group span{

    color:#EF4444;

}

.ev-input{

    width:100%;

    height:58px;

    border:1px solid #E2E8F0;

    border-radius:16px;

    padding:0 18px;

    font-size:15px;

    transition:.25s;

}

.ev-input:focus{

    border-color:#4F8CFF;

    box-shadow:0 0 0 4px rgba(79,140,255,.08);

    outline:none;

}

.ev-url-input{

    display:flex;

    border:1px solid #E2E8F0;

    border-radius:16px;

    overflow:hidden;

    transition:.25s;

}

.ev-url-input:focus-within{

    border-color:#4F8CFF;

    box-shadow:0 0 0 4px rgba(79,140,255,.08);

}

.ev-url-prefix{

    background:#F8FAFC;

    border-right:1px solid #E2E8F0;

    padding:0 18px;

    display:flex;

    align-items:center;

    color:#64748B;

    font-weight:600;

}

.ev-input-url{

    flex:1;

    border:none;

    height:58px;

    padding:0 18px;

    outline:none;

}

.ev-url-preview{

    margin-top:20px;

    padding:18px;

    border-radius:16px;

    background:#F8FAFC;

    border:1px solid #E2E8F0;

}

.ev-url-status{

    display:flex;

    align-items:center;

    gap:10px;

    margin-bottom:10px;

    font-size:.92rem;

    font-weight:600;

}

.ev-url-status.success{

    color:#10B981;

}

.ev-url-status.error{

    color:#EF4444;

}

.ev-url-status.checking{

    color:#F59E0B;

}

.ev-url-status.info{

    color:#64748B;

}

#urlPreview{

    color:#334155;

    word-break:break-all;

}

/* =========================================
   LABEL
========================================= */

.ev-label{
    display:block;
    margin-bottom:14px;
    font-size:15px;
    font-weight:700;
    color:#1E293B;
}

.ev-label span{
    color:#EF4444;
}

/* =========================================
   GRID
========================================= */

.ev-organizer-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
    margin-bottom:28px;
}

/* =========================================
   RADIO
========================================= */

.ev-organizer-card{
    cursor:pointer;
    display:block;
}

.ev-organizer-card input[type="radio"]{
    position:absolute;
    opacity:0;
    pointer-events:none;
}

/* =========================================
   CARD
========================================= */

.ev-organizer-content{

    display:flex;
    align-items:center;
    gap:18px;

    min-height:50px;

    padding:17px;

    border:1px solid #D9E2F1;
    border-radius:22px;

    background:#FFF;

    transition:.25s;

}

.ev-organizer-card:hover .ev-organizer-content{

    border-color:#4F6EF7;

}

.ev-organizer-card input:checked + .ev-organizer-content{

    border:2px solid #4F6EF7;

    background:#F7F9FF;

    box-shadow:0 10px 28px rgba(79,110,247,.08);

}

/* =========================================
   ICON
========================================= */

.ev-organizer-icon{

    width:74px;
    height:74px;

    border-radius:20px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex-shrink:0;

    font-size:30px;

}

.ev-organizer-icon.personal{

    background:#EEF4FF;
    color:#4F6EF7;

}

.ev-organizer-icon.organization{

    background:#ECFDF3;
    color:#16A34A;

}

/* =========================================
   TEXT
========================================= */

.ev-organizer-body{

    flex:1;

}

.ev-organizer-body h5{

    margin:0;

    font-size:20px;
    font-weight:700;

    color:#0F172A;

}

.ev-organizer-body p{

    margin:4px 0 0;

    color:#64748B;

    font-size:15px;

    line-height:1.5;

}

/* =========================================
   CHECK
========================================= */

.ev-organizer-check{

    width:38px;
    height:38px;

    border-radius:50%;

    background:#CBD5E1;

    display:flex;
    justify-content:center;
    align-items:center;

    color:#FFF;

    flex-shrink:0;

    font-size:18px;

    transition:.25s;

}

.ev-organizer-card input:checked + .ev-organizer-content .ev-organizer-check{

    background:#4F46E5;

}

/* =========================================
   ACCOUNT
========================================= */

.ev-account-card{

    display:flex;
    align-items:center;
    gap:18px;

    padding:22px;

    border:1px solid #D9E2F1;
    border-radius:22px;

    background:#FFF;

}

.ev-avatar{

    width:64px;
    height:64px;

    border-radius:50%;

    background:#EEF4FF;
    color:#4F46E5;

    display:flex;
    align-items:center;
    justify-content:center;

    font-weight:700;

    font-size:22px;

    flex-shrink:0;

}

.ev-account-card strong{

    display:block;

    font-size:18px;

    color:#0F172A;

}

.ev-account-card small{

    display:block;

    margin-top:4px;

    color:#64748B;

    font-size:14px;

}

/* =========================================
   SELECT
========================================= */

.ev-select-icon{
    position:relative;
    margin-bottom: 20px;
}

.ev-select-icon > i{

    position:absolute;

    left:22px;

    top:50%;

    transform:translateY(-50%);

    color:#5B5CE6;

    font-size:20px;

    z-index:5;

    pointer-events:none;

}

.ev-select-icon .choices{

    width:100%;

}

.ev-select-icon .choices__inner{

    padding-left:60px !important;

}

/* =========================================
   HELPER
========================================= */

.ev-org-helper{

    display:flex;
    align-items:center;

    gap:18px;

    padding:20px;

    border:1px solid #DCE8FF;
    border-radius:22px;

    background:#F8FAFF;

}

.ev-org-icon{

    width:62px;
    height:62px;

    border-radius:18px;

    background:#EEF4FF;

    color:#4F46E5;

    display:flex;
    justify-content:center;
    align-items:center;

    flex-shrink:0;

    font-size:24px;

}

.ev-org-content{

    flex:1;

}

.ev-org-content strong{

    display:block;

    font-size:18px;

    color:#0F172A;

}

.ev-org-content p{

    margin:6px 0 0;

    color:#64748B;

    font-size:14px;

    line-height:1.5;

}

.ev-org-action{

    display:flex;
    gap:10px;

    flex-shrink:0;

}

.ev-org-action .btn{

    display:flex;
    align-items:center;
    justify-content:center;

    height:44px;
    min-width:170px;

    padding:0 24px;

    line-height:1;

    font-size:15px;
    font-weight:600;

    border-radius:999px;

}
/* =========================================
   MOBILE
========================================= */

@media(max-width:768px){

    .ev-organizer-grid{

        grid-template-columns:1fr;

    }

    .ev-organizer-content{

        min-height:90px;

        padding:18px;

    }

    .ev-organizer-icon{

        width:58px;
        height:58px;

        font-size:22px;

        border-radius:16px;

    }

    .ev-organizer-body h5{

        font-size:17px;

    }

    .ev-organizer-body p{

        font-size:13px;

    }

    .ev-org-helper{

        flex-direction:column;

        align-items:flex-start;

    }

    .ev-org-action{

        width:100%;

    }

    .ev-org-action .btn{

        flex:1;

    }

}

/* ===================================
    SELECT MODERN
=================================== */

/* ===================================
   CHOICES
=================================== */



</style>

<script>

    const bannerInput = document.getElementById("banner");
    const bannerPreview = document.getElementById("bannerPreview");
    const bannerPlaceholder = document.getElementById("bannerPlaceholder");
    const bannerActions = document.getElementById("bannerActions");
    const removeBanner = document.getElementById("removeBanner");

    bannerInput.addEventListener("change", async function () {

        if (!this.files.length) return;

        const file = this.files[0];

        /* ==========================
        Preview
        ========================== */

        const reader = new FileReader();

        reader.onload = function (e) {

            bannerPreview.src = e.target.result;

            bannerPreview.style.display = "block";

            bannerPlaceholder.style.display = "none";

            bannerActions.style.display = "flex";

        };

        reader.readAsDataURL(file);

        /* ==========================
        Upload
        ========================== */

        const formData = new FormData();

        formData.append("banner", file);

        Studio.showStatus(
            "Saving",
            "Uploading event banner..."
        );

        try{

            const { ok, data } = await Studio.request(
                "{{ route('event-studio.banner', $event->event_id) }}",
                {
                    method: "POST",
                    body: formData
                }
            );

            if (!ok) {

                Studio.showStatus(
                    "Failed",
                    data?.message ?? "Failed to upload event banner."
                );

                return;

            }

            Studio.showStatus(
                "Saved",
                "Event banner uploaded successfully.",
                "Banner Updated"
            );

        }catch(err){

            console.error(err);

            Studio.showStatus(
                "Failed",
                "Upload banner gagal."
            );

        }

    });

    removeBanner.addEventListener("click", () => {

    Studio.confirm({

        title: "Delete Banner?",

        description: "This banner will be permanently removed from your event.",

        button: "Delete Banner",

        onConfirm: async () => {

            Studio.showStatus(
                "Saving",
                "Removing event banner..."
            );

            try {

                const { ok, data } = await Studio.request(
                    "{{ route('event-studio.banner.delete', $event->event_id) }}",
                    {
                        method: "DELETE"
                    }
                );

                if (!ok) {

                    Studio.showStatus(
                        "Failed",
                        data?.message ?? "Failed to remove event banner."
                    );

                    return;

                }

                bannerInput.value = "";
                bannerPreview.src = "";
                bannerPreview.style.display = "none";

                bannerPlaceholder.style.display = "block";
                bannerActions.style.display = "none";

                Studio.showStatus(
                    "Saved",
                    "Event banner removed successfully."
                );

            } catch (e) {

                console.error(e);

                Studio.showStatus(
                    "Failed",
                    "Unable to remove banner."
                );

            }

        }

    });

});




    const eventName=document.getElementById("name");
    const slug=document.getElementById("slug");
    const urlPreview=document.getElementById("urlPreview");
    const slugStatus=document.getElementById("slugStatus");
    let slugEdited = slug.value.trim() !== "";

    eventName.addEventListener("input", () => {

        // Jika slug sudah pernah ada, jangan ubah lagi
        if (slugEdited) {
            return;
        }

        slug.value = eventName.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-");

        updateSlug();

    });

    slug.addEventListener("input", () => {

        // User mulai mengedit slug sendiri
        slugEdited = slug.value.trim() !== "";

        updateSlug();

    });

    slug.addEventListener("keyup",updateSlug);

    // Tambahkan ini
    let timer = null;
    function updateSlug(){

        // Ganti spasi menjadi -
        slug.value = slug.value.replace(/\s+/g, "-");

        const value = slug.value;

        urlPreview.textContent = "https://eventverse.id/" + value;

        clearTimeout(timer);

        if(value === ""){

            slugStatus.innerHTML =
                '<i class="fa-solid fa-circle-info"></i> URL akan dibuat otomatis';

            slugStatus.className = "ev-url-status info";

            return;

        }

        slugStatus.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Memeriksa URL...';

        slugStatus.className = "ev-url-status checking";

        timer = setTimeout(() => {

            checkSlug(value);

        }, 500);

    }
    function checkSlug(slug){

        fetch("/url-check?url=" + encodeURIComponent(slug))
            .then(response => response.json())
            .then(res => {

                if(res.result == 0){

                    slugStatus.innerHTML =
                        '<i class="fa-solid fa-circle-check"></i> URL tersedia';

                    slugStatus.className = "ev-url-status success";

                }else if(res.result == 'N'){

                    slugStatus.innerHTML =
                        '<i class="fa-solid fa-circle-info"></i> Masukkan URL event';

                    slugStatus.className = "ev-url-status info";

                }else{

                    slugStatus.innerHTML =
                        '<i class="fa-solid fa-circle-xmark"></i> URL sudah digunakan';

                    slugStatus.className = "ev-url-status error";

                }

            })
            .catch((error) => {

                console.error(error);

                slugStatus.innerHTML =
                    '<i class="fa-solid fa-triangle-exclamation"></i> Gagal memeriksa URL';

                slugStatus.className = "ev-url-status error";

            });

    }

    const individualRadio = document.querySelector('input[name="organizer"][value="individual"]');
    const orgRadio = document.querySelector('input[name="organizer"][value="org"]');

    const personalWrapper = document.getElementById("personalWrapper");
    const organizationWrapper = document.getElementById("organizationWrapper");

    function toggleOrganizer() {

        if (individualRadio.checked) {

            personalWrapper.style.display = "block";
            organizationWrapper.style.display = "none";

        } else {

            personalWrapper.style.display = "none";
            organizationWrapper.style.display = "block";

        }

    }

    document.querySelectorAll('input[name="organizer"]').forEach(item => {

        item.addEventListener("change", toggleOrganizer);

    });

    toggleOrganizer();


    // kategori

    document.addEventListener("DOMContentLoaded", function () {

        [
            "category_id",
            "organization_id"
        ].forEach(id => {

            const element = document.getElementById(id);

            if (element && window.Choices) {

                new Choices(element, {
                    searchEnabled: true,
                    itemSelectText: "",
                    shouldSort: false
                });

            }

        });

    });

//OPTIONAL IMAGE
const galleryInput = document.getElementById("galleryInput");
const galleryWrapper = document.getElementById("galleryWrapper");

const dt = new DataTransfer();

/*
|--------------------------------------------------------------------------
| Upload
|--------------------------------------------------------------------------
*/

galleryInput.addEventListener("change", async function () {

    if (!this.files.length) return;

    const formData = new FormData();

    [...this.files].forEach(file => {

        formData.append("images[]", file);

    });

    Studio.showStatus(
        "Saving",
        `Uploading ${this.files.length} image(s)...`
    );

    try{

        const { ok, data } = await Studio.request(
            "{{ route('event-studio.gallery', $event->event_id) }}",
            {
                method: "POST",
                body: formData
            }
        );

        if (!ok) {

            Studio.showStatus(
                "Failed",
                data?.message ?? "Failed to upload gallery."
            );

            return;

        }

        data.images.forEach(item => {

            createPreview(item);

        });

        Studio.showStatus(
            "Saved",
            `${data.images.length} image(s) uploaded successfully.`,
            "Gallery Updated"
        );


    }catch(e){

        console.error(e);

        Studio.showStatus(
            "Failed",
            "Upload gallery failed."
        );

    }

    galleryInput.value="";

});

/*
|--------------------------------------------------------------------------
| Preview
|--------------------------------------------------------------------------
*/

function createPreview(image){

    const card=document.createElement("div");

    card.className="ev-gallery-item";

    card.dataset.id=image.id;

    card.innerHTML=`
        <img src="${image.image}" alt="">

        <button
            type="button"
            class="ev-gallery-remove">

            <i class="fa-solid fa-times"></i>

        </button>
    `;

    card.querySelector(".ev-gallery-remove")
        .onclick=()=>removeImage(card);

    galleryWrapper.insertBefore(
        card,
        galleryWrapper.querySelector(".ev-gallery-add")
    );

}

/*
|--------------------------------------------------------------------------
| Remove
|--------------------------------------------------------------------------
*/

async function removeImage(card){

    if(!confirm("Delete this image?")){
        return;
    }

    Studio.showStatus(
        "Saving",
        "Removing image..."
    );

    try{

        const { ok, data } = await Studio.request(

            `/event-studio/{{ $event->event_id }}/gallery/${card.dataset.id}`,

            {
                method: "DELETE"
            }

        );

        if (!ok) {

            Studio.showStatus(
                "Failed",
                data?.message ?? "Failed to remove image."
            );

            return;

        }

        card.remove();

        Studio.showStatus(
            "Saved",
            "Image removed successfully.",
            "Gallery Updated"
        );

    }catch(e){

        console.error(e);

        Studio.showStatus(
            "Failed",
            "Delete failed."
        );

    }

}

document.querySelectorAll(".ev-gallery-remove").forEach(button => {

    button.addEventListener("click", function(){

        removeImage(
            this.closest(".ev-gallery-item")
        );

    });

});



//save

window.beforeLeave = async function(){

    return await saveBasic();

}

</script>

@push('scripts')
<script>

Studio.initAutoSave({

    form: "#basicForm",

    section: "basic",

    endpoint: "{{ route('event-studio.autosave', $event->event_id) }}"

});

</script>
@endpush

@endsection



