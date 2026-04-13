<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            static::audit('created', $model);
        });

        static::updated(function ($model) {
            static::audit('updated', $model);
        });

        static::deleted(function ($model) {
            static::audit('deleted', $model);
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
            
            // Si no hay cambios reales (solo timestamps), omitir
            if (count($new) <= 1 && (isset($new['updated_at']) || isset($new['created_at']))) {
                return;
            }
        } elseif ($event === 'deleted') {
            $old = $model->getAttributes();
        }

        try {
            $user = Auth::user();
            Audit::create([
                'user_id' => $user->id ?? null,
                'user_name' => $user->name ?? null,
                'user_email' => $user->email ?? null,
                'event' => $event,
                'auditable_type' => get_class($model),
                'auditable_id' => $model->id ?? ($model->numero_identificacion_estudiante ?? null), // Handle custom PKs if any
                'old_values' => json_encode($old),
                'new_values' => json_encode($new),
                'url' => request()->fullUrl(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Silently fail auditing to avoid breaking the application if audits fail
            \Log::error('Auditing error: ' . $e->getMessage());
        }
    }
}
