<?php

namespace App;

use Webpatser\Uuid\Uuid;

class LeaveType extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'abbreviation', 'max_duration', 'status'];

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
