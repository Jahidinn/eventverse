@extends('auth.main')

@section('content')

<div class="container pb-3">
    <div class="col-md-12 text-center mt-3 pt-5">
        <h3 >Eventconnect.id</h3>
    </div>
    <div class="row m-1">
        <div class="col-lg-3 col-md-2"></div>
        <div class="col-lg-6 col-md-8 login-box px-4">

            <div class="col-lg-12 login-title">
                LOGIN
            </div>

            <div class="col-lg-12 login-form">
                <div class="col-lg-12 login-form">
                    <form>
                        <div class="form-group">
                            <label class="form-control-label">EMAIL</label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">PASSWORD</label>
                            <input type="password" class="form-control" i>
                            <small>lupa password? <strong>Reset password</strong></small>
                        </div>

                        <div class="col-lg-12 loginbttm">
                            <div class="col-lg-6 login-btm login-text">
                                <!-- Error Message -->
                            </div>
                            <div class="col-lg-12 login-btm login-button">
                                <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-2"></div>
        </div>
        <div class="col-md-12 text-center mt-3">
            <small> Belum punya akun? <a href="/register"><strong>DAFTAR SEKARANG</strong></a></small>
        </div>
</div>

@endsection