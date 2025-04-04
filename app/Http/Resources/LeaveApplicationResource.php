<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveApplicationResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'personal_information_id' => $item->personal_information_id,
                'personalinformation' => [
                    'firstname' => $item->personalinformation->firstname,
                    'middlename' => $item->personalinformation->middlename,
                    'nameextension' => $item->personalinformation->nameextension,
                    'surname' => $item->personalinformation->surname,
                    'fullName' => $item->personalinformation->fullName,
                ],
                'leave_type_id' => $item->leave_type_id,
                'leavetype' => [
                    'title' => $item->leavetype->title,
                    'id'    => $item->leavetype->id,
                ],
                'date_of_filing' => $item->date_of_filing,
                'department' => $item->department,
                'position' => $item->position,
                'working_days' => $item->working_days,
                'spent' => $item->spent,
                'spent_specified' => $item->spent_specified,
                'inclusive_dates' => $item->inclusive_dates->mode == 2 ? Carbon::parse($item->inclusive_dates->data->start)->format('m-d-Y') . ' - ' . Carbon::parse($item->inclusive_dates->data->end)->format('m-d-Y') :
                    collect($item->inclusive_dates->data)
                        ->values()
                        ->sort()
                        ->map(fn ($date) => ['month'=> Carbon::parse($date->date)->setTimeZone('Asia/Manila')->format('Y-m'), 'date' => Carbon::parse($date->date)->setTimeZone('Asia/Manila')->format('d')])
                        ->groupBy('month')
                        ->map(function ($entry) {
                            return Carbon::parse($entry[0]['month'])->format('M') . ' ' . collect($entry)->map(fn ($e) => $e['date'])->join(', ') . ' ' . Carbon::parse($entry[0]['month'])->format('Y');
                    })->join(' - '),
                'vacation_balance'                      => $item->vacation_balance,
                'vacation_less'                         => $item->vacation_less,
                'sick_balance'                          => $item->sick_balance,
                'sick_less'                             => $item->sick_less,
                'credit_officer'                        => $item->credit_officer,
                'recommendation_officer'                => $item->recommendation_officer,
                'recommendation_approved'               => $item->recommendation_approved,
                'recommendation_disapproved_due_to'     => $item->recommendation_disapproved_due_to,
                'noted_by_officer'                      => $item->noted_by_officer,
                'noted_by_approved'                     => $item->noted_by_approved,
                'noted_disapproved_due_to'              => $item->noted_disapproved_due_to,
                'governor_approval_officer'             => $item->governor_approval_officer,
                'governor_approved'                     => $item->governor_approved,
                'gov_disapproved_due_to'                => $item->gov_disapproved_due_to,
                'final'                                 => $item->final,
                'application_stage'                     => $item->application_stage,
            ];
        });
    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://www.davsurians.com.ph/'),
        ];
    }
}
