<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Appointment extends Model
{

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
    ];

    protected $table = 'appointment_records';

    protected $fillable = [ 'personal_information_id',
                            'position_id',
                            'salary_grade_id',
                            'status',
                            'agency',
                            'nature_of_appointment',
                            'previous_employee',
                            'previous_status',
                            'itemno',
                            'page',
                            'reckoning_date'
    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public function position()
    {
        return $this->belongsTo('App\Position', 'position_id');
    }

    public function salarygrade()
    {
        return $this->belongsTo('App\SalaryGrade', 'salary_grade_id');
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
