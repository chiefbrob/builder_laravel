<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|email|unique:teams,email',
            'description' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);

    }
}
