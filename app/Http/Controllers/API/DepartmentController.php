<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Department;
use App\PlantillaContent;
use App\Plantilla;
use App\Setting;
use App\Http\Resources\SortedDepartmentsResource;
use App\Http\Resources\DepartmentsAndPositionsResource;
use App\Position;

class DepartmentController extends Controller
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
        $plantillacontents = PlantillaContent::where('plantilla_id', $plantilla->id)
            ->join('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->groupBy('positions.department_id')
            ->orderBy('order_number')
            ->get();
        return new SortedDepartmentsResource($plantillacontents);
    }

    public function fetch_depts()
    {
        $departments = Department::with('position')->get();

        return new DepartmentsAndPositionsResource($departments);
    }

    public function fetch_positions(Request $request)
    {
        $positions = Position::where('department_id', $request->id)->orderBy('title')->get();

        foreach($positions as $key => $data)
        {
            $positions[$key]['count']  = PlantillaContent::where('position_id', $data->id)->count();
        }

        return $positions;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $department = Department::create($request->all());
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
        $department = Department::findOrFail($id);

        $department->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();
    }

    public function store_position(Request $request){

        $this->validate($request, [
            'title' => 'required|unique:positions,title'
        ]);

        $position = Position::create($request->all());

    }

    public function update_position(Request $request, $id){

        $this->validate($request, [
            'title' => 'required|unique:positions,title'
        ]);

        $position = Position::findOrFail($id);

        $position->update($request->all());

    }

    public function delete_position($id){

        $position = Position::findOrFail($id);

        $position->delete();

    }
}
