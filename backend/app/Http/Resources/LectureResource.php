<?php

namespace App\Http\Resources;

use App\Enums\LectureType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
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
            'sort_order' => $this->sort_order,
            'course' => $this->course?->hashid,
            'section' => $this->section?->hashid,
            'type' => $this->type,
            'body' => $this->body,
            'duration' => [
                'hms' => $this->duration_hms
            ],
            'has_content' => $this->hasContent(),
            'video' => $this->when($this->type == LectureType::VIDEO && $this->video()->exists(), [
                'id' => $this->video?->hashid,
                'src' => '',
                'type' => $this->video?->mime_type,
                'filename' => $this->video?->original_file_name,
                'status' => $this->video?->status,
                'percent' => $this->video?->processing_percent
            ]),
        ];
    }
}
