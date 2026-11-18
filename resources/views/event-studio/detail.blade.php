@extends('event-studio.layouts.studio')

@section('content')

<form id="detailForm">

    @csrf

    <p class="ev-event-badge is-sky">{{ $event->title ?: 'Untitled event' }}</p>
    <div class="ev-page-header is-sky">
        <div class="ev-page-title-row">
            <div class="ev-page-icon">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="ev-page-title-copy">
                <h2 class="ev-title">Time, place &amp; <span class="accent">story</span></h2>
                <p class="ev-subtitle">Schedule, location and description.</p>
            </div>
        </div>
    </div>

    <div class="ev-card">

        {{-- ========================================================= --}}
        {{-- THEME --}}
        {{-- ========================================================= --}}

        <div class="ev-field">

            <label class="ev-label">
                Theme
                <small>(optional)</small>
            </label>

            <input
                type="text"
                name="theme"
                class="ev-input"
                placeholder="Contoh: Transformasi Digital Menuju Era AI"
                value="{{ $event->theme }}">

        </div>

        {{-- ========================================================= --}}
        {{-- LOCATION TYPE --}}
        {{-- ========================================================= --}}

        <div class="ev-field">

            <label class="ev-label">

                Location type
                <span>*</span>

            </label>

            <!-- <p class="ev-helper">

                Tentukan bagaimana peserta mengikuti event Anda.

            </p> -->

            <div class="ev-method-grid">

                <label class="ev-method-card">

                    <input
                        type="radio"
                        name="location_jenis"
                        value="online"
                        {{ ($event->location_jenis ?? 'online') == 'online' ? 'checked' : '' }}>

                    <div class="ev-method-content">

                        <div class="ev-method-icon online">

                            <i class="fa-solid fa-video"></i>

                        </div>

                        <div>

                            <h5>Online</h5>

                            <p>

                                Zoom, Google Meet, dll...

                            </p>

                        </div>

                        <i class="fas fa-circle-check"></i>

                    </div>

                </label>

                <label class="ev-method-card">

                    <input
                        type="radio"
                        name="location_jenis"
                        value="offline"
                        {{ $event->location_jenis == 'offline' ? 'checked' : '' }}>

                    <div class="ev-method-content">

                        <div class="ev-method-icon offline">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                        <div>

                            <h5>Offline</h5>

                            <p>

                                Gedung, Convention Hall, dll...

                            </p>

                        </div>

                        <i class="fas fa-circle-check"></i>

                    </div>

                </label>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- ONLINE --}}
        {{-- ========================================================= --}}

        <div
            id="onlineWrapper"
            style="{{ ($event->location_jenis ?? 'online') == 'online' ? '' : 'display:none' }}">

            <div class="ev-field">

                <label class="ev-label">

                    Access link
                    <span>*</span>

                </label>

                <!-- <p class="ev-helper">

                    Masukkan URL Zoom, Google Meet, atau platform lainnya.

                </p> -->

                <input
                    type="text"
                    class="ev-input"
                    name="location_online"
                    value="{{ $event->location_online }}"
                    placeholder="Online link">

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- OFFLINE --}}
        {{-- ========================================================= --}}

        <div
            id="offlineWrapper"
            style="{{ $event->location_jenis == 'offline' ? '' : 'display:none' }}">

            <div class="ev-grid-2">

                <div class="ev-field">

                    <label class="ev-label">

                        Province <span>*</span>

                    </label>

                    <select
                        id="province_id"
                        name="location_province"
                        class="ev-choices">

                        <option value="">Select province</option>

                    </select>

                </div>

                <div class="ev-field">

                    <label class="ev-label">

                        Regency / city <span>*</span>

                    </label>

                    <select
                        id="city_id"
                        name="location_city"
                        class="ev-choices">

                        <option value="">Select regency/city</option>

                    </select>

                </div>

            </div>

            <div class="ev-field">

                <label class="ev-label">

                    Location detail
                    <span>*</span>

                </label>

                <input
                    class="ev-input"
                    name="location_detail"
                    value="{{ $event->location_detail }}"
                    placeholder="Nama gedung, aula, hotel, dll.">

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- DATE --}}
        {{-- ========================================================= --}}

        <div class="ev-field">

            <label class="ev-label">

                Event date
                <span>*</span>

            </label>

            <div class="ev-grid-2">

                <div class="ev-field">

                    <label class="ev-helper">

                        Start date

                    </label>

                    <div class="ev-date-input">

                        <i class="fa-regular fa-calendar-days"></i>

                        <input
                            id="start_date"
                            class="ev-input"
                            type="text"
                            name="start_date"
                            value="{{ $event->start_date }}"
                            placeholder="Pilih tanggal mulai"
                            readonly>

                    </div>

                </div>

                <div class="ev-field">

                    <label class="ev-helper">

                        End date

                    </label>

                    <div class="ev-date-input">

                        <i class="fa-regular fa-calendar-days"></i>

                        <input
                            id="end_date"
                            class="ev-input"
                            type="text"
                            name="end_date"
                            value="{{ $event->end_date }}"
                            placeholder="Pilih tanggal selesai"
                            readonly>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- DESCRIPTION --}}
        {{-- ========================================================= --}}

        <div class="ev-field">

            <label class="ev-label">

                Event description
                <span>*</span>

            </label>

            <div class="ev-trix">

                <input
                    id="description"
                    type="hidden"
                    name="description"
                    value="{{ $event->description }}">

                <trix-editor input="description"></trix-editor>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- TIPS --}}
        {{-- ========================================================= --}}

        <div class="ev-tip-box ev-tip-compact">

            <div class="ev-tip-icon">

                <i class="fa-solid fa-lightbulb"></i>

            </div>

            <p>Tip: highlight the outcome, speakers, and agenda.</p>

        </div>

    </div>
