@extends('layouts.main')

@section('content')
    <div class="bg-eventconnect header-hight">

    </div>

    <section class="pt-2" id="invoice_page" hidden>
        <div class="container mx-auto text-center mb-3 px-2">
            <div class="alert alert-primary" role="alert">
                <strong>#Online Invoice</strong>
            </div>
        </div>

        <form action="javascript:void(0)" method="post" id="checkout-event">
            @csrf

            <div class="container row mx-auto px-0">
                <div class="col-md-12 px-2 mt-2">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            EventHub ID
                        </div>
                        <div class="mt-3 ml-2">
                            <h5 class="card-title mb-1">Halo, {{ $transaction->name }}!</h5>
                            {{-- STATUS --}}
                            @if ($transaction->status == 'Paid')
                                {{-- IF PAID --}}
                                <small class="text-success"><i class="fas fa-check"></i> Selamat
                                    {{ $ticket->ticket_button == 'BELI TIKET' ? 'Pembelian tiket' : 'Pendaftaran' }} event
                                    kamu berhasil.</small>
                            @elseif ($transaction->status == 'Unpaid')
                                {{-- IF UNPAID --}}
                                <small class="text-warning"><i class="fas fa-exclamation-circle"></i> Wah! sepertinya kamu
                                    belum melakukan pembayaran!</small>
                            @elseif ($transaction->status == 'Pending')
                                {{-- IF PENDING --}}
                                <small class="text-warning"><i class="fas fa-exclamation-circle"></i> Pending (menunggu
                                    pembayaran)</small>
                            @elseif ($transaction->status == 'Expired')
                                {{-- IF EXPIRED --}}
                                <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Wah! Sepertinya
                                    pembayaran kamu sudah expired.</small>
                            @else
                                {{-- ELSE --}}
                                <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Wah! Sepertinya proses
                                    pembayaran kamu gagal/pending.</small>
                            @endif

                            <br>
                            <div class="joined-actions">
                                <button type="button" class="button-39 mt-2 px-0" onClick="window.location.reload();"><i
                                    class="ti ti-reload ti-sm mr-1"></i> Refresh
                                </button>
                                <button type="button" class="button-39 text-success btn-sm mt-2"
                                    data-id_transaksi="{{ $transaction->id }}" id="download-invoice"><i
                                        class="ti ti-file-type-pdf ti-sm mr-1"></i> Download
                                </button>
                                <button type="button" class="button-39 text-info btn-sm mt-2"
                                    data-id_transaksi="{{ $transaction->id }}" id="download-ticket"><i
                                        class="ti ti-ticket ti-sm mr-1"></i> Ticket
                                </button>

                                @if ($transaction->status == 'Unpaid' || $transaction->status == 'Pending')
                                    <button type="button" class="button-39 text-success btn-sm mt-2" id="lanjutkan-transaksi"
                                        data-id_transaksi="{{ $transaction->id }}"><i class="fas fa-wallet"></i> Bayar
                                    </button>
                                @endif
                            </div>
                        </div>
                        <hr class="mx-2 mt-2">
                        <div class="col-md-12 row mb-2">
                            <div class="col-6 text-secondary">Nama</div>
                            <div class="col-6">{{ $transaction->name }}</div>
                        </div>
                        <div class="col-md-12 row mb-2">
                            <div class="col-6 text-secondary">Order date</div>
                            <div class="col-6">{{ $transaction->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-12 row mb-2">
                            <div class="col-6 text-secondary"><i>ID
                                    {{ $ticket->ticket_button == 'BELI TIKET' ? 'Tiket' : 'Pendaftaran' }}</i></div>
                            <div class="col-6"><strong>#{{ $transaction->transaction_id }}</strong></div>
                        </div>
                        <div class="col-md-12 row mb-2">
                            <div class="col-6 text-secondary">Status pembayaran</div>

                            @if ($transaction->status == 'Paid')
                                {{-- IF PAID --}}
                                <div class="col-6 text-success">Sukses!</div>
                            @elseif ($transaction->status == 'Unpaid')
                                {{-- IF UNPAID --}}
                                <div class="col-6 text-warning"><small><i class="fas fa-dot-circle"></i></small>
                                    Belum dibayar</div>
                            @elseif ($transaction->status == 'Pending')
                                {{-- IF PENDING --}}
                                <div class="col-6 text-warning"><small><i class="fas fa-dot-circle"></i></small>
                                    pending</div>
                            @elseif ($transaction->status == 'Expired')
                                {{-- IF EXPIRED --}}
                                <div class="col-6 text-danger"><small><i class="fas fa-dot-circle"></i></small>
                                    Expired</div>
                            @else
                                {{-- ELSE --}}
                                <div class="col-6 text-danger"><small><i class="fas fa-dot-circle"></i></small>
                                    Gagal</div>
                            @endif

                        </div>
                        <div class="col-md-12 row">
                            <div class="col-6 text-secondary">Detail pesanan :</div>
                            <div class="col-6"></div>
                        </div>
                        <div class="card-body px-3 pb-0">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters">
                                    <div class="col-md-2 checkout-image-cover">
                                        <img src="{{ asset('storage/event-images/' . $event->image) }}" alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $event->title }}</h5>
                                            <small><i class="fas fa-user-circle"></i>
                                                {{ $event->penyelenggara->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-primary" role="alert">
                                {{ $ticket->ticket_name }} <strong><span
                                        class="badge badge-secondary p-2">{{ $transaction->quantity }}X</span></strong>
                                    <hr>
                                    Total bayar :

                                    @if ($transaction->total_price == 0 || $transaction->total_price == '')
                                        <strong class="text-success"> GRATIS </strong>
                                    @else
                                        <strong class="text-success"> Rp
                                            {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </strong>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <small>{{ $ticket->ticket_button == 'BELI TIKET' ? 'Ticket ID' : 'Registration ID' }}</small>

                            {{-- <img src="{{ asset('storage/event-images/qrcode.png') }}" alt="..." style="width: 200px;"> --}}
                            <div class="visible-print text-center my-2">
                                {!! $qrcode !!}
                            </div>

                            <strong>{{ $transaction->transaction_id }}</strong>
                        </div>
                        <div class="col-md-12">
                            <small class="text-danger">*Invoice juga kami kirimkan ke email yang terdaftar ya!</small>
                        </div>
                        <hr class="mx-2">
                        <div class="text-center mb-3">
                            <div class="alert alert-warning mt-2 mx-2" role="alert">
                                <small class="text-danger">Halaman invoice ini hanya bisa <strong>diakses 1x</strong>, untuk
                                    melihat ulang invoice klik URL yang kita kirimkan melalui email. Jika tidak menerima
                                    email periksa folder <strong>spam</strong> di email atau request ulangb melalui halaman
                                    <a href="/event/participant-search" class="btn btn-sm btn-secondary">pencarian
                                        peserta</a>
                                </small>
                            </div>
                            <span><strong>Terimakasih!</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!-- Modal konfirmasi checkout -->
    @include('apps.components.modal-checkout')


    {{-- javascript --}}
    @push('transaction-scripts')
        @include('apps.js.payment-process')
    @endpush

    @push('transaction-invoice')
        @include('apps.js.invoice')
    @endpush
@endsection
