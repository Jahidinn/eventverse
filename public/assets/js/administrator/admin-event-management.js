$(document).ready(function() {

	// Datatable selected event
	var selectedEvent = $('#table-selected-event').DataTable({
		"dom": 'rtip',
		"bInfo": false,
		language: {
			'paginate': {
				'previous': '<i class="fas fa-angle-double-left"></i>',
				'next': '<i class="fas fa-angle-double-right"></i>'
			}
		},
		"oLanguage": {
			"sEmptyTable": "Tidak ada event pilihan!"
		},
		processing: true,
		serverside: true,
		ordering: false,
		destroy: true,
		ajax: {
			'type': 'GET',
			'url': '/administrator/event-management/get-selected',
			'data': {
			},
		},

		columns: [{
			data: 'DT_RowIndex',
			name: 'DT_RowIndex'
		}, {
			data: 'title',
			name: 'title'
		}, {
			data: 'action',
			name: 'action'
		}]
	});

	//Pencarian data
	$('#search-selected-event').keyup(function() {
		selectedEvent.search($(this).val()).draw();
	});

});


$('body').on('click', '#add-selected-event', function() {
	$('#addSelectedEventModal').modal('show');
	tableEvent()

})


function tableEvent() {
	// Datatable list event
	var dataEvent = $('#table-data-event').DataTable({
		"dom": 'rtip',
		"bInfo": false,
		language: {
			'paginate': {
				'previous': '<i class="fas fa-angle-double-left"></i>',
				'next': '<i class="fas fa-angle-double-right"></i>'
			}
		},
		"oLanguage": {
			"sEmptyTable": "Tidak ada event!"
		},
		processing: true,
		serverside: true,
		ordering: false,
		destroy: true,
		ajax: {
			'type': 'GET',
			'url': '/administrator/event-management/get-event',
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
	$('#search-data-event').keyup(function() {
		dataEvent.search($(this).val()).draw();
	});
}

// Klik pilih event
$('body').on('click', '.btn-event-select', function() {
	const id = $(this).data('id');
	$.ajax({
		url: '/administrator/event-management/select-event',
		type: 'POST',
		data: {
			id: id,
		},
		success: function(response) {
			if (response.success) {
				var icon = '<i class="fas fa-check"></i> ';
				alertify.success(icon + response.success);

				$('#addSelectedEventModal').modal('hide');
				$('#table-selected-event').DataTable().ajax.reload();

			} else {
				Swal.fire('', response.error, 'error');
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
			Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan: ' + textStatus, 'error');
		}
	});
})

$('body').on('click', '.btn-delete-selected', function() {
	const id = $(this).data('id');

	Swal.fire({
        html: 'Hapus dari daftar event pilihan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
				url: '/administrator/event-management/unselect-event',
				type: 'POST',
				data: {
					id: id,
				},
				success: function(response) {
					if (response.success) {
						var icon = '<i class="fas fa-check"></i> ';
						alertify.success(icon + response.success);
		
						$('#table-selected-event').DataTable().ajax.reload();
		
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

})


$(document).ready(function() {

	// Datatable selected event
	var promotionEvent = $('#table-promotion-event').DataTable({
		"dom": 'rtip',
		"bInfo": false,
		language: {
			'paginate': {
				'previous': '<i class="fas fa-angle-double-left"></i>',
				'next': '<i class="fas fa-angle-double-right"></i>'
			}
		},
		"oLanguage": {
			"sEmptyTable": "Tidak ada event di promosikan!"
		},
		processing: true,
		serverside: true,
		ordering: false,
		destroy: true,
		ajax: {
			'type': 'GET',
			'url': '/administrator/event-management/get-promotion',
			'data': {
			},
		},

		columns: [{
			data: 'DT_RowIndex',
			name: 'DT_RowIndex'
		}, {
			data: 'title',
			name: 'title'
		}, {
			data: 'action',
			name: 'action'
		}]
	});

	//Pencarian data
	$('#search-promotion-event').keyup(function() {
		promotionEvent.search($(this).val()).draw();
	});

});

//Show modal
$('body').on('click', '#add-promotion-event', function() {
	$('#addPromotionEventModal').modal('show');
	tableEventForPromotion()

})


function tableEventForPromotion() {
	// Datatable list event
	var dataEventForPromotion = $('#table-data-event-promotion').DataTable({
		"dom": 'rtip',
		"bInfo": false,
		language: {
			'paginate': {
				'previous': '<i class="fas fa-angle-double-left"></i>',
				'next': '<i class="fas fa-angle-double-right"></i>'
			}
		},
		"oLanguage": {
			"sEmptyTable": "Tidak ada event!"
		},
		processing: true,
		serverside: true,
		ordering: false,
		destroy: true,
		ajax: {
			'type': 'GET',
			'url': '/administrator/event-management/get-event-for-promotion',
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
	$('#search-data-event-promotion').keyup(function() {
		dataEventForPromotion.search($(this).val()).draw();
	});
}

// Promosikan event
$('body').on('click', '.btn-event-promote', function() {
	const id = $(this).data('id');
	$.ajax({
		url: '/administrator/event-management/promote-event',
		type: 'POST',
		data: {
			id: id,
		},
		success: function(response) {
			if (response.success) {
				var icon = '<i class="fas fa-check"></i> ';
				alertify.success(icon + response.success);

				$('#addPromotionEventModal').modal('hide');
				$('#table-promotion-event').DataTable().ajax.reload();

			} else {
				Swal.fire('', response.error, 'error');
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Menangani kesalahan Ajax dan menampilkan pesan dengan SweetAlert2
			Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan: ' + textStatus, 'error');
		}
	});
})

// Hapus data promosi
$('body').on('click', '.btn-delete-promotion', function() {
	const id = $(this).data('id');

	Swal.fire({
        html: 'Hapus dari daftar promosi?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
				url: '/administrator/event-management/unpromote-event',
				type: 'POST',
				data: {
					id: id,
				},
				success: function(response) {
					if (response.success) {
						var icon = '<i class="fas fa-check"></i> ';
						alertify.success(icon + response.success);
		
						$('#table-promotion-event').DataTable().ajax.reload();
		
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

})