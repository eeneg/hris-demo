<?php

namespace App\Repositories;

use App\LeaveSummary;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveRepository
{
    public function getLeaveSummary($personalInfoId)
    {
        return LeaveSummary::where('personal_information_id', $personalInfoId)
            ->orderBy('sort', 'ASC')
            ->get();
    }

    public function getLeaveCredits($personalInfoId)
    {
        return DB::table('leave_credits')
            ->leftJoin('leave_types', 'leave_credits.leave_type_id', '=', 'leave_types.id')
            ->where('personal_information_id', $personalInfoId)
            ->where(function ($query) {
                $query->whereIn('leave_types.title', ['Sick Leave', 'Vacation Leave']);
            })
            ->get();
    }

    public function getCustomLeaves($personalInfoId)
    {
        return LeaveSummary::where('personal_information_id', $personalInfoId)
            ->whereNotNull('particulars->leave_type')
            ->where(function ($query) {
                $query->where('particulars->leave_type', 'PL')
                ->orWhere('particulars->leave_type', 'FL')
                ->orWhere('particulars->leave_type', 'SPL')
                ->orWhere('particulars->leave_type', 'SP')
                ->orWhere('particulars->leave_type', 'SOLO')
                ->orWhere('particulars->leave_type', 'UFL')
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
    }

    public function getViolations($personalInfoId)
    {
        return LeaveSummary::where('personal_information_id', $personalInfoId)
            ->whereNotNull('particulars->leave_type')
            ->whereIn('particulars->leave_type', ['Undertime', 'Tardy', 'UA', 'AWOL', 'SLWOP', 'VLWOP'])
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
                    'count' => $data->particulars->count ?? $data->particulars->days,
                ];
            });
    }

    public function getAnticipatedCredits($personalInfoId)
    {
        return LeaveSummary::where('personal_information_id', $personalInfoId)
            ->whereNotNull('vl_earned')
            ->where('vl_earned', '>', 0)
            ->whereNotNull('sl_earned')
            ->where('sl_earned', '>', 0)
            ->where('sl_withpay', '=', 0)
            ->where('vl_withpay', '=', 0)
            ->where('period->mode', 4)
            ->where('period->data', Carbon::now()->format('Y'))
            ->first();
    }
}
