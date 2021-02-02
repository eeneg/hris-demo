<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


class EmployeePDSEdit extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
       'employee_edit_request_id', 'model', 'field', 'oldValue', 'newValue', 'status',
    ];

    public function employeeEditRequests()
    {
        return $this->belongsTo('App\EmployeePDSEditRequest', 'employee_edit_request_id');
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