</form>


<script>
document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | LOCATION TYPE
    |--------------------------------------------------------------------------
    | Menampilkan form Online / Offline
    */

    const onlineRadio = document.querySelector('input[name="location_jenis"][value="online"]');
    const offlineRadio = document.querySelector('input[name="location_jenis"][value="offline"]');

    const onlineWrapper = document.getElementById("onlineWrapper");
    const offlineWrapper = document.getElementById("offlineWrapper");

    function toggleLocationType() {

        if (onlineRadio.checked) {

            onlineWrapper.style.display = "block";
            offlineWrapper.style.display = "none";

        } else {

            onlineWrapper.style.display = "none";
            offlineWrapper.style.display = "block";

        }

    }

    document
        .querySelectorAll('input[name="location_jenis"]')
        .forEach(item => {

            item.addEventListener("change", async function () {

                toggleLocationType();

                if (this.value === "offline") {

                    // Load province hanya jika belum pernah dimuat
                    if (evChoices.province_id.getValue(true) === "") {

                        await loadProvinces();

                    }

                } else {

                    // Reset kota ketika pindah ke Online
                    // sebaiknya jangan reset, atasi di backend
                    resetProvinces();
                    resetCities();

                }

                Studio.markDirty();

            });

        });

    toggleLocationType();


    /*
    |--------------------------------------------------------------------------
    | CHOICES
    |--------------------------------------------------------------------------
    | Inisialisasi seluruh select menggunakan Choices.js
    */

    window.evChoices = {};

    document.querySelectorAll(".ev-choices").forEach(element => {

        window.evChoices[element.id] = new Choices(element, {

            searchEnabled: true,
            itemSelectText: "",
            shouldSort: false

        });

    });


    /*
    |--------------------------------------------------------------------------
    | FLATPICKR
    |--------------------------------------------------------------------------
    | Date Picker
    */

    if (window.flatpickr) {

        flatpickr("#start_date", {

            dateFormat: "Y-m-d"

        });

        flatpickr("#end_date", {

            dateFormat: "Y-m-d"

        });

    }


    /*
    |--------------------------------------------------------------------------
    | TRIX
    |--------------------------------------------------------------------------
    | Trigger Autosave ketika isi editor berubah
    */

    const trix = document.querySelector("trix-editor");

    if (trix) {

        trix.addEventListener("trix-change", function () {

            Studio.markDirty();

        });

    }


    /*
    |--------------------------------------------------------------------------
    | LOAD LOCATION
    |--------------------------------------------------------------------------
    | Saat edit event:
    | - Load Province
    | - Load City berdasarkan Province
    | - Pilih otomatis data yang tersimpan
    */

    const selectedProvince = "{{ $event->location_province }}";
    const selectedCity = "{{ $event->location_city }}";

    (async () => {

        if (offlineRadio.checked) {

            await loadProvinces(selectedProvince);

            if (selectedProvince) {

                await loadCities(
                    selectedProvince,
                    selectedCity
                );

            }

        }

    })();


   /*
    |--------------------------------------------------------------------------
    | PROVINCE CHANGE
    |--------------------------------------------------------------------------
    */

    document
        .getElementById("province_id")
        .addEventListener("change", async function () {

            // Kosongkan pilihan kota lama
            resetCities();

            // Load kota berdasarkan provinsi baru
            await loadCities(this.value);

            Studio.markDirty();

    });


    /*
    |--------------------------------------------------------------------------
    | CITY CHANGE
    |--------------------------------------------------------------------------
    */

    document
        .getElementById("city_id")
        .addEventListener("change", function () {

            Studio.markDirty();

        });


    /*
    |--------------------------------------------------------------------------
    | AUTOSAVE
    |--------------------------------------------------------------------------
    */

    Studio.initAutoSave({

        form: "#detailForm",

        endpoint: "{{ route('event-studio.autosave', $event->event_id) }}",

        section: "detail"

    });

});


