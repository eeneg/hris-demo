<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlantillaContentReportsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'personal_information_id' => $item->personal_information_id,
                'sex' => $item->personalinformation ? $item->personalinformation->sex : '',
                'old_number' => $item->old_number,
                'new_number' => $item->new_number,
                'order_number' => $item->order_number,
                'working_time' => $item->working_time,
                'level' => $item->level,
                'original_appointment' => $item->original_appointment,
                'last_promotion' => $item->last_promotion,
                'appointment_status' => $item->appointment_status,
                'office' => $item->position ? $item->position->department->address : '',
                'position' => $item->position ? $item->position->title : '',
                'position_id' => $item->position ? $item->position->id : '',
                'name' => $item->personalinformation ? $item->personalinformation->surname.', '.$item->personalinformation->firstname.' '.$item->personalinformation->nameextension.' '.$item->personalinformation->middlename : 'VACANT',
                'salaryauthorized' => $item->salaryauthorized,
                'salaryproposed' => $item->salaryproposed,
            ];
        });
    }
}
