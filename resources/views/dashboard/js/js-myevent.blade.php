<script>
    $(document).ready(function(e) {

        //Dipakai ketika menampilkan my event dengan ajax
        // var user_id = "{{ auth()->user()->id }}"

        // var myeventTable = $('#myevent-table').DataTable({
        //     "dom": 'rtip',
        //     "bInfo": false,
        //     processing: true,
        //     serverside: true,
        //     destroy: true,
        //     ajax: {
        //         'type': 'GET',
        //         'url': '/dashboard/get-myevent',
        //         'data': {
        //             user_id: user_id,
        //         },
        //     },
        //     columns: [{
        //         data: 'DT_RowIndex',
        //         name: 'DT_RowIndex',
        //         orderable: false,
        //         searchable: false
        //     }, {
        //         data: 'event',
        //         name: 'event'
        //     }, {
        //         data: 'quantity',
        //         name: 'quantity'
        //     }, {
        //         data: 'transaction_status',
        //         name: 'transaction_status'
        //     }, {
        //         data: 'action',
        //         name: 'action'
        //     }]
        // });

        $('#search-myevent').keyup(function() {
            myeventTable.search($(this).val()).draw();
        });

        $('body').on('click', '.lanjutkan-transaksi', function(e) {
            e.preventDefault();

            var idTransaction = $(this).data('id');

            if (navigator.onLine) {
                $('#checkout-button').html('Processing ...');
                $('#checkout-button').attr('disabled', true);

                var biayaAdmin = "{{ config('app.biaya_admin') }}"

                console.log(idTransaction);

                $.ajax({
                    type: 'POST',
                    url: '/event/continue-transaction',
                    data: {
                        id: idTransaction,
                    },
                    success: function(response) {
                        if (response.error) {
                            Swal.fire('Ooopss', response.error, 'error');
                        } else if (response.expired) {
                            Swal.fire('Ooopss', response.expired, 'error').then(function() {
                                window.location = "/dashboard/myevent";
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

        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            $('#pay-button').html('Processing ...');
            $('#pay-button').attr('disabled', true);

            let idTransaction = $('#id_event').val()
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay($('#transaction').val(), {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    window.location.href = '/event/invoice/' + idTransaction;
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    $('#pay-button').html("<i class='fas fa-check'></i> Bayar sekarang");
                    $('#pay-button').attr('disabled', false);
                    Swal.fire({
                        icon: "info",
                        text: "wating your payment!",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            window.location.href = '/event/invoice/' +
                                idTransaction;
                        }
                    });
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    Swal.fire({
                        icon: "error",
                        text: "payment failed!!",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    console.log(result);
                },
                onClose: function() {
                    $('#pay-button').html("<i class='fas fa-check'></i> Bayar sekarang");
                    $('#pay-button').attr('disabled', false);
                    /* You may add your own implementation here */
                    Swal.fire({
                        icon: "warning",
                        text: "you closed the popup without finishing the payment!",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                }
            })
        });
    })

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
            if (result.isConfirmed) {
                $('#checkoutModal').modal('hide');
            } else {
                //Lanjut
            }
        })
    })
</script>
