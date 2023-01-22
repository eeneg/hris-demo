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
        'particulars' => 'object',
        'period' => 'object',
    ];

    protected $attributes = [
        'period' => [
            'mode' => null,
            'data' => null,
        ],
        'particulars' => [
            'leave_type' => null,
            'count' => null,
            'days' => null,
            'hours' => null,
            'mins' => null,
        ],
    ];

    protected $table = 'leave_summaries';

    protected $fillable = [
        'personal_information_id',
        'particulars',
        'period',
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
        'foreign_travel',
    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public static function countCustomLeave($data)
    {
        $leave = collect($data)
            ->groupBy('year')
            ->map(function ($leave) {
                return $leave->groupBy('leave_type')->map(function ($data) {
                    return collect($data)->sum('days');
                });
            })
            ->toArray();

        return $leave;
    }

    public static function violationCounter($tardy)
    {
        $count = collect($tardy)
            ->groupBy('year')
            ->map(function ($leave) {
                return $leave->groupBy('month')->map(function ($data) {
                    return $data->groupBy('type')->map(function ($value) {
                        return collect($value)->sum('count');
                    });
                });
            })->toArray();

        ksort($count);

        return $count;
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
