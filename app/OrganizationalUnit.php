<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationalUnit extends Auditable
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = self::generateUuid();
        });
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->latest();
    }

    public function ascendant()
    {
    return $this->parent()->with('ascendant');
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    public function isChild()
    {
        return ! $this->isRoot();
    }

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

}
