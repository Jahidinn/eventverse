@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong>Withdraw Request</strong>
        </div>
    </section>

    <section class="content mx-1">

        <div class="form-group">
            <button class="btn btn-secondary btn-sm mb-3"><b><i class="fas fa-history"></i> Withdraw history</b></button>
            <select class="form-control" id="status-filter">
                <option>Semua data</option>
                <option>Proses</option>
                <option>Sukses</option>
                <option>Gagal</option>
                <option>Batal</option>
            </select>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table w-100" id="table-wd-request">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">user</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
