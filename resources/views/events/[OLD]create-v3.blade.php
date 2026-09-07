<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EventVerse Studio</title>

    <link rel="stylesheet" href="{{ asset('assets/css/studio.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        /* ==========================================================
   EVENTVERSE STUDIO
========================================================== */

:root{

    --primary:#5B7FFF;
    --primary-dark:#4A68F6;

    --bg:#F5F7FB;
    --card:#FFFFFF;

    --text:#0F172A;
    --muted:#64748B;

    --border:#E8EDF5;

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

    background:white;

    border-right:1px solid var(--border);

    display:flex;

    flex-direction:column;

    justify-content:space-between;

    padding:26px;

    transition:.3s;

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

    padding:15px;

    border-radius:18px;

    text-decoration:none;

    color:var(--text);

    margin-bottom:10px;

    transition:.25s;

}

.menu-icon{

    width:46px;

    height:46px;

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

    height:88px;

    background:white;

    border-bottom:1px solid var(--border);

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 36px;

}

.header-left{

    display:flex;

    align-items:center;

    gap:18px;

}

.header-left h2{

    font-size:1.5rem;

    margin-bottom:4px;

}

.header-left p{

    color:var(--muted);

    font-size:.88rem;

}

.header-right{

    display:flex;

    gap:14px;

}


/* ==========================================================
BUTTON
========================================================== */

.btn-light{

    border:none;

    padding:12px 22px;

    border-radius:16px;

    background:#F3F6FB;

    font-weight:600;

}

.btn-primary{

    border:none;

    padding:12px 24px;

    border-radius:16px;

    background:

        linear-gradient(
            135deg,
            #5B7FFF,
            #6F63FF
        );

    color:white;

    font-weight:700;

}


/* ==========================================================
PAGE
========================================================== */

.studio-page{

    padding:36px;

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

@media (max-width:767px){

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

    background:#E7EDF7;

}

.menu-item:last-child .menu-left::after{

    display:none;

}
.menu-item.active{

    background:#fff;

    border-left:4px solid #5B7FFF;

    box-shadow:0 12px 30px rgba(15,23,42,.08);

}

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

            #5B7FFF,

            #6F63FF

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

.studio-header{

    position:sticky;

    top:0;

    z-index:20;

    backdrop-filter:blur(18px);

    background:

        rgba(255,255,255,.82);

}

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

@media(max-width:1200px){

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

}

/* ==========================================================
MOBILE DRAWER
========================================================== */
@media (max-width:767px){

.sidebar{

    position:fixed;

    left:-320px;

    top:0;

    width:280px;

    height:100vh;

    margin:0;

    border-radius:0;

    z-index:999;

}

.sidebar.show{

    left:0;

}

#sidebarToggle{

    display:flex;

    align-items:center;

    justify-content:center;

}

}
    </style>

</head>

<body>

<div class="studio">

    <!-- ================= SIDEBAR ================= -->

    <aside id="sidebar" class="sidebar">

        <div class="sidebar-top">

            <div class="logo">

                <div class="logo-icon">

                    EV

                </div>

                <div class="logo-text">

                    <h4>EventVerse</h4>

                    <span>Studio</span>

                </div>

            </div>

        </div>


        <div class="sidebar-menu">

            <a href="#step1" class="menu-item active">

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

            <a href="#step2" class="menu-item">

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

            <a href="#step3" class="menu-item">

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

            <a href="#step4" class="menu-item">

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

            <a href="#step5" class="menu-item">

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

                <div>

                    <h2>

                        Create Event

                    </h2>

                    <p>

                        Build your event from start to publish.

                    </p>

                </div>

            </div>

            <div class="header-right">

                <button class="btn-light">

                    Preview

                </button>

                <button class="btn-primary">

                    Publish

                </button>

            </div>

        </header>


        <!-- CONTENT -->

        <div class="studio-page">

            <section id="step1">

                @yield('step1')

            </section>

            <section id="step2" style="display:none">

                @yield('step2')

            </section>

            <section id="step3" style="display:none">

                @yield('step3')

            </section>

            <section id="step4" style="display:none">

                @yield('step4')

            </section>

            <section id="step5" style="display:none">

                @yield('step5')

            </section>

        </div>

    </main>

</div>

<script src="{{ asset('assets/js/studio.js') }}"></script>

<script>
    class EventVerseStudio {

    constructor() {

        this.sidebar = document.getElementById("sidebar");
        this.toggle = document.getElementById("sidebarToggle");

        this.overlay = null;

        this.init();

    }

    init() {

        this.createOverlay();

        this.bindToggle();

    }

    createOverlay() {

        this.overlay = document.createElement("div");

        this.overlay.className = "sidebar-overlay";

        document.body.appendChild(this.overlay);

        this.overlay.onclick = () => {

            this.closeSidebar();

        };

    }

    bindToggle() {

        if (!this.toggle) return;

        this.toggle.onclick = () => {

            this.sidebar.classList.toggle("show");

            this.overlay.classList.toggle("show");

        };

    }

    openSidebar() {

        this.sidebar.classList.add("show");

        this.overlay.classList.add("show");

    }

    closeSidebar() {

        this.sidebar.classList.remove("show");

        this.overlay.classList.remove("show");

    }

}

const Studio = new EventVerseStudio();

window.addEventListener("resize", () => {

    if(window.innerWidth > 767){

        Studio.closeSidebar();

    }

});
</script>

</body>
</html>