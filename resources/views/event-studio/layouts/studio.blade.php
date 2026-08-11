<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Eventverse.id | event studio</title>

    <link rel="stylesheet" href="{{ asset('assets/css/studio.css') }}">

     <!-- Favicons -->
    <link href="{{ asset('assets/img/eventverse-icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/eventverse-apple-icon.png') }}" rel="apple-touch-icon">


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="https://unpkg.com/trix@2.1.15/dist/trix.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css"> --}}

    <style>
        /* ==========================================================
   EVENTVERSE STUDIO
========================================================== */

:root{

    --primary: #186deb;
    --primary-dark: #186deb;

    --bg: #F5F7FB;
    --card: #FFFFFF;

    --text: #0F172A;
    --muted: #64748B;

    --border: #E8EDF5;

    --radius:24px;

}

*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}

body{

    background:var(--bg);

    font-family:
        Inter,
        sans-serif;

    color:var(--text);

}


/* =========================================
   CHOICES.JS - EVENTVERSE
========================================= */

.choices{
    margin:0;
}

.choices__inner{

    display:flex;
    align-items:center;

    min-height:58px;

    padding:0 16px !important;

    border:1px solid #E2E8F0;
    border-radius:16px;

    background:#FFF;

    font-size:15px;

    transition:.25s;

}

.choices.is-focused .choices__inner{

    border-color:var(--primary);

    box-shadow:0 0 0 4px rgba(79,110,247,.08);

}

/* text yang dipilih */

.choices__list--single{

    display:flex;
    align-items:center;

    height:56px;

    padding:0 !important;

}

.choices__list--single .choices__item{

    display:flex;
    align-items:center;

    font-weight:500;

}

/* search */

.choices__input{

    background:transparent !important;

    margin:0 !important;

    padding:0 !important;

    font-size:15px;

}

/* dropdown */

.choices__list--dropdown,
.choices__list[aria-expanded]{

    margin-top:8px;

    border:1px solid #E2E8F0;

    border-radius:16px;

    overflow:hidden;

    z-index: 1000;

    box-shadow:0 18px 40px rgba(15,23,42,.08);

}

/* item */

.choices__list--dropdown .choices__item{

    padding:13px 16px;

    font-size:14px;

    transition:.2s;

}

.choices__list--dropdown .choices__item--selectable.is-highlighted{

    background:#EEF2FF;

    color:var(--primary);

}

/* placeholder */

.choices__placeholder{

    opacity:.55;

}

/* Input search dalam dropdown */

.choices__list--dropdown .choices__input,
.choices__list[aria-expanded] .choices__input{

    font-size:15px;

    padding:10px 14px !important;

    min-height:42px;

    border:1px solid #E2E8F0;

    border-radius:12px;

    margin:10px !important;

    width:calc(100% - 20px);

    box-sizing:border-box;

}

/* Focus */

.choices__list--dropdown .choices__input:focus,
.choices__list[aria-expanded] .choices__input:focus{

    border-color:var(--primary);

    box-shadow:0 0 0 3px rgba(79,110,247,.08);

}

/* Placeholder */

.choices__list--dropdown .choices__input::placeholder{

    color:#94A3B8;

}

/* arrow */
/* 
.choices[data-type*="select-one"]::after{

    border:none;

    content:"\f078";

    font-family:"Font Awesome 6 Free";

    font-weight:900;

    color:#94A3B8;

    top:50%;

    right:18px;

    transform:translateY(-50%);

    margin:0;

}

.choices[data-type*="select-one"].is-open::after{

    transform:translateY(-50%) rotate(180deg);

} */

/* hilangkan garis atas dropdown */

.choices[data-type*="select-one"] .choices__inner{

    padding-bottom:0;

}

/* hilangkan border default */

.choices.is-open .choices__inner{

    border-radius:16px;

}

/* disabled */

.choices.is-disabled .choices__inner{

    background:#F8FAFC;

}


/* ==========================================================
LAYOUT
========================================================== */

.studio{

    display:flex;

    min-height:100vh;

}


/* ==========================================================
SIDEBAR
========================================================== */

.sidebar{

    width:280px;

    background:#fff;

    border-right:1px solid var(--border);

    display:flex;

    flex-direction:column;

    padding:26px;

    transition:.3s;

    z-index:999;

}


