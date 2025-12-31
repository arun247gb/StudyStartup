<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignStudyMilestoneTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'study_milestone_category_task_id'     => 'required|integer|exists:ss_study_milestone_category_tasks,id',
            'assigned_to' => 'required|integer|exists:ss_users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'study_milestone_category_task_id.required'     => 'Task ID is required.',
            'study_milestone_category_task_id.exists'       => 'Selected task does not exist.',
            'assigned_to.required' => 'Assigned user is required.',
            'assigned_to.exists'   => 'Assigned user does not exist.',
        ];
    }
}
