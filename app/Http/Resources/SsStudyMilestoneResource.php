<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SsStudyMilestoneCategoryResource;
use App\Enums\StudyMilestoneStatus;

class SsStudyMilestoneResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                    => $this->id,
            'ss_study_milestone_id' => $this->id,
            'ss_milestone_id'       => $this->ss_milestone_id,
            'name'                  => $this->name,
            'order'                 => $this->order,
            'start_date'            => $this->start_date,
            'planned_due_date'      => $this->planned_due_date,
            'actual_completion_date' => $this->completion_date,
            'enum_status'           => $this->enum_status,
            'status_label'          => StudyMilestoneStatus::getAttribute($this->enum_status),
            'categories'            => $this->categories ? SsStudyMilestoneCategoryResource::collection($this->categories) : null,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
