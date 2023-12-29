<script>
    $(document).ready(function(e) {
        $('body').on('click', '.detail-peserta', function(e) {
            e.preventDefault();
            var id = $(this).data("id");

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
                        id: id,
                    },
                },

                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'transaction_id',
                    name: 'transaction_id'
                }, {
                    data: 'transaction_status',
                    name: 'transaction_status'
                }, {
                    data: 'transaction_action',
                    name: 'transaction_action'
                }]
            });

            $('#search-participant').keyup(function() {
                dataPeserta.search($(this).val()).draw();

                if ($(this).val() != '') {
                    var totalPesertaLabel = $(this).val();
                    $('.result-label').text('Hasil Pencarian');
                } else {
                    $('.result-label').text('Peserta');
                }
            });

            $('#get-filter').on('click', function(e) {
                var status = $('#filter-value').val();
                $('#filterModal').modal('hide')
                dataPeserta.column(4).search(status).draw();

                if (status == '') {
                    var totalPesertaLabel = $(this).val();
                    $('.result-label').text('Total Peserta');
                } else {
                    $('.result-label').text('Transaksi ' + status);
                }

            })

            dataPeserta.on("draw", function() {
                updateTotal = dataPeserta.rows({
                    search: 'applied'
                }).count();
                $('.jumlah-peserta').text(updateTotal);
            });
        })

    })

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
        $('.select2-search__field').attr("placeholder", "Cari ... ");
    });

    $("#filter-value").select2({
        dropdownParent: $("#filterModal"),
        allowClear: true
    });


    $('body').on('click', '.kembali', function(e) {
        e.preventDefault();
        $('.daftar-peserta').attr('hidden', true)
        $('.daftar-event').attr('hidden', false)
    })
    $('body').on('click', '.detail-transaksi', function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var event_id = $(this).data("event_id");
        var container = $('#data-custom-form')
        container.empty();

        $('.p-name').text($(this).data("nama"))
        $('.p-email').text($(this).data("email"))
        $('.p-phone').text($(this).data("phone"))
        $('.p-ticket').text($(this).data("ticket"))
        $('.p-biaya').text($(this).data("biaya"))
        $('.p-status').text($(this).data("status"))
        $('.p-id').text($(this).data("id_transaksi"))
        $('.p-pembayaran').text($(this).data("pembayaran"))

        $.ajax({
            url: '/dashboard/get-customform',
            data: {
                id: id,
                event_id: event_id,
            },
            type: 'GET',
            success: function(response) {
                //Menyisipkan data custom form dengan looping
                $.each(response.data, function(index, value) {
                    var newData = $('<div class="row mt-1">' +
                        '<div class="col-4">' +
                        value.nama_form +
                        '<span class="float-right">:</span>' +
                        '</div>' +
                        '<div class="col-8 pl-0 text-info">' +
                        '<b>' + value.form_value + '</b>' +
                        '</div>' +
                        '</div>'
                    );

                    // Menyisipkan elemen baru ke dalam div
                    container.append(newData);
                });
            }
        });

        $('#detailTransaksiModal').modal('show');
    })
</script>
