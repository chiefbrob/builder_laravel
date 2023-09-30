<?php

namespace App\Http\Requests\v2\Auth;

use Illuminate\Foundation\Http\FormRequest;

class V2LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6']
        ];
    }
}
