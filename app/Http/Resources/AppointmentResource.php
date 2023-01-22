<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AppointmentResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id ? $item->id : '',
                'status' => $item->status ? $item->status : '',
                'agency' => $item->agency ? $item->agency : '',
                'nature_of_appointment' => $item->nature_of_appointment ? $item->nature_of_appointment : '',
                'previous_employee' => $item->previous_employee ? $item->previous_employee : '',
                'previous_status' => $item->previous_status ? $item->previous_status : '',
                'itemno' => $item->itemno,
                'page' => $item->page,
                'reckoning_date' => $item->reckoning_date,
                'personal_information' => [
                    'id' => $item->personal_information_id ? $item->personal_information_id : '',
                    'firstname' => $item->firstname ? $item->firstname : '',
                    'surname' => $item->surname ? $item->surname : '',
                    'nameextension' => $item->nameextension ? $item->nameextension : '',
                ],
                'department' => [
                    'id' => $item->dept_id,
                    'title' => $item->dept_title,
                ],
                'position' => [
                    'id' => $item->position_id,
                    'title' => $item->position_title,
                ],
                'salary_sched' => [
                    'id' => $item->salary_schedules_id,
                    'tranche' => $item->tranche,
                ],
                'salary_grade' => [
                    'id' => $item->salary_grade_id,
                    'grade' => $item->grade,
                    'step' => $item->step,
                ],
            ];
        });
    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('http =>//www.davsurians.com.ph/'),
        ];
    }
}
