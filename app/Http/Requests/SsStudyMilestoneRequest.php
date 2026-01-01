<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsStudyMilestoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'ss_organisation_id' => 'required|exists:ss_organizations,id',
            'ss_site_id'         => 'required|exists:ss_sites,id',

            'milestones'                           => 'required|array|min:1',
            'milestones.*.ss_milestone_id'         => 'required|exists:ss_milestones,id',
            'milestones.*.name'                    => 'required|string|max:255',
            'milestones.*.order'                   => 'nullable|integer',
            'milestones.*.start_date'              => 'nullable|date',
            'milestones.*.planned_due_date'        => 'nullable|date',

            'milestones.*.categories'                                => 'required|array|min:1',
            'milestones.*.categories.*.ss_milestone_category_id'     => 'required|exists:ss_milestone_categories,id',
            'milestones.*.categories.*.study_category_name'          => 'required|string|max:255',
            'milestones.*.categories.*.order'                        => 'nullable|integer',
            'milestones.*.categories.*.is_active'                    => 'nullable|boolean',

            'milestones.*.categories.*.tasks'                         => 'required|array|min:1',
            'milestones.*.categories.*.tasks.*.ss_milestone_category_tasks_id'
                                                                      => 'required|exists:ss_milestone_category_tasks,id',
            'milestones.*.categories.*.tasks.*.name'                  => 'required|string|max:255',
            'milestones.*.categories.*.tasks.*.required'              => 'nullable|boolean',
            'milestones.*.categories.*.tasks.*.planned_start_date'    => 'nullable|date',
            'milestones.*.categories.*.tasks.*.planned_due_date'      => 'nullable|date',
            'milestones.*.categories.*.tasks.*.study_setup_type'      => 'nullable|string|max:100',
            'milestones.*.categories.*.tasks.*.completion_type'       => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_organisation_id.required' => 'Organization is required.',
            'ss_organisation_id.exists'   => 'Selected organization does not exist.',

            'ss_site_id.required'         => 'Site is required.',
            'ss_site_id.exists'           => 'Selected site does not exist.',

            'milestones.required'         => 'At least one milestone is required.',
            'milestones.array'            => 'Milestones must be an array.',
            'milestones.min'              => 'At least one milestone is required.',

            'milestones.*.ss_milestone_id.required' => 'Milestone ID is required.',
            'milestones.*.ss_milestone_id.exists'   => 'Selected milestone does not exist.',

            'milestones.*.name.required'  => 'Milestone name is required.',
            'milestones.*.name.max'       => 'Milestone name may not exceed 255 characters.',

            'milestones.*.planned_due_date.after_or_equal' =>
                'Milestone planned due date must be after or equal to start date.',

            'milestones.*.categories.required' => 'Each milestone must have at least one category.',
            'milestones.*.categories.min'      => 'Each milestone must have at least one category.',

            'milestones.*.categories.*.ss_milestone_category_id.required' =>
                'Milestone category ID is required.',
            'milestones.*.categories.*.ss_milestone_category_id.exists' =>
                'Selected milestone category does not exist.',

            'milestones.*.categories.*.study_category_name.required' =>
                'Study category name is required.',

            'milestones.*.categories.*.tasks.required' =>
                'Each category must have at least one task.',
            'milestones.*.categories.*.tasks.min' =>
                'Each category must have at least one task.',

            'milestones.*.categories.*.tasks.*.ss_milestone_category_tasks_id.required' =>
                'Task template ID is required.',
            'milestones.*.categories.*.tasks.*.ss_milestone_category_tasks_id.exists' =>
                'Selected task template does not exist.',

            'milestones.*.categories.*.tasks.*.name.required' =>
                'Task name is required.',

            'milestones.*.categories.*.tasks.*.planned_due_date.after_or_equal' =>
                'Task planned due date must be after or equal to planned start date.',

            'milestones.*.categories.*.tasks.*.study_setup_type.in' =>
                'Study setup type must be external or internal.',

            'milestones.*.categories.*.tasks.*.completion_type.in' =>
                'Completion type must be MANUAL or AUTO.',
        ];
    }
}