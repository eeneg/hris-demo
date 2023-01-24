<?php

namespace App;

use Illuminate\Support\Str;
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
        return $this->morphTo();
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        return $this->morphTo();
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
        return Str::headline(class_basename($this->auditable_type));
    }

    public function getModifiedAttribute()
    {
        return $this->getModified(true);
    }
}
