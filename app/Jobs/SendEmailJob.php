<?php

namespace App\Jobs;

use App\Services\EmailRouter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $backoff = 60;

    public function __construct(
        public string $email,
        public Mailable $mailable
    ) {
    }

    public function handle(EmailRouter $emailRouter): void
    {
        try {
            $emailRouter->send(
                $this->email,
                $this->mailable
            );
        } catch (\RuntimeException $e) {

            /*
             * QUOTA FULL
             * → jangan gagal
             * → cukup lempar lagi supaya queue retry
             */
            if ($e->getMessage() === 'EMAIL_QUOTA_EXCEEDED') {
                throw $e;
            }

            /*
             * error lain tetap normal retry
             */
            throw $e;
        }
    }
}