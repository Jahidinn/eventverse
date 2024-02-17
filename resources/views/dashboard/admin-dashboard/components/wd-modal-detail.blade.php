<!-- Modal -->
<div class="modal fade" id="detailWithdrawModal" tabindex="-1" aria-labelledby="detailWithdrawModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailWithdrawModalLabel">Detail transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-1">
                    <div class="col-6">
                        User
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6" id="wd-user">
                        -
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        Event
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6">
                        <a target="_blank" href="" id="wd-event" class="text-decoration-none">-</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        Amount
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6">
                        <b id="wd-amount" class="text-success">Rp 000</b>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        Rekening
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6">
                        <span id="wd-rekening">000</span>
                        <span class="btn btn-sm btn-light text-secondary" id="copy-rekening">
                            <i class="fas fa-copy"></i>
                        </span>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        Bank
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6" id="wd-bank">
                        BCA
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        Status
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6" id="wd-status">
                        -
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        Last update
                        <span class="float-right">:</span>
                    </div>
                    <div class="col-6" id="wd-date">
                        00 Month 000
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
