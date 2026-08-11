<?php

namespace App\Services\Payment;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class XenditService
{
    private string $baseUrl;
    private string $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('xendit.base_url');
        $this->secretKey = config('xendit.secret_key');
    }

    private function request(
        string $method,
        string $endpoint,
        array $data = []
    ): array
    {
        $response = Http::withBasicAuth(
                $this->secretKey,
                ''
            )
            ->acceptJson()
            ->withHeaders([
                'api-version' => '2024-11-11',
            ])
            ->send(
                $method,
                $this->baseUrl . $endpoint,
                [
                    'json' => $data,
                ]
            );

        $response->throw();

        return $response->json();
    }

    public function createPaymentRequest(
        Transaction $transaction
    ): array
    {
        return $this->request(
            'POST',
            '/v3/payment_requests',
            $this->buildPaymentRequestPayload($transaction)
        );
    }

    public function cancelPaymentRequest(
        string $paymentRequestId
    ): array
    {
        return $this->request(
            'POST',
            "/v3/payment_requests/{$paymentRequestId}/cancel"
        );
    }

    private function buildPaymentRequestPayload(
        Transaction $transaction
    ): array
    {
        $transaction->loadMissing([
            'paymentGatewayMethod',
            'reservation',
        ]);

        return [

            'reference_id' => $transaction->transaction_code,

            'type' => 'PAY',

            'country' => 'ID',

            'currency' => 'IDR',

            'request_amount' => (int) $transaction->grand_total,

            'channel_code' => $transaction
                ->paymentGatewayMethod
                ->gateway_code,

            'channel_properties' => $this->buildChannelProperties(
                $transaction
            ),

        ];
    }

    private function buildChannelProperties(
        Transaction $transaction
    ): array
    {
        $returnUrl = route(
            'transaction.show',
            $transaction->transaction_code
        );

        $expiresAt = $transaction->reservation
            ->expired_at
            ->copy()
            ->utc()
            ->toIso8601String();

        return match ($transaction->paymentGatewayMethod->gateway_code) {

            'QRIS',

            'BCA_VIRTUAL_ACCOUNT',
            'BNI_VIRTUAL_ACCOUNT',
            'BRI_VIRTUAL_ACCOUNT',
            'MANDIRI_VIRTUAL_ACCOUNT',
            'PERMATA_VIRTUAL_ACCOUNT' => [

                'display_name' => 'EVENTVERSE',

                'expires_at' => $expiresAt,

            ],

            'GOPAY',
            'SHOPEEPAY' => [

                'success_return_url' => $returnUrl,

                'failure_return_url' => $returnUrl,

                'pending_return_url' => $returnUrl,
                'cancel_return_url' => $returnUrl,

                'expires_at' => $expiresAt,

            ],

            default => [],

        };
    }
}