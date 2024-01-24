<script>
    //Menampilkan saldo pada modal
    $('body').on('click', '#detailReportButton', function(e) {
        e.preventDefault();
        var id = $(this).data('id')

        $.ajax({
            url: '/dashboard/get-transaction-report',
            type: 'GET',
            data: {
                event_id: id
            },
            success: function(response) {
                if (response.data) {
                    $('#total-peserta').text(response.data.peserta)
                    $('#kategori-tiket').text(response.data.tiket)
                    $('#pemasukan').text(Number(response.data.danaTotal).toLocaleString('id-ID'))
                    $('#admin-fee').text(Number(response.data.fee).toLocaleString('id-ID'))
                    $('#penarikan').text(Number(response.data.danaDitarik).toLocaleString('id-ID'))
                    $('#saldo_akhir').text(Number(response.data.danaBersih).toLocaleString('id-ID'))

                    $('#detailReportTransaksi').modal('show');

                } else {
                    Swal.fire('', 'Gagal!', 'error')

                }
            }
        });


    })

    $('#detailReportTransaksi').on('hidden.bs.modal', function() {
        $('#total-peserta').text(0)
        $('#kategori-tiket').text(0)
        $('#pemasukan').text(0)
        $('#admin-fee').text(0)
        $('#penarikan').text(0)
        $('#saldo_akhir').text(0)
    })

    $('#withdrawModal').on('hidden.bs.modal', function() {
        $('#jumlah-penarikan-fixed').val(0);
        $('#jumlah-penarikan').val('');
        $('#wd-pemasukan').text(0)
        $('#wd-limit').text('0')
        $('#wd-history').text('0')
        $('#limit-withdraw').val(0)
    })

    $('body').on('click', '.withdraw-button', function(e) {
        e.preventDefault();
        var id = $(this).data('id')

        $.ajax({
            url: '/dashboard/get-transaction-report',
            type: 'GET',
            data: {
                event_id: id
            },
            success: function(response) {
                if (response.data) {
                    $('#wd-pemasukan').text(Number(response.data.danaTotal).toLocaleString('id-ID'))
                    $('#wd-limit').text(Number(response.data.danaBersih).toLocaleString('id-ID'))
                    $('#wd-history').text(Number(response.data.danaDitarik).toLocaleString('id-ID'))
                    $('#wd-admin').text(Number(response.data.fee).toLocaleString('id-ID'))
                    $('#limit-withdraw').val(response.data.danaBersih)

                    $('#withdrawModal').modal('show');

                } else {
                    Swal.fire('', 'Gagal!', 'error')
                }
            }
        });

        $('#wd-rekening').text("{{ auth()->user()->bank . ' ' . auth()->user()->no_rekening }}")
        $('#wd-event-id').val(id)

        $('.limit-notif').attr('hidden', true);
        $('#submit-withdraw').attr('disabled', true);


        $('#jumlah-penarikan').on('input', function() {
            var limitWd = $('#limit-withdraw').val().replace(/\D/g, '');
            var inputValue = $(this).val().replace(/\D/g, '');
            var formattedValue = Number(inputValue).toLocaleString('id-ID');

            $(this).val(formattedValue);
            $('#jumlah-penarikan-fixed').val(inputValue);

            if (parseInt(inputValue, 10) < limitWd) {
                if (parseInt(inputValue, 10) < 10000) {
                    $('#submit-withdraw').attr('disabled', true)
                } else {
                    $('.limit-notif').attr('hidden', true);
                    $('#submit-withdraw').attr('disabled', false)
                }

            } else {
                $('.limit-notif-value').text(Number(limitWd).toLocaleString('id-ID'));
                $('#jumlah-penarikan-fixed').val(limitWd);
                $('#submit-withdraw').attr('disabled', true)

                if (inputValue == '') {
                    $(this).val(0);
                } else {
                    $('.limit-notif').attr('hidden', false);
                    $(this).val(Number(limitWd).toLocaleString('id-ID'));

                }
            }
        });
    })

    // $('body').on('click', '#submit-withdraw', function(e) {
    //     e.preventDefault();
    //     $('#withdraw-form').submit();
    // })

    $(document).on('submit', '#withdraw-form', function(e) {
        e.preventDefault();
        var formData = new FormData(this)
        $('#submit-withdraw').html('Loading ...')
        $('#submit-withdraw').attr('disabled', true)

        $.ajax({
            url: '/dashboard/withdraw-process',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.success) {
                    Swal.fire('', response.success, 'success')
                    $('#submit-withdraw').html('<i class="fas fa-wallet"></i> Tarik dana')
                    $('#submit-withdraw').attr('disabled', false)
                    $('#withdrawModal').modal('hide');
                    $('#view-total-dana-button' + response.event_id).html(response.saldo);
                    console.log(response.saldo);
                } else {
                    Swal.fire('', response.error, 'error')
                    $('#submit-withdraw').html('<i class="fas fa-wallet"></i> Tarik dana')
                    $('#submit-withdraw').attr('disabled', false)
                }
            }
        });
    });

    $('body').on('click', '.history-withdraw', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        var wdHistory = $('#withdraw-history').DataTable({
            "dom": 'rtip',
            //"bInfo": false,
            "bPaginate": false,
            "ordering": false,
            processing: true,
            serverside: true,
            "language": {
                "emptyTable": "Tidak ada history penarikan",
            },
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/dashboard/withdraw-history',
                'data': {
                    id: id,
                },
            },
            columns: [{
                data: 'wd',
                name: 'wd'
            }, {
                data: 'tanggal',
                name: 'tanggal'
            }, {
                data: 'wd-status',
                name: 'wd-status'
            }]
        });

        $('#wd-history-search').keyup(function() {
            wdHistory.search($(this).val()).draw();
        });

        $('#withdrawHistoryModal').modal('show');
    })
</script>
