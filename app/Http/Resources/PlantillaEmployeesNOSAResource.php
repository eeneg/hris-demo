<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlantillaEmployeesNOSAResource extends ResourceCollection
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
                'office' => $item->position->department->address,
                'position' => $item->position ? $item->position->title : '',
                'name' => $item->personalinformation->firstname.' '.$item->personalinformation->middlename.' '.$item->personalinformation->surname.' '.$item->personalinformation->nameextentsion,
                'salaryproposed' => $item->salaryproposed,
                'salaryauthorized' => $item->salaryauthorized,
                'item_no' => $item->new_number ? $item->new_number : $item->old_number,
                'plantilla' => $item->plantilla->year,
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
