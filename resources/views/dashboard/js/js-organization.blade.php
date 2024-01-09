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
                    $('#myfollowing-table').DataTable().ajax.reload();

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
                    //Swal.fire('', response.success, 'success');
                    alertify.success('<i class="fas fa-check"></i> ' + response.success);
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
                        //Swal.fire('', response.success, 'success')
                        alertify.success('<i class="fas fa-check"></i> ' + response
                            .success);
                        $('#my-organization-table').DataTable().ajax.reload();
                        $('#myfollowing-table').DataTable().ajax.reload();
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

    //Handle follow organisasi

    $('#followOrganisasiModal').on('shown.bs.modal', function(e) {
        e.preventDefault();
        var dataOrganization = $('#get-data-org-table').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            "bPaginate": false,
            "ordering": false,
            processing: true,
            serverside: true,
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/dashboard/get-organization',
            },

            columns: [{
                data: 'org',
                name: 'org'
            }, {
                data: 'org_follow',
                name: 'org_follow',
                class: 'width-25',
            }]
        });

        $('#follow_org_search').keyup(function() {
            dataOrganization.search($(this).val()).draw();

            if ($(this).val() == '' || $(this).val() == null) {
                $('#org-follow-container').attr('hidden', true);
            } else {
                $('#org-follow-container').attr('hidden', false);
            }
        });
    })

    $('#followOrganisasiModal').on('hidden.bs.modal', function(e) {
        $('#org-follow-container').attr('hidden', true);
        $('#follow_org_search').val('');
    });

    $('body').on('click', '.follow-organization', function(e) {
        e.preventDefault();
        var org_id = $(this).data("org_id");

        $.ajax({
            url: '/dashboard/follow-organization',
            type: 'POST',
            data: {
                org_id: org_id,
            },
            success: function(response) {
                if (response.success) {
                    alertify.success('<i class="fas fa-check"></i> ' + response.success);
                    $('#followOrganisasiModal').modal('hide');
                    $('#myfollowing-table').DataTable().ajax.reload();
                } else {
                    Swal.fire('', response.error, 'error')
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //Swal.fire('', 'error!', 'error');
            }

        });

    })

    $(document).ready(function(e) {

        var dataFollowingOrganization = $('#myfollowing-table').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            "ordering": false,
            processing: true,
            serverside: true,
            "oLanguage": {
                "sEmptyTable": "Kamu belum gabung organisasi apapun!"
            },
            language: {
                'paginate': {
                    'previous': '<i class="fas fa-chevron-circle-left"></i>',
                    'next': '<i class="fas fa-chevron-circle-right"></i>'
                }
            },
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/dashboard/get-foll-organization',
            },

            columns: [{
                data: 'org_nama',
                name: 'org_nama'
            }, {
                data: 'org_unfollow',
                name: 'org_unfollow',
            }]
        });
    })

    $('body').on('click', '.unfollow-organization', function(e) {
        e.preventDefault();
        var org_id = $(this).data("org_id");

        Swal.fire({
            text: "Keluar Organisasi?",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "<i class='fas fa-trash-alt'></i> Keluar",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                console.log(org_id);

                $.ajax({
                    url: '/dashboard/unfollow-organization',
                    type: 'POST',
                    data: {
                        org_id: org_id,
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success('<i class="fas fa-check"></i> ' + response
                                .success);
                            $('#myfollowing-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire('', response.error, 'error')
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //Swal.fire('', 'error!', 'error');
                    }

                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });

    })

    $('body').on('click', '.org-info', function(e) {
        e.preventDefault();
        $('.my-org-info').attr('hidden', false)
        $('.data-my-org').attr('hidden', true)

        var org_id = $(this).data("id");
        var org_name = $(this).data("name");
        var org_type = $(this).data("type");
        var org_logo = $(this).data("logo");

        if (org_logo == null || org_logo == '') {
            org_logo = 'logo.png'
        }

        $('.org-info-type').text(org_type)
        $('.org-info-name').text(org_name)
        $("#org-info-logo").attr("src", "{{ asset('storage/organization-images/') }}/" + org_logo);

        var organizationMember = $('#organization-member-table').DataTable({
            "dom": 'rtip',
            "bInfo": false,
            //"bPaginate": false,
            "ordering": false,
            processing: true,
            serverside: true,
            language: {
                'paginate': {
                    'previous': '<i class="fas fa-chevron-circle-left"></i>',
                    'next': '<i class="fas fa-chevron-circle-right"></i>'
                }
            },
            destroy: true,
            ajax: {
                'type': 'GET',
                'url': '/dashboard/get-organization-member',
                data: {
                    org_id: org_id,
                },
            },

            columns: [{
                data: 'member_name',
                name: 'member_name'
            }, {
                data: 'member_action',
                name: 'member_action',
            }]
        });

        $('#member-search').keyup(function() {
            organizationMember.search($(this).val()).draw();
        });
    })

    $('body').on('click', '.back-my-org-info', function(e) {
        e.preventDefault();
        $('.my-org-info').attr('hidden', true)
        $('.data-my-org').attr('hidden', false)

        $('.org-info-type').text('type')
        $('.org-info-name').text('name')
        $("#org-info-logo").attr("src", "{{ asset('storage/organization-images/logo.png') }}");
    })
</script>
