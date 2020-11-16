<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Department extends Model
{

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $with = [
        
    ];

    protected $fillable = [
        'title', 'description', 'address', 'function', 'projectactivity', 'fund'
    ];

    public function workexperiences()
    {
        return $this->hasMany('App\Position', 'department_id');
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
