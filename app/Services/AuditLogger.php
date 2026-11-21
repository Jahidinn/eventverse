<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AuditLogger
{
    public function log(
        string $action,
        string $description,
        ?Model $subject = null,
        array $meta = [],
        ?int $userId = null
    ): void {
        try {
            $request = request();

            AuditLog::create([
                'user_id' => $userId ?? auth()->id(),
                'action' => $action,
                'description' => $description,
                'subject_type' => $subject ? $subject->getMorphClass() : null,
                'subject_id' => $subject?->getKey(),
                'meta' => $meta,
                'ip_address' => $request?->ip(),
                'user_agent' => substr((string) $request?->userAgent(), 0, 2000),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Audit log failed: ' . $exception->getMessage(), [
                'action' => $action,
            ]);
        }
    }
}
