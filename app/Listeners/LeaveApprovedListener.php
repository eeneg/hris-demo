<?php

namespace App\Listeners;

use App\Events\LeaveProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use App\LeaveCredit;
use App\LeaveType;


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
        $sl = LeaveType::where('title', 'Sick Leave')->first();
        $vl = LeaveType::where('title', 'Vacation Leave')->first();

        $sl_credit = LeaveCredit::where('personal_information_id', $this->request->personal_information_id)->where('leave_type_id', $sl->id)->first();
        $vl_credit = LeaveCredit::where('personal_information_id', $this->request->personal_information_id)->where('leave_type_id', $vl->id)->first();




        return $leave_credit;

    }
}
