@php
    if ($data->total_price == 0 || $data->total_price == '') {
        $price = 'GRATIS';
        $payment = '-';
    } else {
        $price = $data->total_price - config('app.biaya_admin');
        $payment = $data->payment_type;
    }

@endphp

<button class="button-39 btn-sm px-2 text-dark detail-transaksi" data-id="{{ $data->id }}" data-event_id="{{ $data->event_id }}"
    data-nama="{{ $data->name }}" data-email="{{ $data->email }}" data-phone="{{ $data->phone }}"
    data-ticket="{{ $data->ticket->ticket_name }}" data-biaya="{{ $price }}" data-status="{{ $data->status }}"
    data-pembayaran="{{ $payment }}" data-id_transaksi="{{ $data->transaction_id }}">
    More info <i class="fas fa-chevron-circle-right"></i>
</button>
