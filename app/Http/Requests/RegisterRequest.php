<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // 'ss_organization_id' => "sometimes|exists:ss_organizations,id",
            // 'ss_department_id' => "sometimes|exists:ss_departments,id",
            'email' => 'required|email|unique:ss_users,email',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
