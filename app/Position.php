<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Position extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [ 'department_id', 'title' ];

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
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
