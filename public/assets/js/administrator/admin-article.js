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
			data: 'blog-title',
			name: 'blog-title'
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

$('body').on('keyup', '#blog-title-edit', function() {
	var title = $('#blog-title-edit').val();
	var slug = generateSlug(title);

	//Isikan data slug pada form
	$('#slug-edit').val(slug);
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

	const url = '/administrator/article/post';
	const addArticleButton = '#btn-submit-article';
	const addArticleModal = '#articleModal'
	const addArticleTable = '#table-article';
	const addArticleButtonText = '<i class="fas fa-check-circle"></i> Publish';

	submitData(addArticleButton, url, addArticleModal, addArticleTable, addArticleButtonText);

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

// handle submit form edit artikel
$(document).on('submit', '#form-edit-article', function(e) {
	e.preventDefault();

	data = new FormData(this);

	const url = '/administrator/article/edit';
	const editArticleButton = '#submit-edit-article';
	const editArticleModal = '#editArticleModal'
	const editArticleTable = '#table-article';
	const editArticleButtonText = '<i class="fas fa-check-circle"></i> Edit artikel';

	submitData(editArticleButton, url, editArticleModal, editArticleTable, editArticleButtonText);

})

// Fungsi delete artikel
$('body').on('click', '.btn-delete-article', function() {
	const id = $(this).data('id');

	const textWarning = '<b>Hapus artikel?</b>';
	const url = '/administrator/article/delete';
	const modal = '#editArticleModal';
	const table = '#table-article';

	// Panggil function
	deleteData(id, textWarning, url, modal, table);

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
$(document).ready(function() {
	const categoryTable = '#table-article-category';
	const categoryUrl = '/administrator/blog-category/get';
	const categoryColumn = 'category';
	const categorySearchForm = '#search-category';
	const categoryNull = "Tidak ada kategori artikel!";

	// Panggil function
	dataTable(categoryTable, categoryUrl, categoryColumn, categorySearchForm, categoryNull);
})


//Pencarian data
$('#search-category').keyup(function() {
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
	data = new FormData(this);
	let url;
	
	if (isEdit == 1) {
		// Jika mode edit
		url = '/administrator/blog-category/edit';
	} else {
		// Jika mode tambah
		url = '/administrator/blog-category/submit';
	}

	const categoryButton = '#btn-submit-kategori'
	const categoryModal = '#articleCategoryModal'
	const categoryTable = '#table-article-category';
	const categoryButtonText = '<i class="fas fa-check-circle"></i> Buat kategori'

	submitData(categoryButton, url, categoryModal, categoryTable, categoryButtonText);

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

	const textWarning = '<b>Hapus kategori?</b>';
	const url = '/administrator/blog-category/delete';
	const modal = '#articleCategoryModal';
	const table = '#table-article-category';

	// Panggil function
	deleteData(id, textWarning, url, modal, table);
})


// JENIS ARTIKEL

$('body').on('keyup', '#article-type', function() {
	var title = $('#article-type').val();
	var slug = generateSlug(title);

	//Isikan data slug pada form
	$('#type-slug').val(slug);
})

// Menampilkan jenis artikel
	$(document).ready(function() {
	const typeTable = '#table-article-type';
	const typeUrl = '/administrator/blog-type/get';
	const typeColumn = 'type_name';
	const typeSearchForm = '#search-article-type';
	const typeNull = 'Tidak ada jenis artikel';
	// Panggil function
	dataTable(typeTable, typeUrl, typeColumn, typeSearchForm, typeNull);
})


//Klik add type
$('body').on('click', '#add-type-article', function() {
	$('#articleTypeModalLabel').text('Tambah jenis artikel');
	$('#submit-jenis-artikel').html('<i class="fas fa-check-circle"></i> Tambahkan');

	$('#articleTypeModal').modal('show');
})


//handle submit form jenis artikel
$(document).on('submit', '#form-jenis-artikel', function(e) {
	e.preventDefault();

	const isEdit = $('#type-edit').val();
	data = new FormData(this);
	let url;
	
	if (isEdit == 1) {
		// Jika mode edit
		url = '/administrator/blog-type/edit';
	} else {
		// Jika mode tambah
		url = '/administrator/blog-type/submit';
	}

	const typeButton = '#submit-jenis-artikel';
	const typeModal = '#articleTypeModal'
	const typeTable = '#table-article-type';
	const typeButtonText = '<i class="fas fa-check-circle"></i> Tambahkan';

	submitData(typeButton, url, typeModal, typeTable, typeButtonText);

});


// Edit jenis artikel
$('body').on('click', '.edit-jenis-artikel', function() {
	var rowData = $(this).data('row');
	var type = rowData.type_name
	var id = rowData.id;
	var slug = rowData.type_slug;

	$('#articleTypeModalLabel').text('Edit jenis artikel');
	$('#submit-jenis-artikel').html('<i class="fas fa-check-circle"></i> Edit');

	$('#article-type').val(type);
	$('#type-slug').val(slug);
	$('#type-id').val(id);
	$('#type-edit').val(1);

	$('#articleTypeModal').modal('show');
})

//Modal tipe/jenis on hide
$('body').on('hidden.bs.modal', '#articleTypeModal', function () {
	$("#form-jenis-artikel")[0].reset();
	$('#type-id').val('');
	$('#type-edit').val(0);
});

// Fungsi delete tipe/jenis artikel
$('body').on('click', '.delete-jenis-artikel', function() {
	const id = $(this).data('id');
	const textWarning = '<b>Hapus jenis artikel?</b>';
	const url = '/administrator/blog-type/delete';
	const modal = '#articleTypeModal';
	const table = '#table-article-type';

	// Panggil function
	deleteData(id, textWarning, url, modal, table);
    
})

// Fungsi Menampilkan DATATABLE untuk jenis artikel, tipe artikel
function dataTable(table, url, column_0, searchForm, nullData){
	// Datatable
	var dataTable = $(table).DataTable({
		"dom": 'rtip',
		"bInfo": false,
		language: {
			'paginate': {
				'previous': '<i class="fas fa-angle-double-left"></i>',
				'next': '<i class="fas fa-angle-double-right"></i>'
			}
		},
		"oLanguage": {
			"sEmptyTable": nullData
		},
		processing: true,
		serverside: true,
		ordering: false,
		destroy: true,
		ajax: {
			'type': 'GET',
			'url': url,
			'data': {
			},
		},
	
		columns: [{
			data: column_0,
			name: column_0
		}, {
			data: 'action',
			name: 'action'
		}]
	});
	
	//Pencarian data
	$(searchForm).keyup(function() {
		dataTable.search($(this).val()).draw();
	});
}


// Fungsi SUBMIT untuk artkel, jenis artikel, tipe artikel
function submitData(button, url, modal, table, buttonText){

	$(button).html('<i class="fas fa-spinner fa-spin"></i> Processing ...');
	$(button).attr('disabled', true);

	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response) {
			if (response.success) {
				$(modal).modal('hide');
				$(table).DataTable().ajax.reload();
				alertify.success('<i class="fas fa-check"></i> ' + response.success);

			} else {
				Swal.fire('', response.error, 'error');
			}
			$(button).html(buttonText);
			$(button).attr('disabled', false);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
			Swal.fire('Error!', 'Error request: ' + textStatus, 'error');
			$(button).html(buttonText);
			$(button).attr('disabled', false);
		}
	});
}


// Fungsi DELETE untuk artkel, jenis artikel, tipe artikel
function deleteData(id, textWarning, url, modal, table) {
	//Lakukan ajax menyimpan data check
    Swal.fire({
        html: textWarning,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {

            // Tindakan yang akan diambil jika mengonfirmasi delete
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(response) {
                    if (response.success) {
						var icon = '<i class="fas fa-check"></i> ';
                        alertify.success(icon + response.success);

						$(modal).modal('hide');
						$(table).DataTable().ajax.reload(null, false);

                    } else {
                        Swal.fire('', response.error, 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
                    Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan: ' + textStatus, 'error');
                }
            });
        }
    });
}

