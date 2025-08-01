<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // use policies in controller instead
    }

    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'POST') {
            return [
                'content' => 'required|string|max:1000',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ];
        }

        if ($method === 'PUT' || $method === 'PATCH') {
            return [
                'content' => 'required|string|max:1000',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Please enter some content.',
            'content.max' => 'Content cannot exceed 1000 characters.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Allowed image types: jpeg, jpg, png, gif, svg.',
            'image.max' => 'Image size must not exceed 2MB.',
        ];
    }
}
