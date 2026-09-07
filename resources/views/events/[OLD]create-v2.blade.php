@extends('form.main')

@section('content')

<style>
    /* UTILITAS DESAIN PREMIUM */
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #eeebff;
        --success: #10b981;
        --success-light: #ecfdf5;
        --danger: #ef4444;
        --danger-light: #fef2f2;
        --dark-slate: #1e293b;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --radius-lg: 1.25rem;
        --radius-md: 0.75rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .main-section {
        background-color: #f1f5f9;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .step-header{

    border:0;
    border-radius:24px;

    background:
    linear-gradient(
        135deg,
        hsl(219, 87%, 57%) 0%,
        #4e80ec 25%,
        #6d8ef7 55%,
        #5b6af0 100%
    );


    overflow:hidden;
    position:relative;

    box-shadow:
        0 18px 45px rgba(75,111,255,.20);

}
.step-header::before{

    content:"";

    position:absolute;

    width:320px;
    height:320px;

    left:-120px;
    top:-140px;

    border-radius:50%;

    background:rgba(255,255,255,.12);

}

.step-header::after{

    content:"";

    position:absolute;

    width:260px;
    height:260px;

    right:-80px;
    bottom:-120px;

    border-radius:50%;

    background:rgba(255,255,255,.08);

}

.studio-title{

    font-size:11px;

    letter-spacing:3px;

    font-weight:500;

    color:rgba(255,255,255,.75);

    text-transform:uppercase;

    margin-bottom:10px;

}

.progress-badge{

    position:absolute;

    top:22px;

    right:22px;

    padding:8px 16px;

    border-radius:999px;

    background:rgba(255,255,255,.18);

    backdrop-filter:blur(12px);

    color:#fff;

    font-weight:700;

    font-size:14px;

    border:1px solid rgba(255,255,255,.25);

}

@media(max-width:768px){

    .step-label{
        display:none;
    }

    .step-title{
        font-size:28px;
    }

    .progress-badge{

        top:16px;
        right:16px;

        font-size:13px;

        padding:6px 14px;

    }

}

.step-title{

    color:#fff;
    font-weight:700;
    letter-spacing:.5px;

}

.step-subtitle{

    color:rgba(255,255,255,.82);

}

.modern-stepper{

    position:relative;

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

}

.progress-line{

    position:absolute;

    top:24px;

    left:10%;

    right:10%;

    height:4px;

    background:#dce7f6;

    border-radius:20px;

}

.progress-active{

    position:absolute;

    top:24px;

    left:10%;

    width:0%;

    height:4px;

    border-radius:20px;

    background:linear-gradient(90deg,#555af3,#845fea);

    transition:.4s;

}

.step-item{

    width:25%;

    text-align:center;

    position:relative;

    z-index:2;

}

.step-circle{

    width:48px;
    height:48px;

    margin:auto;

    border-radius:50%;

    background:white;

    border:3px solid #d6dfec;

    color:#718fe9;

    font-weight:700;

    display:flex;

    align-items:center;

    justify-content:center;

    transition:.3s;

}

.step-circle.active{

    background:linear-gradient(135deg,#2563eb,#4f8cff);

    border-color:#2563eb;

    color:white;

    transform:scale(1.08);

    box-shadow:0 8px 20px rgba(37,99,235,.25);

}

.step-circle.done{

    background:#10b981;

    border-color:#10b981;

    color:white;

}

.step-label{

    margin-top:14px;

    color:white;

    font-size:14px;

    font-weight:500;

}

.step-label.active{

    color:white;

    font-weight:700;

}


.progress-active{
    transition: width .45s cubic-bezier(.4,0,.2,1);
}

.step-circle{
    transition: all .35s ease;
}

.step-circle.active{
    transform:scale(1.12);
}

.step-circle.done{
    transform:scale(1);
}

@media(max-width:768px){

.step-label{

    font-size:11px;

}

.step-circle{

    width:40px;
    height:40px;

}

.progress-line,
.progress-active{

    top:20px;

}

}



.section-header{

    display:flex;

    align-items:flex-start;

    gap:18px;

    margin-bottom:35px;

}

.section-icon{

    width:56px;

    height:56px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:linear-gradient(
        135deg,
        #EEF4FF,
        #F4F0FF
    );

    color:#4F8CFF;

    font-size:22px;

    flex-shrink:0;

}

.section-step{

    display:inline-block;

    padding:5px 12px;

    border-radius:50px;

    background:#EEF4FF;

    color:#4F8CFF;

    font-size:11px;

    font-weight:700;

    letter-spacing:1.5px;

    margin-bottom:5px;

}

.section-desc{

    margin:0;

    color:#64748B;

    font-size:.90rem;

    line-height:1.6;

}

@media(max-width:768px){

.section-header{

    gap:14px;

}

.section-icon{

    width:46px;

    height:46px;

    border-radius:14px;

    font-size:18px;

}

.section-title{

    font-size:1.3rem;

}

.section-desc{

    font-size:.88rem;

}

}

.upload-zone{

    position:relative;

    height:260px;

    border:2px dashed #D7E3F4;

    border-radius:18px;

    background:#F8FAFC;

    overflow:hidden;

    cursor:pointer;

}

#upload-placeholder{

    height:100%;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    transition:.3s;

}

.upload-icon{

    font-size:50px;

    color:#4F8CFF;

    margin-bottom:15px;

}

#preview-container{

    position:absolute;

    inset:0;

}

#image-preview{

    width:100%;

    height:100%;

    object-fit:cover;

}

#remove-file-btn{

    position:absolute;

    top:15px;

    right:15px;

    border-radius:30px;

    padding:8px 15px;

}

.modern-label{

    font-size:.88rem;

    font-weight:600;

    color:#334155;

    margin-bottom:8px;
    font-style: normal;

}

.form-hint{

    color:#94A3B8;

    font-size:.78rem;

    margin-top:6px;

    display:block;

}

.modern-input-wrapper{

    position:relative;

}


.modern-input{

    height:54px;

    border-radius:14px;

    border:1px solid #D9E2F1;

    box-shadow:none;

    padding-left:48px;

    transition:.25s;

}

.modern-input:focus{

    border-color:#4F8CFF;

    box-shadow:0 0 0 .18rem rgba(79,140,255,.12);

}

.modern-url{

    display:flex;

    align-items:center;

    border:1px solid #D9E2F1;

    border-radius:14px;

    overflow:hidden;

    transition:.25s;

    background:white;

}

.modern-url:focus-within{

    border-color:#4F8CFF;

    box-shadow:0 0 0 .18rem rgba(79,140,255,.12);

}

.url-prefix{

    background:#F8FAFC;

    color:#64748B;

    font-size:.82rem;

    font-weight:600;

    padding:0 16px;

    height:54px;

    display:flex;

    align-items:center;

    border-right:1px solid #E2E8F0;

}

.modern-url .modern-input{

    border:0!important;

    padding-left:16px;

    box-shadow:none!important;

}


.premium-radio-check{
    display:none;
}

/* Card */

.organizer-card{

    position:relative;

    display:flex;

    align-items:center;

    gap:16px;

    padding:20px;

    border-radius:18px;

    background:#fff;

    border:1px solid #E2E8F0;

    cursor:pointer;

    transition:.25s;

}

.organizer-card:hover{

    border-color:#4F8CFF;

    transform:translateY(-2px);

    box-shadow:0 12px 24px rgba(79,140,255,.08);

}

/* Active */

.premium-radio-check:checked + .organizer-card{

    border-color:#4F8CFF;

    background:#EEF5FF;

    box-shadow:0 12px 30px rgba(79,140,255,.12);

}

/* Icon */

.organizer-icon{

    width:54px;

    height:54px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

}

.bg-primary-soft{

    background:#E8F1FF;

    color:#3B82F6;

}

.bg-success-soft{

    background:#ECFDF3;

    color:#10B981;

}

/* Content */

.organizer-content{

    flex:1;

}

.organizer-content h6{

    margin:0;

    font-weight:700;

    color:#1E293B;

}

.organizer-content p{

    margin:4px 0 0;

    font-size:.82rem;

    color:#64748B;

}

/* Check */

.check-icon{

    font-size:22px;

    color:#D1D5DB;

    transition:.2s;

}

.premium-radio-check:checked + .organizer-card .check-icon{

    color:#3B82F6;

}

/* Account */

