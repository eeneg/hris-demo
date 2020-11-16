<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $primaryKey = 'PK_PositionId';

    protected $fillable = ['Title'];

    public function posPersonalInformation()
    {
        return $this->hasMany('App\PersonalInformation');
    }

    public function posPlantilla()
    {
        return $this->hasMany('App\Plantilla');
    }

    public function posSalarygrade()
    {
        return $this->hasOne('App\SalaryGrade');
    }

    public function posDepartment()
    {
        return $this->hasOne('App\Department');
    }

    public function posAllocation()
    {
        return $this->hasMany('App\Allocation');
    }
}
