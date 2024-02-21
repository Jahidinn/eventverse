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
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success"><i class="fas fa-check-circle"></i> Transaksi
                        sukses
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