.account-card{

    display:flex;

    align-items:center;

    gap:16px;

    padding:18px;

    border-radius:16px;

    background:#F8FAFC;

    border:1px solid #E2E8F0;

}

.account-avatar{

    width:48px;

    height:48px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#E8F1FF;

    color:#3B82F6;

    font-size:18px;

}

.account-card strong{

    display:block;

    color:#1E293B;

}

.account-card small{

    color:#64748B;

}

.modern-select{

    display:flex;

    align-items:center;

    background:#F8FAFC;

    border:1px solid #E2E8F0;

    border-radius:16px;

    overflow:hidden;

    transition:.25s;

}

.modern-select:focus-within{

    border-color:#4F8CFF;

    box-shadow:0 0 0 4px rgba(79,140,255,.08);

}

.select-icon{

    width:56px;

    display:flex;

    justify-content:center;

    color:#3B82F6;

    font-size:18px;

}

.modern-select-input{

    flex:1;

    border:0;

    background:transparent;

    height:58px;

    outline:none;

    font-size:.92rem;

    color:#334155;

    appearance:none;

}

.select-arrow{

    width:50px;

    display:flex;

    justify-content:center;

    color:#94A3B8;

    pointer-events:none;

}

.organization-help{

    display:flex;

    align-items:center;

    gap:16px;

    padding:16px 18px;

    margin-top:14px;

    border-radius:16px;

    background:linear-gradient(
        135deg,
        #F8FBFF,
        #EEF5FF
    );

    border:1px solid #D8E7FF;

}

.help-icon{

    width:46px;

    height:46px;

    flex-shrink:0;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#E8F1FF;

    color:#3B82F6;

    font-size:18px;

}

.help-content{

    flex:1;

}

.help-content strong{

    display:block;

    color:#1E293B;

    font-size:.92rem;

    margin-bottom:3px;

}

.help-content p{

    font-size:.8rem;

    color:#64748B;

    line-height:1.5;

}

.organization-help .btn{

    white-space:nowrap;

}

@media(max-width:768px){

.organization-help{

    flex-direction:column;

    align-items:flex-start;

}

.organization-help .btn{

    width:100%;

}

}


.event-mode-card{

    position:relative;

    display:flex;

    align-items:center;

    gap:16px;

    padding:18px;

    border-radius:18px;

    background:#fff;

    border:1px solid #E2E8F0;

    cursor:pointer;

    transition:.25s;

    min-height:105px;

}

.event-mode-card:hover{

    border-color:#4F8CFF;

    transform:translateY(-2px);

    box-shadow:0 12px 25px rgba(79,140,255,.08);

}

.premium-radio-check:checked + .event-mode-card{

    border-color:#4F8CFF;

    background:#EEF5FF;

    box-shadow:0 12px 30px rgba(79,140,255,.12);

}

.mode-icon{

    width:58px;

    height:58px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:24px;

    flex-shrink:0;

}

.mode-online{

    background:#E8F1FF;

    color:#3B82F6;

}

.mode-offline{

    background:#FEECEC;

    color:#EF4444;

}

.mode-content{

    flex:1;

}

.mode-content h6{

    margin:0;

    font-weight:700;

    color:#1E293B;

}

.mode-content p{

    margin:4px 0 0;

    color:#64748B;

    font-size:.82rem;

    line-height:1.5;

}

.mode-check{

    color:#CBD5E1;

    font-size:22px;

    transition:.2s;

}

.premium-radio-check:checked + .event-mode-card .mode-check{

    color:#3B82F6;

}

.datetime-card{

    display:flex;
    align-items:center;

    height:58px;

    padding:0 18px;

    border-radius:16px;

    background:#F8FAFC;

    border:1px solid #E2E8F0;

    transition:.25s;

}

.datetime-card:focus-within{

    border-color:#4F8CFF;

    box-shadow:0 0 0 4px rgba(79,140,255,.10);

    background:#fff;

}

.datetime-group{

    padding:20px;

    border:1px solid #E2E8F0;

    border-radius:18px;

    background:#FBFCFE;

}



.datetime-group-title i{

    color:#3B82F6;

}

.datetime-icon{

    color:#3B82F6;

    font-size:18px;

    margin-right:14px;

}

.modern-date-input{

    flex:1;

    border:0;

    background:transparent;

    outline:none;

    font-size:.95rem;

    color:#334155;

    cursor:pointer;

}

/* Wrapper */

.trix-wrapper{

    border:1px solid #E2E8F0;

    border-radius:10px;

    overflow:hidden;

    background:#fff;

    transition:.25s;

}

.trix-wrapper:focus-within{

    border-color:#4F8CFF;

    box-shadow:0 0 0 4px rgba(79,140,255,.08);

}

/* Toolbar */

trix-toolbar{

    background:#F8FAFC;

    padding:10px 12px;

    border-bottom:1px solid #E2E8F0;

}

/* Editor */

.modern-trix{

    min-height:260px;

    padding:18px;

    border:0;

    font-size:.95rem;

    color:#334155;

}

.modern-trix:focus{

    outline:none;

}

/* Tips */

.description-tip{

    display:flex;

    gap:16px;

    padding:16px;

    border-radius:16px;

    background:#F8FAFC;

    border:1px solid #E2E8F0;
    font-size: 12px;

}

.tip-icon{

    width:46px;

    height:46px;

    border-radius:14px;

    background:#FEF3C7;

    color:#F59E0B;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:15px;

    flex-shrink:0;

}

.description-tip strong{

    color:#1E293B;

}

.description-tip ul{

    color:#64748B;

    padding-left:18px;

}

.description-tip li{

    margin-bottom:4px;

}

/* ======================================================
   TICKET BUILDER
====================================================== */

