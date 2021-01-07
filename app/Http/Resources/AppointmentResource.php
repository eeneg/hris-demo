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
                'id' => $item->personalInfoId,
                'salary_grade_id' => $item->salary_grade_auth_id,
                'firstname' => $item->firstname,
                'middlename' => $item->middlename,
                'nameextension' => $item->nameextension,
                'surname' => $item->surname,
                'department' => $item->deptTitle ? $item->deptTitle : '',
                'position' => [
                    'id' => $item->positionId ? $item->positionId : '',
                    'title' => $item->positionTitle ? $item->positionTitle : '',
                ],
                'appointment' => [
                    'id' => $item->id ? $item->id : '',
                    'status' => $item->status ? $item->status : '',
                    'nature_of_appointment' => $item->nature_of_appointment ? $item->nature_of_appointment : '',
                    'reckoning_date' => $item->reckoning_date ? $item->reckoning_date : ''
                ]
            ];
        });

    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://www.davsurians.com.ph/')
        ];
    }
}
