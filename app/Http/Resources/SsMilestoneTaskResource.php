<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SsMilestoneTaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ss_milestone_categories_id' => $this->ss_milestone_categories_id,
            'study_setup_type' => $this->study_setup_type,
            'completion_type' => $this->completion_type,
            'name' => $this->name,
            'order' => $this->order,
            'is_active' => $this->is_active,
            "created_at" =>$this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
