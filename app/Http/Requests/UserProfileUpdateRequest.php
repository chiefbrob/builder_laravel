<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'phone_number' => 'required|numeric',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,jpg|max:2048',
            'team_id' => ['sometimes', 'nullable', 'integer', 'exists:teams,id']
        ];
    }
}
