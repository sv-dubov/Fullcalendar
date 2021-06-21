<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'start' => $this->start_time->format('Y-m-d\TH:i:s\Z'),
            'end' => $this->end_time->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
