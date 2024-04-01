<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.tabs button').click(function() {
            var tab_id = $(this).attr('data-tab');

            $('.tabs button').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        });

        //select 2
        //$('.js-example-basic-single').select2();
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
            $('.select2-search__field').attr("placeholder", "Cari ... ");
        });

        $("#organizerEvent").select2({
            dropdownParent: $("#penyelenggaraEventModal"),
            allowClear: true
        });

        $("#organizerId").select2({
            dropdownParent: $("#penyelenggaraEventModal"),
            allowClear: true
        });

        $("#kategoriEvent").select2({
            dropdownParent: $("#kategoriEventModal"),
            allowClear: true
        });
        $("#temaEvent").select2({
            dropdownParent: $("#kategoriEventModal"),
            allowClear: true
        });

        $("#jenis-event").select2({
            dropdownParent: $("#lokasiEventModal"),
            allowClear: true
        });
        $("#provinces").select2({
            dropdownParent: $("#lokasiEventModal"),
            allowClear: true
        });
        $("#cities").select2({
            dropdownParent: $("#lokasiEventModal"),
            allowClear: true
        });

        $('#penyelenggaraEventModal').on('shown.bs.modal', function() {
            var previousOrg = $('#previousEvent').val();
            $.ajax({
                url: '/get-my-org',
                type: 'GET',
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                    var myOrg = $('#organizerId');
                    myOrg.empty();

                    if (response.data == '' || !response.data) {
                        $('.org-id-container').attr('hidden', true);
                        $('.event-no-org').attr('hidden', false);

                    } else {
                        $('.org-id-container').attr('hidden', false);
                        $('.event-no-org').attr('hidden', true);
                        myOrg.attr('hidden', false);
                        myOrg.removeAttr('disabled');

                        $("#organizerId").append(
                            '<option value="">Pilih Organisasi</option>');
                        $.each(response.data, function(index, item) {
                            var selectedAttribute = (item.org.id == previousOrg) ?
                                'selected' : '';

                            $("#organizerId").append('<option value="' + item.org
                                .id + '" ' + selectedAttribute + '>' + item.org
                                .org_name + '</option>');
                        });
                    }

                }
            })
        });

        // Event ketika modal disembunyikan (hidden)
        $('#penyelenggaraEventModal').on('hidden.bs.modal', function() {
            var penyelenggaraEvent = $('#penyelenggaraEvent').val();
            var myOrg = $('#organizerId').val();
            var orgType = $('#organizerEvent').val();
            $('#previousEvent').val(myOrg);

            //reset jika tidak memilih organisasi tapi tepenya organisasi
            if (orgType == 'org' && (myOrg == '' || myOrg == null)) {
                $('#organizerEvent').val('individual').trigger('change');
                $('#organizerId').val('').trigger('change');
            }

        });

        //Simpan penyelenggara
        $('body').on('click', '#simpan-organization', function(e) {
            e.preventDefault();
            var myOrg = $('#organizerId').val();
            var orgType = $('#organizerEvent').val();

            //reset jika tidak memilih organisasi tapi tepenya organisasi
            if (orgType == 'org' && (myOrg == '' || myOrg == null)) {
                $('.org-id-container .select2-container .select2-selection').addClass("border-danger");;
                e.preventDefault();
            } else {
                $('.org-id-container .select2-container .select2-selection').removeClass(
                    "border-danger");

                if ($('#organizerEvent').val() == 'org') {
                    $('#penyelenggaraEvent').val($('#organizerId').find("option:selected").text())
                    $('#penyelenggaraEventModal').modal('hide')
                } else {
                    $('#penyelenggaraEvent').val($('#organizer-individual').val())
                    $('#penyelenggaraEventModal').modal('hide')
                }
            }
        });

        //Penyelenggara event
        $('body').on('change', '#organizerEvent', function(e) {
            e.preventDefault();
            var orgType = $('#organizerEvent').val();

            if (orgType == 'individual') {
                //reset input offline dan hilangkan kolom input alamat
                $('.cont-individual').attr('hidden', false);
                $('.cont-org').attr('hidden', true);
            } else {

                $('.cont-individual').attr('hidden', true);
                $('.cont-org').attr('hidden', false);
            }
        });

        //lokasi event
        $('body').on('change', '#jenis-event', function(e) {
            e.preventDefault();
            var jenisEvent = $('#jenis-event').val();

            if (jenisEvent == 'Online') {
                //reset input offline dan hilangkan kolom input alamat
                $('#provinces').val('').trigger('change');
                $('#cities').val('').trigger('change');
                $('#detailAlamat').val('');
                $('#lokasi-event-container').attr('hidden', true);
            } else {
                $('#lokasi-event-container').attr('hidden', false);
            }
        });

        $('body').on('change', '#provinces', function(e) {
            e.preventDefault();
            var province_code = $('#provinces').val();

            if (province_code == '') {
                $('#cities').empty();
                $("#cities").append('<option value="">Pilih Kota</option>');
                $('#cities').attr('disabled', true);
            } else {
                $.ajax({
                    url: '/get-cities/' + province_code,
                    type: 'GET',
                    cache: false,
                    dataType: 'JSON',
                    success: function(response) {
                        var city = $('#cities');
                        city.removeAttr('disabled');

                        city.empty();
                        $("#cities").append('<option value="">Pilih Kota</option>');
                        $.each(response.result, function(key, value) {

                            $("#cities").append('<option value="' + value.name +
                                '">' +
                                value.name +
                                '</option>');
                        });

                    }

                });
            }
        });
    });


    document.addEventListener("trix-before-initialize", () => {
        // Change Trix.config if you need
    });
    $('trix-editor').css("min-height", "250px");

    $(".penyelenggara-event").click(function() {
        $("#penyelenggaraEventModal").modal("show");
    });

    $(".kategori-event").click(function() {
        $("#kategoriEventModal").modal("show");
    });

    $(".lokasi-event").click(function() {
        $("#lokasiEventModal").modal("show");
    });

    $(".tanggal-event").click(function() {
        $("#tanggalEventModal").modal("show");
    });


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

    //url form
    $('#url-event').on('keyup', function() {
        var url = $('#url-event').val();
        url = url.replace(/\s+/g, '-');
        $('#url-event').val(url);
    });

    //mengisi form kategori, lokasi, & tanggal

    //kategori
    $('body').on('click', '#simpan-kategori', function(e) {
        e.preventDefault();
        var kategoriEvent = $('#kategoriEvent option:selected').text();
        var temaEvent = $('#temaEvent option:selected').text();
        $('.kategori-event').val(kategoriEvent.trim() + ' (' + temaEvent.trim() + ')');
        $('#kategoriEventModal').modal('hide');
    });

    //lokasi
    $('body').on('click', '#simpan-lokasi', function(e) {
        e.preventDefault();
        var jenisEvent = $('#jenis-event').val();
        if (jenisEvent == 'Online') {
            var province = null;
            var city = null;
            var detailAlamat = null;
            var alamat = jenisEvent
            $('#lokasiEventModal').modal('hide');
            $('.lokasi-event').val(alamat);
        } else {
            var province = $('#provinces').val();
            var city = $('#cities').val();
            var detailAlamat = $('#detailAlamat').val();

            if (province == '' || city == '' || detailAlamat == '') {
                Swal.fire('', 'Lengkapi alamat dulu guys!');
            } else {
                var alamat = jenisEvent + ' (' + detailAlamat + ', ' + city + ', ' + province + ')';
                $('#lokasiEventModal').modal('hide');
                $('.lokasi-event').val(alamat);
            }
        }
    });

    //tanggal
    $('body').on('click', '#simpan-tanggal', function(e) {
        e.preventDefault();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        if (startDate == '' || startDate == null) {
            $('#startDate').addClass('border-danger');
            $('#endDate').removeClass('border-danger');
        } else if (endDate == '' || endDate == null) {
            $('#endDate').addClass('border-danger');
            $('#startDate').removeClass('border-danger');
        } else {
            $('#endDate').removeClass('border-danger');
            $('#startDate').removeClass('border-danger');

            // Membandingkan dua tanggal
            if (startDate > endDate) {
                Swal.fire('', 'Cek lagi tanggal mulai dan tanggal selesai event!', '');
            } else {
                $('.tanggal-event').val(moment(startDate).format('DD MMM YYYY') + ' - ' + moment(endDate)
                    .format('DD MMM YYYY'));
                $('#tanggalEventModal').modal('hide');
            }

        }

    });


    $(document).ready(function() {

        var max_fields = 2; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $("#add-ticket"); //Add button ID

        var x = 0; //initlal text box count
        var ticketStock = 0;
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            var endEventDate = $("#endDate").val(); //Tanggal berakhir event

            var ticketName = $("#ticketName").val();
            var ticketDescription = $("#ticketDescription").val();
            var ticketQuota = $("#ticketQuota").val();
            var ticketDate = $("#ticketDate").val();
            var ticketEndDate = $("#ticketEndDate").val();
            var ticketButton = $("#ticketButton").val();
            var ticketButtonText = $("#ticketButton").children("option:selected").text();
            var checkboxValue = $("#ticketMoreQty").is(":checked") ? 1 : 0; //bisa order lebih dari 1x?

            var ticketPrice = $("#ticketPrice").val();

            if (ticketPrice.replace(/[^0-9]/g, '') == 0 || ticketPrice == '') {
                ticketPrice = "GRATIS!";
                price = 0;
            } else {
                var price = ticketPrice.replace(/[^0-9]/g, '');
            }

            //cek form
            if (ticketName == '') {
                $("#ticketName").addClass('border border-danger');
                $("#ticketQuota").removeClass('border border-danger');
                $("#ticketDescription").removeClass('border border-danger');
                $("#ticketDate").removeClass('border border-danger');
            } else if (ticketDescription != '') {
                $("#ticketDescription").addClass('border border-danger');
                $("#ticketName").removeClass('border border-danger');
                $("#ticketQuota").removeClass('border border-danger');
                $("#ticketDate").removeClass('border border-danger');
            } else if (ticketQuota == '') {
                $("#ticketQuota").addClass('border border-danger');
                $("#ticketName").removeClass('border border-danger');
                $("#ticketDescription").removeClass('border border-danger');
                $("#ticketDate").removeClass('border border-danger');
            } else if (ticketDate == '' || ticketEndDate == '') {
                $("#ticketDate").addClass('border border-danger');
                $("#ticketEndDate").addClass('border border-danger');
                $("#ticketQuota").removeClass('border border-danger');
                $("#ticketName").removeClass('border border-danger');
                $("#ticketDescription").removeClass('border border-danger');
            } else if (ticketEndDate > endEventDate) {
                $("#ticketDate").removeClass('border border-danger');
                $("#ticketEndDate").addClass('border border-danger');
                $("#ticketQuota").removeClass('border border-danger');
                $("#ticketName").removeClass('border border-danger');
                $("#ticketDescription").removeClass('border border-danger');
                Swal.fire('',
                    'Sepertinya periode tiket pendaftaran melebihi tanggal berakhirnya event!',
                    '');
            } else {
                ticketStock++
                if (ticketStock <= max_fields) { //max input box allowed
                    x++; //text box increment
                    //menambah tiket

                    $(wrapper).append(`
						<div class="card border-0 m-0 p-0 mt-3 bg-none">
							<button class="btn btn-danger remove_field px-0" style="z-index: 3;">
								<i class="fas fa-trash-alt"></i> Delete
							</button>
							<div class="card ticket-card rounded-0 mt-1">
								<div class="card-header bg-ticket text-white rounded-0">
									<small>
										<strong>${ticketName}</strong>
									</small>
								</div>
								<div class="card-body">
									<input type="hidden" value="${ticketName}" name="ticketName[${x}]">
									<input type="hidden" value="${ticketDescription}" name="ticketDescription[${x}]" id="">
									<p class="card-text pt-0">
										<small class="text-secondary icon-class">
											<i class="fas fa-hourglass-end pr-4"></i>Berakhir : <strong>${ticketEndDate}</strong>
											<span class="alert alert-success py-1 px-2 ms-2"><strong>Kuota : ${ticketQuota}</strong>
												<input type="hidden" value="${ticketQuota}" name="ticketQuota[${x}]">
											</span>
										</small>
									</p>
									<input type="hidden" value="${ticketDate}" name="ticketDate[${x}]">
									<input type="hidden" value="${ticketEndDate}" name="ticketDeadline[${x}]">
									<hr class="dashed">
									<div class="row">
										<div class="col">
											<span class="badge bg-secondary py-2 rounded-0">
												<strong><i class="fas fa-tag"></i> ${ticketPrice}</strong>
												<input type="hidden" value="${price}" name="ticketPrice[${x}]">
											</span>
											<input type="hidden" value="${ticketButton}" name="ticketButton[${x}]">
											<input type="hidden" value="${checkboxValue}" name="moreQuantity[${x}]">
										</div>
										<div class="col text-end">
											<button type="button" class="btn btn-sm btn-success px-3">
												<strong>${ticketButtonText} <i class="fas fa-arrow-circle-right"></i></strong>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					`);
                    // add input boxes.
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
            var tanggalEvent = $('#tanggalEvent').val();

            if (ticketStock >= max_fields) {
                //$("#add-ticket-modal").addClass("disabled");
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Maksimal hanya menambahkan 5 ticket guys!',
                    footer: '<a href="">pelajari lebih lanjut?</a>'
                });
            } else if (tanggalEvent == '') {
                Swal.fire('', 'Isi tanggal event sebelum buat tiket pendaftaran!', '');
            } else {
                $("#ticketModal").modal('show');
            }

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
            $("#ticketMoreQty").prop("checked", false);

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
                    '<div class="input-group mb-3 icon-class"><input type="text" class="form-control" required placeholder="Isikan nama form ..." name="formName[' +
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
        });
    });

    $(function() {
        $("#eventStartDate,#eventEndDate,#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());
    });

    $(document).ready(function(e) {

        $('#form-event').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('/event') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('', response.error, 'error');
                    } else {
                        Swal.fire({
                            text: response.success,
                            icon: 'success',
                            willClose: () => {
                                // Aksi yang akan dijalankan setelah alert ditutup
                                window.location.href = "/" + response.url;
                            }
                        });

                    }
                }
            });
        });

        ///
        $('#delete-event').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });
        ///

        //cek ketersediaan URL
        $('#url-event').on('keyup', function(e) {
            e.preventDefault();
            var url = $('#url-event').val();

            $.ajax({
                type: 'GET',
                url: "{{ url('/check-url') }}",
                data: {
                    url: url
                },
                success: function(response) {
                    if (response.result == 0) {
                        $('#url-notif-danger').attr('hidden', true);
                        $('#url-notif-success').removeAttr('hidden');
                    } else if (response.result == 'N') { //jika null
                        $('#url-notif-danger').attr('hidden', true);
                        $('#url-notif-success').attr('hidden', true);
                    } else {
                        $('#url-notif-danger').removeAttr('hidden');
                        $('#url-notif-success').attr('hidden', true);
                    }
                }
            });

        });

    });
</script>
