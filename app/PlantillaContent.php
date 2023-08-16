<?php

namespace App;

use Webpatser\Uuid\Uuid;

class PlantillaContent extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'plantilla_contents';

    protected $with = [
        'plantilla', 'salaryschedule', 'salaryauthorized', 'salaryproposed', 'position', 'vacancysalary',
    ];

    protected $fillable = [
        'plantilla_id',
        'salary_grade_auth_id',
        'salary_grade_prop_id',
        'position_id',
        'personal_information_id',
        'old_number',
        'new_number',
        'difference_amount',
        'working_time',
        'level',
        'original_appointment',
        'last_promotion',
        'appointment_status',
        'order_number',
        'csc_level'
    ];

    protected $appends = [
        'annual',
        'monthly',
        'daily',
    ];

    public function plantilla()
    {
        return $this->belongsTo('App\Plantilla', 'plantilla_id');
    }

    public function salaryschedule()
    {
        return $this->hasOneThrough('App\SalarySchedule', 'App\SalaryGrade', 'plantilla_contents.id', 'id', null, 'salary_sched_id')->join($this->getTable(), function ($join) {
            $join->on('salary_grades.id', $this->getTable().'.salary_grade_prop_id');
        });
    }

    public function vacancysalary()
    {
        // $query = $this->hasOneThrough('App\SalaryGrade', 'App\SalarySchedule', 'plantilla_contents.id', 'salary_schedules.id', 'third', 'salary_grades.salary_sched_id')->join($this->getTable(), function ($join) {
        //     $join->on('salary_grades.id', $this->getTable().'.salary_grade_prop_id');
        // })->where('salary_grades.grade', 1);

        // return $query;

        return $this->belongsTo('App\SalaryGrade', 'salary_grade_prop_id');

    }

    public function salaryauthorized()
    {
        return $this->belongsTo('App\SalaryGrade', 'salary_grade_auth_id');
    }

    public function salaryproposed()
    {
        return $this->belongsTo('App\SalaryGrade', 'salary_grade_prop_id');
    }

    public function position()
    {
        return $this->belongsTo('App\Position', 'position_id');
    }

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public function getVacantAttribute()
    {
        return $this->personsal_information_id === null;
    }

    public function getAnnualAttribute()
    {
        return $this->salaryproposed?->annual / ($this->working_time == 'Part-time' ? 2 : 1);
    }

    public function getMonthlyAttribute()
    {
        return $this->salaryproposed?->monthly / ($this->working_time == 'Part-time' ? 2 : 1);
    }

    public function getDailyAttribute()
    {
        return $this->salaryproposed?->daily / ($this->working_time == 'Part-time' ? 2 : 1);
    }

    public function scopeCurrent($query)
    {
        $query->whereHas('plantilla', function ($query) {
            $query->where('year', function ($query) {
                $query->select('value')->where('title', 'Default Plantilla')->from('settings');
            });
        });
    }

    public function scopeVacant($query)
    {
        $query->whereNull('personal_information_id');
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
