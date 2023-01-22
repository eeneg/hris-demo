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
            return [
                'original_appointment' => $item->original_appointment,
                'last_promotion' => $item->last_promotion,
                'office' => $item->position->department->address,
                'position' => $item->position ? $item->position->title : '',
                'name' => $item->personalinformation->firstname.' '.$item->personalinformation->middlename.' '.$item->personalinformation->surname.' '.$item->personalinformation->nameextentsion,
                'salaryproposed' => $item->salaryproposed,
                'nextStepAmount' => $item->amount,
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
