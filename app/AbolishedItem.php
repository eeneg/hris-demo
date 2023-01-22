<?php

namespace App;

use Webpatser\Uuid\Uuid;

class AbolishedItem extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $with = [
        'plantillacontent', 'salarygrade',
    ];

    protected $fillable = [
        'plantilla_content_id',
        'salary_grade_prop_id',
        'new_number',
    ];

    public function plantillacontent()
    {
        return $this->belongsTo('App\PlantillaContent', 'plantilla_content_id');
    }

    public function salarygrade()
    {
        return $this->belongsTo('App\SalaryGrade', 'salary_grade_prop_id');
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
