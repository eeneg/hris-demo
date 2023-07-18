<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QSResource extends ResourceCollection
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
                'position' => $item->position,
                'sg' => $item->sg,
                'education' => $item->education,
                'experience' => $item->experience,
                'training' => $item->training,
                'eligibility' => $item->eligibility,
            ];
        });
    }
}
