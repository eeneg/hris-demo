<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JDResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->resource == null) {
            return null;
        }
        return [
            'id' => $this->id,
            'plantilla_content_id' => $this->plantilla_content_id,
            'description' => $this->description,
        ];
    }
}
