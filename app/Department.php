<?php

namespace App;

use Webpatser\Uuid\Uuid;

class Department extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $with = [

    ];

    protected $fillable = [
        'title', 'description', 'address', 'function', 'projectactivity', 'fund', 'status'
    ];

    public function positions()
    {
        return $this->hasMany('App\Position', 'department_id');
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
