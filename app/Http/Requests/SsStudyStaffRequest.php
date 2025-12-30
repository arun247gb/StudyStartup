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
}
