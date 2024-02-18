@extends('form.main')

@section('content')
    <div class="container pb-3 mt-5">
        <div class="col-md-12 text-center mt-3 pt-3">
            {{-- <span>eventconnect.id</span> --}}
        </div>
        <div class="row m-1 style-form">
            <div class="col-lg-6 col-md-8 px-4 py-2 m-auto bg-eventconnect text-center text-white"><b>LOGIN</b></div>
        </div>

        <div class="row m-1 style-form">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box px-4">

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <strong>{{ session('loginError') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('logoutSuccess'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <strong>{{ session('logoutSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">

                        <form action="/login" method="post">
                            @csrf

                            <div class="form-group">
                                <label class="form-control-label" for="email">Email</label>
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    name="email" autofocus required value="{{ old('email') }}"
                                    placeholder="contoh@email.com" id="email">

                                @error('email')
                                    <small class="invalid-veedback text-danger mt-0 pt-0">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="password">Password</label>
                                <input type="password" class="form-control mb-2 @error('password') is-invalid @enderror"
                                    name="password" required id="password" placeholder="******">
                                <small>lupa password? <a href="/auth/forgot-password"><strong>Reset
                                            password</strong></a></small>
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <!-- Error Message -->
                                </div>
                                <div class="col-lg-12 login-btm login-button">
                                    <button type="submit" class="btn btn-eventconnect text-white">LOGIN</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
            <div class="col-md-12 text-center mt-3">
                <small> Belum punya akun? <a href="/register" class="btn btn-secondary btn-sm ms-1 btn-log-reg"><span><i
                                class="fas fa-user-circle"></i> Register!</span></a>
                </small>
            </div>
        </div>

        {{-- notifikasi sukses reset --}}
        @if (Session::has('status'))
            <script type="text/javascript">
                alertify.alert("Sukses!", "{{ session()->get('status') }}");
            </script>
        @endif
    @endsection
