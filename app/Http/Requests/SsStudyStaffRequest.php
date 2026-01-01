<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsStudyStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_study_id' => 'required|exists:ss_studies,id',
            'ss_user_id' => 'required|exists:ss_users,id',
            'name' => 'required|string|max:255',
            'enum_staff_type_id' => 'required|integer',
            'description' => 'nullable|string',
            'ss_organizations_id' => 'nullable|exists:ss_organizations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_study_id.required' => 'Study ID is required.',
            'ss_study_id.exists'   => 'The selected study does not exist.',

            'ss_user_id.required'  => 'User ID is required.',
            'ss_user_id.exists'    => 'The selected user does not exist.',

            'name.required'        => 'Staff name is required.',
            'name.string'          => 'Staff name must be a valid string.',
            'name.max'             => 'Staff name must not exceed 255 characters.',

            'enum_staff_type_id.required' => 'Staff type is required.',
            'enum_staff_type_id.integer'  => 'Staff type must be a valid integer.',

            'description.string'   => 'Description must be a valid string.',

            'ss_organizations_id.exists' => 'The selected organization does not exist.',
        ];
    }
}
