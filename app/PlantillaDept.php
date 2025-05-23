<?php

namespace App;

use Webpatser\Uuid\Uuid;

class PlantillaDept extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $with = [
        'plantilla', 'department',
    ];

    protected $fillable = [
        'plantilla_id',
        'department_id',
        'footnote',
        'order_number',
    ];

    public function plantilla()
    {
        return $this->belongsTo('App\Plantilla', 'plantilla_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = self::generateUuid();
        });
    }

    public static function generateUuid()
    {
        return Uuid::generate()->string;
    }
}
