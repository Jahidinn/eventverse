@extends('event-studio.layouts.studio')

@section('content')

<section id="form_step">

    <div class="ev-page-header">

        <div>

            <span class="page-badge">

                Registration Form

            </span>

            <h2 class="ev-page-title">

                Registration Form

            </h2>

            <p class="ev-page-description">

                Collect attendee information before registration is completed. Full Name, Email, and Phone Number are provided by default.

            </p>

        </div>

        <button
            type="button"
            class="btn btn-primary btn-add-field"
            id="btnAddField">

            <i class="fa-solid fa-plus"></i>

            Add Field

        </button>

    </div>

    <div class="ev-field-grid" id="formList">

    @foreach($forms as $form)

        @include('event-studio.form-card')

    @endforeach

</div>

</section>
{{-- =========================================================
    MODAL FIELD
========================================================= --}}

<div class="ev-modal-backdrop" id="fieldModal">

    <div class="ev-modal">

        <div class="ev-modal-header">

            <div>

                <h3 id="fieldModalTitle">

                    Create Field

                </h3>

                <p>

                    Create a custom registration field for attendees.

                </p>

            </div>

            <button
                type="button"
                class="ev-modal-close"
                id="closeFieldModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form id="fieldForm">

            @csrf

            <input
                type="hidden"
                id="field_id"
                name="field_id">

            {{-- =========================================================
                FIELD TYPE
            ========================================================= --}}

            <div class="ev-field">

                <label class="ev-label">

                    Field Type <span>*</span>

                </label>

                <select
                    class="ev-select ev-choices"
                    id="field_type"
                    name="field_type">

                    <optgroup label="Basic">

                        <option value="text">Text</option>

                        <option value="textarea">Textarea</option>

                        <option value="email">Email</option>

                        <option value="phone">Phone Number</option>

                        <option value="number">Number</option>

                    </optgroup>

                    <optgroup label="Selection">

                        <option value="select">Select</option>

                        <option value="radio">Radio</option>

                        <option value="checkbox">Checkbox</option>

                    </optgroup>

                    <optgroup label="Date & Time">

                        <option value="date">Date</option>

                        <option value="time">Time</option>

                    </optgroup>

                    <optgroup label="Upload">

                        <option value="image">Image</option>

                        <option value="file">File</option>

                    </optgroup>

                    <optgroup label="Other">

                        <option value="url">URL</option>

                    </optgroup>

                </select>

            </div>

            {{-- =========================================================
                FIELD LABEL
            ========================================================= --}}

            <div class="ev-field">

                <label class="ev-label">

                    Field Label <span>*</span>

                </label>

                <input
                    type="text"
                    class="ev-input"
                    id="field_label"
                    name="field_label"
                    placeholder="Example: University">

            </div>

            {{-- =========================================================
                DESCRIPTION
            ========================================================= --}}

            <div class="ev-field">

                <label class="ev-label">

                    Description

                </label>

                <textarea
                    rows="3"
                    class="ev-textarea"
                    id="description"
                    name="description"
                    placeholder="Optional helper text displayed below the field."></textarea>

            </div>

            {{-- =========================================================
                PLACEHOLDER
            ========================================================= --}}

            <div
                class="ev-field"
                id="placeholderField">

                <label class="ev-label">

                    Placeholder

                </label>

                <input
                    type="text"
                    class="ev-input"
                    id="placeholder"
                    name="placeholder"
                    placeholder="Example: Enter your university">

            </div>

            {{-- =========================================================
                REQUIRED
            ========================================================= --}}

            <div class="ev-switch-field">

                <div>

                    <strong>

                        Required Field

                    </strong>

                    <small>

                        Attendees must complete this field before registration.

                    </small>

                </div>

                <label class="ev-switch">

                    <input
                        type="checkbox"
                        id="is_required"
                        name="is_required"
                        value="1">

                    <span></span>

                </label>

            </div>

            {{-- =========================================================
                DYNAMIC AREA
            ========================================================= --}}

            <div id="fieldDynamicArea">

                {{-- Filled automatically by Javascript --}}

            </div>

            {{-- =========================================================
                FOOTER
            ========================================================= --}}

            <div class="ev-modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    id="cancelField">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="btnSaveField">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Save Field

                </button>

            </div>

        </form>

    </div>

