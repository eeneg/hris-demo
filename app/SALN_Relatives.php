<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SALN_Relatives extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relationship',
        'postion',
        'agency_name_and_address',
    ];

    public function saln(){
        return $this->belongsTo('App\SALN');
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
