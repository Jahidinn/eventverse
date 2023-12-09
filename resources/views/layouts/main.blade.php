<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>eventconnect.id | your success partner</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/slick/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Moderna - v2.0.1
    * Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        @include('layouts.navbar')
    </header>

    <main id="main">
        @yield('content')
    </main>


    <!-- ======= Footer ======= -->
    <footer id="footer">
        @include('layouts.footer')
    </footer>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

    <!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/custom-script.js') }}"></script>

    <script>
        // For example trigger on button clicked, or any time you need


        $(document).ready(function() {

            $('.tabs button').click(function() {
                var tab_id = $(this).attr('data-tab');

                $('.tabs button').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            })
            gridSearch();

            $(window).resize(function() {
                gridSearch();

            });

            function gridSearch() {
                var sreenSize = $(window).width();
                if (sreenSize < 1170 && sreenSize > 750) {
                    $(".card-event-search").removeClass('col-md-3');
                    $(".card-event-search").addClass('col-md-4');
                    $(".card-event-search").removeClass('col-6');
                } else if (sreenSize < 750 && sreenSize > 500) {
                    $(".card-event-search").removeClass('col-md-3');
                    $(".card-event-search").removeClass('col-md-4');
                    $(".card-event-search").addClass('col-6');
                } else {
                    $(".card-event-search").removeClass('col-6');
                    $(".card-event-search").removeClass('col-md-4');
                    $(".card-event-search").addClass('col-md-3');
                }
            }
            $(".filter-city, .filter-category, #filter-jenis-lokasi, #sort-filter").select2({
                allowClear: true
            });

            $(function() {
                $("#datepicker").datepicker({
                    autoclose: true,
                    todayHighlight: true,
                }).datepicker('update', "{{ request('date') }}");
            });

            $('body').on('click', '#datepicker', function(e) {
                $("#datepicker").datepicker('show');
            });

            $('body').on('change', '#filter-category', function(e) {
                var kategori = $('#filter-category option:selected').text().trim();
                if (kategori == 'Semua kategori') {
                    var kat = '';
                } else {
                    var kat = kategori;
                }
                $('#cat-name').val(kat)
            });

            //lokasi event
            $('body').on('change', '#filter-jenis-lokasi', function(e) {
                e.preventDefault();
                var jenisEvent = $('#filter-jenis-lokasi').val();

                if (jenisEvent == 'Online') {
                    //reset input offline dan hilangkan kolom input alamat
                    $('#filter-city').val('').trigger('change');
                    $('#filter-city').attr('disabled', true);
                    $('.container-city').attr('hidden', true);
                } else {
                    $('#filter-city').attr('disabled', false);
                    $('.container-city').attr('hidden', false);
                }
            });

            $('#sort-filter').on('change', function() {
                this.form.submit();
            });

            $('body').on('click', '.ticket-button', function(e) {
                e.preventDefault();
                var userAuthLogin = {{ auth()->check() ? 'true' : 'false' }};
                var ticket_id = $(this).data('id');
                var event_id = $(this).data('event_id');
                var label_button = $(this).data('label_button');

                if (!userAuthLogin) {
                    Swal.fire({
                        title: "",
                        html: "Kamu belum login nih! <strong>login</strong> dulu? atau " +
                            label_button + " <strong>tanpa login?</strong>",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Login",
                        denyButtonText: `Tanpa login`,
                        denyButtonColor: "#0dcaf0",
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        } else if (result.isDenied) {
                            window.location.href = '/event/checkout?event=' + event_id +
                                '&ticket=' + ticket_id;
                        }
                    });
                } else {
                    window.location.href = '/event/checkout?event=' + event_id +
                        '&ticket=' + ticket_id;
                }
            });
        });
    </script>

    @stack('transaction-scripts')
    @stack('transaction-invoice')
</body>

</html>
