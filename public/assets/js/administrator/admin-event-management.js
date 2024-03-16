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
			"sEmptyTable": "Tidak ada event!"
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