.sidebar-overlay{

    position:fixed;

    inset:0;

    background:rgba(15,23,42,.35);

    backdrop-filter:blur(2px);

    opacity:0;

    visibility:hidden;

    transition:.25s;

    z-index:998;

}

.sidebar-overlay.show{

    opacity:1;

    visibility:visible;

}


/* ==========================================================
LOGO
========================================================== */

.logo{

    display:flex;

    align-items:center;

    gap:16px;

}

.logo-icon{

    width:56px;

    height:56px;

    border-radius:18px;

    background:

        linear-gradient(
            135deg,
            #5B7FFF,
            #7A5FFF
        );

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

    font-size:20px;

    box-shadow:

        0 12px 25px rgba(91,127,255,.25);

}

.logo-text h4{

    font-size:1.15rem;

    margin-bottom:2px;

}

.logo-text span{

    color:var(--muted);

    font-size:.82rem;

}


/* ==========================================================
MENU
========================================================== */

.sidebar-menu{

    margin-top:45px;

}

.menu-item{

    display:flex;

    align-items:center;

    gap:16px;

    padding:10px;

    border-radius:18px;

    text-decoration:none;

    color:var(--text);

    margin-bottom:10px;

    transition:.25s;

}

.menu-icon{

    width:38px;

    height:38px;

    border-radius:14px;

    background:#F5F7FC;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

}

.menu-content{

    display:flex;

    flex-direction:column;

}

.menu-title{

    font-weight:700;

}

.menu-content small{

    color:var(--muted);

    font-size:.75rem;

}


/* ==========================================================
BOTTOM
========================================================== */

.dashboard-btn{

    display:flex;

    align-items:center;

    gap:14px;

    text-decoration:none;

    color:var(--muted);

    padding:16px;

    border-radius:18px;

    background:#F8FAFC;

}


/* ==========================================================
CONTENT
========================================================== */

.content{

    flex:1;

    display:flex;

    flex-direction:column;

}


/* ==========================================================
HEADER
========================================================== */

.studio-header{

    display:flex;

    align-items:center;

    justify-content:space-between;

    height:78px;

    margin:18px 18px 18px 0;

    padding:0 28px;

    background:#fff;

    border-radius:24px;

    border:1px solid #EEF2F7;

    box-shadow:0 10px 30px rgba(15,23,42,.05);

}

.header-left{

    display:flex;

    align-items:center;

    gap:16px;

}

.studio-brand{

    font-size:1rem;

    font-weight:700;

    color:#0F172A;

}

.page-header{

    /* margin-bottom:36px; */

}

.page-badge{

    display:inline-block;

    padding:6px 14px;

    border-radius:999px;

    background:#EEF5FF;

    color:#5B7FFF;

    font-size:14px;

    font-weight:700;

    margin-bottom:0px;

}

.page-subtitle{

    max-width:620px;

    color:#64748B;

    font-size:13px;

    line-height:1.7;

    margin:0;

}

/* .page-header h1{

    font-size:2rem;

    font-weight:800;

    color:#0F172A;

    margin-bottom:8px;

}

.page-header p{

    color:#64748B;

    font-size:1rem;

    max-width:600px;

    margin:0;

} */


/* ==========================================================
BUTTON
========================================================== */

.btn-light{

    height:52px;

    padding:0 28px;

    border:none;

    border-radius:16px;

    background:#F8FAFC;

    color:#0F172A;

    font-weight:600;

    transition:.25s;

}

.btn-light:hover{

    background:#EEF2F7;

}

.btn-primary{

    height:52px;

    padding:0 30px;

    border:none;

    border-radius:16px;

    background:linear-gradient(135deg,#5B7FFF,#6C63FF);

    color:#fff;

    font-weight:700;

    box-shadow:0 12px 30px rgba(91,127,255,.25);

    transition:.25s;

}

.btn-primary:hover{

    transform:translateY(-2px);

    box-shadow:0 18px 35px rgba(91,127,255,.30);

}


/* ==========================================================
PAGE
========================================================== */

.studio-page{

    margin: 18px 18px 18px 0;

    margin-top:0px;

    padding:20px;

    background:#fff;

    border-radius:28px;

    border:1px solid #EEF2F7;

    box-shadow:0 10px 40px rgba(15,23,42,.06);

}


/* ==========================================================
TOGGLE
========================================================== */

#sidebarToggle{

    display:none;

    width:48px;

    height:48px;

    border:none;

    border-radius:14px;

    background:#F5F7FC;

    font-size:18px;

}


