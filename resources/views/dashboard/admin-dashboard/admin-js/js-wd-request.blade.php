<script>
    $(document).ready(function(e) {

        var dataPeserta = $('#table-wd-request').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            language: {
                'paginate': {
                    'previous': '<i class="fas fa-angle-double-left"></i>',
                    'next': '<i class="fas fa-angle-double-right"></i>'
                }
            },
            processing: true,
            serverside: true,
            ordering: false,
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/administrator/wd-request/get-data',
                'data': {
                    status: status,
                },
            },

            columns: [{
                data: 'admin_wd_user',
                name: 'admin_wd_user'
            }, {
                data: 'admin_wd_amount',
                name: 'admin_wd_amount'
            }, {
                data: 'admin_wd_status',
                name: 'admin_wd_status'
            }, {
                data: 'admin_wd_action',
                name: 'admin_wd_action'
            }]
        });

        $('#search-transaction').keyup(function() {
            dataPeserta.column(2).search($(this).val()).draw();
        });
    })
</script>
