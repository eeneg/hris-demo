<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeAppointmentListResource;
use App\LeaveCredit;
use App\LeaveSummary;
use App\LeaveType;
use App\PersonalInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lc = LeaveCredit::all();

        $lt = LeaveType::where('title', 'Sick Leave')->orWhere('title', 'Vacation Leave')->get();

        $ar = [];

        foreach($lc as $key => $data)
        {
            foreach($lt as $leaveType)
            {
                if($leaveType->title == 'Sick Leave' || $leaveType->title == 'Vacation Leave')
                {
                    $ar[$data->personal_information_id][$leaveType->title == 'Sick Leave' ? 'sick_leave' : 'vacation_leave'] = $data->balance != '' && $data->balance != null  ? $data->balance : 0;
                }else{
                    abort(403, 'Leave balance not found, possible leave type data change');
                }
            }
        }

        return $ar;
    }

    function getLeaveSummary(Request $request)
    {
        return LeaveSummary::where('personal_information_id', $request->id,)->orderBy('created_at', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ls = LeaveSummary::create($request->all());

        if($ls->vl_earned)
        {

            $lt = LeaveType::where('title', 'Vacation Leave')->first()->id;

            $lc = LeaveCredit::where('personal_information_id', $request->personal_information_id,)
                ->where('leave_type_id', $lt)
                ->first();

            if(isset($lc))
            {

                $result = floatval($lc->balance + $request->vl_earned);

                $lc->update(['balance' => $result]);

                $ls->update(['vl_balance' => $result]);


            }else{

                LeaveCredit::create([
                        'personal_information_id' => $request->personal_information_id,
                        'leave_type_id' => $lt,
                        'balance' => floatval($ls->vl_earned + $ls->vl_balance),
                ]);

                $ls->update(['vl_balance' => floatval($ls->vl_earned)]);

            }

        }

        if($ls->sl_earned){

            $lt = LeaveType::where('title', 'Sick Leave')->first()->id;

            $lc = LeaveCredit::where('personal_information_id', $request->personal_information_id,)
                ->where('leave_type_id', $lt)
                ->first();

            if(isset($lc))
            {

                $result = floatval($lc->balance + $request->sl_earned);

                $lc->update(['balance' => $result]);

                $ls->update(['sl_balance' => $result]);

            }else{

                LeaveCredit::create([
                        'personal_information_id' => $request->personal_information_id,
                        'leave_type_id' => $lt,
                        'balance' => floatval($ls->sl_earned + $ls->sl_balance),
                ]);

                $ls->update(['sl_balance' => floatval($ls->sl_earned)]);

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
