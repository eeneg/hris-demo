<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SALN_AssetRealProperties extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'kind',
        'location',
        'assessed_value',
        'market_value',
        'acquisition_year',
        'acquisition_mode',
        'acquisition_cost',
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
