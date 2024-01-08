@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white" role="alert">
            <strong>CHECKIN EVENT</strong>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card bg-secondar">
            <div class="card-header">
                <h3 class="card-title">Butuh checkin peserta? <b class="text-info">bisa dong!</b> </h3>
            </div>

            <div class="card-body px-3 daftar-event text-dark bg-card-blue">

                <form action="" method="GET">
                    <div class="p-0 form-inline mb-4">
                        <input class="form-control col shadow-none mr-1" id="search-myevent" name="key" type="search"
                            placeholder="Cari event ..." value="{{ request('key') }}">
                    </div>
                </form>

                {{-- Looping data my event --}}
                @foreach ($dataEvent as $event)
                    <div class="card mt-2">
                        <div class="col-md-12 row card-body px-3 pb-3">
                            <div class="col-9">
                                {{-- Event --}}
                                <b class="text-info title-manage-event">
                                    @php
                                        $title = $event->title;
                                        if (strlen($title) > 44) {
                                            $title = substr($title, 0, 44) . '...';
                                        }
                                    @endphp
                                    {{ $title }}
                                </b>
                                <br>

                                @php
                                    $participant = \App\Models\Transaction::where('event_id', $event->id)
                                        ->where('status', 'Paid')
                                        ->get()
                                        ->count();
                                @endphp

                                <small>
                                    <span class="text-secondary"><i class="fas fa-user-circle"></i>
                                        <b>{{ $participant }}</b> PESERTA</span>
                                </small>

                                <hr class="my-3">

                                <div class="mt-2">
                                    <button type="button" class="btn btn-info btn-sm rounded-0 px-3 detail-peserta"
                                        data-id="{{ $event->id }}" data-participant="{{ $participant }}"
                                        data-title="{{ $event->title }}">
                                        <i class="fas fa-check-circle"></i> Checkin peserta
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
                <form action="javascript:void(0)" id="checkin-form">
                    <div class="input-group mb-3">
                        <span class="fas fa-qrcode form-control-icon"></span>
                        <input type="text" class="form-control shadow-none form-search"
                            placeholder="Input atau scan ID peserta" aria-label="Input atau scan QR Code ID peserta"
                            id="search-transaction" aria-describedby="button-addon2">

                        {{-- Tombol checkin di form sementara dinonaktifkan --}}
                        {{-- <div class="input-group-append">
                            <button class="btn btn-info shadow-none" type="submit" id="checkin-event-form"><i
                                    class="fas fa-check-square"></i>
                                Check in</button>
                        </div> --}}

                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped w-100" id="data-peserta">
                        <thead class="bg-info">
                            <tr>
                                <th scope="col" style="min-width: 150px">Nama peserta</th>
                                <th scope="col" style="min-width: 150px">Email</th>
                                <th scope="col" style="min-width: 150px">ID</th>
                                <th scope="col" style="min-width: 100px">Check In</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Push javascript --}}
    @push('js-checkin')
        @include('dashboard.js.js-page-checkin')
    @endpush

    {{-- Push javascript --}}
    @push('js-myevent')
        @include('dashboard.js.js-myevent')
    @endpush
@endsection
