@php

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    $transaction = $data;

    /*
    |--------------------------------------------------------------------------
    | HARGA
    |--------------------------------------------------------------------------
    */

    $jumlahPeserta = $transaction->participants?->count() ?? 1;

    $jumlahPeserta = max($jumlahPeserta, 1);

    if (
        $transaction->subtotal == 0 ||
        $transaction->subtotal == ''
    ) {
        $price = 'GRATIS';
        $payment = '-';
    } else {
        $totalTicketPrice = $transaction->subtotal;
        $price =
            $totalTicketPrice / $jumlahPeserta;
        $payment =
            $transaction->paymentGatewayMethod?->method?->name
            ?? '-';
    }


    /*
    |--------------------------------------------------------------------------
    | PARTICIPANT
    |--------------------------------------------------------------------------
    */

    $participantData = [

        'id' => $participant->id,

        'name' => $participant->name ?? '',

        'email' => $participant->email ?? '',

        'phone' => $participant->phone ?? '',

        /*
        |--------------------------------------------------------------------------
        | CUSTOM FORM
        |--------------------------------------------------------------------------
        */

        'forms' => $transaction->event?->customForms
            ->map(function ($customForm) use ($participant) {

                /*
                |--------------------------------------------------------------------------
                | Cari jawaban participant untuk form ini
                |--------------------------------------------------------------------------
                */

                $answer = $participant->forms
                    ->firstWhere('form_id', $customForm->id);


                $fieldType = strtolower(
                    $customForm->field_type ?? ''
                );


                $formValue = $answer?->form_value;


                /*
                |--------------------------------------------------------------------------
                | URL FILE / IMAGE
                |--------------------------------------------------------------------------
                */

                $url = null;

                if (
                    in_array($fieldType, ['image', 'file']) &&
                    $formValue
                ) {

                    $url = \Illuminate\Support\Facades\Storage::url(
                        $formValue
                    );

                }


                return [

                    'id' => $answer?->id,

                    'form_id' => $customForm->id,

                    'field_type' => $fieldType,

                    'field_label' =>
                        $customForm->field_label ?? '',

                    /*
                    |--------------------------------------------------------------------------
                    | NULL kalau tidak diisi
                    |--------------------------------------------------------------------------
                    */

                    'form_value' => $formValue,

                    'url' => $url,

                ];

            })
            ->values()
            ->toArray(),
    ];


    /*
    |--------------------------------------------------------------------------
    | DETAIL MODAL
    |--------------------------------------------------------------------------
    */

    $detail = [

        /*
        |--------------------------------------------------------------------------
        | PARTICIPANT
        |--------------------------------------------------------------------------
        */

        'participant' => $participantData,


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        'transaction' => [

            'id' => $transaction->id,

            'transaction_id' => $transaction->transaction_id ?? '',

            'transaction_code' => $transaction->transaction_code ?? '',

            'status' => $transaction->status ?? '',

            'created_at' => $transaction->created_at
                ?->format('d M Y H:i'),

            /*
            |--------------------------------------------------------------------------
            | BUYER
            |--------------------------------------------------------------------------
            */

            'buyer_name' => $transaction->buyer_name ?? '',

            'buyer_email' => $transaction->buyer_email ?? '',

            'buyer_phone' => $transaction->buyer_phone ?? '',


            /*
            |--------------------------------------------------------------------------
            | PAYMENT
            |--------------------------------------------------------------------------
            */

            'subtotal' => $transaction->subtotal ?? 0,

            'price' => $price,

            'payment_type' => $payment,

            'payment_gateway_method_id' =>
                $transaction->payment_gateway_method_id ?? null,
        ],


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        'event' => [

            'id' => $transaction->event?->id,

            'event_id' => $transaction->event?->event_id,

            'title' => $transaction->event?->title ?? '',
        ],


        /*
        |--------------------------------------------------------------------------
        | TICKET
        |--------------------------------------------------------------------------
        */

        'ticket' => [

            'id' => $transaction->ticket?->id,

            'ticket_name' =>
                $transaction->ticket?->ticket_name ?? '',

            'price' =>
                $transaction->ticket?->price ?? 0,
        ],

    ];

@endphp

<button
    type="button"
    class="button-39 btn-sm px-2 text-dark detail-transaksi"

    data-id="{{ $transaction->id }}"

    data-event_id="{{ $transaction->event_id }}"

    data-nama="{{ $participant->name ?? '' }}"

    data-email="{{ $participant->email ?? '' }}"

    data-phone="{{ $participant->phone ?? '' }}"

    data-ticket="{{ $transaction->ticket?->ticket_name ?? '' }}"

    data-biaya="{{ $price }}"

    data-status="{{ $transaction->status ?? '' }}"

    data-pembayaran="{{ $payment }}"

    data-id_transaksi="{{ $transaction->transaction_id ?? '' }}"

    data-detail='@json($detail)'
>
    detail <i class="ti ti-arrow-right"></i>
</button>