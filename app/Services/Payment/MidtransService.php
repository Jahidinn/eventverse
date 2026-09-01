<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private string $baseUrl;

    private string $serverKey;


    public function __construct()
    {
        $this->baseUrl = rtrim(
            config('midtrans.base_url'),
            '/'
        );

        $this->serverKey =
            config('midtrans.server_key');
    }


    /*
    |--------------------------------------------------------------------------
    | HTTP REQUEST
    |--------------------------------------------------------------------------
    */

    private function request(
        string $method,
        string $endpoint,
        array $data = []
    ): array {

        $url =
            $this->baseUrl .
            '/' .
            ltrim($endpoint, '/');


        $request = Http::withBasicAuth(
            $this->serverKey,
            ''
        )
        ->acceptJson()
        ->timeout(30);


        if (!empty($data)) {

            $response = $request->send(
                $method,
                $url,
                [
                    'json' => $data,
                ]
            );

        } else {

            $response = $request->send(
                $method,
                $url
            );
        }


        Log::info('MIDTRANS API REQUEST', [
            'method' => $method,
            'url' => $url,
            'status' => $response->status(),
            'body' => $response->json(),
        ]);


        if ($response->failed()) {

            throw new Exception(
                'Midtrans API error: ' .
                $response->body()
            );
        }


        $json = $response->json();


        if (!is_array($json)) {

            throw new Exception(
                'Invalid Midtrans API response.'
            );
        }


        return $json;
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PAYMENT
    |--------------------------------------------------------------------------
    */

    public function createPaymentRequest(
        Transaction $transaction
    ): array {

        $payload =
            $this->buildPaymentRequestPayload(
                $transaction
            );


        Log::info(
            'MIDTRANS CREATE PAYMENT',
            [
                'transaction_code' =>
                    $transaction->transaction_code,

                'payload' =>
                    $payload,
            ]
        );


        return $this->request(
            'POST',
            '/v2/charge',
            $payload
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL PAYMENT
    |--------------------------------------------------------------------------
    |
    | Midtrans:
    |
    | POST /v2/{order_id}/cancel
    |
    | order_id = transaction_code
    |
    */

    public function cancelPaymentRequest(
        string $transactionCode
    ): array {

        $transactionCode =
            trim($transactionCode);


        if ($transactionCode === '') {

            throw new Exception(
                'Transaction code Midtrans kosong.'
            );
        }


        return $this->request(
            'POST',
            '/v2/' .
            rawurlencode($transactionCode) .
            '/cancel'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD CREATE PAYMENT PAYLOAD
    |--------------------------------------------------------------------------
    */

    private function buildPaymentRequestPayload(
        Transaction $transaction
    ): array {

        $transaction->loadMissing([
            'paymentGatewayMethod',
            'reservation',
        ]);


        $method =
            $transaction->paymentGatewayMethod;


        if (!$method) {

            throw new Exception(
                'Payment gateway method tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BASIC PAYLOAD
        |--------------------------------------------------------------------------
        */

        $payload = [

            'payment_type' =>
                $method->gateway_code,

            'transaction_details' => [

                'order_id' =>
                    $transaction->transaction_code,

                'gross_amount' =>
                    (int) $transaction->grand_total,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | PAYMENT PROPERTIES
        |--------------------------------------------------------------------------
        */

        $payload = array_merge(
            $payload,
            $this->buildPaymentProperties(
                $method
            )
        );


        /*
        |--------------------------------------------------------------------------
        | EXPIRY
        |--------------------------------------------------------------------------
        */

        $payload = array_merge(
            $payload,
            $this->buildCustomExpiry(
                $transaction
            )
        );


        return $payload;
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT PROPERTIES
    |--------------------------------------------------------------------------
    */

    private function buildPaymentProperties(
        $method
    ): array {

        return match (
            $method->gateway_code
        ) {

            'bank_transfer' => [

                'bank_transfer' => [

                    'bank' =>
                        $method->sub_code,

                ],
            ],


            'cstore' => [

                'cstore' => [

                    'store' =>
                        $method->sub_code,

                ],
            ],


            default => [],
        };
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOM EXPIRY
    |--------------------------------------------------------------------------
    */

    private function buildCustomExpiry(
        Transaction $transaction
    ): array {

        $expiredAt =
            $transaction
                ->reservation
                ?->expired_at;


        if (!$expiredAt) {

            return [];
        }


        $expiredAt =
            Carbon::parse($expiredAt);


        $seconds =
            now()->diffInSeconds(
                $expiredAt,
                false
            );


        /*
        |--------------------------------------------------------------------------
        | Sudah expired
        |--------------------------------------------------------------------------
        */

        if ($seconds <= 0) {

            throw new Exception(
                'Reservation sudah kedaluwarsa.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Minimal 1 menit
        |--------------------------------------------------------------------------
        */

        $minutes =
            max(
                1,
                (int) ceil(
                    $seconds / 60
                )
            );


        return [

            'custom_expiry' => [

                'expiry_duration' =>
                    $minutes,

                'unit' =>
                    'minute',
            ],
        ];
    }
}