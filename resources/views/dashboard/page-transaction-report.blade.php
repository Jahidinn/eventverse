@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white" role="alert">
            <strong>LAPORAN TRANSAKSI</strong> (Penyelenggara)
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title manajemen-event-title">Data transaksi event kamu! <i class="fas fa-paper-plane"></i>
                </h3>
            </div>

            <div class="card-body px-2 pt-3 bg-card-blue">
                <div class="table-responsive py-0 manajemen-event-box">
                    <form action="" method="GET" {{ $listEvent->isEmpty() ? 'hidden' : '' }}>
                        <div class="p-0 form-inline mb-4">
                            <input class="form-control col shadow-none" name="key" type="search"
                                placeholder="Cari event ..." value="{{ request('key') }}">
                        </div>
                    </form>

                    @if ($listEvent->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Wah kamu belum <b>punya event</b> sob! <a href="/event/create"
                                class="text-info text-decoration-none">Buat event <i class="fas fa-paper-plane"></i></a>
                        </div>
                    @endif

                    @foreach ($listEvent as $event)
                        <div class="card pb-2">
                            <div class="col-md-12 row card-body px-3 pb-2">
                                <div class="col-12">

                                    @php

                                        //Biaya admin untuk customer
                                        $biayaAdmin = config('app.biaya_admin');

                                        //Total transaksi sukses
                                        $totalPeserta = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Paid')
                                            ->count();

                                        //Total biaya admin
                                        $biayaAdminPeserta = $biayaAdmin * $totalPeserta;

                                        //Total dana sebelum dikurangi biaya admin
                                        $totalTransaksi = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Paid')
                                            ->sum('total_price');

                                        //Pengurangan total dana dikurangi biaya admin dari user (Total dana masuk)
                                        $totalDana = $totalTransaksi - $biayaAdminPeserta;

                                        $totalTiket = App\Models\Ticket::where('event_id', $event->id)->count();

                                        //Mengkategorikan dana berdasarkan metode pembayaran
                                        //Metode BANK TRANSFER (VA)
                                        $qty_bank_tf = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Paid')
                                            ->where('payment_type', 'bank_transfer')
                                            ->count();

                                        $dana_bank_tf =
                                            App\Models\Transaction::where('event_id', $event->id)
                                                ->where('status', 'Paid')
                                                ->where('payment_type', 'bank_transfer')
                                                ->sum('total_price') -
                                            $biayaAdmin * $qty_bank_tf;

                                        // Bank TF : 1.5% + 4500 per transaksi
                                        $admin_bank_tf = 4500 * $qty_bank_tf + (1.5 / 100) * $dana_bank_tf;

                                        $total_dana_bank_tf = $dana_bank_tf - $admin_bank_tf;

                                        //Metode CREDIT CARD

                                        $qty_credit_card = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Paid')
                                            ->where('payment_type', 'credit_card')
                                            ->count();

                                        $dana_credit_card =
                                            App\Models\Transaction::where('event_id', $event->id)
                                                ->where('status', 'Paid')
                                                ->where('payment_type', 'credit_card')
                                                ->sum('total_price') -
                                            $biayaAdmin * $qty_credit_card;

                                        //Credit card : 3.5% + 2500 per transaksi
                                        $admin_credit_card = 2500 * $qty_credit_card + (3.5 / 100) * $dana_credit_card;

                                        $total_dana_credit_card = $dana_credit_card - $admin_credit_card;

                                        //Metode Lain (Qris, Gopay, Shopeepay, Dana, Linkaja)

                                        $qty_lain = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Paid')
                                            ->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
                                            ->count();

                                        $dana_lain =
                                            App\Models\Transaction::where('event_id', $event->id)
                                                ->where('status', 'Paid')
                                                ->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
                                                ->sum('total_price') -
                                            $biayaAdmin * $qty_lain;

                                        // Pembayaran Lain : 3% pertransaksi / per tiket
                                        $admin_lain = (3 / 100) * $dana_lain;

                                        $total_dana_lain = $dana_lain - $admin_lain;

                                        //Pengurangan biaya admin penyelenggara
                                        $eventConnectFee = $admin_bank_tf + $admin_credit_card + $admin_lain;

                                        // penarikan dana;
                                        $danaDitarik = App\Models\WithdrawData::where('event_id', $event->id)
                                            ->whereIn('status', ['Sukses', 'Proses'])
                                            ->sum('amount');

                                        $danaBersih = $total_dana_bank_tf + $total_dana_credit_card + $total_dana_lain - $danaDitarik;

                                        $title = $event->title;
                                        if (strlen($title) > 61) {
                                            $title = substr($title, 0, 61) . '...';
                                        }
                                    @endphp
                                    <span class="text-info title-manage-event"><b>{{ $title }}</b></span>

                                    <br>

                                    <button type="button" class="btn p-0 shadow-none" id="detailReportButton"
                                        data-toggle="tooltip" data-placement="bottom" title="Klik untuk Lihat detail"
                                        data-id="{{ $event->id }}">
                                        <small>
                                            <b class="text-success"><i class="fas fa-check-circle"></i> Rp
                                                <span
                                                    id="view-total-dana-button{{ $event->id }}">{{ number_format($danaBersih, 0, ',', '.') }}</span></b>
                                        </small>
                                    </button>
                                    {{-- <button type="button" class="btn dana btn-sm mt-1 px-3" data-id="{{ $event->id }}"
                                        data-event="{{ $event->title }}">
                                        <i class="fas fa-wallet"></i> <b></b>
                                    </button> --}}
                                </div>
                            </div>

                            <hr class="mx-2 my-2">
                            {{-- Button edit tiket & form --}}
                            <div class="col-md-12 pb-2 card-body pt-1 pb-2 px-3">

                                <button type="button" class="btn transaction-button btn-sm px-3 withdraw-button"
                                    data-id="{{ $event->id }}" data-event="{{ $event->title }}">
                                    <i class="fas fa-download"></i> Tarik Dana
                                </button>

                                <button type="button" class="btn btn-sm px-3 transaction-button history-withdraw"
                                    data-id="{{ $event->id }}" data-event="{{ $event->title }}">
                                    <i class="fas fa-history"></i> Riwayat
                                </button>
                            </div>
                        </div>
                    @endforeach

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $listEvent->links() }}
                    </div>
                    {{-- Pagination --}}

                </div>
            </div>
        </div>
    </section>

    <!-- Modal detail -->
    <div class="modal fade" id="detailReportTransaksi" tabindex="-1" aria-labelledby="detailReportTransaksiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailReportTransaksiLabel">Laporan transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row mt-1">
                        <div class="col-6">Peserta</div>
                        <div class="col-6"><b id="total-peserta">0</b> orang</div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">Kategori Tiket</div>
                        <div class="col-6"><b id="kategori-tiket">0</b> Tiket</div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">Transaksi masuk</div>
                        <div class="col-6"><b>Rp <span id="pemasukan">0</span></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">Total admin fee</div>
                        <div class="col-6"><b>Rp <span id="admin-fee">0</span></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">History penarikan</div>
                        <div class="col-6"><b>Rp <span id="penarikan">0</span></b></div>
                    </div>
                    <hr>
                    <div class="row text-success">
                        <div class="col-6"><b>Total SALDO</b></div>
                        <div class="col-6"><b>Rp <span id="saldo_akhir">0</span></b></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times-circle"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal penarikan dana-->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">Penarikan dana</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" id="withdraw-form">
                    <div class="modal-body">
                        <div class="row mt-1">
                            <div class="col-6">Pemasukan</div>
                            <div class="col-6"><b>Rp <span id="wd-pemasukan">0</span></b></div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6">Total admin fee</div>
                            <div class="col-6"><b>Rp <span id="wd-admin">0</span></b></div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6">History penarikan</div>
                            <div class="col-6"><b>Rp <span id="wd-history">0</span></b></div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6">Rekening</div>
                            <div class="col-6"><b class="text-info"><span id="wd-rekening">0</span></b></div>
                        </div>

                        <hr>
                        <div class="row text-success">
                            <div class="col-6"><b>Saldo tersedia</b></div>
                            <div class="col-6"><b>Rp <span id="wd-limit">0</span></b></div>
                        </div>
                        <hr class="mb-0">

                        <small class="text-warning">Min penarikan <b>Rp 10.000</b></small>

                        <div class="form-group mt-2">
                            <label for="jumlah-penarikan">Jumlah penarikan</label>
                            <input type="hidden" id="limit-withdraw">
                            <input [value]="units * 600 + 2500 | number" type="text" class="form-control"
                                id="jumlah-penarikan" placeholder="Rp 0" required>
                            <small class="text-danger limit-notif" hidden>Maksimal penarikan <b>Rp <span
                                        class="limit-notif-value"></span></b>
                            </small>
                            <input type="hidden" name="from_request" value="withdraw">
                            <input type="hidden" name="event_id" id="wd-event-id">
                            <input type="hidden" name="wdUserId" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="wdRekening" value="{{ auth()->user()->no_rekening }}">
                            <input type="hidden" name="wdBank" value="{{ auth()->user()->bank }}">
                            <input type="hidden" name="wdAmount" id="jumlah-penarikan-fixed">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submit-withdraw"><i
                                class="fas fa-wallet"></i> Tarik dana
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal History penarikan-->
    <div class="modal fade" id="withdrawHistoryModal" tabindex="-1" aria-labelledby="withdrawHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawHistoryModalLabel">History penarikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="search" class="form-control shadow-none mb-3 mt-2" id="wd-history-search"
                        name="wd-history-search" placeholder="Cari riwayat transaksi">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="withdraw-history">
                            <thead>
                                <tr>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                <tr>
                                    <th scope="row">900.450.000</th>
                                    <td>220 Marc 2024</td>
                                    <td>
                                        <span class="badge badge-success">Sukses</span>
                                    </td>
                                </tr>
                            </tbody> --}}
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Push javascript --}}
    @push('js-transaction-report')
        @include('dashboard.js.js-transaction-report')
    @endpush
@endsection
