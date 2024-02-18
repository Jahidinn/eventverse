@extends('layouts.main')

@section('content')
    <div class="bg-eventconnect header-hight">

    </div>
    <section class="pt-5">
        <div class="container mx-auto text-center mb-3 px-2">
            <div class="alert alert-primary" role="alert">
                Selesaikan pemesananmu!
            </div>
        </div>

        <form action="javascript:void(0)" method="post" id="checkout-event">
            @csrf

            <div class="container row mx-auto px-0">
                <div class="col-md-6 px-2 mt-2">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Form pendaftaran / pemesanan
                        </div>
                        <div class="card-body">
                            @if (auth()->check())
                                <div>
                                    <label>
                                        <input class="checkbox checkbox-success" type="checkbox" name="checkbox"
                                            value="1">
                                        <strong>Pesan buat orang lain</strong>
                                    </label>
                                </div>
                            @endif

                            {{-- Dipakai jika pesan ticket dengan login --}}
                            <input type="hidden" name="is_login" id="is_login" value="{{ auth()->check() ? 1 : 0 }}">
                            <input type="hidden" name="user_login_id" id="user_login_id"
                                value="{{ auth()->check() ? auth()->user()->id : '0' }}">
                            {{-- Dipakai jika pesan ticket dengan login --}}

                            <div class="form-group">
                                <label for="fullName" class="custom-form-label">
                                    <small><strong>Nama lengkap</strong> <span class="text-danger">*</span></small>
                                </label>
                                <input class="form-control rounded-0" name="fullName" id="fullName" type="text"
                                    placeholder="isi nama" required autocomplete="on"
                                    {{ auth()->check() ? 'readonly' : '' }}
                                    value="{{ auth()->check() ? auth()->user()->name : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="email" class="custom-form-label">
                                    <small><strong>Email</strong> <span class="text-danger">*</span></small>
                                </label>
                                <input class="form-control rounded-0" name="email" type="email"
                                    placeholder="example@email.com" id="email" required autocomplete="on"
                                    {{ auth()->check() ? 'readonly' : '' }}
                                    value="{{ auth()->check() ? auth()->user()->email : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="nomorHp" class="custom-form-label">
                                    <small><strong>Nomer HP</strong> <span class="text-danger">*</span></small>
                                </label>
                                <input class="form-control rounded-0" name="nomorHp" type="text" id="nomorHp"
                                    placeholder="+62 821 3355 3002" value="+62" required>
                            </div>

                            @if ($customForms)
                                @foreach ($customForms as $customForm)
                                    <div class="form-group">
                                        <label for="customForm[{{ $customForm->id }}]" class="custom-form-label">
                                            <small>
                                                <b>{{ strtr($customForm->form_name, ['*' => '']) }}
                                                    <span class="text-danger">{{ $customForm->form_status == 1 ? '*' : '' }}
                                                    </span>
                                                </b>
                                            </small>
                                        </label>
                                        <input class="form-control rounded-0" name="customForm[{{ $customForm->id }}]"
                                            id="customForm[{{ $customForm->id }}]" type="text" placeholder="..."
                                            {{ $customForm->form_status == 1 ? 'required' : '' }}>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                    <div class="alert alert-warning mt-2" role="alert">
                        Pastikan formulir sudah terisi dengan benar guys!
                    </div>
                </div>
                <div class="col-md-6 px-2 mt-2">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Order review
                        </div>
                        <div class="card-body px-2">

                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters">
                                    <div class="col-md-2 checkout-image-cover">
                                        <img src="{{ asset('storage/event-images/' . $detailEvent->image) }}"
                                            alt="...">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $detailEvent->title }}</h5>
                                            <small><i class="fas fa-user-circle"></i>
                                                {{ $detailEvent->penyelenggara->name }}</small>
                                            <small class="ml-2"><i class="fas fa-map-marker-alt"></i>
                                                {{ $detailEvent->location_jenis == 'Online' ? 'Online' : $detailEvent->location_detail . ', ' . $detailEvent->location_city . ',  ' . $detailEvent->province->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-primary" role="alert">
                                {{ $detailTicket->ticket_name }} <strong><span
                                        class="badge badge-secondary p-2">1X</span></strong>
                                <hr>
                                @if ($detailTicket->ticket_price == 0 || $detailTicket->ticket_price == '')
                                    <strong>GRATIS</strong>
                                @else
                                    <strong>Rp {{ number_format($detailTicket->ticket_price, 0, ',', '.') }}</strong>
                                @endif

                                <input type="hidden" name="idEvent" value="{{ $detailEvent->id }}">
                                <input type="hidden" name="idTicket" value="{{ $detailTicket->id }}">
                                <input type="hidden" name="quantity" value="{{ $detailTicket->ticket_price }}">
                                <input type="hidden" name="totalPrice" value="{{ $detailTicket->ticket_price }}">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="persetujuan" required>
                                <label class="form-check-label text-secondary" for="persetujuan">Saya setuju dengan
                                    <strong>Syarat & Ketentuan</strong> yang berlaku di eventconnect.id</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="checkout-button" class="btn btn-success w-100 mt-3 rounded-0">Proses
                        pembayaran</button>
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

    {{-- javascript --}}
    @push('transaction-scripts')
        @include('apps.js.transaction')
    @endpush

@endsection