/* ==========================================================
TABLET
========================================================== */

/* @media(max-width:1200px){

.sidebar{

    width:92px;

    padding:20px;

}

.logo-text{

    display:none;

}

.menu-content{

    display:none;

}

.dashboard-btn span{

    display:none;

}

.dashboard-btn{

    justify-content:center;

}

.menu-item{

    justify-content:center;

}

} */


/* ==========================================================
MOBILE
========================================================== */

/* @media(max-width:768px){

.sidebar{

    position:fixed;

    left:-320px;

    top:0;

    height:100vh;

    width:280px;

    z-index:999;

}

.content{

    width:100%;

}

#sidebarToggle{

    display:flex;

    align-items:center;

    justify-content:center;

}

.studio-header{

    padding:0 20px;

}

.header-right{

    display:none;

}

.studio-page{

    padding:22px;

}

} */

@media (max-width:998px){

.sidebar{

    width:280px;

    overflow-y:auto;

}

.sidebar-menu{

    margin-top:24px;

}

.sidebar-menu::before{

    left:34px;
    top:22px;
    bottom:22px;

}

.menu-item{

    padding:12px;

    gap:14px;

    margin-bottom:8px;

}

.menu-icon{

    width:48px;

    height:48px;

    border-radius:14px;

    font-size:18px;

    flex-shrink:0;

}

.menu-content{

    flex:1;

}

.menu-title{

    font-size:1rem;

}

.menu-content small{

    font-size:.78rem;

}

.menu-item.active{

    border-radius:18px;

}

}

/* ==========================================================
   PREMIUM SIDEBAR
========================================================== */

.sidebar{

    position:sticky;

    top:18px;

    left:18px;

    margin:18px;

    height:calc(100vh - 36px);

    border-radius:28px;

    box-shadow:
        0 10px 40px rgba(15,23,42,.06);

    overflow:hidden;

}

/* Glow */

.sidebar::before{

    content:"";

    position:absolute;

    top:-100px;

    right:-100px;

    width:220px;

    height:220px;

    border-radius:50%;

    background:
        radial-gradient(
            rgba(91,127,255,.12),
            transparent 70%
        );

}

/* ==========================================================
MENU
========================================================== */

.sidebar-menu{

    position:relative;

    margin-top:40px;

}

/* Timeline */

/* .sidebar-menu::before{

    content:"";

    position:absolute;

    left:37px;

    top:18px;

    bottom:18px;

    width:2px;

    background:#EEF2F7;

} */

.menu-item{

    position:relative;

}

/* Garis atas */

/* .menu-item::before{

    content:"";

    position:absolute;

    left:37px;

    top:-12px;

    width:2px;

    height:24px;

    background:#E9EEF7;

    z-index:0;

} */

/* Garis bawah */

/* .menu-item::after{

    content:"";

    position:absolute;

    left:37px;

    bottom:-12px;

    width:2px;

    height:24px;

    background:#E9EEF7;

    z-index:0;

} */

/* Item pertama */

.menu-item:first-child::before{

    display:none;

}

/* Item terakhir */

.menu-item:last-child::after{

    display:none;

}

/* Icon di atas garis */

.menu-icon{

    position:relative;

    z-index:2;

}

/* ==========================================================
ITEM
========================================================== */

.menu-item{

    transition:.25s;

}

.menu-item:hover{

    background:#F7F9FF;

    box-shadow:0 8px 22px rgba(15,23,42,.05);

}

.menu-item:hover .menu-icon{

    background:#EEF4FF;

    color:var(--primary);

}

/* Active */

.menu-item.active{

    background:white;

    box-shadow:

        0 10px 28px rgba(15,23,42,.06);

}

.menu-left{

    width:64px;

    display:flex;

    justify-content:center;

    position:relative;

    flex-shrink:0;

}

.menu-left::after{

    content:"";

    position:absolute;

    top:52px;

    bottom:-34px;

    width:2px;

    background: #E7EDF7;

}

.menu-item:last-child .menu-left::after{

    display:none;

}

/* .menu-item.active{

    background:#fff;

    border-left:4px solid #5B7FFF;

    box-shadow:0 12px 30px rgba(15,23,42,.08);

} */

