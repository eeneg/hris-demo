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
        $slwop = LeaveType::where('title', 'Sick Leave Without Pay')->first();
        $vl = LeaveType::where('title', 'Vacation Leave')->first();

        $is_sl = ($sl->id == $data->leave_type_id) || ($slwop->id == $data->leave_type_id);

        $leave_type = LeaveType::find($data->leave_type_id);

        $count = LeaveSummary::where('personal_information_id', $data->personal_information_id)->count();

        $sl_credits = LeaveCredit::where('personal_information_id', $data->personal_information_id)->where('leave_type_id', $sl->id)->first();
        $vl_credits = LeaveCredit::where('personal_information_id', $data->personal_information_id)->where('leave_type_id', $vl->id)->first();

        $leave = [
            'id' => Str::orderedUuid()->toString(),
            'personal_information_id' => $data->personal_information_id,
            'period' => json_encode(['mode' => 2, 'data' => ['start' => $data->from, 'end' => $data->to]]),
            'particulars' => json_encode(['leave_type' => $leave_type->abbreviation, 'days' => $data->working_days, 'hours' => null, 'mins' => null]),
            'vl_earned' => 0,
            'vl_withpay' => $is_sl != true ? $data->days_with_pay : 0,
            'vl_balance' => $vl_credits->balance - $data->vacation_less,
            'vl_withoutpay' => $is_sl != true ? $data->days_without_pay : 0,
            'sl_earned' => 0,
            'sl_withpay' => $is_sl ? $data->days_with_pay : 0,
            'sl_balance' => $sl_credits->balance - $data->sick_less,
            'sl_withoutpay' => $is_sl ? $data->days_without_pay : 0,
            'remarks' => '',
            'sort' => $count == 0 ? 0 : LeaveSummary::select('personal_information_id', 'sort')->where('personal_information_id', $data->personal_information_id)->max('sort') + 1,
        ];

        $s = LeaveCredit::updateOrCreate(['personal_information_id' => $this->request->personal_information_id, 'leave_type_id' => $sl->id], ['balance' => $sl_credits->balance - $data->sick_less]);
        $d = LeaveCredit::updateOrCreate(['personal_information_id' => $this->request->personal_information_id, 'leave_type_id' => $vl->id], ['balance' => $vl_credits->balance - $data->vacation_less]);

        return LeaveSummary::insert($leave);
    }
}
