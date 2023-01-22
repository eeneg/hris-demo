<?php

namespace App;

use OwenIt\Auditing\Models\Audit as AuditModel;

class Audit extends AuditModel
{
    protected $appends = [
        'audited', 'modified'
    ];

    /**
     * {@inheritdoc}
     */
    public function auditable()
    {
        return $this->morphTo(null, 'auditable_type', 'auditable_id');
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        return $this->morphTo(null, 'user_type', 'user_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = self::generateUuid();
        });
    }

    public function getAuditedAttribute()
    {
        return (new \ReflectionClass($this->auditable_type))->getShortName();
    }

    public function getModifiedAttribute()
    {
        return $this->getModified(true);
    }
}
