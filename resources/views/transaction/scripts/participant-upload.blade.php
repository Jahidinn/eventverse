<script>
/* =========================================================
   UPLOAD FILE / IMAGE
========================================================= */
document.addEventListener('change', function (e) {
    if (!e.target.matches('.upload-box input[type=file]')) return;

    const input = e.target;
    const file = input.files[0];

    if (!file) {
        resetUpload(input);
        return;
    }

    const uploadBox = input.closest('.upload-box');
    const isImage = uploadBox.classList.contains('image-upload');

    const validation = validateFile(input, file);

    if (!validation.valid) {
        showToast('error', validation.message);
        resetUpload(input);
        return;
    }

    const size = formatFileSize(file.size);

    uploadBox.classList.add('uploaded');
    uploadBox.classList.remove('upload-error');

    const strong = uploadBox.querySelector('.upload-content strong');
    const small = uploadBox.querySelector('.upload-content small');

    if (strong) strong.textContent = file.name;
    if (small) small.textContent = size;

    if (isImage) previewImage(input, file);
});


/* =========================================================
   VALIDATION
========================================================= */
function validateFile(input, file) {
    const accept = input.getAttribute('accept');

    if (accept) {
        const allowed = accept.split(',')
            .map(ext => ext.replace('.', '').trim().toLowerCase());
        const extension = file.name.split('.').pop().toLowerCase();

        if (!allowed.includes(extension)) {
            return { valid: false, message: 'Format file tidak diperbolehkan.' };
        }
    }

    const maxSize = 10 * 1024 * 1024;

    if (file.size > maxSize) {
        return { valid: false, message: 'Ukuran file maksimal 10 MB.' };
    }

    return { valid: true };
}


/* =========================================================
   IMAGE PREVIEW
========================================================= */
function previewImage(input, file) {
    const preview = input.closest('.checkout-field')?.querySelector('.image-preview');
    if (!preview) return;

    const reader = new FileReader();

    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };

    reader.readAsDataURL(file);
}


/* =========================================================
   RESET
========================================================= */
function resetUpload(input) {
    input.value = '';

    const uploadBox = input.closest('.upload-box');
    if (!uploadBox) return;

    uploadBox.classList.remove('uploaded', 'upload-error');

    const strong = uploadBox.querySelector('.upload-content strong');
    const small = uploadBox.querySelector('.upload-content small');

    if (strong) {
        strong.textContent = uploadBox.classList.contains('image-upload')
            ? 'Upload Gambar'
            : 'Upload File';
    }
    if (small) small.textContent = 'Belum ada file dipilih';

    const preview = uploadBox.closest('.checkout-field')?.querySelector('.image-preview');
    if (preview) {
        preview.style.display = 'none';
        preview.src = '';
    }
}


/* =========================================================
   FORMAT SIZE
========================================================= */
function formatFileSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1024 / 1024).toFixed(2) + ' MB';
}
</script>