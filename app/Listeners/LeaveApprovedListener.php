<?php

namespace App\Listeners;

use App\Events\LeaveProcessed;
use App\LeaveCredit;
use App\LeaveSummary;
use App\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeaveApprovedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LeaveProcessed  $event
     * @return void
     */
    public function handle(LeaveProcessed $event)
    {
        $data = $event->application;

        $sl = LeaveType::where('title', 'Sick Leave')->first();
        $vl = LeaveType::where('title', 'Vacation Leave')->first();

        $is_sl = $sl->id == $data->leave_type_id;

        $leave_type = LeaveType::find($data->leave_type_id);

        $count = LeaveSummary::where('personal_information_id', $data->personal_information_id)->count();

        $leave = [
            'id' => Str::orderedUuid()->toString(),
            'personal_information_id' => $data->personal_information_id,
            'period' => json_encode(['mode' => 2, 'data' => ['start' => $data->from, 'end' => $data->to]]),
            'particulars' => json_encode(['leave_type' => $leave_type->abbreviation, 'days' => $data->working_days, 'hours' => null, 'mins' => null]),
            'vl_earned' => 0,
            'vl_withpay' => $is_sl != true ? $data->days_with_pay : 0,
            'vl_balance' => $data->vacation_balance,
            'vl_withoutpay' => $is_sl != true ? $data->days_without_pay : 0,
            'sl_earned' => 0,
            'sl_withpay' => $is_sl ? $data->days_with_pay : 0,
            'sl_balance' => $data->sick_balance,
            'sl_withoutpay' => $is_sl ? $data->days_without_pay : 0,
            'remarks' => '',
            'sort' => $count == 0 ? 0 : LeaveSummary::select('personal_information_id', 'sort')->where('personal_information_id', $data->personal_information_id)->max('sort') + 1,
        ];

        LeaveCredit::updateOrCreate(['personal_information_id' => $this->request->personal_information_id, 'leave_type_id' => $sl->id], ['balance' => $data->sick_balance]);
        LeaveCredit::updateOrCreate(['personal_information_id' => $this->request->personal_information_id, 'leave_type_id' => $vl->id], ['blanace' => $data->vacation_balance]);

        return LeaveSummary::insert($leave);
    }
}
