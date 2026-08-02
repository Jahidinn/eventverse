@extends('event-studio.layouts.studio')

@section('content')

<form id="detailForm">

    @csrf

    <section>

        <span class="page-badge">
            Detail Event
        </span>

        <p class="page-subtitle">
            Fill in the detailed information of your event before publishing.
        </p>

    </section>

    <div class="ev-section">

        {{-- ========================================================= --}}
        {{-- THEME --}}
        {{-- ========================================================= --}}

        <div class="ev-field">

            <label class="ev-label">
                Tema Event
                <small>(Opsional)</small>
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

                Metode Pelaksanaan
                <span>*</span>

            </label>

            <p class="ev-helper">

                Tentukan bagaimana peserta mengikuti event Anda.

            </p>

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

                                Zoom, Google Meet, YouTube Live, dll.

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

                                Gedung, Aula, Hotel, Convention Hall.

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

                    Tautan Ruang Meeting Virtual
                    <span>*</span>

                </label>

                <p class="ev-helper">

                    Masukkan URL Zoom, Google Meet, atau platform lainnya.

                </p>

                <input
                    type="text"
                    class="ev-input"
                    name="location_online"
                    value="{{ $event->location_online }}"
                    placeholder="Masukkan link URL Zoom, Google Meet atau YouTube Live Stream">

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

                        Provinsi <span>*</span>

                    </label>

                    <select
                        id="province_id"
                        name="location_province"
                        class="ev-choices">

                        <option value="">Pilih Provinsi</option>

                    </select>

                </div>

                <div class="ev-field">

                    <label class="ev-label">

                        Kota / Kabupaten <span>*</span>

                    </label>

                    <select
                        id="city_id"
                        name="location_city"
                        class="ev-choices">

                        <option value="">Pilih Kota / Kabupaten</option>

                    </select>

                </div>

            </div>

            <div class="ev-field">

                <label class="ev-label">

                    Detail Lokasi
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

                Tanggal Event
                <span>*</span>

            </label>

            <div class="ev-grid-2">

                <div class="ev-field">

                    <label class="ev-small-label">

                        Tanggal Mulai

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

                    <label class="ev-small-label">

                        Tanggal Selesai

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

                Deskripsi Event
                <span>*</span>

            </label>

            <p class="ev-helper">

                Jelaskan informasi lengkap mengenai event.

            </p>

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

        <div class="ev-tip-box">

            <div class="ev-tip-icon">

                <i class="fa-solid fa-lightbulb"></i>

            </div>

            <div>

                <h5>

                    Tips membuat deskripsi yang menarik

                </h5>

                <ul>

                    <li>Jelaskan tujuan event.</li>

                    <li>Sebutkan benefit yang diperoleh peserta.</li>

                    <li>Tampilkan narasumber utama.</li>

                    <li>Tambahkan rundown atau agenda singkat.</li>

                </ul>

            </div>

        </div>

    </div>

</form>

<style>
    /* ======================================================
   DETAIL
======================================================*/

.ev-field{

    margin-bottom:24px;

}

.ev-label{

    display:block;

    margin-bottom:6px;

    font-size:15px;

    font-weight:700;

    color:#1E293B;

}

.ev-label span{

    color:#EF4444;

}

.ev-label small{

    font-weight:500;

    color:#94A3B8;

}

.ev-helper{

    margin-top:2px;

    margin-bottom:14px;

    color:#94A3B8;

    font-size:14px;

    line-height:1.5;

}

.ev-grid-2{

    display:grid;

    grid-template-columns:repeat(2,minmax(0,1fr));

    gap:18px;

}

.ev-input{

    width:100%;

    height:50px;

    border:1px solid #D9E3F1;

    border-radius:14px;

    padding:0 16px;

    font-size:15px;

    transition:.2s;

    background:#fff;

}

.ev-input:focus{

    outline:none;

    border-color:#4F7CFF;

    box-shadow:0 0 0 4px rgba(79,124,255,.08);

}

