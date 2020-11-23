<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SalaryGrade extends Model
{

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = ['tranche', 'grade', 'tranche', 'step', 'amount', 'effective_date'];

    public function position()
    {
        return $this->hasMany('App\Position');
    }

    public function plantilla()
    {
        return $this->hasMany('App\Plantilla');
    }

    public function nosiSchedule()
    {
        return $this->hasMany('App\NosiSchedule');
    }

    public function allocation()
    {
        return $this->hasMany('App\Allocation');
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
