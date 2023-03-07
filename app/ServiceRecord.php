<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


class ServiceRecord extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'personal_information_id',
        'ORNo',
        'dateCertified',
        'dateIssued',
        'certifier_id',
        'amount',
    ];

    protected $table = 'service_records';

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public function employeeservicerecord()
    {
        return $this->hasMany('App\EmployeeServiceRecord', 'service_record_id')->orderBy('orderNo');
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
