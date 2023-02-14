<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class GetRolesRequest extends FormRequest
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
            'role_id' => 'sometimes|nullable|integer|exists:roles,id'
        ];
    }
}
