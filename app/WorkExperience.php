<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class WorkExperience extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'personal_information_id',
        'inclusiveDateFrom',
        'inclusiveDateTo',
        'position',
        'department',
        'monthlySalary',
        'salaryGrade',
        'statusOfAppointment',
        'govService',
    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if ($model->id == null || $model->id == '') {
                $model->id = self::generateUuid();
            }
        });
    }

    public static function generateUuid()
    {
        return Uuid::generate()->string;
    }
}
