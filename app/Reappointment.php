<?php

namespace App;

use Webpatser\Uuid\Uuid;

class Reappointment extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'reappointments';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'id', 'personal_information_id', 'assigned_from', 'assigned_to', 'date',
    ];

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
