<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SALN extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable =[
        'declarant_fn',
        'declarant_ln',
        'declarant_mi',
        'declarant_address',
        'declarant_position',
        'declarant_agency',
        'declarant_office_address',
        'spouse_fn',
        'spouse_ln',
        'spouse_mi',
        'spouse_position',
        'spouse_agency',
        'spouse_agency_address',
        'real_property_subtotal',
        'personal_property_subtotal',
        'total_asset',
        'total_liability',
        'net_worth',
        'date',
        'gov_id1',
        'idNo_id1',
        'idDate_id1',
        'gov_id2',
        'idNo_id2',
        'idDate_id2'
    ];

    public function personalInformation(){
        return $this->belognsTo('App\PersonalInformation');
    }

    public function children(){
        return $this->hasMany('App\SALN_Children', 'saln_id');
    }

    public function realProperty(){
        return $this->hasMany('App\SALN_AssetRealProperties', 'saln_id');
    }

    public function personalProperty(){
        return $this->hasMany('App\SALN_AssetPersonalProperties', 'saln_id');
    }

    public function liability(){
        return $this->hasMany('App\SALN_Liabilities', 'saln_id');
    }

    public function business(){
        return $this->hasMany('App\SALN_Business', 'saln_id');
    }

    public function relative(){
        return $this->hasMany('App\SALN_Relatives', 'saln_id');
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
