<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SsStudyMilestoneCategoryTaskResource;

class SsStudyMilestoneCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'ss_study_milestone_category_id' => $this->id,
            'ss_milestone_category_id'       => $this->ss_milestone_category_id,
            'study_category_name'            => $this->study_category_name,
            'order'                          => $this->order,
            'is_active'                      => $this->is_active,
            'tasks'                          => $this->tasks ? SsStudyMilestoneCategoryTaskResource::collection($this->tasks) : null,
            'created_at'                     => $this->created_at,
            'updated_at'                     => $this->updated_at,
        ];
    }
}