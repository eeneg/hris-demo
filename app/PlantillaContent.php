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
        'plantilla', 'salaryauthorized', 'salaryproposed', 'position'
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

    public function plantilla()
    {
        return $this->belongsTo('App\Plantilla', 'plantilla_id');
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

    public function getPreviousStep() {
        if ($this->salaryproposed) {
            return \App\SalaryGrade::where('salary_sched_id', $this->plantilla->salary_schedule_prop_id)
                ->where('grade', $this->salaryproposed->grade)
                ->where('step', $this->salaryproposed->step - 1)
                ->first();
        }
        return null;
    }

    public function getNextStep() {
        if ($this->salaryproposed) {
            return \App\SalaryGrade::where('salary_sched_id', $this->plantilla->salary_schedule_prop_id)
                ->where('grade', $this->salaryproposed->grade)
                ->where('step', $this->salaryproposed->step + 1)
                ->first();
        }
        return null;
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
