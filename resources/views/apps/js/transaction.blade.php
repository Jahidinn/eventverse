<script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#checkout-event').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#checkout-button').html('Processing ...');
            $('#checkout-button').attr('disabled', true);

            $.ajax({
                type: 'POST',
                url: '/event/checkout-proccess',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                    } else {

                        $('#checkoutModal').modal('show');
                        //Swal.fire(response.token, '', 'success');
                        $('#checkout-button').html('Bayar sekarang!');
                        $('#checkout-button').attr('disabled', false);
                        //Menampilkan data konfirmasi checkout
                        $('#transaction').val(response.token);
                        $('#id_event').val(response.transaction.id);
                        $('#email_transaction').val(response.transaction.email);
                        $('#confirm_nama').html(response.transaction.name);
                        $('#confirm_email').html(response.transaction.email);
                        $('#confirm_nomerhp').html(response.transaction.phone);
                        $('#confirm_nomerhp').html(response.transaction.phone);
                        $('#confirm_event_title').html(response.event.title);
                        $('#confirm_penyelenggara').html(response.event.penyelenggara.name);
                        $('#confirm_ticket').html(response.ticket.ticket_name);
                        $('#confirm_jumlah_tiket').html(response.transaction.quantity);
                        let price = response.transaction.total_price - 500;
                        $('#confirm_price').html(price.toString().replace(
                            /\B(?=(\d{3})+(?!\d))/g, "."));
                        $('#confirm_total_price').html(response.transaction.total_price
                            .toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    }
                }
            })
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
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    $('#pay-button').html("<i class='fas fa-check'></i> Bayar sekarang");
                    $('#pay-button').attr('disabled', false);
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

        $("#checkoutModal").on('hide.bs.modal', function() {
            $('#pay-button').html("<i class='fas fa-check'></i> Bayar sekarang");
            $('#pay-button').attr('disabled', false);
        });

        $('body').on('click', '.transaction-cancel-button', function(e) {
            e.preventDefault();
            let idTransaction = $('#id_event').val()
            let emailTransaction = $('#email_transaction').val()
            console.log(idTransaction, emailTransaction);

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
                } else {
                    //Lanjut
                }
            })
        })
    })
</script>
