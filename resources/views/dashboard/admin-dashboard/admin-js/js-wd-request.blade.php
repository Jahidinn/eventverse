<script>
    $(document).ready(function(e) {

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            defaultDate: new Date(),
        });

        var today = new Date();
        $(".datepicker").datepicker("setDate", today);

        //Datatable request penarikan
        var dataRequestPenarikan = $('#table-wd-request').DataTable({
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

        //Pencarian data
        $('#search-request').keyup(function() {
            dataRequestPenarikan.search($(this).val()).draw();
        });

        //Filter berdasarkan option status
        $('body').on('change', '#status-filter', function(e) {
            dataRequestPenarikan.columns(2).search($(this).val()).draw();
        });

    })

    // Function menampilkan data history
    function withdrawHistory(status, startDate, endDate) {
        //Datatable request penarikan
        var dataHistoryPenarikan = $('#table-wd-history').DataTable({
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
                'url': '/administrator/wd-history/get-data',
                'data': {
                    status: status,
                    start_date: startDate,
                    end_date: endDate,
                },
            },

            columns: [{
                data: 'admin_wd_user',
                name: 'admin_wd_user'
            }, {
                data: 'admin_wd_amount',
                name: 'admin_wd_amount'
            }, {
                data: 'admin_wd_date',
                name: 'admin_wd_date'
            }, {
                data: 'admin_wd_status',
                name: 'admin_wd_status'
            }]
        });

        //Pencarian data
        $('#search-history').keyup(function() {
            dataHistoryPenarikan.search($(this).val()).draw();
        });
    }

    // ketika tombol tampilkan atau filter di klik
    $('body').on('click', '#wd-history-filter', function(e) {
        e.preventDefault();

        // MEngambil data form
        var status = $('#wd-history-status-filter').val();
        var startDate = $('#wd-history-start').val();
        var endDate = $('#wd-history-end').val();

        // Panggil function menampilkan data history
        withdrawHistory(status, startDate, endDate);
    })


    //Ketika tombol history di klik
    $('body').on('click', '#btn-wd-history', function(e) {
        e.preventDefault();

        //Hiden WD request dan tampilkan WD history
        $('#wd-request-container').attr('hidden', true);
        $('#wd-history-container').attr('hidden', false);

        $('#wd-title').html('Withdraw History');

        // Mengambil data form
        var status = $('#wd-history-status-filter').val();
        var startDate = $('#wd-history-start').val();
        var endDate = $('#wd-history-end').val();

        // Panggil function menampilkan data history
        withdrawHistory(status, startDate, endDate);

    })

    //Ketika tombol withdraw di klik
    $('body').on('click', '#btn-wd-request', function(e) {
        e.preventDefault();

        //Hiden WD history dan tampilkan WD request
        $('#wd-request-container').attr('hidden', false);
        $('#wd-history-container').attr('hidden', true);

        $('#table-wd-request').DataTable().ajax.reload();

        $('#wd-title').html('Withdraw Request');
    })

    // Proses menolak request penarikan
    $('body').on('click', '.admin-cancel-wd', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: '<small><b>Yakin TOLAK proses penarikan?</b></small>',
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545',
            html: '<input type="text" id="alasanTolak" class="swal2-input w-100 m-1" style="display: block;" placeholder="Catatan ...">',
            preConfirm: () => {
                // Mendapatkan nilai alasan tolak dari input formulir
                const alasanTolak = document.getElementById('alasanTolak').value;
                // Tindakan yang akan diambil jika pengguna mengonfirmasi penolakan
                if (!alasanTolak) {
                    Swal.showValidationMessage('Catatan harus diisi');
                }
                return {
                    alasanTolak: alasanTolak
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const alasanTolak = result.value.alasanTolak;

                // Tindakan yang akan diambil jika mengonfirmasi tolak
                $.ajax({
                    url: '/administrator/wd-request/tolak',
                    type: 'POST',
                    data: {
                        id: id,
                        catatan: alasanTolak,
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success('<i class="fas fa-check"></i> ' + response
                                .success);
                            $('#table-wd-request').DataTable().ajax.reload(null, false);

                        } else {
                            Swal.fire('', response.error, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
                        Swal.fire('Error!',
                            'Terjadi kesalahan saat memproses permintaan: ' +
                            textStatus, 'error');
                    }
                });
            }
        });
    })

    // Proses Terima request penarikan
    $('body').on('click', '.admin-proses-wd', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            html: '<b>TERIMA request proses penarikan?</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Terima!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {

                // Tindakan yang akan diambil jika mengonfirmasi tolak
                $.ajax({
                    url: '/administrator/wd-request/accept',
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success('<i class="fas fa-check"></i> ' + response
                                .success);
                            $('#table-wd-request').DataTable().ajax.reload(null, false);

                        } else {
                            Swal.fire('', response.error, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
                        Swal.fire('Error!',
                            'Terjadi kesalahan saat memproses permintaan: ' +
                            textStatus, 'error');
                    }
                });
            }
        });

    })
</script>
