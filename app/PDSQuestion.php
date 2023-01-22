<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class PDSQuestion extends Model
{
    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'personal_information_id',
        'q34a',
        'q34b',
        'q34bdetails',
        'q35a',
        'q35adetails',
        'q35b',
        'q35bdatefiled',
        'q35bcasestatus',
        'q36a',
        'q36adetails',
        'q37a',
        'q37adetails',
        'q38a',
        'q38adetails',
        'q38b',
        'q38bdetails',
        'q39a',
        'q39adetails',
        'q40a',
        'q40adetails',
        'q40b',
        'q40bdetails',
        'q40c',
        'q40cdetails',
        'refname1',
        'refaddress1',
        'reftelephone1',
        'refname2',
        'refaddress2',
        'reftelephone2',
        'refname3',
        'refaddress3',
        'reftelephone3',
        'govid',
        'idnumber',
        'dateissued',
    ];

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
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
