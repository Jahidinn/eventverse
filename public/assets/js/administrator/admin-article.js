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

	// Menangani event klik pada dataHistory
	dataArticle.on('click', 'tr', function(e) {
		var rowData = dataArticle.row(this).data();

		if (rowData) {
			//Memanggil function handleRowClick
			handleRowClick(dataArticle, e);
		}
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

// Fungsi untuk menangani event klik row da menampilkan data
function handleRowClick(dataTable, e) {
	if ($(e.target).is('.btn-edit-article') || $(e.target).closest('.btn-edit-article').length > 0) {
		let data = dataTable.row(e.target.closest('tr')).data();

		// Tampilkan data detail transaksi pada modal
		$('#blog-id-edit').val(data['id'])
		$('#blog-title-edit').val(data['title'])
		$('#blog-category-edit').val(data['category_id'])
		$('#slug-edit').val(data['slug'])

		if (data['input_image'] == '' || data['input_image'] == null) {
			$('#image-edit-container').attr('hidden', true);
		} else {
			$('#image-edit-container').attr('hidden', false);
			
		}

		//Image
		var imageUrlFull = imageUrl +  '/' + data['input_image'];
        // Set atribut 'src' untuk menampilkan gambar
        $("#article-image-edit").attr("src", imageUrlFull);
		

		// Membersihkan konten sebelum memasukkan HTML baru
		$('#edit-body-container').empty(); // atau $('#edit-body-container').html('');
		var bodyValue = data['body'];

		// Memasukkan HTML baru
		$('#edit-body-container').html(`
			<label for="blog-body-edit">Body</label>
			<input id="blog-body-edit" type="hidden" name="blog_body_edit" value="${bodyValue}" required>
			<trix-editor input="blog-body-edit"></trix-editor>
		`);

		$('#blog-article-id-edit').val(data['article_code']);
		$('#blog-tag-edit').val(data['tag']);

		$('#editArticleModal').modal('show');
	}
}

// Fungsi edit ertikel 

// handle submit form edit artikel
$(document).on('submit', '#form-edit-article', function(e) {
	e.preventDefault();

	data = new FormData(this);
	$('#submit-edit-article').html('<i class="fas fa-spinner fa-spin"></i> Processing ...');
	$('#submit-edit-article').attr('disabled', true);

	$.ajax({
		url: '/administrator/article/edit',
		type: 'POST',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(response) {
			if (response.success) {
				$('#editArticleModal').modal('hide');
				$('#table-article').DataTable().ajax.reload();
				alertify.success('<i class="fas fa-check"></i> ' + response.success);

			} else {
				Swal.fire('', response.error, 'error');
			}
			$('#submit-edit-article').html('<i class="fas fa-check-circle"></i> Edit artikel');
			$('#submit-edit-article').attr('disabled', false);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
			Swal.fire('Error!',
				'Terjadi kesalahan saat memproses permintaan: ' +
				textStatus, 'error');
			$('#btn-submit-article').html('<i class="fas fa-check-circle"></i> Publish');
		}
	});
})