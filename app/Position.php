<?php

namespace App;

use Webpatser\Uuid\Uuid;

class Position extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'positions';

    protected $fillable = ['department_id', 'title'];

    protected $with = [
        'department',
    ];

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
