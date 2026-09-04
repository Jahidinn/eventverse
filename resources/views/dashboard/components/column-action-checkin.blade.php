@if (empty($participant->checked_in_at))
    <button class="button-39 btn-sm text-primary checkin-event" data-id="{{ $participant->id }}"><i
            class="fas fa-check-circle"></i> Check in
    </button>
@else
    <span class="text-success"><i class="fas fa-check"></i> checked</span>
@endif
