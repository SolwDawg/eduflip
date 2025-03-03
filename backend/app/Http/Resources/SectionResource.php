<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->hashid,
            'title' => $this->title,
            'course' => $this->course->hashid,
            'sort_order' => $this->sort_order,
            'can_trash' => ! $this->lectures->count(),
            'lectures' => LectureResource::collection($this->whenLoaded('lectures'))
        ];
    }
}