</div>

@include('event-studio.components.modal-confirm')

<style>
    .ev-page-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-end;

    gap:24px;

    margin-bottom:34px;

}

.btn-add-field{

    min-width:170px;

    height:56px;

}
.ev-field-grid{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(360px,1fr));

    gap:24px;

}



#fieldForm{

    padding:30px;

}

.ev-grid-2{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:22px;

}

.ev-switch-field{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:20px;

    border:1px solid #E2E8F0;

    border-radius:18px;

    margin-top:24px;

}

.ev-switch{

    position:relative;

    width:56px;

    height:32px;

}

.ev-switch input{

    display:none;

}

.ev-switch span{

    position:absolute;

    inset:0;

    background:#CBD5E1;

    border-radius:999px;

    transition:.25s;

}

.ev-switch span::before{

    content:"";

    position:absolute;

    left:4px;

    top:4px;

    width:24px;

    height:24px;

    border-radius:50%;

    background:#FFF;

    transition:.25s;

}

.ev-switch input:checked + span{

    background:var(--primary);

}

.ev-switch input:checked + span::before{

    transform:translateX(24px);

}

.ev-modal-footer{

    display:flex;

    justify-content:flex-end;

    gap:12px;

    margin-top:34px;

}

/* =========================================================
DYNAMIC AREA
========================================================= */

#fieldDynamicArea{

    display:none;

}

.ev-dynamic-card{

    margin-top:24px;

    padding:24px;

    border:1px solid #E2E8F0;

    border-radius:18px;

    background:#F8FAFC;

}

.ev-dynamic-card h4{

    margin:0 0 8px;

    font-size:18px;

    font-weight:700;

}

.ev-dynamic-card p{

    margin:0 0 20px;

    color:#64748B;

    font-size:14px;

}

.ev-option-list{

    display:flex;

    flex-direction:column;

    gap:14px;

}

.ev-option-item{

    display:flex;

    gap:12px;

    align-items:center;

}

.ev-option-item .ev-input{

    flex:1;

}

.ev-option-remove{

    width:42px;

    height:42px;

    border:none;

    border-radius:12px;

    background:#FEF2F2;

    color:#DC2626;

    cursor:pointer;

}

.ev-option-add{

    margin-top:18px;

}

/* =========================================================
FILE FORMAT
========================================================= */

.ev-format-grid{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(120px,1fr));

    gap:12px;

    margin-top:18px;

}

.ev-format-item{

    display:flex;

    align-items:center;

    gap:10px;

    padding:12px 14px;

    border:1px solid #E2E8F0;

    border-radius:12px;

    cursor:pointer;

    transition:.2s;

}

.ev-format-item:hover{

    background:#F8FAFC;

    border-color:var(--primary);

}

.ev-format-item input{

    width:18px;

    height:18px;

    accent-color:var(--primary);

}

.ev-format-item span{

    font-weight:600;

    color:#334155;

}

.ev-system-info{

    margin-top:22px;

    padding:14px 16px;

    border-radius:12px;

    background:#EEF4FF;

    color:#475569;

    display:flex;

    align-items:center;

    gap:10px;

    font-size:14px;

}

.ev-system-info i{

    color:var(--primary);

}


.is-invalid{

    border-color:#EF4444 !important;

}

.choices.is-invalid .choices__inner{

    border-color:#EF4444 !important;

}

.ev-error{

    margin-top:8px;

    color:#EF4444;

    font-size:13px;

    font-weight:500;

}

#optionList.is-invalid,
#extensionList.is-invalid {
    border: 1px solid #EF4444;
    border-radius: 10px;
    padding: 12px;
}


