<?php

namespace App;

use Webpatser\Uuid\Uuid;

class QS extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'q_s';

    protected $fillable = ['position_id', 'sg', 'education', 'experience', 'training', 'eligibility'];

    protected $with = [
        // 'position'
    ];

    public function position()
    {
        return $this->belongsTo('App\Position', 'position_id');
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
