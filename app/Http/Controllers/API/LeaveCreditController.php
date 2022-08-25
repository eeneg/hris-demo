<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveCreditResource;
use App\LeaveCredit;
use App\LeaveSummary;
use App\LeaveType;
use App\PersonalInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $employee = PersonalInformation::orderBy('surname')->get();

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

        foreach($request['data'] as $key => $value)
        {
            if($vl_balance < $value['vl_balance'])
            {
                $vl_balance = $value['vl_balance'];
            }

            if($sl_balance < $value['sl_balance'])
            {
                $sl_balance = $value['sl_balance'];
            }

            if(!isset($value['id']))
            {
                array_push($forCreate, $value);
            }else{
                array_push($forUpdate, $value);
            }
        }

        $vl_balance = LeaveCredit::updateOrCreate(['personal_information_id' => $request['id'], 'leave_type_id' => $vl_id], ['balance' => $vl_balance]);
        $sl_balance = LeaveCredit::updateOrCreate(['personal_information_id' => $request['id'], 'leave_type_id' => $sl_id], ['balance' => $sl_balance]);


        if(count($forCreate))
        {
           foreach($forCreate as $value)
           {
                $create = LeaveSummary::create($value);
           }
        }

        if(count($forUpdate))
        {
            foreach($forUpdate as $key => $value)
            {
                $update = LeaveSummary::find($value['id'])->update($value);
            }
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



        $leaveSummary = LeaveSummary::where('personal_information_id', $id)->orderBy('sort', 'ASC')->get();

        $leaveCredit    =   DB::table('leave_credits')
                            ->leftJoin('leave_types', 'leave_credits.leave_type_id', '=', 'leave_types.id')
                            ->where('personal_information_id', $id)
                            ->where(function ($query) {
                                $query->where('leave_types.title', 'Sick Leave')
                                ->orWhere('leave_types.title', 'Vacation Leave');
                            })
                            ->get();

        $custom_leave = LeaveSummary::where('personal_information_id', $id)->where('custom_leave', '!=', '')->where('custom_leave', '!=', null)
                        ->where('period', 'like', Carbon::now()->year . '%')->get()->groupBy('custom_leave')->map->count();

        return ['summary' => $leaveSummary, 'credit' => $leaveCredit, 'custom_leave' => $custom_leave];

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

        $vl_deduct  = $summary->vl_earned - $summary->vl_withpay;
        $sl_deduct = $summary->sl_earned - $summary->sl_withpay;

        $vl_id = LeaveType::where('title', 'Vacation Leave')->first()->id;
        $sl_id = LeaveType::where('title', 'Sick Leave')->first()->id;

        $vl_balance = LeaveCredit::where('personal_information_id', $summary->personal_information_id)->where('leave_type_id', $vl_id)->first();
        $sl_balance = LeaveCredit::where('personal_information_id', $summary->personal_information_id)->where('leave_type_id', $sl_id)->first();

        if($vl_balance && $sl_balance)
        {
            $update_vl_balance = $vl_balance->update(['balance' => (float)$vl_balance->balance - (float)$vl_deduct]);
            $update_sl_balance = $sl_balance->update(['balance' => (float)$sl_balance->balance - (float)$sl_deduct]);
        }

        $summary->delete();

    }
}
