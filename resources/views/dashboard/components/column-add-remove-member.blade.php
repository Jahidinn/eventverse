@if ($data->position == 'Owner')
@else
    <button class="btn btn-sm btn-danger remove-member" data-id="{{ $data->id }}">
        <i class="fas fa-minus-circle"></i> Remove
    </button>
@endif
