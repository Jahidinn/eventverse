$(document).ready(function() {
	$('#download-sertifikat').click(function(e) {
		e.preventDefault()
		var jenis = $('#sertifikat-type').val();
		var id = $('#sertifikat-id').val();
		$.ajax({
			url: '/download/check-file',
			method: 'GET',
			data: { jenis: jenis, id : id },
			success: function(response) {
				if (response.exists) {
					window.location.href = '/download-file/download?jenis=' + response.jenis + '&id=' + response.id;
					alertify.success('<i class="fas fa-check"></i> Download sukes!');
				} else {
					Swal.fire('Ooopss', 'ID peserta tidak ditemukan!!', 'error');
				}
			}
		});
	});
});