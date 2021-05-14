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

        $lt = LeaveType::where('title', 'Sick Leave')
            ->orWhere('title', 'Vacation Leave')
            ->orWhere('title', 'Forced Leave')
            ->orWhere('title', 'Special Leave Previliges')
            ->get();

        $lc = LeaveCredit::select('leave_credits*')
            ->leftJoin('personal_informations', 'leave_credits.personal_information_id', '=', 'personal_informations.id')
            ->select(
                'personal_informations.surname as surname',
                'personal_informations.firstname as firstname',
                'personal_informations.middlename as middlename',
                'personal_informations.nameextension as nameextension',
                'leave_credits.*'
            )
            ->get();

        $ar = [];

        foreach($lc as $key => $data)
        {
            $type = $lt->firstwhere('id', $data->leave_type_id);

            $ar[$data->personal_information_id][str_replace(' ', '_', strtolower($type->title))]['balance'] = $data->balance;
            $ar[$data->personal_information_id][str_replace(' ', '_', strtolower($type->title))]['year'] = Carbon::parse($data->created_at)->format('Y');

            if(!isset($ar[$data->personal_information_id]['name']))
            {
                $ar[$data->personal_information_id]['name'] = $data->firstname . ' ' . $data->middlename . ' ' . $data->surname . ' ' . $data->nameextension;
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

                $result = floatval($lc->balance + ($request->vl_earned - $request->vl_withpay));

                $lc->update(['balance' => $result]);

                $ls->update(['vl_balance' => $result]);


            }else{

                LeaveCredit::create([
                        'personal_information_id' => $request->personal_information_id,
                        'leave_type_id' => $lt,
                        'balance' => floatval(($ls->vl_earned - $ls->vl_withpay) + $ls->vl_balance),
                ]);

                $ls->update(['vl_balance' => floatval($ls->vl_earned - $ls->vl_withpay)]);

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
                        'balance' => floatval(($ls->sl_earned - $ls->sl_withpay) + $ls->sl_balance),
                ]);

                $ls->update(['sl_balance' => floatval($ls->sl_earned)]);

            }

        }

    }

    public function slp_fl_leave(Request $request){

        $ar = [
            'Forced Leave' => LeaveType::where('title', 'Forced Leave')->first(),
            'Special Leave Previliges' => LeaveType::where('title', 'Special Leave Previliges')->first(),
        ];

        $response = [];

        foreach($ar as $data){

            LeaveCredit::updateOrCreate([
                'personal_information_id'=> $request->id,
                'leave_type_id' => $data->id,
            ],
            [
                'personal_information_id'=> $request->id,
                'leave_type_id' => $data->id,
                'balance' => $data->title == 'Forced Leave' ? $request->fl : $request->slp,
                'created_at' => Carbon::today()->toDateTimeString()
            ]);

        }

        if(count($response) > 0)
        {
            return $response;
        }
    }

    public function editleavesummary(Request $request)
    {
        foreach($request->all() as $data)
        {
            LeaveSummary::find($data['id'])->update($data);
        }
    }

    public function global_credits(Request $request)
    {
        $employees = PersonalInformation::all()->pluck('id');

        $summary = LeaveSummary::where('period', Carbon::now()->format('F Y'))->get()->pluck('personal_information_id');

        $idData = $employees->diff($summary);

        $lt = LeaveType::where('title', 'Sick Leave')
            ->orWhere('title', 'Vacation Leave')
            ->orWhere('title', 'Forced Leave')
            ->orWhere('title', 'Special Leave Previliges')
            ->get();

        foreach( $idData != null ? $idData : $employees  as $id)
        {

            $ls = LeaveSummary::create(
                [
                    'personal_information_id'=> $id,
                    'period' => Carbon::now()->format('F Y'),
                    'vl_earned' => 1.25,
                    'sl_earned' => 1.25,
                ]
            );

            foreach($lt as $type)
            {

                if($type->title == 'Forced Leave' || $type->title == 'Special Leave Previliges')
                {
                    $lc = LeaveCredit::where('personal_information_id', $id)
                        ->where('leave_type_id', $type->id)
                        ->whereYear('created_at', Carbon::now()->format('Y'))
                        ->first();

                    if($lc){

                        $lc->update([
                            'balance' => $type->title == 'Forced Leave' ? 5 : 3,
                            'created_at' => Carbon::today()->toDateTimeString()
                        ]);

                    }else{

                        LeaveCredit::create([
                            'personal_information_id'=> $id,
                            'leave_type_id' => $type->id,
                            'balance' => $type->title == 'Forced Leave' ? 5 : 3,
                            'created_at' => Carbon::today()->toDateTimeString()
                        ]);

                    }

                }else{

                    $lc = LeaveCredit::where('personal_information_id', $id)
                        ->where('leave_type_id', $type->id)
                        ->first();

                    if($lc){

                        $result = floatval($lc->balance + 1.25);

                        $lc->update(['balance' => $result]);

                        $ls->update([$type->title == 'Sick Leave' ? 'sl_balance' : 'vl_balance' => $result]);

                    }else{

                        LeaveCredit::create([
                            'personal_information_id' => $id,
                            'leave_type_id' => $type->id,
                            'balance' => 1.25,
                        ]);

                        $ls->update([$type->title == 'Sick Leave' ? 'sl_balance' : 'vl_balance' => 1.25]);

                    }

                }
            }
        }

        return 'ok';
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
