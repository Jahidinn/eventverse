<script>
    //invoice protection
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var currentUrl = document.referrer
        var prevURL = '{{ env('APP_URL_INVOICE') }}';
        var prevURL2 = '{{ env('APP_URL_INVOICE2') }}';
        var prevURL3 = '{{ env('APP_URL_INVOICE3') }}';

        //Keamanan akses invoice
        if (currentUrl.indexOf(prevURL) !== -1 || currentUrl.indexOf(prevURL2) !== -1 || currentUrl.indexOf(
                prevURL3) !== -1) {
            $('#invoice_page').removeAttr('hidden');
            $('#invoice_page').attr('hidden', false);
        } else {
            window.location.href = '/';
        }
    });

    $('body').on('click', '#download-invoice', function(e) {
        e.preventDefault();
        var url = '{{ env('APP_URL_INVOICE') }}';

        var id_transaksi = $(this).data('id_transaksi');
        const hashids = new Hashids('eventhub-secret', 25);
        const hashIdTransaction = hashids.encode(id_transaksi);
        window.location.href = '/generate-pdf?id_transaksi=' + hashIdTransaction + '&url=' + url
    })

    $('body').on('click', '#download-ticket', function(e) {
        e.preventDefault();

        var id_transaksi = $(this).data('id_transaksi');
        const hashids = new Hashids('eventhub-secret', 25);
        const hashIdTransaction = hashids.encode(id_transaksi);
        window.location.href = '/event/ticket/' + hashIdTransaction
    })

    $('body').on('click', '#lanjutkan-transaksi', function(e) {
        e.preventDefault();

        var idTransaction = $(this).data('id_transaksi');

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
