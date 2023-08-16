<?php

namespace App;

use Webpatser\Uuid\Uuid;

class SalaryGrade extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['grade', 'step', 'amount'];

    protected $appends = [
        'annual', 'monthly', 'daily'
    ];

    public function position()
    {
        return $this->hasMany('App\Position');
    }

    public function plantilla()
    {
        return $this->hasMany('App\Plantilla');
    }

    public function nosiSchedule()
    {
        return $this->hasMany('App\NosiSchedule');
    }

    public function allocation()
    {
        return $this->hasMany('App\Allocation');
    }

    public function salaryschedule()
    {
        return $this->belongsTo('App\SalarySchedule', 'salary_sched_id');
    }

    public function getAnnualAttribute()
    {
        return $this->amount * 12;
    }

    public function getMonthlyAttribute()
    {
        return $this->amount;
    }

    public function getDailyAttribute()
    {
        return $this->amount / 22;
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
