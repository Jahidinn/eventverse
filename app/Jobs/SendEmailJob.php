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

    /**
     * Maximum number of attempts.
     */
    public int $tries = 3;

    /**
     * Retry delay in seconds.
     */
    public int $backoff = 60;

    public function __construct(
        public string $email,
        public Mailable $mailable
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(EmailRouter $emailRouter): void
    {
        $emailRouter->send(
            $this->email,
            $this->mailable
        );
    }
}