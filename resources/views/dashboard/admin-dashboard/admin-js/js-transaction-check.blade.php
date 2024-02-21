<script>
    $(document).ready(function(e) {

        //Datatable request penarikan
        var dataRequestPenarikan = $('#table-transaction-check').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            language: {
                'paginate': {
                    'previous': '<i class="fas fa-angle-double-left"></i>',
                    'next': '<i class="fas fa-angle-double-right"></i>'
                }
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada request penarikan!"
            },
            processing: true,
            serverside: true,
            ordering: false,
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/administrator/transaction-check/get-event',
            },

            columns: [{
                data: 'check_event',
                name: 'check_event'
            }, {
                data: 'check_amount',
                name: 'check_amount'
            }, {
                data: 'check_action',
                name: 'check_action'
            }]
        });

        //Pencarian data
        $('#check-search-event').keyup(function() {
            dataRequestPenarikan.search($(this).val()).draw();
        });
    })

    function tableTransaction(id) {
        var dataTransaction = $('#table-transaction').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            language: {
                'paginate': {
                    'previous': '<i class="fas fa-angle-double-left"></i>',
                    'next': '<i class="fas fa-angle-double-right"></i>'
                }
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada transaksi!"
            },
            processing: true,
            serverside: true,
            ordering: false,
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/administrator/transaction-check/get-transaction',
                data: {
                    id: id,
                }
            },

            columns: [{
                data: 'transaction_id',
                name: 'transaction_id'
            }, {
                data: 'email',
                name: 'email'
            }, {
                data: 'check_amount',
                name: 'check_amount'
            }, {
                data: 'check_action',
                name: 'check_action'
            }]
        });

        //Pencarian data
        $('#check-search-transaction').keyup(function() {
            dataTransaction.search($(this).val()).draw();
        });

        // Menangani event klik pada dataHistory
        dataTransaction.on('click', 'tr', function(e) {
            var rowData = dataTransaction.row(this).data();

            if (rowData) {
                //Memanggil function handleRowClick
                handleRowClick(dataTransaction, e);
            }
        });
    }

    $('body').on('click', '.btn-transaction-check', function(e) {
        const id = $(this).data('id');
        const event = $(this).data('event');

        $('#transaction-event-title').text(event);
        tableTransaction(id)

    })

    // Ketika tombol cek transaksi di klik menampilkan list transaksi
    $('body').on('click', '.btn-transaction-check', function() {
        $('#event-list-container').attr('hidden', true)
        $('#transaction-list-container').attr('hidden', false)

    })

    //Tombol kembali
    $('body').on('click', '#back-check-transaction', function() {
        $('#event-list-container').attr('hidden', false);
        $('#transaction-list-container').attr('hidden', true);
        //Clear data dengan mengirimkan data 0
        tableTransaction(0)
    })


    // Fungsi untuk menangani event klik pada dataRequestPenarikan dan dataHistory
    function handleRowClick(dataTable, e) {
        if ($(e.target).hasClass('btn-process-check')) {
            let data = dataTable.row(e.target.closest('tr')).data();

            //Tampilkan data
            //$('#wd-event').attr('href', '/' + data['event']['slug'])
            //$('#wd-amount').text('Rp ' + formatRibuan(data['amount']))

            $('#transactionDetailModal').modal('show');
        }
    }
</script>
