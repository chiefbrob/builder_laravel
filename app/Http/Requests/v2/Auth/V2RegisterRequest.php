<?php

namespace App\Http\Requests\v2\Auth;

use Illuminate\Foundation\Http\FormRequest;

class V2RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => [
                'sometimes', 
                'nullable', 
                'string', 
                'max:20', 
                'unique:users,username'
            ],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
