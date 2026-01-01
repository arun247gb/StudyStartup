<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SsMilestoneCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $type = $request->query('type') ?? $this->additional['type'] ?? null;

        return [
            'id'               => $this->id,
            'ss_milestone_id'  => $this->ss_milestone_id,
            'category_name'    => $this->category_name,
            'description'      => $this->description,
            'order'            => $this->order,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,

            'tasks' => $this->tasks
                ->when($type, function ($tasks) use ($type) {
                    return $tasks->where('study_setup_type', $type)->values();
                })
                ->map(function ($task) {
                    return [
                        'id'                => $task->id,
                        'ss_milestone_categories_id' => $task->ss_milestone_categories_id ?? null,
                        'name'              => $task->name,
                        'study_setup_type'  => $task->study_setup_type,
                        'is_active'         => $task->is_active,
                        'order'             => $task->order,
                        'created_at'        => $task->created_at,
                        'updated_at'        => $task->updated_at,
                    ];
                }),
        ];
    }
}
