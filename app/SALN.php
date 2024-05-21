<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SALN extends Model
{
    use HasFactory;

    public function personalInformation(){
        return $this->belognsTo('App\PersonalInformation');
    }

    public function children(){
        return $this->hasMany('App\SALN_Children');
    }

    public function realProperty(){
        return $this->hasMany('App\SALN_AssetRealProperties');
    }

    public function personalProperty(){
        return $this->hasMany('App\SALN_AssetPersonalProperties');
    }

    public function liability(){
        return $this->hasMany('App\SALN_Liabilities');
    }

    public function business(){
        return $this->hasMany('App\SALN_Business');
    }

    public function relative(){
        return $this->hasMany('App\SALN_Relatives');
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
