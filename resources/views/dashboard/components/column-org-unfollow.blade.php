@if ($data->position == 'Owner')
    <button class="btn btn-sm btn-success unfollow-organization">
        <i class="fas fa-check"></i> Owner
    </button>
@elseif($data->position == 'Request gabung')
    <button class="btn btn-sm btn-warning cancel-follow-organization" data-org_id="{{ $data->id }}">
        <i class="fas fa-times-circle"></i> Cancel
    </button>
@elseif($data->position == 'Request keluar')
    <button class="btn btn-sm btn-warning cancel-unfollow-organization" data-org_id="{{ $data->id }}">
        <i class="fas fa-times-circle"></i> Cancel
    </button>
@else
    <button class="btn btn-sm btn-danger unfollow-organization" data-org_id="{{ $data->id }}">
        Keluar <i class="fas fa-caret-square-right"></i>
    </button>
@endif