.ev-new-card{
    opacity:0;
    transform:translateY(10px);
}

.ev-field-card{
    transition:.25s ease;
}

.ev-field-card:not(.ev-new-card){
    opacity:1;
    transform:translateY(0);
}

</style>

{{-- form card style --}}
<style>
    .ev-form-card{

    position:relative;

    display:flex;

    flex-direction:column;

    justify-content:space-between;

    gap:24px;

    padding:24px;

    background:#fff;

    border:1px solid #EDF2F7;

    border-radius:18px;

    transition:.25s;

}

.ev-form-card:hover{

    transform:translateY(-4px);

    border-color:#D8E5F6;

    box-shadow:
        0 18px 40px rgba(15,23,42,.07);

}

.ev-form-head{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

}

.ev-form-info{

    display:flex;

    align-items:flex-start;

    gap:16px;

    min-width:0;

}

.ev-form-icon{

    width:48px;

    height:48px;

    border-radius:14px;

    background:linear-gradient(
        135deg,
        #F7F9FC,
        #EEF4FF
    );

    display:flex;

    justify-content:center;

    align-items:center;

    color:var(--primary);

    font-size:18px;

    flex-shrink:0;

}

.ev-form-content{

    min-width:0;

}

.ev-form-content h4{

    margin:0;

    font-size:20px;

    font-weight:700;

    line-height:1.3;

    color:#111827;

    word-break:break-word;

}

.ev-form-content p{

    margin:6px 0 0;

    color:#64748B;

    font-size:14px;

    font-weight:500;

}

.ev-form-footer{

    display:flex;

    justify-content:flex-start;

    align-items:center;

}

.ev-tags{

    display:flex;

    flex-wrap:wrap;

    gap:8px;

}

.tag{

    display:flex;

    align-items:center;

    gap:7px;

    height:30px;

    padding:0 14px;

    border-radius:999px;

    font-size:12px;

    font-weight:600;

    white-space:nowrap;

}

.tag i{

    font-size:11px;

}

.tag.system{

    background:#EEF4FF;

    color:#3B82F6;

}

.tag.custom{

    background:#F3E8FF;

    color:#7C3AED;

}

.tag.required{

    background:#ECFDF5;

    color:#059669;

}

.tag.optional{

    background:#F8FAFC;

    color:#64748B;

}

.ev-card-menu-wrapper{

    position:relative;

}

.ev-card-menu{

    width:40px;

    height:40px;

    border:none;

    border-radius:12px;

    background:transparent;

    cursor:pointer;

    color:#64748B;

    transition:.2s;

}

.ev-card-menu:hover{

    background:#F8FAFC;

    color:#111827;

}

.ev-card-dropdown{

    position:absolute;

    top:46px;

    right:0;

    width:180px;

    background:#fff;

    border:1px solid #E5E7EB;

    border-radius:14px;

    padding:8px;

    display:none;

    z-index:999;

    box-shadow:
        0 18px 45px rgba(15,23,42,.08);

}

.ev-card-dropdown.show{

    display:block;

}

.ev-card-dropdown button{

    width:100%;

    display:flex;

    align-items:center;

    gap:10px;

    border:none;

    background:none;

    padding:11px 12px;

    border-radius:10px;

    cursor:pointer;

    font-size:14px;

    transition:.2s;

}

.ev-card-dropdown button:hover{

    background:#F8FAFC;

}

.ev-card-dropdown .danger{

    color:#DC2626;

}

.ev-divider{

    height:1px;
    margin: 0;

    background:linear-gradient(
        to right,
        transparent,
        #E5E7EB,
        transparent
    );

}
</style>

