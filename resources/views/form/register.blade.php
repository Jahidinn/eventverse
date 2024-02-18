@extends('form.main')

@section('content')
    <div class="container pb-3 mt-5">
        <div class="col-md-12 text-center mt-3 pt-3">
            {{-- <h3>Eventconnect.id</h3> --}}
        </div>
        <div class="row m-1 style-form">
            <div class="col-lg-6 col-md-8 px-4 py-2 m-auto bg-eventconnect text-center text-white"><b>REGISTER</b></div>
        </div>
        <div class="row m-1">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box px-4">

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form style-form">

                        <form action="/register" method="post">
                            @csrf

                            <div class="form-group">
                                <label class="form-control-label" for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" autofocus required value="{{ old('username') }}" id="username"
                                    placeholder="username">
                                @error('username')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" required value="{{ old('email') }}" id="email"
                                    placeholder="example@email.com">
                                @error('email')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="password">Password</label>
                                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                                    name="password" required id="password">
                                @error('password')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="confirmPassword">Confirm Password</label>
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
                                    <button type="submit" class="btn btn-eventconnect text-white">REGISTER</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
            <div class="col-md-12 text-center mt-3">
                <small> Sudah punya akun? <a href="/login" class="btn btn-secondary btn-sm ms-1 btn-log-reg"><span><i
                                class="fas fa-user"></i> login
                            sekarang</span></a>
                </small>
            </div>
        </div>
    @endsection
