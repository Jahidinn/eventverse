<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Eventverse Event Studio — build, manage, and publish your event.">

    <title>@yield('title', ($currentStep['label'] ?? 'Event Studio') . ' · ' . ($event->title ?? 'Eventverse')) | Eventverse.id</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Plus+Jakarta+Sans:wght@600;700;800&amp;display=swap" rel="stylesheet">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/eventverse-icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/eventverse-apple-icon.png') }}" rel="apple-touch-icon">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/dist/tabler-icons.min.css">

    <!-- Studio libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="https://unpkg.com/trix@2.1.15/dist/trix.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/studio.css') }}">

</head>

<body>

@php
    $eventId = request()->route('event_id');
    $routeName = request()->route()?->getName();

    $lineupFeature = null;
    if ($event->category) {
        $lineupFeature = $event->category->features
            ->where('feature', 'lineup')
            ->where('is_enabled', true)
            ->first();
    }

    $navSteps = [
        [
            'group' => 'setup',
            'key' => 'basic',
            'route' => 'event-studio.basic',
            'label' => 'Basic',
            'accent' => 'blue',
            'icon' => 'ti-menu-deep',
            'pattern' => 'event-studio/*/basic*',
            'url' => route('event-studio.basic', $eventId),
        ],
        [
            'group' => 'setup',
            'key' => 'detail',
            'route' => 'event-studio.detail',
            'label' => 'Details',
            'accent' => 'sky',
            'icon' => 'ti-file-description',
            'pattern' => 'event-studio/*/detail*',
            'url' => route('event-studio.detail', $eventId),
        ],
        [
            'group' => 'setup',
            'key' => 'ticket',
            'route' => 'event-studio.ticket',
            'label' => 'Tickets',
            'accent' => 'amber',
            'icon' => 'ti-ticket',
            'pattern' => 'event-studio/*/ticket*',
            'url' => route('event-studio.ticket', $eventId),
        ],
        [
            'group' => 'setup',
            'key' => 'facilities',
            'route' => 'event-studio.facilities',
            'label' => 'Facilities',
            'accent' => 'green',
            'icon' => 'ti-building-plus',
            'pattern' => 'event-studio/*/facilities*',
            'url' => route('event-studio.facilities', $eventId),
        ],
    ];

    if ($lineupFeature) {
        $navSteps[] = [
            'group' => 'setup',
            'key' => 'line-up',
            'route' => 'event-studio.line-up',
            'label' => $lineupFeature->label,
            'accent' => 'sky',
            'icon' => 'ti-user-up',
            'pattern' => 'event-studio/*/line-up*',
            'url' => route('event-studio.line-up', $eventId),
        ];
    }

    $navSteps[] = [
        'group' => 'setup',
        'key' => 'form',
        'route' => 'event-studio.form',
        'label' => 'Form',
            'accent' => 'blue',
            'icon' => 'ti-clipboard-text',
        'pattern' => 'event-studio/*/form*',
        'url' => route('event-studio.form', $eventId),
    ];

    $navSteps[] = [
        'group' => 'publish',
        'key' => 'preview',
        'route' => 'event-studio.preview',
        'label' => 'Publish',
            'accent' => 'green',
            'icon' => 'ti-checklist',
        'pattern' => 'event-studio/*/preview*',
        'url' => route('event-studio.preview', $eventId),
    ];

    foreach ($navSteps as &$step) {
        $step['active'] = Request::is($step['pattern']);
    }
    unset($step);

    $currentStep = collect($navSteps)->firstWhere('route', $routeName)
        ?? ['label' => 'Event Studio', 'key' => 'studio'];

@endphp

