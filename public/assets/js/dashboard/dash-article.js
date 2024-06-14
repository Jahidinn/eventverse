$(document).ready(function() {

	//Datatable request penarikan
	var dataUserArticle = $('#table-user-article').DataTable({
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
			'url': '/dashboard/article/get',
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
	$('#user-search-article').keyup(function() {
		dataUserArticle.search($(this).val()).draw();
	});

	// Menangani event klik pada dataHistory
	dataUserArticle.on('click', 'tr', function(e) {
		var rowData = dataUserArticle.row(this).data();

		if (rowData) {
			//Memanggil function handleRowClick
			handleRowClick(dataUserArticle, e);
		}
	});
});

