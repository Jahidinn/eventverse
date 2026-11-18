@extends('event-studio.layouts.studio')

@section('content')
    <!-- =======================================================
        BASIC INFORMATION
    ======================================================= -->
    <p class="ev-event-badge is-blue">{{ $event->title ?: 'Untitled event' }}</p>
    <div class="ev-page-header is-blue">
        <div class="ev-page-title-row">
            <div class="ev-page-icon">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="ev-page-title-copy">
                <h2 class="ev-title">Event <span class="accent">essentials</span></h2>
                <p class="ev-subtitle">Identity, cover and organizer.</p>
            </div>
        </div>
    </div>

    <form id="basicForm">
        @csrf


    <!-- =======================================================
        EVENT BANNER
    ======================================================= -->

    <div class="ev-card is-blue">
        <div class="ev-card-header">
            <div class="ev-card-icon">
                <i class="fa-regular fa-image"></i>
            </div>
            
            <div>
                <h5>Event Banner</h5>
            </div>
        </div>

        <div class="ev-banner-upload">
            <input type="file" id="banner" name="banner" accept="image/*" hidden>
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

    <div class="ev-card is-cyan">

        <div class="ev-card-header">
            <div class="ev-card-icon is-cyan">
                <i class="fa-regular fa-images"></i>
            </div>
            
            <div>
                <h5>Additional images</h5>
            </div>
        </div>

        <div id="galleryWrapper" class="ev-gallery">
            @foreach($event->images as $image)
                <div class="ev-gallery-item" data-id="{{ $image->id }}">
                    <img src="{{ asset('storage/event-gallery/'.$image->image) }}" alt="Gallery">

                    <button type="button" class="ev-gallery-remove">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

            @endforeach

            <label class="ev-gallery-add">
                <input id="galleryInput" type="file" name="images[]" accept="image/*" multiple hidden>
                <i class="fa-solid fa-plus"></i>
                <span>Add Image</span>
            </label>
        </div>

    </div>


    <!-- EVENT INFORMATION -->

    <div class="ev-card is-blue">
        <div class="ev-card-header">
            <div class="ev-card-icon">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>

            <div>
                <h5>Event Information</h5>
            </div>
        </div>

        <!-- Event Name -->

        <div class="ev-form-group">
            <label class="ev-label">Event Name <span>*</span>
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

            <label class="ev-label">

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


<div class="ev-card is-green">

    <div class="ev-card-header">

        <div class="ev-card-icon is-green">

            <i class="fa-solid fa-users"></i>

        </div>

        <div>

            <h5>Organizer</h5>


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

            <a href="" class="ev-btn ev-btn-primary">

                Buat Organisasi

            </a>

            <a href="" class="ev-btn ev-btn-secondary">

                Gabung

            </a>

        </div>

    </div>

</div>

</form>

@include('event-studio.components.modal-confirm')


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



