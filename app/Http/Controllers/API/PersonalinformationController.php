<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\PersonalInformation;
use App\PlantillaContent;
use App\Http\Resources\EmployeesListResource;
use App\Setting;
use App\Plantilla;
use App\Events\PersonalInfoRegistered;
use App\Events\PersonalInfoUpdated;


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
            $personalinformations = PersonalInformation::with('plantillacontents')->where(function($query) use ($search){
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
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $allEmployees = DB::select("SELECT id, CONCAT(surname, ', ', firstname, ' ', nameextension, ' ', middlename) AS `name` FROM personal_informations
            WHERE (SELECT count(*) FROM plantilla_contents WHERE personal_informations.`id` = plantilla_contents.`personal_information_id` AND plantilla_contents.`plantilla_id` = '" . $plantilla->id . "') = 1
            ORDER BY personal_informations.`surname`");
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
    public function show()
    {

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
