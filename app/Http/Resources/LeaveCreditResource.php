<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveCreditResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'name' => $item->fullName,
                'civilstatus' => $item->civilstatus,
                'birthdate' => $item->birthdate,
                'retirement_date' => $item->retirement_date,
                'status' => $item->status,
            ];
        });
    }
}
