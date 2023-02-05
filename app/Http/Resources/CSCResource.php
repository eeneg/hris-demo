<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CSCResource extends ResourceCollection
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
                'item_no' => $item->new_number ? $item->new_number : $item->old_number,
                'position' => $item->position->title,
                'salary_auth_grade' => $item->salaryauthorized ? $item->salaryauthorized->grade : '',
                'salary_auth_amount' => $item->salaryauthorized ? number_format($item->salaryauthorized->amount * 12) : '',
                'salary_prop_grade' => $item->salaryproposed ? $item->salaryproposed->grade : '',
                'salary_prop_amount' => $item->salaryproposed ? number_format($item->salaryproposed->amount * 12) : '',
                'salary_prop_step' => $item->salaryproposed ? $item->salaryproposed->step : '',
                'level' => substr($item->level,0,1),
                'surname' => $item->personalinformation ? $item->personalinformation->surname . ($item->personalinformation->nameextension ? ', '.$item->personalinformation->nameextension : '') : '',
                'firstname' => $item->personalinformation ? $item->personalinformation->firstname : 'VACANT',
                'middlename' => $item->personalinformation ? $item->personalinformation->middlename : '',
                'birthdate' => $item->personalinformation ? (is_null($item->personalinformation->birthdate) ? '' : $item->personalinformation->birthdate) : '',
                'original_appointment' => $item->original_appointment,
                'last_promotion' => $item->last_promotion,
                'appointment_status' => substr($item->appointment_status,0,1)
            ];
        });
    }
}
