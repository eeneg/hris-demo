<?php

namespace App\Http\Controllers\Api;

use App\AbolishedItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentsResource;
use App\Http\Resources\PlantillaContentResource;
use App\Http\Resources\PlantillaContentReportsResource;
use App\Http\Resources\PlantillaEmployeesNOSAResource;
use App\Http\Resources\PlantillaEmployeesNOSIResource;
use App\Http\Resources\PlantillaContentEmployeeResource;
use App\Http\Resources\PlantillaEmployeesLoyaltyResource;
use App\Plantilla;
use App\PlantillaContent;
use App\PlantillaDept;
use App\Position;
use App\SalaryGrade;
use App\Setting;
use App\Separation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function plantillaForNosi(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::with('personalinformation')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->leftJoin('salary_grades as salaryproposed', 'plantilla_contents.salary_grade_prop_id', '=', 'salaryproposed.id')
            // ->leftJoin('salary_grades as nextStep', function ($join) {
            //     $join->on('salaryproposed.salary_sched_id', '=', 'nextStep.salary_sched_id');
            //     $join->on('salaryproposed.grade', '=', 'nextStep.grade');
            //     $join->on(DB::raw('salaryproposed.step + 1'), '=', 'nextStep.step');
            // })
            // ->leftJoin('salary_grades as previousStep', function ($join) {
            //     $join->on('salaryproposed.salary_sched_id', '=', 'previousStep.salary_sched_id');
            //     $join->on('salaryproposed.grade', '=', 'previousStep.grade');
            //     $join->on(DB::raw('salaryproposed.step - 1'), '=', 'previousStep.step');
            // })
            ->select('*')
            ->whereNotNull('personal_information_id')
            ->orderByRaw('CONVERT(new_number, SIGNED) desc')
            ->get();

        $departments = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get()->pluck('department');

        $data = [
            'plantillacontents' => new PlantillaEmployeesNOSIResource($plantillacontents),
            'departments' => $departments
        ];

        return $data;
    }

    public function plantillaForNosa(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::with('personalinformation')
            ->where('plantilla_id', $plantilla->id)
            ->whereNotNull('personal_information_id')
            ->get();
        $departments = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get()->pluck('department');

        $nosa_resource = new PlantillaEmployeesNOSAResource($plantillacontents);
        $department_resource = new DepartmentsResource($departments);
        $data = [
            'plantillacontents' => $nosa_resource,
            'departments' => $department_resource,
        ];

        return $data;
    }

    public function plantillaForLoyalty(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::with('personalinformation')
            ->where('plantilla_id', $plantilla->id)
            ->whereNotNull('personal_information_id')
            ->get();
        $departments = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get()->pluck('department');

        $nosa_resource = new PlantillaEmployeesLoyaltyResource($plantillacontents);
        $department_resource = new DepartmentsResource($departments);
        $data = [
            'plantillacontents' => $nosa_resource,
            'departments' => $department_resource,
        ];

        return $data;
    }
    
    public function plantillaTicketsReports(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::leftJoin('personal_informations', 'plantilla_contents.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('plantilla_depts', function ($join) {
                $join->on('departments.id', '=', 'plantilla_depts.department_id');
                $join->on('plantilla_contents.plantilla_id', '=', 'plantilla_depts.plantilla_id');
            })
            ->where('departments.address', $request->office)
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->orderBy('plantilla_depts.order_number')->orderBy('personal_informations.surname')->get();

            $plantillacontent_resource = $plantillacontents->map(function ($item) {
                return [
                    'id' => $item->id,
                    'personal_information_id' => $item->personal_information_id,
                    'sex' => $item->personalinformation ? $item->personalinformation->sex : '',
                    'old_number' => $item->old_number,
                    'new_number' => $item->new_number,
                    'order_number' => $item->order_number,
                    'working_time' => $item->working_time,
                    'level' => $item->level,
                    'original_appointment' => $item->original_appointment,
                    'last_promotion' => $item->last_promotion,
                    'appointment_status' => $item->appointment_status,
                    'office' => $item->position ? $item->position->department->address : '',
                    'office_title' => $item->position ? $item->position->department->title : '',
                    'birthdate' => $item->personalinformation ? $item->personalinformation->birthdate : '',
                    'position' => $item->position ? $item->position->title : '',
                    'position_id' => $item->position ? $item->position->id : '',
                    'name' => $item->personalinformation ? $item->personalinformation->surname.($item->personalinformation->nameextension ? ' '.$item->personalinformation->nameextension : '').', '.$item->personalinformation->firstname.' '.$item->personalinformation->middlename : 'VACANT',
                    'salaryauthorized' => $item->salaryauthorized,
                    'salaryproposed' => $item->salaryproposed,
                    'csc_level' => $item->csc_level
                ];
            });
        // $plantillacontent_resource = new PlantillaContentReportsResource($plantillacontents);
        
        // return $plantillacontent_resource;
        $data = [
            'plantillacontents' => $plantillacontent_resource
        ];
        return view('/reports/ticket', $data);
    }

    public function plantillaForOtherReports(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::with('personalinformation')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->leftJoin('plantilla_depts', function ($join) {
                    $join->on('departments.id', '=', 'plantilla_depts.department_id');
                    $join->on('plantilla_contents.plantilla_id', '=', 'plantilla_depts.plantilla_id');
                })
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->orderBy('plantilla_depts.order_number')->orderBy('plantilla_contents.order_number')->get();
        $departments = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get()->pluck('department');

        $department_resource = new DepartmentsResource($departments);
        $plantillacontent_resource = new PlantillaContentReportsResource($plantillacontents);
        $data = [
            'plantillacontents' => $plantillacontent_resource,
            'departments' => $department_resource,
        ];

        return $data;
    }

    public function plantilladepartmentcontent(Request $request)
    {
        if ($request->selectedPlantilla) {
            $plantilla = Plantilla::findOrFail($request->selectedPlantilla);
        } else {
            $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        }

        $plantillacontents = PlantillaContent::select('plantilla_contents.*')
            ->join('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->join('departments', 'positions.department_id', '=', 'departments.id')
            ->where('departments.address', $request->department['address'])
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->orderBy('order_number')
            ->get();

        return new PlantillaContentResource($plantillacontents);
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
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        if (!is_null($request->selectedPlantilla)) {
            $plantilla = Plantilla::findOrFail($request->selectedPlantilla['id']);
        }

        $department_id = $request->department_id;
        if (! isset($request->position['id'])) {
            $position = Position::create([
                'department_id' => $department_id,
                'title' => isset($request->position['title']) ? $request->position['title'] : $request->position,
            ]);
            $position_id = $position->id;
        } else {
            $position_id = $request->position['id'];
        }

        $contents = PlantillaContent::where('plantilla_id', $plantilla->id)->with('position')->whereHas('position', function ($query) use ($department_id) {
            $query->where('department_id', $department_id);
        })->orderBy('order_number', 'desc')->get();

        if ($contents->count() > 0) {
            if ($contents->first()->order_number >= $request->order_number) {
                $adjustments = $contents->where('order_number', '>=', $request->order_number);
                foreach ($adjustments as $key => $value) {
                    $value->order_number = $value->order_number + 1;
                    $value->save();
                }
            }
        }

        if ($request->salary_grade_auth != '') {
            $salaryauthorized = SalaryGrade::where('salary_sched_id', $plantilla->salaryauthorizedschedule->id)
                ->where('grade', explode('/', $request->salary_grade_auth)[0])
                ->where('step', explode('/', $request->salary_grade_auth)[1])
                ->first();
        }

        if ($request->salary_grade_prop != '') {
            $salaryproposed = SalaryGrade::where('salary_sched_id', $plantilla->salaryproposedschedule->id)
                ->where('grade', explode('/', $request->salary_grade_prop)[0])
                ->where('step', explode('/', $request->salary_grade_prop)[1])
                ->first();
        }

        $tbd = PlantillaContent::where('plantilla_id', $plantilla->id)->where('personal_information_id', $request->personal_information_id)->first();
        if ($tbd != null) {
            $tbd->personal_information_id = null;
            $tbd->original_appointment = null;
            $tbd->last_promotion = null;
            $tbd->save();

            // Benefit Schedule
            if ($request->personal_information_id != null) {
                $tbd->personalinformation->benefitschedule->updateorcreate(
                    [ 'personal_information_id' => $tbd->personal_information_id ],
                    [ 'nosi' => $request->nosi_schedule, 'loyalty' => $request->loyalty_schedule ]
                );
            }
        }

        $new_plantilla_content = PlantillaContent::create([
            'plantilla_id' => $plantilla->id,
            'salary_grade_auth_id' => isset($salaryauthorized) ? $salaryauthorized->id : null,
            'salary_grade_prop_id' => isset($salaryproposed) ? $salaryproposed->id : null,
            'position_id' => $position_id,
            'personal_information_id' => $request->personal_information_id,
            'new_number' => $request->new_number,
            'old_number' => $request->old_number,
            'difference_amount' => 0,
            'working_time' => $request->working_time,
            'level' => $request->level,
            'original_appointment' => $request->original_appointment,
            'last_promotion' => $request->last_promotion,
            'appointment_status' => $request->appointment_status,
            'order_number' => $request->order_number,
            'csc_level' => $request->csc_level
        ]);

        return $new_plantilla_content;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('isAdministratorORAuthor');
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $plantillacontent = PlantillaContent::where('plantilla_id', $plantilla->id)->where('personal_information_id', $id)->first();
        if ($plantillacontent != null) {
            return new PlantillaContentEmployeeResource($plantillacontent);
        } else {
            return ['response' => 'Employee is not on current plantilla.'];
        }
    }

    public function plantillacontentabolish(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');

        $plantillacontent = PlantillaContent::findOrFail($request->id);

        // Create Abolished Record
        AbolishedItem::create([
            'plantilla_content_id' => $plantillacontent->id,
            'salary_grade_prop_id' => $plantillacontent->salary_grade_prop_id,
            'new_number' => $plantillacontent->new_number,
        ]);

        $plantillacontent->new_number = null;
        $plantillacontent->salary_grade_prop_id = null;
        $plantillacontent->save();

        $toUpdate = PlantillaContent::where('plantilla_id', $plantillacontent->plantilla->id)->where('order_number', '>', $plantillacontent->order_number)->get();
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
        $this->authorize('isAdministratorORAuthor');
        $plantillacontent = PlantillaContent::find($id);

        $department_id = $request->department_id;
        if (! isset($request->position['id'])) {
            $position = Position::create([
                'department_id' => $department_id,
                'title' => isset($request->position['title']) ? $request->position['title'] : $request->position,
            ]);
            $position_id = $position->id;
        } else {
            $position_id = $request->position['id'];
        }


        // Order Number if same office
        if ($department_id == $request->department_new || $request->department_new == '') {
            $originalOrderNumber = $plantillacontent->order_number;
            $updateOrderNumber = $request->order_number;
            if ($originalOrderNumber > $updateOrderNumber) {
                PlantillaContent::where('plantilla_id', $plantillacontent->plantilla->id)->with('position')->whereHas('position', function ($query) use ($department_id) {
                    $query->where('department_id', $department_id);
                })->where('order_number', '>=', $updateOrderNumber)->where('order_number', '<', $originalOrderNumber)->update(['order_number' => DB::raw('order_number+1')]);
            } elseif ($originalOrderNumber < $updateOrderNumber) {
                PlantillaContent::where('plantilla_id', $plantillacontent->plantilla->id)->with('position')->whereHas('position', function ($query) use ($department_id) {
                    $query->where('department_id', $department_id);
                })->where('order_number', '<=', $updateOrderNumber)->where('order_number', '>', $originalOrderNumber)->update(['order_number' => DB::raw('order_number-1')]);
            }
        } else {
            $new_position = Position::firstOrCreate([
                'department_id' => $request->department_new,
                'title' => isset($request->position['title']) ? $request->position['title'] : $request->position,
            ]);
            $position_id = $new_position->id;

            $originalOrderNumber = $plantillacontent->order_number;
            $updateOrderNumber = $request->order_number;
            // Adjust old department order numbers
            PlantillaContent::where('plantilla_id', $plantillacontent->plantilla->id)->with('position')->whereHas('position', function ($query) use ($department_id) {
                $query->where('department_id', $department_id);
            })->where('order_number', '>', $originalOrderNumber)->update(['order_number' => DB::raw('order_number-1')]);
            // Insert item to new department
            $new_dept_id = $request->department_new;
            PlantillaContent::where('plantilla_id', $plantillacontent->plantilla->id)->with('position')->whereHas('position', function ($query) use ($new_dept_id) {
                $query->where('department_id', $new_dept_id);
            })->where('order_number', '>=', $updateOrderNumber)->update(['order_number' => DB::raw('order_number+1')]);
        }
        

        if ($request->salary_grade_auth != '') {
            $salaryauthorized = SalaryGrade::where('salary_sched_id', $plantillacontent->plantilla->salaryauthorizedschedule->id)
                ->where('grade', explode('/', $request->salary_grade_auth)[0])
                ->where('step', explode('/', $request->salary_grade_auth)[1])
                ->first();
        }

        if ($request->salary_grade_prop != '') {
            $salaryproposed = SalaryGrade::where('salary_sched_id', $plantillacontent->plantilla->salaryproposedschedule->id)
                ->where('grade', explode('/', $request->salary_grade_prop)[0])
                ->where('step', explode('/', $request->salary_grade_prop)[1])
                ->first();
        }

        $tbd = PlantillaContent::where('plantilla_id', $plantillacontent->plantilla->id)->where('personal_information_id', $request->personal_information_id)->first();
        if ($tbd != null) {
            if ($plantillacontent->id != $tbd->id) {
                $tbd->personal_information_id = null;
                $tbd->original_appointment = null;
                $tbd->last_promotion = null;
                $tbd->save();
            }

            // Benefit Schedule
            if ($request->personal_information_id != null) {
                $tbd->personalinformation->benefitschedule->updateorcreate(
                    [ 'personal_information_id' => $tbd->personal_information_id ],
                    [ 'nosi' => $request->nosi_schedule, 'loyalty' => $request->loyalty_schedule ]
                );
            }
        }

        // Separation
        if ($request->mode) {
            $separation = Separation::firstOrCreate(
                [
                    'mode' => $request->mode,
                    'effectivity_date' => $request->effectivity_date,
                    'personal_information_id' => $plantillacontent->personal_information_id,
                    'appointment_status' => $plantillacontent->appointment_status,
                    'salary_grade' => $plantillacontent->salaryproposed->grade . '-' . $plantillacontent->salaryproposed->step,
                    'position' => $plantillacontent->position->title
                ]
            );
            $employee = $plantillacontent->personalinformation;
            $employee->status = $request->particular;
            $employee->save();
        }

        $plantillacontent->salary_grade_auth_id = isset($salaryauthorized) ? $salaryauthorized->id : null;
        $plantillacontent->salary_grade_prop_id = isset($salaryproposed) ? $salaryproposed->id : null;
        $plantillacontent->position_id = $position_id;
        $plantillacontent->personal_information_id = $request->personal_information_id;
        $plantillacontent->new_number = $request->new_number;
        $plantillacontent->old_number = $request->old_number;
        $plantillacontent->working_time = $request->working_time;
        $plantillacontent->level = $request->level;
        $plantillacontent->original_appointment = $request->original_appointment;
        $plantillacontent->last_promotion = $request->last_promotion;
        $plantillacontent->appointment_status = $request->appointment_status;
        $plantillacontent->order_number = $request->order_number;
        $plantillacontent->csc_level = $request->csc_level;

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
        $this->authorize('isAdministratorORAuthor');
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