/* ======================================================
ONLINE OFFLINE
======================================================*/

.ev-method-grid{

    display:grid;

    grid-template-columns:repeat(2,minmax(0,1fr));

    gap:16px;

}

.ev-method-card{

    display:block;

    cursor:pointer;

}

.ev-method-card input{

    display:none;

}

.ev-method-content{

    display:flex;

    align-items:center;

    gap:18px;

    padding:18px;

    border-radius:18px;

    border:1px solid #E5EAF2;

    transition:.2s;

    background:#fff;

    position:relative;

}

.ev-method-card:hover .ev-method-content{

    border-color:#AFC8FF;

}

.ev-method-card input:checked+.ev-method-content{

    border-color:#4F7CFF;

    background:#F8FAFF;

    box-shadow:0 8px 24px rgba(79,124,255,.08);

}

.ev-method-icon{

    width:56px;

    height:56px;

    border-radius:16px;

    display:flex;

    justify-content:center;

    align-items:center;

    flex-shrink:0;

    font-size:22px;

}

.ev-method-icon.online{

    background:#EEF4FF;

    color:#3B82F6;

}

.ev-method-icon.offline{

    background:#FEF2F2;

    color:#EF4444;

}

.ev-method-content h5{

    margin:0 0 4px;

    font-size:18px;

    font-weight:700;

}

.ev-method-content p{

    margin:0;

    color:#64748B;

    font-size:14px;

    line-height:1.5;

}

.ev-method-content .fa-circle-check{

    position:absolute;

    right:18px;

    top:50%;

    transform:translateY(-50%);

    font-size:24px;

    color:#CBD5E1;

}

.ev-method-card input:checked+.ev-method-content .fa-circle-check{

    color:#4F7CFF;

}

/* ======================================================
DATE
======================================================*/

.ev-date-input{

    position:relative;

}

.ev-date-input input{

    padding-right:42px;

}

.ev-date-input i{

    position:absolute;

    left:18px;

    top:50%;

    transform:translateY(-50%);

    color:#4F7CFF;

    font-size:18px;

    z-index:5;

    pointer-events:none;

}

.ev-date-input .flatpickr-input{

    padding-left:48px !important;

}

/* ======================================================
TRIX
======================================================*/
/* ======================================================
TRIX
======================================================*/

.ev-trix{

    border:1px solid #D9E3F1;

    border-radius:14px;

    overflow:hidden;

    background:#fff;

    transition:.2s;

}

.ev-trix:focus-within{

    border-color:#4F7CFF;

    box-shadow:0 0 0 4px rgba(79,124,255,.08);

}

.ev-trix trix-toolbar{

    border:none;

    border-bottom:1px solid #EEF2F7;

    background:#F8FAFC;

    padding:15px 8px;

}

.ev-trix trix-editor{

    border:none;

    min-height:300px;

    padding:18px;

    font-size:15px;

    line-height:1.8;

    background:#fff;

}

.ev-trix trix-editor:focus{

    outline:none;

}

/* ======================================================
TIPS
======================================================*/

.ev-tip-box{

    display:flex;

    gap:18px;

    align-items:flex-start;

    padding:22px;

    border-radius:18px;

    background:#FFFDF5;

    border:1px solid #FDE68A;

}

.ev-tip-icon{

    width:52px;

    height:52px;

    border-radius:14px;

    background:#FEF3C7;

    color:#F59E0B;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

    flex-shrink:0;

}

.ev-tip-box h5{

    margin:0 0 10px;

    font-size:17px;

    font-weight:700;

}

.ev-tip-box ul{

    margin:0;

    padding-left:18px;

}

.ev-tip-box li{

    margin-bottom:6px;

    color:#64748B;

    font-size:14px;

}



/* ======================================================
RESPONSIVE
======================================================*/

@media(max-width:768px){

    .ev-grid-2{

        grid-template-columns:1fr;

    }

    .ev-method-grid{

        grid-template-columns:1fr;

    }

}
</style>

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