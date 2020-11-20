<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Plantilla extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [ 'year', 'date_prepared', 'date_approved' ];

    public function plantilla_contents()
    {
        return $this->hasMany('App\PlantillaContent', 'plantilla_id');
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
