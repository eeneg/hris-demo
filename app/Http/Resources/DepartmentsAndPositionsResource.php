<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class DepartmentsAndPositionsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id'    => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'address' => $item->address,
                'function' => $item->function,
                'projectactivity' => $item->projectactivity,
                'fund' => $item->fund,
                'positions' => $item->position->map(function ($item, $key) {
                    return $item->only(['id', 'department_id', 'title']);
                })
            ];
        });
    }
}
