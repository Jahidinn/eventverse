<div id="confirmModal" class="ev-confirm">

    <div class="ev-confirm-backdrop"></div>

    <div class="ev-confirm-dialog">

        <div class="ev-confirm-icon">

            <i class="fa-solid fa-triangle-exclamation"></i>

        </div>

        <h4 id="confirmTitle">

            Delete Item?

        </h4>

        <p id="confirmDescription">

            This action cannot be undone.

        </p>

        <div class="ev-confirm-actions">

            <button
                type="button"
                class="ev-confirm-btn-light"
                id="confirmCancel">

                Cancel

            </button>

            <button
                type="button"
                class="ev-confirm-btn-danger"
                id="confirmAction">

                Delete

            </button>

        </div>

    </div>

</div>

<style>

/* =========================================
   CONFIRM MODAL
========================================= */

.ev-confirm{

    position:fixed;
    inset:0;

    display:flex;
    align-items:center;
    justify-content:center;

    opacity:0;
    visibility:hidden;
    pointer-events:none;

    transition:opacity .25s ease, visibility .25s ease;

    z-index:99999;

}

.ev-confirm.show{

    opacity:1;
    visibility:visible;
    pointer-events:auto;

}

/* =========================================
   BACKDROP
========================================= */

.ev-confirm-backdrop{

    position:absolute;
    inset:0;

    background:rgba(15,23,42,.45);

    backdrop-filter:blur(4px);

    z-index:1;

}

/* =========================================
   DIALOG
========================================= */

.ev-confirm-dialog{

    position:relative;
    z-index:2;

    width:430px;
    max-width:calc(100% - 32px);

    background:#FFF;

    border-radius:22px;

    padding:34px;

    text-align:center;

    box-shadow:0 20px 50px rgba(15,23,42,.18);

    transform:translateY(24px) scale(.96);

    opacity:0;

    transition:all .25s ease;

}

.ev-confirm.show .ev-confirm-dialog{

    transform:translateY(0) scale(1);

    opacity:1;

}

/* =========================================
   ICON
========================================= */

.ev-confirm-icon{

    width:72px;
    height:72px;

    margin:0 auto 22px;

    border-radius:50%;

    background:#FEF2F2;

    color:#DC2626;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:30px;

}

/* =========================================
   TITLE
========================================= */

.ev-confirm-dialog h4{

    margin:0 0 10px;

    font-size:22px;

    font-weight:700;

    color:#0F172A;

}

/* =========================================
   DESCRIPTION
========================================= */

.ev-confirm-dialog p{

    margin:0 0 30px;

    color:#64748B;

    font-size:15px;

    line-height:1.6;

}

/* =========================================
   ACTIONS
========================================= */

.ev-confirm-actions{

    display:flex;

    justify-content:center;

    gap:12px;

}

/* =========================================
   BUTTON LIGHT
========================================= */

.ev-confirm-btn-light{

    border:1px solid #E2E8F0;

    background:#FFF;

    color:#334155;

    padding:12px 22px;

    border-radius:12px;

    font-weight:600;

    cursor:pointer;

    transition:.2s;

}

.ev-confirm-btn-light:hover{

    background:#F8FAFC;

}

/* =========================================
   BUTTON DANGER
========================================= */

.ev-confirm-btn-danger{

    border:none;

    background:#DC2626;

    color:#FFF;

    padding:12px 22px;

    border-radius:12px;

    font-weight:600;

    cursor:pointer;

    transition:.2s;

}

.ev-confirm-btn-danger:hover{

    background:#B91C1C;

}

/* =========================================
   MOBILE
========================================= */

@media(max-width:576px){

    .ev-confirm-dialog{

        width:calc(100% - 24px);

        padding:28px 22px;

    }

    .ev-confirm-actions{

        flex-direction:column-reverse;

    }

    .ev-confirm-btn-light,
    .ev-confirm-btn-danger{

        width:100%;

    }

}

</style>