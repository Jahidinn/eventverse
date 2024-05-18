<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel"
    aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi pembayaran</h5>
                <button type="button" class="close transaction-cancel-button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row mb-1 p-0 m-0 ">
                    <div class="col-6 m-0 p-1 text-secondary">Nama</div>
                    <div class="col-6 m-0 p-1" id="confirm_nama">Null</div>
                </div>
                <div class="col-md-12 row mb-1 m-0 p-0">
                    <div class="col-6 m-0 p-1 text-secondary">Email</div>
                    <div class="col-6 m-0 p-1" id="confirm_email">Null</div>
                </div>
                <div class="col-md-12 row mb-2 m-0 p-0">
                    <div class="col-6 m-0 p-1 text-secondary">No Hp</div>
                    <div class="col-6 m-0 p-1" id="confirm_nomerhp">Null</div>
                </div>
                <div class="col-md-12 row mb-2 m-0 p-0">
                    <div class="col-md-6 m-0 p-1">
                        <div class="alert alert-primary" role="alert">
                            <span id="confirm_event_title">Null</span>
                            <hr class="my-2">
                            <small><i class="fas fa-user-circle"></i> <span
                                    id="confirm_penyelenggara">Null</span></small>
                        </div>
                    </div>
                    <div class="col-md-6 m-0 p-1">
                        <div class="alert alert-primary" role="alert">
                            <span id="confirm_ticket">Null</span>
                            <span class="btn btn-secondary btn-sm p-0 px-2">
                                <span id="confirm_jumlah_tiket">2</span>X</span>
                            <hr class="mb-1">
                            <div class="row">
                                <div class="col-6"><small>Tiket/pendaftaran</small></div>
                                <div class="col-6">
                                    <small><strong>Rp <span id="confirm_price">000</span></strong></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"><small>Biaya admin</small></div>
                                <div class="col-6">
                                    <small>
                                        <strong>Rp
                                            <span>{{ number_format(config('app.biaya_admin'), 0, ',', '.') }}</span></strong>
                                    </small>
                                </div>
                            </div>

                            <hr class="mb-1">
                            <strong>Total <span>Rp <span id="confirm_total_price">000</span></span></strong>

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
                <button type="button" class="btn btn-secondary transaction-cancel-button">Cancel</button>
                <button type="button" id="pay-button" class="btn btn-primary"><i class="fas fa-check"></i> Bayar
                    sekarang</button>
            </div>
        </div>
    </div>
</div>
