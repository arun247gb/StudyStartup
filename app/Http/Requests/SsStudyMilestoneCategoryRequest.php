<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsStudyMilestoneCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_study_id'               => 'required|exists:ss_studies,id',
            'ss_organisation_id'        => 'nullable|exists:ss_organizations,id',
            'ss_study_milestones_id'    => 'required|exists:ss_study_milestones,id',
            'ss_milestone_category_id'  => 'nullable|exists:ss_milestone_categories,id',

            'study_category_name'       => 'required|string|max:255',
            'description'               => 'nullable|string',

            'order'                     => 'nullable|integer',
            'is_active'                 => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_study_id.required'            => 'Study ID is required.',
            'ss_study_id.exists'              => 'The selected study does not exist.',

            'ss_organisation_id.exists'       => 'The selected organization does not exist.',

            'ss_study_milestones_id.required' => 'Study milestone ID is required.',
            'ss_study_milestones_id.exists'   => 'The selected study milestone does not exist.',

            'ss_milestone_category_id.exists' => 'The selected master milestone category does not exist.',

            'study_category_name.required'    => 'Study category name is required.',
            'study_category_name.string'      => 'Study category name must be a string.',
            'study_category_name.max'         => 'Study category name may not exceed 255 characters.',

            'description.string'              => 'Description must be a valid string.',

            'order.integer'                   => 'Order must be an integer value.',

            'is_active.boolean'               => 'Is active must be true or false.',
        ];
    }
}