/* .menu-item.active::before{

    content:"";

    position:absolute;

    left:-20px;

    top:50%;

    transform:translateY(-50%);

    width:4px;

    height:36px;

    border-radius:999px;

    background:linear-gradient(
        180deg,
        #5B7FFF,
        #7166FF
    );

} */

.menu-item.completed::before{

    background:#22C55E;

}

.menu-item.active .menu-icon{

    background:

        linear-gradient(

            135deg,

            #4587f9,

            #4d8cf9

        );

    color:white;

}

.menu-item.active .menu-title{

    color:#111827;

}

/* ==========================================================
ICON
========================================================== */

.menu-icon{

    transition:.25s;

    flex-shrink:0;

}

.menu-item{

    transition:.25s;

}

/* ==========================================================
HEADER
========================================================== */

/* .studio-header{

    position:sticky;

    top:0;

    z-index:20;

    backdrop-filter:blur(18px);

    background:

        rgba(255,255,255,.82);

} */

/* ==========================================================
BUTTON
========================================================== */

.btn-primary{

    transition:.25s;

}

.btn-primary:hover{

    transform:translateY(-2px);

    box-shadow:

        0 18px 35px rgba(91,127,255,.30);

}

.btn-light{

    transition:.25s;

}

.btn-light:hover{

    background:#EEF4FF;

}

/* ==========================================================
PAGE
========================================================== */

.studio-page{

    animation:fadeStudio .35s;

}

@keyframes fadeStudio{

from{

    opacity:0;

    transform:translateY(12px);

}

to{

    opacity:1;

    transform:none;

}

}

/* ==========================================================
SCROLLBAR
========================================================== */

.sidebar::-webkit-scrollbar{

    width:6px;

}

.sidebar::-webkit-scrollbar-thumb{

    background:#D6DFEA;

    border-radius:999px;

}

/* ==========================================================
TABLET
========================================================== */

/* @media(max-width:1200px){

.sidebar{

    width:86px;

}

.sidebar-menu::before{

    left:42px;

}

.menu-item{

    padding:12px;

}

.menu-item.active::before{

    display:none;

}

.menu-icon{

    margin:auto;

}

} */

/* ==========================================================
MOBILE DRAWER
========================================================== */
@media (max-width:998px){

.sidebar{

    position:fixed;

    left:-320px;

    top:0;

    width:280px;

    height:100vh;

    z-index:999;

    transition:left .3s ease;

}

.sidebar.show{

    left:0;

}

#sidebarToggle{

    display:flex;

    align-items:center;

    justify-content:center;

}

.studio-header{

    height:68px;

    margin:10px;

    padding:0 18px;

}

.studio-page{

    margin:10px;
}

.studio-brand{

    display:none;

}

.page-header h1{

    font-size:1.65rem;

}

.page-header{

    margin-bottom:24px;

}

}


.ev-save-bar{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin:0 18px 18px 0;

    padding:14px 20px;

    border-radius:18px;

    border:1px solid;

    transition:.25s;

    animation:fadeDown .25s;

}

.ev-save-left{

    display:flex;

    align-items:center;

    gap:14px;

}

.ev-save-left i{

    font-size:22px;

}

.ev-save-left strong{

    display:block;

    font-size:15px;

    font-weight:700;

    margin-bottom:2px;

}

.ev-save-left span{

    font-size:13px;

    opacity:.8;

}

/* SUCCESS */

.ev-save-bar.success{

    background:#F0FDF4;

    border-color:#BBF7D0;

    color:#15803D;

}

/* SAVING */

.ev-save-bar.saving{

    background:#EFF6FF;

    border-color:#BFDBFE;

    color:#2563EB;

}

.ev-save-bar.saving i{

    animation:spin 1s linear infinite;

}

/* ERROR */

.ev-save-bar.error{

    background:#FEF2F2;

    border-color:#FECACA;

    color:#DC2626;

}

/* WARNING */

.ev-save-bar.warning{

    background:#FFF7ED;

    border-color:#FED7AA;

    color:#EA580C;

}

@keyframes spin{

    from{

        transform:rotate(0deg);

    }

    to{

        transform:rotate(360deg);

    }

}

@keyframes fadeDown{

    from{

        opacity:0;

        transform:translateY(-8px);

    }

    to{

        opacity:1;

        transform:none;

    }

}



