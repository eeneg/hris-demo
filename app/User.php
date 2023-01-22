<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Redactors\LeftRedactor;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable implements Auditable
{
    use AuditableTrait;
    use HasApiTokens, Notifiable;

    public $incrementing = false;

    protected $auditStrict = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'landline', 'role', 'avatar', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'userassignment',
    ];

    protected $auditExlude = [
        'remember_token',
    ];

    protected $attributeModifiers = [
        'password' => LeftRedactor::class,
    ];

    public function userassignment()
    {
        return $this->hasOne('App\UserAssignment', 'user_id');
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
