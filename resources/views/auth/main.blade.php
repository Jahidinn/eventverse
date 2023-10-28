<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <title>eventconnect.id | your success partner</title>
    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/formevent.css') }}" rel="stylesheet">

</head>

<body>

    @yield('content')

    <script src="{{ asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('.tabs button').click(function() {
                var tab_id = $(this).attr('data-tab');

                $('.tabs button').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            })

        });


        document.addEventListener("trix-before-initialize", () => {
            // Change Trix.config if you need
        });
        $('trix-editor').css("min-height", "250px");

        $(".kategori-event").click(function() {
            $("#exampleModal").modal("show");
        });
        const fileUpload = (event) => {
            const files = event.target.files;
            const filesLength = files.length;
            if (filesLength > 0) {
                const imageSrc = URL.createObjectURL(files[0]);
                const imagePreviewElement = document.querySelector("#tb-image");
                imagePreviewElement.src = imageSrc;
                imagePreviewElement.style.display = "block";
            }
        };

        var rupiah = document.getElementById("ticketPrice");

        if (rupiah) {
            rupiah.addEventListener("keyup", function(e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah.value = formatRupiah(this.value, "Rp. ");
            });
        }

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        $(document).ready(function() {

            var max_fields = 2; //maximum input boxes allowed
            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var add_button = $("#add-ticket"); //Add button ID

            var x = 0; //initlal text box count
            var ticketStock = 0;
            $(add_button).click(function(e) { //on add input button click
                e.preventDefault();
                var ticketName = $("#ticketName").val();
                var ticketDescription = $("#ticketDescription").val();
                var ticketQuota = $("#ticketQuota").val();
                var ticketDate = $("#ticketDate").val();
                var ticketButton = $("#ticketButton").val();
                var ticketButtonText = $("#ticketButton").children("option:selected").text();

                var ticketPrice = $("#ticketPrice").val();
                if (ticketPrice == '') {
                    ticketPrice = "GRATIS!";
                    price = '';
                } else {
                    var price = ticketPrice.replace(/[^0-9]/g, '');
                }

                //cek form
                if (ticketName == '') {
                    $("#ticketName").addClass('border border-danger');
                    $("#ticketQuota").removeClass('border border-danger');
                    $("#ticketDescription").removeClass('border border-danger');
                    $("#ticketDate").removeClass('border border-danger');
                } else if (ticketDescription == '') {
                    $("#ticketDescription").addClass('border border-danger');
                    $("#ticketName").removeClass('border border-danger');
                    $("#ticketQuota").removeClass('border border-danger');
                    $("#ticketDate").removeClass('border border-danger');
                } else if (ticketQuota == '') {
                    $("#ticketQuota").addClass('border border-danger');
                    $("#ticketName").removeClass('border border-danger');
                    $("#ticketDescription").removeClass('border border-danger');
                    $("#ticketDate").removeClass('border border-danger');
                } else if (ticketDate == '') {
                    $("#ticketDate").addClass('border border-danger');
                    $("#ticketQuota").removeClass('border border-danger');
                    $("#ticketName").removeClass('border border-danger');
                    $("#ticketDescription").removeClass('border border-danger');
                } else {
                    ticketStock++
                    if (ticketStock <= max_fields) { //max input box allowed
                        x++; //text box increment
                        //menambah tiket

                        $(wrapper).append(
                            '<div class="card border-0 m-0 p-0 mt-3 bg-none"><button class="btn btn-danger remove_field position-absolute top-50 end-0 translate-middle-y" style="z-index: 2;"><h3><i class="fas fa-trash-alt mt-2"></i></h3></button><div class="card shadow ticket-card"><div class="card-body"><div class="alert alert-success w-100 py-2"><strong>' +
                            ticketName +
                            '</strong></div><input type="hidden" value="' +
                            ticketName + '" name="ticket-name[' +
                            x +
                            ']"><hr class="dashed"><p class="card-text mr-5">' + ticketDescription +
                            '</p><input type="hidden" value="' + ticketDescription +
                            '"  name="ticket-description[' +
                            x +
                            ']" id=""><p class="card-text pt-0"><small class="text-muted icon-class"><i class="fas fa-hourglass-end pr-4"></i>Berakhir : <strong>' +
                            ticketDate +
                            '</strong><span class="alert alert-secondary rounded-0 py-1 ms-2"><strong>Kuota : ' +
                            ticketQuota + '</strong><input type="hidden" value="' + ticketQuota +
                            '" name="ticket-quota[' + ticketQuota +
                            ']"></span></small></p><input type="hidden" value="' +
                            ticketDate +
                            '" name="ticket-deadline[' +
                            x +
                            ']"><hr class="dashed"><div class="d-inline"><span class="alert alert-primary py-2 rounded-0"><strong>' +
                            ticketPrice + '</strong><input type="hidden" value="' + price +
                            '" name="ticket-price[' +
                            x +
                            ']"></span><input type="hidden" value="' + ticketButton +
                            '" name="ticket-button[' + x +
                            ']"><div class="float-end"><button class="btn btn-success px-3">' +
                            ticketButtonText + '</button></div></div></div></div></div>'
                        ); // add input boxes.
                    }
                    $("#ticketModal").modal('hide');
                    $('#ticket-example').addClass("d-none");

                    if (ticketStock >= max_fields) {
                        $("#add-ticket").addClass("disabled");
                        $("#add-ticket-modal").removeAttr("data-bs-target");
                    }
                }
            });
            $('#add-ticket-modal').on("click", function(e) {
                if (ticketStock >= max_fields) {
                    //$("#add-ticket-modal").addClass("disabled");
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maksimal hanya menambahkan 5 ticket guys!',
                        footer: '<a href="">pelajari lebih lanjut?</a>'
                    });
                }
                console.log(ticketStock);
                console.log(x);
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                ticketStock--;
                console.log(ticketStock);
                console.log(x);
                $(this).parent('div').remove();
                if (x == 1) {
                    $('#ticket-example').removeClass("d-none");
                }
                if (ticketStock <= max_fields) {
                    $("#ticket-example").removeClass("disabled");
                    $("#add-ticket").removeClass("disabled");
                    //$("#add-ticket-modal").removeClass("disabled");
                    $("#add-ticket-modal").attr("data-bs-target", "#ticketModal");
                }
            });
            $('#ticketModal').on('hidden.bs.modal', function(e) {
                $("#ticketName").val('');
                $("#ticketDescription").val('');
                $("#ticketPrice").val('');
                $("#ticketQuota").val('');

                $("#ticketName").removeClass('border border-danger');
                $("#ticketQuota").removeClass('border border-danger');
                $("#ticketDescription").removeClass('border border-danger');
                $("#ticketDescription").removeClass('border border-danger');
                //$(this).find('#form-ticket')[0].reset();
            });

            var max_forms = 10;
            var form_wrapper = $(".form-wrap");
            var add_form = $("#add-form");

            var formNumber = 0;
            var myForm = 0;
            $(add_form).click(function(e) {
                e.preventDefault();
                myForm++;
                if (myForm <= max_forms) { //max input box allowed
                    formNumber++; //text box increment
                    //menambah tiket
                    $(form_wrapper).append(
                        '<div class="input-group mb-3 icon-class"><input type="text" class="form-control" placeholder="Isikan nama form ..." name="formName[' +
                        formNumber +
                        ']"> <button data-id="' + formNumber +
                        '" class="btn btn-outline-danger" style="width:85px;" type="button" id="delete-form"><i class="fas fa-trash-alt"></i>Del</button></div>'
                    ); // add input boxes.
                }
                if (myForm >= 10) {
                    $("#add-form").addClass("disabled");
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maksimal hanya menambahkan 10 form guys!',
                        footer: '<a href="">pelajari lebih lanjut?</a>'
                    });
                }
            });

            $(form_wrapper).on("click", "#delete-form", function(e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
                myForm--;

                if (myForm <= 10) {
                    $("#add-form").removeClass("disabled");
                }
                console.log(myForm);
            });

        });
        $(function() {
            $("#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });
    </script>
</body>

</html>
