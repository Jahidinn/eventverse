<script>
    $('body').on('click', '.kelola-org-from-add', function(e) {
        e.preventDefault();

        $('#addOrganisasiModal').modal('hide');
        setTimeout(function() {
            $('#kelolaOragisasiModal').modal('show');
        }, 500);

    })

    $('#kelolaOragisasiModal').on('shown.bs.modal', function(e) {
        var dataMyOrganization = $('#my-organization-table').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            "bPaginate": false,
            "ordering": false,
            processing: true,
            serverside: true,
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/dashboard/get-myorganization',
            },

            columns: [{
                data: 'org',
                name: 'org'
            }, {
                data: 'org_action',
                name: 'org_action'
            }]
        });

        $('#org_search').keyup(function() {
            dataMyOrganization.search($(this).val()).draw();
        });
    })

    $('body').on('click', '.buat-organisasi', function(e) {
        e.preventDefault();
        $('#addOrgModal').modal('show');
    })

    $('#addOrgModal').on('hidden.bs.modal', function(e) {
        $("#create-organization").trigger("reset");
    });

    //handle logo live preview
    const previewLogo = (logo) => {
        const files = logo.target.files;
        const filesLength = files.length;
        if (filesLength > 0) {
            const imageSrc = URL.createObjectURL(files[0]);
            const imagePreviewElement = document.querySelector("#org_logo");
            imagePreviewElement.src = imageSrc;
            console.log(imageSrc);
            imagePreviewElement.style.display = "block";
        }
    };

    //cek validasi file
    var filLogo = document.getElementById("org_logo_input")
    filLogo.addEventListener('change', function() {

        previewLogo({
            target: {
                files: filLogo.files
            }
        });

        var fileLimit = 600; // could be whatever you want
        var files = filLogo.files; //this is an array
        var fileSize = files[0].size; //
        var fileSizeInKB = (fileSize / 1024); // this would be in kilobytes defaults to bytes

        if (fileSizeInKB < fileLimit) {
            console.log('Berhasil');

        } else {
            Swal.fire(
                'Error',
                'Ukuran logo lebih dari 500KB! upload ulang ya!',
                'error'
            );
            document.querySelector("#org_logo").src =
                "{{ asset('storage/organization-images/logo.png') }}";

            // do not pass go, do not add to db. Pass error to user  
        }
    });


    //handle submit form create organisasi
    $(document).on('submit', '#create-organization', function(e) {
        e.preventDefault();

        data = new FormData(this);

        $.ajax({
            url: '/dashboard/add-organization',
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('', response.success, 'success');
                    $('#addOrgModal').modal('hide');
                    $('#my-organization-table').DataTable().ajax.reload();

                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });

    });

    $('body').on('click', '.edit-my-organization', function(e) {
        e.preventDefault();
        var org_id = $(this).data("org_id");

        $.ajax({
            url: '/dashboard/detail-organization',
            type: 'get',
            data: {
                org_id: org_id,
            },
            success: function(response) {
                if (response.data) {
                    var data = response.data
                    $('#org_id_edit').val(data.id)
                    $('#org_org_id_edit').val(data.org_id)
                    $('#org_name_edit').val(data.org_name)
                    $('#org_institution_edit').val(data.org_institution)
                    $('#org_address_edit').val(data.org_address)
                    $('#org_contact_edit').val(data.org_contact)
                    $('#org_type_edit').val(data.org_type)
                    $('#org_image_prev').val(data.org_image)
                    document.querySelector("#org_logo_edit").src =
                        "{{ asset('storage/organization-images/') }}/" + data.org_image;

                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });
        $('#editOrgModal').modal('show');
    })

    //handle logo EDIT live preview 
    const previewLogoEdit = (logo) => {
        const files = logo.target.files;
        const filesLength = files.length;
        if (filesLength > 0) {
            const imageSrc = URL.createObjectURL(files[0]);
            const imagePreviewElement = document.querySelector("#org_logo_edit");
            imagePreviewElement.src = imageSrc;
            console.log(imageSrc);
            imagePreviewElement.style.display = "block";
        }
    };

    //cek validasi file
    var filLogoEdit = document.getElementById("org_logo_input_edit")
    filLogoEdit.addEventListener('change', function() {

        var fileLimit = 600; // could be whatever you want
        var files = filLogoEdit.files; //this is an array
        var fileSize = files[0].size; //
        var fileSizeInKB = (fileSize / 1024); // this would be in kilobytes defaults to bytes

        if (fileSizeInKB < fileLimit) {
            previewLogoEdit({
                target: {
                    files: filLogoEdit.files
                }
            });

        } else {
            Swal.fire(
                'Error',
                'Ukuran logo lebih dari 500KB! upload ulang ya!',
                'error'
            );

            // do not pass go, do not add to db. Pass error to user  
        }
    });


    $(document).on('submit', '#edit-organization', function(e) {
        e.preventDefault();

        data = new FormData(this);

        $.ajax({
            url: '/dashboard/edit-organization',
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('', response.success, 'success');
                    $('#editOrgModal').modal('hide');
                    $('#my-organization-table').DataTable().ajax.reload();

                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });
    });

    $('#editOrgModal').on('hidden.bs.modal', function(e) {
        $("#edit-organization").trigger("reset");
    });

    //Delete Formulir
    $('body').on('click', '.delete-my-organization', function(e) {
        e.preventDefault();
        var org_id = $(this).data("org_id");

        Swal.fire({
            text: "Hapus Organisasi?",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "<i class='fas fa-trash-alt'></i> Delete",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/dashboard/delete-organization',
                    type: 'POST',
                    data: {
                        org_id: org_id,
                    },
                    success: function(response) {
                        Swal.fire('', response.success, 'success')
                        $('#my-organization-table').DataTable().ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('', 'error!', 'error');
                    }

                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });
</script>
