<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlantillaContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'old_number' => $this->old_number,
            'new_number' => $this->new_number,
            'position' => $this->position ? $this->position->title : '',
            'firstname' => $this->personalinformation ? $this->personalinformation->firstname : '',
            'middlename' => $this->personalinformation ? $this->personalinformation->middlename : '',
            'surname' => $this->personalinformation ? $this->personalinformation->surname : '',
            'nameextension' => $this->personalinformation ? $this->personalinformation->nameextension : '',
            'salaryauthorized' => $this->salaryauthorized,
            'salaryproposed' => $this->salaryproposed
        ];
    }
}
