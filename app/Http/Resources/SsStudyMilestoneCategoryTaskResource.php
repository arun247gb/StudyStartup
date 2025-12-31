<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\StudyMilestoneStatus;

class SsStudyMilestoneCategoryTaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'ss_milestone_category_task_id' => $this->id,
            'name'                          => $this->name,
            'completion_type'               => $this->completion_type,
            'study_setup_type'              => $this->study_setup_type,
            'required'                      => $this->required ?? true,
            'planned_start_date'            => $this->planned_start_date ?? null,
            'planned_due_date'              => $this->planned_due_date ?? null,
            'actual_start_date'             => $this->actual_start_date ?? null,
            'actual_due_date'               => $this->actual_due_date ?? null,
            'enum_status'                   => $this->enum_status ?? StudyMilestoneStatus::notStarted()->value,
            'status_label'                  => StudyMilestoneStatus::getAttribute($this->enum_status ?? StudyMilestoneStatus::notStarted()->value),
            'is_active'                     => $this->is_active ?? true,
            'created_at'                    => $this->created_at,
            'updated_at'                    => $this->updated_at,
        ];
    }
}
