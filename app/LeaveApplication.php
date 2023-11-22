<?php

namespace App;

use Webpatser\Uuid\Uuid;

class LeaveApplication extends Auditable
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'personal_information_id',
        'personal_information_id_7b',
        'personal_information_id_7c',
        'personal_information_id_7d',
        'recommendation_officer_id',
        'noted_by_id',
        'governor_id',
        'leave_type_id',
        'date_of_filing',
        'working_days',
        'spent',
        'spent_spec',
        'commutation',
        'from',
        'to',
        'credit_as_of',
        'vacation_balance',
        'sick_balance',
        'vacation_less',
        'sick_less',
        'recommendation',
        'days_with_pay',
        'days_without_pay',
        'others',
        'disapproved_due_to',
        'status',
        'stage_status',
        'recommendation_status',
        'recommendation_remark_approved',
        'recommendation_remark_disapproved',
    ];

    protected $with = [

    ];

    public static function leaveapplications($plantilla, $department_id, $data)
    {
        $allEmployees = [];

        // hrmo head
        if ($data['role'] == 'Office Head' && $data['dept']['title'] == 'PHRMO') {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->whereNotNull('plantilla_contents.personal_information_id')
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->where(function ($query) use ($data) {
                    $query->where('departments.id', '!=', $data['dept']['id'])
                    ->where('leave_applications.stage_status', '!=', 'Pending Recommendation')
                    ->where('leave_applications.stage_status', '!=', null)
                    ->where('leave_applications.stage_status', '!=', '');
                })
                ->orderBy('created_at', 'desc')
                ->orWhere('departments.id', $data['dept']['id'])->paginate(20);

        //PGO EXECUTIVE head
        } else if ($data['role'] == 'Office Head' && $data['dept']['title'] == 'PGO-Local Chief Executive') {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
                ->whereNotNull('plantilla_contents.personal_information_id')
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->where(function ($query) use ($data) {
                    $query->where('departments.id', '!=', $data['dept']['id'])
                    ->where('leave_applications.stage_status', '!=', 'Pending Recommendation')
                    ->where('leave_applications.stage_status', '!=', 'Pending Noted By')
                    ->where('leave_applications.stage_status', '!=', 'Approved by the HR Head')
                    ->where('leave_applications.stage_status', '!=', null)
                    ->where('leave_applications.stage_status', '!=', '');
                })
                ->orWhere('departments.id', $data['dept']['id'])
                ->orWhere('reappointments.assigned_to', $department_id)
                ->orderBy('created_at', 'desc')
                ->paginate(20);

        }else if($department_id != '' && $department_id != null){

            $allEmployees = LeaveApplication::select('leave_applications.*',
            'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
            'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->where('departments.id', $department_id)
            ->orWhere('reappointments.assigned_to', $department_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);


        } else {

            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->whereNotNull('plantilla_contents.personal_information_id')
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->orderBy('created_at', 'desc')
                ->paginate(20);

        }

        return $allEmployees;
    }

    public static function getAllLeave($plantilla, $department_id)
    {
        if ($department_id != null && $department_id != '') {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->where('departments.id', $department_id)
            ->orWhere('reappointments.assigned_to', $department_id)
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return $allEmployees;
    }

    public static function searchLeaveApplication($plantilla, $department_id, $data)
    {
        if ($department_id != null && $department_id != '') {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->where('departments.id', $department_id)
            ->orWhere('reappointments.assigned_to', $department_id)
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($data) {
                if($data['personal_information_id'])
                {
                    $query->where('leave_applications.personal_information_id', $data['personal_information_id']);
                }

                if($data['date_of_filing'])
                {
                    $query->where('leave_applications.date_of_filing', $data['date_of_filing']);
                }

                if($data['leave_type_id'])
                {
                    $query->where('leave_applications.leave_type_id', $data['leave_type_id']);
                }

                if($data['stage_status'])
                {
                    $query->where('leave_applications.stage_status', $data['stage_status']);
                }

                if($data['status'])
                {
                    $query->where('leave_applications.status', $data['status']);
                }
            })
            ->get();
        } else {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($data) {
                if($data['personal_information_id'])
                {
                    $query->where('leave_applications.personal_information_id', $data['personal_information_id']);
                }

                if($data['date_of_filing'])
                {
                    $query->where('leave_applications.date_of_filing', $data['date_of_filing']);
                }

                if($data['leave_type_id'])
                {
                    $query->where('leave_applications.leave_type_id', $data['leave_type_id']);
                }

                if($data['stage_status'])
                {
                    $query->where('leave_applications.stage_status', $data['stage_status']);
                }

                if($data['status'])
                {
                    $query->where('leave_applications.status', $data['status']);
                }
            })
            ->get();
        }

        return $allEmployees;
    }

    public function personalinformation()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id');
    }

    public function personalinformation_7b()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id_7b');
    }

    public function personalinformation_7c()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id_7c');
    }

    public function personalinformation_7d()
    {
        return $this->belongsTo('App\PersonalInformation', 'personal_information_id_7d');
    }

    public function leavetype()
    {
        return $this->belongsTo('App\LeaveType', 'leave_type_id');
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
