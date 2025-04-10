<?php

namespace App;

use Webpatser\Uuid\Uuid;

class Reappointment extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'reappointments';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'id', 'personal_information_id', 'assigned_from', 'assigned_to', 'type', 'position', 'duties', 'effectivity_date', 'termination_date'
    ];

    public function personalinformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'personal_information_id', 'id');
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
