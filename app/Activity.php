<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Activity extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'info',
        'time',
        'title',
    ];

    protected $casts = [
        'time' => 'date:Y-m-d H:i',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Uuid::generate()->string;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
