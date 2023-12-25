<button class="btn btn-sm btn-info detail-transaksi" data-id="{{ $data->id }}" data-event_id="{{ $data->event_id }}"
    data-nama="{{ $data->name }}" data-email="{{ $data->email }}" data-phone="{{ $data->phone }}"
    data-ticket="{{ $data->ticket->ticket_name }}" data-biaya="{{ $data->total_price - config('app.biaya_admin') }}"
    data-status="{{ $data->status }}" data-pembayaran="{{ $data->payment_type }}"
    data-id_transaksi="{{ $data->transaction_id }}">
    More info <i class="fas fa-chevron-circle-right"></i>
</button>
