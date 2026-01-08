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

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required.',
            'name.string'       => 'Name must be a valid string.',
            'name.max'          => 'Name must not exceed 255 characters.',

            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please provide a valid email address.',
            // 'email.unique'      => 'This email address is already registered.',

            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters long.',
            'password.confirmed'=> 'Password confirmation does not match.',
        ];
    }
}