/*
|--------------------------------------------------------------------------
| RESET CITY
|--------------------------------------------------------------------------
| Mengosongkan pilihan Kota
*/

function resetProvinces() {

    evChoices.province_id.clearStore();

    evChoices.province_id.setChoices([

        {
            value: "",
            label: "Pilih Provinsi",
            selected: true,
            disabled: true
        }

    ], "value", "label", true);

}

function resetCities() {

    evChoices.city_id.clearStore();

    evChoices.city_id.setChoices([

        {

            value: "",
            label: "Pilih Kota / Kabupaten",
            selected: true,
            disabled: true

        }

    ], "value", "label", true);

}


/*
|--------------------------------------------------------------------------
| LOAD PROVINCES
|--------------------------------------------------------------------------
| Mengambil seluruh data Provinsi
*/

async function loadProvinces(selected = null) {

    const { ok, data } = await Studio.request(
        "{{ route('locations.provinces') }}"
    );

    if (!ok) return;

    evChoices.province_id.clearStore();

    evChoices.province_id.setChoices(

        data.map(item => ({

            value: item.code,
            label: item.name,
            selected: item.code == selected

        })),

        "value",
        "label",
        true

    );

}


/*
|--------------------------------------------------------------------------
| LOAD CITIES
|--------------------------------------------------------------------------
| Mengambil Kota berdasarkan Provinsi
*/

async function loadCities(province, selected = null) {

    if (!province) {

        resetCities();

        return;

    }

    const url = "{{ route('locations.cities', ':province') }}"
        .replace(':province', province);

    const { ok, data } = await Studio.request(url);

    if (!ok) {

        resetCities();

        return;

    }

    evChoices.city_id.clearStore();

    evChoices.city_id.setChoices(

        data.map(item => ({

            value: item.code,
            label: item.name,
            selected: item.code == selected

        })),

        "value",
        "label",
        true

    );

}
</script>

@endsection