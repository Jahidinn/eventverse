<script>
    $(document).ready(function(e) {
        $('body').on('click', '.detail-peserta', function(e) {
            e.preventDefault();
            var event_id = $(this).data("event_id");

            $('.title-daftar-peserta').text($(this).data("title"))
            $('.jumlah-peserta').text($(this).data("participant"))
            $('.daftar-peserta').attr('hidden', false)
            $('.daftar-event').attr('hidden', true)

            var dataPeserta = $('#data-peserta').DataTable({
                "dom": 'rtip',
                "bInfo": false,
                processing: true,
                serverside: true,
                destroy: true,
                ajax: {
                    'type': 'GET',
                    'url': '/dashboard/get-participant',
                    'data': {
                        event_id: event_id,
                        status: 'Paid'
                    },
                },

                columns: [{
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'ticket_code',
                    name: 'ticket_code'
                }, {
                    data: 'participant_checkin_action',
                    name: 'participant_checkin_action'
                }]
            });

            $('#search-transaction').keyup(function() {
                dataPeserta.column(2).search($(this).val()).draw();
            });

        })

    })


    $('body').on('click', '.kembali', function(e) {
        e.preventDefault();
        $('.daftar-peserta').attr('hidden', true)
        $('.daftar-event').attr('hidden', false)
    })

    //Button submit sementara di nonaktifkan
    // $('body').on('click', '#checkin-event-form', function(e) {
    //     e.preventDefault();
    //     console.log('hahaha');
    // })

    $(document).on('submit', '#checkin-form', function(e) {
        e.preventDefault();
        var id = $('#search-transaction').val()
        prosesCheckin(id)
    });

    $('body').on('click', '.checkin-event', function(e) {
        e.preventDefault();
        var transaction_id = $(this).data("id");
        prosesCheckin(transaction_id)
    })

    function prosesCheckin(id) {
        $.ajax({
            url: '/dashboard/participant-checkin',
            type: 'POST',
            data: {
                id: id,
            },
            success: function(response) {
                if (response.success) {
                    alertify.success('<i class="fas fa-check"></i> ' + response
                        .success);
                    $('#data-peserta').DataTable().ajax.reload(null, false);

                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });
    }
</script>