<script>
    document.addEventListener("DOMContentLoaded",function(){

        const modal=document.getElementById("fieldModal");
        

        [
            document.getElementById("btnAddField")
        ].forEach(btn=>{

            if(!btn) return;

            btn.addEventListener("click",()=>{
                resetFieldModal();

                document.getElementById("fieldForm").reset();

                document.getElementById("field_id").value="";

                document.getElementById("fieldModalTitle").innerHTML="Create Field";

                modal.classList.add("show");

            });

        });

    document.getElementById("closeFieldModal").onclick = closeFieldModal;
    document.getElementById("cancelField").onclick = closeFieldModal;

    modal.onclick = function (e) {
        if (e.target === modal) {
            closeFieldModal();
        }
    };

        window.evChoices = window.evChoices || {};

        document.querySelectorAll(".ev-choices").forEach(element=>{

            if(window.evChoices[element.id]) return;

            window.evChoices[element.id]=new Choices(element,{

                searchEnabled:false,

                itemSelectText:"",

                shouldSort:false

            });

        });

        renderDynamicArea();

        

    });


    function addOption(value=""){

        const list =
            document.getElementById("optionList");

        if(!list) return;

        const item =
            document.createElement("div");

        item.className =
            "ev-option-item";

        item.innerHTML = `

            <input

                type="text"

                class="ev-input"

                name="field_options[]"

                placeholder="Option"

                value="${value}">

            <button

                type="button"

                class="ev-option-remove">

                <i class="fa-solid fa-trash"></i>

            </button>

        `;

        item
            .querySelector(".ev-option-remove")
            .onclick = () => item.remove();

        list.appendChild(item);

    }

    document
    .getElementById("fieldForm")
    .addEventListener("submit", submitField);

    async function submitField(e){

    e.preventDefault();

    clearErrors();

    const form = document.getElementById("fieldForm");

    const submitBtn =
        document.getElementById("btnSaveField");

    Studio.buttonLoading(submitBtn, true);

    try{

        const fieldId =
            document.getElementById("field_id").value;

        const url = fieldId

            ? "{{ route('event-studio.form.update', [$event->id, ':id']) }}"
                .replace(":id", fieldId)

            : "{{ route('event-studio.form.store', $event->id) }}";

        const formData = new FormData(form);

        if(fieldId){

            formData.append("_method","PUT");

        }

        const { ok, data } = await Studio.request(

            url,

            {
                method:"POST",
                body:formData
            }

        );

        if(!ok){

            if(data.errors){

                showErrors(data.errors);

            }

            Studio.showStatus(
                "Failed",
                data.message ?? "Please check the form."
            );

            return;

        }

        Studio.showStatus(
            "Saved",
            data.message
        );

        closeFieldModal();

        resetFieldModal();

        if(fieldId){

            document
                .querySelector(
                    `.ev-form-card[data-id="${fieldId}"]`
                )
                .outerHTML = data.html;

        }else{

            const wrapper =
                document.getElementById("formList");

            wrapper.insertAdjacentHTML(
                "beforeend",
                data.html
            );

            const newCard =
                wrapper.lastElementChild;

            newCard.classList.add("ev-new-card");

            requestAnimationFrame(()=>{

                newCard.classList.remove("ev-new-card");

            });

        }

    }finally{

        Studio.buttonLoading(
            submitBtn,
            false
        );

    }

}

    function clearErrors(){

    document.querySelectorAll(".ev-error").forEach(el=>el.remove());

    document.querySelectorAll(".is-invalid").forEach(el=>{

        el.classList.remove("is-invalid");

    });

}
function showErrors(errors) {

    clearErrors();

    Object.keys(errors).forEach(field => {

        /*
        |--------------------------------------------------------------------------
        | Field Options
        |--------------------------------------------------------------------------
        */

        // Group field
        if (field === "field_options" || field === "field_extensions") {

            const container = document.getElementById(
                field === "field_options"
                    ? "optionList"
                    : "extensionList"
            );

            if (!container) return;

            container.classList.add("is-invalid");

            const error = document.createElement("div");

            error.className = "ev-error";

            error.innerHTML = errors[field][0];

            container.appendChild(error);

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | Normal Field
        |--------------------------------------------------------------------------
        */

        let input = document.querySelector(`[name="${field}"]`);

        if (!input) {

            input = document.querySelector(`[name="${field}[]"]`);

        }

        if (!input) return;

        let target = input;

        if (input.closest(".choices")) {

            target = input.closest(".choices");

        }

        target.classList.add("is-invalid");

        const error = document.createElement("div");

        error.className = "ev-error";

        error.innerHTML = errors[field][0];

        target.after(error);

    });

}

const FIELD_DEFAULTS = {
    text: {
        min_length: 1,
        max_length: 255
    },
    textarea: {
        min_length: 1,
        max_length: 5000
    },
    number: {
        min_value: 0,
        max_value: 999999999
    }
};

function getFieldDefaults(type) {

    const isEdit = document.getElementById("field_id").value !== "";

    if (isEdit) {
        return {};
    }

    return FIELD_DEFAULTS[type] || {};
}

function renderDynamicArea(){

    const typeSelect = document.getElementById("field_type");

        const placeholderField = document.getElementById("placeholderField");

        const dynamicArea = document.getElementById("fieldDynamicArea");

        typeSelect.addEventListener("change", renderDynamicArea);

            const type = typeSelect.value;
            const defaults = getFieldDefaults(type);

            dynamicArea.innerHTML = "";

            dynamicArea.style.display = "none";

            /*
            |--------------------------------------------------------------------------
            | Placeholder
            |--------------------------------------------------------------------------
            */

            const hidePlaceholder = [

                "radio",
                "checkbox",
                "select",
                "image",
                "file"

            ];

            placeholderField.style.display =
                hidePlaceholder.includes(type)
                    ? "none"
                    : "block";

            /*
            |--------------------------------------------------------------------------
            | Selection
            |--------------------------------------------------------------------------
            */

            if(

                ["radio","checkbox","select"]
                .includes(type)

            ){

                dynamicArea.style.display = "block";

                dynamicArea.innerHTML = `

                    <div class="ev-dynamic-card">

                        <h4>

                            Options

                        </h4>

                        <p>

                            Add selectable options.

                        </p>

                        <div
                            class="ev-option-list"
                            id="optionList">

                        </div>

                        <button
                            type="button"
                            class="btn btn-light ev-option-add"
                            id="addOption">

                            <i class="fa-solid fa-plus"></i>

                            Add Option

                        </button>

                    </div>

                `;

                addOption();

                addOption();

                document
                    .getElementById("addOption")
                    .onclick = () => addOption();

            }

            /*
            |--------------------------------------------------------------------------
            | TEXT / TEXTAREA
            |--------------------------------------------------------------------------
            */

            if(["text","textarea"].includes(type)){

                dynamicArea.style.display = "block";

                dynamicArea.innerHTML = `

                    <div class="ev-dynamic-card">

                        <h4>

                            Validation

                        </h4>

                        <p>

                            Limit the number of characters users can enter.

                        </p>

                        <div class="ev-grid-2">

                            <div class="ev-field">

                                <label class="ev-label">

                                    Minimum Length

                                </label>

                                <input
                                    type="number"
                                    class="ev-input"
                                    name="field_min_length"
                                    min="0"
                                    value="${defaults.min_length ?? ""}">

                            </div>

                            <div class="ev-field">

                                <label class="ev-label">

                                    Maximum Length

                                </label>

                                <input
                                    type="number"
                                    class="ev-input"
                                    name="field_max_length"
                                    min="1"
                                    value="${defaults.max_length ?? ""}">

                            </div>

                        </div>

                    </div>

                `;

                return;

            }

            /*
            |--------------------------------------------------------------------------
            | NUMBER
            |--------------------------------------------------------------------------
            */

            if(type === "number"){

                dynamicArea.style.display = "block";

                dynamicArea.innerHTML = `

                    <div class="ev-dynamic-card">

                        <h4>

                            Validation

                        </h4>

                        <p>

                            Set the allowed number range.

                        </p>

                        <div class="ev-grid-2">

                            <div class="ev-field">

                                <label class="ev-label">

                                    Minimum Value

                                </label>

                                <input
                                    type="number"
                                    class="ev-input"
                                    name="field_min_value"
                                    value="${defaults.min_value ?? ""}">

                            </div>

                            <div class="ev-field">

                                <label class="ev-label">

                                    Maximum Value

                                </label>

                                <input
                                    type="number"
                                    class="ev-input"
                                    name="field_max_value"
                                    value="${defaults.max_value ?? ""}">

                            </div>

                        </div>

                    </div>

                `;

                return;

            }

            /*
            |--------------------------------------------------------------------------
            | FILE / IMAGE
            |--------------------------------------------------------------------------
            */

            if (["file", "image"].includes(type)) {

                dynamicArea.style.display = "block";

                const formats = type === "image"
                    ? [
                        { value: "jpg", checked: true },
                        { value: "jpeg", checked: true },
                        { value: "png", checked: true },
                        { value: "webp", checked: false },
                        { value: "gif", checked: false }
                    ]
                    : [
                        { value: "pdf", checked: true },
                        { value: "doc", checked: true },
                        { value: "docx", checked: true },
                        { value: "xls", checked: false },
                        { value: "xlsx", checked: false },
                        { value: "ppt", checked: false },
                        { value: "pptx", checked: false },
                        { value: "zip", checked: false },
                        { value: "rar", checked: false }
                    ];

                const maxSize = type === "image"
                    ? "5 MB"
                    : "10 MB";

                dynamicArea.innerHTML = `

                    <div class="ev-dynamic-card">

                        <h4>

                            ${type === "image"
                                ? "Image Settings"
                                : "File Settings"}

                        </h4>

                        <p>

                            Select the file formats users are allowed to upload.

                        </p>

                        <div class="ev-format-grid" id="extensionList">

                            ${formats.map(format => `

                                <label class="ev-format-item">

                                    <input
                                        type="checkbox"
                                        name="field_extensions[]"
                                        value="${format.value}"
                                        ${format.checked ? "checked" : ""}>

                                    <span>

                                        ${format.value.toUpperCase()}

                                    </span>

                                </label>

                                `).join("")}

                        </div>

                        <div class="ev-system-info">

                            <i class="fa-solid fa-circle-info"></i>

                            Maximum upload size:
                            <strong>${maxSize}</strong>
                            (System Default)

                        </div>

                    </div>

                `;

                return;

            }

        }

        function closeFieldModal() {
    document.getElementById("fieldModal").classList.remove("show");
}

function openFieldModal() {
    document.getElementById("fieldModal").classList.add("show");
}

document.addEventListener("click", function (e) {

    // tutup semua dropdown
    document.querySelectorAll(".ev-card-dropdown").forEach(menu => {

        if (!menu.parentElement.contains(e.target)) {
            menu.classList.remove("show");
        }

    });

    // klik tombol ...
    const button = e.target.closest(".ev-card-menu");

    if (button) {

        const menu = button.nextElementSibling;

        menu.classList.toggle("show");

    }

    
});

//edit 
document.addEventListener("click", function (e) {

    const btn = e.target.closest(".ev-card-menu");

    document
        .querySelectorAll(".ev-card-menu-wrapper")
        .forEach(menu => {

            if (!btn || menu !== btn.closest(".ev-card-menu-wrapper")) {

                menu.classList.remove("open");

            }

        });

    if (!btn) return;

    e.stopPropagation();

    btn.closest(".ev-card-menu-wrapper")
        .classList.toggle("open");

});

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".editField");

    if (!btn) return;

    const card = btn.closest(".ev-form-card");

    resetFieldModal();

    document.getElementById("field_id").value =
        card.dataset.id;

    document.getElementById("field_label").value =
        card.dataset.fieldLabel;

    document.getElementById("description").value =
        card.dataset.description ?? "";

    document.getElementById("placeholder").value =
        card.dataset.placeholder ?? "";

    const required =
    card.dataset.required === "1" ||
    card.dataset.required === "true";

