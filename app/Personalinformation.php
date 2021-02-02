<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webpatser\Uuid\Uuid;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class PersonalInformation extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string',
    ];

    protected $table = 'personal_informations';

    protected $with = [
        'barcode', 'familybackground', 'children', 'educationalbackground', 'eligibilities',
        'otherinfos', 'workexperiences', 'voluntaryworks', 'trainingprograms', 'pdsquestion',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname', 'firstname', 'middlename', 'nameextension', 'birthdate', 'birthplace', 'sex', 'civilstatus', 'citizenship', 'height',
        'weight', 'bloodtype', 'gsis', 'pagibig', 'philhealth', 'sss', 'residentialaddress', 'zipcode1', 'telephone1', 'permanentaddress',
        'zipcode2', 'telephone2', 'email', 'cellphone', 'agencynumber', 'tin', 'picture', 'status',
    ];

    protected $guard = 'employee';

    public function barcode(){
        return $this->hasOne('App\Barcode', 'personal_information_id');
    }

    public function workexperiences()
    {
        return $this->hasMany('App\WorkExperience', 'personal_information_id');
    }

    public function children()
    {
        return $this->hasMany('App\Child', 'personal_information_id');
    }

    public function educationalbackground()
    {
        return $this->hasOne('App\EducationalBackground', 'personal_information_id');
    }

    public function eligibilities()
    {
        return $this->hasMany('App\Eligibility', 'personal_information_id');
    }

    public function familybackground()
    {
        return $this->hasOne('App\FamilyBackground', 'personal_information_id');
    }

    public function pdsquestion()
    {
        return $this->hasOne('App\PDSQuestion', 'personal_information_id');
    }

    public function voluntaryworks()
    {
        return $this->hasMany('App\VoluntaryWork', 'personal_information_id');
    }

    public function trainingprograms()
    {
        return $this->hasMany('App\TrainingProgram', 'personal_information_id');
    }

    public function otherinfos()
    {
        return $this->hasMany('App\OtherInfo', 'personal_information_id');
    }

    public function plantillacontents()
    {
        return $this->hasMany('App\PlantillaContent', 'personal_information_id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment', 'personal_information_id');
    }

    public function employeeEditRequests()
    {
        return $this->hasOne('App\EmployeePDSEditRequest');
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
