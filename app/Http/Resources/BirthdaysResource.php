<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BirthdaysResource extends ResourceCollection
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
                'fullName'    => $item->personalinformation->fullName,
                'birthdate' => $item->personalinformation->birthdate,
                'office' => $item->position->department->address,
                'position' => $item->position->title
            ];
        });
    }
}
