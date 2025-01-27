<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReappointmentResource extends ResourceCollection
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
                'name' => $item->surname.', '.$item->firstname.' '.$item->middlename.' '.$item->nameextension,
                'dept_from' => $item->dept_from,
                'dept_to' => $item->dept_to,
                'assigned_from' => $item->assigned_from,
                'assigned_to' => $item->assigned_to,
                'type' => $item->type,
                'position' => $item->position,
                'duties' => $item->duties,
                'effectivity_date' => $item->effectivity_date,
                'termination_date' => $item->termination_date,
            ];
        });
    }
}
