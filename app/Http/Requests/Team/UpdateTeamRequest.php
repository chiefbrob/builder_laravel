<?php

namespace App\Http\Requests\Team;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $user = User::findOrFail(auth()->id());
        return $user->hasRole($manager);
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
            'email' => 'required|email',
            'description' => 'nullable|string',
        ];

    }
}
