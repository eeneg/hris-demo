<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class OrganizationalUnit extends Auditable
{
    use HasFactory, HasRecursiveRelationships;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'group',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Uuid::generate()->string;
        });
    }

    public function plantilla()
    {
        return $this->belongsTo(PlantillaContent::class, 'plantilla_contents_id')->with('personalinformation', 'position', 'position.department');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeRoot(Builder $query)
    {
        $query->whereNull('parent_id')->orWhere('parent_id', '');
    }

}
