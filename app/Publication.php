<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Publication extends Auditable
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'office',
        'position',
        'address',
        'closing_date',
        'file',
    ];

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

    public function scopeCurrent(Builder $query): void
    {
        $query->whereHas('plantilla', function ($query) {
            $query->where('year', function ($query) {
                $query->select('value')->where('title', 'Default Plantilla')->from('settings');
            });
        });
    }

    public function contents()
    {
        return $this->hasMany(PublicationContent::class);
    }
}
