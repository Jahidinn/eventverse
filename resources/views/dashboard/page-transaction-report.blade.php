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

            <div class="card-body px-2 pt-3">
                <div class="table-responsive py-0 manajemen-event-box">
                    <form action="" method="GET">
                        <div class="p-0 form-inline mb-4">
                            <input class="form-control col shadow-none" name="key" type="text"
                                placeholder="Cari event ..." value="{{ request('key') }}">
                        </div>
                    </form>

                    @foreach ($listEvent as $event)
                        <div class="card pb-2 bg-card-blue">
                            <div class="col-md-12 row card-body px-3 pb-2">
                                <div class="col-12">

                                    @php

                                        $biayaAdmin = config('app.biaya_admin');
                                        $totalEvent = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Expired')
                                            ->count();
                                        $totalBiayaAdmin = $biayaAdmin * $totalEvent;

                                        $totalDana = App\Models\Transaction::where('event_id', $event->id)
                                            ->where('status', 'Expired')
                                            ->sum('total_price');

                                        //Lakukan pengurangan biaya admin dari midtrans
                                        //...............

                                        $title = $event->title;
                                        if (strlen($title) > 61) {
                                            $title = substr($title, 0, 61) . '...';
                                        }
                                    @endphp

                                    <a href="/event/{{ $event->slug }}"
                                        class="text-info title-manage-event"><b>{{ $title }}</b>
                                    </a>
                                    <br>
                                    <button type="button" class="btn dana btn-sm mt-2 px-3 edit-ticket-button"
                                        data-id="{{ $event->id }}" data-event="{{ $event->title }}">
                                        <i class="fas fa-wallet"></i> <b>Rp {{ number_format($totalDana, 0, ',', '.') }}</b>
                                    </button>
                                </div>
                            </div>
                            <hr class="mx-2 my-2">
                            {{-- Button edit tiket & form --}}
                            <div class="col-md-12 pb-2 card-body pt-1 pb-2 px-3">

                                <button type="button" class="btn transaction-button btn-sm px-3 edit-ticket-button"
                                    data-id="{{ $event->id }}" data-event="{{ $event->title }}">
                                    <i class="fas fa-download"></i> Tarik Dana
                                </button>

                                <button type="button" class="btn btn-sm px-3 transaction-button edit-formulir-button"
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
@endsection
