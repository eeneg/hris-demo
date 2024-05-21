<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Webpatser\Uuid\Uuid;

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
        'barcode', 'familybackground', 'residentialaddresstable', 'permanentaddresstable', 'children', 'educationalbackground', 'eligibilities',
        'otherinfos', 'workexperiences', 'voluntaryworks', 'trainingprograms', 'pdsquestion'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname', 'firstname', 'middlename', 'nameextension', 'birthdate', 'birthplace', 'sex', 'civilstatus', 'citizenship', 'height',
        'weight', 'bloodtype', 'gsis', 'pagibig', 'philhealth', 'sss', 'residentialaddress', 'zipcode1', 'telephone1', 'permanentaddress',
        'zipcode2', 'telephone2', 'email', 'cellphone', 'agencynumber', 'tin', 'picture', 'status', 'retirement_date'
    ];

    protected $appends = [
        'fullName',
    ];

    protected $guard = 'employee';

    public function barcode()
    {
        return $this->hasOne('App\Barcode', 'personal_information_id');
    }

    public function benefitschedule()
    {
        return $this->hasOne('App\BenefitSchedule', 'personal_information_id');
    }

    public function workexperiences()
    {
        return $this->hasMany('App\WorkExperience', 'personal_information_id')->orderBy('orderNo');
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
        return $this->hasMany('App\VoluntaryWork', 'personal_information_id')->orderBy('orderNo');
    }

    public function trainingprograms()
    {
        return $this->hasMany('App\TrainingProgram', 'personal_information_id')->orderBy('orderNo');
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
        return $this->hasMany('App\EmployeePDSEditRequest');
    }

    public function leavecredit()
    {
        return $this->hasMany('App\LeaveCredit', 'personal_information_id');
    }

    public function leavesummary()
    {
        return $this->hasMany('App\LeaveSummary', 'personal_information_id');
    }

    public function servicerecord()
    {
        return $this->hasOne('App\ServiceRecord', 'personal_information_id');
    }

    public function residentialaddresstable()
    {
        return $this->hasOne('App\ResidentialAddress', 'personal_information_id');
    }

    public function permanentaddresstable()
    {
        return $this->hasOne('App\PermanentAddress', 'personal_information_id');
    }

    public function saln(){
        return $this->hasOne('App\SALN');
    }

    public function getlatestplantillacontent()
    {
        return $this->plantillacontents()->latest()->first();
    }

    public function getFullNameAttribute()
    {
        return trim(
            preg_replace('/\s+/', ' ',
                "$this->surname, $this->firstname".
                ($this->middleinitial ? " $this->middleinitial." : '').
                ($this->nameextension ? ", $this->nameextension" : '')
            )
        );
    }

    public function getFullNameAttributeProperFormat()
    {
        return trim(
            preg_replace('/\s+/', ' ',
                "$this->firstname" . " " . ($this->middleinitial ? " $this->middleinitial." : '') . " " . "$this->surname" . ($this->nameextension ? ", $this->nameextension" : '')
            )
        );
    }

    public function getMiddleinitialAttribute()
    {
        return $this->middlename ? $this->middlename[0] : '';
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
