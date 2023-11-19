<script>
    //preview image
    const fileUpload = (event) => {

        const files = event.target.files;
        const filesLength = files.length;
        if (filesLength > 0) {
            const imageSrc = URL.createObjectURL(files[0]);
            const imagePreviewElement = document.querySelector("#tb-image");
            imagePreviewElement.src = imageSrc;
            imagePreviewElement.style.display = "block";
        }
    };

    //cek validasi file
    var inputElement = document.getElementById("tb-file-upload")
    inputElement.addEventListener('change', function() {
        var fileLimit = 600; // could be whatever you want 
        var files = inputElement.files; //this is an array
        var fileSize = files[0].size;
        var fileSizeInKB = (fileSize / 1024); // this would be in kilobytes defaults to bytes

        if (fileSizeInKB < fileLimit) {
            $('#image-warning').hide();
            Swal.fire(
                'Ok!',
                'Berhasil menambahkan gambar!',
                'success'
            )
            // add file to db here
        } else {
            $('#image-warning').removeAttr('hidden');
            $('#image-warning').show();
            Swal.fire(
                'Error',
                'Ukuran file lebih dari 500KB! upload ulang ya!',
                'error'
            );
            document.querySelector("#tb-image").src = '';
            // do not pass go, do not add to db. Pass error to user    
        }
    });
</script>
