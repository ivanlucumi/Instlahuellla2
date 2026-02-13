<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::audit('created', $model);
        });

        static::updated(function ($model) {
            self::audit('updated', $model);
        });

        static::deleted(function ($model) {
            self::audit('deleted', $model);
        });
    }

    protected static function audit($event, $model)
    {
        $old = [];
        $new = [];

        if ($event === 'created') {
            $new = $model->getAttributes();
        } elseif ($event === 'updated') {
            $old = $model->getOriginal();
            $new = $model->getChanges();
        } elseif ($event === 'deleted') {
            $old = $model->getAttributes();
        }

        Audit::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'old_values' => json_encode($old),
            'new_values' => json_encode($new),
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
