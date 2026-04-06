<?php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log(
        string  $event,
        ?object $model,
        array   $oldValues,
        array   $newValues,
        ?string $userId = null 
    ): void {
        ActivityLog::create([
            'user_id'        => $userId ?? auth()->id(),
            'event'          => $event,
            'auditable_type' => $model ? get_class($model) : null,
            'auditable_id'   => $model?->getKey(),
            'old_values'     => $oldValues,
            'new_values'     => $newValues,
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }

    public static function logAuth(string $event, ?string $userId = null): void
    {
        ActivityLog::create([
            'user_id'        => $userId,
            'event'          => $event,
            'auditable_type' => null,
            'auditable_id'   => null,
            'old_values'     => [],
            'new_values'     => [],
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }
}