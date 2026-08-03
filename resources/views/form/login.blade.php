@extends('form.main')

@section('content')
    <div class="container py-5">

        <style>

            .auth-card{

                max-width:480px;

                margin:auto;

                background:#fff;

                border-radius:28px;

                padding:35px;

                box-shadow:
                    0 15px 50px rgba(0,0,0,.08);
            }

            .auth-logo{

                text-align:center;

                margin-bottom:20px;
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

                box-shadow:
                    0 0 0 4px rgba(59,130,246,.08) !important;
            }

            .auth-btn{

                width:100%;

                height:56px;

                border:none;

                border-radius:14px;

                font-weight:600;

                color:#fff;

                background:
                    linear-gradient(
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

            .auth-link{

                font-size:14px;
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
                <a href="/" class="logo-link">
                    <img src="{{ asset('assets/img/eventverse-color.png') }}" alt="EventHub">
                </a>
            </div>
            <hr>

            <div class="auth-title">
                Login
            </div>

            <div class="auth-subtitle">
                Login untuk melanjutkan!
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="alert alert-danger">
                    {{ session('loginError') }}
                </div>
            @endif

            @if (session()->has('logoutSuccess'))
                <div class="alert alert-success">
                    {{ session('logoutSuccess') }}
                </div>
            @endif

            <form action="/login" method="post">

                @csrf

                <div class="mb-3">

                    <label class="mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control auth-input @error('email') is-invalid @enderror"
                        placeholder="example@email.com"
                        value="{{ old('email') }}"
                        required>

                    @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control auth-input"
                        placeholder="••••••••"
                        required>

                </div>

                <div class="d-flex justify-content-end mb-4">

                    <a
                        href="/auth/forgot-password"
                        class="auth-link">

                        Lupa password?

                    </a>

                </div>

                <button
                    type="submit"
                    class="auth-btn">

                    Get started

                </button>

            </form>

            <div class="auth-footer">

                Belum punya akun?

                <a href="/register">

                    Daftar sekarang

                </a>

            </div>
        </div>
    </div>

@endsection
