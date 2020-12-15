<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class FamilyBackground extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
                    'personal_information_id',
                    'spouseSurname',
                    'spouseFirstname',
                    'spouseMiddlename',
                    'spouseOccupation',
                    'spouseBussiness',
                    'spouseBussinessAddress',
                    'spouseTelephone',
                    'fatherSurname',
                    'fatherFirstname',
                    'fatherMiddlename',
                    'motherSurname',
                    'motherFirstname',
                    'motherMiddlename',
                    'motherMaidenName'
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
