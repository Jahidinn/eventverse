<?php

namespace App\Services;

use App\Models\EmailProvider;
use App\Models\EmailProviderUsage;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailRouter
{
    public function send(
        string $email,
        Mailable $mailable
    ): void {
        $provider = $this->reserveProvider();

        /*
         * Shared SMTP uses Laravel's default mail flow.
         * This keeps the existing SMTP behaviour unchanged.
         */
        if ($provider->driver === 'smtp') {
            Mail::to($email)
                ->send($mailable);

            return;
        }

        /*
         * Other providers, such as SES, use their
         * explicitly configured Laravel mailer.
         */
        Mail::mailer($provider->driver)
            ->to($email)
            ->send($mailable);
    }

    protected function reserveProvider(): EmailProvider
    {
        return DB::transaction(function () {
            $providers = EmailProvider::query()
                ->where('is_active', true)
                ->orderBy('priority')
                ->get();

            $windowStart = now()->startOfHour();

            foreach ($providers as $provider) {

                if ($provider->hourly_limit === null) {
                    return $provider;
                }

                EmailProviderUsage::query()->insertOrIgnore([
                    'provider_id' => $provider->id,
                    'window_start' => $windowStart,
                    'usage_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $usage = EmailProviderUsage::query()
                    ->where('provider_id', $provider->id)
                    ->where('window_start', $windowStart)
                    ->lockForUpdate()
                    ->first();

                if (! $usage) {
                    continue;
                }

                if ($usage->usage_count >= $provider->hourly_limit) {
                    continue;
                }

                $usage->increment('usage_count');

                return $provider;
            }

            throw new \RuntimeException(
                'No available email provider.'
            );
        });
    }
}