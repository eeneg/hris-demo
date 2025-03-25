<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlantillaEmployeesNOSIResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return $this->collection->map->toArray($request)->all();
        return $this->collection->map(function ($item) {
            $nextStep = $item->getNextStep();
            $previousStep = $item->getPreviousStep();
            return [
                'item_no' => $item->new_number ? $item->new_number : $item->old_number,
                'office' => $item->position->department->address,
                'position' => $item->position ? $item->position->title : '',
                'name' => $item->personalinformation->firstname.' '.$item->personalinformation->middlename.' '.$item->personalinformation->surname.' '.$item->personalinformation->nameextension,
                'name2' => $item->personalinformation->surname.', '.$item->personalinformation->firstname.' '.$item->personalinformation->nameextension.' '.$item->personalinformation->middlename,
                'surname' => $item->personalinformation->surname,
                'title' => $item->personalinformation->sex == 'Male' ? 'Mr.' : 'Ms.',
                'salaryproposed' => $item->salaryproposed,
                'nextStepAmount' => $item->working_time == 'Full-time' ? ($nextStep ? $nextStep->amount : 0) : ($nextStep ? $nextStep->amount / 2 : 0),
                'previousStepAmount' => $item->working_time == 'Full-time' ? ($previousStep ? $previousStep->amount : 0) : ($previousStep ? $previousStep->amount / 2 : 0),
                'nosi_schedule' => $item->personalinformation->benefitschedule->nosi,
                'working_time' => $item->working_time,
            ];
        });
    }

    // public function with($request)
    // {
    //     return [
    //         'version' => '1.0.0',
    //         'author_url' => url('http://www.davsurians.com.ph/'),
    //     ];
    // }
}
