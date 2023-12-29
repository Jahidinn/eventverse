@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white" role="alert">
            <strong>DATA PESERTA</strong>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card bg-secondar">
            <div class="card-header">
                <h3 class="card-title">Kelola data peserta dengan mudah! </h3>

            </div>

            <div class="card-body px-3 daftar-event text-dark">
                <form action="" method="GET">
                    <div class="p-0 form-inline mb-4">
                        <input class="form-control col shadow-none mr-1" id="search-myevent" name="key" type="search"
                            placeholder="Cari event ..." value="{{ request('key') }}">
                    </div>
                </form>

                {{-- Looping data my event --}}
                @foreach ($dataEvent as $event)
                    <div class="card mt-2 bg-card-blue">
                        <div class="col-md-12 row card-body px-3 pb-3">
                            <div class="col-9">
                                {{-- Event --}}
                                <span>
                                    @php
                                        $title = $event->title;
                                        if (strlen($title) > 44) {
                                            $title = substr($title, 0, 44) . '...';
                                        }
                                    @endphp
                                    {{ $title }}
                                </span>
                                <br>

                                @php
                                    $participant = \App\Models\Transaction::where('event_id', $event->id)
                                        // ->where('status', '!=', 'Expired')
                                        ->get()
                                        ->count();
                                @endphp

                                <small>
                                    <b class="text-success"><span>{{ $participant }}</span> PENDAFTAR</b>
                                </small>

                                <br>

                                <div class="mt-2">
                                    <button type="button" class="btn btn-info btn-sm border-rounded px-3 detail-peserta"
                                        data-id="{{ $event->id }}" data-participant="{{ $participant }}"
                                        data-title="{{ $event->title }}">
                                        <i class="fas fa-users"></i> Detail Peserta
                                    </button>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="myevent-container-img">
                                    <img class="card-img-top" src="{{ asset('storage/event-images/' . $event->image) }}"
                                        alt="Card image cap">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $dataEvent->links() }}
                </div>
                {{-- Pagination --}}

            </div>
            <div class="card-body px-3 daftar-peserta" hidden>

                <div class="input-group mb-2">
                    <input type="text" class="form-control shadow-none" placeholder="Cari peserta"
                        aria-label="Cari data peserta" id="search-participant" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-info shadow-none" type="button" id="button-addon2"
                            data-toggle="modal" data-target="#filterModal"><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </div>

                <div class="card mt-1 bg-card-blue">
                    <div class="col-md-12 card-body px-3 pb-2 pt-2">
                        <span class="title-daftar-peserta"></span>
                        <br>
                        <b class="text-secondary">
                            <span class="result-label text-secondary">Total peserta
                            </span> :
                            <span class="jumlah-peserta text-success">000</span>
                        </b>
                    </div>
                </div>

                <div class="mb-2">
                    <button class="btn btn-success kembali"><i class="fas fa-chevron-circle-left"></i> Kembali</button>
                    <button class="btn btn-success"><i class="fas fa-file-excel"></i> Download data</button>
                </div>
                <div class="table-responsive">
                    <small>jsjsj</small>
                    <table class="table table-striped w-100" id="data-peserta">
                        <thead class="bg-info">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col" style="min-width: 150px">Nama peserta</th>
                                <th scope="col" style="min-width: 150px">Email</th>
                                <th scope="col" style="min-width: 150px">ID</th>
                                <th scope="col" style="min-width: 90px">Status</th>
                                <th scope="col" style="min-width: 100px">Detail</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Detail peserta transaksi -->
    <div class="modal fade" id="detailTransaksiModal" tabindex="-1" aria-labelledby="detailTransaksiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTransaksiModalLabel">Detail peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body data-pendaftar">
                    <div class="row">
                        <div class="col-4">Nama <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-name"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Email <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-email"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">No HP <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-phone"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Tiket <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-ticket"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Biaya <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-biaya"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">ID <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-id text-info"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Status <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-status"></b></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">Pembayaran <span class="float-right">:</span></div>
                        <div class="col-8 pl-0"><b class="p-pembayaran"></b></div>
                    </div>
                    <hr>
                    {{-- Value custom form --}}
                    <div id="data-custom-form">
                        <div class="row">
                            <div class="col-4"><span></span> <span class="float-right">:</span></div>
                            <div class="col-8 pl-0"><b></b></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Filter-->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="filter-value">
                            <option value="">Semua status</option>
                            <option value="Sukses">Sukses</option>
                            <option value="Pending">Pending</option>
                            <option value="Expired">Expired</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="get-filter"><i class="fas fa-filter"></i>
                        Filter</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    @push('js-participant')
        @include('dashboard.js.js-participant')
    @endpush

    {{-- Push javascript --}}
    @push('js-myevent')
        @include('dashboard.js.js-myevent')
    @endpush
@endsection
