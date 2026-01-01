<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SsMilestoneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $type = $this->additional['type'] ?? null;
        return [
            'id'                 => $this->id,
            'milestone_owner_id' => $this->milestone_owner_id,
            'name'               => $this->name,
            'order'              => $this->order,
            'is_active'          => $this->is_active,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
            'categories' => $this->categories->map(function ($category) use ($type) {
                return [
                    'id'            => $category->id,
                    'category_name' => $category->category_name,
                    'order'         => $category->order,
                    'tasks'         => $category->tasks
                        ->when($type, fn($tasks) => $tasks->where('study_setup_type', $type)->values())
                        ->map(fn($task) => [
                            'id'                 => $task->id,
                            'name'               => $task->name,
                            'study_setup_type'   => $task->study_setup_type,
                            'is_active'          => $task->is_active,
                            'order'              => $task->order,
                        ]),
                ];
            }),
        ];
    }
}
