<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Department extends Model
{

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $with = [

    ];

    protected $fillable = [
        'title', 'description', 'address', 'function', 'projectactivity', 'fund'
    ];

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