document.getElementById("is_required").checked = required;

    window.evChoices["field_type"]
        .setChoiceByValue(card.dataset.fieldType);

    renderDynamicArea();

    const fieldType = card.dataset.fieldType;

    const validation = JSON.parse(
        card.dataset.validation || "{}"
    );

    const options = JSON.parse(
        card.dataset.options || "[]"
    );

    // Select / Radio / Checkbox
    if (["select", "radio", "checkbox"].includes(fieldType)) {

        const optionList = document.getElementById("optionList");

        optionList.innerHTML = "";

        options.forEach(option => {
            addOption(option);
        });

    }

    // Text / Textarea
    if (["text", "textarea"].includes(fieldType)) {

        document.querySelector('[name="field_min_length"]').value =
            validation.min_length ?? "";

        document.querySelector('[name="field_max_length"]').value =
            validation.max_length ?? "";

    }

    // Number
    if (fieldType === "number") {

        document.querySelector('[name="field_min_value"]').value =
            validation.min ?? "";

        document.querySelector('[name="field_max_value"]').value =
            validation.max ?? "";

    }

    // File / Image
    if (["file", "image"].includes(fieldType)) {

        document
            .querySelectorAll('[name="field_extensions[]"]')
            .forEach(input => {

                input.checked =
                    (validation.extensions ?? []).includes(input.value);

            });

    }

    document.getElementById("fieldModalTitle")
        .innerHTML = "Edit Field";

    document.querySelector(
        "#fieldModal .ev-modal-header p"
    ).innerHTML =
        "Update registration field.";

    document.getElementById("btnSaveField").innerHTML = `
        <i class="fa-solid fa-floppy-disk"></i>
        Update Field
    `;

    document
        .getElementById("fieldModal")
        .classList.add("show");

});

