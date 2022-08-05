<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\PersonalInformation;
use App\PlantillaContent;
use App\Http\Resources\EmployeesListResource;
use App\Setting;
use App\Plantilla;
use App\UserAssignment;
use App\Events\PersonalInfoRegistered;
use App\Events\PersonalInfoUpdated;
use App\Http\Resources\EmployeeAppointmentListResource;
use App\Reappointment;

class PersonalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($search = \Request::get('query')) {
            $personalinformations = PersonalInformation::with('plantillacontents')
            ->where(function($query) use ($search){
                $query->where('surname', 'LIKE', '%'.$search.'%')
                        ->orWhere('firstname', 'LIKE', '%'.$search.'%')
                        ->orWhere('middlename', 'LIKE', '%'.$search.'%')
                        ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$search.'%')
                        ->orWhere('status', 'LIKE', '%'.$search.'%');
            })->orderBy('surname')->paginate(20);
        } else {
            $personalinformations = PersonalInformation::orderBy('surname')->paginate(20);
        }
        return new EmployeesListResource($personalinformations);
    }

    public function forleave(Request $request) {
        $department_id = Auth::user()->role == 'Office User' ? UserAssignment::where('user_id', Auth::user()->id)->first()->department_id : '';
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        if ($department_id != '') {
            $allEmployees = DB::select("SELECT personal_informations.`id` as `id`,
                CONCAT(personal_informations.`surname`, ', ', personal_informations.`firstname`, ' ', personal_informations.`nameextension`, ' ', personal_informations.`middlename`) AS `name`
                FROM plantilla_contents
                JOIN personal_informations ON plantilla_contents.`personal_information_id` =  personal_informations.`id`
                JOIN positions ON plantilla_contents.`position_id` =  positions.`id`
                JOIN departments ON positions.`department_id` =  departments.`id`
                WHERE plantilla_contents.`personal_information_id` IS NOT NULL
                AND plantilla_contents.`plantilla_id` = '" . $plantilla->id . "'
                AND departments.`id` = '" . $department_id . "'
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

        } else {
            $allEmployees = DB::select("SELECT personal_informations.`id` as `id`,
                CONCAT(personal_informations.`surname`, ', ', personal_informations.`firstname`, ' ', personal_informations.`nameextension`, ' ', personal_informations.`middlename`) AS `name`
                FROM plantilla_contents
                JOIN personal_informations ON plantilla_contents.`personal_information_id` =  personal_informations.`id`
                JOIN positions ON plantilla_contents.`position_id` =  positions.`id`
                JOIN departments ON positions.`department_id` =  departments.`id`
                WHERE plantilla_contents.`personal_information_id` IS NOT NULL
                AND plantilla_contents.`plantilla_id` = '" . $plantilla->id . "'
                ORDER BY personal_informations.`surname`");
        }

        return $allEmployees;
    }

    public function forvacants(Request $request) {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $allEmployees = DB::select("SELECT id, CONCAT(surname, ', ', firstname, ' ', nameextension, ' ', middlename) AS `name` FROM personal_informations
            WHERE (SELECT count(*) FROM plantilla_contents WHERE personal_informations.`id` = plantilla_contents.`personal_information_id` AND plantilla_contents.`plantilla_id` = '" . $plantilla->id . "') = 0
            OR personal_informations.`id` = '" . $request->personal_information_id . "'
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
            'surname'               => 'required|string',
            'firstname'             => 'required|string',
            'birthdate'             => 'required|string',
            'permanentaddress'      => 'required|string',
            'cellphone'             => 'required|string',
        ]);

        if ($request->picture != null) {
            $name = time() . '.' . explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
            \Image::make($request->picture)->save(public_path('storage/employee_pictures/').$name);

            $request->merge(['picture' => $name]);
        }

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
        return PersonalInformation::with('plantillacontents')->findOrFail($id);
    }

    public function edit(Request $request)
    {
        return PersonalInformation::findOrFail($request->id);
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
            'surname'               => 'required|string',
            'firstname'             => 'required|string',
            'birthdate'             => 'required|string',
            'permanentaddress'      => 'required|string',
            'cellphone'             => 'required|string',
        ]);

        $pi = PersonalInformation::findOrFail($id);

        $currentPhoto = $pi->picture;

        if ($request->picture != $currentPhoto) {
            $name = time() . '.' . explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
            \Image::make($request->picture)->save(public_path('storage/employee_pictures/').$name);

            $request->merge(['picture' => $name]);

            $userPhoto = public_path('storage/employee_pictures/').$currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        $pi->update($request->all());

        event(new PersonalInfoUpdated($pi));
    }

    public function employees(Request $request)
    {
        $employees = PersonalInformation::orderBy('surname', 'ASC')->get();
        return new EmployeeAppointmentListResource($employees);
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
