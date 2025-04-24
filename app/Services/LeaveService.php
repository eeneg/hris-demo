<?php

namespace App\Services;

use App\Repositories\LeaveRepository;
use App\Setting;
use App\Plantilla;
use App\PersonalInformation;
use App\UserAssignment;
use App\LeaveSummary;
use Illuminate\Support\Facades\Auth;

class LeaveService
{
    protected $leaveRepository;

    public function __construct(LeaveRepository $leaveRepository)
    {
        $this->leaveRepository = $leaveRepository;
    }

    public function getLeaveDetails($id)
    {
        $defaultPlantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $defaultPlantilla->value)->first();

        $user = auth('api')->user();

        $personalInfo = PersonalInformation::find($id)->withoutRelations();
        $positionData = $personalInfo
            ->plantillacontents
            ->firstWhere('plantilla_id', $plantilla->id);

        $position = optional($positionData)->position;
        $salary = optional($positionData)->salaryauthorized;

        $leaveSummary = $this->leaveRepository->getLeaveSummary($id);
        $leaveCredits = $this->leaveRepository->getLeaveCredits($id);
        $customLeave = $this->leaveRepository->getCustomLeaves($id);
        $violations = $this->leaveRepository->getViolations($id);
        $anticipatedCredits = $this->leaveRepository->getAnticipatedCredits($id);

        $vl = collect($leaveCredits->where('abbreviation', 'VL')->first())
            ->put('anticipated', $anticipatedCredits ? $anticipatedCredits->vl_balance + 15 : null);
        $sl = collect($leaveCredits->where('abbreviation', 'SL')->first())
            ->put('anticipated', $anticipatedCredits ? $anticipatedCredits->sl_balance + 15 : null);

        return [
            'personalInfo' => $personalInfo,
            'summary' => $leaveSummary,
            'credit' => ['sl' => $sl, 'vl' => $vl],
            'custom_leave' => LeaveSummary::countCustomLeave($customLeave),
            'violations' => LeaveSummary::violationCounter($violations),
            'position' => $position,
            'salary' => $salary,
            'anticipated' => $anticipatedCredits,
        ];
    }
}
