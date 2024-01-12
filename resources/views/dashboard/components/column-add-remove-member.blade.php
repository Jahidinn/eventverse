@if ($data->position == 'Owner')
@else
    <button class="btn btn-sm btn-danger org-remove-member" data-org_member_id="{{ $data->id }}"
        data-org_member_name="{{ $data->user->name }}">
        <i class="fas fa-minus-circle"></i> Remove
    </button>
@endif
