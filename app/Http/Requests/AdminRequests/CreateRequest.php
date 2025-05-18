<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to `true` to allow all users to make this request.
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:admin,supervisor',
            //'link_password_protection' => 'required_if:link_password_status,1|string|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['email'] = 'required|string|email|max:255|unique:admins,email,'.$this->route('admin');
            $rules['password'] = 'nullable|string|min:8|confirmed'; // Password is optional for update
        }

        return $rules;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The type must be either admin or supervisor.',
        ];
    }
}
