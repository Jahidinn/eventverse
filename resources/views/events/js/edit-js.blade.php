<script>
    //Javascript Menangani Edit event

    //preview image
    const editFileUpload = (event2) => {

        const files = event2.target.files;
        const filesLength = files.length;
        if (filesLength > 0) {
            const imageSrc = URL.createObjectURL(files[0]);
            const imagePreviewElement = document.querySelector("#tb-image-edit");
            imagePreviewElement.src = imageSrc;
            imagePreviewElement.style.display = "block";
        }
    };

    //cek validasi file
    var inputElement2 = document.getElementById("tb-file-upload-edit")
    inputElement2.addEventListener('change', function() {
        var fileLimit = 600; // could be whatever you want
        var files = inputElement2.files; //this is an array
        var fileSize = files[0].size; //
        var fileSizeInKB = (fileSize / 1024); // this would be in kilobytes defaults to bytes

        if (fileSizeInKB < fileLimit) {
            $('#image-warning').hide();

            form = new FormData();
            var featured_image = inputElement2.files[0];
            var idEvent = $('#id-event').val();

            form.append('bannerEventEdit', featured_image);
            form.append('idEvent', idEvent);

            //Ajax proses edit banner / poster
            $.ajax({
                type: 'POST',
                url: "{{ url('/event-edit-image') }}",
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
                        Swal.fire('Sukses!', response.success, 'success');
                    }
                }
            });

        } else {
            $('#image-warning').removeAttr('hidden');
            $('#image-warning').show();
            Swal.fire(
                'Error',
                'Ukuran file lebih dari 500KB! upload ulang ya!',
                'error'
            );
            document.querySelector("#tb-image-edit").src = '';
            // do not pass go, do not add to db. Pass error to user  
        }
    });
</script>
