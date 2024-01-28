<script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
        if (loggedIn) {
            $('.checkbox').on('change', function() {
                if ($('.checkbox').is(":checked")) {
                    $('#fullName').attr('readonly', false);
                    $('#email').attr('readonly', false);
                } else {
                    $('#fullName').attr('readonly', true);
                    $('#email').attr('readonly', true);
                }
            });
        }

        $('#checkout-event').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            //Cek koneksi dulu
            if (navigator.onLine) {
                $('#checkout-button').html('<i class="fas fa-spinner fa-spin"></i> Processing ...');
                $('#checkout-button').attr('disabled', true);
                var biayaAdmin = "{{ config('app.biaya_admin') }}"

                $.ajax({
                    type: 'POST',
                    url: '/event/checkout-proccess',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            $('#checkout-button').html('Bayar sekarang!');
                            $('#checkout-button').attr('disabled', false);
                            Swal.fire('Ooopss', response.error, 'error');
                        } else if (response.success) {
                            $('#checkout-button').html('Bayar sekarang!');
                            $('#checkout-button').attr('disabled', false);
                            Swal.fire({
                                text: response.success,
                                icon: 'success',
                                showCancelButton: false, // Hilangkan tombol Cancel
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then((result) => {
                                // Periksa apakah pengguna mengklik tombol "OK"
                                if (result.isConfirmed) {
                                    // Alihkan ke halaman yang diinginkan
                                    window.location.href = '/event/invoice/' +
                                        response.id;
                                }
                            });
                        } else {

                            var transaction = response.transaction;
                            var event = response.event;
                            var ticket = response.ticket;
                            let price = transaction.total_price - biayaAdmin;

                            //untuk format number ribuan
                            function formatNumber(number) {
                                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ".");
                            }

                            //Menampilkan data konfirmasi checkout
                            $('#checkoutModal').modal('show');
                            $('#checkout-button').html('Bayar sekarang!');
                            $('#checkout-button').attr('disabled', false);
                            $('#transaction').val(response.token);
                            $('#id_event').val(transaction.id);
                            $('#confirm_is_login').val(transaction.is_login);
                            $('#confirm_user_login_id').val(transaction.user_login_id);
                            $('#email_transaction').val(transaction.email);
                            $('#confirm_nama').html(transaction.name);
                            $('#confirm_email').html(transaction.email);
                            $('#confirm_nomerhp').html(transaction.phone);
                            $('#confirm_nomerhp').html(transaction.phone);
                            $('#confirm_event_title').html(event.title);
                            $('#confirm_penyelenggara').html(event.penyelenggara.name);
                            $('#confirm_ticket').html(ticket.ticket_name);
                            $('#confirm_jumlah_tiket').html(transaction.quantity);
                            $('#confirm_price').html(formatNumber(price));
                            $('#confirm_total_price').html(formatNumber(transaction
                                .total_price));
                        }
                    }
                })
            }
            //Jika Offline
            else {
                Swal.fire('', 'Cek koneksi internet kamu!', 'warning');
            }
        })

        $("#checkoutModal").on('hide.bs.modal', function() {
            $('#pay-button').html("<i class='fas fa-check'></i> Bayar sekarang");
            $('#pay-button').attr('disabled', false);
        });

        $('body').on('click', '.transaction-cancel-button', function(e) {
            e.preventDefault();
            let idTransaction = $('#id_event').val()
            let emailTransaction = $('#email_transaction').val()

            let is_login = $('#confirm_is_login').val();
            let user_login_id = $('#confirm_user_login_id').val();
            //console.log(idTransaction, emailTransaction);

            Swal.fire({
                title: "Batalkan transaksi?",
                html: "Klik <strong>Batalkan</strong> untuk membatalkan proses pembayaran",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Batalkan",
                cancelButtonText: `Lanjut`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    if (is_login != 0 || user_login_id != 0) {
                        Swal.fire('Ok!',
                            'Kamu bisa melanjutkan transaksi di profil dashboard ya!', );
                        $('#checkoutModal').modal('hide');
                    } else {

                        //Hapus jika daftar tapi tidak login (beli sekali selesai)
                        $.ajax({
                            type: 'POST',
                            url: "/event/transaction-delete",
                            data: {
                                id: idTransaction,
                                email: emailTransaction,
                            },
                            success: function(response) {
                                $('#checkoutModal').modal('hide');
                            }
                        });
                    }
                } else {
                    //Lanjut
                }
            })
        })
    })
</script>
