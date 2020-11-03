<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Personalinformation extends Model
{
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname', 'firstname', 'middlename', 'nameextension', 'birthdate', 'birthplace', 'sex', 'civilstatus', 'citizenship', 'height',
        'weight', 'bloodtype', 'gsis', 'pagibig', 'philhealth', 'sss', 'residentialaddress', 'zipcode1', 'telephone1', 'permanentAddress',
        'zipcode2', 'telephone2', 'email', 'cellphone', 'agencynumber', 'tin', 'picture', 'status'
    ];

    public function barcode(){
        return $this->hasOne('App\Barcode', 'personalinformation_id');
    }

    public static function boot(){
        parent::boot();
        self::creating(function($model){
            $model->id = self::generateUuid();
        });
    }

    public static function generateUuid(){
        return Uuid::generate()->string;
    }
}
