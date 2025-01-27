<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentsAndPositionsResource;
use App\Http\Resources\DepartmentsResource;
use App\Http\Resources\SortedDepartmentsResource;
use App\Plantilla;
use App\PlantillaContent;
use App\PlantillaDept;
use App\Position;
use App\Setting;
use Illuminate\Http\Request;

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
        $plantilla = $default_plantilla ? Plantilla::where('year', $default_plantilla->value)->first() : null;
        // $plantillacontents = PlantillaContent::where('plantilla_id', $plantilla->id)
        //     ->join('positions', 'plantilla_contents.position_id', '=', 'positions.id')
        //     ->groupBy('positions.department_id')
        //     ->orderBy('order_number')
        //     ->get();
        if($plantilla){
            $departments = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get();
            return new SortedDepartmentsResource($departments);
        } else {
            $departments = Department::where('status', 'active')->orderBy('order_number')->get();
            return new DepartmentsResource($departments);
        }
    }

    public function add_departments(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');

        $plantilla = Plantilla::findOrFail($request->id);
        $departments = $request->plantilla_depts;

        foreach ($departments as $key => $data) {
            $department = PlantillaDept::where('plantilla_id', $plantilla->id)->where('department_id', $data['id'])->first();

            if(!$department)
            {
                $department = new PlantillaDept;
                $department->plantilla_id = $plantilla->id;
                $department->department_id = $data['id'];
                $department->order_number = $key + 1;
                $department->save();
            } else {
                $department->order_number = $key + 1;
                $department->save();
            }
        }
    }

    public function complete_depts()
    {
        $departments = Department::where('status', 'active')->orderBy('order_number')->get();

        return new DepartmentsResource($departments);
    }

    public function fetch_depts()
    {
        $departments = Department::with('positions')->get();

        return new DepartmentsAndPositionsResource($departments);
    }

    public function fetch_plantilla_depts(Request $request)
    {
        $departments = PlantillaDept::where('plantilla_id', $request->selectedPlantilla)->orderBy('order_number')->get();

        return new SortedDepartmentsResource($departments);
    }

    public function fetch_positions(Request $request)
    {
        $positions = Position::where('department_id', $request->id)->orderBy('title')->get();
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();

        if($default_plantilla){
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
            foreach ($positions as $key => $data) {
                $positions[$key]['count'] = PlantillaContent::where('plantilla_id', $plantilla->id)->where('position_id', $data->id)->count();
            }
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
        $this->authorize('isAdministratorORAuthor');

        $request->validate([
            'title' => 'required|unique:departments',
            'description' => 'required',
            'address' => 'required',
            'function' => 'required',
            'projectactivity' => 'required',
            'fund' => 'required',
        ]);

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
        $this->authorize('isAdministratorORAuthor');

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'address' => 'required',
            'function' => 'required',
            'projectactivity' => 'required',
            'fund' => 'required',
        ]);

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
        $this->authorize('isAdministratorORAuthor');
        $department = Department::findOrFail($id);

        $department->delete();
    }

    public function store_position(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');

        $unique = Position::where('department_id', $request->department_id)->where('title', $request->title)->first();

        if($unique)
        {
            $this->validate($request, [
                'title' => 'required|unique:positions',
            ]);
        }

        $position = Position::create($request->all());
    }

    public function update_position(Request $request, $id)
    {
        $this->authorize('isAdministratorORAuthor');
        $this->validate($request, [
            'title' => 'required|unique:positions,title',
        ]);

        $position = Position::findOrFail($id);

        $position->update($request->all());
    }

    public function delete_position($id)
    {
        $this->authorize('isAdministratorORAuthor');
        $position = Position::findOrFail($id);

        $position->delete();
    }
}
