<script>
    $(function () {

        /*
        |--------------------------------------------------------------------------
        | Upload File / Image
        |--------------------------------------------------------------------------
        */

        $(document).on('change', '.upload-box input[type=file]', function () {

            const input = this;

            const file = input.files[0];

            if (!file) {

                resetUpload(input);

                return;

            }

            const uploadBox = $(input).closest('.upload-box');

            const isImage = uploadBox.hasClass('image-upload');

            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            const validation = validateFile(input, file);

            if (!validation.valid) {

                Swal.fire({

                    icon: 'error',

                    title: 'Upload Gagal',

                    text: validation.message

                });

                resetUpload(input);

                return;

            }

            /*
            |--------------------------------------------------------------------------
            | Success UI
            |--------------------------------------------------------------------------
            */

            const size = formatFileSize(file.size);

            uploadBox
                .addClass('uploaded')
                .removeClass('upload-error');

            uploadBox.find('.upload-content strong')
                .text(file.name);

            uploadBox.find('.upload-content small')
                .text(size);

            /*
            |--------------------------------------------------------------------------
            | Image Preview
            |--------------------------------------------------------------------------
            */

            if (isImage) {

                previewImage(input, file);

            }

        });

    });

    function validateFile(input, file) {

        const accept = $(input).attr('accept');

        /*
        |--------------------------------------------------------------------------
        | Extension Validation
        |--------------------------------------------------------------------------
        */

        if (accept) {

            const allowed = accept
                .split(',')
                .map(ext => ext.replace('.', '').trim().toLowerCase());

            const extension = file.name
                .split('.')
                .pop()
                .toLowerCase();

            if (!allowed.includes(extension)) {

                return {

                    valid: false,

                    message: 'Format file tidak diperbolehkan.'

                };

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Max Size (10 MB)
        |--------------------------------------------------------------------------
        */

        const maxSize = 10 * 1024 * 1024;

        if (file.size > maxSize) {

            return {

                valid: false,

                message: 'Ukuran file maksimal 10 MB.'

            };

        }

        return {

            valid: true

        };

    }

    function previewImage(input, file) {

        const reader = new FileReader();

        const preview = $(input)
            .closest('.checkout-field')
            .find('.image-preview');

        reader.onload = function (e) {

            preview
                .attr('src', e.target.result)
                .fadeIn(150);

        };

        reader.readAsDataURL(file);

    }

    function resetUpload(input) {

        input.value = '';

        const uploadBox = $(input).closest('.upload-box');

        uploadBox
            .removeClass('uploaded')
            .removeClass('upload-error');

        uploadBox.find('.upload-content strong')
            .text('Upload File');

        uploadBox.find('.upload-content small')
            .text('Belum ada file dipilih');

        uploadBox
            .closest('.checkout-field')
            .find('.image-preview')
            .hide()
            .attr('src', '');

    }

    function formatFileSize(bytes) {

        if (bytes < 1024) {

            return bytes + ' B';

        }

        if (bytes < 1024 * 1024) {

            return (bytes / 1024).toFixed(1) + ' KB';

        }

        return (bytes / 1024 / 1024).toFixed(2) + ' MB';

    }
</script>