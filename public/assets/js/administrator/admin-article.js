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
				$('#table-article').DataTable().ajax.reload(null, false);
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

// Fungsi delete artikel
$('body').on('click', '.btn-delete-article', function() {
	const id = $(this).data('id');

        //Lakukan ajax menyimpan data check
        Swal.fire({
            html: '<b>Hapus artikel?</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {

                // Tindakan yang akan diambil jika mengonfirmasi delete
                $.ajax({
                    url: '/administrator/article/delete',
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        if (response.success) {
                            var icon = '<i class="fas fa-check"></i> ';
                            alertify.success(icon + response.success);

                            $('#table-article').DataTable().ajax.reload(null, false);
							$('#editArticleModal').modal('hide');

                        } else {
                            Swal.fire('', response.error, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
                        Swal.fire('Error!',
                            'Terjadi kesalahan saat memproses permintaan: ' +
                            textStatus, 'error');
                    }
                });
            }
        });
})

// hidden modal artikel
$('body').on('hidden.bs.modal', '#editArticleModal', function () {
	$("#form-edit-article")[0].reset();
});

$('body').on('hidden.bs.modal', '#articleModal', function () {
	$("#form-add-article")[0].reset();
});

// KATEGORI ARTIKEL

$('body').on('keyup', '#category-name', function() {
	var title = $('#category-name').val();
	var slug = generateSlug(title);

	//Isikan data slug pada form
	$('#category-id').val(slug);
})

// Menampilkan data kategori
var dataKategori = $('#table-article-category').DataTable({
	"dom": 'rtip',
	"bInfo": false,
	language: {
		'paginate': {
			'previous': '<i class="fas fa-angle-double-left"></i>',
			'next': '<i class="fas fa-angle-double-right"></i>'
		}
	},
	"oLanguage": {
		"sEmptyTable": "Tidak ada kategori artikel!"
	},
	processing: true,
	serverside: true,
	ordering: false,
	destroy: true,
	ajax: {
		'type': 'GET',
		'url': '/administrator/blog-category/get',
		'data': {
		},
	},

	columns: [{
		data: 'category',
		name: 'category'
	}, {
		data: 'action',
		name: 'action'
	}]
});

//Pencarian data
$('#check-search-category').keyup(function() {
	dataKategori.search($(this).val()).draw();
});

//Klik add kategori
$('body').on('click', '#add-kategori', function() {
	$('#articleCategoryModalLabel').text('Buat kategori');
	$('#btn-submit-kategori').html('<i class="fas fa-check-circle"></i> Buat kategori');

	$('#articleCategoryModal').modal('show');
})

//handle submit form kategori artikel
$(document).on('submit', '#form-kategori-artikel', function(e) {
	e.preventDefault();

	const isEdit = $('#category-edit').val();
	let url;
	
	if (isEdit == 1) {
		// Jika mode edit
		url = '/administrator/blog-category/edit';
	} else {
		// Jika mode tambah
		url = '/administrator/blog-category/submit';
	}

	data = new FormData(this);
	$('#btn-submit-kategori').html('<i class="fas fa-spinner fa-spin"></i> Processing ...');

	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response) {
			if (response.success) {
				$('#articleCategoryModal').modal('hide');
				$('#table-article-category').DataTable().ajax.reload();
				alertify.success('<i class="fas fa-check"></i> ' + response.success);

			} else {
				Swal.fire('', response.error, 'error');
			}
			$('#btn-submit-kategori').html('<i class="fas fa-check-circle"></i> Buat kategori');
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
			Swal.fire('Error!',
				'Terjadi kesalahan saat memproses permintaan: ' +
				textStatus, 'error');
			$('#btn-submit-kategori').html('<i class="fas fa-check-circle"></i> Buat kategori');
		}
	});

});

// Edit kategori artikel
$('body').on('click', '.btn-edit-kategori', function() {
	var rowData = $(this).data('row');
	var kategori = rowData.category
	var id = rowData.id;
	var slug = rowData.category_id;

	$('#articleCategoryModalLabel').text('Edit kategori');
	$('#btn-submit-kategori').html('<i class="fas fa-check-circle"></i> Edit kategori');

	$('#category-name').val(kategori);
	$('#category-id').val(slug);
	$('#category-key').val(id);
	$('#category-edit').val(1);

	$('#articleCategoryModal').modal('show');
})

//Modal kategori on hide
$('body').on('hidden.bs.modal', '#articleCategoryModal', function () {
	$("#form-kategori-artikel")[0].reset();
	$('#category-key').val('');
	$('#category-edit').val(0);
});

// Fungsi delete kategori artikel
$('body').on('click', '.btn-delete-kategori', function() {
	const id = $(this).data('id');

    //Lakukan ajax menyimpan data check
    Swal.fire({
            html: '<b>Hapus kategori?</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {

                // Tindakan yang akan diambil jika mengonfirmasi delete
                $.ajax({
                    url: '/administrator/blog-category/delete',
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        if (response.success) {
							var icon = '<i class="fas fa-check"></i> ';
                            alertify.success(icon + response.success);

                            $('#table-article-category').DataTable().ajax.reload(null, false);
							$('#articleCategoryModal').modal('hide');

                        } else {
                            Swal.fire('', response.error, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
                        Swal.fire('Error!',
                            'Terjadi kesalahan saat memproses permintaan: ' +
                            textStatus, 'error');
                    }
                });
            }
    });
})