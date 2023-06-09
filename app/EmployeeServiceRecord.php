<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class EmployeeServiceRecord extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'service_record_id',
        'from',
        'to',
        'position',
        'status',
        'salary',
        'station',
        'branch',
        'pay',
        'remark',
        'date',
        'cause',
        'orderNo'
    ];

    public function servicerecord()
    {
        return $this->belongsTo('App\ServiceRecord', 'service_record_id');
    }

    public function getMiddleinitialAttribute()
    {
        return $this->middlename ? $this->middlename[0] : '';
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
