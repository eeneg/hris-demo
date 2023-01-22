<?php

namespace App;

use Webpatser\Uuid\Uuid;

class Plantilla extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $with = ['salaryproposedschedule', 'salaryauthorizedschedule'];

    protected $fillable = ['year', 'salary_schedule_auth_id', 'salary_schedule_prop_id'];

    public function plantilla_contents()
    {
        return $this->hasMany('App\PlantillaContent', 'plantilla_id');
    }

    public function salaryproposedschedule()
    {
        return $this->belongsTo('App\SalarySchedule', 'salary_schedule_prop_id');
    }

    public function salaryauthorizedschedule()
    {
        return $this->belongsTo('App\SalarySchedule', 'salary_schedule_auth_id');
    }

    public function plantilla_depts()
    {
        return $this->hasMany('App\PlantillaDept', 'plantilla_id');
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
