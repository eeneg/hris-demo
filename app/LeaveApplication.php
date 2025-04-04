<?php

namespace App;

use Webpatser\Uuid\Uuid;

class LeaveApplication extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'inclusive_dates' => 'object',
        'noted_by' => 'object',
        'noted_by_officer' => 'object',
        'governor_approval_officer' => 'object',
        'recommendation_officer' => 'object',
        'credit_officer' => 'object',
    ];

    protected $fillable = [
        'personal_information_id',
        'leave_type_id',
        'noted_by_officer', // noted by officer details (name, position, date)
        'noted_by_approved', //boolean
        'noted_disapproved_due_to', //noted_disapproved_due_to remark
        'governor_approval_officer', // governor approval officer details (name, position, date)
        'governor_approved', // boolean
        'gov_disapproved_due_to', //disapproved_due_to to gov_disapproved_due_to
        'department',
        'position',
        'salary',
        'working_days',
        'date_of_filing',
        'spent',
        'spent_specified', //spent_spec to spent_specified
        'commutation',
        'inclusive_dates',
        'credit_as_of',
        'vacation_balance',
        'vacation_less',
        'sick_balance',
        'sick_less',
        'credit_officer',
        'recommendation_officer',
        'recommendation_approved', //string to boolean
        'recommendation_disapproved_due_to',//recommendation_remark_approved to recommendation_remark
        'leave_type_others',
        'state',   //status to state (final or draft)
        'days_with_pay',
        'days_without_pay',
        'approved_for_others',
        'application_stage', //stage_status to application_stage
    ];

    protected $with = [

    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }


    public function leavetype()
    {
        return $this->belongsTo('App\LeaveType', 'leave_type_id');
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
