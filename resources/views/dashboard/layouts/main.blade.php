<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <title>Dashboard | Eventconnect.id</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                        <hr>
                        <form action="/email/verification-notification" method="post">
                            @csrf
                            <p>Biar lebih aman, cek email dan <strong>verifikasi</strong> dulu ya!
                                <button href="/email/verification-notification" style="text-decoration:none"
                                    class="btn btn-secondary btn-sm border-rounded px-3"><i class="fas fa-retweet"></i>
                                    Request ulang</button>
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
            <small><strong>Copyright &copy; 2014-2021 <a href="/">Eventconnect.id</a>.</strong> All rights
                reserved.</small>
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

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    text: "Yakin hapus event?",
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
                                if (response.success) {
                                    Swal.fire(response.success, '', 'success').then(
                                        function() {
                                            location.reload();
                                        })
                                } else {
                                    Swal.fire('Ooopss', response.error, 'error');
                                }
                            }
                        });
                    }
                });
            });
        });

        $(function() {
            $("#eventStartDate,#eventEndDate,#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });

        $('.edit-ticket-button').on('click', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var titleEvent = $(this).data('event');
            $('.event_id').val($(this).data('id'));

            $('.manajemen-event-box').attr('hidden', true);
            $('.manajemen-ticket-box').attr('hidden', false);

            $('.manajemen-event-title').text('Edit ticket event');
            $('.event-title-for-ticket').text(titleEvent);

            //Menampilkan tabel daftar ticket
            var ticketTable = $('#ticket-table').DataTable({
                "dom": 'rtip',
                "bInfo": false,
                processing: true,
                serverside: true,
                destroy: true,
                ajax: {
                    'type': 'GET',
                    'url': '/get-ticket',
                    'data': {
                        event_id: id,
                    },
                },
                columns: [{
                    data: 'ticket_name',
                    name: 'ticket_name'
                }, {
                    data: 'ticket_price',
                    name: 'ticket_price'
                }, {
                    data: 'ticket_quota',
                    name: 'ticket_quota'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });

            $('#search-ticket').keyup(function() {
                ticketTable.search($(this).val()).draw();
            });

        })

        $('#back-from-ticket').on('click', function(e) {
            e.preventDefault();

            $('.manajemen-event-box').attr('hidden', false);
            $('.manajemen-ticket-box').attr('hidden', true);
            $('.manajemen-event-title').html('Buat event sesukamu! <i class="fas fa-paper-plane"></i>');

        });

        $('.edit-formulir-button').on('click', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var titleEvent = $(this).data('event');
            $('.event_id').val($(this).data('id'));

            $('.manajemen-event-box').attr('hidden', true);
            $('.manajemen-formulir-box').attr('hidden', false);

            $('.manajemen-event-title').text('Edit formulir pendaftaran');
            $('.event-title-for-formulir').text(titleEvent);

            //Menampilkan tabel daftar formulir
            var formTable = $('#form-table').DataTable({
                "dom": 'rtip',
                "bInfo": false,
                processing: true,
                serverside: true,
                destroy: true,
                ajax: {
                    'type': 'GET',
                    'url': '/get-formulir',
                    'data': {
                        event_id: id,
                    },
                },
                columns: [{
                    data: 'form_name',
                    name: 'form_name'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });

            $('#search-form').keyup(function() {
                formTable.search($(this).val()).draw();
            });

        })

        $('#back-from-formulir').on('click', function(e) {
            e.preventDefault();

            $('.manajemen-event-box').attr('hidden', false);
            $('.manajemen-formulir-box').attr('hidden', true);
            $('.manajemen-event-title').html('Buat event sesukamu! <i class="fas fa-paper-plane"></i>');

        });

        /* Dengan Rupiah */
        var dengan_rupiah = document.getElementById('ticket_price');
        if (dengan_rupiah) {
            dengan_rupiah.addEventListener('keyup', function(e) {
                dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
            });
        }

        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        //add ticket
        $('body').on('click', '#add-ticket-button', function(e) {
            e.preventDefault();
            $('#addEditTicketModal').modal('show');
            $('#addEditTicketModalLabel').text('Tambah tiket pendaftaran')
            $('.addEditTicket').attr('id', 'add-ticket-form')
            $('.btn-ticket-submit').attr('id', 'submit-add-ticket')
        });

        $('body').on('click', '#submit-add-ticket', function(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("add-ticket-form"));

            $.ajax({
                type: 'POST',
                url: "{{ url('/add-ticket') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                    } else {
                        Swal.fire('', response.success, 'success')
                        $('#addEditTicketModal').modal('hide')
                        $('#ticket-table').DataTable().ajax.reload()
                    }
                }
            });
        });

        //Edit Ticket
        $('body').on('click', '.edit-ticket', function(e) {
            e.preventDefault();
            $('#addEditTicketModal').modal('show');
            $('#addEditTicketModalLabel').text('Edit tiket pendaftaran')
            $('.addEditTicket').attr('id', 'edit-ticket-form')
            $('.btn-ticket-submit').attr('id', 'submit-edit-ticket')

            $('#id_ticket').val($(this).data('id'));
            $('#ticket_name').val($(this).data('ticket_name'));
            $('#ticket_price').val('Rp ' + ($(this).data('ticket_price') / 1000).toFixed(3));
            $('#ticket_quota').val($(this).data('ticket_quota'));
            $('#ticket_start').val($(this).data('ticket_start'));
            $('#ticket_deadline').val($(this).data('ticket_deadline'));
            $('#ticket_button option[value="' + $(this).data('ticket_button') + '"]').prop("selected", true);
        });

        $('body').on('click', '#submit-edit-ticket', function(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("edit-ticket-form"));

            $.ajax({
                type: 'POST',
                url: "{{ url('/edit-ticket') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                    } else {
                        Swal.fire('', response.success, 'success')
                        $('#addEditTicketModal').modal('hide')
                        $('#ticket-table').DataTable().ajax.reload()
                    }
                }
            });
        });

        $('#addEditTicketModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })
        $('#addEditFormModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        //add form
        $('body').on('click', '#add-formulir-button', function(e) {
            e.preventDefault();
            $('#addEditFormModal').modal('show');
            $('#addEditFormModalLabel').text('Tambah Form pendaftaran')
            $('.addEditForm').attr('id', 'add-formulir-form')
            $('.btn-form-submit').attr('id', 'submit-add-form')
        });

        $('body').on('click', '#submit-add-form', function(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("add-formulir-form"));

            $.ajax({
                type: 'POST',
                url: "{{ url('/add-formulir') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                    } else {
                        Swal.fire('', response.success, 'success')
                        $('#addEditFormModal').modal('hide')
                        $('#form-table').DataTable().ajax.reload()
                    }
                }
            });
        });

        //Edit Form
        $('body').on('click', '.edit-formulir', function(e) {
            e.preventDefault();
            $('#addEditFormModal').modal('show');
            $('#addEditFormModalLabel').text('Edit Form pendaftaran')
            $('.addEditForm').attr('id', 'edit-formulir-form')
            $('.btn-form-submit').attr('id', 'submit-edit-form')

            $('#id_form').val($(this).data('id'));
            $('#form_name').val($(this).data('form_name'));
        });

        $('body').on('click', '#submit-edit-form', function(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("edit-formulir-form"));

            $.ajax({
                type: 'POST',
                url: "{{ url('/edit-formulir') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                    } else {
                        Swal.fire('', response.success, 'success')
                        $('#addEditFormModal').modal('hide')
                        $('#form-table').DataTable().ajax.reload()

                    }
                }
            });
        });

        $('body').on('click', '.delete-ticket', function(e) {
            e.preventDefault();
            var ticket_id = $(this).data('id')

            Swal.fire({
                title: "Delete ticket?",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "<i class='fas fa-trash-alt'></i> Delete",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/delete-ticket',
                        type: 'POST',
                        data: {
                            id: ticket_id,
                        },
                        success: function(response) {
                            Swal.fire('', response.success, 'success')
                            $('#ticket-table').DataTable().ajax.reload()
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });

        $('body').on('click', '.delete-formulir', function(e) {
            e.preventDefault();
            var form_id = $(this).data('id')

            Swal.fire({
                title: "Delete Formulir?",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "<i class='fas fa-trash-alt'></i> Delete",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/delete-formulir',
                        type: 'POST',
                        data: {
                            id: form_id,
                        },
                        success: function(response) {
                            Swal.fire('', response.success, 'success')
                            $('#form-table').DataTable().ajax.reload()
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });

        $('body').on('click', '#detailReportButton', function(e) {
            e.preventDefault();
            console.log('hahaha');
            $('#detailReportTransaksi').modal('show');

        })
    </script>

    @stack('js-myevent')
    @stack('js-participant')

</body>

</html>
