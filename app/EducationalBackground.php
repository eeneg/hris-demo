<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class EducationalBackground extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'personal_information_id',
        'elemSchoolName',
        'secSchoolName',
        'vocSchoolName',
        'collSchoolName1',
        'collSchoolName2',
        'gradSchoolName',
        'elemDegree',
        'secDegree',
        'vocDegree',
        'collDegree1',
        'collDegree2',
        'gradDegree',
        'elemYear',
        'secYear',
        'vocYear',
        'collYear1',
        'collYear2',
        'gradYear',
        'elemHighestLevel',
        'secHighestLevel',
        'vocHighestLevel',
        'collHighestLevel1',
        'collHighestLevel2',
        'gradHighestLevel',
        'elemFrom',
        'elemTo',
        'secFrom',
        'secTo',
        'vocFrom',
        'vocTo',
        'collFrom1',
        'collFrom2',
        'collTo1',
        'collTo2',
        'gradFrom',
        'gradTo',
        'elemSOA',
        'secSOA',
        'vocSOA',
        'collSOA1',
        'collSOA2',
        'gradSOA',
    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
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
