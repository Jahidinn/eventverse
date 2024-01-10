@if ($data->position == 'Request join')
    <a href="javascript:void(0)" class="text-info text-decoration-none">{{ $data->user->name }}</a>
@else
    <a href="javascript:void(0)" class="text-info text-decoration-none">{{ $data->user->name }} <span
            class="badge badge-secondary" style="top: 0">{{ $data->position }}</span></a>
@endif
