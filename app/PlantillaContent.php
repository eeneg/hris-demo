<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class PlantillaContent extends Model
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
        'order_number'
    ];

    public function plantilla(){
        return $this->belongsTo('App\Plantilla', 'plantilla_id');
    }

    public function salaryauthorized(){
        return $this->belongsTo('App\SalaryGrade', 'salary_grade_auth_id');
    }

    public function salaryproposed(){
        return $this->belongsTo('App\SalaryGrade', 'salary_grade_prop_id');
    }

    public function position(){
        return $this->belongsTo('App\Position', 'position_id');
    }

    public function personalinformation(){
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
