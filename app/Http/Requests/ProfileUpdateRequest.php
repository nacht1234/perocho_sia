<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }
}
