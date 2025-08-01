<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules(): array
{
    return [
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|string|min:6|confirmed',
    ];
}

public function messages(): array
{
    return [
        'token.required' => 'Reset token is missing.',
        'email.required' => 'Email is required.',
        'email.email' => 'Enter a valid email.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Passwords do not match.',
    ];
}

}
