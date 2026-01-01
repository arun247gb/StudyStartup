<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsStudyMilestoneCategoryTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_study_id'                         => 'required|exists:ss_studies,id',
            'ss_organisation_id'                  => 'nullable|exists:ss_organizations,id',

            'ss_study_milestone_category_id'      => 'required|exists:ss_study_milestone_categories,id',
            'ss_milestone_category_tasks_id'      => 'nullable|exists:ss_milestone_category_tasks,id',

            'study_setup_type'                    => 'required|in:external,internal',
            'completion_type'                     => 'nullable|in:MANUAL,AUTO',

            'name'                                => 'required|string|max:255',
            'description'                         => 'nullable|string',

            'enum_status'                         => 'nullable|integer',
            'required'                            => 'boolean',

            'planned_start_date'                  => 'nullable|date',
            'planned_due_date'                    => 'nullable|date',
            'actual_start_date'                   => 'nullable|date',
            'actual_completion_date'              => 'nullable|date',

            'order'                               => 'nullable|integer',

            'assigned_to'                         => 'nullable|exists:ss_users,id',
            'updated_by'                          => 'nullable|exists:ss_users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_study_id.required' => 'Study ID is required.',
            'ss_study_id.exists'   => 'The selected study does not exist.',

            'ss_organisation_id.exists' => 'The selected organization does not exist.',

            'ss_study_milestone_category_id.required' => 'Study milestone category is required.',
            'ss_study_milestone_category_id.exists'   => 'The selected study milestone category does not exist.',

            'ss_milestone_category_tasks_id.exists'   => 'The selected master category task does not exist.',

            'study_setup_type.required' => 'Study setup type is required.',
            'study_setup_type.in'       => 'Study setup type must be external or internal.',

            'completion_type.in'        => 'Completion type must be MANUAL or AUTO.',

            'name.required'             => 'Task name is required.',
            'name.string'               => 'Task name must be a string.',
            'name.max'                  => 'Task name may not exceed 255 characters.',

            'description.string'        => 'Description must be a valid string.',

            'enum_status.integer'       => 'Status must be an integer value.',

            'required.boolean'          => 'Required must be true or false.',

            'planned_due_date.after_or_equal' =>
                'Planned due date must be after or equal to planned start date.',

            'actual_completion_date.after_or_equal' =>
                'Actual completion date must be after or equal to actual start date.',

            'order.integer'             => 'Order must be an integer.',

            'assigned_to.exists'        => 'Assigned user does not exist.',
            'updated_by.exists'         => 'Updated by user does not exist.',
        ];
    }
}
