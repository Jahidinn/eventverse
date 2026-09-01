<script>
    $(document).ready(function(e) {

        $('body').on('click', '.detail-peserta', function(e) {

            e.preventDefault();

            var event_id = $(this).data("event_id");

            $('.title-daftar-peserta').text(
                $(this).data("title")
            );

            $('.jumlah-peserta').text(
                $(this).data("participant")
            );

            $('.daftar-peserta').attr('hidden', false);

            $('.daftar-event').attr('hidden', true);

            $('.download-participant-data')
                .attr('data-id', event_id);


            /*
            |--------------------------------------------------------------------------
            | DATATABLE PESERTA
            |--------------------------------------------------------------------------
            */

            var dataPeserta = $('#data-peserta').DataTable({

                dom: 'rtip',

                bInfo: false,

                processing: true,

                // JANGAN serverSide true
                serverSide: false,

                destroy: true,

                ajax: {
                    type: 'GET',

                    url: '/dashboard/get-participant',

                    data: {
                        event_id: event_id,
                    },
                },

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                            data: 'ticket_name',
                            name: 'ticket_name',
                        },

                    {
                        data: 'transaction_id',
                        name: 'transaction_id'
                    },

                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },

                    {
                        data: 'transaction_status',
                        name: 'transaction_status'
                    },

                    {
                        data: 'transaction_action',
                        name: 'transaction_action'
                    }

                ]

            });


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            $('#search-participant')
                .off('keyup')
                .on('keyup', function() {

                    var value = $(this).val();

                    dataPeserta
                        .search(value)
                        .draw();

                    if (value != '') {

                        $('.result-label')
                            .text('Hasil Pencarian');

                    } else {

                        $('.result-label')
                            .text('Peserta');

                    }

                });


            /*
            |--------------------------------------------------------------------------
            | FILTER STATUS
            |--------------------------------------------------------------------------
            */

            $('#get-filter')
                .off('click')
                .on('click', function(e) {

                    e.preventDefault();

                    var status = $('#filter-value').val();

                    $('#filterModal').modal('hide');

                    // STATUS = index 5
                    dataPeserta
                        .column(6)
                        .search(status)
                        .draw();


                    if (status == '') {

                        $('.result-label')
                            .text('Total Peserta');

                    } else {

                        $('.result-label')
                            .text(
                                'Transaksi ' + status
                            );

                    }

                });


            /*
            |--------------------------------------------------------------------------
            | UPDATE JUMLAH PESERTA
            |--------------------------------------------------------------------------
            */

            dataPeserta.on("draw", function() {

                var updateTotal = dataPeserta
                    .rows({
                        search: 'applied'
                    })
                    .count();

                $('.jumlah-peserta')
                    .text(updateTotal);

            });

        });

    });

    // SELECT 2
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
        $('.select2-search__field').attr("placeholder", "Cari ... ");
    });

    $("#filter-value").select2({
        dropdownParent: $("#filterModal"),
        allowClear: true
    });


    //Fungsi kembali
    $('body').on('click', '.kembali', function(e) {
        e.preventDefault();
        $('.daftar-peserta').attr('hidden', true)
        $('.daftar-event').attr('hidden', false)
    })

    //Fungsi proses detail transaksi
    // ==========================================================================
// DETAIL PESERTA
// ==========================================================================

