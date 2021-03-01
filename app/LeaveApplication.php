<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class LeaveApplication extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [ 
        'personal_information_id',
        'leave_type_id',
        'date_of_filing',
        'working_days',
        'spent',
        'spent_spec',
        'commutation',
        'from',
        'to',
        'credit_as_of',
        'vacation_balance',
        'sick_balance',
        'vacation_less',
        'sick_less',
        'recommendation',
        'days_with_pay',
        'days_without_pay',
        'others',
        'disapproved_due_to',
        'status'
    ];

    protected $with = [
        'personalinformation',
        'leavetype',
        'personalinformation_7b',
        'personalinformation_7c',
        'personalinformation_7d'
    ];

    public function personalinformation() {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public function personalinformation_7b() {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id_7b');
    }

    public function personalinformation_7c() {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id_7c');
    }

    public function personalinformation_7d() {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id_7d');
    }

    public function leavetype() {
        return $this->belongsTo('App\LeaveType', 'leave_type_id');
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
