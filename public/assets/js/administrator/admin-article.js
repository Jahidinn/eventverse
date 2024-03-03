$(document).ready(function() {

	//Datatable request penarikan
	var dataArticle = $('#table-article').DataTable({
		"dom": 'rtip',
		"bInfo": false,
		language: {
			'paginate': {
				'previous': '<i class="fas fa-angle-double-left"></i>',
				'next': '<i class="fas fa-angle-double-right"></i>'
			}
		},
		"oLanguage": {
			"sEmptyTable": "Tidak ada artikel!"
		},
		processing: true,
		serverside: true,
		ordering: false,
		destroy: true,
		ajax: {
			'type': 'GET',
			'url': '/administrator/article/get',
			'data': {
			},
		},

		columns: [{
			data: 'title',
			name: 'title'
		}, {
			data: 'action',
			name: 'action'
		}]
	});

	//Pencarian data
	$('#search-request').keyup(function() {
		dataArticle.search($(this).val()).draw();
	});
});

$('body').on('keyup', '#blog-title', function() {
	var title = $('#blog-title').val();
	var slug = generateSlug(title);

	//Isikan data slug pada form
	$('#slug').val(slug);
})


//Function geretate slug
function generateSlug(text) {
	var title = text.toLowerCase().trim();
	var slug = title.replace(/\s+/g, '-').replace(/[^\w-]+/g, '');
	return slug;
}

//handle submit form artikel
$(document).on('submit', '#form-add-article', function(e) {
	e.preventDefault();

	data = new FormData(this);
	$('#btn-submit-article').html('<i class="fas fa-spinner fa-spin"></i> Processing ...');

	$.ajax({
		url: '/administrator/article/post',
		type: 'POST',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(response) {
			if (response.success) {
				$('#articleModal').modal('hide');
				$('#table-article').DataTable().ajax.reload();
				alertify.success('<i class="fas fa-check"></i> ' + response.success);

			} else {
				Swal.fire('', response.error, 'error');
			}
			$('#btn-submit-article').html('<i class="fas fa-check-circle"></i> Publish');
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
			Swal.fire('Error!',
				'Terjadi kesalahan saat memproses permintaan: ' +
				textStatus, 'error');
			$('#btn-submit-article').html('<i class="fas fa-check-circle"></i> Publish');
		}
	});

});