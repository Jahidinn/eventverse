<a href="javascript:void(0)" class="text-info text-decoration-none">{{ $data->org->org_name }}
    @if ($data->position == 'Owner')
        <span class="badge badge-info">{{ $data->position }}</span>
    @elseif($data->position == 'Request gabung')
        <span class="badge badge-warning">{{ $data->position }}</span>
    @else
        <span class="badge badge-secondary">{{ $data->position }}</span>
    @endif

</a>
