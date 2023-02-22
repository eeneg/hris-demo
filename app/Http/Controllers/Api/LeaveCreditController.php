<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveCreditResource;
use App\LeaveCredit;
use App\LeaveSummary;
use App\LeaveType;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\Setting;
use App\UserAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeaveCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $default_plantilla  =   Setting::where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::where('year', $default_plantilla->value)->first();
        $department_id      =   auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                                UserAssignment::where('user_id', auth('api')->user()->id)->first()->department_id : '';

        $role = auth('api')->user()->role;

        if($department_id && $role == 'Office User' || $role == 'Office Head')
        {
            $employee = PlantillaContent::has('personalinformation')->with('personalinformation')->get()->where('position.department_id', $department_id)
                ->map(fn($employee) => $employee->personalinformation);
        }else{
            $employee = PersonalInformation::orderBy('surname')->get();
        }

        return new LeaveCreditResource($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $forCreate = [];
        $forUpdate = [];

        $vl_balance = null;
        $sl_balance = null;

        $vl_id = LeaveType::where('title', 'Vacation Leave')->first()->id;
        $sl_id = LeaveType::where('title', 'Sick Leave')->first()->id;

        $collection = collect($request->data)->map(function ($leave) {
            $ll = collect($leave)->mapWithKeys(fn ($data, $key) => in_array($key, ['particulars', 'period']) ? [$key => json_encode($data)] : [$key => $data])->reject(fn ($data, $key) => in_array($key, ['newly_added']));

            return $ll;
        });

        $forUpdate = $collection->filter(fn ($summary) => $summary->has('id'));
        $forCreate = $collection->reject(fn ($summary) => $summary->has('id'))->map(fn ($summary) => $summary->put('id', Str::orderedUuid()->toString()));

        $vl_balance = LeaveCredit::updateOrCreate(['personal_information_id' => $request['id'], 'leave_type_id' => $vl_id], ['balance' => collect($request->data)->last()['vl_balance']]);
        $sl_balance = LeaveCredit::updateOrCreate(['personal_information_id' => $request['id'], 'leave_type_id' => $sl_id], ['balance' => collect($request->data)->last()['sl_balance']]);

        $create = LeaveSummary::insert($forCreate->toArray());
        $update = LeaveSummary::upsert($forUpdate->toArray(), 'id');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personalinformations = PersonalInformation::find($id)->plantillacontents->map(fn ($e) => (object) ['position' => $e->position,  'salary' => $e->salaryauthorized])->first();

        $leaveSummary = LeaveSummary::where('personal_information_id', $id)->orderBy('sort', 'ASC')->get();

        $leaveCredit = DB::table('leave_credits')
                            ->leftJoin('leave_types', 'leave_credits.leave_type_id', '=', 'leave_types.id')
                            ->where('personal_information_id', $id)
                            ->where(function ($query) {
                                $query->where('leave_types.title', 'Sick Leave')
                                ->orWhere('leave_types.title', 'Vacation Leave');
                            })
                            ->get();

        $custom_leave = LeaveSummary::where('personal_information_id', $id)->whereNotNull('particulars->leave_type')
                        ->where(function ($query) {
                            $query->where('particulars->leave_type', 'PL')
                            ->orWhere('particulars->leave_type', 'FL')
                            ->orWhere('particulars->leave_type', 'SPL')
                            ->orWhere('particulars->leave_type', 'SP')
                            ->orWhere('particulars->leave_type', 'SOLO')
                            ->orWhere('particulars->leave_type', 'PL');
                        })
                        ->get()
                        ->map(function ($data) {
                            $year = null;

                            switch($data->period->mode) {
                                case 1:
                                case 4:
                                    $year = Carbon::parse($data->period->data)->format('Y');
                                    break;
                                case 2:
                                    $year = Carbon::parse($data->period->data->start)->format('Y');
                                    break;
                                case 3:
                                    $year = Carbon::parse($data->period->data[0]->date)->format('Y');
                                    break;
                            }

                            $particulars = $data->particulars;

                            $particulars->year = $year;

                            $data->particulars = $particulars;

                            return $data->particulars;
                        });

        $tardy = LeaveSummary::where('personal_information_id', $id)
                        ->whereNotNull('particulars->leave_type')
                        ->whereIn('particulars->leave_type', ['Undertime', 'Tardy', 'UA', 'AWOL'])
                        ->get()
                        ->map(function ($data) {
                            $year = null;
                            $month = null;

                            switch($data->period->mode) {
                                case 1:
                                case 4:
                                    $year = Carbon::parse($data->period->data)->format('Y');
                                    $month = Carbon::parse($data->period->data)->format('F');
                                    break;
                                case 2:
                                    $year = Carbon::parse($data->period->data->start)->format('Y');
                                    $month = Carbon::parse($data->period->data->start)->format('F');
                                    break;
                                case 3:
                                    $year = Carbon::parse($data->period->data[0]->date)->format('Y');
                                    $month = Carbon::parse($data->period->data[0]->date)->format('F');
                                    break;
                            }

                            $data->year = $year;
                            $data->month = $month;

                            return [
                                'month' => $data->month,
                                'year' => $data->year,
                                'type' => $data->particulars->leave_type,
                                'count' => $data->particulars->count,
                            ];
                        });

        $awol = LeaveSummary::where('personal_information_id', $id)->whereIn('particulars->leave_type', ['AWOL', 'UA'])
                        ->where('period->mode', 4)
                        ->get()
                        ->map(function ($data, $index) {
                            switch($data->period->mode) {
                                case 1:
                                case 4:
                                    $year = Carbon::parse($data->period->data)->format('Y');

                                    if ($year == Carbon::now()->format('Y')) {
                                        return $data;
                                    }

                                    break;
                                case 2:
                                    $year = Carbon::parse($data->period->data->start)->format('Y');

                                    if ($year == Carbon::now()->format('Y')) {
                                        return $data;
                                    }

                                    break;
                                case 3:
                                    $year = Carbon::parse($data->period->data[0]->date)->format('Y');

                                    if ($year == Carbon::now()->format('Y')) {
                                        return $data;
                                    }

                                    break;
                            }
                        });

        $vl = LeaveCredit::where('leave_type_id', LeaveType::where('title', 'Vacation Leave')->first()->id)->first()->id;
        $sl = LeaveCredit::where('leave_type_id', LeaveType::where('title', 'Sick Leave')->first()->id)->first()->id;

        $credits_anticipated = LeaveSummary::where('personal_information_id', $id)
            ->where(function ($query) {
                $query->whereNotNull('vl_earned')
                ->where('vl_earned', '>', 0.0)
                ->whereNotNull('sl_earned')
                ->where('sl_earned', '>', 0.0)
                ->where('sl_withpay', '=', 0.0)
                ->where('vl_withpay', '=', 0.0);
            })
            ->where(function($query){
                $query->where('period->mode', 4)
                ->where('period->data', Carbon::now()->subYear()->format('Y') . '-12');
            })
            ->first();

        $vl = collect($leaveCredit->where('abbreviation', 'VL')->first())->put('anticipated', $credits_anticipated ? $credits_anticipated->vl_balance + 15 : null);
        $sl = collect($leaveCredit->where('abbreviation', 'SL')->first())->put('anticipated', $credits_anticipated ? $credits_anticipated->sl_balance + 15 : null);

        return [
            'summary' => $leaveSummary,
            'credit' => ['sl' => $sl, 'vl' => $vl],
            'custom_leave' => LeaveSummary::countCustomLeave($custom_leave),
            'tardy' => LeaveSummary::violationCounter($tardy),
            'position' => $personalinformations->position ?? '',
            'salary' => $personalinformations->salary ?? '',
            'awol' => LeaveSummary::violationCounter($awol),
        ];
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $summary = LeaveSummary::find($id);

        $vl_deduct = $summary->vl_earned - $summary->vl_withpay;
        $sl_deduct = $summary->sl_earned - $summary->sl_withpay;

        $vl_id = LeaveType::where('title', 'Vacation Leave')->first()->id;
        $sl_id = LeaveType::where('title', 'Sick Leave')->first()->id;

        $vl_balance = LeaveCredit::where('personal_information_id', $summary->personal_information_id)->where('leave_type_id', $vl_id)->first();
        $sl_balance = LeaveCredit::where('personal_information_id', $summary->personal_information_id)->where('leave_type_id', $sl_id)->first();

        if ($vl_balance && $sl_balance) {
            $update_vl_balance = $vl_balance->update(['balance' => (float) $vl_balance->balance - (float) $vl_deduct]);
            $update_sl_balance = $sl_balance->update(['balance' => (float) $sl_balance->balance - (float) $sl_deduct]);
        }

        $summary->delete();
    }
}
