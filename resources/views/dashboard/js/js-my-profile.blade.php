<script>
    //preview image
    const profileFileUpload = (event2) => {

        const files = event2.target.files;
        const filesLength = files.length;
        if (filesLength > 0) {
            const imageSrc = URL.createObjectURL(files[0]);
            const imagePreviewElement = document.querySelector("#profile-image-edit");
            imagePreviewElement.src = imageSrc;
            imagePreviewElement.style.display = "block";
        }
    };

    //cek validasi file
    var inputElement2 = document.getElementById("profile-file-upload-edit")
    inputElement2.addEventListener('change', function() {
        var fileLimit = 600; // could be whatever you want
        var files = inputElement2.files; //this is an array
        var fileSize = files[0].size; //
        var fileSizeInKB = (fileSize / 1024); // this would be in kilobytes defaults to bytes

        var userId = $('#id-user').val();
        var picture_prev = $('#profile_picture').val();

        if (fileSizeInKB < fileLimit) {

            form = new FormData();
            var profile_image = inputElement2.files[0];

            form.append('imageProfileEdit', profile_image);
            form.append('userId', userId);

            //Ajax proses edit profile image
            console.log('haha');
            $.ajax({
                type: 'POST',
                url: '/dashboard/edit-profile-image',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                        document.querySelector("#tb-image-edit").src = '';
                    } else {
                        Swal.fire('', response.success, 'success');
                    }
                }
            });

        } else {

            Swal.fire(
                'Error',
                'Ukuran file lebih dari 500KB! upload ulang ya!',
                'error'
            );
            if (!picture_prev || picture_prev == '') {
                document.querySelector("#profile-image-edit").src =
                    "{{ asset('storage/profile-images/default-user.jpg') }}";
            } else {
                document.querySelector("#profile-image-edit").src =
                    "{{ asset('storage/profile-images') }}/" + picture_prev;

            }
            // do not pass go, do not add to db. Pass error to user  
        }
    });

    $('body').on('click', '.edit-my-profile', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/dashboard/get-data-profile',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editProfileModal').modal('show');
                    $('#p_username').val(response.success.username)
                    $('#p_name').val(response.success.name)
                    $('#p_email').val(response.success.email)
                    $('#p_no_tlp').val(response.success.no_tlp)
                    $('#p_no_rekening').val(response.success.no_rekening)
                    $('#p_bank').val(response.success.bank)
                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });
    })

    $(document).on('submit', '#edit-my-profile', function(e) {
        e.preventDefault();

        data = new FormData(this);

        $.ajax({
            url: '/dashboard/edit-profile-process',
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#editProfileModal').modal('hide');
                    Swal.fire({
                        icon: "success",
                        text: response.success,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });;
                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });

    });

    $('body').on('click', '.edit-my-password', function(e) {
        e.preventDefault();

        $('#editPasswordModal').modal('show');

    })

    $(document).on('submit', '#edit-password-form', function(e) {
        e.preventDefault();

        data = new FormData(this);

        $.ajax({
            url: '/dashboard/edit-password',
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#editPasswordModal').modal('hide');
                    Swal.fire('', response.success, 'success');
                } else {
                    Swal.fire('', response.error, 'error');
                }
            }
        });

    });

    $('#editPasswordModal').on('hidden.bs.modal', function(e) {
        $('#edit-password-form').trigger("reset");
    });

    // $(document).ready(function(e) {

    // })
</script>
