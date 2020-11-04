<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class EducationalBackground extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
                    'personal_information_id',
                    'ElemSchoolName',
                    'SecSchoolName',
                    'VocSchoolName',
                    'CollSchoolName1',
                    'CollSchoolName2',
                    'GradSchoolName',
                    'ElemDegree',
                    'SecDegree',
                    'VocDegree',
                    'CollDegree1',
                    'CollDegree2',
                    'GradDegree',
                    'ElemYear',
                    'SecYear',
                    'VocYear',
                    'CollYear1',
                    'CollYear2',
                    'GradYear',
                    'ElemHighestLevel',
                    'SecHighestLevel',
                    'VocHighestLevel',
                    'CollHighestLevel1',
                    'CollHighestLevel2',
                    'GradHighestLevel',
                    'ElemFrom',
                    'ElemTo',
                    'SecFrom',
                    'SecTo',
                    'VocFrom',
                    'VocTo',
                    'CollFrom1',
                    'CollFrom2',
                    'CollTo1',
                    'CollTo2',
                    'GradFrom',
                    'GradTo',
                    'ElemSOA',
                    'SecSOA',
                    'VocSOA',
                    'CollSOA1',
                    'CollSOA2',
                    'GradSOA',
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
