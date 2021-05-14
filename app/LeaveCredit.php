<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


class LeaveCredit extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string',
    ];

    protected $table = 'leave_credits';

    protected $fillable = [
        'personal_information_id',
        'leave_type_id',
        'balance',
        'detail1',
        'detail2',
        'created_at'
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
