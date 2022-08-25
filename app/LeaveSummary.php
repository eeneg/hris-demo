<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class LeaveSummary extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string',
        'particulars' => 'object'
    ];

    protected $table = 'leave_summaries';

    protected $fillable = [
        'personal_information_id',
        'particulars',
        'period',
        'custom_leave',
        'vl_earned',
        'vl_withpay',
        'vl_balance',
        'vl_withoutpay',
        'sl_earned',
        'sl_balance',
        'sl_withpay',
        'sl_withoutpay',
        'remarks',
        'sort',
        'detail1',
        'detail2',
        'detail3',
    ];


    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
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
