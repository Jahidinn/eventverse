@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Withdraw Request</strong>
        </div>
    </section>

    {{-- Konten withdraw request --}}
    <section class="content mx-1" id="wd-request-container">
        <div class="form-group">
            {{-- Button wd history --}}
            <button class="btn btn-secondary btn-sm pull-right" id="btn-wd-history">
                <b><i class="fas fa-history"></i> Menu withdraw history</b>
            </button>

            {{-- <select class="form-control" id="status-filter">
                <option value="">Semua data</option>
                <option value="Proses">Proses</option>
                <option value="Sukses">Sukses</option>
                <option value="Gagal">Gagal</option>
                <option value="Batal">Batal</option>
            </select> --}}
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="search-request" placeholder="Cari data request">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100" id="table-wd-request">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">user</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="min-width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Konten withdraw history --}}
    <section class="content mx-1" id="wd-history-container" hidden>
        <div class="form-group pr-0">
            {{-- Button wd history --}}
            <button class="btn btn-info btn-sm" id="btn-wd-request">
                <b><i class="fas fa-wallet"></i> Menu withdraw request</b>
            </button>

            <div class="row m-0 p-0">
                {{-- Pilihan status --}}
                <div class="col-md-6 mt-2 px-0">
                    <select class="form-control" id="wd-history-status-filter">
                        <option value="">Semua status</option>
                        <option value="Sukses">Sukses</option>
                        <option value="Gagal">Gagal</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>
                {{-- rentang pilihan tanggal filter --}}
                <div class="col-md-6 row px-0 mt-2 m-0">
                    <div class="col-5 pr-0 start-date-form">
                        <div class="input-form-group date datepicker p-0">
                            <span class="far fa-calendar-alt form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="start date" id="wd-history-start">
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                    <div class="col-2 pr-0 text-center">
                        <input class="form-control border-0" placeholder="to" disabled>
                    </div>
                    <div class="col-5 pr-0">
                        <div class="input-form-group date datepicker p-0">
                            <span class="far fa-calendar-alt form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="start date" id="wd-history-end">
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol tampilkan --}}
            <button class="btn btn-info col-md-12 mt-2" id="wd-history-filter">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="search-history" placeholder="Cari history">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="table-wd-history">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">user</th>
                                <th scope="col" style="min-width: 150px;">Amount</th>
                                <th scope="col" style="min-width: 100px;">Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    {{-- Modal detail --}}
    @include('dashboard.admin-dashboard.components.wd-modal-detail')

    {{-- Push javascript --}}
    @push('js-admin-wd-request')
        @include('dashboard.admin-dashboard.admin-js.js-wd-request')
    @endpush
@endsection
