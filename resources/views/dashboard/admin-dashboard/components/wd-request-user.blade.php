<a class="text-decoration-none text-info btn p-0" data-username="{{ $data->user->username }}"
    data-name="{{ $data->user->name }}" data-rekening="{{ $data->rekening }}"
    data-userRekening="{{ $data->user->no_rekening }}" data-event="{{ $data->event->id }}"
    data-amount="{{ $data->amount }}" data-status="{{ $data->status }}">
    {{ $data->user->username }}
</a>
