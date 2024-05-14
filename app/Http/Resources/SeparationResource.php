<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeparationResource extends ResourceCollection
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
                'firstname' => $item->personalinformation ? $item->personalinformation->firstname : '',
                'middlename' => $item->personalinformation ? $item->personalinformation->middlename : '',
                'surname' => $item->personalinformation ? $item->personalinformation->surname : '',
                'nameextension' => $item->personalinformation ? $item->personalinformation->nameextension : '',
                'birthdate' => $item->personalinformation ? $item->personalinformation->birthdate : '',
                'picture' => $item->personalinformation ? $item->personalinformation->picture : '',
                'mode' => $item->mode,
                'position' => $item->position,
                'appointment_status' => $item->appointment_status,
                'salary_grade' => $item->salary_grade,
                'description' => $item->description,
                'effectivity_date' => $item->effectivity_date,
                'office' => $item->office,
                'item_no' => $item->item_no,
            ];
        });
    }
}
