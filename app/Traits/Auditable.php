<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Services\AuditService;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            if ($model instanceof ActivityLog) return;
            AuditService::log('created', $model, [], $model->getAttributes());
        });

        static::updated(function ($model) {
            if ($model instanceof ActivityLog) return;
            AuditService::log('updated', $model, $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function ($model) {
            if ($model instanceof ActivityLog) return;
            AuditService::log('deleted', $model, $model->getAttributes(), []);
        });
    }
}