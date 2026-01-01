<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsMilestoneCategoryTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_milestone_categories_id' => 'required|exists:ss_milestone_categories,id',
            'name'                       => 'required|string|max:255',
            'study_setup_type'           => 'required|in:external,internal',
            'completion_type'            => 'nullable|in:manual,auto',
            'order'                      => 'nullable|integer',
            'is_active'                  => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_milestone_categories_id.required' => 'Milestone category is required.',
            'ss_milestone_categories_id.exists'   => 'Selected milestone category does not exist.',

            'name.required'                       => 'Task name is required.',
            'name.string'                         => 'Task name must be a valid string.',
            'name.max'                            => 'Task name must not exceed 255 characters.',

            'study_setup_type.required'           => 'Study setup type is required.',
            'study_setup_type.in'                 => 'Study setup type must be either external or internal.',

            'completion_type.in'                  => 'Completion type must be either manual or auto.',

            'order.integer'                       => 'Order must be a valid integer.',

            'is_active.boolean'                   => 'Active status must be true or false.',
        ];
    }
}
