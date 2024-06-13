@extends('form.main')

@section('content')
    <div class="container pb-1">
        <div class="col-md-12 text-center mt-3 pt-2">
            <small><strong>Eventconnect.id</strong></small>
        </div>
        <div class="row m-1 style-form">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box px-4">

                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <strong>{{ session('loginError') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="col-lg-12 reset-password-title">
                    RESET PASSWORD
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">

                        <form action="/auth/send-reset-password" method="POST">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label class="form-control-label" for="email">Email</label>
                                <input type="email" class="form-control readonly @error('email') is-invalid @enderror"
                                    name="email" autofocus readonly required value="{{ $email }}"
                                    placeholder="contoh@email.com" id="email">

                                @error('email')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="password">Password baru</label>
                                <input type="password" class="form-control mb-2 @error('password') is-invalid @enderror"
                                    name="password" required id="password">

                                @error('password')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="confirmPassword">Konfirmasi Password</label>
                                <input type="password" class="form-control  @error('confirmPassword') is-invalid @enderror"
                                    name="confirmPassword" required id="confirmPassword">
                                @error('confirmPassword')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <!-- Error Message -->
                                </div>
                                <div class="col-lg-12 login-btm login-button mt-2">
                                    <button type="submit" class="btn btn-eventconnect text-white">Reset password</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
    @endsection