$('body').on('click', '.detail-transaksi', function (e) {

    e.preventDefault();


    // =========================================================================
    // AMBIL DATA DARI BUTTON
    // =========================================================================

    let rawDetail = $(this).attr('data-detail');

    if (!rawDetail) {

        console.error(
            'Data detail peserta tidak ditemukan.'
        );

        return;
    }


    let detail;

    try {

        detail = JSON.parse(rawDetail);

    } catch (error) {

        console.error(
            'Gagal membaca data detail peserta:',
            error
        );

        return;
    }


    let participant = detail.participant || {};
    let transaction = detail.transaction || {};
    let ticket = detail.ticket || {};
    let event = detail.event || {};


    // =========================================================================
    // CONTAINER CUSTOM FORM
    // =========================================================================

    let container = $('#data-custom-form');

    container.empty();


    // =========================================================================
    // EVENT
    // =========================================================================

    $('.p-event').text(
        event.title || '-'
    );


    // =========================================================================
    // DATA PESERTA
    // =========================================================================

    $('.p-name').text(
        participant.name || '-'
    );

    $('.p-email').text(
        participant.email || '-'
    );

    $('.p-phone').text(
        participant.phone || '-'
    );


    // =========================================================================
    // TICKET
    // =========================================================================

    $('.p-ticket').text(
        ticket.ticket_name || '-'
    );


    // =========================================================================
    // TRANSACTION
    // =========================================================================

    $('.p-id').text(
        transaction.transaction_id ||
        transaction.transaction_code ||
        '-'
    );


    /*
     * Harga
     *
     * transaction.price dari Blade sudah berupa:
     * - GRATIS
     * - atau harga setelah biaya admin
     */

    if (
        transaction.price === 'GRATIS' ||
        transaction.price === '' ||
        transaction.price === null ||
        typeof transaction.price === 'undefined'
    ) {

        $('.p-biaya').text('GRATIS');

    } else {

        $('.p-biaya').text(
            numberWithCommas(transaction.price)
        );

    }


    $('.p-status').text(
        transaction.status || '-'
    );

    $('.p-pembayaran').text(
        transaction.payment_type || '-'
    );


    // =========================================================================
    // CUSTOM FORM PESERTA
    // =========================================================================

    let forms = participant.forms || [];


    if (forms.length === 0) {

        container.append(
            $('<div>')
                .addClass('text-muted')
                .text('Tidak ada data tambahan.')
        );

    } else {


        $.each(forms, function (index, value) {


            let fieldType = (
                value.field_type || ''
            ).toLowerCase();


            let label =
                value.field_label || '-';


            let formValue =
                value.form_value || '';


            let url =
                value.url || '';


            // =================================================================
            // ROW
            // =================================================================

            let row = $(
                '<div class="row mt-3"></div>'
            );


            // =================================================================
            // LABEL
            // =================================================================

            let labelColumn = $(
                '<div class="col-4"></div>'
            );


            labelColumn.text(label);


            labelColumn.append(
                $('<span>')
                    .addClass('float-right')
                    .text(':')
            );


            // =================================================================
            // VALUE
            // =================================================================

            let valueColumn = $(
                '<div class="col-8 pl-0"></div>'
            );


            // =================================================================
            // IMAGE
            // =================================================================

            if (
                fieldType === 'image' &&
                url
            ) {


                let image = $('<img>');


                image
                    .attr('src', url)
                    .attr('alt', label)
                    .attr('loading', 'lazy')
                    .css({

                        'max-width': '250px',

                        'max-height': '200px',

                        'width': 'auto',

                        'height': 'auto',

                        'object-fit': 'contain',

                        'display': 'block',

                        'border-radius': '8px',

                        'border':
                            '1px solid #dee2e6',

                        'padding': '4px'

                    });


                valueColumn.append(image);


                // -------------------------------------------------------------
                // LINK GAMBAR
                // -------------------------------------------------------------

                let imageLink = $('<a>');


                imageLink
                    .attr('href', url)
                    .attr('target', '_blank')
                    .attr(
                        'rel',
                        'noopener noreferrer'
                    )
                    .addClass(
                        'small text-info d-inline-block mt-2'
                    )
                    .text('Lihat gambar');


                valueColumn.append(
                    imageLink
                );

            }


            // =================================================================
            // FILE
            // =================================================================

            else if (
                fieldType === 'file' &&
                url
            ) {


                let fileButton = $('<a>');


                fileButton
                    .attr('href', url)
                    .attr('target', '_blank')
                    .attr(
                        'rel',
                        'noopener noreferrer'
                    )
                    .addClass(
                        'btn btn-sm btn-outline-info'
                    )
                    .html(
                        '<i class="ti ti-file"></i> ' +
                        'Lihat file'
                    );


                valueColumn.append(
                    fileButton
                );

            }


            // =================================================================
            // TEXT / SELECT / TEXTAREA / NUMBER / DLL
            // =================================================================

            else {


                let textValue = $('<b>');


                textValue
                    .addClass('text-info')
                    .text(
                        formValue || '-'
                    );


                valueColumn.append(
                    textValue
                );

            }


            // =================================================================
            // APPEND
            // =================================================================

            row.append(
                labelColumn
            );

            row.append(
                valueColumn
            );


            container.append(
                row
            );

        });

    }


    // =========================================================================
    // SHOW MODAL
    // =========================================================================

    $('#detailTransaksiModal').modal('show');

});

    //Format number
    function numberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    //Download data peserta
    $('body').on('click', '.download-participant-data', function(e) {
        //e.preventDefault();
        var id = $(this).data("id");
        $('.download-participant-data').html('<i class="fas fa-spinner fa-spin"></i> Downloading')
        $('.download-participant-data').attr('disabled', true)
        window.location.replace('/dashboard/participant-download-excel/' + id);

        setTimeout(function() {
            $('.download-participant-data').html('<i class="fas fa-file-excel"></i> Download data');
            $('.download-participant-data').attr('disabled', false);
            alertify.success('<i class="fas fa-check"></i> ' + 'Downloaded successfully');
        }, 1000);

    })
</script>