/* =========================================================
   MODAL
========================================================= */

.ev-modal-backdrop{

    position:fixed;

    inset:0;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:24px;

    background:rgba(15,23,42,.45);

    backdrop-filter:blur(6px);

    opacity:0;
    visibility:hidden;

    transition:.25s;

    z-index:9999;

}

.ev-modal-backdrop.show{

    opacity:1;

    visibility:visible;

}

.ev-modal{

    width:100%;
    max-width:760px;

    max-height:90vh;

    overflow:auto;

    background:#FFF;

    border-radius:22px;

    box-shadow:0 30px 80px rgba(15,23,42,.15);

    animation:modalShow .25s ease;

}

/* =========================================================
   HEADER
========================================================= */

.ev-modal-header{

    display:flex;
    align-items:flex-start;
    justify-content:space-between;

    gap:20px;

    padding:26px 30px;

    border-bottom:1px solid #EEF2F7;

}

.ev-modal-header h3{

    margin:0;

    font-size:24px;
    font-weight:700;

    color:#0F172A;

}

.ev-modal-header p{

    margin:8px 0 0;

    color:#64748B;

}

.ev-modal-close{

    width:42px;
    height:42px;

    border:none;

    border-radius:12px;

    background:#F8FAFC;

    cursor:pointer;

    transition:.2s;

}

.ev-modal-close:hover{

    background:#EEF2FF;

    color:var(--primary);

}

/* =========================================================
   BODY
========================================================= */

.ev-modal-header{

    position:sticky;
    top:0;

    z-index:10;

    background:#FFF;
}

.ev-modal form{

    flex:1;

    overflow-y:auto;

    padding:24px 30px;
}

.ev-grid-3{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

}

/* =========================================
   FORM
========================================= */

.ev-field{

    display:flex;
    flex-direction:column;

    margin-bottom:22px;

}

.ev-label{

    display:flex;
    align-items:center;
    gap:6px;

    margin-bottom:10px;

    font-size:14px;
    font-weight:600;

    color:#0F172A;

}

.ev-label span{

    color:#EF4444;

}

.ev-input,
.ev-textarea{

    width:100%;

    height:56px;

    padding:0 18px;

    border:1px solid #E2E8F0;
    border-radius:16px;

    background:#FFF;

    font-size:15px;

    transition:.25s;

}

.ev-textarea{

    min-height:100px;

    padding:16px 18px;

    resize:vertical;

}

.ev-input:focus,
.ev-textarea:focus{

    outline:none;

    border-color:var(--primary);

    box-shadow:0 0 0 4px rgba(79,110,247,.08);

}

.ev-input::placeholder,
.ev-textarea::placeholder{

    color:#94A3B8;

}


/* =========================================
   INPUT GROUP
========================================= */

.ev-input-group{

    display:flex;

    align-items:center;

    border:1px solid #E2E8F0;
    border-radius:16px;

    overflow:hidden;

    transition:.25s;

    background:#FFF;

}

.ev-input-group:focus-within{

    border-color:var(--primary);

    box-shadow:0 0 0 4px rgba(79,110,247,.08);

}

.ev-input-group span{

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 18px;

    height:56px;

    background:#F8FAFC;

    border-right:1px solid #E2E8F0;

    font-weight:600;

    color:#475569;

}

.ev-input-group .ev-input{

    border:none !important;

    box-shadow:none !important;

    height:56px;

}


/* =========================================
   HELPER
========================================= */

.ev-helper{

    margin-top:8px;

    font-size:13px;

    color:#94A3B8;

}


/* =========================================
   GRID
========================================= */

.ev-grid-price{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

}

.ev-grid-date{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

}


/* =========================================
   DIVIDER
========================================= */

.ev-divider{

    margin:28px 0;

    border-top:1px solid #EEF2F7;

}

.swal2-container{
    z-index: 20000 !important;
}


.sidebar-top{
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0px 20px;
}

