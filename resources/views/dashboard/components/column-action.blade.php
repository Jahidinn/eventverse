{{-- For ticket & form action --}}

<a class="btn btn-sm btn-success edit-{{ $button }}" data-id="{{ $data->id }}"
    data-event_id="{{ $data->event_id }}" data-form_name="{{ $data->form_name }}"
    data-ticket_name="{{ $data->ticket_name }}" data-ticket_price="{{ $data->ticket_price }}"
    data-ticket_quota="{{ $data->ticket_quota }}" data-ticket_start="{{ $data->ticket_start }}"
    data-ticket_deadline="{{ $data->ticket_deadline }}" data-ticket_button="{{ $data->ticket_button }}"
    data-ticket_more_qty="{{ $data->more_quantity }}"><i class="fas fa-edit mr-1"></i>Edit</a>

<button class="btn btn-sm btn-danger delete-{{ $button }}" data-id="{{ $data->id }}"><i
        class="fas fa-trash-alt"></i></button>
