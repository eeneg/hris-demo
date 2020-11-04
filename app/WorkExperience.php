<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class WorkExperience extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'personal_information_id',
        'InclusiveDates',
        'Position',
        'Department',
        'MonthlySalary',
        'SalaryGrade',
        'StatusOfAppointment',
        'GovService'
    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public static function boot(){
        parent::boot();
        self::creating(function($model){
            $model->id = self::generateUuid();
        });
    }

    public static function generateUuid(){
        return Uuid::generate()->string;
    }
}
