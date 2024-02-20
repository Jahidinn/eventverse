<script>
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
</script>
