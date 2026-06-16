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

        // $('#search-myevent').keyup(function() {
        //     myeventTable.search($(this).val()).draw();
        // });

        $('body').on('click', '.detail-myevent', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            const hashids = new Hashids('eventhub-secret', 15);
            const hashIdTransaction = hashids.encode(id);
            window.location = "/event/redirect-invoice/" + hashIdTransaction;
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
                                location.reload();
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
                    type: "POST",
                    url: "{{ url('/dashboard/delete-myevent') }}",
                    data: {
                        id: id,
                    },
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

    $('body').on('click', '.info-myevent', function(e) {
        e.preventDefault();
        var transaction_id = $(this).data('id');
        var event_id = $(this).data('event');
        $('#detail-trx-container').empty();
        $('.detail-trx-title').html('...')
        $('.detail-trx-status').html('...')

        $.ajax({
            url: '/dashboard/get-detail-transaction',
            data: {
                transaction: transaction_id,
                event: event_id,
            },
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Proses data yang diterima dari server
                const data = response.data;

                $('.detail-trx-title').html(response.event.title)
                $('.detail-trx-status').html(response.trx.status)

                data.forEach(function(item) {
                    const form = `
					<div class="form-group">
                        <label>${item.form_name}</label>
                        <input type="text" class="form-control" value="${item.form_value}" disabled/>
					</div>
                `;
                    $('#detail-trx-container').append(form);
                });

            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika request gagal
                $('#result').html('Error: ' + error);
            }
        });

        $('#detailModal').modal('show');
    })

    // EDIT form pendaftaran
    $('body').on('click', '.edit-myevent', function(e) {
        e.preventDefault();

        var transaction_id = $(this).data('id');
        var event_id = $(this).data('event');

        $('#edit-trx-container').empty();
        $('.edit-trx-title').html('...')
        $('.edit-trx-status').html('...')

        $.ajax({
            url: '/dashboard/get-detail-transaction',
            data: {
                transaction: transaction_id,
                event: event_id,
            },
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Proses data yang diterima dari server
                const data = response.data;

                $('.edit-trx-title').html(response.event.title)
                $('.edit-trx-status').html(response.trx.status)

                if (data.length === 0) {
                    const alert = `
                        <div class="alert alert-warning" role="alert">
                            Tidak ada data custom form!
                        </div>
                    `;
                    $('#edit-trx-container').html(alert);
                } else {
                    data.forEach(function(item) {
                        const form = `
                            <div class="form-group">
                                <label>${item.form_name}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-value-${item.form_id}" value="${item.form_value}" disabled/>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-info edit-trx-form btn-form-${item.form_id}" type="button" 
                                            data-formid="${item.form_id}" 
                                            data-form_name="${item.form_name}" 
                                            data-value_id="${item.form_value_id}" 
                                            data-trx_id="${transaction_id}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#edit-trx-container').append(form);
                    });
                }

            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika request gagal
                $('#result').html('Error: ' + error);
            }
        });

        $('#editFormModal').modal('show');
    })

    $('#editFormModal').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });

    $('body').on('click', '.edit-trx-form', function(e) {
        e.preventDefault();

        var form_id = $(this).data('formid');
        var value_id = $(this).attr('data-value_id');
        var trx_id = $(this).data('trx_id');
        var form_name = $(this).data('form_name');
        var form_value = $('.form-value-' + form_id).val();

        Swal.fire({
            title: `<small><b>Edit ${form_name}</b></small>`,
            html: `
                    <form id="swal-form">
                        <input type="hidden" id="trx_id" name="trx_id" class="form-control w-100" value="${trx_id}">
                        <input type="hidden" id="form_id" name="form_id" class="form-control w-100" value="${form_id}">
                        <input type="hidden" id="value_id" name="value_id" class="form-control w-100" value="${value_id}"><br/>
                        <input type="text" id="form_val" name="form_val" class="form-control w-100" value="${form_value}"><br/>
                    </form>
                `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check-circle"></i> simpan',
            confirmButtonColor: '#28a745',
            reverseButtons: true,
            preConfirm: () => {
                const value_id = Swal.getPopup().querySelector('#value_id').value;
                const form_id = Swal.getPopup().querySelector('#form_id').value;
                const trx_id = Swal.getPopup().querySelector('#trx_id').value;
                const value = Swal.getPopup().querySelector('#form_val').value;

                if (!value || !trx_id || !form_id) {
                    Swal.showValidationMessage(`Silahkan lengkapi form dulu ya!`);
                }
                return {
                    value_id: value_id,
                    form_id: form_id,
                    trx_id: trx_id,
                    value: value,
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = result.value;

                $.ajax({
                    url: '/dashboard/edit-form-transaction',
                    data: {
                        value_id: formData.value_id,
                        form_id: formData.form_id,
                        trx_id: formData.trx_id,
                        value: formData.value,
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        // Proses data yang diterima dari server
                        const status = response.success;
                        const data = response.data;

                        if (status) {
                            Swal.fire('', status, 'success')
                            $('.form-value-' + form_id).val(formData.value);
                            $('.btn-form-' + form_id).attr('data-value_id', data.id);
                        }

                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika request gagal
                        Swal.fire('', error, 'error')
                        $('#result').html('Error: ' + error);
                    }
                });
            }
        });

    })
</script>
