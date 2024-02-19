@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Transaction check</strong>
        </div>
    </section>

    {{-- Konten withdraw request --}}
    <section class="content mx-1" id="wd-request-container">
        <div class="form-group">

        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="search-request" placeholder="Cari event">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100" id="table-transaction-check">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">Event</th>
                                <th scope="col">Pemasukan</th>
                                <th scope="col" style="width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Example event</td>
                                <td>40.000.000</td>
                                <td>
                                    <button class="btn btn-success btn-sm">
                                        Cek transaksi <i class="fas fa-chevron-circle-right"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Push javascript --}}
    @push('js-admin-wd-request')
        @include('dashboard.admin-dashboard.admin-js.js-wd-request')
    @endpush
@endsection
