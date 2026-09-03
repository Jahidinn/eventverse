<?php

namespace App\Services;

use App\Services\TicketService;
use App\Services\EmailService;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        */

        $callbackToken = $request->header('x-callback-token');

        if (
            ! $callbackToken ||
            ! hash_equals(
                config('xendit.webhook_token'),
                $callbackToken
            )
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
        */

        $payment = $request->all();

        /*
        |--------------------------------------------------------------------------
        | Validasi payload webhook
        |--------------------------------------------------------------------------
        */

        if (
            empty($payment['payment_request_id']) ||
            empty($payment['status'])
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
        | payment_reference menyimpan payment_request_id dari Xendit.
        |
        */

        $transaction = Transaction::where(
            'payment_reference',
            $payment['payment_request_id']
        )->first();

        if (! $transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Periksa status transaksi
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->status !== 'Paid' &&
            (
                $transaction->status === 'Expired' ||
                (
                    $transaction->expired_at &&
                    $transaction->expired_at->isPast()
                )
            )
        ) {
            return response()->json([
                'success' => true,
                'message' => 'Transaction already expired.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan payload webhook terbaru
        |--------------------------------------------------------------------------
        |
        | payment_payload menyimpan payload/status terbaru
        | yang diterima dari Xendit.
        |
        */

        $transaction->update([
            'payment_payload' => $payment,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Proses hanya jika pembayaran berhasil
        |--------------------------------------------------------------------------
        */

        if ($payment['status'] !== 'SUCCEEDED') {
            return response()->json([
                'success' => true,
                'message' => 'Webhook received.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cegah transaksi diproses lebih dari satu kali
        |--------------------------------------------------------------------------
        |
        | Xendit dapat mengirim webhook lebih dari satu kali.
        | Jika transaksi sudah Paid, jangan menjual tiket
        | atau mengirim email e-ticket lagi.
        |
        */

        if ($transaction->status === 'Paid') {
            return response()->json([
                'success' => true,
                'message' => 'Transaction already paid.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Proses pembayaran
        |--------------------------------------------------------------------------
        |
        | Sell ticket dan update status transaksi dilakukan
        | dalam satu database transaction.
        |
        */

        DB::transaction(function () use ($transaction) {

            /*
            |--------------------------------------------------------------------------
            | Jual tiket
            |--------------------------------------------------------------------------
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

            $transaction->update([
                'status'  => 'Paid',
                'paid_at' => now(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Kirim email e-ticket
        |--------------------------------------------------------------------------
        */

        $this->emailService->sendPaid($transaction);

        /*
        |--------------------------------------------------------------------------
        | Response ke Xendit
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
        ]);
    }
}