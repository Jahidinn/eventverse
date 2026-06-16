@if (empty($data->checkin))
    <button class="button-39 btn-sm checkin-event" data-id="{{ $data->transaction_id }}"><i
            class="fas fa-check-circle"></i> Check in
    </button>
@else
    <span class="text-success"><i class="fas fa-check"></i> checked</span>
@endif
