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

        $('#form-subscribe').submit(function(event) {
            // Menghentikan pengiriman formulir secara default
            event.preventDefault();

            // Membuat objek FormData dan menambahkan data formulir
            var formData = new FormData(this);
            $('#btn-subscribe').val('Processing ...');

            // Mengirim data menggunakan Ajax
            $.ajax({
                url: '/subscribe',
                type: $(this).attr('method'), // Menggunakan metode dari atribut method formulir
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Tindakan yang diambil setelah permintaan berhasil
                    if (response.success) {
                        Swal.fire('', response.success, 'success');
                    } else {
                        Swal.fire('', response.error, 'error');

                    }
                    $('#btn-subscribe').val('Subscribe');
                },
                error: function(xhr, status, error) {
                    // Tindakan yang diambil jika terjadi kesalahan
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
