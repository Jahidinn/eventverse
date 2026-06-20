@extends('layouts.main')

<style>

.checkout-section{
    background:#f8fafc;
    min-height:100vh;
}

/* HEADER */

.checkout-hero{
    text-align:center;
    margin-bottom:25px;
}

.checkout-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 18px;
    border-radius:999px;
    background:#eff6ff;
    color:#2563eb;
    font-size:14px;
    font-weight:600;
    margin-bottom:15px;
}

.checkout-title{
    font-size:25px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:8px;
}

.checkout-subtitle{
    color:#64748b;
}

/* PROGRESS */

.checkout-progress{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin-bottom:35px;
    flex-wrap:wrap;
}

.progress-step{
    display:flex;
    align-items:center;
    gap:10px;
}

.progress-circle{
    width:42px;
    height:42px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}

.progress-done{
    background:#dcfce7;
    color:#16a34a;
}

.progress-active{
    background:#2563eb;
    color:#fff;
}

.progress-wait{
    background:#f1f5f9;
    color:#94a3b8;
}

.progress-line{
    width:70px;
    height:2px;
    background:#e2e8f0;
}

/* CARD */

.checkout-card{
    background:#fff;
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:
        0 10px 40px rgba(15,23,42,.06);
}

.checkout-card-body{
    padding:28px 28px 75px 28px;
}

.checkout-section-title{
    font-size:20px;
    font-weight:700;
    margin-bottom:20px;
    color:#0f172a;
}

/* USER */

.checkout-user-card{
    display:flex;
    align-items:center;
    gap:15px;
    background:#f8fafc;
    border-radius:18px;
    padding:15px;
    margin-bottom:20px;
}

