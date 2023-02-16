<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlantillaContentResource extends ResourceCollection
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
                'id' => $item->id,
                'personal_information_id' => $item->personal_information_id,
                'old_number' => $item->old_number,
                'new_number' => $item->new_number,
                'order_number' => $item->order_number,
                'working_time' => $item->working_time,
                'level' => $item->level,
                'original_appointment' => $item->original_appointment,
                'last_promotion' => $item->last_promotion,
                'appointment_status' => $item->appointment_status,
                'position' => $item->position ? $item->position->title : '',
                'position_id' => $item->position ? $item->position->id : '',
                'firstname' => $item->personalinformation ? $item->personalinformation->firstname : '',
                'middlename' => $item->personalinformation ? $item->personalinformation->middlename : '',
                'surname' => $item->personalinformation ? $item->personalinformation->surname : '',
                'nameextension' => $item->personalinformation ? $item->personalinformation->nameextension : '',
                'birthdate' => $item->personalinformation ? $item->personalinformation->birthdate : '',
                'salaryauthorized' => $item->salaryauthorized,
                'salaryproposed' => $item->salaryproposed,
                'csc_level' => $item->csc_level
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
