<?php

namespace App;

use Webpatser\Uuid\Uuid;

class SalarySchedule extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['tranche', 'effective_date'];

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

    public function salarygrades()
    {
        return $this->hasMany('App\SalaryGrade', 'salary_sched_id');
    }
}
