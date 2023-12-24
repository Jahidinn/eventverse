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

        $('body').on('click', '.detail-myevent', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location = "/event/redirect-invoice/" + id;
        })

        $('body').on('click', '.lanjutkan-transaksi', function(e) {
            e.preventDefault();

            var idTransaction = $(this).data('id');

            if (navigator.onLine) {
                $('#checkout-button').html('Processing ...');
                $('#checkout-button').attr('disabled', true);

                var biayaAdmin = "{{ config('app.biaya_admin') }}"

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
    })


    $('body').on('click', '#delete-myevent', function(e) {
        e.preventDefault();
        Swal.fire({
            text: "Hapus data registrasi event kamu?",
            showCancelButton: true,
            confirmButtonText: "<i class='fas fa-trash-alt'></i> Delete",
            confirmButtonColor: "#d33",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                var id = $(this).data("id");
                $.ajax({
                    url: '/dashboard/delete-myevent/',
                    data: {
                        id: id,
                    },
                    type: 'POST',
                    success: function(response) {
                        Swal.fire('', response.success, 'success').then(
                            function() {
                                location.reload();
                            })
                    }
                });
            }
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
