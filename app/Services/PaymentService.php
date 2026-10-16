<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TicketService;
use App\Services\EmailService;

class PaymentService
{
    public function __construct(
        protected TicketService $ticketService,
        protected EmailService $emailService,
    ) {
    }

    public function handleWebhook(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Verifikasi webhook Xendit
        |--------------------------------------------------------------------------
        |
        | Xendit mengirim Webhook Verification Token melalui header
        | x-callback-token. Token harus sesuai dengan konfigurasi aplikasi.
        |
        */

        $callbackToken = $request->header('x-callback-token');
        $webhookToken = config('xendit.webhook_token');

        if (
            ! is_string($callbackToken) ||
            ! is_string($webhookToken) ||
            $callbackToken === '' ||
            $webhookToken === '' ||
            ! hash_equals($webhookToken, $callbackToken)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized webhook.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil payload webhook dari Xendit
        |--------------------------------------------------------------------------
        |
        | Webhook Payment Requests V3 memiliki struktur:
        | - event
        | - api_version
        | - data.payment_request_id
        | - data.status
        |
        | Data pembayaran berada di dalam objek "data", bukan di root JSON.
        |
        */

        $payload = $request->all();

        $event = $payload['event'] ?? null;
        $payment = $payload['data'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Validasi payload webhook
        |--------------------------------------------------------------------------
        */

        if (
            ! is_array($payment) ||
            empty($payment['payment_request_id']) ||
            ! is_string($payment['payment_request_id']) ||
            empty($payment['status']) ||
            ! is_string($payment['status']) ||
            ! is_string($event)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook payload.',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | Cari transaksi berdasarkan payment reference
        |--------------------------------------------------------------------------
        |
        | Kolom payment_reference menyimpan payment_request_id dari Xendit.
        |
        */

        $result = DB::transaction(function () use (
            $payload,
            $event,
            $payment
        ) {
            /*
            |--------------------------------------------------------------------------
            | Kunci baris transaksi
            |--------------------------------------------------------------------------
            |
            | lockForUpdate mencegah dua webhook memproses transaksi yang sama
            | secara bersamaan selama transaksi database berlangsung.
            |
            */

            $transaction = Transaction::where(
                'payment_reference',
                $payment['payment_request_id']
            )->lockForUpdate()->first();

            if (! $transaction) {
                return [
                    'success' => false,
                    'message' => 'Transaction not found.',
                    'http_code' => 404,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan payload webhook lengkap
            |--------------------------------------------------------------------------
            |
            | Simpan event, api_version, dan seluruh data yang dikirim Xendit
            | agar status callback terbaru dapat ditelusuri.
            |
            */

            $transaction->payment_payload = $payload;

            /*
            |--------------------------------------------------------------------------
            | Cegah transaksi diproses lebih dari satu kali
            |--------------------------------------------------------------------------
            |
            | Webhook dapat dikirim ulang oleh Xendit.
            | Transaksi Paid tidak boleh menjual tiket kembali.
            |
            */

            if ($transaction->status === 'Paid') {
                $transaction->save();

                return [
                    'success' => true,
                    'message' => 'Transaction already paid.',
                    'http_code' => 200,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Periksa masa berlaku transaksi
            |--------------------------------------------------------------------------
            |
            | Transaksi yang sudah Expired atau melewati expired_at tidak
            | diproses menjadi Paid secara otomatis.
            |
            */

            if (
                $transaction->status === 'Expired' ||
                (
                    $transaction->expired_at &&
                    $transaction->expired_at->isPast()
                )
            ) {
                $transaction->save();

                return [
                    'success' => true,
                    'message' => 'Transaction already expired.',
                    'http_code' => 200,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan payload untuk setiap event yang valid
            |--------------------------------------------------------------------------
            |
            | Event selain payment.capture dengan status SUCCEEDED tidak
            | memicu penjualan tiket atau perubahan status menjadi Paid.
            |
            */

            if (
                $event !== 'payment.capture' ||
                $payment['status'] !== 'SUCCEEDED'
            ) {
                $transaction->save();

                return [
                    'success' => true,
                    'message' => 'Webhook received. No payment action taken.',
                    'http_code' => 200,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Jual tiket
            |--------------------------------------------------------------------------
            |
            | Penjualan tiket dan perubahan status transaksi dijalankan
            | dalam database transaction yang sama.
            |
            */

            $this->ticketService->sell(
                $transaction->ticket_id,
                $transaction->quantity
            );

            /*
            |--------------------------------------------------------------------------
            | Update status transaksi
            |--------------------------------------------------------------------------
            */

            $transaction->status = 'Paid';
            $transaction->paid_at = now();
            $transaction->save();

            return [
                'success' => true,
                'message' => 'Payment processed successfully.',
                'http_code' => 200,
                'transaction_id' => $transaction->id,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Kirim email e-ticket setelah pembayaran berhasil
        |--------------------------------------------------------------------------
        |
        | Email dikirim setelah database transaction selesai agar email
        | tidak terkirim jika proses penjualan tiket gagal.
        |
        */

        if (
            ! empty($result['success']) &&
            isset($result['transaction_id'])
        ) {
            $transaction = Transaction::find($result['transaction_id']);

            if ($transaction) {
                $this->emailService->sendPaid($transaction);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Response ke Xendit
        |--------------------------------------------------------------------------
        |
        | Kembalikan HTTP 200 untuk webhook yang berhasil diterima atau
        | sudah diproses. Gunakan HTTP error untuk payload tidak valid
        | atau transaksi yang tidak ditemukan.
        |
        */

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['http_code']);
    }
}
