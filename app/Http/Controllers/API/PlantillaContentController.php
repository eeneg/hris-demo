<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PlantillaContent;
use App\Setting;
use App\Plantilla;
use App\Position;
use App\SalaryGrade;
use App\Department;
use App\Http\Resources\PlantillaContentResource;

class PlantillaContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function plantilladepartmentcontent(Request $request) {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::select('plantilla_contents.*')
            ->join('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->join('departments', 'positions.department_id', '=', 'departments.id')
            ->where('departments.address', $request->department)
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->orderBy('order_number')
            ->get();
        return PlantillaContentResource::collection($plantillacontents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $newPosition = Position::create([
            'department_id' => Department::where('address', $request->department)->first()->id,
            'title' => $request->position
        ]);
        
        $newPositionOrder = PlantillaContent::where('plantilla_id', $plantilla->id)->where('new_number', $request->new_number)->first();
        if ($newPositionOrder != null) {
            $contentUpdates = PlantillaContent::where('plantilla_id', $plantilla->id)->where('order_number', '>=', $newPositionOrder->order_number)->get();
            foreach ($contentUpdates as $key => $value) {
                $value->order_number = $value->order_number + 1;
                $value->new_number = $value->new_number != null ? intval($value->new_number) + 1 : $value->new_number;
                $value->save();
            }
        }
        
        $salaryproposed = SalaryGrade::where('salary_sched_id', $plantilla->salaryproposedschedule->id)
                ->where('grade', intval(((object) $request->salaryproposed)->grade))->where('step', intval(((object) $request->salaryproposed)->step))
                ->first();
        
        $lastOrderNumber = PlantillaContent::where('plantilla_id', $plantilla->id)->orderBy('order_number', 'desc')->first()->order_number;        
        return PlantillaContent::create([
            'plantilla_id' => $plantilla->id,
            'salary_grade_prop_id' => $salaryproposed->id,
            'position_id' => $newPosition->id,
            'new_number' => $request->new_number,
            'order_number' => $newPositionOrder == null ? ($lastOrderNumber + 1) : $newPositionOrder->order_number
        ]);
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

    public function plantillacontentabolish(Request $request) {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $plantillacontent = PlantillaContent::findOrFail($request->id);
        $plantillacontent->new_number = null;
        $plantillacontent->salary_grade_prop_id = null;
        $plantillacontent->save();

        $toUpdate = PlantillaContent::where('plantilla_id', $plantilla->id)->where('order_number', '>', $plantillacontent->order_number)->get();
        foreach ($toUpdate as $key => $value) {
            $value->new_number = $value->new_number != '' ? (intval($value->new_number) - 1) : $value->new_number;
            $value->save();
        }

        return $plantillacontent;
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
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $plantillacontent = PlantillaContent::findOrFail($id);
        
        // Employee
        $plantillacontent->personal_information_id = $request->personal_information_id == 'null' ? null : $request->personal_information_id;

        // Item No.
        $update = intval($request->new_number);
        $original = $plantillacontent->new_number;
        if ($update != $original) {
            // New item record
            $newUpdate = PlantillaContent::where('plantilla_id', $plantilla->id)->where('new_number', $update)->first();
            
            // New and old order numbers
            $originalOrderNumber = $plantillacontent->order_number;
            $updateOrderNumber = $newUpdate->order_number;
            
            // Update record
            $plantillacontent->new_number = $update;
            $plantillacontent->order_number = $updateOrderNumber;
            
            if ($originalOrderNumber > $updateOrderNumber) {
                for ($i=$originalOrderNumber-1; $i >= $updateOrderNumber; $i--) {
                    $forUpdate1 = PlantillaContent::where('plantilla_id', $plantilla->id)->where('order_number', $i)->first();
                    $forUpdate1->order_number = $forUpdate1->order_number + 1;
                    $forUpdate1->new_number = $forUpdate1->new_number != '' ? (intval($forUpdate1->new_number) + 1) : $forUpdate1->new_number;
                    $forUpdate1->save();
                }
            } else {
                for ($i=$originalOrderNumber+1; $i <= $updateOrderNumber; $i++) { 
                    $forUpdate2 = PlantillaContent::where('plantilla_id', $plantilla->id)->where('order_number', $i)->first();
                    $forUpdate2->order_number = $forUpdate2->order_number - 1;
                    $forUpdate2->new_number = $forUpdate2->new_number != '' ? (intval($forUpdate2->new_number) - 1) : $forUpdate2->new_number;
                    $forUpdate2->save();
                }
            }
        }

        // Update Position Name
        $position = Position::findOrFail($request->position_id);
        if ($request->position != $position->title) {
            $position->title = $request->position;
            $position->save();
        }

        // Salary Proposed Update
        if ($plantillacontent->salaryproposed->grade != intval(((object) $request->salaryproposed)->grade) || $plantillacontent->salaryproposed->step != intval(((object) $request->salaryproposed)->step)) {
            $salaryproposed = SalaryGrade::where('salary_sched_id', $plantillacontent->salaryproposed->salary_sched_id)
                ->where('grade', intval(((object) $request->salaryproposed)->grade))->where('step', intval(((object) $request->salaryproposed)->step))
                ->first();
            $plantillacontent->salary_grade_prop_id = $salaryproposed->id;
        }

        $plantillacontent->save();

        return $plantillacontent;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $plantillacontent = PlantillaContent::findOrFail($id);
        $position = Position::findOrFail($plantillacontent->position_id);
        $plantillacontent->delete();
        $position->delete();

        $contentUpdates = PlantillaContent::where('plantilla_id', $plantilla->id)->where('order_number', '>', $plantillacontent->order_number)->get();
        foreach ($contentUpdates as $key => $value) {
            $value->order_number = $value->order_number - 1;
            $value->new_number = $value->new_number != null ? intval($value->new_number) - 1 : $value->new_number;
            $value->save();
        }
    }
}
