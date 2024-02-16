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