.user-avatar{
    width:52px;
    height:52px;
    border-radius:50%;
    background:linear-gradient(135deg,#2563eb,#4f46e5);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}

.user-name{
    font-weight:700;
    color:#0f172a;
}

.user-email{
    color:#64748b;
    font-size:14px;
}

/* INPUT */

.checkout-input{
    height:54px !important;
    border-radius:14px !important;
    border:1px solid #e2e8f0 !important;
    box-shadow:none !important;
}

.checkout-input:focus{
    border-color:#2563eb !important;
    box-shadow:0 0 0 4px rgba(37,99,235,.08)!important;
}

.checkout-label{
    font-weight:600;
    color:#334155;
    margin-bottom:6px;
}

.form-check-label{
    font-size: 14px;
}

/* SUMMARY */

.summary-card{
    position:sticky;
    top:90px;
}

.summary-cover{
    width:100%;
    height:100px;
    object-fit:cover;
}

.summary-content{
    padding:24px;
}

.summary-title{
    font-size:22px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:10px;
}

.summary-meta{
    color:#64748b;
    margin-bottom:8px;
    font-size: 15px;
}

.ticket-box{
    margin-top:20px;
    background:#f8fafc;
    border-radius:18px;
    padding:18px;
}

.price-box{
    margin-top:25px;
    text-align:center;
}

.price-box small{
    color:#64748b;
}

.price-amount{
    margin-top:6px;
    font-size:40px;
    font-weight:800;
    color:#16a34a;
    line-height:1;
}

.trust-card{
    margin-top:20px;
    background:#f8fafc;
    border-radius:18px;
    padding:16px;
}

.trust-item{
    margin-bottom:10px;
    font-size: 15px;
    color:#16a34a;
}

.checkout-note{
    margin-top:12px;
    background:#fffbeb;
    border:1px solid #fde68a;
    color:#92400e;
    border-radius:16px;
    padding:14px 16px;
    font-size:14px;
}

.checkout-pay-btn{
    width:100%;
    height:60px;
    border:none;
    border-radius:18px;
    color:white;
    font-weight:700;
    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );
}

.checkout-pay-btn:hover{
    transform:translateY(-2px);
}

@media(max-width:991px){

    .summary-card{
        position:relative;
        top:0;
        margin-top:20px;
    }

    .checkout-title{
        font-size:22px;
    }

}

@media(max-width:768px){

    .checkout-card-body{
        padding:28px;
    }
    .checkout-progress{
        flex-wrap:nowrap;
        gap:4px;
        margin-bottom:25px;
    }

    .progress-step span{
        display:none;
    }

    .progress-line{
        width:100%;
        min-width:20px;
    }

    .progress-circle{
        width:34px;
        height:34px;
        font-size:13px;
    }

}

</style>

@section('content')
<div class="bg-eventconnect header-hight">

    </div>
<section class="checkout-section pt-4 pb-5">

<div class="container">

    <div class="checkout-hero">

        {{-- <div class="checkout-badge">
            <i class="ti ti-ticket"></i>
            Checkout Event
        </div> --}}

        <div class="checkout-title">
            Selesaikan Pemesanan
        </div>

        {{-- <div class="checkout-subtitle">
            Lengkapi data peserta dan lanjutkan ke pembayaran
        </div> --}}

    </div>

    <div class="checkout-progress">

        <div class="progress-step">
            <div class="progress-circle progress-done">
                <i class="ti ti-check"></i>
            </div>
            <span>Pilih Tiket</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-step">
            <div class="progress-circle progress-active">
                2
            </div>
            <span>Data Peserta</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-step">
            <div class="progress-circle progress-wait">
                3
            </div>
            <span>Pembayaran</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-step">
            <div class="progress-circle progress-wait">
                4
            </div>
            <span>Tiket</span>
        </div>

    </div>

    <form action="javascript:void(0)" method="post" id="checkout-event">

        @csrf

        <div class="row">

            {{-- FORM --}}
            <div class="col-lg-7">

                <div class="checkout-card">

                    <div class="checkout-card-body">

                        <div class="checkout-section-title">
                            Data Peserta
                        </div>

                        @if(auth()->check())

                        <div class="checkout-user-card">

                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </div>

                            <div>
                                <div class="user-name">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="user-email">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>

                        </div>

                        @endif

                        {{-- SELURUH INPUT FORM LAMA ANDA TEMPEL DI SINI --}}
                        {{-- mulai dari checkbox --}}
                        {{-- hidden input --}}
                        {{-- nama --}}
                        {{-- email --}}
                        {{-- hp --}}
                        {{-- custom forms --}}

                        @if (auth()->check())
                            <div class="mb-3">
                                <label>
                                    <input class="checkbox checkbox-success" type="checkbox" name="checkbox"
                                        value="1">
                                    <strong>Pesan buat orang lain</strong>
                                </label>
                            </div>
                        @endif

                        {{-- Dipakai jika pesan ticket dengan login --}}
                        <input type="hidden" name="is_login" id="is_login"
                            value="{{ auth()->check() ? 1 : 0 }}">

                        <input type="hidden" name="user_login_id" id="user_login_id"
                            value="{{ auth()->check() ? auth()->user()->id : '0' }}">
                        {{-- Dipakai jika pesan ticket dengan login --}}

                        <div class="form-group mb-3">

                            <label for="fullName" class="checkout-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>

                            <input
                                class="form-control checkout-input"
                                name="fullName"
                                id="fullName"
                                type="text"
                                placeholder="Masukkan nama lengkap"
                                required
                                autocomplete="on"
                                {{ auth()->check() ? 'readonly' : '' }}
                                value="{{ auth()->check() ? auth()->user()->name : '' }}">

                        </div>

                        <div class="form-group mb-3">

                            <label for="email" class="checkout-label">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input
                                class="form-control checkout-input"
                                name="email"
                                type="email"
                                placeholder="example@email.com"
                                id="email"
                                required
                                autocomplete="on"
                                {{ auth()->check() ? 'readonly' : '' }}
                                value="{{ auth()->check() ? auth()->user()->email : '' }}">

                        </div>

                        <div class="form-group mb-3">

                            <label for="nomorHp" class="checkout-label">
                                Nomor HP <span class="text-danger">*</span>
                            </label>

                            <input
                                class="form-control checkout-input"
                                name="nomorHp"
                                type="text"
                                id="nomorHp"
                                placeholder="+62 821 3355 3002"
                                value="+62"
                                required>

                        </div>

                        @if ($customForms)

                            @foreach ($customForms as $customForm)

                                <div class="form-group mb-3">

                                    <label
                                        for="customForm[{{ $customForm->id }}]"
                                        class="checkout-label">

                                        {{ strtr($customForm->form_name, ['*' => '']) }}

                                        @if ($customForm->form_status == 1)
                                            <span class="text-danger">*</span>
                                        @endif

                                    </label>

                                    <input
                                        class="form-control checkout-input"
                                        name="customForm[{{ $customForm->id }}]"
                                        id="customForm[{{ $customForm->id }}]"
                                        type="text"
                                        placeholder="Isi jawaban..."
                                        {{ $customForm->form_status == 1 ? 'required' : '' }}>

                                </div>

                            @endforeach

                        @endif

                        <div class="checkout-note mt-4">
                            Form yang tidak bertanda * dapat diubah selama masa pendaftaran masih berlangsung.
                        </div>

                    </div>

                </div>

            </div>

            {{-- SUMMARY --}}
            <div class="col-lg-5">

                <div class="checkout-card summary-card">

                    <img
                        src="{{ asset('storage/event-images/' . $detailEvent->image) }}"
                        class="summary-cover">

                    <div class="summary-content">

                        <div class="summary-title">
                            {{ $detailEvent->title }}
                        </div>

                        <div class="summary-meta">
                            <i class="ti ti-user"></i>
                            {{ $detailEvent->penyelenggara->name }}
                        </div>

                        <div class="summary-meta">
                            <i class="ti ti-map-pin"></i>

                            {{ $detailEvent->location_jenis == 'Online'
                                ? 'Online'
                                : $detailEvent->location_city }}
                        </div>

                        <div class="ticket-box">

                            <strong>
                                {{ $detailTicket->ticket_name }}
                            </strong>

                            <br>

                            <small class="text-muted">
                                Qty 1 Ticket
                            </small>

                        </div>

                        <div class="price-box">

                            <small>Total Pembayaran</small>

                            <div class="price-amount">

                                @if ($detailTicket->ticket_price == 0 || $detailTicket->ticket_price == '')
                                    GRATIS
                                @else
                                    Rp {{ number_format($detailTicket->ticket_price,0,',','.') }}
                                @endif

                            </div>

                        </div>

                        <input type="hidden" name="idEvent" value="{{ $detailEvent->id }}">
                        <input type="hidden" name="idTicket" value="{{ $detailTicket->id }}">
                        <input type="hidden" name="quantity" value="{{ $detailTicket->ticket_price }}">
                        <input type="hidden" name="totalPrice" value="{{ $detailTicket->ticket_price }}">

                        <div class="trust-card">

                            <div class="trust-item">
                                <i class="ti ti-shield-check"></i> Secure payment
                            </div>

                            <div class="trust-item">
                                <i class="ti ti-ticket"></i> Verify and generate tickets automatically
                            </div>

                        </div>

                        <div class="form-check mt-4">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="persetujuan"
                                required>

                            <label
                                class="form-check-label"
                                for="persetujuan">

                                Saya setuju dengan <strong>Syarat & Ketentuan</strong>

                            </label>

                        </div>

                        <button
                            type="submit"
                            id="checkout-button"
                            class="checkout-pay-btn mt-4">

                            <i class="ti ti-credit-card"></i>
                            Lanjut ke Pembayaran

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

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
