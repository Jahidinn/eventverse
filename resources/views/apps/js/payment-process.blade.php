<script>
    $(document).ready(function(e) {

        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            $('#pay-button').html('<i class="fas fa-spinner fa-spin"></i> Processing ...');
            $('#pay-button').attr('disabled', true);

            let idTransaction = $('#id_event').val()
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay($('#transaction').val(), {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    const hashids = new Hashids('eventhub-secret', 15);
                    const hashIdTransaction = hashids.encode(idTransaction);
                    window.location.href = '/event/invoice/' + hashIdTransaction;
                    // console.log(result);
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
                            const hashids = new Hashids('eventhub-secret', 15);
                            const hashIdTransaction = hashids.encode(idTransaction);
                            window.location.href = '/event/invoice/' +
                                hashIdTransaction;
                        }
                    });
                    // console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    Swal.fire({
                        icon: "error",
                        text: "payment failed!!",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    //console.log(result);
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
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            //location.reload();
                        }
                    });
                }
            })
        });
    })
</script>