.ticket-builder{

    padding:34px;

    border-radius:28px;

    background:linear-gradient(180deg,#ffffff,#fbfcff);

    border:1px solid #E6ECF5;

}

.ticket-builder-top{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:30px;

    margin-bottom:35px;

    flex-wrap:wrap;

}

.ticket-step{

    display:inline-flex;

    align-items:center;

    padding:7px 14px;

    border-radius:999px;

    background:#EEF4FF;

    color:#4F8CFF;

    font-weight:700;

    font-size:.72rem;

    letter-spacing:.08em;

    margin-bottom:14px;

}

.ticket-builder-title{

    font-size:2rem;

    font-weight:800;

    color:#0F172A;

    margin-bottom:8px;

}

.ticket-builder-desc{

    color:#64748B;

    font-size:.93rem;

    max-width:520px;

    line-height:1.7;

}


/* ======================================================
BUTTON
====================================================== */

.ticket-create-btn{

    border:none;

    padding:14px 22px;

    border-radius:18px;

    background:linear-gradient(135deg,#4F8CFF,#6B63FF);

    color:#fff;

    font-weight:700;

    display:flex;

    align-items:center;

    gap:10px;

    transition:.25s;

    box-shadow:0 15px 30px rgba(79,140,255,.25);

}

.ticket-create-btn:hover{

    transform:translateY(-3px);

}


/* ======================================================
CARD
====================================================== */

.ticket-card{

    position:relative;

    background:white;

    border-radius:24px;

    border:1px solid #E8EDF5;

    overflow:hidden;

    transition:.3s;

    margin-bottom:24px;

}

.ticket-card:hover{

    transform:translateY(-4px);

    box-shadow:0 25px 50px rgba(15,23,42,.08);

}

.ticket-card.active{

    border-color:#D6E6FF;

}

.ticket-card::before{

    content:"";

    position:absolute;

    left:0;

    top:0;

    width:100%;

    height:5px;

    background:linear-gradient(90deg,#4F8CFF,#7367FF);

}


/* ======================================================
HEADER
====================================================== */

.ticket-card-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    /* padding:0px 0px; */

    border-bottom:1px solid #EEF2F7;

}

.ticket-card-left{

    display:flex;

    gap:18px;

    align-items:center;

}

.ticket-icon{

    width:62px;

    height:62px;

    border-radius:20px;

    display:flex;

    justify-content:center;

    align-items:center;

    background:linear-gradient(135deg,#EEF5FF,#DDEAFF);

    color:#3B82F6;

    font-size:22px;

}

.ticket-card-left h4{

    margin:0;

    font-size:1.15rem;

    font-weight:700;

    color:#0F172A;

}

.ticket-card-left span{

    color:#64748B;

    font-size:.85rem;

}


/* ======================================================
BADGE
====================================================== */

.ticket-badge{

    padding:8px 16px;

    border-radius:999px;

    font-size:.75rem;

    font-weight:700;

}

.ticket-badge.paid{

    background:#EEF5FF;

    color:#3478F6;

}

.ticket-badge.free{

    background:#ECFDF3;

    color:#10B981;

}


/* ======================================================
BODY
====================================================== */

.ticket-body{

    /* padding:30px; */

}

.ticket-body label{

    display:block;

    margin-bottom:9px;

    color:#475569;

    font-size:.82rem;

    font-weight:600;

}


/* ======================================================
INPUT
====================================================== */

.ticket-body input,

.ticket-body textarea{

    width:100%;

    border:1px solid #E5EAF2;

    background:#FAFBFD;

    border-radius:16px;

    transition:.25s;

    outline:none;

    font-size:.92rem;

}

.ticket-body input{

    height:56px;

    padding:0 18px;

}

.ticket-body textarea{

    padding:16px 18px;

    resize:none;

}

.ticket-body input:focus,

.ticket-body textarea:focus{

    border-color:#4F8CFF;

    background:#fff;

    box-shadow:0 0 0 4px rgba(79,140,255,.08);

}


/* ======================================================
PRICE
====================================================== */

.ticket-price{

    display:flex;

    align-items:center;

    height:56px;

    border:1px solid #E5EAF2;

    border-radius:16px;

    overflow:hidden;

    background:#FAFBFD;

}

.ticket-price span{

    width:70px;

    text-align:center;

    font-weight:700;

    color:#64748B;

    border-right:1px solid #E5EAF2;

}

.ticket-price input{

    border:none!important;

    background:transparent!important;

    box-shadow:none!important;

}


/* ======================================================
FOOTER
====================================================== */

.ticket-footer{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:24px 30px;

    border-top:1px solid #EEF2F7;

    background:#FCFDFF;

}

.ticket-switch{

    display:flex;

    align-items:center;

    gap:12px;

}

.ticket-switch input{

    width:18px;

    height:18px;

}

.ticket-switch span{

    color:#475569;

    font-size:.9rem;

}

.ticket-delete{

    border:none;

    background:#FEF2F2;

    color:#EF4444;

    border-radius:14px;

    padding:11px 18px;

    font-weight:600;

    transition:.25s;

}

.ticket-delete:hover{

    background:#EF4444;

    color:white;

}


/* ======================================================
ADD CARD
====================================================== */

.ticket-add-card{

    width:100%;

    border:2px dashed #CBD5E1;

    border-radius:24px;

    background:#FBFCFE;

    padding:45px;

    transition:.25s;

}

.ticket-add-card:hover{

    border-color:#4F8CFF;

    background:#F8FBFF;

}

.ticket-add-card div{

    width:70px;

    height:70px;

    margin:auto;

    border-radius:22px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#EEF5FF;

    color:#4F8CFF;

    font-size:28px;

    margin-bottom:18px;

}

.ticket-add-card strong{

    display:block;

    font-size:1rem;

    color:#0F172A;

}

.ticket-add-card small{

    color:#64748B;

}


/* ======================================================
RESPONSIVE
====================================================== */

@media(max-width:768px){

.ticket-builder{

    padding:22px;

}

.ticket-builder-top{

    flex-direction:column;

}

.ticket-create-btn{

    width:100%;

    justify-content:center;

}

.ticket-card-header{

    flex-direction:column;

    align-items:flex-start;

    gap:18px;

}

.ticket-body{

    padding:20px;

}

.ticket-footer{

    flex-direction:column;

    gap:15px;

    align-items:stretch;

}

.ticket-delete{

    width:100%;

}

}



    /* INPUT CONTROLS */
    .form-control, .custom-select {
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        height: auto;
        font-size: 0.95rem;
        color: var(--dark-slate);
        background-color: #ffffff;
        transition: var(--transition);
    }

    .form-control:focus, .custom-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        background-color: #ffffff;
    }

    /* UPLOAD ZONE */
    .upload-zone {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-md);
        padding: 2.5rem 1.5rem;
        text-align: center;
        background-color: var(--bg-light);
        cursor: pointer;
        transition: var(--transition);
    }

    .upload-zone:hover {
        border-color: var(--primary);
        background-color: var(--primary-light);
    }

    /* RADIO CARDS */
    .premium-radio-check {
        display: none;
    }

    .premium-radio-label {
        display: block;
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
        color: var(--dark-slate);
        background: #ffffff;
    }

    .premium-radio-check:checked + .premium-radio-label {
        border-color: var(--primary);
        background-color: var(--primary-light);
        color: var(--primary);
    }

    /* REPEATERS (TIKET & CUSTOM FIELDS) */
    .repeater-item {
        background: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        position: relative;
        transition: var(--transition);
    }

    .repeater-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .btn-delete-repeater {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--danger-light);
        color: var(--danger);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    

    .btn-delete-repeater:hover {
        background-color: var(--danger);
        color: #ffffff;
    }

    .step-content {
        display: none;
    }
    
    .step-content.active {
        display: block;
        animation: smoothFadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes smoothFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .summary-card {
        background-color: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.5rem;
    }

    .summary-badge {
        background-color: #e2e8f0;
        color: var(--dark-slate);
        padding: 0.35rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
</style>

<section class="py-5 min-vh-100 d-flex align-items-center main-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10 col-md-12">
                
                <!-- CARD 1: HEADER & PROGRESS TRACKER (TERPISAH) -->
                <div class="card step-header border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-lg-5 position-relative">

                        <!-- Progress -->
                        <div class="progress-badge" id="progress-badge">
                            25%
                        </div>

                        <!-- Header -->
                        <div class="text-center mb-4">

                            

                            <h2 class="step-title mb-0">
                                Create Event
                            </h2>
                            <div class="studio-title">
                                EVENTHUB STUDIO
                            </div>

                        </div>
                    

                        <!-- Stepper -->
                        <div class="modern-stepper">

                            <div class="progress-line"></div>
                            <div id="progress-active" class="progress-active"></div>

                            <div class="step-item">
                                <div id="badge-step-1" class="step-circle active">1</div>
                                <div id="text-step-1" class="step-label">
                                    Informasi Dasar
                                </div>
                            </div>

                            <div class="step-item">
                                <div id="badge-step-2" class="step-circle">2</div>
                                <div id="text-step-2" class="step-label">
                                    Detail Event
                                </div>
                            </div>

                            <div class="step-item">
                                <div id="badge-step-3" class="step-circle">3</div>
                                <div id="text-step-3" class="step-label">
                                    Manajemen Tiket
                                </div>
                            </div>

                            <div class="step-item">
                                <div id="badge-step-4" class="step-circle">4</div>
                                <div id="text-step-4" class="step-label">
                                    Form & Publish
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- CARD 2: FORM KONTEN UTAMA -->
                <div class="card premium-card">
                    <form id="eventForm" action="#" method="POST" enctype="multipart/form-data" class="card-body p-4 p-md-5 needs-validation" novalidate>
                        @csrf

                        <!-- STEP 1 — INFORMASI DASAR -->
                        <div id="step-1-content" class="step-content active">
                            <div class="section-header mb-4 border-bottom pb-3">
                                <div class="section-icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div class="section-content">
                                    <span class="section-step">
                                        INFORMASI DASAR
                                    </span>
                                    <p class="section-desc">
                                        Lengkapi identitas event agar peserta mudah mengenali acara Anda.
                                    </p>

                                </div>
                            </div>
                                <div class="form-group mb-4">

                                    <label class="font-weight-bold text-secondary small">
                                        Upload Banner Event <span class="text-danger">*</span>
                                    </label>

                                    <div class="upload-zone" id="upload-zone"
                                        onclick="document.getElementById('event_banner').click()">

                                        <input type="file"
                                            id="event_banner"
                                            name="event_banner"
                                            accept="image/*"
                                            class="d-none"
                                            required>

                                        <!-- Placeholder -->
                                        <div id="upload-placeholder">

                                            <i class="fas fa-cloud-upload-alt upload-icon"></i>

                                            <h6 class="font-weight-bold mb-1">
                                                Klik untuk upload banner
                                            </h6>

                                            <p class="small text-muted mb-0">
                                                PNG, JPG, JPEG • Maks. 2MB
                                            </p>

                                        </div>

                                        <!-- Preview -->
                                        <div id="preview-container"
                                            class="d-none">

                                            <img id="image-preview"
                                                src="#"
                                                alt="Preview">

                                            <button
                                                type="button"
                                                id="remove-file-btn"
                                                class="btn btn-light btn-sm shadow">

                                                <i class="fas fa-sync-alt mr-1"></i>

                                                Ganti

                                            </button>

                                        </div>

                                    </div>

                                    <div class="text-danger small d-none mt-2"
                                        id="error-event_banner">
                                        Anda diwajibkan mengunggah banner.
                                    </div>

                                </div>

                            <div class="form-row">

                                <!-- Judul Event -->
                                <div class="form-group col-lg-12 mb-4">

                                    <label for="event_name" class="modern-label">
                                        Judul Event
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="modern-input-wrapper">

                                        {{-- <i class="fas fa-user input-icon"></i> --}}

                                        <input
                                            type="text"
                                            id="event_name"
                                            name="event_name"
                                            class="form-control modern-input"
                                            placeholder="Contoh: Premium Business Strategy Seminar"
                                            required>

                                    </div>

                                    <small class="form-hint">
                                        Nama yang akan ditampilkan kepada peserta.
                                    </small>

                                    <div class="invalid-feedback">
                                        Judul event tidak boleh kosong.
                                    </div>

                                </div>

                                <!-- Custom Link -->
                                <div class="form-group col-lg-12 mb-4">

                                    <label for="event_link" class="modern-label">
                                        Custom Link
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="modern-url">

                                        <span class="url-prefix">
                                            eventhub.web.id/
                                        </span>

                                        <input
                                            type="text"
                                            id="event_link"
                                            name="event_link"
                                            class="form-control modern-input border-0"
                                            placeholder="business-strategy-2026"
                                            required>

                                    </div>

                                    <small class="form-hint">
                                        Link unik yang akan dibagikan ke peserta.
                                    </small>

                                    <div class="invalid-feedback">
                                        Custom link URL unik wajib ditentukan.
                                    </div>

                                </div>

                            </div>

                            <div class="form-group mb-4">

                                <label class="modern-label">
                                    Penyelenggara Acara
                                    <span class="text-danger">*</span>
                                </label>

                                {{-- <small class="form-hint mb-3">
                                    Pilih siapa yang bertanggung jawab terhadap event ini.
                                </small> --}}

                                <div class="row">

                                    <div class="col-md-6 mb-3">

                                        <input
                                            type="radio"
                                            id="p_individu"
                                            name="organizer_type"
                                            value="Individu"
                                            checked
                                            class="premium-radio-check">

                                        <label class="organizer-card" for="p_individu">

                                            <div class="organizer-icon bg-primary-soft">
                                                <i class="fas fa-user"></i>
                                            </div>

                                            <div class="organizer-content">

                                                <h6>Individu</h6>

                                                <p>
                                                    Kelola event menggunakan akun pribadi.
                                                </p>

                                            </div>

                                            <i class="fas fa-check-circle check-icon"></i>

                                        </label>

                                    </div>

                                    <div class="col-md-6">

                                        <input
                                            type="radio"
                                            id="p_organisasi"
                                            name="organizer_type"
                                            value="Organisasi"
                                            class="premium-radio-check">

                                        <label class="organizer-card" for="p_organisasi">

                                            <div class="organizer-icon bg-success-soft">
                                                <i class="fas fa-building"></i>
                                            </div>

                                            <div class="organizer-content">

                                                <h6>Organisasi</h6>

                                                <p>
                                                    Gunakan organisasi yang sudah terdaftar.
                                                </p>

                                            </div>

                                            <i class="fas fa-check-circle check-icon"></i>

                                        </label>

                                    </div>

                                </div>

                            </div>

                            <div id="username-container" class="form-group mb-4">

                                <label class="modern-label">
                                    Penanggung Jawab
                                </label>

                                <div class="account-card">

                                    <div class="account-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            {{ auth()->user()->username ?? 'Username_Anda' }}
                                        </strong>

                                        <small>Akun pribadi</small>

                                    </div>

                                </div>

                            </div>

                            <div id="org-select-container" class="form-group mb-4 d-none">

                                <label class="modern-label">
                                    Pilih Organisasi
                                    <span class="text-danger">*</span>
                                </label>

                            <div class="modern-select">

                                <div class="select-icon">
                                    <i class="fas fa-building"></i>
                                </div>

                                <select
                                    id="organization_id"
                                    name="organization_id"
                                    class="modern-select-input">

                                    <option value="" selected disabled>
                                        Pilih organisasi...
                                    </option>

                                    <option value="1">
                                        Google Developers Group (GDG)
                                    </option>

                                    <option value="2">
                                        PT. Synergy Creative Nusantara
                                    </option>

                                    <option value="3">
                                        BEM Fakultas Ilmu Komputer
                                    </option>

                                </select>

                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>

                            </div>

                            <div class="invalid-feedback">
                                Silakan pilih organisasi.
                            </div>

                            <div class="organization-help mt-3">

                                <div class="help-icon">
                                    <i class="fas fa-users"></i>
                                </div>

                                <div class="help-content">

                                    <strong>Belum punya organisasi?</strong>

                                    <p class="mb-0">
                                        Daftarkan organisasi Anda terlebih dahulu agar dapat menjadi penyelenggara event.
                                    </p>

                                </div>

                                <a href="#" class="btn btn-primary btn-sm rounded-pill px-3">
                                    Buat Sekarang
                                </a>

                            </div>

                            </div>
                        </div>

                        <!-- STEP 2 — DETAIL EVENT -->
                        <div id="step-2-content" class="step-content">

                            <div class="section-header mb-4 border-bottom pb-3">
                                <div class="section-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="section-content">
                                    <span class="section-step">
                                        DETAIL EVENT
                                    </span>
                                    <p class="section-desc">
                                        Tentukan segmentasi klasifikasi, ruang pertemuan, alokasi waktu serta substansi acara
                                    </p>

                                </div>
                            </div>

                            

                            <div class="form-row">

                                <!-- Kategori -->
                                <div class="form-group col-lg-12 mb-4">

                                    <label for="category" class="modern-label">
                                        Kategori Event
                                        <span class="text-danger">*</span>
                                    </label>

                                    {{-- <small class="form-hint mb-2">
                                        Pilih kategori yang paling sesuai dengan event Anda.
                                    </small> --}}

                                    <div class="modern-select">

                                        <div class="select-icon">
                                            <i class="fas fa-layer-group"></i>
                                        </div>

                                        <select
                                            id="category"
                                            name="category"
                                            class="modern-select-input"
                                            required>

                                            <option value="" disabled selected>
                                                Pilih kategori event...
                                            </option>

                                            <option value="Workshop & Training">
                                                Workshop & Training
                                            </option>

                                            <option value="International Conference">
                                                International Conference
                                            </option>

                                            <option value="Music Concert & Art">
                                                Music Concert & Art
                                            </option>

                                        </select>

                                        <div class="select-arrow">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>

                                    </div>

                                    <div class="invalid-feedback">
                                        Pilih jenis kategori kegiatan.
                                    </div>

                                </div>

                                <!-- Tema -->

                                <div class="form-group col-lg-12 mb-4">

                                    <label for="theme" class="modern-label">
                                        Tema Event
                                        <span class="text-danger">*</span>
                                    </label>

                                    {{-- <small class="form-hint mb-2">
                                        Ringkas, jelas, dan mudah dipahami peserta.
                                    </small> --}}

                                    <div class="modern-input-wrapper">

                                        {{-- <i class="fas fa-lightbulb input-icon"></i> --}}

                                        <input
                                            type="text"
                                            id="theme"
                                            name="theme"
                                            class="form-control modern-input"
                                            placeholder="Contoh: Transformasi Digital Menuju Era AI"
                                            required>

                                    </div>

                                    <div class="invalid-feedback">
                                        Tema event wajib diisi.
                                    </div>

                                </div>

                            </div>

                            <div class="form-group mb-4">

                                <label class="modern-label">
                                    Metode Pelaksanaan
                                    <span class="text-danger">*</span>
                                </label>

                                <small class="form-hint mb-3">
                                    Tentukan bagaimana peserta mengikuti event Anda.
                                </small>

                                <div class="row">

                                    <div class="col-md-6 mb-3">

                                        <input
                                            type="radio"
                                            id="mode_online"
                                            name="event_mode"
                                            value="Online"
                                            checked
                                            class="premium-radio-check">

                                        <label class="event-mode-card" for="mode_online">

                                            <div class="mode-icon mode-online">

                                                <i class="fas fa-video"></i>

                                            </div>

                                            <div class="mode-content">

                                                <h6>Online</h6>

                                                <p>
                                                    Zoom, Google Meet, YouTube Live, dll.
                                                </p>

                                            </div>

                                            <i class="fas fa-check-circle mode-check"></i>

                                        </label>

                                    </div>

                                    <div class="col-md-6">

                                        <input
                                            type="radio"
                                            id="mode_offline"
                                            name="event_mode"
                                            value="Offline"
                                            class="premium-radio-check">

                                        <label class="event-mode-card" for="mode_offline">

                                            <div class="mode-icon mode-offline">

                                                <i class="fas fa-map-marker-alt"></i>

                                            </div>

                                            <div class="mode-content">

                                                <h6>Offline</h6>

                                                <p>
                                                    Gedung, Aula, Hotel, Convention Hall.
                                                </p>

                                            </div>

                                            <i class="fas fa-check-circle mode-check"></i>

                                        </label>

                                    </div>

                                </div>

                            </div>

                            <div class="form-group mb-4">

                                <label
                                    id="location_input_label"
                                    for="location_detail"
                                    class="modern-label">

                                    Tautan Ruang Meeting Virtual
                                    <span class="text-danger">*</span>

                                </label>

                                <small
                                    id="location_hint"
                                    class="form-hint mb-2">

                                    Masukkan URL Zoom, Google Meet, atau platform lainnya.

                                </small>

                                <div class="modern-input-wrapper">

                                    <i
                                        {{-- id="location_icon"
                                        class="fas fa-link input-icon text-primary"> --}}

                                    </i>

                                    <input
                                        type="text"
                                        id="location_detail"
                                        name="location_detail"
                                        class="form-control modern-input"
                                        placeholder="https://zoom.us/j/123456789"
                                        required>

                                </div>

                                <div
                                    class="invalid-feedback"
                                    id="location_feedback">

                                    Detail lokasi tidak boleh kosong.

                                </div>
                            </div>
                            

                            <div class="form-row">

                                <!-- START -->
                        
                                <div class="col-lg-12 mb-4">
                                    <label class="modern-label">
                                            Tanggal event
                                            <span class="text-danger">*</span>
                                        </label>

                                    <div class="datetime-group">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <small class="form-hint mb-2">
                                                    Tanggal mulai
                                                </small>

                                                <div class="datetime-card">

                                                    <i class="far fa-calendar-alt datetime-icon"></i>

                                                    <input
                                                        type="date"
                                                        id="start_date"
                                                        name="start_date"
                                                        class="modern-date-input"
                                                        required>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                
                                                <small class="form-hint mb-2">
                                                    Tanggal selesai
                                                </small>

                                                <div class="datetime-card">

                                                    <i class="far fa-calendar-alt datetime-icon"></i>

                                                    <input
                                                        type="date"
                                                        id="end_date"
                                                        name="end_date"
                                                        class="modern-date-input"
                                                        required>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="form-group mb-0">

                                <label class="modern-label">
                                    Deskripsi Event
                                    <span class="text-danger">*</span>
                                </label>

                                <small class="form-hint mb-3">
                                    Jelaskan informasi lengkap mengenai event, agenda, benefit, narasumber, serta hal penting lainnya.
                                </small>

                                <div class="trix-wrapper">

                                    <input
                                        id="description"
                                        type="hidden"
                                        name="description"
                                        required>

                                    <trix-editor
                                        input="description"
                                        class="modern-trix">

                                    </trix-editor>

                                </div>

                                <div class="description-tip mt-3">

                                    <div class="tip-icon">

                                        <i class="fas fa-lightbulb"></i>

                                    </div>

                                    <div>

                                        <strong>Tips membuat deskripsi yang menarik</strong>

                                        <ul class="mb-0 mt-2">
                                            <li>Jelaskan tujuan event.</li>
                                            <li>Sebutkan benefit yang diperoleh peserta.</li>
                                            <li>Tampilkan narasumber utama.</li>
                                            <li>Tambahkan rundown atau agenda singkat.</li>
                                        </ul>

                                    </div>

                                </div>

                                <div class="invalid-feedback">
                                    Tuliskan deskripsi event.
                                </div>

                            </div>
                        </div>

                        <!-- STEP 3 — TIKET & FORM CUSTOM -->
                        <div id="step-3-content" class="step-content">

                            <div class="section-header mb-4 border-bottom pb-3">
                                <div class="section-icon">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <div class="section-content">
                                    <span class="section-step">
                                        TICKET BUILDER
                                    </span>
                                    <p class="section-desc">
                                        Buat tiketmu disini
                                    </p>

                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <button type="button" id="addTicketBtn" class="ticket-create-btn">
                                    <i class="fas fa-plus mr-1"></i> Tambah Kelas Tiket
                                </button>
                            </div>

                            <div id="ticket-wrapper" class="ticket-list t">
                                <div class="repeater-item ticket-card active">
                                    <div class="ticket-card-header pb-2">

                                        <div class="ticket-card-left">

                                            <div class="ticket-icon">

                                                <i class="fas fa-ticket-alt"></i>

                                            </div>

                                            <div>

                                                <h4>

                                                    TICKET

                                                </h4>

                                                {{-- <span>

                                                    Tiket #1

                                                </span> --}}

                                            </div>

                                        </div>

                                        {{-- <div class="ticket-card-right">

                                            <button
                                            class="ticket-delete">

                                            <i class="far fa-trash-alt"></i>

                                            Hapus

                                        </button>

                                        </div> --}}

                                    </div>

                                    <div class="ticket-body mt-4">

                                        <div class="row">

                                            <div class="col-lg-12">

                                                <label>

                                                    Nama Tiket

                                                </label>

                                                <input name="ticket_name[]"
                                                    type="text"
                                                    placeholder="VIP Early Bird">

                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-4 mt-4">

                                                <label>

                                                    Harga

                                                </label>

                                                <div class="ticket-price">

                                                    <span>

                                                        Rp

                                                    </span>

                                                    <input name="ticket_price[]"
                                                        type="number"
                                                        placeholder="100000">

                                                </div>

                                            </div>

                                            <div class="col-lg-4 mt-4">

                                                <label>

                                                    Maksimal Pembelian

                                                </label>

                                                <input
                                                    type="number"
                                                    placeholder="2">

                                            </div>

                                            <div class="col-lg-4 mt-4">

                                                <label>

                                                    hhshshsh

                                                </label>

                                                <input name="ticket_stock[]"
                                                    type="number"
                                                    placeholder="2">

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-4 mt-4">

                                                <label>

                                                    Harga

                                                </label>

                                                <div class="ticket-price">

                                                    <span>

                                                        Rp

                                                    </span>

                                                    <input name="ticket_price2[]"
                                                        type="number"
                                                        placeholder="100000">

                                                </div>

                                            </div>

                                            <div class="col-lg-4 mt-4">

                                                <label>

                                                    Maksimal Pembelian

                                                </label>

                                                <input
                                                    type="number"
                                                    placeholder="2">

                                            </div>

                                            <div class="col-lg-4 mt-4">

                                                <label>

                                                    hhshshsh

                                                </label>

                                                <input name="ticket_stock2[]"
                                                    type="number"
                                                    placeholder="2">

                                            </div>

                                        </div>
                                    </div>

                                    {{-- <div class="form-row align-items-center">
                                        <div class="col-md-5 mb-2 mb-md-0">
                                            <label class="small font-weight-bold text-secondary">Nama Kategori Tiket <span class="text-danger">*</span></label>
                                            <input type="text" name="ticket_name[]" class="form-control form-control-sm" placeholder="Contoh: Reguler / VIP Pas / Early Bird" required>
                                        </div>
                                        <div class="col-md-4 col-6 mb-2 mb-md-0">
                                            <label class="small font-weight-bold text-secondary">Harga Tiket (Rupiah) <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text bg-white">Rp</span></div>
                                                <input type="number" name="ticket_price[]" min="0" class="form-control" placeholder="Isi 0 jika Gratis" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <label class="small font-weight-bold text-secondary">Kuota Tersedia <span class="text-danger">*</span></label>
                                            <input type="number" name="ticket_stock[]" min="1" class="form-control form-control-sm" placeholder="Contoh: 100" required>
                                        </div>
                                    </div> --}}

                                    <button
                    class="ticket-delete mt-3">

                    <i class="far fa-trash-alt"></i>

                    Hapus Tiket

                </button>
                                </div>
                            </div>

                            <div class="ticket-list">

        <!-- Ticket -->

        <div class="ticket-card active">

            <!-- Header -->

            <div class="ticket-card-header">

                <div class="ticket-card-left">

                    <div class="ticket-icon">

                        <i class="fas fa-ticket-alt"></i>

                    </div>

                    <div>

                        <h4>

                            TICKET

                        </h4>

                        {{-- <span>

                            Tiket #1

                        </span> --}}

                    </div>

                </div>

                {{-- <div class="ticket-card-right">

                    <button
                    class="ticket-delete">

                    <i class="far fa-trash-alt"></i>

                    Hapus

                </button>

                </div> --}}

            </div>

            <!-- Body -->

            <div class="ticket-body">

                <div class="row">

                    <div class="col-lg-8">

                        <label>

                            Nama Tiket

                        </label>

                        <input
                            type="text"
                            placeholder="VIP Early Bird">

                    </div>

                    <div class="col-lg-4">

                        <label>

                            Kuota

                        </label>

                        <input
                            type="number"
                            placeholder="100">

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-lg-6">

                        <label>

                            Harga

                        </label>

                        <div class="ticket-price">

                            <span>

                                Rp

                            </span>

                            <input
                                type="number"
                                placeholder="100000">

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <label>

                            Maksimal Pembelian

                        </label>

                        <input
                            type="number"
                            placeholder="2">

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-lg-6">

                        <label>

                            Penjualan Dibuka

                        </label>

                        <input
                            type="date">

                    </div>

                    <div class="col-lg-6">

                        <label>

                            Penjualan Ditutup

                        </label>

                        <input
                            type="date">

                    </div>

                </div>

                <div class="mt-4">

                    <label>

                        Deskripsi Tiket

                    </label>

                    <textarea
                        rows="3"
                        placeholder="Benefit tiket ini..."></textarea>

                </div>

            </div>

            <!-- Footer -->

            <div class="ticket-footer">

                <div class="ticket-switch">

                    <input
                        type="checkbox"
                        checked>

                    <span>

                        Tampilkan tiket kepada peserta

                    </span>

                </div>

                <button
                    class="ticket-delete">

                    <i class="far fa-trash-alt"></i>

                    Hapus Tiket

                </button>

            </div>

        </div>

    </div>

                            <!-- =========================
    TICKET BUILDER
========================== -->

<section class="ticket-builder">

    <div class="ticket-builder-top">

        <div>

            <span class="ticket-step">
                STEP 3
            </span>

            <h2 class="ticket-builder-title">
                Ticket Builder
            </h2>

            <p class="ticket-builder-desc">
                Buat beberapa kategori tiket yang dapat dipilih peserta saat melakukan registrasi.
            </p>

        </div>

        <button
            type="button"
            class="ticket-create-btn">

            <i class="fas fa-plus"></i>

            Tambah Tiket

        </button>

    </div>

    <!-- LIST TICKET -->

    <div class="ticket-list">

        <!-- Ticket -->

        <div class="ticket-card active">

            <!-- Header -->

            <div class="ticket-card-header">

                <div class="ticket-card-left">

                    <div class="ticket-icon">

                        <i class="fas fa-ticket-alt"></i>

                    </div>

                    <div>

                        <h4>

                            VIP Early Bird

                        </h4>

                        <span>

                            Tiket #1

                        </span>

                    </div>

                </div>

                <div class="ticket-card-right">

                    <span class="ticket-badge paid">

                        Berbayar

                    </span>

                </div>

            </div>

            <!-- Body -->

            <div class="ticket-body">

                <div class="row">

                    <div class="col-lg-8">

                        <label>

                            Nama Tiket

                        </label>

                        <input
                            type="text"
                            placeholder="VIP Early Bird">

                    </div>

                    <div class="col-lg-4">

                        <label>

                            Kuota

                        </label>

                        <input
                            type="number"
                            placeholder="100">

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-lg-6">

                        <label>

                            Harga

                        </label>

                        <div class="ticket-price">

                            <span>

                                Rp

                            </span>

                            <input
                                type="number"
                                placeholder="100000">

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <label>

                            Maksimal Pembelian

                        </label>

                        <input
                            type="number"
                            placeholder="2">

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-lg-6">

                        <label>

                            Penjualan Dibuka

                        </label>

                        <input
                            type="date">

                    </div>

                    <div class="col-lg-6">

                        <label>

                            Penjualan Ditutup

                        </label>

                        <input
                            type="date">

                    </div>

                </div>

                <div class="mt-4">

                    <label>

                        Deskripsi Tiket

                    </label>

                    <textarea
                        rows="3"
                        placeholder="Benefit tiket ini..."></textarea>

                </div>

            </div>

            <!-- Footer -->

            <div class="ticket-footer">

                <div class="ticket-switch">

                    <input
                        type="checkbox"
                        checked>

                    <span>

                        Tampilkan tiket kepada peserta

                    </span>

                </div>

                <button
                    class="ticket-delete">

                    <i class="far fa-trash-alt"></i>

                    Hapus Tiket

                </button>

            </div>

        </div>

        <!-- Add Card -->

        <button class="ticket-add-card">

            <div>

                <i class="fas fa-plus-circle"></i>

            </div>

            <strong>

                Tambah Kategori Tiket

            </strong>

            <small>

                Klik untuk membuat tiket baru

            </small>

        </button>

    </div>

</section>
                            {{-- <div class="pb-3 mb-4 border-bottom">
                                <h4 class="font-weight-bold text-dark mb-1">Step 3 — Manajemen Tiket & Form Kustom</h4>
                                <p class="text-muted small mb-0">Kelola kuota kategori tiket dan buatlah pertanyaan tambahan secara fleksibel untuk diisi peserta.</p>
                            </div> --}}

                            

                            {{-- <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="font-weight-bold text-dark mb-0">1. Konfigurasi Kategori Kelas Tiket</label>
                                    <button type="button" id="addTicketBtn" class="btn btn-sm btn-primary font-weight-bold rounded-pill px-3">
                                        <i class="fas fa-plus mr-1"></i> Tambah Kelas Tiket
                                    </button>
                                </div>

                                <div id="ticket-wrapper">
                                    <div class="repeater-item">
                                        <div class="form-row align-items-center">
                                            <div class="col-md-5 mb-2 mb-md-0">
                                                <label class="small font-weight-bold text-secondary">Nama Kategori Tiket <span class="text-danger">*</span></label>
                                                <input type="text" name="ticket_name[]" class="form-control form-control-sm" placeholder="Contoh: Reguler / VIP Pas / Early Bird" required>
                                            </div>
                                            <div class="col-md-4 col-6 mb-2 mb-md-0">
                                                <label class="small font-weight-bold text-secondary">Harga Tiket (Rupiah) <span class="text-danger">*</span></label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend"><span class="input-group-text bg-white">Rp</span></div>
                                                    <input type="number" name="ticket_price[]" min="0" class="form-control" placeholder="Isi 0 jika Gratis" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <label class="small font-weight-bold text-secondary">Kuota Tersedia <span class="text-danger">*</span></label>
                                                <input type="number" name="ticket_stock[]" min="1" class="form-control form-control-sm" placeholder="Contoh: 100" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="border-top pt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0">2. Form Pertanyaan Kustom Tambahan (Opsional)</label>
                                    <button type="button" id="addCustomFieldBtn" class="btn btn-sm btn-outline-primary font-weight-bold rounded-pill px-3">
                                        <i class="fas fa-folder-plus mr-1"></i> Tambah Form Kustom
                                    </button>
                                </div>
                                <p class="text-muted small mb-3">Secara default pendaftaran hanya meminta data <b>Nama Lengkap</b> & <b>Email</b>. Tambahkan form isian lain di bawah ini jika diperlukan.</p>

                                <div id="custom-field-wrapper">
                                    <!-- Elemen kustom form di-inject via JS -->
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4 — REVIEW & PUBLISH -->
                        <div id="step-4-content" class="step-content">
                            <div class="pb-3 mb-4 border-bottom">
                                <h4 class="font-weight-bold text-dark mb-1">Step 4 — Tinjau Data & Publikasikan</h4>
                                <p class="text-muted small mb-0">Periksa kembali ringkasan struktur kelengkapan data sebelum event diterbitkan ke publik.</p>
                            </div>

                            <div class="summary-card mb-4 text-dark small shadow-sm">
                                <div class="row">
                                    <div class="col-12 mb-4 border-bottom pb-3 text-center text-md-left">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Judul Utama & Custom Link Event</span>
                                        <h4 id="review-name" class="font-weight-bold text-primary mb-1">-</h4>
                                        <span id="review-url" class="badge badge-primary font-weight-normal px-3 py-2 mt-1" style="border-radius:30px; font-size:0.85rem;"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Penanggung Jawab Acara</span>
                                        <span id="review-organizer" class="font-weight-bold h6 text-dark">-</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Kategori & Tema Dasar</span>
                                        <span id="review-cat-theme" class="font-weight-bold h6 text-dark">-</span>
                                    </div>
                                    <div class="col-sm-6 mb-3 border-top pt-3">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Waktu Mulai Acara</span>
                                        <span id="review-start" class="text-secondary font-weight-bold">-</span>
                                    </div>
                                    <div class="col-sm-6 mb-3 border-top pt-3">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Waktu Selesai Acara</span>
                                        <span id="review-end" class="text-secondary font-weight-bold">-</span>
                                    </div>
                                    <div class="col-12 mb-3 border-top pt-3">
                                        <span id="review-location-title" class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Lokasi Pertemuan</span>
                                        <span id="review-location" class="text-dark font-weight-bold font-italic text-break">-</span>
                                    </div>
                                    <div class="col-12 mb-3 border-top pt-3">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Struktur Kategori Tiket</span>
                                        <div id="review-tickets-area" class="mt-1"></div>
                                    </div>
                                    <div class="col-12 border-top pt-3">
                                        <span class="text-muted d-block text-uppercase font-weight-bold tracking-wider mb-1" style="font-size:0.7rem;">Formulir Data yang Diwajibkan Peserta</span>
                                        <div id="review-fields-area" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-control custom-checkbox pt-2">
                                <input type="checkbox" class="custom-control-input" id="terms" required>
                                <label class="custom-control-label text-muted small" for="terms" style="line-height: 1.6; cursor: pointer;">Saya menjamin validitas seluruh data isian manajemen event ini dan bersedia mengikuti regulasi operasional serta bertanggung jawab penuh atas keabsahan publikasi acara. <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Anda harus menyetujui pernyataan persetujuan sebelum mengirim formulir.</div>
                            </div>
                        </div>

                        <!-- Footer Navigasi -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-4">
                            <button type="button" id="prevBtn" onclick="navigateStep(-1)" class="btn btn-light px-4 py-2 font-weight-bold invisible" style="border-radius: var(--radius-md); color: var(--text-muted);">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </button>
                            <button type="button" id="nextBtn" onclick="navigateStep(1)" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: var(--radius-md); background-color: var(--primary); border-color: var(--primary);">
                                Selanjutnya<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    let currentStep = 1;
    const totalSteps = 4;

    // Mapping Nama Step & Persentase Progress
    const stepNames = {
        1: "Informasi Dasar",
        2: "Detail Event",
        3: "Manajemen Tiket & Form Kustom",
        4: "Tinjau Data & Publikasikan"
    };

    const stepPercentages = {
        1: "25%",
        2: "50%",
        3: "75%",
        4: "100%"
    };

    // Cache DOM Elements
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const form = document.getElementById('eventForm');
    const organizerRadioIndividu = document.getElementById('p_individu');
    const organizerRadioOrganisasi = document.getElementById('p_organisasi');
    const usernameContainer = document.getElementById('username-container');
    const orgSelectContainer = document.getElementById('org-select-container');
    const organizationId = document.getElementById('organization_id');
    const modeOnline = document.getElementById('mode_online');
    const modeOffline = document.getElementById('mode_offline');
    const locationLabel = document.getElementById('location_input_label');
    const locationDetail = document.getElementById('location_detail');
    const locationFeedback = document.getElementById('location_feedback');
    const fileInput = document.getElementById('event_banner');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');
    const removeFileBtn = document.getElementById('remove-file-btn');
    const addTicketBtn = document.getElementById('addTicketBtn');
    const ticketWrapper = document.getElementById('ticket-wrapper');
    const addCustomFieldBtn = document.getElementById('addCustomFieldBtn');
    const customFieldWrapper = document.getElementById('custom-field-wrapper');
    const dynamicStepIndicator = document.getElementById('dynamic-step-indicator');

    // 1. Tipe Penyelenggara Toggle
    organizerRadioIndividu.addEventListener('change', function() {
        if(this.checked) {
            usernameContainer.classList.remove('d-none');
            orgSelectContainer.classList.add('d-none');
            organizationId.removeAttribute('required');
        }
    });
    organizerRadioOrganisasi.addEventListener('change', function() {
        if(this.checked) {
            usernameContainer.classList.add('d-none');
            orgSelectContainer.classList.remove('d-none');
            organizationId.setAttribute('required', 'required');
        }
    });

    // 2. Online / Offline Handler Input
    modeOnline.addEventListener('change', function() {
        if(this.checked) {
            locationLabel.innerHTML = 'Tautan Ruang Meeting Virtual <span class="text-danger">*</span>';
            locationDetail.placeholder = 'Masukkan link URL Zoom, Google Meet, atau YouTube Live Stream';
            locationFeedback.textContent = 'Detail tautan konferensi online tidak boleh kosong.';
        }
    });
    modeOffline.addEventListener('change', function() {
        if(this.checked) {
            locationLabel.innerHTML = 'Detail Alamat Lokasi Fisik Event <span class="text-danger">*</span>';
            locationDetail.placeholder = 'Contoh: Gedung Nusantara Room Lt. 3, Jl. Asia Afrika No. 12, Bandung';
            locationFeedback.textContent = 'Detail alamat fisik gedung penyelenggaraan wajib diisi.';
        }
    });

    // 3. Banner Upload Preview
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    // 3. Banner Upload Preview
fileInput.addEventListener('change', function () {

    const file = this.files[0];

    if (file) {

        const reader = new FileReader();

        reader.onload = function (e) {

            imagePreview.src = e.target.result;

            uploadPlaceholder.classList.add('d-none');
            previewContainer.classList.remove('d-none');

            document.getElementById('error-event_banner').classList.add('d-none');
            fileInput.classList.remove('is-invalid');

        };

        reader.readAsDataURL(file);

    }

});

removeFileBtn.addEventListener('click', function (e) {

    e.preventDefault();

    fileInput.value = "";

    imagePreview.src = "#";

    previewContainer.classList.add('d-none');
    uploadPlaceholder.classList.remove('d-none');

});

    // 4. Dynamic Repeater Tiket
    addTicketBtn.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'repeater-item';
        row.innerHTML = `
            <button type="button" class="btn-delete-repeater remove-ticket-btn" style="position: absolute; right: 12px; top: -14px;" title="Hapus Kategori">&times;</button>
            <div class="form-row align-items-center">
                <div class="col-md-5 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-secondary">Nama Kategori Tiket <span class="text-danger">*</span></label>
                    <input type="text" name="ticket_name[]" class="form-control form-control-sm" placeholder="Contoh: Tiket Reguler / VIP Pas" required>
                </div>
                <div class="col-md-4 col-6 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-secondary">Harga Tiket (Rupiah) <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend"><span class="input-group-text bg-white">Rp</span></div>
                        <input type="number" name="ticket_price[]" min="0" class="form-control" placeholder="Isi 0 jika Gratis" required>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <label class="small font-weight-bold text-secondary">Kuota Tersedia <span class="text-danger">*</span></label>
                    <input type="number" name="ticket_stock[]" min="1" class="form-control form-control-sm" placeholder="Contoh: 100" required>
                </div>
            </div>
        `;
        ticketWrapper.appendChild(row);
    });
    ticketWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-ticket-btn')) {
            e.target.closest('.repeater-item').remove();
        }
    });

    // 5. Dynamic Repeater Form Custom
    addCustomFieldBtn.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'repeater-item bg-white border-primary-light shadow-sm';
        row.innerHTML = `
            <button type="button" class="btn-delete-repeater remove-field-btn" style="position: absolute; right: 12px; top: -14px;" title="Hapus Form Kustom">&times;</button>
            <div class="form-row">
                <div class="col-md-7 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-dark">Nama Kolom / Pertanyaan Form Kustom <span class="text-danger">*</span></label>
                    <input type="text" name="custom_field_label[]" class="form-control form-control-sm" placeholder="Contoh: Nomor WhatsApp / Instansi / Ukuran Baju" required>
                </div>
                <div class="col-md-5">
                    <label class="small font-weight-bold text-dark">Tipe Format Isian Input <span class="text-danger">*</span></label>
                    <select name="custom_field_type[]" class="custom-select custom-select-sm" required>
                        <option value="Teks Pendek">Teks Pendek (Text)</option>
                        <option value="Angka">Angka (Number)</option>
                        <option value="Pilihan Ganda">Pilihan Yes/No (Checkbox)</option>
                        <option value="Teks Panjang">Paragraf Deskriptif (Textarea)</option>
                    </select>
                </div>
            </div>
        `;
        customFieldWrapper.appendChild(row);
    });
    customFieldWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-field-btn')) {
            e.target.closest('.repeater-item').remove();
        }
    });

    // 6. Validasi Form per Step Halaman
    function validateStep(step) {
        let isValid = true;
        
        if (step === 1) {
            const fields = ['event_name', 'event_link'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (organizerRadioOrganisasi.checked && !organizationId.value) {
                organizationId.classList.add('is-invalid');
                isValid = false;
            } else {
                organizationId.classList.remove('is-invalid');
            }

            const errorBanner = document.getElementById('error-event_banner');
            if (!fileInput.files || fileInput.files.length === 0) {
                errorBanner.classList.remove('d-none');
                isValid = false;
            } else {
                errorBanner.classList.add('d-none');
            }

        } else if (step === 2) {
            const fields = ['category', 'theme', 'location_detail', 'start_date', 'end_date', 'description'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        } else if (step === 3) {
            const ticketInputs = ticketWrapper.querySelectorAll('input[required]');
            ticketInputs.forEach(input => {
                if (!input.value.trim() || (input.type === 'number' && input.value < 0)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            const fieldInputs = customFieldWrapper.querySelectorAll('input[required]');
            fieldInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        } else if (step === 4) {
            const terms = document.getElementById('terms');
            if (!terms.checked) {
                terms.classList.add('is-invalid');
                isValid = false;
            } else {
                terms.classList.remove('is-invalid');
            }
        }

        return isValid;
    }

    // 7. Sinkronisasi Data Ke Halaman Review Akhir (Step 4)
    function updateSummary() {
        document.getElementById('review-name').textContent = document.getElementById('event_name').value;
        document.getElementById('review-url').textContent = "Akses Link: event.id/" + document.getElementById('event_link').value;
        
        if (organizerRadioIndividu.checked) {
            document.getElementById('review-organizer').textContent = "Individu (@" + document.getElementById('username_display').value + ")";
        } else {
            const orgSelect = document.getElementById('organization_id');
            const orgText = orgSelect.options[orgSelect.selectedIndex].text;
            document.getElementById('review-organizer').textContent = "Organisasi (" + orgText + ")";
        }

        document.getElementById('review-cat-theme').textContent = document.getElementById('category').value + " — " + document.getElementById('theme').value;
        
        const formatOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit' };
        const startVal = new Date(document.getElementById('start_date').value);
        const endVal = new Date(document.getElementById('end_date').value);
        document.getElementById('review-start').textContent = isNaN(startVal) ? '-' : startVal.toLocaleDateString('id-ID', formatOptions) + ' WIB';
        document.getElementById('review-end').textContent = isNaN(endVal) ? '-' : endVal.toLocaleDateString('id-ID', formatOptions) + ' WIB';
        
        const modeVal = document.querySelector('input[name="event_mode"]:checked').value;
        document.getElementById('review-location-title').textContent = modeVal === 'Online' ? 'Tautan Ruang Virtual (Online)' : 'Alamat Gedung Pertemuan (Offline)';
        document.getElementById('review-location').textContent = document.getElementById('location_detail').value;

        const ticketsArea = document.getElementById('review-tickets-area');
        ticketsArea.innerHTML = '';
        const ticketRows = ticketWrapper.querySelectorAll('.repeater-item');
        ticketRows.forEach(item => {
            const name = item.querySelector('input[name="ticket_name[]"]').value;
            const price = item.querySelector('input[name="ticket_price[]"]').value;
            const stock = item.querySelector('input[name="ticket_stock[]"]').value;
            const priceLabel = price == 0 ? 'Gratis' : 'Rp' + parseInt(price).toLocaleString('id-ID');
            
            if(name) {
                ticketsArea.innerHTML += `<span class="summary-badge"><i class="fas fa-ticket-alt mr-1 text-primary"></i> ${name} (${priceLabel} / Kuota: ${stock})</span>`;
            }
        });

        const fieldsArea = document.getElementById('review-fields-area');
        fieldsArea.innerHTML = '<span class="summary-badge"><i class="fas fa-check-circle text-success mr-1"></i> Nama Lengkap (Sistem)</span><span class="summary-badge"><i class="fas fa-check-circle text-success mr-1"></i> Email Aktif (Sistem)</span>';
        
        const fieldRows = customFieldWrapper.querySelectorAll('.repeater-item');
        fieldRows.forEach(item => {
            const labelName = item.querySelector('input[name="custom_field_label[]"]').value;
            const typeName = item.querySelector('select[name="custom_field_type[]"]').value;
            if(labelName) {
                fieldsArea.innerHTML += `<span class="summary-badge"><i class="fas fa-plus-circle text-info mr-1"></i> ${labelName} [Format: ${typeName}]</span>`;
            }
        });
    }

    // 8. Controller Alur Wizard Navigasi
    function navigateStep(direction) {
        if (direction === 1 && !validateStep(currentStep)) {
            return false;
        }

        document.getElementById(`step-${currentStep}-content`).classList.remove('active');
        currentStep += direction;

        if (currentStep > totalSteps) {
            currentStep = totalSteps;
            if (validateStep(4)) {
                alert('Seluruh data tervalidasi sukses! Formulir dikirim ke Laravel Controller.');
                form.submit();
            }
            return;
        }

        document.getElementById(`step-${currentStep}-content`).classList.add('active');
        updateUI();
        
        if (currentStep === 4) {
            updateSummary();
        }
    }

    // 9. Update UI, Teks Indikator, & Persentase Kemajuan
    function updateUI() {
    //     document.getElementById("progress-badge").innerHTML = stepPercentages[currentStep];

    // document.getElementById("progress-active").style.width =
    // stepPercentages[currentStep];

    // tombol back
    prevBtn.classList.toggle('invisible', currentStep === 1);

    // tombol next
    if (currentStep === totalSteps) {
        nextBtn.innerHTML = 'Publish Event <i class="fas fa-paper-plane ml-2"></i>';
        nextBtn.style.backgroundColor = "var(--success)";
        nextBtn.style.borderColor = "var(--success)";
    } else {
        nextBtn.innerHTML = 'Selanjutnya <i class="fas fa-arrow-right ml-2"></i>';
        nextBtn.style.backgroundColor = "var(--primary)";
        nextBtn.style.borderColor = "var(--primary)";
    }

    // Progress Bar
    const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;

document.getElementById("progress-active").style.width =
    (progress * 0.8) + "%";

    // Update setiap step
    for (let i = 1; i <= totalSteps; i++) {

        const badge = document.getElementById(`badge-step-${i}`);
        const text = document.getElementById(`text-step-${i}`);

        badge.className = "step-circle";
        text.className = "step-label";

        if (i < currentStep) {

            badge.classList.add("done");
            badge.innerHTML = '<i class="fas fa-check"></i>';

            text.classList.add("active");

        } else if (i === currentStep) {

            badge.classList.add("active");
            badge.innerHTML = i;

            text.classList.add("active");

        } else {

            badge.innerHTML = i;

        }
    }
}

// function openDatePicker(id){

//     const input = document.getElementById(id);

//     input.focus();

//     if(input.showPicker){

//         input.showPicker();

//     }

// }

document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#start_date", {
        defaultDate: "today",
        enableTime: true,
        dateFormat: "Y-m-d"
    });

    flatpickr("#end_date", {
        defaultDate: "today",
        enableTime: true,
        dateFormat: "Y-m-d"
    });

});

document.addEventListener("trix-initialize", function () {

    document.querySelectorAll(".trix-button-group--file-tools")
        .forEach(el => el.remove());

});
</script>

@endsection