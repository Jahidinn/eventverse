<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard | Eventconnect.id</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/adminlte.css') }}">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('dashboard.layouts.navbar')
        @include('dashboard.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            {{-- tampil jika belum verifikasi email --}}
            @if (!Auth()->user()->email_verified_at)
                <section class="content mt-3">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Verifikasi email</h4>
                        <p>Biar lebih aman, cek email dan <strong>verifikasi</strong> dulu ya!</p>
                        <hr>
                        <form action="/email/verification-notification" method="post">
                            @csrf
                            <p class="mb-0">belum menerima email? <button href="/email/verification-notification"
                                    style="text-decoration:none" class="btn btn-secondary btn-sm">Request ulang</button>
                            </p>
                        </form>


                    </div>
                </section>
            @endif

            <!-- Main content -->
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="/">Eventconnect.id</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //delete event dari dashboard
            $('.delete-event').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Yakin hapus event?",
                    showCancelButton: true,
                    confirmButtonText: "<i class='fas fa-trash-alt'></i> Delete",
                    confirmButtonColor: "#d33",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var id = $(this).data("id");
                        $.ajax({
                            url: '/event/' + id,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire(response.success, '', 'success').then(
                                    function() {
                                        window.location =
                                            "/dashboard/manajemen-event";
                                    })
                            }
                        });

                    }
                });
            });
        });

        $('#edit-button').on('click', function(e) {
            e.preventDefault();
            $('#editModal').modal('show');
            var slug = $(this).data("slug");

            $('#edit-detail-event').attr('href', '/event/' + slug + '/edit');

        })

        //href = "" >
    </script>

</body>

</html>
