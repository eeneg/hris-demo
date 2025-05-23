<?php

namespace App\Http\Controllers\Api;

use App\Events\PersonalInfoRegistered;
use App\Events\PersonalInfoUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeAppointmentListResource;
use App\Http\Resources\EmployeesListResource;
use App\PersonalInformation;
use App\Plantilla;
use App\Reappointment;
use App\Setting;
use App\UserAssignment;
use App\PlantillaContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PersonalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        if ($search = \Request::get('query')) {
            if (Gate::allows('isOfficeHead') || Gate::allows('isOfficeUser')) {
                $department_id = UserAssignment::where('user_id', Auth::user()->id)->first()->department_id;
                $personalinformations = PersonalInformation::with(['plantillacontents' => function ($query) use ($plantilla) {
                    $query->where('plantilla_id', $plantilla->id);
                }])->whereHas('plantillacontents', function ($query) use ($department_id) {
                    $query->whereHas('position', function ($query2) use ($department_id) {
                        $query2->where('department_id', $department_id);
                    });
                })->where(function ($query) use ($search) {
                    $query->where('surname', 'LIKE', '%'.$search.'%')
                            ->orWhere('firstname', 'LIKE', '%'.$search.'%')
                            ->orWhere('middlename', 'LIKE', '%'.$search.'%')
                            ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$search.'%')
                            ->orWhere('status', 'LIKE', '%'.$search.'%');
                })->orderBy('surname')->paginate(20);
            } else {
                $personalinformations = PersonalInformation::with('plantillacontents')
                ->where(function ($query) use ($search) {
                    $query->where('surname', 'LIKE', '%'.$search.'%')
                            ->orWhere('firstname', 'LIKE', '%'.$search.'%')
                            ->orWhere('middlename', 'LIKE', '%'.$search.'%')
                            ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$search.'%')
                            ->orWhere('status', 'LIKE', '%'.$search.'%');
                })->orderBy('surname')->paginate(20);
            }
        } else {
            if (Gate::allows('isOfficeHead') || Gate::allows('isOfficeUser')) {
                $department_id = UserAssignment::where('user_id', Auth::user()->id)->first()->department_id;
                $personalinformations = PersonalInformation::with(['plantillacontents' => function ($query) use ($plantilla) {
                    $query->where('plantilla_id', $plantilla->id);
                }])->whereHas('plantillacontents', function ($query) use ($department_id) {
                    $query->whereHas('position', function ($query2) use ($department_id) {
                        $query2->where('department_id', $department_id);
                    });
                })->orderBy('surname')->paginate(20);
            } else {
                $personalinformations = PersonalInformation::with(['plantillacontents' => function ($query) use ($plantilla) {
                    $query->where('plantilla_id', $plantilla->id);
                }])->orderBy('surname')->paginate(20);
            }
        }

        return new EmployeesListResource($personalinformations);
    }

    public function listCurrent()
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();

        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        return PersonalInformation::whereHas('plantillacontents', fn ($q) => $q->where('plantilla_id', $plantilla->id))
            ->withOnly([])
            ->orderBy('surname')
            ->orderBy('firstname')
            ->orderBy('middlename')
            ->get(['id', 'firstname', 'middlename', 'surname', 'nameextension'])
            ->map(function ($employee) {
                return [
                    ...$employee->toArray(),
                    'name' => $employee->fullName,
                ];
            });
    }

    public function forleave(Request $request)
    {
        $department_id = Auth::user()->role == 'Office User' || Auth::user()->role == 'Office Head' ? UserAssignment::where('user_id', Auth::user()->id)->first()->department_id : '';
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        @$title = Auth::user()->userassignment->department->title;


        if($department_id == null || (Auth::user()->role == 'Office Head' && $title == 'PHRMO') || (Auth::user()->role == 'Office Head' && $title == 'PGO-Local Chief Executive') || Auth::user()->role == 'Author'){

            $allEmployees = DB::select("SELECT DISTINCT personal_informations.`id` as `id`,
                CONCAT(personal_informations.`surname`, ', ', personal_informations.`firstname`, ' ', IFNULL(personal_informations.`nameextension`, ''), ' ', IFNULL(personal_informations.`middlename`, '')) AS `name`
                FROM plantilla_contents
                JOIN personal_informations ON plantilla_contents.`personal_information_id` =  personal_informations.`id`
                JOIN positions ON plantilla_contents.`position_id` =  positions.`id`
                JOIN departments ON positions.`department_id` =  departments.`id`
                WHERE plantilla_contents.`personal_information_id` IS NOT NULL
                AND plantilla_contents.`plantilla_id` = '".$plantilla->id."'
                ORDER BY personal_informations.`surname`");

        }else if ($department_id != '') {

            $allEmployees = DB::select("SELECT personal_informations.`id` as `id`,
                CONCAT(personal_informations.`surname`, ', ', personal_informations.`firstname`, ' ', IFNULL(personal_informations.`nameextension`, ''), ' ', IFNULL(personal_informations.`middlename`, '')) AS `name`
                FROM plantilla_contents
                JOIN personal_informations ON plantilla_contents.`personal_information_id` =  personal_informations.`id`
                JOIN positions ON plantilla_contents.`position_id` =  positions.`id`
                JOIN departments ON positions.`department_id` =  departments.`id`
                WHERE plantilla_contents.`personal_information_id` IS NOT NULL
                AND plantilla_contents.`plantilla_id` = '".$plantilla->id."'
                AND departments.`id` = '".$department_id."'
                ORDER BY personal_informations.`surname`");

            $reapointments = Reappointment::select('reappointments.*')
                                ->join('personal_informations', 'reappointments.personal_information_id', 'personal_informations.id')
                                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                                ->whereNotNull('plantilla_contents.personal_information_id')
                                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                                ->where('reappointments.assigned_to', $department_id)
                                ->select(
                                    'personal_informations.id as id',
                                    DB::raw("CONCAT(personal_informations.surname, ', ', personal_informations.firstname, ' ', personal_informations.nameextension, ' ', personal_informations.middlename) as name")
                                )
                                ->orderBy('personal_informations.surname', 'ASC')
                                ->get();

            $allEmployees = array_merge($allEmployees, $reapointments->toarray());

        }

        return $allEmployees;
    }

    public function forvacants(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $allEmployees = DB::select("SELECT id, CONCAT(surname, ', ', firstname, ' ', nameextension, ' ', middlename) AS `name` FROM personal_informations
            WHERE (SELECT count(*) FROM plantilla_contents WHERE personal_informations.`id` = plantilla_contents.`personal_information_id` AND plantilla_contents.`plantilla_id` = '".$plantilla->id."') = 0
            OR personal_informations.`id` = '".$request->personal_information_id."'
            ORDER BY personal_informations.`surname`");
        // $collection = collect($allEmployees);
        // $personalinformation = PersonalInformation::select('id','firstname','middlename','surname','nameextension')->where('id', $request->personal_information_id)->first();
        // if ($personalinformation != null) {
        //     $collection->prepend($personalinformation);
        // }
        return $allEmployees;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'surname' => 'required|string',
                'firstname' => 'required|string',
                'birthdate' => 'required|string',
                'cellphone'  => 'required|string',
                'religion' => 'required|string',
                'other_religion' => 'required_if_:religion,Others',
                'other_indigenous_people' => 'required_if_:indigenous_people,Others',
                'other_disability' => 'required_if_:disability,Others',
                'civilstatus_others' => 'required_if_:civilstatus,Other/s',
                'permanentaddresstable.house_lotNo' => 'required',
                'permanentaddresstable.street' => 'required',
                'permanentaddresstable.subdv_village' => 'required',
                'permanentaddresstable.barangay' => 'required',
                'permanentaddresstable.city_municipality' => 'required',
                'permanentaddresstable.province' => 'required',
                'permanentaddresstable.zipcode' => 'required',
            ],
            [
                'permanentaddresstable.house_lotNo.required' => 'File Required',
                'permanentaddresstable.street.required' => 'File Required',
                'permanentaddresstable.subdv_village.required' => 'File Required',
                'permanentaddresstable.barangay.required' => 'File Required',
                'permanentaddresstable.city_municipality.required' => 'File Required',
                'permanentaddresstable.province.required' => 'File Required',
                'permanentaddresstable.zipcode.required' => 'File Required',
            ]
        );

        if($request->civilstatus == "Other/s"){
            $request->merge(['civilstatus' => $request->civilstatus . '(-)' . $request->civilstatus_others]);
        }



        if ($request->picture != null) {
            $name = time().'.'.explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
            \Image::make($request->picture)->save(public_path('storage/employee_pictures/').$name);

            $request->merge(['picture' => $name]);
        }

        // dd($request->civilstatus);

        $pi = PersonalInformation::create($request->all());

        event(new PersonalInfoRegistered($pi));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pi = PersonalInformation::with('plantillacontents')->findOrFail($id);

        $cs = explode('(-)', $pi->civilstatus);

        if($cs[0] == "Other/s" && count($cs) > 1){
            $pi->civilstatus = "Other/s";
            $pi->civilstatus_others = $cs[1];
        }

        return $pi;
    }

    public function edit(Request $request)
    {
        $pi = PersonalInformation::findOrFail($request->id);

        $cs = explode('(-)', $pi->civilstatus);

        if($cs[0] == "Other/s" && count($cs) > 1){
            $pi->civilstatus = "Other/s";
            $pi->civilstatus_others = $cs[1];
        }

        return $pi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
                'surname' => 'required|string',
                'firstname' => 'required|string',
                'birthdate' => 'required|string',
                'cellphone'  => 'required|string',
                'religion' => 'required|string',
                'other_religion' => 'required_if_:religion,Others',
                'other_indigenous_people' => 'required_if_:indigenous_people,Others',
                'other_disability' => 'required_if_:disability,Others',
                'civilstatus_others' => 'required_if_:civilstatus,Other/s',
                'permanentaddresstable.house_lotNo' => 'required',
                'permanentaddresstable.street' => 'required',
                'permanentaddresstable.subdv_village' => 'required',
                'permanentaddresstable.barangay' => 'required',
                'permanentaddresstable.city_municipality' => 'required',
                'permanentaddresstable.province' => 'required',
                'permanentaddresstable.zipcode' => 'required',
            ],
            [
                'permanentaddresstable.house_lotNo.required' => 'File Required',
                'permanentaddresstable.street.required' => 'File Required',
                'permanentaddresstable.subdv_village.required' => 'File Required',
                'permanentaddresstable.barangay.required' => 'File Required',
                'permanentaddresstable.city_municipality.required' => 'File Required',
                'permanentaddresstable.province.required' => 'File Required',
                'permanentaddresstable.zipcode.required' => 'File Required',
            ]
        );

        $pi = PersonalInformation::findOrFail($id);

        $currentPhoto = $pi->picture;

        if ($request->picture != $currentPhoto) {
            $name = time().'.'.explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
            \Image::make($request->picture)->save(public_path('storage/employee_pictures/').$name);

            $request->merge(['picture' => $name]);

            $userPhoto = public_path('storage/employee_pictures/').$currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        if($request->civilstatus == "Other/s"){
            $request->merge(['civilstatus' => $request->civilstatus . '(-)' . $request->civilstatus_others]);
        }

        $pi->update($request->all());

        event(new PersonalInfoUpdated($pi));
    }

    public function employees(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $employees = PersonalInformation::whereHas('plantillacontents', function ($query) use ($plantilla) {
            $query->where('plantilla_id', $plantilla->id);
        })->orderBy('surname')->get();

        return new EmployeeAppointmentListResource($employees);
    }

    public function editPersonalInfo(Request $request)
    {
        $employee = PersonalInformation::find($request->id);

        return  $employee->update([
            $request->mode == 1 ? 'retirement_date' : 'status' => $request->data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
