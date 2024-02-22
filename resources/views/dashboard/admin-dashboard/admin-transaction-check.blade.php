@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Transaction check</strong>
        </div>
    </section>

    {{-- Konten withdraw request --}}
    <section class="content mx-1" id="check-event-container">
        <div class="form-group">

        </div>

        {{-- List event yang ada request penarikanya --}}
        <div class="card" id="event-list-container">
            <div class="card-body">
                {{-- Form pencarian --}}
                <div class="form-group">
                    <input type="text" class="form-control" id="check-search-event" placeholder="Cari event">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100" id="table-transaction-check">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">Event</th>
                                <th scope="col">Penarikan</th>
                                <th scope="col" style="width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- List transaksi --}}
        <div class="card" id="transaction-list-container" hidden>
            <div class="card-body">
                <span id="transaction-event-title">
                    -
                </span>
                <hr>

                {{-- Tombol kembali --}}
                <button class="btn btn-secondary mb-2" id="back-check-transaction"><i class="fas fa-angle-left"></i>
                    Kembali
                </button>

                <div class="form-group">
                    <input type="text" class="form-control" id="check-search-transaction" placeholder="Cari transaksi">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100" id="table-transaction">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Amount</th>
                                <th scope="col" style="width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    <!-- Modal detail transaksi -->
    <div class="modal fade" id="transactionDetailModal" tabindex="-1" aria-labelledby="transactionDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionDetailModalLabel">Detail transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- Detail transaksi --}}
                    <div class="row mb-1">
                        <div class="col-6">
                            Transaction ID
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <b id="check-transaction-id">-</b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            Event
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <a target="_blank" href="" id="check-event" class="text-decoration-none">Lihat event</a>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            Email
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <span id="check-email">-</span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            Phone
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <span id="check-phone">-</span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            Amount
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <b><span id="check-amount">-</span></b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            Metode pembayaran
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <span id="check-payment-method"></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            Status
                            <span class="float-right">:</span>
                        </div>
                        <div class="col-6">
                            <span id="check-status">-</span>
                        </div>
                    </div>
                    {{-- Detail transaksi --}}

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="event-id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="submit-check-event">
                        <i class="fas fa-check-circle"></i> Transaksi sukses
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    @push('js-admin-transaction-check')
        @include('dashboard.admin-dashboard.admin-js.js-transaction-check')
    @endpush
@endsection
