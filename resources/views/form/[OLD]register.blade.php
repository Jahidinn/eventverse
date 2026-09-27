@extends('form.main')

@section('content')
    <div class="container py-5">

<style>

.auth-card{
    max-width:560px;
    margin:auto;
    background:#fff;
    border-radius:28px;
    padding:35px;
    box-shadow:0 15px 50px rgba(0,0,0,.08);
}

.auth-logo{
    text-align:center;
    margin-bottom:15px;
}

.auth-logo img{
    height:45px;
}

.auth-title{
    font-size:25px;
    font-weight:700;
    color:#0f172a;
    text-align:center;
    margin-bottom:6px;
}

.auth-subtitle{
    text-align:center;
    color:#64748b;
    margin-bottom:30px;
    font-size: 13px;
}

.auth-input{
    height:56px;
    border-radius:14px;
    border:1px solid #e2e8f0;
    box-shadow:none !important;
}

.auth-input:focus{
    border-color:#3b82f6;
    box-shadow:0 0 0 4px rgba(59,130,246,.08) !important;
}

.auth-btn{
    width:100%;
    height:56px;
    border:none;
    border-radius:14px;
    font-weight:600;
    color:#fff;

    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );
}

.auth-footer{
    text-align:center;
    margin-top:20px;
    color:#64748b;
}

.auth-footer a{
    text-decoration:none;
    font-weight:600;
}

@media(max-width:576px){

    .auth-card{
        padding:25px;
    }

    .auth-title{
        font-size:24px;
    }
}

</style>

<div class="auth-card">

<div class="auth-logo">

    {{-- Logo EventHub --}}
    {{-- <img src="{{ asset('img/logo.png') }}"> --}}
    <div class="auth-logo">
        <a href="/" class="logo-link">
            <img src="{{ asset('assets/img/eventverse-color.png') }}" alt="EventHub">
        </a>
    </div>

</div>
<hr>

<div class="auth-title">
    Buat Akun Baru
</div>

<div class="auth-subtitle">
    Mulai buat event, kelola peserta, ticketing, dan pembayaran dalam satu dashboard terintegrasi.
</div>

<form action="/register" method="post">

    @csrf

    <div class="mb-3">

        <label class="mb-2">
            Username
        </label>

        <input
            type="text"
            name="username"
            class="form-control auth-input @error('username') is-invalid @enderror"
            value="{{ old('username') }}"
            placeholder="username"
            required>

        @error('username')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

    <div class="mb-3">

        <label class="mb-2">
            Email
        </label>

        <input
            type="email"
            name="email"
            class="form-control auth-input @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            placeholder="example@email.com"
            required>

        @error('email')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

    <div class="row">

        <div class="col-md-6 mb-3">

            <label class="mb-2">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control auth-input @error('password') is-invalid @enderror"
                placeholder="••••••••"
                required>

            @error('password')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="col-md-6 mb-3">

            <label class="mb-2">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="confirmPassword"
                class="form-control auth-input @error('confirmPassword') is-invalid @enderror"
                placeholder="••••••••"
                required>

            @error('confirmPassword')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror

        </div>

    </div>

    <button
        type="submit"
        class="auth-btn mt-2">

        Buat Akun

    </button>

</form>

<div class="auth-footer">

    Sudah punya akun?

    <a href="/login">
        Login sekarang
    </a>

</div>

</div>

</div>

    
@endsection