function resetFieldModal() {

    const form = document.getElementById("fieldForm");

    form.reset();

    clearErrors();

    document.getElementById("field_id").value = "";

    document.getElementById("fieldModalTitle").innerHTML =
        "Create Field";

    document.querySelector(
        "#fieldModal .ev-modal-header p"
    ).innerHTML =
        "Create a custom registration field for attendees.";

    document.querySelector(
        '#fieldForm button[type="submit"]'
    ).innerHTML = `
        <i class="fa-solid fa-floppy-disk"></i>
        Save Field
    `;

    window.evChoices["field_type"]
        .setChoiceByValue("text");

    renderDynamicArea();

}


//delete
document.addEventListener("click", function (e) {

    const btn = e.target.closest(".deleteField");

    if (!btn) return;

    const fieldId = btn.dataset.id;

    Studio.confirm({

        title: "Delete Field?",

        description: "This field will be permanently deleted and cannot be recovered.",

        button: "Delete Field",

        onConfirm: async () => {

            Studio.showStatus(
                "Saving",
                "Deleting field..."
            );

            const { ok, data } = await Studio.request(

                "{{ route('event-studio.form.delete', [$event->id, ':id']) }}"
                    .replace(":id", fieldId),

                {
                    method: "DELETE"
                }

            );

            if (!ok) {

                Studio.showStatus(
                    "Failed",
                    data?.message ?? "Failed to delete field."
                );

                return;

            }

            // Hapus card
            btn.closest(".ev-form-card").remove();

            Studio.showStatus(
                "Saved",
                data.message
            );

            // Empty state
            if (!document.querySelector(".ev-form-card")) {

                const grid = document.querySelector(".ev-field-grid");

                if (grid) {
                    grid.innerHTML = `
                        <div class="ev-empty-state">
                            <i class="fa-solid fa-list-check"></i>
                            <h3>No custom fields yet</h3>
                            <p>Create your first registration field.</p>
                        </div>
                    `;
                }

            }

        }

    });

});
</script>
@endsection