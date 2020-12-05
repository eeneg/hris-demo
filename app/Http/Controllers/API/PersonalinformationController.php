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
        return EmployeesListResource::collection($personalinformations);
    }

    public function forvacants() {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $allEmployees = DB::select('SELECT id,firstname,middlename,surname,nameextension FROM personal_informations
            WHERE (SELECT count(*) FROM plantilla_contents WHERE personal_informations.`id` = plantilla_contents.`personal_information_id`) = 0
            ORDER BY surname');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
