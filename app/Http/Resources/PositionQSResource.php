<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PositionQSResource extends ResourceCollection
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
                'title' => $item->title,
                'qs_id' => $item->qs ? $item->qs->id : '',
                'qs_sg' => $item->qs ? $item->qs->sg : '',
                'qs_education' => $item->qs ? $item->qs->education : '',
                'qs_experience' => $item->qs ? $item->qs->experience : '',
                'qs_training' => $item->qs ? $item->qs->training : '',
                'qs_eligibility' => $item->qs ? $item->qs->eligibility : ''
            ];
        });
    }
}