.logo{
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo-image{
    width: 180px; /* sesuaikan */
    height: auto;
    display: block;
}
    </style>

</head>

<body>

<div class="studio">

    <!-- ================= SIDEBAR ================= -->

    <aside id="sidebar" class="sidebar">

        <div class="sidebar-top">

            <div class="logo">

                <img
                    src="{{ asset('assets/img/eventverse-color.png') }}"
                    alt="Eventverse"
                    class="logo-image"
                >

            </div>

        </div>

        @php
            $eventId = request()->route('event_id');
        @endphp


        <div class="sidebar-menu">

            <a href="{{ route('event-studio.basic', $eventId) }}" class="menu-item {{ Request::is('event-studio/*/basic*') ? 'active' : '' }}">

                <div class="menu-left">

                    <div class="menu-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                </div>

                <div class="menu-content">

                    <span class="menu-title">

                        Informasi

                    </span>

                    <small>

                        Basic information

                    </small>

                </div>

            </a>

            <a href="{{ route('event-studio.detail', $eventId) }}" class="menu-item {{ Request::is('event-studio/*/detail*') ? 'active' : '' }}">

                <div class="menu-left">

                    <div class="menu-icon">

                    <i class="fa-solid fa-location-dot"></i>

                    </div>

                </div>

                <div class="menu-content">

                    <span class="menu-title">

                        Detail

                    </span>

                    <small>

                        Schedule & location

                    </small>

                </div>

            </a>

            <a href="{{ route('event-studio.ticket', $eventId) }}" class="menu-item {{ Request::is('event-studio/*/ticket*') ? 'active' : '' }}">

                <div class="menu-left">
                    
                    <div class="menu-icon">

                        <i class="fa-solid fa-ticket"></i>

                    </div>
                </div>

                <div class="menu-content">

                    <span class="menu-title">

                        Ticket

                    </span>

                    <small>

                        Pricing & quota

                    </small>

                </div>

            </a>

            <a href="{{ route('event-studio.form', $eventId) }}" class="menu-item {{ Request::is('event-studio/*/form*') ? 'active' : '' }}">

                <div class="menu-left">
                    
                    <div class="menu-icon">

                        <i class="fa-solid fa-file-lines"></i>

                    </div>
                </div>

                <div class="menu-content">

                    <span class="menu-title">

                        Form

                    </span>

                    <small>

                        Registration fields

                    </small>

                </div>

            </a>

            <a href="{{ route('event-studio.preview', $eventId) }}" class="menu-item {{ Request::is('event-studio/*/preview*') ? 'active' : '' }}">

                <div class="menu-left">

                    <div class="menu-icon">

                        <i class="fa-solid fa-gear"></i>

                    </div>
                </div>

                <div class="menu-content">

                    <span class="menu-title">

                        Publish

                    </span>

                    <small>

                        Review & publish

                    </small>

                </div>

            </a>

        </div>


        <div class="sidebar-bottom">

            <a href="" class="dashboard-btn">

                <i class="fa-solid fa-arrow-left"></i>

                <span>

                    Dashboard

                </span>

            </a>

        </div>

    </aside>


    <!-- ================= CONTENT ================= -->

    <main class="content">

        <!-- HEADER -->

        <header class="studio-header">

    <div class="header-left">

        <button id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="studio-brand">

            <span>Event studio</span>

        </div>

    </div>

    <div class="header-right">
        <a href="{{ route('event-studio.preview', $eventId) }}">
            <button class="btn-light">
            Preview
        </button>
        </a>
        

        <!-- <button class="btn-primary">
            Publish
        </button> -->

    </div>

    

</header>

<div id="saveIndicator" class="ev-save-bar success">

    <div class="ev-save-left">

        <i id="saveIcon" class="fa-solid fa-circle-check"></i>

        <div>

            <strong id="saveTitle">
                All changes saved
            </strong>

            <span id="saveStatus">
                Your latest changes have been saved automatically.
            </span>

        </div>

    </div>

</div>



        <!-- CONTENT -->

        <div class="studio-page">

            @yield('content')

        </div>

    </main>

</div>





@stack('modals')

<script src="{{ asset('assets/js/studio.js') }}"></script>
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

            this.sidebar.classList.toggle("show");
            this.overlay.classList.toggle("show");

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

                if (data?.field === "slug") {

                    slugStatus.innerHTML =
                        '<i class="fa-solid fa-circle-xmark"></i> ' + data.message;

                    slugStatus.className = "ev-url-status error";

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

    }

    closeSidebar() {

        this.sidebar.classList.remove("show");

        this.overlay.classList.remove("show");

    }

}

window.Studio = new EventVerseStudio();

window.addEventListener("resize", () => {

    if (window.innerWidth > 767) {

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