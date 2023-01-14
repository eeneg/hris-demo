<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use App\Plantilla;
use App\PlantillaContent;
use Carbon\Carbon;
use App\Http\Resources\BirthdaysResource;

class DashboardController extends Controller
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

        $plantilla_contents = PlantillaContent::where('plantilla_id', $plantilla->id)->get();
        $vacant_positions = $plantilla_contents->whereNull('personal_information_id');
        $active_employees = $plantilla_contents->whereNotNull('personal_information_id');
        $birthdays = PlantillaContent::where('plantilla_id', $plantilla->id)->whereNotNull('personal_information_id')
            ->with('personalinformation')
            ->whereHas('personalinformation', function($q){
                $q->whereMonth('birthdate', Carbon::now()->format('m'))
                ->whereDay('birthdate', Carbon::now()->format('d'));
            })->get();

        $data = [
            'vacant_positions' => count($vacant_positions),
            'active_employees' => count($active_employees),
            'birthdays' => new BirthdaysResource($birthdays)
        ];
        return $data;
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