<div class="studio">

    <!-- ================= SIDEBAR ================= -->
    <aside id="sidebar" class="sidebar" aria-label="Event Studio navigation">

        <div class="sidebar-top">
            <a href="/dashboard" class="logo studio-menu-link" aria-label="Eventverse dashboard">
                <img
                    src="{{ asset('assets/img/eventverse-color.png') }}"
                    alt="Eventverse"
                    class="logo-image">
            </a>
        </div>

        <nav class="sidebar-menu" aria-label="Event setup steps">
            @php $lastGroup = null; @endphp

            @foreach($navSteps as $step)
                @if($lastGroup !== null && $lastGroup !== $step['group'])
                    <div class="menu-divider" aria-hidden="true"></div>
                @endif

                <a
                    href="{{ $step['url'] }}"
                    class="menu-item studio-menu-link {{ $step['active'] ? 'active' : '' }}"
                    @if($step['active']) aria-current="page" @endif
                >
                    <div class="menu-left">
                        <div class="menu-icon is-{{ $step['accent'] }}">
                            <i class="ti {{ $step['icon'] }}"></i>
                        </div>
                    </div>

                    <div class="menu-content">
                        <span class="menu-title">{{ $step['label'] }}</span>
                    </div>
                </a>

                @php $lastGroup = $step['group']; @endphp
            @endforeach
        </nav>

        <div class="sidebar-bottom">
            <a href="/dashboard" class="dashboard-btn studio-menu-link">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </aside>

    <!-- ================= CONTENT ================= -->
    <main class="content">

        <header class="studio-header">
            <div class="header-left">
                <button
                    id="sidebarToggle"
                    type="button"
                    aria-label="Open navigation"
                    aria-controls="sidebar"
                    aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="header-copy">
                    <div class="header-title-row">
                        <h1 class="header-title">EVENT STUDIO</h1>
                        <span class="header-status is-{{ $event->event_status ?: 'draft' }}">
                            {{ ucfirst($event->event_status ?: 'draft') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="header-right header-actions">
                @if($routeName === 'event-studio.preview')
                    <a
                        href="{{ route('event.show', $event) }}"
                        target="_blank"
                        rel="noopener"
                        class="ev-btn ev-btn-primary"
                        aria-label="Preview public event page">
                        <i class="fa-regular fa-eye"></i>
                        <span>Preview</span>
                    </a>
                @else
                    <a
                        href="{{ route('event-studio.preview', $eventId) }}"
                        class="ev-btn ev-btn-primary studio-menu-link"
                        aria-label="Preview event">
                        <i class="fa-regular fa-eye"></i>
                        <span>Preview</span>
                    </a>
                @endif
            </div>
        </header>

        <div id="saveIndicator" class="ev-save-bar idle" role="status" aria-live="polite">
            <div class="ev-save-left">
                <i id="saveIcon" class="fa-solid fa-circle-check"></i>
                <div>
                    <strong id="saveTitle">All changes saved</strong>
                    <span id="saveStatus">Your latest changes have been saved automatically.</span>
                </div>
            </div>
        </div>

        <div class="studio-page">
            @yield('content')
        </div>
    </main>
</div>

@stack('modals')

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://unpkg.com/trix@2.1.15/dist/trix.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
class EventVerseStudio {


    async request(url, options = {}) {

    if (typeof url === "object") {
        options = url;
        url = options.url;
    }

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        ?.content;

    // Jika menggunakan data -> ubah menjadi JSON
    if (options.data !== undefined) {

        options.body = JSON.stringify(options.data);

        delete options.data;

    }

    const headers = {

        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": csrf,

        ...(options.headers || {})

    };

    // Hanya JSON yang diberi Content-Type
    if (!(options.body instanceof FormData)) {

        headers["Content-Type"] = "application/json";

    }

    const response = await fetch(url, {

        ...options,

        headers

    });

    let data = null;

    try {

        data = await response.json();

    } catch (e) {}

    return {

        ok: response.ok,
        status: response.status,
        data

    };

}



    constructor() {

        // Sidebar
        this.sidebar = document.getElementById("sidebar");
        this.toggle = document.getElementById("sidebarToggle");
        this.menuItems = document.querySelectorAll(".studio-menu-link");

        this.overlay = null;

        // Auto Save
        this.autoSave = {
            form: null,
            endpoint: null,
            section: null,
            isDirty: false,
            timer: null,
            saving: false
        };

        this.init();

    }

    init() {

        this.createOverlay();
        this.bindToggle();
        this.bindMenu();

        document.addEventListener("keydown", (event) => {

            if (event.key !== "Escape") {
                return;
            }

            this.closeSidebar();

            document
                .querySelectorAll(".ev-modal-backdrop.show")
                .forEach((modal) => {

                    modal.querySelector(".ev-modal-close")?.click();

                });

            document
                .querySelector(".ev-confirm.show #confirmCancel")
                ?.click();

        });

    }

    /* =========================================
        SIDEBAR
    ========================================= */

    createOverlay() {

        this.overlay = document.createElement("div");

        this.overlay.className = "sidebar-overlay";

        document.body.appendChild(this.overlay);

        this.overlay.onclick = () => this.closeSidebar();

    }

    bindToggle() {

        if (!this.toggle) return;

        this.toggle.onclick = () => {

            const isOpen = this.sidebar.classList.toggle("show");

            this.overlay.classList.toggle("show", isOpen);

            this.toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");

            document.body.style.overflow = isOpen ? "hidden" : "";

        };

    }

    bindMenu() {

        this.menuItems.forEach(item => {

            item.addEventListener("click", async (e) => {

                e.preventDefault();

                await this.navigate(item.href);

            });

        });

    }

    async navigate(url) {

        await this.saveNow();

        window.location.href = url;

    }

    /* =========================================
        AUTO SAVE
    ========================================= */

    initAutoSave(config) {

        console.log("initAutoSave");

        this.autoSave.form = document.querySelector(config.form);

        this.autoSave.endpoint = config.endpoint;

        this.autoSave.section = config.section;

        if (!this.autoSave.form) return;

        this.autoSave.form
            .querySelectorAll("input, textarea, select")
            .forEach(el => {

                // Jangan autosave untuk upload file
                if (el.type === "file") {
                    return;
                }

                if (el.dataset.autosaveBound) {
                    return;
                }

                el.dataset.autosaveBound = "1";

                if (
                    el.tagName === "SELECT" ||
                    el.type === "checkbox" ||
                    el.type === "radio"
                ) {

                    el.addEventListener("change", () => this.markDirty(el));

                } else {

                    el.addEventListener("input", () => this.markDirty(el));

                }

            });

    }

    markDirty() {
        // console.log("dirty", event.target.name);

        this.autoSave.isDirty = true;

        clearTimeout(this.autoSave.timer);

        this.autoSave.timer = setTimeout(() => {

            this.saveNow();

        }, 1500);

    }

    async saveNow() {

        if (!this.autoSave.isDirty) {
            return true;
        }

        if (this.autoSave.saving) {
            return false;
        }

        this.autoSave.saving = true;

        this.showStatus("Saving");

        const formData = new FormData(this.autoSave.form);

        formData.append("section", this.autoSave.section);

        try {

            const { ok, data } = await this.request(
                this.autoSave.endpoint,
                {
                    method: "POST",
                    body: formData
                }
            );

            // const result = await response.json();

            // ===========================
            // VALIDATION / BACKEND ERROR
            // ===========================
            if (!ok) {

                const slugStatusEl = document.getElementById("slugStatus");

                if (data?.field === "slug" && slugStatusEl) {

                    slugStatusEl.innerHTML =
                        '<i class="fa-solid fa-circle-xmark"></i> ' + data.message;

                    slugStatusEl.className = "ev-url-status error";

                }

                this.showStatus(
                    "Failed",
                    data?.message ?? "Unable to save changes."
                );

                this.autoSave.saving = false;

                return false;

            }

            // ===========================
            // SUCCESS
            // ===========================
            if (data?.success) {

                this.autoSave.isDirty = false;

                this.showStatus("Saved");

                this.autoSave.saving = false;

                return true;

            }

            // ===========================
            // UNKNOWN RESPONSE
            // ===========================
            this.showStatus(
                "Failed",
                data?.message ?? "Unexpected server response."
            );

            this.autoSave.saving = false;

            return false;

        } catch (e) {

            console.error(e);

            this.showStatus(
                "Failed",
                "Connection lost. Please check your internet connection."
            );

            this.autoSave.saving = false;

            return false;

        }

    }

    showStatus(status, message = null, title = null) {

        const wrapper = document.getElementById("saveIndicator");
        const titleEl = document.getElementById("saveTitle");
        const text = document.getElementById("saveStatus");
        const icon = document.getElementById("saveIcon");

        wrapper.className = "ev-save-bar";

        switch(status){

            case "Saving":

                wrapper.classList.add("saving");

                icon.className = "fa-solid fa-arrows-rotate fa-spin";

                titleEl.textContent = title ?? "Saving changes";

                text.textContent = message ?? "Please wait while your changes are being saved.";

                break;

            case "Saved":

                wrapper.classList.add("success");

                icon.className = "fa-solid fa-circle-check";

                titleEl.textContent = title ?? "All changes saved";

                text.textContent = message ?? "Everything is up to date.";

                break;

            case "Failed":

                wrapper.classList.add("error");

                icon.className = "fa-solid fa-circle-xmark";

                titleEl.textContent = title ?? "Save failed";

                text.textContent = message ?? "Unable to save your latest changes.";

                break;

            case "Warning":

                wrapper.classList.add("warning");

                icon.className = "fa-solid fa-triangle-exclamation";

                titleEl.textContent = title ?? "Needs attention";

                text.textContent = message ?? "Please review the highlighted fields.";

                break;

        }

    }

    /* =========================================
        SIDEBAR
    ========================================= */

    openSidebar() {

        this.sidebar.classList.add("show");

        this.overlay.classList.add("show");

        this.toggle?.setAttribute("aria-expanded", "true");

        document.body.style.overflow = "hidden";

    }

    closeSidebar() {

        this.sidebar.classList.remove("show");

        this.overlay.classList.remove("show");

        this.toggle?.setAttribute("aria-expanded", "false");

        document.body.style.overflow = "";

    }

}

window.Studio = new EventVerseStudio();

window.addEventListener("resize", () => {

    if (window.innerWidth > 1023) {

        Studio.closeSidebar();

    }

});


// Helper loading
Studio.buttonLoading = function(button, loading){

    if(loading){

        button.dataset.original = button.innerHTML;

        button.disabled = true;

        button.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            Saving...
        `;

    }else{

        button.disabled = false;

        button.innerHTML = button.dataset.original;

    }

}

//Toast
Studio.toast = function({

    icon = "success",
    title = "",
    position = "top-end",
    timer = 3000

} = {}){

    Swal.fire({

        toast: true,

        position,

        icon,

        title,

        showConfirmButton: false,

        timer,

        timerProgressBar: true,

        allowOutsideClick: true,

        didOpen: (toast) => {

            toast.addEventListener(
                "mouseenter",
                Swal.stopTimer
            );

            toast.addEventListener(
                "mouseleave",
                Swal.resumeTimer
            );

        }

    });

};

// helper modal confirm
// Helper modal confirm
Studio.confirm = function({

    title,
    description,
    button = "Delete",
    onConfirm

}){

    const modal = document.getElementById("confirmModal");

    const btn = document.getElementById("confirmAction");

    const cancel = document.getElementById("confirmCancel");

    const backdrop = modal.querySelector(".ev-confirm-backdrop");

    document.getElementById("confirmTitle").textContent = title;
    document.getElementById("confirmDescription").textContent = description;
    btn.textContent = button;

    modal.classList.add("show");

    function close(){

        modal.classList.remove("show");

        btn.onclick = null;
        cancel.onclick = null;
        backdrop.onclick = null;

    }

    cancel.onclick = close;

    backdrop.onclick = close;

    btn.onclick = async function(){

        Studio.buttonLoading(btn, true);

        try{

            await onConfirm();

            close();

        }finally{

            Studio.buttonLoading(btn, false);

        }

    };

};
</script>

@stack('scripts')

</body>
</html>
