<style>

.checkout-confirm-modal .modal-content{

    border:none;

    border-radius:28px;

    overflow:hidden;

    box-shadow:
        0 20px 60px rgba(15,23,42,.12);
}

.checkout-confirm-modal .modal-header{

    border:none;

    padding:24px 28px 0;
}

.checkout-confirm-modal .modal-title{

    font-size:22px;

    font-weight:700;

    color:#0f172a;
}

.checkout-confirm-modal .modal-body{

    padding:24px 28px;
}

.confirm-event-card{

    background:#f0f5f8;

    border-radius:18px;

    padding:18px;

    margin-bottom:20px;
}

.confirm-event-title{

    font-size:18px;

    font-weight:700;

    color:#0f172a;
}

.confirm-event-organizer{

    color:#64748b;

    margin-top:4px;
}

/* .confirm-info{

    margin-bottom:14px;
} */

/* .confirm-label{

    color:#64748b;

    font-size:13px;

    margin-bottom:2px;
} */

.confirm-value{

    font-weight:600;

    color:#0f172a;
}

.participant-card{

    display:flex;
    align-items:center;
    gap:14px;

    background:#f0f5f8;

    border-radius:18px;

    padding:16px;

    margin-bottom:20px;
}

.participant-avatar{

    width:48px;
    height:48px;

    border-radius:50%;

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;
}

.participant-name{

    font-weight:700;

    color:#0f172a;
}

.participant-email{

    color:#64748b;

    font-size:14px;
}

.ticket-summary{

    background:#f8fafc;

    border-radius:18px;

    padding:18px;

    margin-top:18px;
}

.ticket-row{

    display:flex;

    justify-content:space-between;

    margin-bottom:10px;
}

.total-box{

    margin-top:15px;

    padding-top:15px;

    border-top:1px solid #e2e8f0;

    text-align:center;
}

.total-label{

    color:#64748b;

    font-size:14px;
}

.total-price{

    font-size:34px;

    font-weight:800;

    color:#16a34a;
}

.modal-footer{

    border:none;

    padding:0 28px 28px;
}

.btn-cancel-modern{

    flex:1;

    height:52px;

    border:none;

    border-radius:14px;

    background:#f1f5f9;

    color:#334155;

    font-weight:600;
}

.btn-pay-modern{

    flex:2;

    height:52px;

    border:none;

    border-radius:14px;

    color:white;

    font-weight:700;

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );
}

</style>

<div class="modal fade checkout-confirm-modal"
     id="checkoutModal"
     tabindex="-1"
     role="dialog"
     data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">
                    Konfirmasi Pesanan
                </h5>

                <button
                    type="button"
                    class="close transaction-cancel-button">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="confirm-event-card">

                    <div class="confirm-event-title">
                        <span id="confirm_event_title">
                            Event
                        </span>
                    </div>

                    <div class="confirm-event-organizer">

                        <i class="ti ti-user"></i>

                        <span id="confirm_penyelenggara">
                            Organizer
                        </span>

                    </div>

                </div>

                <div class="participant-card">

                    <div class="participant-avatar">
                        <i class="ti ti-user"></i>
                    </div>

                    <div>

                        <div class="participant-name">
                            <span id="confirm_nama"></span>
                        </div>

                        <div class="participant-email">
                            <span id="confirm_email"></span>
                        </div>

                    </div>

                </div>

                <div class="ticket-summary">

                    <div class="ticket-row">

                        <span>

                            <strong id="confirm_ticket">
                                Ticket
                            </strong>

                            x<span id="confirm_jumlah_tiket">1</span>

                        </span>

                        <span>

                            Rp <span id="confirm_price"></span>

                        </span>

                    </div>

                    <div class="ticket-row">

                        <span>
                            Biaya Admin
                        </span>

                        <span>

                            Rp {{ number_format(config('app.biaya_admin'),0,',','.') }}

                        </span>

                    </div>

                    <div class="total-box">

                        <div class="total-label">

                            Total Pembayaran

                        </div>

                        <div class="total-price">

                            Rp <span id="confirm_total_price"></span>

                        </div>

                    </div>

                </div>

                <input type="hidden" id="confirm_is_login">
                <input type="hidden" id="confirm_user_login_id">

                <input type="hidden" id="id_event">
                <input type="hidden" id="email_transaction">
                <input type="hidden" id="transaction">

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-cancel-modern transaction-cancel-button">

                    Kembali

                </button>

                <button
                    type="button"
                    id="pay-button"
                    class="btn-pay-modern">

                    <i class="ti ti-credit-card"></i>

                    Lanjut Bayar

                </button>

            </div>

        </div>
    </div>
</div>
