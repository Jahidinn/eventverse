@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="page-header-modern mb-3">
            <div class="page-header-left">

                <div class="page-header-icon">
                    <i class="ti ti-file-dollar"></i>
                </div>

                <h2 class="page-header-title">
                    LAPORAN TRANSAKSI
                </h2>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

<style>

.search-modern{
    height:50px;
    border:none;
    border-radius:16px;
    background:#fff;
    box-shadow:0 4px 20px rgba(0,0,0,.06);
    padding-left:18px;
}

.search-modern:focus{
    box-shadow:0 0 0 4px rgba(59,130,246,.08);
}

.finance-card{
    background:#fff;
    border:none;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 4px 20px rgba(0,0,0,.06);
    transition:.25s;
    margin-bottom:18px;
}

.finance-card:hover{
    transform:translateY(-3px);
    box-shadow:0 14px 40px rgba(0,0,0,.10);
}

.finance-body{
    padding:22px;
}

.finance-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:10px;
}

.finance-title{
    font-size:18px;
    font-weight:700;
    color:#0f172a;
    line-height:1.5;
    transition:.2s;
}

.finance-header:hover .finance-title{
    color:#2563eb;
}

.balance-card{
    margin-top:16px;
    padding:18px;
    border-radius:18px;

    background:
        linear-gradient(
            135deg,
            #f0fdf4,
            #dcfce7
        );
}

.balance-label{
    font-size:13px;
    color:#15803d;
    font-weight:600;
}

.balance-value{
    font-size:30px;
    font-weight:700;
    color:#14532d;
    line-height:1.2;
}

.finance-toolbar{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-top:18px;
}

.finance-chip{
    display:flex;
    align-items:center;
    gap:6px;

    padding:8px 14px;

    border-radius:999px;

    font-size:13px;
    font-weight:600;
}

.finance-chip-green{
    background:rgba(16,185,129,.08);
    color:#059669;
}

.finance-chip-blue{
    background:rgba(59,130,246,.08);
    color:#2563eb;
}

.finance-chip-action{
    border:none;
    background:#f8fafc;

    color:#475569;

    transition:.2s;
}

.finance-chip-action:hover{
    background:#eef2ff;
}

.finance-chip-wd{
    border:none;
    background:#2dcd68;

    color:#ffffff;

    transition:.2s;
}

.finance-chip-wd:hover{
    background:#26b159;
}


.mobile-hide{
    display:inline;
}

@media(max-width:768px){

    .finance-toolbar{
        display:grid;
        grid-template-columns:
            repeat(4,1fr);
    }

    .mobile-hide{
        display:none;
    }

    .finance-chip{
        justify-content:center;
        padding:10px;
    }
}

.finance-chip{
    display:flex;
    align-items:center;
    gap:6px;

    padding:8px 14px;

    border-radius:999px;

    font-size:13px;
    font-weight:600;
}

.finance-chip-green{
    background:rgba(16,185,129,.08);
    color:#059669;
}

.finance-chip-blue{
    background:rgba(59,130,246,.08);
    color:#2563eb;
}


.action-text{
    margin-left:4px;
}

.empty-state{
    background:#fff;
    border-radius:20px;
    padding:30px;
    text-align:center;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
}

@media(max-width:768px){

    .finance-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .balance-value{
        font-size:22px;
    }

    .finance-actions{
        display:grid;
        grid-template-columns:repeat(2,1fr);
    }

    .finance-actions .btn{
        width:100%;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .action-text{
        display:none;
    }
}

</style>

<div class="card-body px-0 pt-3 bg-card-blue">

    <div class="manajemen-event-box">

        <form action="" method="GET" {{ $listEvent->isEmpty() ? 'hidden' : '' }}>

            <div class="mb-4">

                <input
                    class="form-control search-modern shadow-none"
                    name="key"
                    type="search"
                    placeholder="🔍 Cari event..."
                    value="{{ request('key') }}">

            </div>

        </form>

        @if ($listEvent->isEmpty())

            <div class="empty-state">

                <h5>Belum ada event 🎉</h5>

                <p class="text-muted mb-3">
                    Kamu belum mempunyai event.
                </p>

                <a href="/event/create" class="button-40">
                    <i class="ti ti-plus"></i>
                    Buat Event
                </a>

            </div>

        @endif

        @foreach ($listEvent as $event)

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

                //Pengurangan total dana dikurangi biaya admin dari user
                $totalDana = $totalTransaksi - $biayaAdminPeserta;

                $totalTiket = App\Models\Ticket::where('event_id', $event->id)->count();

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

                $admin_bank_tf = 4500 * $qty_bank_tf + (1.5 / 100) * $dana_bank_tf;

                $total_dana_bank_tf = $dana_bank_tf - $admin_bank_tf;

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

                $admin_credit_card = 2500 * $qty_credit_card + (3.5 / 100) * $dana_credit_card;

                $total_dana_credit_card = $dana_credit_card - $admin_credit_card;

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

                $admin_lain = (3 / 100) * $dana_lain;

                $total_dana_lain = $dana_lain - $admin_lain;

                $eventConnectFee = $admin_bank_tf + $admin_credit_card + $admin_lain;

                $danaDitarik = App\Models\WithdrawData::where('event_id', $event->id)
                    ->whereIn('status', ['Sukses', 'Proses'])
                    ->sum('amount');

                $danaBersih = $total_dana_bank_tf + $total_dana_credit_card + $total_dana_lain - $danaDitarik;

                $title = $event->title;
                if (strlen($title) > 61) {
                    $title = substr($title, 0, 61) . '...';
                }

            @endphp

            <div class="card finance-card">

                <div class="finance-body">

                    <div class="finance-header">

                        <button
                            type="button"
                            class="btn p-0 text-left shadow-none"
                            id="detailReportButton"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Lihat Detail Laporan"
                            data-id="{{ $event->id }}">

                            <div class="finance-title">

                                {{ $title }}

                                <i class="ti ti-chevron-right text-muted ml-1"></i>

                            </div>

                        </button>

                    </div>

                    <div class="balance-card">

                        <div class="balance-label">
                            Dana Tersedia
                        </div>

                        <div class="balance-value">

                            Rp
                            <span id="view-total-dana-button{{ $event->id }}">
                                {{ number_format($danaBersih, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                    <div class="finance-toolbar">

                        <div class="finance-chip finance-chip-green">

                            <i class="ti ti-users ti-sm"></i>

                            <span class="mobile-hide">
                                {{ number_format($totalPeserta,0,',','.') }}
                                Peserta
                            </span>

                        </div>

                        <div class="finance-chip finance-chip-blue">

                            <i class="ti ti-ticket ti-sm"></i>

                            <span class="mobile-hide">
                                {{ number_format($totalTiket,0,',','.') }}
                                Tiket
                            </span>

                        </div>

                        <button
                            type="button"
                            class="finance-chip finance-chip-action history-withdraw"
                            data-id="{{ $event->id }}"
                            data-event="{{ $event->title }}">

                            <i class="ti ti-history ti-sm"></i>

                            <span class="mobile-hide">History</span>

                        </button>

                        <button
                            type="button"
                            class="finance-chip finance-chip-wd withdraw-button"
                            data-id="{{ $event->id }}"
                            data-event="{{ $event->title }}">

                            <i class="ti ti-cash-banknote-move ti-sm"></i>

                            Withdraw

                        </button>

                    </div>

                </div>

            </div>

        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $listEvent->links() }}
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
